<?php
namespace FlitsFiets;

class SqliteDatabase {
  private $sqlite;
  private $mode;

  function __construct( $filename, $mode = SQLITE3_ASSOC ) {
    $this->mode = $mode;
    $this->sqlite = new \SQLite3($filename);
  }

  public function fetch_array( $query ) {
    $rows = array();
    if( $res = $this->query( $query ) ){
      while($row = $res->fetchArray($this->mode)){
        $rows[] = $row;
      }
    }
    return $rows;
  }

  public function fetch_rows( $table_name, $condition = 1, $column = '*', $orderby = NULL, $direction = "ASC" )
  {
    $query = "SELECT ". $column ." FROM ". $table_name ." WHERE ". $condition;
    if (isset($orderby)) {
      $query .= " ORDER BY ".$orderby." $direction";
    }
    $row = $this->fetch_array( $query );
    return $row;
  }

  public function query( $query ) {
    $res = $this->sqlite->query( $query );
    if ( !$res )
    {
      throw new \Exception( $this->sqlite->lastErrorMsg() );
    }
    return $res;
  }

  public function getDaylist() {

  }
}