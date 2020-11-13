<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
	<head>
		<title>
			<?php __('Magazine:'); ?>
			<?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $this->Html->charset();
			echo $this->Html->meta('icon');
			echo $this->Html->css('default');
			echo $this->Html->css('bootstrap/bootstrap.min');
			echo $this->Html->css('bootstrap/bootstrap-responsive.min');
			echo $this->Html->script('bootstrap/bootstrap.min');
			echo $this->Html->script('jquery-1.9.0.min');
			echo $this->Html->script('bootstrap/bootstrap-affix');			
			echo $scripts_for_layout;
		?>
		<script type="text/javascript">
        	var baseUrl = '<?php echo $this->base; ?>';
		</script>
		<style type="text/css">
		body { background-color: #6A6A6A; /* #404040 */	}
		#footer { 
			background-color: white;	/* #333333 */
			box-shadow: 0 0px 15px #6A6A6A;
			color: black;
			height: 150px
		}			
		.navbar-fixed-top .navbar-inner { padding: 0px 40px 0px 20px;}
		form .input { margin-right: 20px;}		
		form .input textarea { width: auto;}
		.table-hover tbody tr:hover > td,
		.table-hover tbody tr:hover > th {
		  background-color: #FFFFFF;
		}
		</style>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<?php echo $this->element('menu'); ?>
			</div>
			<div id="content" class="container-fluid">				

				<?php echo $content_for_layout; ?>

			</div>
			<div id="footer" class="lat_padding ">
			<?php echo $html->image('sep.jpg',array('class'=>'pull-right', 'style'=>'max-height: 125px; width: auto;'));?>
			<?php echo $html->image('ceprobi1.jpg',array('style'=>'max-height: 80px; width: auto;'));?>
			<?php echo $html->image('ipn.png',array('style'=>'max-height:110px; width:auto; opacity:0.4; margin-top:20px;'));?>
			</div>
		</div>
		<?php echo $this->element('sql_dump'); ?>
		<?php $dontAccess = 'Ud no puede estar en este sitio' ?>
	</body>
</html>