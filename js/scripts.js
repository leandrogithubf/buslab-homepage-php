var alerta1 = $("#alerta1").val();
var alerta2 = $("#alerta2").val();
var alerta3 = $("#alerta3").val();
var alerta4 = $("#alerta4").val();
var alerta5 = $("#alerta5").val();
var sucesso1 = $("#sucesso1").val();
var sucesso2 = $("#sucesso2").val();
var sucesso3 = $("#sucesso3").val();

$(document).ready(function(){  

    sal({        
        once: true,
    });  

    if($('.counter-animate').length != 0){
        counterAnimate();

        $('[data-feature="button"]','[data-feature="change-content-nav"]').on('click', function(event){
           event.preventDefault();
            counterAnimate();
        });
    };

   $(".telefone").mask("(99) 9999-9999?9",{placeholder: " "}).on("keyup", function() {
      var elemento = $(this);
      var valor = elemento.val().replace(/\D/g, '');
      if (valor.length > 10) {
         elemento.mask("(99) 99999-9999",{placeholder: " "});
      } else if (valor.length > 9) {
         elemento.mask("(99) 9999-9999?9",{placeholder: " "});
      }
   }).trigger('keyup');  

   var procurarAtivo = $("#procurar-ativo").val();
   if(procurarAtivo == 1){
      $('#blog-artigos, #blog-paginacao').hide();
   }else if(procurarAtivo == 2){
      $('#blog-artigos, #blog-paginacao, #blog-side, #blog-descricao').hide();
      $("#blog-titulo").text('Pesquisa');
      $("#blog-navegacao").text('Pesquisa');
   }

   //trabalhe conosco
   var arquivo;
   $('#trabalhe-curriculo').change(function(){
      var filename = $(this).val();
      var extension = filename.replace(/^.*\./, '');

      arquivo = $(this)[0].files[0];

      // $("#curriculo-name").text(arquivo.name);

      if (extension == filename) { 
          extension = '';
      }
      else{ 
          extension = extension.toLowerCase(); 
      }
     
      if(extension!='doc' && extension!='docx' && extension!='pdf'){
        msgErro(alerta2);
        $("#trabalhe-curriculo").val('');
        // $("#curriculo-name").text('Arquivo anexado');
        // $("#curriculo-name").css('border', '1px solid red');
        $("#curriculo-arquivo").css('border', '1px solid red');
        return false;
      }

      var tamanhoMaximo ;
      tamanhoMaximo = ($("#maxFileSize").val())*1000000; 
      if($(this)[0].files[0].size >  tamanhoMaximo){
          msgErro(alerta3);
          $("#curriculo-arquivo").css('border', '1px solid red');
          return false;
      }
   });
  
   $("#enviar-trabalhe-conosco").on("click", function(e){
        e.preventDefault();
        var filename = $('#trabalhe-curriculo').val();
        var extension = filename.replace(/^.*\./, '');
        var valida = validaForm({
            form: $("form#form-trabalhe-conosco"),
            notValidate: true,
            validate: true
        });
        var valida = true;

        var formdata = new FormData();
        formdata.append("nome", $('#trabalhe-nome').val());
        formdata.append("email", $('#trabalhe-email').val());
        formdata.append("telefone", $('#trabalhe-telefone').val());
        formdata.append("idarea_pretendida", $('#trabalhe-area').val());
        formdata.append("arquivo", arquivo);

        if(valida == false){
            msgErro(alerta4);
            $("#form-trabalhe-conosco input[name='email']").val('');
        }else{
            arquivo = $('#trabalhe-curriculo')[0].files[0];

            if (extension == filename) { 
                extension = '';
            }
            else{ 
                extension = extension.toLowerCase(); 
            }
           
            if(extension!='doc' && extension!='docx' && extension!='pdf'){
              msgErro(alerta2);
              $("#trabalhe-curriculo").val('');
              // $("#curriculo-name").text('Arquivo anexado');
              $("#curriculo-name").css('border', '1px solid red');
              valida = false;
              return false;
            }

            var tamanhoMaximo;
            tamanhoMaximo = ($("#maxFileSize").val())*1000000; 
            if($('#trabalhe-curriculo')[0].files[0].size >  tamanhoMaximo){
                msgErro(alerta3);
                $("#trabalhe-curriculo").val('');
                // $("#curriculo-name").text('Arquivo anexado');
                $("#curriculo-name").css('border', '1px solid red');
                valida = false;
                return false;
            }

            var valida = validaForm({
                form: $("form#form-trabalhe-conosco"),
                notValidate: true,
                validate: true,
            });
            if (valida) {
                $.ajax({
                    url: 'admin/trabalhe_conosco_script.php?ajax=true&opx=cadastroTrabalhe_conosco',
                    type: 'post',
                    dataType: 'json',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        $.fancybox.showLoading();
                        $.fancybox.helpers.overlay.open({parent: $('body'), closeClick : false});
                    }
                }).done(function (e) {
                    $.fancybox.hideLoading();
                    $.fancybox.helpers.overlay.close();
                    if (e.status) {
                        msgSucesso(sucesso2);
                        $('form#form-trabalhe-conosco')[0].reset();
                        setTimeout(function(){
                            document.location.reload(true)
                        }, 1200)
                    } else {
                        msgErro(alerta1);
                    }
                });
            }
        }
    });

   //Newsletter
   $("#enviar-newsletter").on("click", function(e){
      e.preventDefault();
      enviarFormEmail("newsletter");
   });

   //Newsletter footer
   $("#enviar-footer").on("click", function(e){
      e.preventDefault();
      enviarFormEmail("footer");
   });

   //Contato
   $("#enviar-contato").on("click", function(e){
      e.preventDefault();
      enviarFormEmail("contato");
   });

   //Contato comercial
   $("#enviar-comercial").on("click", function(e){
      e.preventDefault();
      enviarFormEmail("comercial");
   });

   //Contato cliente
   $("#enviar-cliente").on("click", function(e){
      e.preventDefault();
      enviarFormEmail("cliente");
   });

   //Contato cases
   $("#enviar-cases").on("click", function(e){
      e.preventDefault();
      enviarFormEmail("cases");
   });

   //Blog comentario
   $("#enviar-blog-comentario").on("click", function(e){
        e.preventDefault();
        var formData = new FormData($('#form-blog-comentario')[0]);
        var valida = validaForm({
            form: $("form#form-blog-comentario"),
            notValidate: true,
            validate: true
        });
        var valida = validateEmail($("#form-blog-comentario input[name='email']").val());
        // var valida = true;
        if(valida == false){
            msgErro(alerta4);
            $("#form-blog-comentario input[name='email']").val('');
            $("#form-blog-comentario input[name='email']").addClass("border-error");
        }else{
            $("#form-blog-comentario input[name='email']").removeClass('border-error').addClass("border-complete");
            var valida = validaForm({
                form: $("form#form-blog-comentario"),
                notValidate: true,
                validate: true
            });
            if (valida) {
                $.ajax({
                    url: 'admin/blog_comentarios_script.php?opx=cadastroBlog_comentarios&ajax=true',
                    type: 'post',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    // data: $('form#form-blog-comentario').serialize(),
                    beforeSend:function(){
                        $.fancybox.showLoading();
                        $.fancybox.helpers.overlay.open({parent: $('body'), closeClick : false});
                    }
                }).done(function (e) {
                    $.fancybox.hideLoading();
                    $.fancybox.helpers.overlay.close();
                    if (e.status) {
                        msgSucesso(sucesso3);
                        $('form#form-blog-comentario')[0].reset();
                        setTimeout(function(){
                            document.location.reload(true)
                        }, 1200)
                    } else {
                        msgErro(alerta1);
                    }
                });
            }
        }
   });

   //Anexar imagem blog comentário
   $("#anexar-imagem").change(function(){
      if ($("#anexar-imagem")[0].files && $("#anexar-imagem")[0].files[0]) {
         var filename = $(this).val();
         var reader = new FileReader();
         var extension = filename.replace(/^.*\./, '');
         if (extension == filename) { extension = '';
         }else{ extension = extension.toLowerCase(); }

         if(extension!='jpg' && extension!='png' && extension!='gif' && extension!='jpeg' ){
           msgErro(alerta2);
           $("#anexar-imagem").val('');
           return false;
         }

         var tamanhoMaximo ;
         tamanhoMaximo = ($("#maxFileSize").val())*1000000;
         if($(this)[0].files[0].size >  tamanhoMaximo){
             msgErro(alerta3);
             $("#anexar-imagem").val('');
             return false;
         }

         reader.onload = function(e) {
            $('#imagem-upload').attr('src', e.target.result);
            $('#imagem-upload').css("display","block");
            $('#imagem-upload').css("margin-bottom","15px");
            $('#icone-comentario').css("display","none");
         }
         reader.readAsDataURL($("#anexar-imagem")[0].files[0]);
      }
   })

   // CALL FUNCTIONS 
   headerSearch();
   switchContent('#buslab-mvv', '#buslab-mvv > .nav', '#buslab-mvv > .content');
   wereWeServe();
   $('.tabs-wrapper').blackTabs({tabActive:0});
   $('.blackFakeFile').blackFakeFile();
   $('.main-nav-container').blackMobileNav({menuWidth:'70%'});   

   // modais
   close_modal();
   $('[data-modal-btn]').click(function(event){
      event.preventDefault();
      var dataModal = $(this).attr("data-modal-btn");
      $('.modal-solutions').each(function(){
         if($(this).attr('data-modal') == dataModal){
            $('.modal-overlay').css('display', 'flex');
            $(this).toggle(250).addClass('modal-visible');
         }
         else{
            close_modal();
         }
      });
   });
   // $('[data-modal-btn=solutions-hardware]').click(function(event) {
   //     event.preventDefault();
   //     $('.modal-overlay').css('display', 'flex');
   //     $('[data-modal=solutions-hardware]').toggle(250).addClass('modal-visible');
   // });

   // $('[data-modal-btn=solutions-software]').click(function(event) {
   //     event.preventDefault();
   //     $('.modal-overlay').css('display', 'flex');
   //     $('[data-modal=solutions-software]').toggle(250).addClass('modal-visible');
   // });
   
   $('[data-modal-btn=schedule-conversation]').on('click', function(event) {
       event.preventDefault();
       $('.modal-overlay').css('display', 'flex');
       $('[data-modal=schedule-conversation]').toggle(250).addClass('modal-visible');
   });

   // timeline
   if($('#timeline-buslab').length === 1){
    // new HorizontalTimeline(document.getElementById('timeline-buslab'));

    window.addEventListener('resize', function(){
        new HorizontalTimeline(document.getElementById('timeline-buslab'));
    });
   };

   // custom scroolbar
   $(".mCustomScrollbar").mCustomScrollbar({
        theme:"dark"
    });

   // sliders
   $('.hero-slider > .banner-slider').slick({
    adaptiveHeight:     true,
    autoplay:           true,
    autoplaySpeed:      3000,
    arrow:              false,
    cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
    speed:              '1000',
    dots:               true,
    dotsClass:          'slick-dots-nav',
    appendDots:         $('.hero-slider .slider-nav-content'),
    cssEase:            'cubic-bezier(0,1.37,.4,1.11)', 
    draggable:          true,
    infinite:           false,
    lazyLoad:           'ondemand',
    mobileFirst:        true
   });

   $('#how-it-work .banner-slider').slick({
    adaptiveHeight:     false, //false because a slick bug - not get correctly slide height (slide-list)
    autoplay:           true,
    autoplaySpeed:      3000,
    arrow:              true,
    appendArrows:       $('.banner-slider-nav'),
    prevArrow:          $('.banner-slider-nav > .icon-arrow-left'),
    nextArrow:          $('.banner-slider-nav > .icon-arrow-right'),
    cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
    speed:              '1000',
    dots:               false,
    draggable:          true,
    infinite:           false, //false because a slick bug -> double item [https://github.com/akiran/react-slick/issues/1171]
    lazyLoad:           'ondemand',
    mobileFirst:        true
   });

   $('.notebook-slider').slick({
    adaptiveHeight:     false,
    autoplay:           true,
    autoplaySpeed:      3000,
    arrow:              true,
    appendArrows:       $('.notebook-slider-nav-wrapper'),
    prevArrow:          $('.notebook-slider-nav-wrapper > .nav.prev'),
    nextArrow:          $('.notebook-slider-nav-wrapper > .nav.next'),
    cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
    speed:              '1000',
    dots:               false,
    draggable:          true,
    infinite:           true,
    lazyLoad:           'ondemand',
    mobileFirst:        true
   });    

   if ($('.solucoes-card-md-slider .card').length > 2){
       $('.solucoes-card-md-slider').slick({
        adaptiveHeight:     false,
        slidesToShow:       2,
        slidesToScroll:     1,
        initialSlide:       1,
        centerMode:         true,
        centerPadding:      '0px',
        arrow:              false,
        dots:               true,
        appendDots:         $('.solucoes-card-md-slider-nav'),
        dotsClass:          'slick-dots-nav',
        cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
        speed:              '1000',
        draggable:          true,
        infinite:           false,
        lazyLoad:           'ondemand',
        mobileFirst:        true,
        responsive: [
            {
              breakpoint: 319,
              settings: {
                slidesToShow: 1
              }
            }, 
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 2
              }
            },            
          ]
       });
   }else if($('.solucoes-card-md-slider .card').length == 2){
    $('.solucoes-card-md-slider').slick({
        adaptiveHeight:     false,
        slidesToShow:       2,
        slidesToScroll:     1,
        initialSlide:       0,
        centerMode:         true,
        centerPadding:      '0px',
        arrow:              false,
        dots:               true,
        appendDots:         $('.solucoes-card-md-slider-nav'),
        dotsClass:          'slick-dots-nav',
        cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
        speed:              '1000',
        draggable:          true,
        infinite:           false,
        lazyLoad:           'ondemand',
        mobileFirst:        true,
        responsive: [
            {
              breakpoint: 319,
              settings: {
                slidesToShow: 1
              }
            }, 
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 2
              }
            },            
          ]
       });
   };

   $('.slider-company-partners > .slider-container').slick({
        autoplay:           true,
        autoplaySpeed:      3000,
        adaptiveHeight:     true,         
        slidesToScroll:     1,
        initialSlide:       0,       
        centerMode:         true,
        centerPadding:      '0px',
        arrow:              false,
        dots:               true,
        appendDots:         $('.slider-company-partners-nav'),
        dotsClass:          'slick-dots-nav',
        cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
        speed:              '1000',
        draggable:          true,
        infinite:           true,
        lazyLoad:           'ondemand',
        mobileFirst:        true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5
                }
            },
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3                
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1
              }
            }            
          ]
   });

   $('.testemonials-container').slick({
        adaptiveHeight:     true,
        autoplay:           true,
        autoplaySpeed:      5000,
        slidesToShow:       1,
        arrow:              true,
        appendArrows:       $('.testemonials-nav'),
        prevArrow:          $('#testemonials-nav-prev'),
        nextArrow:          $('#testemonials-nav-next'),
        cssEase:            'cubic-bezier(0,1.37,.4,1.11)',
        speed:              '1000',
        dots:               false,
        draggable:          true,
        infinite:           true,
        lazyLoad:           'ondemand',
        mobileFirst:        true
   });

   $('[data-blog-filter]').blackSideToggle({
        openTarget:'.blog-side-mobile',
        cloneTriggerCss:{
            marginLeft:         '95%',
            marginBottom:       '2rem',
            display:            'block'
        }
    });
   
});
// END READY

