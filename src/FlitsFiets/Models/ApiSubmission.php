<?php


namespace FlitsFiets\Models;


class ApiSubmission extends Model {
  private $street;
  private $lat;
  private $lon;
  private $modus; // meter per second or km per hour

  private $direction;

  private $speed;
  private $radars;
  private $deviceid;

  public function __construct($settings) {
    parent::__construct();

    foreach ($settings as $radar) {
        $this->radars[$radar['deviceid']] = $radar;
    }
  }

  public function loadRadarByDeviceId($deviceid) {
    if (!array_key_exists($deviceid,$this->radars)) {
       throw new Exception("Unknown radar deviceid ".$deviceid.". Please update your configuration."); 
    }
    $this->deviceid = $deviceid;
    $radar = $this->radars[$this->deviceid];
    $this->modus = $radar['modus'];
    $this->street = $radar['street'];
    $this->lat = $radar['lat'];
    $this->lon = $radar['lon'];
    $this->direction = $radar['direction'];
  }

  public function __set($property, $value) {

    if ($property == "speed" && $this->modus == "mps") {
      $this->speed = floatval($value)*3.6;
    } else if ($property == "deviceid") {
      throw new Exception("Set the device Id with loadRadarByDeviceId."); 
    } else if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }

  public function save() {
    if ($this->speed < 15) return("low speed");

    if(array_key_exists($this->deviceid, $this->radars)) {
        $radar = $this->radars[$this->deviceid];
        $radar['speed'] = $this->speed;
        $this->startSave($radar);
        return ("Saved entry to database");
    } else {
        print_r($this->radars);
        return ("DeviceId not found in radar config.");
    }
  }

  private function startSave($radar) {
      // TODO: add name of radar to db
      // TODO: reference a location?
      $data = array(
          "SPEED"     => $radar['speed'],
          "STREET"    => $radar['street'],
          "DIRECTION" => $radar['direction'],
          "LON"       => $radar['lon'],
          "LAT"       => $radar['lat'],
          "RADARNAME" => $radar['name'],
          "RADAR"     => $radar['deviceid']
      );

      $this->db->insert("speed",$data);
  }
}
