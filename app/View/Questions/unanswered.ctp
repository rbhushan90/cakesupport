<h2>
  Unanswered Questions
  <a href="/questions/add" class="btn btn-info ask-a-question">Ask a question!</a>
</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
  <?php
    if(count($questions) < 1) {
      echo "<h4>There are no unanswered questions</h4>";
    } else {
      echo $this->element('questions-list');
    }
  ?>
  </div>

  <div class="sidebar">
    <?php echo $this->element('external'); ?>
    <?php echo $this->element('tags'); ?>
  </div>

  <div class="clear"></div>
</div>
<div class="bottom-content"></div>
