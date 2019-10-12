<?php


namespace FlitsFiets\Views;


class RadarSettingsEditor extends View {

  public function __construct() {
    parent::__construct();
    $this->template = "editor.html";
    $this->addPageData(["dashurl" => $_ENV['DASHBOARD_URL']]);
  }
}
