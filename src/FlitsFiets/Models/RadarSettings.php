<?php


namespace FlitsFiets\Models;


class RadarSettings {
  private $data;
  private $settingsfile;

  public function __construct() {
    $this->settingsfile = APP_ROOT."/settings.json";
    $string = file_get_contents($this->settingsfile);
    $this->data = json_decode($string, true);
  }

  public function loadRadarSettings() {
    return $this->data;
  }

  public function save($data){
      file_put_contents($this->settingsfile, $data);
  }
}
