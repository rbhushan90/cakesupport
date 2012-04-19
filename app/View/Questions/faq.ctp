<h2>Frequently Asked Questions</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <?php if(count($faqs) == 0) { ?>
        <div class="nothing">There are no FAQs under this tag.</div>
    <?php } ?>
    <?php foreach($faqs as $faq): ?>
      <div class="question short">
        <h3><?php echo $this->Html->link($faq['Question']['title'], array('controller' => 'questions', 'action' => 'view', $faq['Question']['id'])); ?></h3>
        <div class="question-text">
          <p><?php echo htmlspecialchars($faq['Question']['body']) ?></p>
        </div>
        <div class="question-answers">
          <h4>Answer</h4>
          <p class="answer accepted">
            <?php if(!$faq['Question']['accepted']){
              echo $this->Html->link('View Thread',array('controller'=>'questions', 'action'=>'view', $faq['Question']['id']));
            } else {
              echo $faq['QuestionAnswer'][0]['body'];
            }?>
          </p>
        </div>

        <?php if($this->Session->read('User.permissions') & Configure::read('permissions.FAQ')){
          echo "<p class=\"remove-answer\">";
          echo $this->Html->link('Remove', array('action'=>'removeFaq', $faq['Question']['id']), array('class' => 'btn btn-danger'));
          echo "</p>";
        } ?>

      </div>
    <?php endforeach; ?>
  </div>
  <div class="sidebar">
    <div class="links">
      <h3>Questions</h3>
      <?php
        foreach ($faqs as $faq) {
          echo '<p>';
          echo $this->Html->link($faq['Question']['title'], array('controller'=>'questions', 'action'=>'view', $faq['Question']['id']));
          echo '</p>';
        }
      ?>
    </div>
    <?php echo $this->element('tags'); ?>
  </div>
  <div class="clear"></div>
</div>
<div class="bottom-content"></div>
