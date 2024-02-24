//####################################################################
//               BLACK FAKE FILE
// -----------------------------------------------------------------
//     Created by: BlackHeart-frt
//     date:       08-april-2021
//     email:      blackheart.frt@gmail.com
// -----------------------------------------------------------------
//
//              SETTINGS
// -----------------------------------------------------------------
//      showIcon:   {boolean}{default true}
//
//              HTML BASE
// -----------------------------------------------------------------
//      <div>
//          <span data-blackFakeFile-filename>Anexo Currículo</span>          
//          <input type="file" name="" id="">                                    
//      </div>
//####################################################################
(function($){
    $.fn.blackFakeFile = function(options){
        let     settings        =   $.extend({
            showIcon:   true
        },options);

        let     fileElement     =   $(this).find('input[type=file]');
        let     fileNameElement =   $(this).find('[data-blackFakeFile-filename]');
        let     fileButton      =   $(this).find('[data-blackFakeFile-button]');

        //set css style for $(this)
        $(this).css({
            position:       'relative',
	        flex:           'auto',
	        justifyContent: 'flex-start',
	        alignItems:     'center',
	        display:        'flex'
        });

        //set css style for fileElement
        $(fileElement).css({
            position:   'absolute',
	        top:        '0',
	        left:       '0',
	        width:      '100%',
	        height:     '100%',
	        opacity:    '0',
	        cursor:     'pointer',
	        zIndex:     '100'
        });

        //add icon
        if(settings.showIcon === true){
            $(this).append('<svg class="blackFakeFile-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"><g transform="translate(-1293 -830)"><g transform="translate(1293 830)" fill="#707070" stroke="#707070" stroke-width="1"><circle cx="12.5" cy="12.5" r="12.5" stroke="none"/><circle cx="12.5" cy="12.5" r="12" fill="none"/></g><g transform="translate(1300.555 813.193)"><g transform="translate(0 23.936)"><path d="M9.934,24.891a3.258,3.258,0,0,0-4.61,0L.743,29.473a2.54,2.54,0,0,0,3.592,3.592l4.582-4.582a1.82,1.82,0,0,0-2.573-2.573L2.435,29.817a.38.38,0,1,0,.537.537L6.88,26.447a1.06,1.06,0,1,1,1.5,1.5L3.8,32.527A1.78,1.78,0,0,1,1.28,30.01l4.582-4.582A2.5,2.5,0,1,1,9.4,28.964L7.361,31a.38.38,0,1,0,.537.537L9.934,29.5A3.258,3.258,0,0,0,9.934,24.891Z" transform="translate(0 -23.936)" fill="#fff"/></g></g></g></svg>');
            $('.blackFakeFile-icon').css({
                position:   'absolute',
                top:        '50%',
                left:       'auto',
                minWidth:   '28px',
                minHeight:  '28px',
                right:      '1rem',
                transform:  'translateY(-50%)',
                display:    'block'
            });
        };

        //set filename to fileNameElement
        $(fileElement).on('change', function(){
            let fileName    =   $(fileElement).val();
            $(fileNameElement).text(fileName);
        });
        
        return this;
    };
}(jQuery));