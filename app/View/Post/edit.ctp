<h2>Edit blog post</h2>

<div class="top-content"></div>
<div class="forms main-content">
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
echo $this->Form->input('Tag');
echo $this->Form->input('Category');
echo $this->Form->input('body', array('id' => 'markdown', 'rows' => 3));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Make changes');

?>
</div>
<div class="bottom-content"></div>
