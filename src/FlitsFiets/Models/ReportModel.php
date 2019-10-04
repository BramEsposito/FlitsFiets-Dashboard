<?php

namespace FlitsFiets\Models;

use FlitsFiets\SqliteDatabase;

class ReportModel {

  private $db; #database connection

  public function __construct() {
    $this->db = new SqliteDatabase(APP_ROOT."/".$_ENV['DB_FILE']);
  }

  public function getIntervalData() {
    $datePart = "date('now')";
    return [
      $this->db->fetch_array("SELECT count() as 'nbr' FROM speed WHERE speed < 30 and date(datetime(Time,'localtime')) = " . $datePart),
      $this->db->fetch_array("SELECT count() as 'nbr' FROM speed WHERE speed > 30 and speed <= 40 and date(datetime(Time,'localtime')) = " . $datePart),
      $this->db->fetch_array("SELECT count() as 'nbr' FROM speed WHERE speed > 40 and speed <= 50 and date(datetime(Time,'localtime')) = " . $datePart),
      $this->db->fetch_array("SELECT count() as 'nbr' FROM speed WHERE speed > 50 and speed <= 70 and date(datetime(Time,'localtime')) = " . $datePart),
      $this->db->fetch_array("SELECT count() as 'nbr' FROM speed WHERE speed > 70 and date(datetime(Time,'localtime')) = " . $datePart),
    ];

  }
}
