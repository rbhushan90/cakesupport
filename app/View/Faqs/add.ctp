<h2>Ask a Question</h2>

<?php

echo $this->Form->create('Faq');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => 3));
echo $this->Form->end('Save Post');

?>
