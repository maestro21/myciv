<h1>Units
    <i class="fa fa-plus icon file addunit"></i>
</h1>
<div class="rulset-units wrap-galleries"></div>

<script>
    var units = <?php echo json_encode(cache('units'));?>;
    var rulesetUnits = <?php echo json_encode(@$data['units']);?>;

    function addUnit(uid) {
        var unit = units[uid];
        $('<div>')
            .addClass('photothumb')
            .css('background-image', "url('<?php echo BASEFMURL;?>" + unit.img.name + "')")
            .html(
                '<a href="javascript:void(0)" class="fa-trash-o fa icon icon_sml tlcorner delunit"></a>' +
                '<a href="javascript:void(0)" class="fa-pencil fa icon icon_sml tlcorner editunit"></a> ' +
                '<input readonly class="galedit"  value="' + unit.name  + '">' +
                '<input name="form[data][units][]" type="hidden" value="' + uid + '">'
            )
            .appendTo('.rulset-units.wrap-galleries');
    }

    function drawUnits() {
        $('.rulset-units.wrap-galleries').html('');
        if($.isArray(rulesetUnits)) {
            for (var i in rulesetUnits) {
                addUnit(rulesetUnits[i]);
            }
        } else {
            rulesetUnits = [];
        }
    }
    drawUnits();

    $('.addunit').click(function() {
        $.when( selectFile('units/list') ).then(function( data, textStatus, jqXHR ) {
            setTimeout(function() {
                $('.photothumb').click(function() {
                    rulesetUnits.push($(this).data('id'));
                    drawUnits();
                });
            },100);
        });
    });

</script>