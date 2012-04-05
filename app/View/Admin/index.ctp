<h2>Admin > Reports</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">
    <h3>Reported Answers</h3>
    <table class="table" id="question-list">
      <tr>
        <th>Content</th>
        <th>reported by</th>
        <th>on</th>
        <th>Actions</th>
      </tr>
      
      <?php $reportType = 'ReportedAnswer'; ?>
      <?php foreach ($answers as $ans): ?>
        <tr>
          <td><?php echo $ans['ReportedAnswerContent']['body'] ?></td>
          <td>
          <?php echo $this->Html->link($ans['ReportedAnswerUser']['username'], array('controller'=>'users', 'action'=>'view', $ans['ReportedAnswerUser']['id'])); ?>
          <td style="width: 180px"><?php echo $ans['ReportedAnswer']['time']; ?></td>
          <td>
            <?php echo $this->Html->link('View Question',
                array('controller'  => 'questions', 'action' => 'view',
                $ans['ReportedAnswerContent']['question_id'])); 
            ?>
            <?php echo $this->Html->link('Delete Report', array('controller' => 'admin', 'action' => 'unreport', $reportType, $ans[$reportType]['id'])); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <h3>Reported Questions</h3>
    <table class="table" id="question-list">
      <tr>
        <th>Title</th>
        <th>Content</th>
        <th>reported by</th>
        <th>on</th>
        <th>Actions</th>
      </tr>
  
      <?php $reportType = 'ReportedQuestion'; ?>
      <?php foreach ($questions as $q): ?>
        <tr>
          <td><?php echo htmlspecialchars($q['ReportedQuestionContent']['title']) ?></td>
          <td><?php echo htmlspecialchars($q['ReportedQuestionContent']['body']) ?></td>
          <td>
          <?php echo $this->Html->link($q['ReportedQuestionUser']['username'], array('controller'=>'users', 'action'=>'view', $q['ReportedQuestionUser']['id'])); ?>
          </td>
          <td style="width: 180px"><?php echo $q['ReportedQuestion']['time']; ?></td>
          <td>
            <?php echo $this->Html->link('View Question',
                array('controller'  => 'questions', 'action' => 'view',
                $q['ReportedQuestion']['question_id']));
            ?>
            <?php echo $this->Html->link('Delete Report', array('controller' => 'admin', 'action' => 'unreport', $reportType, $q[$reportType]['id'])); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <h3>Reported Users</h3>
    <table class="table" id="question-list">
      <tr>
        <th>Username</th>
        <th>reported by</th>
        <th>on</th>
        <th>Actions</th>
      </tr>

      <?php $reportType = 'ReportedUser'; ?>
      <?php foreach ($users as $user): ?>        
        <tr>
          <td>
          <?php echo $this->Html->link($user['ReportedUserContent']['username'], array('controller'=>'users', 'action'=>'view', $user['ReportedUserContent']['id'])); ?>
          </td>
          <td>
          <?php echo $this->Html->link($user['ReportedUserUser']['username'], array('controller'=>'users', 'action'=>'view', $user['ReportedUserUser']['id'])); ?>
          </td>
          <td style="width: 180px"><?php echo $user['ReportedUser']['time']; ?></td>
          <td>
            <?php echo $this->Html->link('Deactivate User', array('controller' => 'users', 'action' => 'deactivate', $user['ReportedUserContent']['id'])); ?>
            <?php echo $this->Html->link('Delete Report', array('controller' => 'admin', 'action' => 'unreport', $reportType, $user[$reportType]['id'])); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
<div class="bottom-content"></div>
