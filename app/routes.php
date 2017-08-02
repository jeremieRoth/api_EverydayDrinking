<?php

use Symfony\Component\HttpFoundation\Request;

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
								'longitutde' => $establishment->getLocation()->getLongitude(),
								'latitude' => $establishment->getLocation()->getLatitude())
		);
	}
    return $app->json($responseData);
});

$app->get('/establishment/{id}', function($id, Request $request) use ($app)
{
    $establishments = $app['dao.establishment']->find($id);
	$establishments->setLocation($app['dao.location']->find($establishments->getLocation()));
	if(!isset($establishments)){
		$app->abort(404, 'establishments not exist');
	}
    $responseData = array();
		$responseData[] = array(
			'id' => $establishments->getId(),
			'name' => $establishments->getName(),
			'location' => array('id' => $establishments->getLocation()->getId(),
								'longitutde' => $establishments->getLocation()->getLongitude(),
								'latitude' => $establishments->getLocation()->getLatitude())
		);
    return $app->json($responseData) ;
});

$app->post('/establishment',function(Request $request) use ($app)
{
	$data = json_decode();
});

$app->put('/establishment/{id}',function($id, Response $response) use ($app)
{

});

$app->delete('/establishment/{id}',function($id) use ($app)
{

});


$app->get('/comments', function() use ($app)
{
    $comments = $app['dao.comment']->findAll();
    $responseData = array();
	foreach ($comments as $comment) {
		$comment->setEstablishment($app['dao.establishment']->find($comment->getEstablishment()));
		$comment->getEstablishment()->setLocation($app['dao.location']->find($comment->getEstablishment()->getLocation()));
		$responseData[] = array(
			'id' => $comment->getId(),
			'user' => $comment->getUser(),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => array('id' => $comment->getEstablishment()->getId(),
									 'name' => $comment->getEstablishment()->getName(),
									 'location' => array('id' => $comment->getEstablishment()->getLocation()->getId(),
														 'longitutde' => $comment->getEstablishment()->getLocation()->getLongitude(),
														 'latitude' => $comment->getEstablishment()->getLocation()->getLatitude()))
		);
	}
    return $app->json($responseData);
});

$app->get('/comment/{id}', function($id, Request $request) use ($app)
{
    $comment = $app['dao.comment']->find($id);
	if(!isset($comment)){
		$app->abort(404, 'comment not exist');
	}
    $responseData = array();
		$responseData[] = array(
			'id' => $comment->getId(),
			'user' => $comment->getUser(),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => $comment->getEstablishment()
		);
    return $app->json($responseData);
});

$app->post('/comment',function(Request $request) use ($app)
{
	$data = json_decode();


});

$app->put('/comment/{id}',function($id, Response $response) use ($app)
{

});

$app->delete('/comment/{id}',function($id) use ($app)
{

});

$app->get('/drinks', function() use ($app)
{
    $drinks = $app['dao.drink']->findAll();
    $responseData = array();
	foreach ($drinks as $drink) {
		$responseData[] = array(
			'id' => $drink->getId(),
			'name' => $drink->getName(),
			'price' => $drink->getPrice(),
            'establishment' => $drink->getEstablishment()
		);
	}
    return $app->json($responseData);
});

$app->get('/drink/{id}', function($id, Request $request) use ($app)
{
    $drink = $app['dao.drink']->find($id);
	if(!isset($drink)){
		$app->abort(404, 'drink not exist');
	}
    $responseData = array();
		$responseData[] = array(
			'id' => $drink->getId(),
			'name' => $drink->getName(),
			'price' => $drink->getPrice(),
            'establishment' => $drink->getEstablishment()
		);
    return $app->json($responseData);
});

$app->post('/drink',function(Request $request) use ($app)
{
	$data = json_decode();


});

$app->put('/drink/{id}',function($id, Response $response) use ($app)
{

});

$app->delete('/drink/{id}',function($id) use ($app)
{

});

$app->get('/locations', function() use ($app)
{
    $locations = $app['dao.location']->findAll();
    $responseData = array();
	foreach ($locations as $location) {
		$responseData[] = array(
			'id' => $location->getId(),
			'lontitude' => $location->getLongitude(),
			'latitude' => $location->getLatitude()
		);
	}
    return $app->json($responseData);
});

$app->get('/location/{id}', function($id, Request $request) use ($app)
{
    $location = $app['dao.location']->find($id);
	if(!isset($location)){
		$app->abort(404, 'location not exist');
	}
    $responseData = array();
		$responseData[] = array(
			'id' => $location->getId(),
			'lontitude' => $location->getLongitude(),
			'latitude' => $location->getLatitude()
		);
    return $app->json($responseData);
});

$app->post('/location',function(Request $request) use ($app)
{
	$data = json_decode();


});

$app->put('/location/{id}',function($id, Response $response) use ($app)
{

});

$app->delete('/location/{id}',function($id) use ($app)
{

});

$app->get('/users', function() use ($app)
{
    $users = $app['dao.user']->findAll();
    $responseData = array();
	foreach ($users as $user) {
		$responseData[] = array(
			'id' => $user->getId(),
			'login' => $user->getLogin(),
			'password' => $user->getPassword(),
            'username' => $user->getUserName()
		);
	}
    return $app->json($responseData);
});

$app->get('/user/{id}', function($id, Request $request) use ($app)
{
    $user = $app['dao.user']->find($id);
	if(!isset($user)){
		$app->abort(404, 'user not exist');
	}
    $responseData = array();
		$responseData[] = array(
			'id' => $user->getId(),
			'login' => $user->getLogin(),
			'password' => $user->getPassword(),
            'username' => $user->getUserName()
		);
    return $app->json($responseData);
});

$app->post('/user',function(Request $request) use ($app)
{
	$data = json_decode();


});

$app->put('/user/{id}',function($id, Response $response) use ($app)
{

});

$app->delete('/user/{id}',function($id) use ($app)
{

});