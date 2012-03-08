<?php
class AnswersController extends AppController {
  public $name = 'Answers';
  public $helpers = array('Html', 'Form', 'Session');
  public $uses = array('Question', 'User', 'Answer');

  public function post() {
    if(!$this->Session->read('User.id')) {
      $this->setFlash('You must be registered to post an answer');
      $this->redirect('/login');
    }
    $this->request->data['Answer']['user_id'] = $this->Session->read('User.id');
    if($this->Answer->save($this->request->data)) {
      $this->redirect('/questions'); 
    } else {
      $this->Session->setFlash('Could not save answer');
      $this->redirect(array('controller' => 'questions', 'action' => 'view', 
          $this->request->data['Answer']['question_id'])); 
    }
  }

  public function remove($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    $this->Session->setFlash("This functionality has not been implemented yet.");
    $this->redirect(array('controller' => 'questions', 'action' => 'view', $ans['Answer']['question_id']));
  }

  public function report($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    $this->Session->setFlash("This functionality has not been implemented yet.");
    $this->redirect(array('controller' => 'questions', 'action' => 'view', $ans['Answer']['question_id']));
  }
}

?>
