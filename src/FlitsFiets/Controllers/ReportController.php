<?php
namespace FlitsFiets\Controllers;

use FlitsFiets\Models\ReportModel;
use FlitsFiets\Views\ReportView;

class ReportController {
  private $m; # model
  private $v; # view
  public $time; # date in $_GET

  public function __construct($date = null) {
    if (!isset($date)) {
      $date = $_REQUEST['day'];
    }

    if (isset($date)) {
      $this->time = strtotime($date);
    } else {
      $this->time = time();
    }
    $this->m = new ReportModel();
    $this->v = new ReportView();
  }

  public function getIntervalData() {
    return $this->m->getIntervalData($this->time);
  }

  public function getReport() {
    return $this->m->getReport($this->time);
  }

  public function render() {
    return $this->v->render($this->getReport(),$this->getIntervalData(), $this->time);
  }
}
