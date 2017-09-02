<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use everydayDrinking\BDD\Entity\Establishment;
use everydayDrinking\BDD\Entity\Drink;
use everydayDrinking\BDD\Entity\Comment;
use everydayDrinking\BDD\Entity\Location;
use everydayDrinking\BDD\Entity\User;
use everydayDrinking\BDD\Entity\Event;

// Home page
$app->get('/', function () use ($app) {
    //require '../src/model.php';
    //$articles = getArticles();

    ob_start();             // start buffering HTML output
    require '../views/home.php';
    $view = ob_get_clean(); // assign HTML output to $view
    return $view;
});

$app->get('/establishments', function() use ($app)
{
    $establishments = $app['dao.establishment']->findAll();
    $responseData = array();
	foreach ($establishments as $establishment) {
		$establishment->setLocation($app['dao.location']->find($establishment->getLocation()));
		$responseData[] = array(
			'id' => $establishment->getId(),
			'name' => $establishment->getName(),
			'location' => array('id' => $establishment->getLocation()->getId(),
								'longitude' => $establishment->getLocation()->getLongitude(),
								'latitude' => $establishment->getLocation()->getLatitude())
		);
	}
    return $app->json($responseData);
})->bind('establishments');

$app->get('/establishment/{id}', function($id, Request $request) use ($app)
{
    $establishments = $app['dao.establishment']->find($id);
	$establishments->setLocation($app['dao.location']->find($establishments->getLocation()));
	if(!isset($establishments)){
		$app->abort(404, 'establishments not exist');
	}
    $responseData = array();
		$responseData = array(
			'id' => $establishments->getId(),
			'name' => $establishments->getName(),
			'location' => array('id' => $establishments->getLocation()->getId(),
								'longitude' => $establishments->getLocation()->getLongitude(),
								'latitude' => $establishments->getLocation()->getLatitude())
		);
    return $app->json($responseData) ;
})->bind('get-establishment');

$app->post('/establishment',function(Request $request) use ($app)
{
	if (!$request->request->has('name')) {
		return $app->json('Missing parameter: name', 400);
	}
	if (!$request->request->has('location')) {
		return $app->json('Missing parameter: location', 400);
	}

	$establishment = new Establishment();
	$establishment->setName($request->request->get('name'));
	$establishment->setLocation($request->request->get('location'));
	$app['dao.establishment']->save($establishment);
	$establishment->setLocation($app['dao.location']->find($establishment->getLocation()));

	$responseData = array(
		'id' => $establishment->getId(),
		'name' => $establishment->getName(),
		'location' => array('id' => $establishment->getLocation()->getId(),
							'longitude' => $establishment->getLocation()->getLongitude(),
							'latitude' => $establishment->getLocation()->getLatitude())
	);

	return $app->json($responseData, 201);
	$data = json_decode();
})->bind('post-establishment');

$app->put('/establishment/{id}',function($id, Request $request) use ($app)
{
	$estblishment = $app['dao.establishment']->find($id);

	$estblishment->setName($request->request->get('name'));
	$estblishment->setLocation($request->request->get('location'));
	$app['dao.establishment']->save($estblishment);
	$establishment->setLocation($app['dao.location']->find($establishment->getLocation()));	

	$responseData = array(
		'id' => $estblishment->getId(),
		'name' => $estblishment->getName(),
		'location' => array('id' => $establishment->getLocation()->getId(),
							'longitude' => $establishment->getLocation()->getLongitude(),
							'latitude' => $establishment->getLocation()->getLatitude())
	);

	return $app->json($responseData, 202);

})->bind('put-establishment');

$app->delete('/establishment/{id}',function($id) use ($app)
{
	$app['dao.establishment']->delete($id);

	return $app->json('No content', 204);

})->bind('delete-establishment');


$app->get('/comments', function() use ($app)
{
    $comments = $app['dao.comment']->findAll();
    $responseData = array();
	foreach ($comments as $comment) {
		$comment->setUser($app['dao.user']->find($comment->getUser()));
		$comment->setEstablishment($app['dao.establishment']->find($comment->getEstablishment()));
		$comment->getEstablishment()->setLocation($app['dao.location']->find($comment->getEstablishment()->getLocation()));
		$responseData[] = array(
			'id' => $comment->getId(),
			'user' => array('id' => $comment->getUser()->getId(),
							'login' => $comment->getUser()->getLogin(),
							'password' => $comment->getUser()->getPassword(),
            				'username' => $comment->getUser()->getUserName()),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => array('id' => $comment->getEstablishment()->getId(),
									 'name' => $comment->getEstablishment()->getName(),
									 'location' => array('id' => $comment->getEstablishment()->getLocation()->getId(),
														 'longitude' => $comment->getEstablishment()->getLocation()->getLongitude(),
														 'latitude' => $comment->getEstablishment()->getLocation()->getLatitude()))
		);
	}
    return $app->json($responseData);
})->bind('comments');

