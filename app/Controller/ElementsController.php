<?php
class ElementsController extends AppController {
  public $name = 'Elements';

  public function beforeFilter() {
    if($this->request->is('ajax')) {
      $this->layout = 'content-only';
    }
  }

  public function navigation() {
  }

  public function categories() {
  }

  public function tags() {
  }

  public function error() {
  }
}
?>
