<h2>Recover username/password</h2>

<div class="top-content"></div>
<div class="forms main-content">
  <?php

    echo $this->Form->create('User', array('action' => 'forgot'));
    echo $this->Form->input('usermail', array('label' => 'Email or username'));
    echo $this->Form->submit('Send me the details', array('class' => 'btn btn-primary', 'div' => false));
    echo $this->Form->end();
  ?>

  <p class="users-links">
    <br>
    <?php echo $this->Html->link('Need to register?', array('action' => 'register')); ?>
  </p>
</div>
<div class="bottom-content"></div>
