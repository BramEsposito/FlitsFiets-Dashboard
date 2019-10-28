<?php

namespace FlitsFiets\Views;

use FlitsFiets\Controllers\ReportController;

class ReportView {

  private $twig; // twig object

  public function __construct() {
    $loader = new \Twig\Loader\FilesystemLoader(APP_ROOT.'/templates');
    $twigoptions = [
      "cache" => $this->getCachingState(),
      'debug' => true
    ];
    $this->twig = new \Twig\Environment($loader, $twigoptions);
  }

  public function getCachingState() {
    if ($_ENV['APP_ENV'] == 'production') {
       APP_ROOT.'/cache/templates/compilation_cache';
    } else {
      return false;
    }
  }

  public function parseReport($r) {

    array_walk($r, function(&$item, $key) {
      $speed = round(floatval($item['SPEED']), 2);
      $time = strtotime($item['TIME']);
      $datetime = new \DateTime();
      $datetime->setTimestamp($time);
      $datetime->setTimezone(new \DateTimeZone("Europe/Brussels"));

      switch (true) {
        case $speed > 30:
          $color = "orange";
          break;
        case $speed > 50:
          $color = "red";
          break;
        default:
          $color = "green";
          break;
      }

      $item = [
        'SPEED' => $speed,
        'RADARNAME' => $item['RADARNAME'],
        'TIME' => $time,
        'FORMATTEDTIME' => $datetime->format("H:i:s"),
        'DATE' => $datetime->format("d/m/Y"),
        'COLOR' => $color,
        'STREET' => $item['STREET'],
        'DIRECTION' => $item['DIRECTION'],
        'LON' => $item['LON'],
        'LAT' => $item['LAT'],
        'RADAR' => $item['RADAR']
      ];
    });

    return $r;
  }

  public function render($report, $intervals, $time) {
    // https://twig.symfony.com/doc/2.x/api.html
    $rows = $this->parseReport($report);
    $plotly = "";
    $day = date("Y-m-d",$time);


    // TODO: print graph X values
    // TODO: use json_encode
    $plotly .= "var yValue = [";
    array_walk($intervals, function ($item, $index) use ($intervals,&$plotly) {
      $plotly .= $item[0]['nbr'];
      if ($index < count($intervals) - 1) {
        $plotly .= ",";
      }
    });
    $plotly .= "];\n\n";


    $template = $this->twig->load('report.html');
    return $template->render(compact('rows', 'plotly', 'day'));
  }
}
