<?php 
// use composer
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('FlitsFiets\\', __DIR__.'/../src/');

use FlitsFiets\App;
use FlitsFiets\RegexRouter;
use FlitsFiets\Views\ReportView;

try {
  $app = new App();
  $app->init();
  $app->auth();

  $router = new RegexRouter();

  $router->route("/\\".$_ENV['DASHBOARD_URL'].'\/(.*)\//', function($date) use ($app){
    $v = new ReportView($date);
    $app->view($v->render());
  });

  $router->route($_ENV['API_URL'].'/', function() use ($app){

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
