<?php 

	require_once __DIR__.'/../vendor/autoload.php';

	use Silex\Application;
	use Silex\Provider\SessionServiceProvider;

	const DB_HOST = 'localhost';
	const DB_DATABASE = 'map';


	$app = new Application();

	$app->register(new SessionServiceProvider());

	$app['debug'] = true;

	$app['database.config'] = [
	        'dsn'      => 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
	        'username' => 'root',
	        'password' => '',
	        'options'  => [
	                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // flux en utf8
	                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // mysql erreurs remontées sous forme d'exception
	                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // tous les fetch en objets
	        ]
	  
	];

	$app['pdo'] = function( $app ){
		$options = $app['database.config'];

		return new \PDO($options['dsn'],$options['username'],$options['password'],$options['options']);
	};

	$app->register(new Silex\Provider\TwigServiceProvider(), array(
	    'twig.path' => __DIR__.'/../views',
	));

	$app->get('/', function() use($app) {

		$prepare = $app['pdo']->prepare('SELECT * from default_settings');

	  	$prepare->execute();
	  
	    $data = $prepare->fetchAll();

		$settings = 'Default settings';

		$app['session']->getFlashBag()->add('message', 'Super cool');
	    
	    return $app['twig']->render('Front/home.twig',['map'=>$settings,'data'=>$data]);
	});

	$app->get('/single/{id}', function($id) use($app) {

		$prepare = $app['pdo']->prepare('SELECT * from default_settings WHERE id='.$id);

	  	$prepare->execute();
	  
	    $data = $prepare->fetchAll();

	    return $app['twig']->render('Front/single.twig',['setting'=>$data[0]]);
	});

	$app->get('/hello/{name}', function($name) use($app) {
	    return 'Hello '.$app->escape($name);
	});

	$app->run();