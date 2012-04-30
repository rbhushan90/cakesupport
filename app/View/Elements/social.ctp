<?php if(!isset($_SESSION['nojs']) || $_SESSION['nojs'] == '0') { ?>
  <div class='social'>
    <div class="fb-like" 
  <?php 
    if(isset($href)) {
        echo 'data-href="' . $href . '"';
    }
  ?>
        data-send="true"
        data-layout="box_count" data-width="70" data-show-faces="false"
        data-font="verdana"></div>
    <a href="https://twitter.com/share" class="twitter-share-button"
  <?php 
    if(isset($href)) {
        echo 'data-href="' . $href . '"';
    }
  ?>
        data-count="vertical" data-size="large" data-hashtags="GoodMeasureMeal">Tweet</a>
    <div class="g-plusone" data-size="tall"
  <?php 
    if(isset($href)) {
        echo 'data-href="' . $href . '"';
    }
  ?>
  ></div>
  </div>
<?php } ?>
