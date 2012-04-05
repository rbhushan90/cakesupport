<h2><?php echo $user['User']['username']; ?>'s Profile</h2>

<div class="top-content"></div>
<div class="main-content">
    <p>Name: <?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></p>
    <p>Email: <?php echo $user['User']['email']; ?></p>
    <p><?php echo $this->Html->link( 'Questions asked: ' . $user['User']['question_count'],
	 array('controller'=>'users', 'action'=>'viewquestions', $user['User']['id']));?></p>
    <p><?php echo $this->Html->link( 'Questions answered: ' . $user['User']['answer_count'],
	 array('controller'=>'users', 'action'=>'viewanswers', $user['User']['id']));?></p>

</div>
<div class="bottom-content"></div>