$app->get('/comment/{id}', function($id, Request $request) use ($app)
{
    $comment = $app['dao.comment']->find($id);
	if(!isset($comment)){
		$app->abort(404, 'comment not exist');
	}
	$comment->setEstablishment($app['dao.establishment']->find($comment->getEstablishment()));
	$comment->getEstablishment()->setLocation($app['dao.location']->find($comment->getEstablishment()->getLocation()));
    $responseData = array();
		$responseData = array(
			'id' => $comment->getId(),
			'user' => $comment->getUser(),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => array('id' => $comment->getEstablishment()->getId(),
									 'name' => $comment->getEstablishment()->getName(),
									 'location' => array('id' => $comment->getEstablishment()->getLocation()->getId(),
														 'longitude' => $comment->getEstablishment()->getLocation()->getLongitude(),
														 'latitude' => $comment->getEstablishment()->getLocation()->getLatitude()))
		);
    return $app->json($responseData);
})->bind('get-comment');

/*$app->get("commentByEstablishment/{establishment_id}"), function($establishment_id, Request $request) use($app)
{


}*/

$app->post('/comment',function(Request $request) use ($app)
{
	if (!$request->request->has('user')){
		return $app->json('Missing parameter: user', 400);
	}
	if(!$request->request->has('comment')){
		return $app->json('Missing parameter: comment', 400);
	}
	if(!$request->request->has('score')){
		return $app->json('Missing parameter: score', 400);
	}
	if(!$request->request->has('establishment')){
		return $app->json('Missing parameter: establishment', 400);
	}

	$comment = new Comment();
	$comment->setUser($request->request->get('user'));
	$comment->setComment($request->request->get('comment'));
	$comment->setScore($request->request->get('score'));
	$comment->setEstablishment($request->request->get('establishment'));	
	$app['dao.comment']->save($comment);
	$comment->setEstablishment($app['dao.establishment']->find($comment->getEstablishment()));
	$comment->getEstablishment()->setLocation($app['dao.location']->find($comment->getEstablishment()->getLocation()));

	$responseData = array(
		'id' => $comment->getId(),
		'user' => array('id' => $comment->getUser()->getId(),
						'login' => $comment->getUser()->getLogin(),
						'password' => $comment->getUser()->getPassword(),
						'username' => $comment->getUser()->getUserName()),
		'comment' => $comment->getComment(),
        'score' => $comment->getScore(),
        'establishment' => array('id' => $comment->getEstablishment()->getId(),
								'name' => $comment->getEstablishment()->getName(),
								'location' => array('id' => $comment->getEstablishment()->getLocation()->getId(),
													'longitude' => $comment->getEstablishment()->getLocation()->getLongitude(),
													'latitude' => $comment->getEstablishment()->getLocation()->getLatitude())
	));

	return $app->json($responseData, 201);
	$data = json_decode();


})->bind('post-comment');

$app->put('/comment/{id}',function($id, Request $request) use ($app)
{
	$comment = $app['dao.comment']->find($id);

	$comment->setUser($request->request->get('user'));
	$comment->setComment($request->request->get('comment'));
	$comment->setScore($request->request->get('score'));
	$comment->setEstablishment($request->request->get('establishment'));
	echo $request->get('user');
	$app['dao.comment']->save($comment);

	$responseData = array(
		'id' => $comment->getId(),
		'user' => $comment->getUser(),
		'comment' => $comment->getComment(),
        'score' => $comment->getScore(),
        'establishment' => array('id' => $comment->getEstablishment()->getId(),
								'name' => $comment->getEstablishment()->getName(),
								'location' => array('id' => $comment->getEstablishment()->getLocation()->getId(),
													'longitude' => $comment->getEstablishment()->getLocation()->getLongitude(),
													'latitude' => $comment->getEstablishment()->getLocation()->getLatitude())
));

	return $app->json($responseData, 202);

})->bind('put-comment');

$app->delete('/comment/{id}',function($id) use ($app)
{
	$app['dao.comment']->delete($id);

	return $app->json('No content', 204);

})->bind('delete-comment');

