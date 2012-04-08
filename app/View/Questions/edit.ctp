<h2>Edit your Question</h2>

<?php

echo $this->Form->create('Question');
echo $this->Form->input('title');
echo "<p>Tags</p>";
foreach($tags as $index=>$tag){
  if(array_key_exists($index, $question_tags) && $question_tags[$index]==true){
    echo $this->Form->checkbox($tag, array('checked'=>true));
  } else {
  echo $this->Form->checkbox($tag);
  }
  echo $tag;
  echo "<br />";
}
echo $this->Form->input('body', array('rows' => 3));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('user_id', array('type' => 'hidden'));
echo $this->Form->end('Save Changes');

?>
