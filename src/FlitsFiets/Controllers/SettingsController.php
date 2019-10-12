<?php


namespace FlitsFiets\Controllers;


use FlitsFiets\Models\RadarSettings;
use FlitsFiets\Views\RadarSettingsEditor;

class SettingsController extends Controller {

  public function __construct() {

    $this->m = new RadarSettings();
    $this->v = new RadarSettingsEditor();
    $this->v->addPageData(["radarsettings" => json_encode($this->m->loadRadarSettings())]);
  }

  public function save ($data) {
      $this->m->save($data);
  }

}