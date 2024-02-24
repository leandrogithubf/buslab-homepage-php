// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;
function preTableServicos(){
		$("#limit").change(function(){
	         $("#pagina").val(1);
	         dataTableServicos();
	    });

	    $("#pagina").keyup(function(e){
	         if(e.keyCode == 13){
	             if(totalPaginasGrid >= $(this).val() && $(this).val() > 0){
	                 dataTableServicos();
	             }else{
	                 msgErro("numero de pagina deve ser entre 1 e "+totalPaginasGrid);
	             }
	         }
	    });

	    $(".next").click(function(e){
	          e.preventDefault();
	          $("#pagina").val($(this).attr('proximo'));
	          dataTableServicos();
	    });

	    $(".prev").click(function(e){
	         e.preventDefault();
	         $("#pagina").val($(this).attr('anterior'));
	         dataTableServicos();
	    });


	    //LISTAGEM BUSCA
	    $("#buscarapida").keyup(function(event){
	        event.preventDefault();
	        if(event.keyCode == '13') {
                $('#pagina').val(1);
	            pesquisar = "&titulo="+$("#buscarapida").val();
	            dataTableServicos();
	        }
	        return true;
	    });

	    $("#filtrar").click(function(e){
	        e.preventDefault();
            $('#pagina').val(1);
	        pesquisar = "&"+$("#formAvancado").serialize();
	        dataTableServicos();
	    });

	    $(".ordem").click(function(e){
	         e.preventDefault();
	         ordem = $(this).attr("ordem");
	         dir = $(this).attr("order");
	         $(".ordem").removeClass("action");
	         $(".ordem").removeClass("actionUp");
	         if($(this).attr("order") == "asc"){
	             $(this).attr("order","desc");
	             $(this).removeClass("action");
	             $(this).addClass("actionUp");
	         }else{
	             $(this).attr("order","asc");
	             $(this).removeClass("actionUp");
	             $(this).addClass("action");
	         }
	         dataTableServicos();
	    });

	    $('.table').on("click",".ordemUp",function(e){ 
          var params = { idservicos: $(this).attr("codigo")}
          $.post( 'servicos_script.php?opx=alteraOrdemCima', params,
                function(data){  
                  var resultado = new String (data.status); 
                  if(resultado.toString() == 'sucesso'){ 
                       dataTableServicos(); 
                  }  
                  else if (resultado == 'falha'){ 
                       alert('Não foi possível atender a sua solicitação.')
                  }
              },'json'
          );  
      });  
         

    $('.table').on("click", ".ordemDown", function(e){  
        var params = {idservicos: $(this).attr("codigo")}  
        $.post( 'servicos_script.php?opx=alteraOrdemBaixo', params,
         function(data){  
            var resultado = new String (data.status);  
            if(resultado.toString() == 'sucesso'){ 
              dataTableServicos(); 
            }  
            else if (resultado == 'falha'){ 
              alert('Não foi possível atender a sua solicitação.')
            } 
          },'json' 
        );  
    }); 


	    $('.table').on("click", ".inverteStatus", function (e) {
		var params = {
			idservicos: $(this).attr("codigo")
		}

		$.post(
			'servicos_script.php?opx=inverteStatus',
			params,
			function (data) {
				var resultado = new String(data.status);

				if (resultado.toString() == 'sucesso') {
					dataTableServicos();
				}
				else if (resultado == 'falha') {
					alert('Não foi possível atender a sua solicitação.')
				}

			}, 'json'
		);
	});

}
	var myColumnDefs = [
		{key:"idservicos", sortable:true, label:"ID", print:true, data:true},
		{key:"titulo", sortable:true, label:"Nome", print:true, data:true},
		{ key: "ordem", sortable: false, label: "Ordem", print: true, data: false },
		{ key: "ordemUp", sortable: false, label: "Subir", print: false, data: true },
		{ key: "ordemDown", sortable: false, label: "Descer", print: false, data: true }
	]
