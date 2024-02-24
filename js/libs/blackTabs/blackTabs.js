//####################################################
//               BLACKTABS
// --------------------------------------------------
//     Created by: BlackHeart-frt
//     date:       08-april-2021
//     email:      blackheart.frt@gmail.com
// --------------------------------------------------
//
//              SETTINGS
// --------------------------------------------------
//      tab:        {string}{css class selector}
//      tabActive:  {integer}{index}
//      tabContent: {string}{css class selector}
//
//              HTML BASE
// --------------------------------------------------
//      <div>
//          <ul class="tabs-container">
//              <li class="blackTab"></li>
//              <li class="blackTab"></li>
//              <li class="blackTab"></li>
//          </ul>
//          <div>
//              <div class="blackTab-content"></div>
//              <div class="blackTab-content"></div>
//              <div class="blackTab-content"></div>
//          </div>
//      </div>
//####################################################
(function($){
    $.fn.blackTabs = function(options){
        let settings = $.extend({
            tab:        '.blackTab',
            tabActive:  0,
            tabContent: '.blackTab-content'
        }, options);   
        
        let tabElement          =   this.find(settings.tab);
        let tabContentElement   =   this.find(settings.tabContent);
        
        // set [data-index] to tabElement
        for (let i = 0; i < $(tabElement).length; i++) {
            $(tabElement).filter(':nth-child(' + (i + 1) + ')').attr('data-id', i);            
        };
        // set [data-active] to tabElement
        $(tabElement).attr('data-active', 'off');        
        this.find(settings.tab + '[data-id=' + settings.tabActive + ']').attr('data-active', 'on');

        // set [data-index] to tabContentElement
        for (let i = 0; i < $(tabContentElement).length; i++) {
            $(tabContentElement).filter(':nth-child(' + (i + 1) + ')').attr('data-id', i);            
        };        
        // set [data-active] to tabContentElement
        $(tabContentElement).attr('data-active', 'off');        
        this.find(settings.tabContent + '[data-id=' + settings.tabActive + ']').attr('data-active', 'on');

        //ACTION: change tab content
        $(tabElement).click(function(event){
            event.preventDefault();
            let tabID    =   $(this).attr('data-id');
            
            // set tab behavior
            $(tabElement).filter('[data-active=on]').attr('data-active', 'off');
            $(this).attr('data-active', 'on');
            //set tab content behavior
            $(tabContentElement).filter('[data-active=on]').attr('data-active', 'off').hide();
            $(tabContentElement).filter('[data-id=' + tabID + ']').attr('data-active', 'on').show();
        });
        return this;
    };
}(jQuery));