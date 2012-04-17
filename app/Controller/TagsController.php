<?php
class TagsController extends AppController {
  public $name = 'Tags';
  public $helpers = array('Form', 'Html');


  public function flip($id = null) {
    $this->Tag->id = $id;
    $tag = $this->Tag->read();
    if($tag || $id == 0 ) {
      CakeSession::write('tag', $id);
    } else {
      $this->Session->setFlash('This category does not exist');
    }

    if(!$this->is('ajax')) {
      $this->redirect(array('controller' => 'questions'));
    }
  }

}
?>
