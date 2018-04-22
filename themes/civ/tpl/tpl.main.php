<!DOCTYPE HTML>
<html  class="<?php echo $class->className;?>">
	<head>
		<?php echo tpl('header', array('class' => $class)); ?>
	</head>
	<body<?php if(superAdmin()) echo ' class="admin"';?>>
	
	<div class="page-wrapper">
		<div class="header">
			<div class="menu wrap">				
				<div class="logo">
                    <a href="<?php echo BASE_URL;?>"><img src="<?php echo BASE_URL . tpath(); ?>img/logo.png" height="50"></a>
				</div>
                <?php echo tpl('game');?>
				<?php if(superAdmin()) echo tpl('adminpanel');  else { ?>
                    <div class="login">
                        <a href="<?php echo BASE_URL;?>adm"><?php echo T('login');?></a>
                    </div>    
                <?php } ?>    
				<div class="langs">
					<?php echo langs(); ?>
				</div>
			</div>
		</div>

		
		<div class="content">
			<div class="wrap wrap-<?php echo $class->className .  ' ' . $class->tpl;?>">
				<?php echo $content;?>		
			</div>		
		</div>
		
		<div class="page-buffer"></div>
	</div>	
			
			
	<div class="footer">
		<div class="wrap">
			<?php echo tpl('footer'); ?>
		</div>	
	</div>

	<div class="modal-overlay"></div>	
	<section id="modal" class="modal">
		<div class="fa fa-times icon icon-big modal-close"></div>
		<div class="modal-body">	
		</div>
	</section>
		
		
	</body>
</html>
