<h2>Edit your Question</h2>

<div class="top-content"></div>
<div class="forms main-content">

<?php

echo $this->Form->create('Question');
echo $this->Form->input('title');
echo $this->Form->input('Tag');
echo "<br />";
echo "<br />";
echo $this->Form->input('body', array('rows' => 3));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('user_id', array('type' => 'hidden'));
echo $this->Form->end('Save Changes');

?>
</div>
<div class="bottom-content"></div>