//==================
//  FUNCIONS
//==================
function close_modal(){
    const modal     =   '.modal-visible'
    const close     =   '[data-modal=close]';
    const overlay   =   '.modal-overlay';    
    $(close).click(function(event) {
        event.preventDefault();        
        $(modal).toggle(250).removeClass('modal-visible');
        $(overlay).hide();
    });
};

function switchContent(parent, nav, content){

    if ($(parent).length != 0){
        for(let i = 0; $(nav).children().length >= i; i++){

            let     el_nav      =   $(nav).find('li').find('a')[i];
            let     el_ctn      =   $(content).find('.data')[i];

            if($(el_nav).attr('data-nav') === undefined){
                $(el_nav).attr('data-nav', i);
            };
            if($(el_ctn).attr('data-content') === undefined){
                $(el_ctn).attr('data-content', i);
            };

            $(parent).find('[data-content-view=false]').css({
                    top: '250px',
                    opacity: '0'
                });
        };//end for

        $(parent).find('[data-btn]').click(function(event) {
            event.preventDefault();

            let index = $(this).attr('data-nav');

            if($(this).attr('data-view') === 'false'){
                $(parent).find('[data-btn][data-view=true]').attr('data-view', 'false').addClass('ghost gray thin');
                $(this).attr('data-view', 'true').removeClass('ghost gray thin');

                $(parent).find('[data-content-view=true]').attr('data-content-view', 'false').css({
                    top: '250px',
                    opacity: '0'
                }).hide();
                $(parent).find('[data-content=' + index + ']').attr('data-content-view', 'true').show().animate({
                    top:    '0px',
                    opacity:'1'
                });
            };
        });//end click
    };//end test
};