function columnServicos(){
	    tr = "";
	    $.each(myColumnDefs, function(col, ColumnDefs){
	    	if(ColumnDefs['data']){
	            orderAction = "";
	            ordena = "";
	            if(ColumnDefs['key'] == ordem){
	                if(dir == "desc"){
	                    orderAction = "actionUp";
	                }else{
	                    orderAction = "action";
	                }
	            }
	            if(ColumnDefs['sortable']){
	                ordena = 'ordem="'+ColumnDefs['key']+'" class="ordem '+orderAction+'" order="'+dir+'"';
	            }
	            tr += '<th><a href="#" '+ ordena +'>'+ColumnDefs['label']+'</a></th>';
	        }
	    });
	    tr += "<th></th>";
	    $('#listagem').find("thead").append(tr);
}
function dataTableServicos(){
	    limit = $("#limit").val();
        pagina = $("#pagina").val();
        pagina = parseInt(pagina) - 1;
        colunas = myColumnDefs;
        colunas = JSON.stringify(colunas);
        queryDataTable = requestInicio+"&ordem="+ordem+pesquisar+"&dir="+dir+"&colunas="+colunas;
        $.ajax({
               url: "base_proxy.php",
               dataType: "json",
               type: "post",
               data: requestInicio+"&limit="+limit+"&pagina="+pagina+"&ordem="+ordem+pesquisar+"&dir="+dir,
               beforeSend: function () {
                      $.fancybox.showLoading();
                      $('#listagem').find("tbody tr").remove();
               },
               success:function(data){
                      tr = "";
                      if(data.totalRecords > 0){
                           $.each(data.records, function(index, value){
                                tr += '<tr>';
                                $.each(myColumnDefs, function(col, ColumnDefs){
                                	if(ColumnDefs['data']){
										key = ColumnDefs['key'];
										tr += '<td><span>'+value[key]+'</span></td>';
									}
                                });

                                tr += '<td><div class="acts">';
                                tr += '<a href="index.php?mod=servicos&acao=formServicos&met=editServicos&idu='+value.idservicos+'"><img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
                                tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro '+value.titulo_aba+' ?\',\'php\', \'servicos_script.php?opx=deletaServicos&idu='+value.idservicos+'\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
                                tr += '</div></td>';
                           });
                           $('#listagem').find("tbody").append(tr);
                           atualizaPaginas(data.pageSize, (pagina + 1) , data.totalRecords);
                           $('.pagination').show();
                      }else{
                           $('#listagem').find("tbody").append('<tr class="odd pesquisa_error"><td colspan="'+myColumnDefs.length+'">Nenhum resultado encontrado</td></tr>');
                           $('.pagination').hide();
                      }
               },
               complete:function(){
                        $.fancybox.hideLoading();
               }
        });
}

function verificaUrlrewrite(url, form){
  id = 0; 
   
  if(url != ""){
    if($("#mod").val()=='editar'){ 
        id = $("#idservicos").val(); 
    } 
    
    $.ajax({
        url:'servicos_script.php',
        dataType:'json',
        data: "opx=verificarUrlRewrite&idservicos="+id+"&urlrewrite="+url,
        type:'post',
        beforeSend:function(){
          $.fancybox.showLoading();
        },
        success:function(data){  
            if(!data.status){
                msgErro("Url já cadastrado para outro Serviços!");
                $("#urlamigavel").val($("#urlrewriteantigo").val());
                urlRetorno = false;
            }else{   
                $("#urlamigavel").val(data.url); 
                if(form){
                   $('#formServicos').submit();   
                }
            }
        },
        complete:function(){
            $.fancybox.hideLoading();
        }
    });
  }   
}

