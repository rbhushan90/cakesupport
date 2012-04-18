<h2>
  Admin > Users
  <a href="/admin/" class="btn btn-info ask-a-question">View Reports</a>
</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">

<?php
  echo $this->Form->create();
  echo $this->Form->input('search', array('label' => 'Search For:', 'div' => false));
  echo $this->Form->end('Search', array('div' => false));
?>

    <table class="table">
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
      <?php
        foreach($users as $user) {
          print "<tr>\n<td>";
	        print $this->Html->link($user['User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $user['User']['id']));
          print "</td>\n<td>";
          print $user['User']['email'];
          print "</td>\n<td>";
	        print $this->Html->link('Deactivate',
                array('controller'  => 'users', 'action' => 'deactivate',
                $user['User']['id']));
          print "</td>\n</th>";
        }
      ?>
    </table>
  </div>
</div>
<div class="bottom-content"></div>
