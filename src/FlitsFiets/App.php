<?php

namespace FlitsFiets;

use Dotenv\Dotenv;
use Krumo;

class App {

  private $r = [];  // response
  public $APPDIR;

  public $html = "";

  public function __construct() {

    $this->APPDIR = realpath(pathinfo($_SERVER["SCRIPT_FILENAME"], PATHINFO_DIRNAME)."/../");
    set_error_handler([$this,'exceptions_error_handler']);
    ob_start([$this,'catcherrors']);
  }

  public function init() {
    $this->loadEnv();
    $this->debug($_ENV);
  }

  public function view($message,$mode = "html") {
    switch($mode) {
      case "html":
        $this->html .= $message;
        break;
      default:
        // json
        // do nothing
        break;
    }

  }

  public function exceptions_error_handler($severity, $message, $filename, $lineno) {
    if (error_reporting() == 0) {
      return;
    }
    if (error_reporting() & $severity) {
      // throw new ErrorException($message, 0, $severity, $filename, $lineno);
      ob_end_clean();
      header('Content-Type: application/json');
      echo json_encode(array(
        'error' => array(
          'msg' => $message,
          'severity' => $severity,
          'filename' => $filename,
          'lineno' => $lineno,
        ),
        'app' => $this->r,
      ));
      die();
    }
  }

  public function catcherrors($data) {
    if ($data) {
      $this->r['errors'][] = $data;
    }
  }

  public function loadEnv() {
    // load ENV
    $dotenv = Dotenv::create($this->APPDIR);
    $dotenv->load();
  }

  public function getResponse() {
    return $this->r;
  }

  public function getJsonResponse() {
    return json_encode($this->getResponse());
  }

  public function sendResponse ($format = "json") {
    ob_end_clean();
    switch ($format) {
      case "json":
        header('Content-Type: application/json');
        print $this->getJsonResponse();
        die();

        break;
      case "html":
        print($this->html);
        krumo($this->getResponse());
        break;
    }
  }

  public function debug($object) {
    $this->r['debug'][] = $object;
  }
}