<?php

App::uses('Xml', 'Utility');

class BlogPostsController extends AppController {
  public $name = 'BlogPost';
  public $helpers = array('Html', 'Form');
  public $uses = array('GMMBlogPost', 'User');
  var $rss_item = array();
  var $feed_url = "http://blog.goodmeasuremeals.com/?feed=rss2";

  public function add() {
  }

  public function index() {
		// xml to array conversion
		$this->rss_item = Xml::toArray(Xml::build($this->feed_url));
    //debug($this->rss_item, true);
		$this->set('entries', $this->rss_item['rss']['channel']['item']);
    //debug($this->rss_item['rss']['channel']['item'][0], true);

    //$this->set('entries', $this->GMMBlog->find('all'));
    //$this->set('entries2', $this->Question->find('all'));
  }


}
?>