function wereWeServe(){    
    if($('#cases-s02').find('[data-feature="change-content"]').length != 0){
        const   parent  =   '#cases-s02';    
        let     button  =   $(parent).find('[data-feature=button]');        

        let     getPos  =   function(){
            let     button_active       =   $(parent).find('[data-feature=button][data-active=on]');
            let     button_active_pos   =   $(parent).find(button_active).position();
            let     button_active_width =   $(parent).find(button_active).innerWidth();
            let     pointer_left        =   Math.round(button_active_pos.left + (button_active_width / 2)); 
    
            // $(parent).find('.control-pointer').css('left', pointer_left + 'px');            
            $(parent).find('.control-pointer').animate({left: pointer_left + 'px'});            
        };
        getPos();

    
        $(button).click(function(event){            
            event.preventDefault();
            let button_id       =   $(this).attr('data-feature-id');
            let content_active  =   $(parent).find('[data-feature=change-content][data-active=on]');

            $(button).attr('data-active', 'off');
            $(this).attr('data-active', 'on');
            getPos();            
            $(content_active).attr('data-active', 'off');
            $('[data-feature=change-content][data-feature-id=' + button_id + ']').attr('data-active', 'on').show();
        })
    };//end test
};

function headerSearch(){
    const searchBtn             =   document.querySelector('.btn-search');
    const searchInputContainer  =   document.querySelector('.search-input-container');
    const searchInput           =   document.querySelector('#input-search');

    searchInput.addEventListener('blur', function(){
        if(searchInputContainer !== null && searchInputContainer.getAttribute('data-open') === 'true'){
            $(searchInputContainer).animate({
                    width:'0px'
                },
                    300,
                    function(){
                        searchInputContainer.setAttribute('data-open', 'false');
                        searchInputContainer.style.display = "none";

                        // [ADD SEND FORM HERE]
                });          
        };
    });

    searchBtn.addEventListener('click', function(event){
        event.preventDefault();

        if(searchInputContainer !== null && searchInputContainer.getAttribute('data-open') === 'false'){
            $(searchInputContainer).show().animate(
                {
                    width:'50vw'
                },
                    300,
                    function(){
                        searchInputContainer.setAttribute('data-open', 'true');
                });
        };
        if(searchInputContainer !== null && searchInputContainer.getAttribute('data-open') === 'true'){
            $(searchInputContainer).animate({
                    width:'0px'
                },
                    300,
                    function(){
                        searchInputContainer.setAttribute('data-open', 'false');
                        searchInputContainer.style.display = "none";

                        // [ADD SEND FORM HERE]
                        // $("#form-busca").submit();
                        $(this).closest("form").submit();
                });
        };
    });    
};


