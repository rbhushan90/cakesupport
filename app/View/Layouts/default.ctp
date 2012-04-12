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
<?php if(!$this->request->is('ajax')) { ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php

    # The two I'm using
    echo $this->Html->css('bootstrap.min');                                             
    echo $this->Html->css('gmm');                                             

    echo $this->Html->script('jquery');
    echo $this->Html->script('jquery.animate-colors');
    echo $this->Html->script('gmm');
                                                                                 
    echo $this->fetch('meta');                                                   
    echo $this->fetch('css');                                                    
    echo $this->fetch('script');                                                 
  ?>                                                                             
</head>
<body>
  <div id="header-container">
    <div id="header" class="content-width">
      <h1><a href="/"><img src="/img/gmm_logo.png"></a></h1>
      <div id="menu" class="menu">
      <?php echo $this->element('navigation'); ?>
      </div>
    </div>
  </div>

  <div id='content-main' class="content-container content-width">
    <?php echo $this->Session->flash(); ?> 
    <?php echo $this->fetch('content'); ?>
  </div>

  <div class="footer content-width">
    Footer Stuff Goes Here &copy; Since The Big Bang
  </div>
</body>                                                                          
</html>  
<?php
  } else if(!strcasecmp($_SERVER['REQUEST_URI'], '/header')) {
    $this->header('HTTP/1.1 200 OK');
    echo $this->element('navigation');
  } else {
    echo $this->Session->flash();
    echo $this->fetch('content');
  }
?>
