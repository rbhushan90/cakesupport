<?php
class AdminController extends AppController {
  public $name = 'Admin';
  public $helpers = array('Html', 'Form');
  public $uses = array('User', 'ReportedAnswer', 'ReportedQuestion','ReportedComment');

  public function index() {
    $this->set('reports', $this->ReportedQuestion->find('all'));
  }

  public function users() {
    $this->set('users', $this->User->find('all'));
    //$cond = array('answer_count' => 0);
    //$this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
  }

  public function view($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    $this->request->data['Answer']['question_id'] = $id;
    if($q == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->redirect('/questions');
    }

    for ($i=count($q['QuestionAnswer'])-1; $i >= 0; $i--) {
      $this->User->id = $q['QuestionAnswer'][$i]['user_id'];
      $user = $this->User->read();
      $q['QuestionAnswer'][$i]['username'] = $user['User']['username'];
    }

    $this->set('question', $q);
  }

}
?>
