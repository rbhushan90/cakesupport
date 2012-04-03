<h2>Login</h2>

<div class="top-content"></div>
<div class="users main-content">
  <?php

    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Form->end('Login');
  ?>

  <p class="users-links">
    <?php echo $this->Html->link('Need to register?', array('action' => 'register')); ?>
  </p>
</div>
<div class="bottom-content"></div>
