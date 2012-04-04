<?php $this->start('qlist') ?>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <?php foreach ($questions as $q): ?>
      <div class="question short">
        <h3><?php echo $this->Html->link($q['Question']['title'], array('controller' => 'questions', 'action' => 'view', $q['Question']['id'])); ?></h3>
        <p class="info">asked by <strong><?php echo $q['User']['username']; ?></strong> on <strong><?php echo $q['Question']['created']; ?></strong></p>

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
  </div>
  <div class="sidebar">
    <div class="links">
      <h3>Tags</h3>
      <p><a href="#">Fitness</a></p>
      <p><a href="#">Diet</a></p>
      <p><a href="#">Vegan</a></p>
      <p><a href="#">Meat</a></p>
      <p><a href="#">Dairy</a></p>
      <p><a href="#">Veggies</a></p>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="bottom-content"></div>

<?php $this->end() ?>
