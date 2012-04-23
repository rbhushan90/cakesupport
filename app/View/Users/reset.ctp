

<h2>Password Reset</h2>

<div class="top-content"></div>
<div class="forms main-content">
  <?php
      echo $this->Form->create('User', array('action' => 'reset', 'class' => 'resetpass'));
      echo $this->Form->input('id', array('type' => 'hidden'));
      echo $this->Form->input('password', array('label' => 'New Password'));
      echo $this->Form->input('confirm', array('type' => 'password', 'label' => 'Confirm new password'));
      echo $this->Form->submit('Change Password', array('class' => 'btn btn-primary'));
      echo $this->Form->end();
  ?>
</div>
<div class="bottom-content"></div>
