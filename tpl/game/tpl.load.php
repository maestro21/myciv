<h2><?php echo T('load game');?></h2>
<div class="games">
<?php foreach($games as $game) { ?>
<a href="<?php echo BASE_URL . 'game/play/' . $game['id'];?>"><?php echo T('game') . ' #' . $game['id'];?></a>
<?php } ?></div>