$(document).ready(function(){
	$('.ordemUpRec').click(function(){
		var params = { idrecursos: $(this).attr("codigo"), idservicos: $('#idservicos').val() }
		$.post( 'servicos_script.php?opx=alteraOrdemCimaRec', params,
			function(data){  
				var resultado = new String (data.status); 
				if(resultado.toString() == 'sucesso'){ 
					$.ajax({
		               url: "servicos_script.php?opx=atualizaOrdemRec&idservicos="+$('#idservicos').val(),
		               dataType: "json",
		               type: "post",
		               beforeSend: function () {
		               		$.fancybox.showLoading();
		               },
		               success:function(data){
		               		var dados = data.dados;
				            $.each(dados, function(index, value){
		               			$('#ordem'+value.idrecursos).val(value.ordem);
		               		});
		               		$.fancybox.hideLoading();
		               }
		       		});
				}  
				else if (resultado == 'falha'){ 
					alert('Não foi possível atender a sua solicitação.')
				}
			},'json'
		);  
	});

	$('.ordemDownRec').click(function(){
		var params = { idrecursos: $(this).attr("codigo"), idservicos: $('#idservicos').val() }
		$.post( 'servicos_script.php?opx=alteraOrdemBaixoRec', params,
			function(data){  
				var resultado = new String (data.status); 
				if(resultado.toString() == 'sucesso'){ 
					dataTableServicos(); 
				}  
				else if (resultado == 'falha'){ 
					alert('Não foi possível atender a sua solicitação.')
				}
			},'json'
		);  
	});

	$('ul.tabs li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#" + tab_id).addClass('current');
    });
    $('input#pesquisar_icone').keyup(function (event) {
        var pesquisa = $(this).val();
        $.ajax({
            url: 'servico_script.php?opx=pesquisaIcone',
            type: 'post',
            dataType: 'html',
            data: { nome: pesquisa },
            success(data) {
                $('#icone_pai').html(data);
                carregaIconeAcao();
            }
        })
    });
    carregaIconeAcao();

  	$(".bt_save").click(function(event){
  		  event.preventDefault(); 
    		var valida = true;
    		msg = "";
        if($("#imagem_icone").val() == '' && $("#imagem_value").val() == ''){
        	valida = false;
          $("#icone-titulo").css("border", "solid 1px red");
          $("#inputArquivoBotao").css("border", "solid 1px red");
        }
        else{
        	$("#icone-titulo").css("border", "solid 0px red");
          $("#inputArquivoBotao").css("border", "solid 0px red");
        }
        if($("#imagem_icone").val() == '' && $("#imagem_value2").val() == ''){
        	valida = false;
        	$("#inputArquivoBotao2").css("border", "solid 1px red");
        }
        else if($("#imagem_icone").val() != '' && $("#imagem_value2").val() == ''){
        	$("#inputArquivoBotao2").css("border", "solid 0px red");
        }
        else{
        	$("#inputArquivoBotao2").css("border", "solid 0px red");
        }
    		$('#formServicos').find('.required').each(function(){
    	      	$(this).css("border","1px solid #d9d9d9");
    		        if($.trim($(this).val())==''){ 
                    if (this.type == "select-one" || this.type == 'file') {
                       $(this).parent().css("border", "solid 1px red");     
                    } 
		                else {
                      $(this).css("border", "solid 1px red");		                  
                    }
                    valida = false; 
    		        }
    		});  

    		if(valida){
    		    $.fancybox.showLoading();  
    		    $('#formServicos').submit();
    		}else{
    		   msgErro('Preencha o(s) campo(s) obrigatórios!');
    		}
	});

	let divMostraIcones = $("div.div-mostra-icones").html();

	// == INPUTS FILES == //
	let $input = $("input.inputImagem");
	$($input).on('change', function(){

		// ====== >>> INICIO TRATA AS VARIÁVEIS <<< ====== //

		// == PEGA O TIPO DO INPUT PARA COMBINAÇÃO DE NOMES == //
		let type = $(this).attr("type");

		// == PEGA O NOME DO INPUT == //
		let name = $(this).attr("name");

		// == PEGA O ARQUIVO ATUAL == //
		let filename = $(this).val();

		// == PEGA O ARQUIVO ANTIGO SE TIVER == //
		let filename_old = $("#"+name+"_old").val();

		// == PEGA O TAMANHO MAXIMO DA EXTENÇÃO DO ARQUIVO == //
		let tamanhoMaximo = ($("#maxFileSize").val())*1000000;

		// == PEGA A EXTENÇÃO DO ARQUIVO == //
		let extension = filename.replace(/^.*\./, '');

		// == PEGA O NOME DO MUDULO NO INPUT FILE == //
		let nameModulo = $(this).attr("data-name-modulo");

		// == PEGA A LARGURA QUE A IMAGEM SERÁ CORTADA NO INPUT FILE == //
		let dimensaoWidth = $(this).attr("dimension-crop-width");

		// == PEGA A LARGURA QUE A IMAGEM SERÁ CORTADA NO INPUT FILE == //
		let dimensaoHeigth = $(this).attr("dimension-crop-height");

		// == PEGA O ID DO MUDULO NO INPUT FILE == //
		let idModulo = $(this).attr("data-id-modulo");

		let tipo = $(this).attr("tipo");

		// ====== >>> FIM TRATA AS VARIÁVEIS <<< ====== //

		// == VERIFICAÇÃO DOS EXTENÇÕES == //
		if (extension == filename) {
			extension = '';
		}else{
			extension = extension.toLowerCase();
		}
		if(extension!='jpg' && extension!='png' && extension!='gif' && extension!='jpeg' ){
			msgErro('A extensão deste arquivo não é permitida!');
			return false;
		}

		// == VERIFICAÇÃO DOS TAMANHO DO ARQUIVO == //
		if($(this)[0].files[0].size >  tamanhoMaximo){
			msgErro('Arquivo muito grande!');
			return false;
		}

		// == TRATATIVA DAS VARIAIVEL PARA ENVIAR AO AJAX == //

		var formData = new FormData();
		formData.append('imagem', this.files[0]);
		formData.append('opx', "salvaImagem");
		formData.append("id"+nameModulo, idModulo);
		formData.append('tipo', $(this).attr("tipo")); 
		formData.append("dimensaoWidth", dimensaoWidth);
		formData.append("dimensaoHeigth", dimensaoHeigth);
		// formData.append(name+"_old", filename_old);
		if(tipo == "thumbs"){ 
          formData.append('imagem_antigo', $("#thumbs_old").val());
        }else{
          formData.append('imagem_antigo', $("#banner_topo_old").val());
        } 

		$.ajax({
			url: nameModulo+"_script.php",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,  // tell jQuery not to process the data
			contentType: false,   // tell jQuery not to set contentType
			beforeSend:function(){
				$.fancybox.showLoading();
				$.fancybox.helpers.overlay.open({parent: $('body'), closeClick : false});
			},
			success:function(data){
				if(data.status==true){
					msgSucesso('Imagem enviada com sucesso.');
					$('#'+type+"-"+name).attr('src', data.caminho).show();
					$("#"+name+"_old").val(data.nome_arquivo);
					$("#id"+nameModulo).val(data.id+nameModulo);
				}else{
					msgErro(data.msg);
				}
				$.fancybox.hideLoading();
			},
			complete:function(){
				$.fancybox.hideLoading();
				$.fancybox.helpers.overlay.close();
			}
		});
	});

	$(".btn-recursos").click(function () {
        var novoinput = '';
        novoinput += '<tr class="box-recursos removeRecursos-'+$('.box-recursos').length+'">';

        novoinput += '<td align="center" class="td-padding">';
        novoinput += '<div class="divParentIconeRecursos"><img src="https://via.placeholder.com/100?text=Upload+Foto" width="100" class="img-upload img-'+$('.box-recursos').length+'" data-key="'+$('.box-recursos').length+'" />';
        novoinput += '<input type="file" name="recursos['+$('.box-recursos').length+'][imagem]" class="required file-upload upload-'+$('.box-recursos').length+'" data-key="'+$('.box-recursos').length+'" style="display:none"></div>';
        novoinput += '<span style="font-size:11px">Tamanho recomendado 70x70 </span>';
        novoinput += '<input type="hidden" name="recursos['+$('.box-recursos').length+'][imagem]" value="">';

        novoinput += '<div id="mostrar_icone-'+$('.box-recursos').length+'" style="margin: 15px"><i class="fa fa- fa-2x"></i><input type="hidden" name="recursos['+$('.box-recursos').length+'][icone]" value="" id="imagem_icone-'+$('.box-recursos').length+'"></div>'
        novoinput += '<input type="button" value="Escolher ícone" class="btn button-escolher-icone" data-key="'+$('.box-recursos').length+'">';

        novoinput += '<input type="hidden" name="recursos['+$('.box-recursos').length+'][idrecursos]" value="0">';
        novoinput += '<input id="excluirRecurso-'+$('.box-recursos').length+'" type="hidden" name="recursos['+$('.box-recursos').length+'][excluirRecurso]" value="1">';
        novoinput += '</td>';

        novoinput += '<td colspan="2">';
        novoinput += '<input type="text" class="box_txt inputRecursos w-100" name="recursos['+$('.box-recursos').length+'][nome]" placeholder="Titulo">';
        // novoinput += '<textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="recursos['+$('.box-recursos').length+'][descricao]" placeholder="Descrição"></textarea>';
        novoinput += '</td>';

        novoinput += '<td align="center">';
        novoinput += '<span class="excluirRecursos" data-key="'+$('.box-recursos').length+'">';
        novoinput += '<b class="fa fa-trash ico-del"></b>';
        novoinput += '</span>';
        novoinput += '</td>';

        novoinput += '</tr>';

        novoinput += '<tr class="removeRecursos-'+$('.box-recursos').length+'">';

        novoinput += '<td colspan="4">';
        novoinput += '<div id="escolha-icone-'+$('.box-recursos').length+'"><div class="box_ip div-icones" style="width: 100% !important;"></div></div>';
        novoinput += '</td>';

        novoinput += '</tr>';

        $('.recursos').append(novoinput);

        clickEscolherIcone(divMostraIcones);
    });

    $(document).on('click', '.img-upload', function(){
        let key = $(this).attr('data-key');
        $(".upload-"+key).trigger("click");
    });

    $(document).on('change', ".file-upload", function(){
        let key = $(this).attr('data-key');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".img-"+key).attr('src', e.target.result)
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(document).on('click', '.icone-upload', function(){
        let key = $(this).attr('data-key');
        $(".upload-icone-"+key).trigger("click");
    });

    $(document).on('change', ".file-icone-upload", function(){
        let key = $(this).attr('data-key');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".icone-"+key).attr('src', e.target.result)
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(document).on("click", ".excluirRecursos", function () {
        let key = $(this).attr('data-key');
        $('.removeRecursos-'+key).hide();
        $('.removeRecursos-'+key).children().find('.required').removeClass('required');
        $('#excluirRecurso-'+key).val('0');
        // $('.removeRecursos-'+key).remove();
    });

    $("#image").change(function () {
        enviaImagens(this);
    });

    $("#urlamigavel").focus(function(event){
        event.preventDefault();  
        if($(this).val() != "" || $("#titulo_aba").val() != ""){
          url = $(this).val();
          if(url == ""){
            url = $("#titulo_aba").val();
            $("#urlamigavel").val($("#titulo_aba").val());
          }  
          verificaUrlrewrite(url);
        }  
    }); 

    $("#titulo_aba").blur(function(event){
        url = $("#urlamigavel").val();
        if(url == ""){ 
          titulo = $("#titulo_aba").val();
          $("#urlamigavel").focus();
          verificaUrlrewrite(titulo);
        }   
    });

   	clickEscolherIcone(divMostraIcones);
})

function clickEscolherIcone(divMostraIcones){
	$(".button-escolher-icone").click(function(){
    	var dataKeyIcone = $(this).attr("data-key");
    	// $(".div-icones").remove();
    	$("#escolha-icone-"+dataKeyIcone).children().show();
    	$("#escolha-icone-"+dataKeyIcone).children().html('');
    	$("#escolha-icone-"+dataKeyIcone).children().append(divMostraIcones);
    	$(".div-icones").not($("#escolha-icone-"+dataKeyIcone).children()).hide();
    	escolheIcone(dataKeyIcone);
    	pesquisaIcone(dataKeyIcone);
    	// $(".div-mostra-icones").show();
    });
}

function escolheIcone(dataKeyIcone){
	$('i.icone_icone').click(function (e) {
        e.preventDefault();
        var nome = $(this).data('nome');
        var id = $(this).data('id');
        var icone = '';
        icone = '<i class="fa fa-' + nome + ' fa-2x" data-id="' + id + '"></i>';
        icone += '<input type="hidden" name="recursos['+dataKeyIcone+'][icone]" id="" value="' + id + '">';
        $('#mostrar_icone-'+dataKeyIcone).html(icone);
    });
}

function pesquisaIcone(dataKeyIcone){
	$('input.pesquisar_icone').keyup(function (event) {
        var pesquisa = $(this).val();
        $.ajax({
            url: 'servico_script.php?opx=pesquisaIcone',
            type: 'post',
            dataType: 'html',
            data: { nome: pesquisa },
            success(data) {
                $('div.icone_pai').html(data);
                escolheIcone(dataKeyIcone);
            }
        })
    });
}

function carregaIconeAcao() {
    $('i.icone_icone2').click(function (e) {
        e.preventDefault();
        var nome = $(this).data('nome');
        var id = $(this).data('id');
        var icone = '';
        icone = '<i class="fa fa-' + nome + ' fa-2x" data-id="' + id + '"></i>';
        icone += '<input type="hidden" name="icone2" id="icone" value="' + id + '">';
        $('#mostrar_icone2').html(icone);
    });
}