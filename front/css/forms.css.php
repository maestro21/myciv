/** Forms **/
select,
input,
.table div.td select,
.table div.td input {
	width: 250px;
	padding: 8px;
	border-radius: 3px;
	box-sizing: border-box;
	border: 1px <?php echo $mainColor; ?> solid;
}

textarea {
	border-radius: 3px;
	width: auto;
	min-width: 1200px !important;
	border: 1px <?php echo $mainColor; ?> solid;	
}

textarea.list {
    min-width: 200px !important;
    width: 200px !important;
    height:500px;
    display:none;
    position: absolute;
}

.form sup {
	font-size: 14px;
	font-weight: 900;
	color: <?php echo $mainColor; ?>;
}

i.file {
	cursor: pointer;
}

input[type="file"] {
	display: none;
}

input[type="checkbox"] + label:before {
    content: '';
    background: #fff;
    border: 1px solid <?php echo $mainColor; ?>;
    display: inline-block;
    vertical-align: middle;
    width: 22px;
    height: 22px;
    padding: 2px;
    margin: 10px;
    text-align: center;
    line-height: 15px;
    font-size: 15px;
    border-radius: 3px;
    margin-left: 0;
    margin-top: 8px;
}

.mce-tinymce {
	border: 1px <?php echo $mainColor; ?> solid !important;
	border-radius: 3px;
	width: 1200px !important;
}
.hidden {
  visibility: hidden !important;
  display: none !important;
}

.visible {
  visibility: visible !important;
  display: block !important;
}


input[type="checkbox"] {
    display: none;
}

input[type="checkbox"]:checked + label:before {
    content: "\f00c";
	font-family: 'FontAwesome';
}

input[type="checkbox"] + label:before {
	cursor: pointer;
}

input[type="text"].char {
	width: 30px !important;
}

.jscolor {
	width: 100px !important;
}

form sup {
    font-size: 14px;
    font-weight: 900;
    color: <?php echo $mainColor2; ?>;
}

.messages .message {
	display: inline-block;
	margin: 20px;
	border: 1px <?php echo $mainColor; ?> solid;
	padding: 10px;
	width: 300px;
}


.leftMenu {
	width: 200px;
	border-right: 1px <?php echo $mainColor; ?> solid;
	vertical-align: top !important;
}

.tabSelect {
	 color: <?php echo $mainColor2; ?>;	
	 font-weight:bold;
	 cursor:pointer;
	 text-decoration: none;
	 padding: 10px;
	 font-size: 20px;
}
.tabSelect.active,
.tabSelect:hover {
	color: <?php echo $bgColor; ?>;
	background-color: <?php echo $mainColor; ?>;
}

.lbl {
	width: 160px;
	text-align: right;
}

.colorbox {
	width: 30px;
	height: 30px;
}

.table .td.small input {
	width: 100px;
}