<h1><?php echo $title;?>
	<?php echo drawBtns($buttons['admin'],$class);?></h1>

<div>
<?php if($data)
    foreach ($data as $id => $item) {
	?>
	<div data-id="<?php echo $id;?>" class="photothumb" <?php echo img2($id,$item['cover'], true);?>>
		<div class="tlcorner">
			<a href="<?php echo BASE_URL.$class;?>/edit/<?php echo $id;?>" target="_blank" class="fa-pencil fa icon icon_sml"></a>
			<a href="javascript:void(0)" onclick="conf('<?php echo BASE_URL.$class;?>/del/<?php echo $id;?>', '<?php echo T('del conf');?>')" class="fa-trash-o fa icon icon_sml "></a>
		</div>
		<input name="name-<?php echo $id;?>" class="galedit" type="text" value="<?php echo $item['name']; ?>">

	</div>
<?php } else echo T('no galleries'); ?>

</div>
<script>
$('.photothumb').each(function(index) {
	$(this).click(function() {
		window.location = '<?php echo BASE_URL.$class;?>/view/' + $(this).data("id");
	});
});
</script>
