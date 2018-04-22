<?php $icons = [
        'cancel' => 'times',
        'terrain' => 'globe',
        'river' => 'stumbleupon',
        'goodies' => 'diamond',
        'startlocations' => 'arrows',
        'players' => 'user',
        'owner' => 'flag',
        'cities' => 'hospital-o',
        'improvements' => 'home',
        'units' => 'male',
    ]; ?>

<div class="editpanel gamebg">&nbsp;&nbsp;&nbsp;Editor 
    <?php foreach($icons as $url => $icon) { ?>
        <div data-section="<?php echo $url;?>" class="fa fa-<?php echo $icon . ' ' . $url;?>" title="<?php echo T($url);?>"></div>
    <?php } ?>
</div>

<div class="editsections">
    <section id="terrain"></section>


    <section id="startlocation">
        <h2>Edit start location</h2>
        <?php echo T('Write down list of civs that should start here. Leave blank for all civs');?>
        <input name="startlocationcivs" class="startlocationcivs"></input>
        <div class="btn" onclick="setStartLocation(this)">Save</div>
    </section>
    
    <section id="players">
        <form id="editplayersform">
            <input type="hidden" name="class" value="players">
            <input type="hidden" name="do" value="savePlayers">
            <input type="hidden" name="gid" value="<?php echo $gid;?>">
        <?php echo drawForm(
                [ 
                    'fields' => [                  
                        'players' => [
                            DB_ARRAY, WIDGET_TABLE,
                            'children' => [
                                'control' => [
                                    DB_INT, WIDGET_SELECT, 'options' => ['player', 'ai' ],
                                ],
                                'civ' => [
                                    DB_INT, WIDGET_SELECT, 'options' => cache('civlist'),
                                ],
                                'country' => [
                                    DB_INT, WIDGET_SELECT,
                                ],
                                'age' => [
                                    DB_INT, WIDGET_SELECT, 'options' => $ruleset['ages'],
                                ],
                                'color' => [DB_STRING, WIDGET_COLOR],
                                'takePlayer'  => [DB_VOID, WIDGET_BTN]
                            ],
                            // here add logic button take
                        ]
                    ],
                    'data' => [
                        'players' => $game['players']
                    ],
                ]); ?>
        </form>    
        <div class="btn" onclick="savePlayers()">Save</div>
    </section>

    <section id="cities">
        <form id="editcitiesform">
            <input type="hidden" name="x">
            <input type="hidden" name="y">
            <input type="hidden" name="class" value="city">
            <input type="hidden" name="data[action]" value="">
            <input type="hidden" name="do" value="postCity">
            <input type="hidden" name="gid" value="<?php echo $gid;?>">
            <?php echo drawForm(
                [
                    'fields' => [
                        'owner' => [ DB_INT, WIDGET_SELECT, 'options'], //to be replaced on player select
                        'pop' => [ DB_INT, WIDGET_NUMBER ],
                        'name' => [DB_TEXT, WIDGET_TEXT]
                    ],
                ]); ?>
        </form>
        <div class="btn" onclick="saveCity()">Save</div>
    </section>

    
    <section id="improvements"></section>
    <section id="goodies"></section>
    <section id="units"></section>
</div>





