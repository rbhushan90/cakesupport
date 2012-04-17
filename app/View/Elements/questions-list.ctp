<?php foreach ($questions as $q): ?>
  <div class="question short">
    <h3><?php echo $this->Html->link($q['Question']['title'], array('controller' => 'questions', 'action' => 'view', $q['Question']['id'])); ?></h3>
    <p class="info">asked by <strong>
    <?php echo $this->Html->link($q['User']['username'], array('controller' => 'users', 'action' => 'view', $q['User']['id'])); ?>
    </strong> on <strong><?php echo $q['Question']['created']; ?></strong></p>

    <?php echo "<a href=\"/questions/view/" . $q['Question']['id'] . "\">" ?>
    <div class="answers
      <?php
        if($q['Question']['answer_count'] == 0) {
          echo 'unanswered';
        }
        if($q['Question']['accepted']) {
          echo 'accepted';
        }
      ?>
    ">
      <p class="number"><?php echo $q['Question']['answer_count'] ?></p>
      <p class="answers-subtext">
      <?php
        if($q['Question']['answer_count'] != 1) {
          echo 'answers';
        } else {
          echo 'answer';
        }
      ?>
      </p>
    </div>
    </a>

    <div class="question-text">
      <p><?php echo htmlspecialchars($q['Question']['body']) ?></p>
    </div>

    <p class="view-answers"><?php echo $this->Html->link('View Answers', array('controller' => 'questions', 'action' => 'view', $q['Question']['id'])); ?></p>
  </div>
<?php endforeach; ?>