$app->get('/drinks', function() use ($app)
{
    $drinks = $app['dao.drink']->findAll();
    $responseData = array();
	foreach ($drinks as $drink) {
		$drink->setEstablishment($app['dao.establishment']->find($drink->getEstablishment()));
		$drink->getEstablishment()->setLocation($app['dao.location']->find($drink->getEstablishment()->getLocation()));
		$responseData[] = array(
			'id' => $drink->getId(),
			'name' => $drink->getName(),
			'price' => $drink->getPrice(),
            'establishment' => array('id' => $drink->getEstablishment()->getId(),
									 'name' => $drink->getEstablishment()->getName(),
									 'location' => array('id' => $drink->getEstablishment()->getLocation()->getId(),
														 'longitude' => $drink->getEstablishment()->getLocation()->getLongitude(),
														 'latitude' => $drink->getEstablishment()->getLocation()->getLatitude()))
		);
	}
    return $app->json($responseData,202);
})->bind('drinks');

$app->get('/drink/{id}', function($id, Request $request) use ($app)
{
    $drink = $app['dao.drink']->find($id);
	if(!isset($drink)){
		$app->abort(404, 'drink not exist');
	}
	$drink->setEstablishment($app['dao.establishment']->find($drink->getEstablishment()));
	$drink->getEstablishment()->setLocation($app['dao.location']->find($drink->getEstablishment()->getLocation()));
    $responseData = array();
		$responseData = array(
			'id' => $drink->getId(),
			'name' => $drink->getName(),
			'price' => $drink->getPrice(),
            'establishment' => array('id' => $drink->getEstablishment()->getId(),
									 'name' => $drink->getEstablishment()->getName(),
									 'location' => array('id' => $drink->getEstablishment()->getLocation()->getId(),
														 'longitude' => $drink->getEstablishment()->getLocation()->getLongitude(),
														 'latitude' => $drink->getEstablishment()->getLocation()->getLatitude()))
		);
    return $app->json($responseData);
})->bind('get-drink');

$app->post('/drink',function(Request $request) use ($app)
{
	if (!$request->request->has('name')){
		return $app->json('Missing parameter: name', 400);
	}
	if(!$request->request->has('price')){
		return $app->json('Missing parameter: price', 400);
	}
	if(!$request->request->has('establishment')){
		return $app->json('Missing parameter: establishment', 400);
	}

	$drink = new Drink();
	$drink->setName($request->request->get('name'));
	$drink->setPrice($request->request->get('name'));
	$drink->setEstablishment($request->request->get('establishment'));
	$app['dao.drink']->save($drink);
	$drink->setEstablishment($app['dao.establishment']->find($drink->getEstablishment()));
	$drink->getEstablishment()->setLocation($app['dao.location']->find($drink->getEstablishment()->getLocation()));

	$responseData = array(
		'id' => $drink->getId(),
		'name' => $drink->getName(),
		'price' => $drink->getPrice(),
        'establishment' => array('id' => $drink->getEstablishment()->getId(),
								'name' => $drink->getEstablishment()->getName(),
								'location' => array('id' => $drink->getEstablishment()->getLocation()->getId(),
													'longitude' => $drink->getEstablishment()->getLocation()->getLongitude(),
													'latitude' => $drink->getEstablishment()->getLocation()->getLatitude()))
	);
	return $app->json($responseData, 201);
	$data = json_decode();


})->bind('post-drink');

$app->put('/drink/{id}',function($id, Request $request) use ($app)
{

	$drink = $app['dao.drink']->find($id);

	$drink->setName($request->request->get('name'));
	$drink->setPrice($request->request->get('price'));
	$drink->setEstablishment($request->request->get('establishment'));
	$app['dao.drink']->save($drink);
	$drink->setEstablishment($app['dao.establishment']->find($drink->getEstablishment()));
	$drink->getEstablishment()->setLocation($app['dao.location']->find($drink->getEstablishment()->getLocation()));

	$responseData = array(
		'id' => $drink->getId(),
		'name' => $drink->getName(),
		'price' => $drink->getPrice(),
        'establishment' => array('id' => $drink->getEstablishment()->getId(),
								 'name' => $drink->getEstablishment()->getName(),
								 'location' => array('id' => $drink->getEstablishment()->getLocation()->getId(),
													 'longitude' => $drink->getEstablishment()->getLocation()->getLongitude(),
													 'latitude' => $drink->getEstablishment()->getLocation()->getLatitude()))
);

	return $app->json($responseData, 202);


})->bind('put-drink');

$app->delete('/drink/{id}',function($id) use ($app)
{
	$app['dao.drink']->delete($id);

	return $app->json('No content', 204);

})->bind('delete-drink');

