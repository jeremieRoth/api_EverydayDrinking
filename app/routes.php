<?php


// Home page
$app->get('/', function () use ($app) {
    //require '../src/model.php';
    //$articles = getArticles();

    ob_start();             // start buffering HTML output
    require '../views/home.php';
    $view = ob_get_clean(); // assign HTML output to $view
    return $view;
});

$app->get('/establishments', function() use ($app){
    $establishments = $app['dao.establishment']->findAll();
    $responseData = array();
	foreach ($establishments as $establishment) {
		$responseData[] = array(
			'id' => $establishment->getId(),
			'name' => $establishment->getName(),
			'location' => $establishment->getLocation()
		);
	}
    return $app->json($responseData);
});

$app->get('/establishment/{id}', function() use ($app){
    $establishments = $app['dao.establishment']->find($id);
	if(!isset($establishments)){
		$app->abort(404, 'establishments not exist');
	}
    $responseData = array();
	foreach ($establishments as $establishment) {
		$responseData[] = array(
			'id' => $establishment->getId(),
			'name' => $establishment->getName(),
			'location' => $establishment->getLocation()
		);
	}
    return $app->json($responseData);
});


$app->get('/comments', function() use ($app){
    $comments = $app['dao.comment']->findAll();
    $responseData = array();
	foreach ($comments as $comment) {
		$responseData[] = array(
			'id' => $comment->getId(),
			'user' => $comment->getUser(),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => $comment->getEstablishment()
		);
	}
    return $app->json($responseData);
});

$app->get('/comment/{id}', function() use ($app){
    $comments = $app['dao.comment']->findAll();
	if(!isset($comments)){
		$app->abort(404, 'comment not exist');
	}
    $responseData = array();
	foreach ($comments as $comment) {
		$responseData[] = array(
			'id' => $comment->getId(),
			'user' => $comment->getUser(),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => $comment->getEstablishment()
		);
	}
    return $app->json($responseData);
});

$app->get('/drinks', function() use ($app){
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

$app->get('/drink/{id}', function() use ($app){
    $drinks = $app['dao.drink']->findAll();
	if(!isset($drinks)){
		$app->abort(404, 'drink not exist');
	}
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

$app->get('/locations', function() use ($app){
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

$app->get('/location/{id}', function() use ($app){
    $locations = $app['dao.location']->findAll();
	if(!isset($locations)){
		$app->abort(404, 'location not exist');
	}
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

$app->get('/users', function() use ($app){
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

$app->get('/user/{id}', function() use ($app){
    $users = $app['dao.user']->findAll();
	if(!isset($users)){
		$app->abort(404, 'user not exist');
	}
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

