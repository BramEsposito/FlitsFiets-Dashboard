<?php


namespace FlitsFiets\Models;


class ApiSubmission extends Model {
  private $street;
  private $lat;
  private $lon;
  private $modus; // meter per second or km per hour

  private $direction;

  private $speed;
  public $radar;

  public function __construct() {
    parent::__construct();
    $this->modus = "mps";
    $this->street = "Anselmostraat";
    $this->lat = "4.4042355";
    $this->lon = "51.2061932";
    $this->direction = 350;
  }

  /**
   * @param mixed $speed
   */
  public function setSpeed($speed) {
    $this->speed = $speed;
  }

  public function __set($property, $value) {

    if ($property == "speed" && $this->modus == "mps") {
      $this->speed = floatval($value)*3.6;
    } else if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }


  public function save() {
    if ($this->speed < 15) return("low speed");

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