$app->get('/locations', function() use ($app)
{
    $locations = $app['dao.location']->findAll();
    $responseData = array();
	foreach ($locations as $location) {
		$responseData[] = array(
			'id' => $location->getId(),
			'longitude' => $location->getLongitude(),
			'latitude' => $location->getLatitude()
		);
	}
    return $app->json($responseData);
})->bind('locations');

$app->get('/location/{id}', function($id, Request $request) use ($app)
{
    $location = $app['dao.location']->find($id);
	if(!isset($location)){
		$app->abort(404, 'location not exist');
	}
    $responseData = array();
		$responseData = array(
			'id' => $location->getId(),
			'longitude' => $location->getLongitude(),
			'latitude' => $location->getLatitude()
		);
    return $app->json($responseData);
})->bind('get-location');

$app->post('/location',function(Request $request) use ($app)
{
	if (!$request->request->has('longitude')) {
		return $app->json('Missing parameter: location', 400);
	}
	if(!$request->request->has('latitude')){
		return $app->json('Missing parameter: location', 400);
	}

	$location = new Location();
	$location->setLongitude($request->request->get('longitude'));
	$location->setLatitude($request->request->get('latitude'));
	$app['dao.location']->save($location);

	$responseData = array(
		'id' => $location->getId(),
		'longitude' => $location->getLongitude(),
		'latitude' => $location->getLatitude()
	);

	return $app->json($responseData, 201);
	$data = json_decode();


})->bind('post-location');

$app->put('/location/{id}',function($id, Request $request) use ($app)
{
	$location = $app['dao.location']->find($id);

	$location->setLongitude($request->request->get('longitude'));
	$location->setLatitude($request->request->get('latitude'));
	$app['dao.location']->save($location);

	$responseData = array(
		'id' => $location->getId(),
		'longitude' => $location->getLongitude(),
		'latitude' => $location->getLatitude()
	);

	return $app->json($responseData, 202);

})->bind('put-location');

$app->delete('/location/{id}',function($id) use ($app)
{
	$app['dao.location']->delete($id);

	return $app->json('No content', 204);

})->bind('delete-location');

$app->get('/users', function() use ($app)
{
	$responseData = array();
    $users = $app['dao.user']->findAll();
	foreach ($users as $user) {
		$responseData[] = array(
			'id' => $user->getId(),
			'login' => $user->getLogin(),
			'password' => $user->getPassword(),
            'username' => $user->getUserName()
		);
	}
    return $app->json($responseData);
})->bind('users');

$app->get('/user/{id}', function($id, Request $request) use ($app)
{
    $user = $app['dao.user']->find($id);
	if(!isset($user)){
		$app->abort(404, 'user not exist');
	}
    
	$responseData = array(
		'id' => $user->getId(),
		'login' => $user->getLogin(),
		'password' => $user->getPassword(),
        'username' => $user->getUserName()
	);
    return $app->json($responseData);
})->bind('get-user');

$app->get('/user/{login}/{password}', function($login, $password, Request $request) use ($app)
{
    $user = $app['dao.user']->findByNameAndPassword($login, $password);
	if(!isset($user)){
		$app->abort(404, 'user not exist');
	}
    
	$responseData = array(
		'id' => $user->getId(),
		'login' => $user->getLogin(),
		'password' => $user->getPassword(),
        'username' => $user->getUserName()
	);
    return $app->json($responseData);
})->bind('get-user-by-login');



$app->post('/user',function(Request $request) use ($app)
{
	if (!$request->request->has('login')) {
		return $app->json('Missing parameter: login', 400);
	}
	if(!$request->request->has('password')){
		return $app->json('Missing parameter: password', 400);
	}
	if(!$request->request->has('user_name')){
		return $app->json('Missing parameter: user_name', 400);
	}

	$user = new User();
	$user->setLogin($request->request->get('login'));
	$user->setPassword($request->request->get('password'));
	$user->setUserName($request->request->get('user_name'));
	$app['dao.user']->save($user);

	$responseData = array(
		'id' => $user->getId(),
		'login' => $user->getLogin(),
		'password' => $user->getPassword(),
        'username' => $user->getUserName()
	);

	return $app->json($responseData, 201);
	$data = json_decode();


})->bind('post-user');

