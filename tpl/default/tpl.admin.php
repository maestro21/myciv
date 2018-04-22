<br> 
<h1><?php echo $title;?>
<?php echo drawBtns($buttons['admin'], $class);?></h1>
<?php if($data) { ?>
<table cellpadding=0 cellspacing=0>
	<thead>
	<tr>
		<td>
		<a href="<?php echo BASE_URL.$class;?>filter/sort_<?php echo $class;?>/<?php echo 'id_'.getFilterState($class,'id');?>">id</a><?php echo filterImg($class,'id');?>
		</td>
		<?php foreach ($fields as $k=>$v){
			if(isset($v['table']) && !$v['table']) continue;?>
			<td><a href="<?php echo BASE_URL.$class;?>filter/sort_<?php echo $class;?>/<?php echo $k.'_'.getFilterState($class,$k);?>"><?php echo T($k);?></a><?php echo filterImg($class,$k);?></td>
		<?php }?>
		<td><?php echo T('options');?></td>
	</tr>
	</thead>
	<?php  
        foreach (@$data as $k => $row){
        if(empty($row['id'])) {
            $id = $k; 
        } else {
            $id = $row['id']; unset($row['id']); 
        }?>
		<tr>
		<td>
			<a href="<?php echo BASE_URL.$class;?>/view/<?php echo $id;?>" target="_blank">#<?php echo $id;?></a>
		</td>
		<?php 
		foreach($fields as $field => $f){
			if(isset($f['table']) && !$f['table']) continue;
			$k = $field; $v = $row[$field];
			echo "<td>".fType($v, $f[1], @$options[$k])."</td>";	
		}?>
		<td width=150>
			<a href="<?php echo BASE_URL.$class;?>/edit/<?php echo $id;?>" target="_blank" class="fa-pencil fa icon icon_sml"></a>
			<a href="javascript:void(0)" onclick="conf('<?php echo BASE_URL.$class;?>/del/<?php echo $id;?>', '<?php echo T('del conf');?>')" class="fa-trash-o fa icon icon_sml"></a>	
		</td>
		</tr>		
	<?php }  ?> 
</table>
<?php } else { ?>
<div><?php echo T('no data');?></div>
<?php } ?>
