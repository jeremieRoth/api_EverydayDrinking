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

$app->get('/comments', function() use ($app){
    $establishments = $app['dao.comment']->findAll();
    $responseData = array();
	foreach ($comments as $comment) {
		$responseData[] = array(
			'id' => $comment->getId(),
			'name' => $comment->getName(),
			'comment' => $comment->getComment(),
            'score' => $comment->getScore(),
            'establishment' => $comment->getEstablishment()
		);
	}
    return $app->json($responseData);
});