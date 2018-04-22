/* modal */

$( document ).ready(function() {
    $('.modal-close').click(function() {
		closeModal();
	});
});

function closeModal(reload) {
	$('#modal').hide();
	$('.modal-overlay').hide();
	if(reload) window.location.reload();
}
function showModal(data) {
	$('#modal .modal-body').html(data);
	$('#modal').show();
	$('.modal-overlay').show();
}

function modal(path,params) {
	$.post(path, params)
	.done(function( data ) {
		showModal(data)
	});
}

function eModal(el) {
	var data = $(el).html();
	showModal(data)
}


/* tab */
$( document ).ready(function() {
	$('.tab').hide();
    $('.tabSelect').each(function( index ) {
		$(this).click(function(){
			tabSelect($(this).attr('id'));
		});
	});
});

function tabSelect(id) { console.log(id);
	$('.tabSelect').removeClass('active');
	$('#' + id).addClass('active');
	$('.tab').hide();
	$('#' + id + '_tab').show();
}

function widgetTabSelect(widget,key) {
	$('.widget_tab_choise_' + widget).val(key);
	$('fieldset').hide();
	$('.fieldset_' + key).show();

}