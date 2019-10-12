<?php


namespace FlitsFiets\Views;


use mysql_xdevapi\Exception;

class View {
  private $template;
  protected $renderer;
  protected $data;
  protected $twig; // twig object

  public function __construct() {
    $loader = new \Twig\Loader\FilesystemLoader(APP_ROOT.'/templates');
    $twigoptions = [
      "cache" => $this->getCachingState(),
      'debug' => true
    ];
    $this->twig = new \Twig\Environment($loader, $twigoptions);
    $this->template = "default.html";
    $this->data = [];
  }

  public function __set($name, $value)
  {
      if ($name == 'template') {
          $this->template = $value;
          $this->renderer = $this->twig->load($this->template);
      }
  }

    public function getCachingState() {
    if ($_ENV['APP_ENV'] == 'production') {
      APP_ROOT.'/cache/templates/compilation_cache';
    } else {
      return false;
    }
  }

  public function addPageData($array) {
    $this->data = array_merge($array, $this->data);
  }

  public function render() {
      return $this->startRender();
  }

  protected function startRender() {
    if (isset($_SESSION['messages'])) {
      $this->data = array_merge(["messages" => $_SESSION['messages']], $this->data);
    }

    return $this->renderer->render($this->data);
  }
}
