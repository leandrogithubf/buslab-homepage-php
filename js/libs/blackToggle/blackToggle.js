//####################################################################
//               BLACK TOGGLE CONTENT
// -----------------------------------------------------------------
//     Created by: BlackHeart-frt
//     date:       16-april-2021
//     email:      blackheart.frt@gmail.com
// -----------------------------------------------------------------
//
//              SETTINGS
// -----------------------------------------------------------------
//
//
//              HTML BASE
// -----------------------------------------------------------------
//
//      
//####################################################################
(function($){
    $.fn.blackSideToggle = function(options){
        let     settings        =   $.extend({            
                    overlay:            true,
                    overlayColor:       'rgba(0,0,0,.75)',
                    openTarget:         'null',
                    openTargetWidth:    '70%',
                    openTargetAppendTo: '.blackToggle-overlay',
                    btnClose:           'null',
                    cloneTrigger:        true,
                    cloneTriggerCss:    {},
                    zindexTarget:       '999999'
        }, options);

        let     triggerButton   =   $(this);                   

        //set data-open to openTarget element
        $(settings.openTarget).attr('data-open', 'off');

        //clone trigger set attr
        if(settings.cloneTrigger === true){                
            $(this).attr('data-trigger', 'original');
        };
        //clone trigger destroy
        const destroyCloneTrigger   =   function(){
            $('[data-trigger=clone]').remove();
        };

        //trigger open target
        $(this).on('click', function(event){
            event.preventDefault();
            
            //create overlay in DOM
            if(settings.overlay === true && $('.blackToggle-overlay').length == 0){
                $('body').append('<div class="blackToggle-overlay"></div>');
                $('.blackToggle-overlay').css({
                    position:           'absolute',
                    top:                '0',
                    left:               '0',
                    width:              '100vw',
                    height:             '100vh',
                    backgroundColor:    settings.overlayColor,
                    zIndex:             settings.zindexTarget
                });
            };

            //clone target element
            if($(settings.openTarget).length === 1){                
                $(settings.openTarget)
                    .clone(true, true)
                    .appendTo(settings.openTargetAppendTo);
                if(settings.overlay === true){
                    $(settings.openTarget)
                        .eq(1)
                        .css({
                            position:   'absolute',
                            left:       'auto',
                            right:      '-100vw',
                            width:       settings.openTargetWidth,
                            padding:    '1rem',
                            boxSizing:  'border-box'
                        });
                };
                $(settings.openTarget)
                    .eq(1)
                    .attr('data-open-target', 'clone');
            };

            // cloning trigger and bind event for closing target element
            if(settings.cloneTrigger === true){
                $('[data-trigger=original]')
                    .clone()
                    .prependTo('[data-open-target = clone]')
                    .on('click', function(event){
                        event.preventDefault();
                        funcCloseTarget();
                    });
                $('[data-trigger]')
                    .eq(1)
                    .attr('data-trigger', 'clone')
                    .css(settings.cloneTriggerCss);
            };

            //call funcOpenTarget
            funcOpenTarget();
        });

        //functions menu trigger open/close
        const   funcOpenTarget  =   function(){            
            if($(settings.openTarget).eq(1).attr('data-open') === 'off'){
                if(settings.overlay === true){
                    $('.blackToggle-overlay').show();

                    $(settings.openTarget)
                        .eq(1)
                        .css('display', 'block')
                        .animate({
                            right:      '0'
                        })
                        .attr('data-open', 'on');                        
                    $(window).scrollTop($('.blackToggle-overlay').scrollTop());
                };
                $(settings.openTarget)
                    .eq(1)
                    .css({
                        display:    'block',
                        opacity:    '1'
                    })                    
                    .attr('data-open', 'on');
                let openTargetPosY  =   $(settings.openTarget).eq(1).position();                
                $(window).scrollTop(Math.round(openTargetPosY.top));
            };            
        };
        const   funcCloseTarget  =   function(){
            if($(settings.openTarget).eq(1).attr('data-open') === 'on'){                
                if(settings.overlay === true){
                    $(settings.openTarget)
                        .eq(1)                    
                        .animate({
                            right:      '-100vw'
                        }, function(){
                            if(settings.overlay === true){
                                $('.blackToggle-overlay').hide();
                            };
                            if(settings.cloneTrigger === true){
                                destroyCloneTrigger();
                            };
                        })
                        .attr('data-open', 'off');                                    
                }else{
                    $(settings.openTarget)
                        .eq(1)                    
                        .animate({
                            opacity:      '0'
                        }, function(){
                            if(settings.overlay === true){
                                $('.blackToggle-overlay').hide();
                            };
                            if(settings.cloneTrigger === true){
                                destroyCloneTrigger();
                            };
                            $(settings.openTarget).hide();
                        })
                        .attr('data-open', 'off');
                };
            };
        };

        return this;    
    };
}(jQuery));