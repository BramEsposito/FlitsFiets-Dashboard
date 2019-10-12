<?php 
// use composer
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('FlitsFiets\\', __DIR__.'/../src/');

use FlitsFiets\App;
use FlitsFiets\RegexRouter;
use FlitsFiets\Controllers\ReportController;
use FlitsFiets\Controllers\ApiController;
use FlitsFiets\Controllers\SettingsController;

try {
  $app = new App();
  $app->init();

  $router = new RegexRouter();

  $router->route("/\\".$_ENV['DASHBOARD_URL'].'\/(.*)\//', function($date) use ($app){
    $app->auth();
    // date in request url
    $c = new ReportController($date);
    $app->view($c->render());
    $app->sendResponse("html");
  });

  $router->route("/\\".$_ENV['DASHBOARD_URL'].'/', function() use ($app){
    $app->auth();
    // day in $_GET
    $c = new ReportController();
    $app->view($c->render());
    $app->sendResponse("html");
  });

  $router->route($_ENV['API_URL'].'/', function() use ($app){
    $c = new ApiController();
    $c->addSubmission();
    $app->sendResponse("json");
  });

  $router->route('/edit/', function() use ($app){

    $c = new SettingsController();
    $app->view($c->render());
      $app->sendResponse("html");
  });

  $router->route('/terms/', function() use ($app){
    $app->view("<h1>TODO</h1>");
  });

  $router->route('/privacy/', function() use ($app){
    $app->view("<h1>TODO</h1>");
  });

  $router->route('//', function() use ($app){
      switch($_SERVER['REQUEST_METHOD']) {
          case "GET":
              // todo: implement homepage
              break;
          case "POST":
              // handle form submits
              switch($_POST['op']) {
                  case "savesettings":
                      $c = new SettingsController();
                      $c->save($_POST['settings']);
                      $app->flash("Settings updated");
                      $app->handleRedirect();
                      break;
              }
              break;
      }
  });

  $router->execute($_SERVER['REQUEST_URI']);

} catch (Throwable $e) {
    ob_end_clean();

    $response = array(
      'error' => array(
        'msg' => $e->getMessage(),
        'code' => $e->getCode(),
        'trace' => $e->getTrace()
      )
    );

    if (isset($app)) {
      $r = $app->getResponse();
      if ($r) $response['app'] = $r;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
