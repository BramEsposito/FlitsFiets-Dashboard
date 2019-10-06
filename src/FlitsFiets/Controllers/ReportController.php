<?php
namespace FlitsFiets\Controllers;

use FlitsFiets\Models\ReportModel;

class ReportController {
  private $m; # model
  public $time; # date in $_GET

  public function __construct($date) {
    if (!isset($date)) {
      $date = $_REQUEST['day'];
    }

    if (isset($date)) {
      $this->time = strtotime($date);
    } else {
      $this->time = time();
    }
    $this->m = new ReportModel();
  }

  public function getIntervalData() {
    return $this->m->getIntervalData($this->time);
  }

  public function getReport() {
    return "report";
  }
}
