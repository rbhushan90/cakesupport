<h2>
  Admin > Reports
  <a href="/admin/allusers" class="btn btn-info ask-a-question">View Users</a>
</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="/admin/users">Users</a>
      </li>
      <li><a href="/admin/questions">Questions</a></li>
      <li><a href="/admin/answers">Answers</a></li>
      <li><a href="/admin/comments">Comments</a></li>
    </ul>

    <table class="table">
      <tr>
        <th>Username</th>
        <th>Reported On</th>
        <th>By</th>
        <th>Actions</th>
      </tr>
      <?php
        foreach($users as $user) {
          print "<tr>\n<td>";
          print $user['User']['username'];
          print "</td>\n<td>";
          print $user['ReportedUser']['time'];
          print "</td>\n<td>";
	        print $this->Html->link($user['User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $user['User']['id']));
          print "</td>\n<td>";
	        print $this->Html->link('Deactivate User',
                array('controller'  => 'users', 'action' => 'deactivate',
                $user['Reportee']['id']));
          print "<br/>";
	        print $this->Html->link('Delete Report',
                array('controller'  => 'admin', 'action' => 'unreport',
                'ReportedUser', $user['ReportedUser']['id']));
          print "</td>\n</th>";
        }
      ?>
    </table>
  </div>
</div>
<div class="bottom-content"></div>
