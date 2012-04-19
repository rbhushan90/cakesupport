<h2><?php echo $user['User']['username']; ?>'s Answers</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="user user-content">
    <ul>
      <?php
        $count = 0;
        foreach($user['UserAnswer'] as $ans) {
          $klass = ($count % 2 == 0) ? 'even' : 'odd';
          echo "<li class='{$klass}'>";
          echo $ans['body'];
          echo $this->Html->link('[View Question]', array('controller'=>'questions', 'action'=>'view', $ans['question_id']));
          echo '</li>';
        }
      ?>
    </ul>
    <?php
      echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'view', $user['User']['id']), array('class' => 'user-back'));
    ?>
  </div>
</div>
<div class="bottom-content"></div>
