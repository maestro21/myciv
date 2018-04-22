<div id="menu">
	<div class="mapeditor">
		<div class="menuitem">
			<a href="javascript:void(0);" onclick="$('#edit_cursor_dropdown').toggle();">
				<SPAN id="editor_cursor">Cursor</span>
			</a>
			<div class="dropdown" id="edit_cursor_dropdown">
				<a href="javascript:void(0);" onclick="clearEditCursor()">Cursor</a>
				<?php $terrain = conf('terrain'); 
				foreach ($terrain as $k => $v) { ?>
					<a href="javascript:void(0);" onclick="setEditCursor('setTerrain', '<?php echo $k; ?>', '<?php echo $v; ?>')"><?php echo $v; ?></a>
				<? } ?>
				<a href="javascript:void(0);"  onclick="setEditCursor('setRiver', 'r', 'River')">River</a>
				<a href="javascript:void(0);"  onclick="setEditCursor('setRiver', ' ', 'Clear river')">Clear river</a>
			</div>
		</div>
	</div>

</div>

<script language="javascript">


</script>



<div id="debug"></div>