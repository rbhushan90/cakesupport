<h2>
  Admin > Reports
  <a href="/admin/allusers" class="btn btn-info ask-a-question">View Users</a>
</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">
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
                'ReportedAnswer', $answer['ReportedAnswer']['id']));
          print "</td>\n</th>";
        }
      ?>
    </table>
  </div>
</div>
<div class="bottom-content"></div>
