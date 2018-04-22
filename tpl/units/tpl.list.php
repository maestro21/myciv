<?php $selectlist = (bool)(@$post['mode'] == 'selectFile');?>
<?php if (!$selectlist) { ?>
    <h1><?php echo $title;?>
        <?php echo drawBtns($buttons['admin']);?></h1>

<?php } ?>
<div class="wrap-galleries">
    <?php if($data) {
        foreach ($data as $id => $unit) {
            ?>
            <div data-id="<?php echo $id; ?>" class="photothumb" style="background-image:url('<?php echo BASEFMURL . $unit['img']['name'];?>')"
                 data-src="<?php echo BASEFMURL . $unit['img']['name'];?>">
                <?php if (!$selectlist) { ?>
                    <a href="javascript:void(0)"
                       onclick="conf('<?php echo BASE_URL . $class; ?>/del/<?php echo $id; ?>', '<?php echo T('del conf'); ?>')"
                       class="fa-trash-o fa icon icon_sml tlcorner"></a>
                    <a href="<?php echo BASE_URL . $class; ?>/edit/<?php echo $id; ?>" target="_blank" class="fa-pencil fa icon icon_sml tlcorner"></a>
                <?php } ?>
                <input readonly class="galedit"  value="<?php echo $unit['name']; ?>">
            </div>
        <?php }
    } else { echo T('no units added'); } ?>

</div>

