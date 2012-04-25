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
      <li class="active">
        <a href="/admin/answers">Answers</a>
      </li>
      <li><a href="/admin/comments">Comments</a></li>
    </ul>

    <?php if(count($answers) > 0) { ?>
    <table class="table">
      <tr>
        <th>Answer Text</th>
        <th>Reported On</th>
        <th>By</th>
        <th>Actions</th>
      </tr>
      <?php
        foreach($answers as $answer) {
          print "<tr>\n<td>";
          print $answer['Answer']['body'];
          print "</td>\n<td>";
          print $answer['ReportedAnswer']['time'];
          print "</td>\n<td>";
	        print $this->Html->link($answer['User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $answer['User']['id']));
          print "</td>\n<td>";
	        print $this->Html->link('View Question',
                array('controller'  => 'questions', 'action' => 'view',
                $answer['Answer']['question_id']));
          print "<br/>";
	        print $this->Html->link('Delete Report',
                array('controller'  => 'admin', 'action' => 'unreport',
                'ReportedAnswer', $answer['ReportedAnswer']['id']),
                array('class' => 'action ref'));
          print "</td>\n</th>";
        }
      ?>
    </table>
    <?php } else { ?>
        <div class="nothing">There are no reported answer.</div>
    <?php } ?>
  </div>
</div>
<div class="bottom-content"></div>
