<?php
namespace FlitsFiets;

class SqliteDatabase {
  private $sqlite;
  private $mode;

  function __construct( $filename, $mode = SQLITE3_ASSOC ) {
    $this->mode = $mode;
    $this->sqlite = new \SQLite3($filename);
  }

  public function insert( $table_name, $in_data = array() )
  {
    if( !empty( $in_data ) && !empty( $table_name ) )
    {
      $cols = $vals = '';

      foreach( $in_data AS $key => $val )
      {
        $cols .= $key .", ";
        $vals .= "'". $val ."', ";
      }

      $query = "INSERT INTO ". $table_name ."(". trim( $cols, ', ') .") VALUES(". trim( $vals, ', ' ) .") ";
      return $this->query( $query );
    }
    else
    {
      return FALSE;
    }
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
    print($query."\n");
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