<?php $this->start('qlist') ?>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <?php foreach ($questions as $q): ?>
      <div class="question">
        <h3><?php echo $this->Html->link($q['Question']['title'], array('controller' => 'questions', 'action' => 'view', $q['Question']['id'])); ?></h3>
        <p class="info">asked by <strong><?php echo $q['User']['username']; ?></strong> on <strong><?php echo $q['Question']['created']; ?></strong></p>

        <div class="answers">
          <p class="number"><?php echo $q['Question']['answer_count'] ?></p>
          <p class="answers-subtext">answers</p>
        </div>

        <div class="question-text">
          <p><?php echo $q['Question']['body'] ?></p>
        </div>

        <p class="view-answers"><a href="#">View Answers</a></p>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="sidebar">
    <div class="links">
      <h3>Tags</h3>
      <p><a href="#" target="_blank">Fitness</a></p>
      <p><a href="#" target="_blank">Diet</a></p>
      <p><a href="#" target="_blank">Vegan</a></p>
      <p><a href="#" target="_blank">Meat</a></p>
      <p><a href="#" target="_blank">Dairy</a></p>
      <p><a href="#" target="_blank">Veggies</a></p>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="bottom-content"></div>

<?php $this->end() ?>
