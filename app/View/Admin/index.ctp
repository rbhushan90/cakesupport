<h2>Recently Reported Answers</h2>
<table class="table" id="question-list">
  <tr>
    <th>Content</th>
    <th>reported by</th>
    <th>on</th>
    <th>Actions</th>
  </tr>

  <?php foreach ($answers as $ans): ?>
    <tr>
      <td><?php echo $ans['ReportedAnswerContent']['body'] ?></td>
      <td><?php echo $ans['ReportedAnswerUser']['username']; ?></td>
      <td style="width: 180px"><?php echo $ans['ReportedAnswer']['time']; ?></td>
      <td>
        <?php echo $this->Html->link('View Quetsion',
            array('controller'  => 'questions', 'action' => 'view',
            $ans['ReportedAnswerContent']['question_id'])); 
        ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<h2>Recently Reported Questions</h2>
<table class="table" id="question-list">
  <tr>
    <th>Content</th>
    <th>reported by</th>
    <th>on</th>
    <th>Actions</th>
  </tr>

  <?php foreach ($questions as $q): ?>
    <tr>
      <td><?php echo htmlspecialchars($q['ReportedQuestionContent']['body']) ?></td>
      <td><?php echo $q['ReportedQuestionUser']['username']; ?></td>
      <td style="width: 180px"><?php echo $q['ReportedQuestion']['time']; ?></td>
      <td>
        <?php echo $this->Html->link('View Quetsion',
            array('controller'  => 'questions', 'action' => 'view',
            $q['ReportedQuestion']['question_id']));
        ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
