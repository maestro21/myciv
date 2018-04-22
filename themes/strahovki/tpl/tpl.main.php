<!DOCTYPE HTML>
<html>
	<head>
		<?php echo tpl('header', array('class' => $class)); ?>
	</head>
	<body<?php if(superAdmin()) echo ' class="admin"';?>>
	<?php if(superAdmin()) echo tpl('adminpanel'); ?>
	<div class="page-wrapper">
		<div class="header">
			<div class="menu wrap">
				
				<div class="logo">
					<img src="<?php echo PUB_URL ?>img/logo.png" height="50">
				</div>
				<div class="dropdownmenu">
					<ul class="topmenu">
						<?php echo menu(); ?>
					
					<span class="phone"><i class="fa-phone fa"> <b>+</b></i>41 787 67 27 09</span>
					</ul>
				</div>
				
				<?php echo langs(); ?>
			</div>
		</div>

		<div class="main <?php echo (first()?'first':'wrap');?>">
			<?php echo $content; ?>
			<a class="contact-us" href="<?php echo PUB_URL . getLang(); ?>/contacts"><i class="fa fa-envelope-o"></i><?php echo T('contact us');?></a>
		</div>
	</div>
	<div class="footer">
		<div class="wrapper">
			&copy; <?=date('Y');?> <?=T('copyright');?>  <span class="right"> <?=T('Design');?> Maestro Studio</span>
		</div>
	</div>
	</body>
</html>	