<h2>
  Admin > Users
  <a href="/admin/" class="btn btn-info ask-a-question">View Reports</a>
</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">

<?php
  echo $this->Form->create(array('class' => 'find-user'));
  echo $this->Form->input('search', array('label' => 'Find user:', 'div' => false));
  echo $this->Form->submit('Find User', array('class' => 'btn btn-primary', 'div' => false));
  echo "<div>";
  echo $this->Form->checkbox('inactive', array());
  echo "Show inactive users";
  echo "</div>";
  echo $this->Form->end();
?>

    <table class="table">
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
      <?php
        $mod = false;
        if(CakeSession::read('User.permissions') & Configure::read('permissions.userMod')) {
          $mod = true;
        }
        foreach($users as $user) {
          print "<tr>\n<td>";
	        print $this->Html->link($user['User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $user['User']['id']));
          print "</td>\n<td>";
          print $user['User']['email'];
          print "</td>\n<td>";
          if($mod) {
            if($user['User']['permissions'] & 1) {
              print $this->Html->link('Deactivate',
                    array('controller'  => 'users', 'action' => 'deactivate',
                    $user['User']['id']), array('class' => 'btn btn-danger btn-mini action ref'));
            } else {
              print $this->Html->link('Activate',
                    array('controller'  => 'users', 'action' => 'activate',
                    $user['User']['id']), array('class' => 'btn btn-primary btn-mini action ref'));
            }
          }
          print "</td>\n</th>";
        }
      ?>
    </table>
  </div>
</div>
<div class="bottom-content"></div>
