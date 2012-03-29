<?php

App::uses('Xml', 'Utility');

class BlogPostsController extends AppController {
  public $name = 'BlogPost';
  public $helpers = array('Html', 'Form');
  public $uses = array('BlogPost', 'User');
  var $rss_item = array();
  var $feed_url = "http://blog.goodmeasuremeals.com/?feed=rss2";

  public function add() {
  }

  public function view($id = null) {
    $this->BlogPost->id = $id;
    $p = $this->BlogPost->read();

    if($p == null) {
      $this->Session->setFlash('This post does not exist or has been deleted');
      $this->redirect('/blog');
    }

    $this->set('post', $p);
  }

  public function index() {
    $this->set('posts', $this->BlogPost->find('all',
      array('order' => 'BlogPost.id desc')));

		// xml to array conversion
		//$this->rss_item = Xml::toArray(Xml::build($this->feed_url));
    //debug($this->rss_item, true);
		//$this->set('entries', $this->rss_item['rss']['channel']['item']);
    //debug($this->rss_item['rss']['channel']['item'][0], true);

    //$this->set('entries', $this->GMMBlog->find('all'));
    //$this->set('entries2', $this->Question->find('all'));
  }


}
?>
