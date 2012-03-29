<h2>Create a Blog Entry</h2>

<?php

echo $this->Form->create('BlogPost');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => 3));
echo $this->Form->end('Post Entry');

?>
