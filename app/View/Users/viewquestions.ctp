<h2><?php echo $user['User']['username']; ?>'s Questions</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="user user-content">
    <ul>
    <?php
      $count = 0;
      foreach($user['UserQuestion'] as $q) {
        $klass = ($count % 2 == 0) ? 'even' : 'odd';
        echo "<li class='{$klass}'>";
        echo $this->Html->link($q['title'], array('controller'=>'questions', 'action'=>'view', $q['id']));
        echo '</li>';
        $count++;
      }
    ?>
    </ul>
    <?php 
      echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'view', $user['User']['id']), array('class' => 'user-back'));
    ?>
  </div>
</div>
<div class="bottom-content"></div>
