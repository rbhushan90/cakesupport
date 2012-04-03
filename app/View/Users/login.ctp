<h2>Login</h2>

<div class="top-content"></div>
<div class="forms main-content">
  <?php

    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Form->submit('Login', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
  ?>

  <p class="users-links">
    <br>
    <?php echo $this->Html->link('Need to register?', array('action' => 'register')); ?>
  </p>
</div>
<div class="bottom-content"></div>
