<?php


namespace FlitsFiets\Models;


class ApiSubmission extends Model {
  private $street;
  private $lat;
  private $lon;

  private $direction;

  public $speed;
  public $radar;

  public function __construct() {
    parent::__construct();
    $this->street = "Appelstraat";
    $this->lat = "4.440665";
    $this->lon = "51.212986";
    $this->direction = 205;
  }

  public function save() {

    $data = array(
      "SPEED"     => $this->speed,
      "STREET"    => $this->street,
      "DIRECTION" => $this->direction,
      "LON"       => $this->lon,
      "LAT"       => $this->lat,
      "RADAR"     => $this->radar
    );

    $this->db->insert("speed",$data);
  }


}