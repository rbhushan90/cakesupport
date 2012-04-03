<h2>Register</h2>

<div class="top-content"></div>
<div class="forms main-content">
<?php
  echo $this->Form->create('User', array('action' => 'register'));

  echo $this->Form->input('username');
  echo $this->Form->input('password');
  echo $this->Form->input('email');
  echo $this->Form->input('first_name');
  echo $this->Form->input('last_name');

  echo $this->Form->submit('Register', array('class' => 'btn btn-primary'));
  echo $this->Form->end();

?>

<p class="users-links">
  <br>
  <?php
    echo "Already have an account? ";
    echo $this->Html->link('Login here!', array('action' => 'login'));
  ?>
</p>
</div>
<div class="bottom-content"></div>
