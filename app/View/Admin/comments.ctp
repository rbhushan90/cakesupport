<h2>
  Admin > Reports
  <a href="/admin/allusers" class="btn btn-info ask-a-question">View All Users</a>
</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">
    <ul class="nav nav-tabs">
      <li><a href="/admin/users">Users</a></li>
      <li><a href="/admin/questions">Questions</a></li>
      <li><a href="/admin/answers">Answers</a></li>
      <li class="active">
        <a href="/admin/comments">Comments</a>
      </li>
    </ul>

    <?php if(count($comments) > 0) { ?>
    <table class="table">
      <tr>
        <th>Comment Text</th>
        <th>Reported On</th>
        <th>By</th>
        <th>Actions</th>
      </tr>
      <?php
        foreach($comments as $comment) {
          print "<tr>\n<td>";
          print $comment['Comment']['body'];
          print "</td>\n<td>";
          print $comment['ReportedComment']['time'];
          print "</td>\n<td>";
	        print $this->Html->link($comment['User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $comment['User']['id']));
          print "</td>\n<td>";
	        print $this->Html->link('View Post',
                array('controller'  => 'posts', 'action' => 'view',
                $comment['Comment']['post_id']));
          print "<br/>";
	        print $this->Html->link('Delete Report',
                array('controller'  => 'admin', 'action' => 'unreport',
                'ReportedComment', $comment['ReportedComment']['id']));
          print "</td>\n</th>";
        }
      ?>
    </table>
    <?php } else { ?>
        <div class="nothing">There are no reported comments.</div>
    <?php } ?>
  </div>
</div>
<div class="bottom-content"></div>
