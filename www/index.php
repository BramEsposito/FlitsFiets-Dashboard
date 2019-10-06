<?php 
// use composer
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('FlitsFiets\\', __DIR__.'/../src/');

use FlitsFiets\App;
use FlitsFiets\RegexRouter;
use FlitsFiets\Controllers\ReportController;
use FlitsFiets\Controllers\ApiController;

try {
  $app = new App();
  $app->init();
  $app->auth();

  $router = new RegexRouter();

  $router->route("/\\".$_ENV['DASHBOARD_URL'].'\/(.*)\//', function($date) use ($app){
    // date in request url
    $c = new ReportController($date);
    $app->view($c->render());
  });

  $router->route("/\\".$_ENV['DASHBOARD_URL'].'\//', function() use ($app){
    // day in $_GET
    $c = new ReportController();
    $app->view($c->render());
  });

  $router->route($_ENV['API_URL'].'/', function() use ($app){
    $c = new ApiController();
    $c->addSubmission();
  });

  $router->route('/terms/', function() use ($app){
    $app->view("<h1>TODO</h1>");
  });

  $router->route('/privacy/', function() use ($app){
    $app->view("<h1>TODO</h1>");
  });

  $router->execute($_SERVER['REQUEST_URI']);

  $app->sendResponse("html");

} catch (Throwable $e) {
    ob_end_clean();

    $response = array(
      'error' => array(
        'msg' => $e->getMessage(),
        'code' => $e->getCode(),
      )
    );

    if (isset($app)) {
      $r = $app->getResponse();
      if ($r) $response['app'] = $r;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
