<h2>Ask a Question</h2>

<div class="top-content"></div>
<div class="forms main-content">
  <?php

  echo $this->Form->create('Question');
  echo $this->Form->input('title');
  echo $this->Form->input('Tag');
  echo $this->Form->input('body', array('rows' => 3));
  echo $this->Form->submit('Ask Question', array('class' => 'btn btn-primary', 'id' => 'add_question'));
  echo $this->Form->end();

  ?>
</div>
<div class="bottom-content"></div>
