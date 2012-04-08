<h2>Edit blog post</h2>
<link rel="stylesheet" type="text/css" href="/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="/markitup/sets/markdown/style.css" /> 
<script type="text/javascript" src="/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/markitup/sets/markdown/set.js"></script>

<script language="javascript">
$(document).ready(function()  {
      $('#markdown').markItUp(mySettings);
});
</script>

<?php

echo $this->Form->create('Post');
echo $this->Form->input('title');
echo "<p>Tags</p>";
foreach($tags as $index=>$tag){
  if(array_key_exists($index, $post_tags) && $post_tags[$index]==true){
    echo $this->Form->checkbox($tag, array('checked'=>true));
  } else {
  echo $this->Form->checkbox($tag);
  }
  echo $tag;
  echo "<br />";
}
echo $this->Form->input('body', array('id' => 'markdown', 'rows' => 3));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Make changes');

?>