$app->put('/user/{id}',function($id, Request $request) use ($app)
{
	$user = $app['dao.user']->find($id);
	$user->setLogin($request->request->get('login'));
	$user->setPassword($request->request->get('password'));
	$user->setUserName($request->request->get('user_name'));
	$app['dao.user']->save($user);

	$responseData = array(
		'id' => $user->getId(),
		'login' => $user->getLogin(),
		'password' => $user->getPassword(),
        'username' => $user->getUserName()
	);

	return $app->json($responseData, 202);
	

})->bind('put-user');

$app->delete('/user/{id}',function($id) use ($app)
{
	$app['dao.user']->delete($id);

	return $app->json('No content', 204);

})->bind('delete-user');

$app->get('/events', function() use ($app)
{
	$responseData = array();
    $events = $app['dao.event']->findAll();
	foreach ($events as $event) {
		$event->setEstablishment($app['dao.establishment']->find($event->getEstablishment()));
		$event->getEstablishment()->setLocation($app['dao.location']->find($event->getEstablishment()->getLocation()));
		$responseData[] = array(
			'id' => $event->getId(),
			'name' => $event->getName(),
			'establishment' => array('id' => $event->getEstablishment()->getId(),
									'name' => $event->getEstablishment()->getName(),
									'location' => array('id' => $event->getEstablishment()->getLocation()->getId(),
														'longitude' => $event->getEstablishment()->getLocation()->getLongitude(),
														'latitude' => $event->getEstablishment()->getLocation()->getLatitude()))
		);
	}
    return $app->json($responseData);
})->bind('events');

$app->get('/event/{id}', function($id, Request $request) use ($app)
{
	$event = $app['dao.event']->find($id);
	$event->setEstablishment($app['dao.establishment']->find($event->getEstablishment()));
	$event->getEstablishment()->setLocation($app['dao.location']->find($event->getEstablishment()->getLocation()));
	if(!isset($event)){
		$app->abort(404, 'event not exist');
	}
    
	$responseData = array(
		'id' => $event->getId(),
		'name' => $event->getName(),
		'establishment' => array('id' => $event->getEstablishment()->getId(),
								'name' => $event->getEstablishment()->getName(),
								'location' => array('id' => $event->getEstablishment()->getLocation()->getId(),
													'longitude' => $event->getEstablishment()->getLocation()->getLongitude(),
													'latitude' => $event->getEstablishment()->getLocation()->getLatitude()))
	);
    return $app->json($responseData);
})->bind('get-event');

$app->post('/event',function(Request $request) use ($app)
{
	if (!$request->request->has('name')) {
		return $app->json('Missing parameter: name', 400);
	}
	if(!$request->request->has('establishment')){
		return $app->json('Missing parameter: establishment', 400);
	}

	$event = new Event();
	$event->setName($request->request->get('name'));
	$event->setEstablishment($request->request->get('establishment'));
	$app['dao.event']->save($event);
	$event->setEstablishment($app['dao.establishment']->find($event->getEstablishment()));
	$event->getEstablishment()->setLocation($app['dao.location']->find($event->getEstablishment()->getLocation()));

	$responseData = array(
		'id' => $event->getId(),
		'name' => $event->getName(),
		'establishment' => array('id' => $event->getEstablishment()->getId(),
								'name' => $event->getEstablishment()->getName(),
								'location' => array('id' => $event->getEstablishment()->getLocation()->getId(),
													'longitude' => $event->getEstablishment()->getLocation()->getLongitude(),
													'latitude' => $event->getEstablishment()->getLocation()->getLatitude()))
);
	return $app->json($responseData, 202);

})->bind('post-event');

$app->put('/event/{id}',function($id, Request $request) use ($app)
{
	$event = $app['dao.event']->find($id);
	$event->setName($request->request->get('name'));
	$event->setEstablishment($request->request->get('establishment'));
	$app['dao.event']->save($event);
	$event->setEstablishment($app['dao.establishment']->find($event->getEstablishment()));
	$event->getEstablishment()->setLocation($app['dao.location']->find($event->getEstablishment()->getLocation()));

	$responseData = array(
		'id' => $event->getId(),
		'name' => $event->getName(),
		'establishment' => array('id' => $event->getEstablishment()->getId(),
								 'name' => $event->getEstablishment()->getName(),
								 'location' => array('id' => $event->getEstablishment()->getLocation()->getId(),
													 'longitude' => $event->getEstablishment()->getLocation()->getLongitude(),
													 'latitude' => $event->getEstablishment()->getLocation()->getLatitude()))
	);

	return $app->json($responseData, 202);
	

})->bind('put-event');

$app->delete('/event/{id}',function($id) use ($app)
{
	$app['dao.event']->delete($id);

	return $app->json('No content', 204);

})->bind('delete-event');

