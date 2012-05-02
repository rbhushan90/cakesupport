<?php
class TagsController extends AppController {
  public $name = 'Tags';
  public $helpers = array('Form', 'Html');



  public function selectQuestionTag($id = null) {
    $this->Tag->id = $id;
    $tag = $this->Tag->read();
    if($tag || $id == 0 ) {
      CakeSession::write('questionTag', $id);
    } else {
      $this->Session->setFlash('This category does not exist');
    }

    if(!$this->request->is('ajax')) {
      if(isset($_SERVER['HTTP_REFERER'])) {
        $this->redirect($_SERVER['HTTP_REFERER']);
      } else {
        $this->redirect('/');
      }
    }
  }
  public function selectPostTag($id = null) {
    $this->Tag->id = $id;
    $tag = $this->Tag->read();
    if($tag || $id == 0 ) {
      CakeSession::write('postTag', $id);
    } else {
      $this->Session->setFlash('This category does not exist');
    }

    if(!$this->request->is('ajax')) {
      if(isset($_SERVER['HTTP_REFERER'])) {
        $this->redirect($_SERVER['HTTP_REFERER']);
      } else {
        $this->redirect('/');
      }
    }
  }

}
?>
