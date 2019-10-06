<?php


namespace FlitsFiets\Models;

use FlitsFiets\SqliteDatabase;

class Model {

  public $db; #database connection

  public function __construct() {
    $this->db = new SqliteDatabase(APP_ROOT."/".$_ENV['DB_FILE']);
  }
}