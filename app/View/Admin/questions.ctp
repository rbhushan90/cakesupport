<h2>
  Admin > Reports
  <a href="/admin/allusers" class="btn btn-info ask-a-question">View All Users</a>
</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">
    <ul class="nav nav-tabs">
      <li><a href="/admin/users">Users</a></li>
      <li class="active">
        <a href="/admin/questions">Questions</a>
      </li>
      <li><a href="/admin/answers">Answers</a></li>
      <li><a href="/admin/comments">Comments</a></li>
    </ul>
    <?php if(count($questions) > 0) { ?>
    <table class="table">
      <tr>
        <th>Question Title</th>
        <th>Reported On</th>
        <th>By</th>
        <th>Actions</th>
      </tr>
      <?php
        foreach($questions as $q) {
          print "<tr>\n<td>";
          print htmlspecialchars($q['Question']['title']);
          print "</td>\n<td>";
          print $q['ReportedQuestion']['time'];
          print "</td>\n<td>";
	        print $this->Html->link($q['User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $q['User']['id']));
          print "</td>\n<td>";
	        print $this->Html->link('View Answer',
                array('controller'  => 'questions', 'action' => 'view',
                $q['Question']['id']));
          print "<br/>";
	        print $this->Html->link('Delete Report',
                array('controller'  => 'admin', 'action' => 'unreport',
                'ReportedQuestion', $q['ReportedQuestion']['id']));
          print "</td>\n</th>";
        }
      ?>
    </table>
    <?php } else { ?>
        <div class="nothing">There are no reported questions.</div>
    <?php } ?>
  </div>
</div>
<div class="bottom-content"></div>
