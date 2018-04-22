<div class="dropdownmenu">		
    <ul>
         <li>
            <a href="<?php echo BASE_URL;?>modules/admin">Modules</a>
            <?php $modules = cache('modules'); 
            if($modules) {?>
                <ul>
                    <?php foreach($modules as $module) { 
                        if($module['status'] > 1) {?>
                        <li><a href="<?php echo BASE_URL . $module['name'];?>/admin"><?php echo T($module['name']);?></a></li>
                    <?php } 
                    }?>	
                </ul>
            <?php } ?>
        </li>		
    </ul>
</div>
<div class="logout">
    <a href="<?php echo BASE_URL;?>system/logout"><?php echo T('logout');?></a>
</div>
