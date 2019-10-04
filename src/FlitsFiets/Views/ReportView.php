<?php

namespace FlitsFiets\Views;

use FlitsFiets\Controllers\ReportController;

class ReportView {

  private $c; // controller
  private $twig; // twig object

  public function __construct() {
    $loader = new \Twig\Loader\FilesystemLoader(APP_ROOT.'/templates');
    $twigoptions = $this->getCachingState();
    $this->twig = new \Twig\Environment($loader, $twigoptions);
    $this->c = new ReportController();
  }

  public function getCachingState() {
    if ($_ENV['APP_ENV'] == 'production') {
      return ['cache' => APP_ROOT.'/cache/templates/compilation_cache'];
    } else {
      return [];
    }
  }

  public function render() {
    // https://twig.symfony.com/doc/2.x/api.html
    $content = $this->c->getReport();
    $template = $this->twig->load('report.html');
    return $template->render(compact('content'));
  }
}
