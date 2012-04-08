<h2>Frequently Asked Questions</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <?php for($i = count($faqs)-1; $i>=0; $i--){ ?>
      <div class="question short">
        <h3><?php echo $this->Html->link($faqs[$i]['title'], array('controller' => 'questions', 'action' => 'view', $faqs[$i]['id'])); ?></h3>
        <div class="question-text">
          <p><?php echo htmlspecialchars($faqs[$i]['body']) ?></p>
        </div>
        <div class="question-answers">
          <h4>Answer</h4>
          <p class="answer accepted">
            <?php if($faqs[$i]['answer']==null){
              echo $this->Html->link('View Thread',array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id']));
            } else {
              echo $faqs[$i]['answer'];
            }?>
          </p>
        </div>

        <?php if($this->Session->read('User.permissions') & Configure::read('permissions.FAQ')){
          echo "<p class=\"remove-answer\">";
          echo $this->Html->link('Remove', array('controller'=>'faq', 'action'=>'remove', $faqs[$i]['id']), array('class' => 'btn btn-danger'));
          echo "</p>";
        } ?>

      </div>
    <?php } ?>
  </div>
  <div class="sidebar">
    <div class="links">
      <h3>Questions</h3>
<?php
        for($i = count($faqs)-1; $i>=0; $i--) {
          echo '<p>';
          echo $this->Html->link($faqs[$i]['title'], array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id']));
          echo '</p>';
        }
?>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="bottom-content"></div>
