<!-- META stuff -->
<title><?php echo ($class->title!=''?strip_tags($class->title) . ' - ' : '') . T('sitename');?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="<?php echo BASE_URL . UPLOADS_FOLDER;?>favicon.ico?erg" rel="icon" type="image/x-icon" />


<!-- CSS -->
<LINK REL="StyleSheet" HREF="<?php echo PUB_URL;?>style.php" TYPE="text/css" MEDIA="screen">
<link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">
<link rel="stylesheet" href="<?php echo BASE_URL . EXT_FOLDER;?>slider/simple-slideshow-styles.css">

<!-- JS -->
<script src="<?php echo BASE_URL . EXT_FOLDER;?>jquery-latest.min.js" type="text/javascript"></script>
<script src="<?php echo PUB_URL;?>script.php?lang=<?php echo getLang();?>" type="text/javascript"></script>
<script src="<?php echo BASE_URL . EXT_FOLDER;?>validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL . EXT_FOLDER;?>validate/messages_<?php echo getLang();?>.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL . EXT_FOLDER;?>tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL . EXT_FOLDER;?>dropzone/dropzone.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL . EXT_FOLDER;?>slider/better-simple-slideshow.min.js"></script>


