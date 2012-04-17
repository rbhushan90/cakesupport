<h2>
Questions with no accepted answers
<a href="/questions/add" class="btn btn-info ask-a-question">Ask a question!</a>
</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
  <?php
    if(count($questions) < 1) {
      echo "<h4>There are no questions with unaccepted answers</h4>";
    } else {
      echo $this->element('questions-list');
    }
  ?>
  </div>

  <div class="sidebar">
    <div id="external" class="links">
      <?php echo $this->element('external'); ?>
    </div>
    <div id="tags" class="links">
      <?php echo $this->element('tags'); ?>
    </div>
  </div>

  <div class="clear"></div>
</div>
<div class="bottom-content"></div>