function validaForm(params)
{
    var valida = true;
    var notpermitidos = ['', '__/__/____', undefined, null];
    var config = {
        form    : $(params.form.selector),
        notValidate : false,
        msgError  : alerta5,
        validate  : false,
        msgValidate :  'O formulário foi validado com sucesso.',
        validaEmail : false
    }
    $.extend(config, params);
    var $form = config.form;
    $form.find(':input.required', 'select.required').each(function () {
        var border = (!$(this).val()) ? 'border-error' : 'border-complete';
        if ($.inArray($(this).val(), notpermitidos) == 0){
            valida = false;
        }
        $(this).closest('input, textarea, select').removeClass('border-error').addClass(border);

        if($(this).attr("id") == "trabalhe-curriculo"){
            $(this).parent().addClass("border-error");
        }
        // else{
        //     $(this).parent().removeClass('border-error').addClass("border-complete");
        // }
    });
    if (config.notValidate && !valida){
        msgErro(config.msgError);
    }else{
        $form.find(':input.validate_email').each(function (){
            if(!validateEmail($(this).val()))
            {
                $(this).css('border', '1px solid red');
                config.msgError = alerta4;
                valida = false;
            };
        });
        if (config.notValidate && !valida)
            msgErro(config.msgError);
    }
    return valida;
}
function msgErro(msg, pagina) {
    jError(
        msg,
        {
            autoHide: true, // added in v2.0
            clickOverlay: true, // added in v2.0
            MinWidth: 250,
            TimeShown: 3000,
            ShowTimeEffect: 200,
            HideTimeEffect: 200,
            LongTrip: 20,
            HorizontalPosition: 'center',
            VerticalPosition: 'top',
            ShowOverlay: true,
            ColorOverlay: '#000',
            OpacityOverlay: 0.3,
            onClosed: function () { // added in v2.0

            },
            onCompleted: function () { // added in v2.0

            }
        });
}
function msgSucesso(msg, pagina) {
    jSuccess(
        msg,
        {
            autoHide: true, // added in v2.0
            clickOverlay: true, // added in v2.0
            MinWidth: 250,
            TimeShown: 3000,
            ShowTimeEffect: 200,
            HideTimeEffect: 200,
            LongTrip: 20,
            HorizontalPosition: 'center',
            VerticalPosition: 'top',
            ShowOverlay: true,
            ColorOverlay: '#000',
            OpacityOverlay: 0.3,
            onClosed: function () { // added in v2.0
                if (pagina) {
                    if (pagina != "") {
                        if (pagina == "home")
                            location.href = jQuery("#_endereco").val();
                        else if (pagina == "location")
                            location.reload();
                        else
                            location.href = jQuery("#_endereco").val() + pagina;
                    }
                }
            },
            onCompleted: function () { // added in v2.0

            }
        });
}


