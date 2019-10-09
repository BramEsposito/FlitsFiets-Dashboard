<?php
namespace FlitsFiets\Controllers;

use FlitsFiets\Models\ApiSubmission;

class ApiController {

  private $m; // model

  public function __construct() {
    $this->m = new ApiSubmission();
  }

  public function addSubmission(){

    $speed = floatval($_REQUEST['data']);

    $this->m->speed = $speed;
    $this->m->radar = $_REQUEST['coreid'];

    $this->m->save();
  }
}
