<h2>Admin > Reports</h2>
<div class="top-content"></div>
<div class="main-content">
  <div class="admin">

<?php
//A function to format report lists. Should probably be refactored into a CakePHP Helper later.
  function formatReportList($this_copy, $reportType, $reportList, $fields, $valueGetters) {  ?>
    <h3>Reported <?php echo substr($reportType,8); ?>s</h3>
    <table class="table" id="question-list">
      <tr>
        <?php foreach($fields as $f){
          echo '<th>' . $f . '</th>';        
        } ?>
      </tr>
      
      <?php foreach ($reportList as $ans): ?>
        <tr>
        <?php foreach($valueGetters as $f){
          echo '<td>' . $f($reportType, $ans) . '</td>';        
        } ?>
        </tr>
      <?php endforeach; ?>
    </table>
<?php
  }
?>

<?php 

//Make copy of this so we can use it in anonymous functions we create
$this_copy = $this;

$bodyGetter = function ($reportType, $r){
	return htmlspecialchars($r[$reportType . 'Content']['body']);
};

$titleGetter = function ($reportType, $r){
	return htmlspecialchars($r[$reportType . 'Content']['title']);
};

$timeGetter = function ($reportType, $r){
	return $r[$reportType]['time'];
};

$viewReporterLink = function($reportType,$r)use($this_copy){
	return $this_copy->Html->link($r[$reportType.'User']['username'],
                array('controller'  => 'users', 'action' => 'view',
                $r[$reportType]['user_id']));
};

$deleteReportLink = function($reportType,$r)use($this_copy){
	return $this_copy->Html->link('Delete Report',
                array('controller'  => 'admin', 'action' => 'unreport',
                $reportType, $r[$reportType]['id']));
};

///////////////////////////////////////////////////////////////////////////
//Create list of Reported Answers 
$viewAnswerLink = function($reportType,$r)use($this_copy){
	return $this_copy->Html->link('View Answer',
                array('controller'  => 'questions', 'action' => 'view',
                $r[$reportType.'Content']['question_id']));
};

formatReportList($this,'ReportedAnswer',$answers,
	array('Content','reported by','on','Actions',''),
	array($bodyGetter, $viewReporterLink, $timeGetter, $viewAnswerLink, $deleteReportLink)
	);

?>
  </div>
</div>
<div class="bottom-content"></div>
