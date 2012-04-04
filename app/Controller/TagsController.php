<?php
class TagsController extends AppController {
  public $name = 'Tags';
  public $helpers = array('Form', 'Html');


  public function flip($id = null) {
    $this->Tag->id = $id;
    $tag = $this->Tag->read();
    $tags = CakeSession::read('tags');
    if($id == 0) {
      $tags = array();
    } else {
      if(array_key_exists($id, $tags)) {
        unset($tags[$id]);
      } else {
        $tags[$id] = 1;
      }
    }
    CakeSession::write('tags', $tags);

    $this->redirect('/');
  }

}
?>
