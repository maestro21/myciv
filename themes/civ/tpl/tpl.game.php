<div class="dropdownmenu">		
    <ul>
        <li>
            <a href="#">Game</a>
            <ul>
                <?php $options = ['create', 'load']; ?>
                <?php foreach($options as $option) { ?>
                <li><a href="<?php echo BASE_URL . 'game/' . $option;?>"><?php echo T($option);?></a> </li>                               
                <?php } ?>
                <?php if(superAdmin()) { ?>
                    <li><a class="editor">Editor</a>
                    <li><a class="savemap">Save map</a>
                <?php } ?>
            </ul>
        </li>    
    </ul>
</div>    

