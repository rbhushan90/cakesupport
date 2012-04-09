<?php $this->start('qlist') ?>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
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
  </div>

  <div class="sidebar">
    <div class="links">
      <h3>Links</h3>
      <p><a href="http://twitter.com/goodmeasuremeal" target="_blank">@GoodMeasureMeals on Twitter</a></p>
      <p><a href="http://www.facebook.com/GoodMeasureMeals" target="_blank">GMM Facebook Page</a></p>
      <p><a href="http://www.youtube.com/user/GoodMeasureMeals" target="_blank">GMM YouTube Channel</a></p>
      <p><a href="http://www.goodmeasuremeals.com" target="_blank">GMM Website</a></p>
      <p><a href="http://www.projectopenhand.com" GMM target="_blank">Open Hand Atlanta</a></p>
    </div>
    <div class="links">
      <h3>Tags</h3>
      <p>
        <?php
          $selTags = CakeSession::read('tags');
          if(!($selTags)) {
            $selTags = array();
            CakeSession::write('tags', $selTags);
          }
          echo $this->Html->link('All', array('controller' => 'tags', 'action' => 'flip', '0'));
        ?>
      </p>
      <?php foreach($tags as $tag): ?>
      <p>
        <?php
          if(array_key_exists($tag['Tag']['id'], $selTags)) {
            $text = '<i class="icon-minus"></i> ';
          } else {
            $text = '<i class="icon-plus"></i> ';
          }
          $text .= $tag['Tag']['name'];
          echo $this->Html->link($text, array('controller' => 'tags', 'action' => 'flip', $tag['Tag']['id']), array('escape' => false));
        ?>
      </p>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="clear"></div>
</div>
<div class="bottom-content"></div>

<?php $this->end() ?>
