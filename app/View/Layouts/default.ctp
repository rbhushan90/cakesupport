<?php
/**
*
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> :: Good Measure Meals
	</title>
	<?php

    # The two I'm using
    
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('gmm');

    if(!isset($_SESSION['nojs']) || $_SESSION['nojs'] == '0') {
      echo $this->Html->script('jquery');
      echo $this->Html->script('jquery.animate-colors');
      echo $this->Html->script('gmm');
      echo $this->Html->script('jquery.history');
    }
                                                                                 
    echo $this->fetch('meta');                                                   
    echo $this->fetch('css');                                                    
    echo $this->fetch('script');                                                 
  ?>                                                                             
</head>
<body>
<div id="fb-root"></div>
<?php if(!isset($_SESSION['nojs']) || $_SESSION['nojs'] == '0') { ?>
  <script>
    loadScript = function(d, s, id, url) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = url;
      fjs.parentNode.insertBefore(js, fjs);
    }
    loadScript(document, 'script', 'facebook-jssdk', "//connect.facebook.net/en_US/all.js#xfbml=1");
    loadScript(document,"script","twitter-wjs", "//platform.twitter.com/widgets.js");
  </script>
  <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
    {parsetags: 'explicit'}
  </script>
<?php } ?>
  <div id="header-container">
    <div id="header" class="content-width">
      <h1><a href="/"><img src="/img/gmm_logo.png"></a></h1>
      <div id="menu" class="menu">
      <?php echo $this->element('navigation'); ?>
      </div>
    </div>
  </div>

  <div id='err' class='content-container content-width'>
    <?php echo $this->Session->flash(); ?> 
  </div>
  <div id='content-main' class="content-container content-width">
    <?php echo $this->fetch('content'); ?>
  </div>

  <div class="footer content-width">
    &copy; 2012 Good Measure Meals
    <br><br>
<?php if(isset($_SESSION['nojs']) && $_SESSION['nojs'] == '1') { ?>
    <a href="/js.php" class="nojs">Turn javascript back on</a>
<?php } else { ?>
    <a href="/nojs.php" class="nojs">Click here to turn off Javascript if you're having trouble viewing the site</a>
<?php } ?>
  </div>
</body>                                                                          
</html>  
