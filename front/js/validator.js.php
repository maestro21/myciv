<?php if(!Hget('validate')) die(); ?>

(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "jquery.validate"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: RU (Russian; ������� ����)
 */
$.extend( $.validator.messages, {
	phone: "����������, ������� ���������� ����� ��������",
	required: "����������, ��������� ��� ����",
	remote: "����������, ������� ���������� ��������.",
	email: "����������, ������� ���������� ����� ����������� �����.",
	url: "����������, ������� ���������� URL.",
	date: "����������, ������� ���������� ����.",
	dateISO: "����������, ������� ���������� ���� � ������� ISO.",
	number: "����������, ������� �����.",
	digits: "����������, ������� ������ �����.",
	creditcard: "����������, ������� ���������� ����� ��������� �����.",
	equalTo: "����������, ������� ����� �� �������� ��� ���.",
	extension: "����������, �������� ���� � ���������� �����������.",
	maxlength: $.validator.format( "����������, ������� �� ������ {0} ��������." ),
	minlength: $.validator.format( "����������, ������� �� ������ {0} ��������." ),
	rangelength: $.validator.format( "����������, ������� �������� ������ �� {0} �� {1} ��������." ),
	range: $.validator.format( "����������, ������� ����� �� {0} �� {1}." ),
	max: $.validator.format( "����������, ������� �����, ������� ��� ������{0}." ),
	min: $.validator.format( "����������, ������� �����, ������� ��� ������ {0}." )
} );

}));


$().ready(function() {
	
	$.validator.addMethod('phone', function (value, element) {
		return this.optional(element) || /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(value);
	});
});

function bindvalidate(selector) {
	$(selector).validate({
		
		rules: {			
            phone: {
				required: true,
				phone: true
			},
        },
		
		submitHandler: function(form) {
			$('#errorMsg').hide();
			$('#saveMsg').show(500);
			setTimeout(function() {	$('#saveMsg').hide() }, 3000);
			$.post( $(selector).attr( "action" ), $(selector).serialize(), function(data) {
				$('#saveMsg').show(500);
				setTimeout(function() {	$('#saveMsg').hide() }, 5000);
			}, "json");
		},
		
		invalidHandler: function(event, validator) {
			$('#errorMsg').show(500);
		}
		
	});
}