function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function enviarFormEmail(local){
   var form = "form-"+local;
   var formData = new FormData($('#'+form)[0]);   
   var valida = validaForm({
      form: $("form#"+form),
      notValidate: true,
      validate: true
   });
   var valida = validateEmail($("form#"+form+" input[name='email']").val());
   if(valida == false){
      msgErro(alerta4);
      $("form#"+form+" input[name='email']").val('');
      $("form#"+form+" input[name='email']").addClass("border-error");
   }else{
      $("form#"+form+" input[name='email']").removeClass('border-error').addClass("border-complete");
      var valida = validaForm({
         form: $("form#"+form),
         notValidate: true,
         validate: true
      });
      if (valida) {
         $.ajax({
            url: 'admin/email_script.php?opx='+local,
            type: 'post',
            dataType : "json",
            data: formData,
            processData: false,
            contentType: false,
            // data: $("form#"+form).serialize(),
            beforeSend:function(){
               $.fancybox.showLoading();
               $.fancybox.helpers.overlay.open({parent: $('body'), closeClick : false});
            }
         }).done(function (e) {
            $.fancybox.hideLoading();
            $.fancybox.helpers.overlay.close();
            if (e.status) {
               msgSucesso(sucesso1);
               $('#'+form)[0].reset();
            } else {
               msgErro(alerta1);
            }
         });
      }
   }
}

function counterAnimate(){
    $('.counter-animate').each(function(){
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text(),
            },
            {
                duration: 2000,
                easing: 'linear',
                step: function(now){
                    $(this).text(Math.ceil(now));
                }
            })
    });
}