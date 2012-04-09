<h2><?php echo $user['User']['username']; ?>'s profile</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="user user-info">
    <h3>Info</h3>
    <p><strong>Name:</strong> <?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['User']['email']; ?></p>
    <p><strong>Questions asked:</strong>
  <?php
    if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
      echo $this->Html->link($user['User']['question_count'], array('controller'=>'users', 'action'=>'viewquestions', $user['User']['id']));
    } else {
      echo $user['User']['question_count'];
    }
  ?>
    </p>
    <p><strong>Questions answered:</strong>
  <?php
    if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
      echo $this->Html->link($user['User']['answer_count'], array('controller'=>'users', 'action'=>'viewanswers', $user['User']['id']));
    } else {
      echo $user['User']['answer_count'];
    }
  ?>
    </p>
  </div>

<?php
  if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
    echo "<div class=\"user user-permissions\">";
    echo "<h3>Permissions</h3>";
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
    echo $this->Form->submit('Change permissions', array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    echo "</div>";
  }
?>

  <div class="clear">
    <div class="user actions">
      <?php
        if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
          if($user['User']['permissions'] & 1) {
            echo $this->Html->link('Deactivate account', array('controller'=>'users', 'action'=>'deactivate', $user['User']['id']), array('class' => 'btn btn-danger'));
          } else {
            echo $this->Html->link('Activate account', array('controller'=>'users', 'action'=>'activate', $user['User']['id']));
          }
        } else if(CakeSession::read('User.permissions')){
          echo $this->Html->link('Report this user', array('controller'=>'users', 'action'=>'report', $user['User']['id']), array('class' => 'btn btn-danger'));
        }
      ?>
    </div>
  </div>

</div>
<div class="bottom-content"></div>
