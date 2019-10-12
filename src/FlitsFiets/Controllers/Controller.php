<?php


namespace FlitsFiets\Controllers;


class Controller {
  protected $m; # model
  protected $v; # view

  public function render() {
    return $this->v->render();
  }
}