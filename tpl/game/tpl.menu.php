<div class="game_menu">
  <?php $options = ['create', 'load']; 
    foreach($options as $option) { ?>
    <a href="<?php echo BASE_URL . 'game/' . $option;?>"><?php echo T($option . ' game');?></a>
    <?php }
  ?>
</div>