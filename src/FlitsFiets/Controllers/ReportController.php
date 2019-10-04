<?php
namespace FlitsFiets\Controllers;

use FlitsFiets\Models\ReportModel;

class ReportController {
  private $m; # model

  public function __construct() {
    $this->m = new ReportModel();
  }

  public function getIntervalData() {
    return $this->m->getIntervalData();
  }

  public function getReport() {
    return "report";
  }
}
