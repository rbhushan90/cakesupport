<h2>Questions</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="question full-page">
    <h3><?php echo htmlspecialchars($question['Question']['title']); ?></h3>
    <p class="info">asked by <strong>
    <?php echo $this->Html->link($question['User']['username'], array('controller' => 'users', 'action' => 'view', $question['User']['id'])); ?>
    </strong> on <strong><?php echo $question['Question']['created']; ?></strong></p>

    <div class="answers">
      <p class="number"><?php echo $question['Question']['answer_count'] ?></p>
      <p class="answers-subtext">answers</p>
    </div>

    <div class="question-text">
      <p><?php echo htmlspecialchars($question['Question']['body']); ?></p>
    </div>

    <p class="view-answers">
<?php
      $ct = 0;
      foreach($question['Tag'] as $tag) {
        if($ct == 0) {
          echo "<b>Tags:</b> ";
          $ct = 1;
        } else {
          echo ", ";
        }
        echo $tag['name'];
      }
      if($ct == 0) {
        echo "<b>Tags:</b> none";
      }
?>
    </p>
    <?php
      if($question['Question']['created'] != $question['Question']['modified']) {
        echo "<div class=\"modified\">";
        echo "Last modified on <strong>" . $question['Question']['modified'];
        echo "</strong></div>";
      }
    ?>

    <?php 
      if($this->Session->read('User.id')) {
        echo "<div class=\"actions\">";
        if ($this->Session->read('User.id') == $question['User']['id'] || $this->Session->read('User.permissions') & Configure::read('permissions.QAMod')) {
          echo $this->Html->Link('Edit', array('action' => 'edit', $question['Question']['id']));
          echo " | ";
          echo $this->Html->Link('Delete',
              array('action' => 'remove', $question['Question']['id']));
        } else {
          echo $this->Html->Link('Report', array('action' => 'report', $question['Question']['id']));
        }
        if($this->Session->read('User.permissions') & Configure::read('permissions.FAQ')){
          echo " | ";
          if($question['Question']['faq'] == '0') {
            echo $this->Html->Link('Add to FAQ', array('controller'=>'questions', 'action'=>'addFaq', $question['Question']['id']));
          } else {
            echo $this->Html->Link('Remove from FAQ', array('controller'=>'questions', 'action'=>'removeFaq', $question['Question']['id']));
          }

        }
        echo "</div>";
      }
    ?>

    <p class="clear no-margin"></p>
  </div>


  <?php if ($question['QuestionAnswer']) { ?>
  <div class="question-answers">
    <h3>Answers</h3>
  <?php
    $i=0;
    foreach ($question['QuestionAnswer'] as $ans):
      echo "<div class=\"answer";
      if($ans['accepted']) {
        echo " accepted";
      }
      if($i%2==0) {
        echo " even";
      } else {
        echo " odd";
      }
      echo "\">";
      $i++; 
  ?>
    <?php
      if($ans['accepted']) {
        echo "<h4><strong>Accepted Answer</strong></h4>";
      }
    ?>
    <p class="answerer"><strong>
    <?php echo $this->Html->link($ans['username'], array('controller' => 'users', 'action' => 'view', $ans['user_id'])); ?>:
    </strong></p>
    <p><?php echo $ans['body'] ?></p>
    <?php 
      if ($this->Session->read('User.id')) {
        echo "<div class=\"actions\">";
        if ($this->Session->read('User.permissions') & Configure::read('permissions.acceptAnswers') && !$ans['accepted']) {
          echo $this->Html->Link('Accept', array('controller' => 'answers', 'action' => 'accept', $ans['id']));
          echo " | ";
        }
        if ($ans['user_id'] == $this->Session->read('User.id') || $this->Session->read('User.permissions') & Configure::read('permissions.QAMod')) {
          echo $this->Html->Link('Delete', array('controller' => 'answers', 'action' => 'remove', $ans['id']));
        } else {
          echo $this->Html->Link('Report', array('controller' => 'answers', 'action' => 'report', $ans['id']));
        }
        echo "</div>";
      }
    ?>
    </div>
  <?php endforeach; ?>
  </div>
  <?php } ?>

  <?php
    if($this->Session->read('User.id')) {
      echo "<div class=\"question-answer-new\">";
      echo "<h3>Add a new answer</h3>";
      echo $this->Form->create('Answer', array('action' => 'post', 'class' => 'submit-answer'));
      echo $this->Form->input('question_id', array('type' => 'hidden'));
      echo $this->Form->input('body',
          array('rows' => 4, 'class' => 'newanswer', 'label' => ''));
      echo $this->Form->submit('Answer', array('class' => 'btn btn-primary'));
      echo $this->Form->end();
      echo "</div>";
    }
  ?>

</div>
<div class="bottom-content"></div>
