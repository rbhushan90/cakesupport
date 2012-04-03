<?php
class AdminController extends AppController {
  public $name = 'Admin';
  public $helpers = array('Html', 'Form');
  public $uses = array('User', 'ReportedAnswer', 'ReportedQuestion','ReportedComment');

  public function index() {
    foreach(array('ReportedAnswer', 'ReportedQuestion') as $reportType){
      $this->set($reportType . 's', $this->$reportType->find('all'));
    }    
    $this->set('answers', $this->ReportedAnswer->find('all'));
    $this->set('questions', $this->ReportedQuestion->find('all'));
  }

  public function users() {
    $this->set('users', $this->User->find('all'));
    //$cond = array('answer_count' => 0);
    //$this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
  }

}
?>
