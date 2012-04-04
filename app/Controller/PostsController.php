<?php

class PostsController extends AppController {
  public $name = 'Post';
  public $helpers = array('Html', 'Form');
  public $uses = array('Post', 'User');

  public function add() {
    $this->User;
    if(!($this->Session->read('User.permissions') & User::$permissionMasks['postBlog'])) {
      $this->Session->setFlash('You do not have the permissions to post to the blog');
      $this->redirect('/blog');
    }
    if($this->request->data) {
      $this->Session->setFlash('The post has been added.');
      include '../webroot/markitup/markdown.php';
      $this->request->data['Post']['output'] = Markdown($this->request->data['Post']['body']);
      $this->request->data['Post']['user_id'] = $this->Session->read('User.id');
      $this->Post->save($this->request->data);
      $this->redirect('/blog');
    }
  }

  public function delete($id = null) {
    $this->User;
    if(!($this->Session->read('User.permissions') & User::$permissionMasks['postBlog'])) {
      $this->Session->setFlash('You do not have the permissions to delete blog entries');
      $this->redirect('/blog');
    } else {
      $this->Post->delete($id);
      $this->redirect('/blog');
    }
  }

  public function view($id = null) {
    $this->Post->id = $id;
    $p = $this->Post->read();

    if($p == null) {
      $this->Session->setFlash('This post does not exist or has been deleted');
      $this->redirect('/blog');
    }

    $this->set('post', $p);
  }

  public function index() {
    $this->set('posts', $this->Post->find('all',
      array('order' => 'Post.id desc')));
  }


}
?>
