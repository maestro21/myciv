<h1><?php echo $title;?></h1>
<?php $formid = $class . '_form_item_' . $id;?>
<form method="POST" id="form" class="content" enctype='multipart/form-data' action="<?php echo BASE_URL . $class;?>/save?ajax=1">
<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
	<table cellpadding=0 cellspacing=0>
		<?php
			echo drawForm([
				'fields' => [
					'name' => $fields['name']
				],
				'data' => [
					'name' => $data['name']
				]
			]);
		?>
	</table>
	<br />

	<?php if($id > 0) {

		$data = unserialize($data['data']);
		$tabs = [
			'general',
            'religion',
			'resources',
			'terrain',
            'goodies',
			'improvements',
			'cities',
			'units',
            // 'tech',
			// 'buildings',
			// 'wonders',
		];
		?>
		<div class="leftMenu td">
			<?php foreach($tabs as $tab) { ?>
				<div class="tabSelect" id="<?php echo $tab;?>"><?php echo T($tab);?></div>
			<?php } ?>
		</div>
		<div class="td">
			<?php foreach($tabs as $tab) { ?>
				<div class="tab" id="<?php echo $tab;?>_tab">
					<?php include('tpl.' . $tab . '.php'); ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="center">
		<div class="btn submit"><?php echo T('save');?></div>
		<div class="messages"></div>
	</div>
</form>

<script src="<?php echo BASE_URL;?>external/savectrls.js" type="text/javascript"></script>
<script> $( document ).ready(function() { setTimeout(function(){tabSelect('general') }, 100); }); </script>
