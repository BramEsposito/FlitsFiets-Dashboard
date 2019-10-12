<?php


namespace FlitsFiets\Models;


class RadarSettings {
  private $data;
  private $settingsfile;

  public function __construct() {
    $this->settingsfile = APP_ROOT."/settings.json";
    $this->data = ["radarsettings" => file_get_contents($this->settingsfile)];
  }

  public function loadRadarSettings() {
    return $this->data;
  }

  public function save($data){
      file_put_contents($this->settingsfile, $data);
  }
}
