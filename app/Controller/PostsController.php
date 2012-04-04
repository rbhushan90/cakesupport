<?php

class PostsController extends AppController {
  public $name = 'Post';
  public $helpers = array('Html', 'Form');
  public $uses = array('Post', 'User');

  public function add() {
    $this->User;
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.postBlog'))) {
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
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.postBlog'))) {
      $this->Session->setFlash('You do not have permission to delete blog posts');
      $this->redirect('/blog');
    } else {
      $this->Post->delete($id);
      $this->redirect('/blog');
    }
  }

  public function edit($id = null) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.postBlog'))) {
      $this->Session->setFlash('You do not have permission to edit blog posts');
      $this->redirect('/blog');
    }
    $this->Post->id = $id;
    $post = $this->Post->read();
    if(!$post) {
      $this->Session->setFlash('This post does not exist');
      $this->redirect('/blog');
    }

    if($this->request->is('get')) {
      $this->request->data = $post;
    } else {
      include '../webroot/markitup/markdown.php';
      $this->request->data['Post']['output'] = Markdown($this->request->data['Post']['body']);
      $this->request->data['Post']['user_id'] = $this->Session->read('User.id');
      $this->Post->save($this->request->data);
      $this->Session->setFlash('The post was successfully edited.');
      $this->redirect(array('action' => 'view', $id));
    }


  }


  public function view($id = null) {
    $this->Post->id = $id;
    $p = $this->Post->read();

    if($p == null) {
      $this->Session->setFlash('This post does not exist or has been deleted');
      $this->redirect('/blog');
    }

    for ($i=count($p['PostComment'])-1; $i >= 0; $i--) {
      $this->User->id = $p['PostComment'][$i]['user_id'];
      $user = $this->User->read();
      $p['PostComment'][$i]['username'] = $user['User']['username'];
    }

    $this->request->data['Comment']['post_id'] = $id;
    $this->set('post', $p);
  }

  public function index() {
    $this->set('posts', $this->Post->find('all',
      array('order' => 'Post.id desc')));
  }


}
?>