<script>

    function takePlayer(obj) {
       player = $(obj).closest('div.tr').data('rowid');
       updatePlayerInfo();
    }

    function setStartLocation(val) {
        editdata = $(val).parent().find('.startlocationcivs').val();
        callEdit();
    }

    function savePlayers() {
        var data = $('.modal-body #editplayersform').find('input, select, textarea').not('[name*="{key}"]').serialize();
        $.ajax({
            url: gameurl,
            data: data,
            'method': 'POST'
        });
    }

    function saveCity() {
        $('.modal-body #editcitiesform input[name=x]').val(cursorX);
        $('.modal-body #editcitiesform input[name=y]').val(cursorY);
        var data = $('.modal-body #editcitiesform').find('input, select, textarea').not('[name*="{key}"]').serialize();
        $.ajax({
            url: gameurl,
            data: data,
            'method': 'POST'
        }).done(render)
    }

    function setCityInfo() {
        $('.modal-body #formowner').val(city.owner);
        $('.modal-body #formname').val(city.name);
        $('.modal-body #formpop').val(city.pop);
    }


    $(function() {

        
        // terrain
        for (var i in conf.terrain) {
            var terrain = conf.terrain[i];
            $('section#terrain').append(
              '<img onclick=setEditTerrain(this) title="' + terrain.name + '" src="' + images[terrain.img] + '" class="edit-terrain" data-name="' + i + '">'
            );
        }
        $('section#terrain').append('<img onclick=setEditTerrain(this) title="water" src="' + images[conf.water] + '" class="edit-terrain" data-name=" ">');
        $('.editpanel .terrain').click(function(){ showModal($('#terrain').html()); });
        
        // river
        $('.editpanel .river').click(function(){
            var r = null;
            if($(this).hasClass('del')) {
                $(this).removeClass('del');
                $(this).removeClass('active');
                r = null;
            } else if($(this).hasClass('active')) {
                $(this).addClass('del');
                r = ' ';
            } else {
                $(this).addClass('active');
                r = 'r';
            }
            if(r) {
                setCall('map','putRiver', images[conf.river], r);
            } else {
                cancelEdit();
            }
        });

        // owner
        $('.editpanel .owner').click(function(){
            var o = null;
            if($(this).hasClass('del')) {
                $(this).removeClass('del');
                $(this).removeClass('active');
                o = null;
            } else if($(this).hasClass('active')) {
                $(this).addClass('del');
                o = ' ';
            } else {
                $(this).addClass('active');
                o = player - 1;
            }
            if(o != null) {
                setCall('map','setOwner', images[conf.startlocation], o);
            } else {
                cancelEdit();
            }
        });

        // startlocation
        $('.editpanel .startlocations').click(function(){
            var l = null;
            if($(this).hasClass('del')) {
                $(this).removeClass('del');
                $(this).removeClass('active');
                l = null;
            } else if($(this).hasClass('active')) {
                $(this).addClass('del');
                l = 'del';
            } else {
                $(this).addClass('active');
                l = 'put';
            }
            if(l) {
                setCall('map','changeStartLocation', images[conf.startlocation], l);
            } else {
                cancelEdit();
            }
        });

   
        
        // countries
        function civCountryDropdown(civselect) {
            var civid = $(civselect).val();
            $(civselect).closest('.tr').find('.select.country').html('');
            for (var i in countries[civid]) {
                var country = countries[civid][i];
                var govid = country.gov;
                var title = '[' + gov[govid].name + '] ' + country.name;
                $(civselect).closest('.tr').find('.select.country').append('<option value="' + i + '">' + title + '</option>');
            }
        }    
        $('.editpanel .players').click(function(){ 
            $('.select.civ').each(function() {
                civCountryDropdown(this);
                var id = $(this).closest('.tr').data('rowid');
                if(id) {
                    var countryId = game.players[id].country;
                    $(this).closest('.tr').find('.select.country option[value=' + countryId +']').attr('selected','selected');
                }
            });
            showModal($('#players').html()); 
        });
        $('.tbl-players').bind("DOMSubtreeModified",function(){
            $(document).on('change', '.select.civ', function() {
                civCountryDropdown(this)
            });            
        });

        // cities
        $('.editpanel .cities').click(function(){
            var r = null;
            if($(this).hasClass('del')) {
                $(this).removeClass('del');
                $(this).removeClass('active');
                r = null;
            } else if($(this).hasClass('active')) {
                $(this).addClass('del');
                r = 'del';
            } else {
                $(this).addClass('active');
                r = 'put';
            }
            if(r) {
                setCall('city','postCity', images[conf.startlocation], {'action':r, 'player':player});
            } else {
                cancelEdit();
            }
        });
        
        // improvements
        for (var i in conf.roads) {
            var road = conf.roads[i];
            $('section#improvements').append(
              '<img onclick=setEditRoad(this) title="' + road.name + '" src="' + thumbs[road.img] + '" class="edit-road" data-name="' + i + '">'
            );
        }    
        for (var i in conf.improvements) {
            var imp = conf.improvements[i];
            $('section#improvements').append(
              '<img onclick=setEditImp(this) title="' + imp.name + '" src="' + thumbs[imp.img] + '" class="edit-imp" data-name="' + i + '">'
            );
        }  
        $('.editpanel .improvements').click(function(){ showModal($('#improvements').html()); });


        // goodies
        for (var i in conf.goodies) {
            var goody = conf.goodies[i];
            $('section#goodies').append(
              '<img onclick=setEditGoody(this) title="' + goody.name + '" src="' + images[goody.img] + '" class="edit-terrain" data-name="' + goody.char + '">'
            );
        }  $('.editpanel .goodies').click(function(){ showModal($('#goodies').html()); });

        // units
        for (var i in conf.units) {
            var uid = conf.units[i];
            unit = unitgallery[uid];
            $('section#units').append(
                '<img onclick=setEditUnit(this) title="' + unit.name + '" src="<?php echo BASEFMURL;?>' + unit.img.name  + '" class="edit-unit" data-id="' + i + '">'
            );
        }  $('.editpanel .units').click(function(){ showModal($('#units').html()); });

        // general        
        $('.editpanel .cancel').click(function(){ cancelEdit(); }); 
    });
    
    function cancelEdit() {
        editclass = null;
        editfunction = null;
        editmode = false;
        delCursorAnimation();
        $('.editpanel div').removeClass('active').removeClass('del');
    }
    
    function startEdit(mod, funct) {
        editclass = mod;
        editfunction = funct;
        editmode = true; 
    }
    
    
    function setCall(cl, fn, cursor, data) {
        startEdit(cl, fn);
        cursoranimation = cursor;
        setCursorAnimation();
        editdata = data;      
    }
    
    function setEditTerrain(obj) {
        setCall('map', 'putTerrain', $(obj).attr('src'),{
          terrain: $(obj).data('name')
        });
        $('.modal-close').click();
    };
    
    function setEditGoody(obj) {
        setCall('map', 'putGoody', $(obj).attr('src'),{
          goody: $(obj).data('name')
        });
        $('.modal-close').click();
    };

    function setEditUnit(obj) {
        setCall('units', 'putUnit', $(obj).attr('src'),{
            id: $(obj).data('id'),
            owner: player
        });
        $('.modal-close').click();
    };
    
    function setEditRoad(obj) {
        setCall('map', 'putRoad', $(obj).attr('src'),{
          road: $(obj).data('name')
        });
        $('.modal-close').click();
    }
    function setEditImp(obj) {
        setCall('map', 'putImprovement', $(obj).attr('src'),{
          improvement: $(obj).data('name')
        });
        $('.modal-close').click();
    }

    // Fires when you click on cursor; usually to enter and edit stuff
    function clickCursor() {
        if(editmode) {
            switch (editfunction) {
                case 'changeStartLocation':
                    if(currentTile.startlocation) {
                        if($('.editpanel .startlocations').hasClass('del')) {
                            editdata = 'del';
                            callEdit();
                        } else {
                            showModal($('#startlocation').html());                        
                            $('.startlocationcivs').val(currentTile.startlocation.join(','));
                        }
                        return;
                    }
                    break;

                case 'postCity':
                        if(game.cities[cursorX+'_'+cursorY]) {
                            if(editdata.action == 'del') {
                                callEdit(); 
                            } else {
                            
                                showModal($('#cities').html());
                                playerDropdown($('.modal-body #formowner'));                            
                                setCityInfo();
                            }
                            return;
                        }
                    break;
            }
            callEdit();
        }
    }
    
    function rightClickCursor() {
        console.log(editmode);
        if(editmode) {
            switch (editfunction) {
                case 'putUnit':
                    editdata = 'del';
                    callEdit();
                break;
            }
        }
    }

    function callEdit() {
        if(editmode) {
            $.post(gameurl, {
                'class': editclass,
                'do': editfunction,
                'gid': gid,
                'data': editdata,
                'x': cursorX,
                'y': cursorY
            }).done(render);
        }  
    }
    
</script>