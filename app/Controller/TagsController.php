<?php
class TagsController extends AppController {
  public $name = 'Tags';
  public $helpers = array('Form', 'Html');



  public function select($type = 0, $id = null) {
    $this->Tag->id = $id;
    $tag = $this->Tag->read();
    $redirect = '/';
    if($tag || $id == 0 ) {
      if($type == 1) {
        CakeSession::write('postTag', $id);
        $redirect = '/';
      } else if($type == 2) {
        CakeSession::write('questionTag', $id);
        $redirect = '/questions';
      } else if($type == 3) {
        CakeSession::write('questionTag', $id);
        $redirect = '/unanswered';
      } else if($type == 4) {
        CakeSession::write('questionTag', $id);
        $redirect = '/unaccepted';
      } else if($type == 5) {
        CakeSession::write('faqTag', $id);
        $redirect = '/faq';
      }
    } else {
      $this->Session->setFlash('This category does not exist');
    }

    if(!$this->request->is('ajax')) {
      if(isset($_SERVER['HTTP_REFERER'])) {
        $this->redirect($_SERVER['HTTP_REFERER']);
      } else {
        $this->redirect($redirect);
      }
    }
  }

}
?>
