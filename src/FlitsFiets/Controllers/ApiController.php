<?php
namespace FlitsFiets\Controllers;

use FlitsFiets\Models\ApiSubmission;
use FlitsFiets\Models\RadarSettings;
use FlitsFiets\Views\View;

class ApiController extends Controller {

  protected $m; // model
  private $settings; // model

  public function __construct() {
      $this->v = new View();
      $this->settings = new RadarSettings();
      $this->m = new ApiSubmission($this->settings->loadRadarSettings());
  }

  public function addSubmission(){

    $speed = floatval($_REQUEST['data']);

    $this->m->speed = $speed;
    $this->m->deviceid = $_REQUEST['coreid'];

    $this->m->save();
  }
}
