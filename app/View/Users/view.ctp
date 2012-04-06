<h2><?php echo $user['User']['username']; ?>'s Profile</h2>

<div class="top-content"></div>
<div class="main-content">
  <p>Name: <?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></p>
  <p>Email: <?php echo $user['User']['email']; ?></p>
  <p>Questions asked:
<?php
  if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
    echo $this->Html->link($user['User']['question_count'], array('controller'=>'users', 'action'=>'viewquestions', $user['User']['id']));
  } else {
    echo $user['User']['question_count'];
  }
?>
  </p>
  <p>Questions answered:
<?php
  if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
    echo $this->Html->link($user['User']['answer_count'], array('controller'=>'users', 'action'=>'viewanswers', $user['User']['id']));
  } else {
    echo $user['User']['answer_count'];
  }
?>
  </p>


<?php
  if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
    echo "<div class=\"permissions\">";
    $perm = $user['User']['permissions'];
    $permText = Configure::read('permText');
    $permissions = Configure::read('permissions');
    echo $this->Form->create('User', array('action' => 'permissions'));
    $opt = array();
    $sel = array();
    foreach($permissions as $mask) {
      $opt[$mask] = $permText[$mask];
      if($perm & $mask) {
        $sel[] = $mask;
      }
    }
    echo $this->Form->input('Permissions:', array('multiple' => 'checkbox', 'options' => $opt, 'selected' => $sel));
    echo $this->Form->input('id', array('type' => 'hidden', 'value' => $user['User']['id']));
    echo "<br />";
    echo "<br />";
    echo $this->Form->submit('Change permissions', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    echo "<br />";
    echo "</div>";
  }
?>
<div class="actions">
<?php
  if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
    if($user['User']['permissions'] & 1) {
      echo $this->Html->link('Deactivate account', array('controller'=>'users', 'action'=>'deactivate', $user['User']['id']));
    } else {
      echo $this->Html->link('Activate account', array('controller'=>'users', 'action'=>'activate', $user['User']['id']));
    }
  } else if(CakeSession::read('User.permissions')){
    echo $this->Html->link('Report this user', array('controller'=>'users', 'action'=>'report', $user['User']['id']));
  }
?>
</div>

</div>
<div class="bottom-content"></div>
