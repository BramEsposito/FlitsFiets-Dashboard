<?php


namespace FlitsFiets\Controllers;


class Controller {
  public $m; # model
  public $v; # view

  public function render() {
    return $this->v->render();
  }
}