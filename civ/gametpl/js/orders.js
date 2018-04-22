$(function(){
    $('html').keydown(function(e){

        console.log(e.which);

        // unit orders
        if(unit) {
            switch(e.which){
                case 104:
                case 38:
                    unit_move('top');
                    break;
                        
                case 98:
                case 40:
                    unit_move('bottom');
                    break;
                
                case 100:
                case 37:
                    unit_move('left');
                    break;
                    
                    
                case 102:
                case 39:
                    unit_move('right');
                    break;

                case 36:
                case 103: unit_move('topleft'); break;

                case 33:
                case 105: unit_move('topright'); break;

                case 35:
                case 97: unit_move('bottomleft'); break;

                case 34:
                case 99: unit_move('bottomright'); break;
            }       
        }
    });
});