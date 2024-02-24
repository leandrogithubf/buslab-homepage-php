// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;
function preTableSolucoes(){
		$("#limit").change(function(){
	         $("#pagina").val(1);
	         dataTableSolucoes();
	    });

	    $("#pagina").keyup(function(e){
	         if(e.keyCode == 13){
	             if(totalPaginasGrid >= $(this).val() && $(this).val() > 0){
	                 dataTableSolucoes();
	             }else{
	                 msgErro("numero de pagina deve ser entre 1 e "+totalPaginasGrid);
	             }
	         }
	    });

	    $(".next").click(function(e){
	          e.preventDefault();
	          $("#pagina").val($(this).attr('proximo'));
	          dataTableSolucoes();
	    });

	    $(".prev").click(function(e){
	         e.preventDefault();
	         $("#pagina").val($(this).attr('anterior'));
	         dataTableSolucoes();
	    });


	    //LISTAGEM BUSCA
	    $("#buscarapida").keyup(function(event){
	        event.preventDefault();
	        if(event.keyCode == '13') {
                $('#pagina').val(1);
	            pesquisar = "&titulo="+$("#buscarapida").val();
	            dataTableSolucoes();
	        }
	        return true;
	    });

	    $("#filtrar").click(function(e){
	        e.preventDefault();
            $('#pagina').val(1);
	        pesquisar = "&"+$("#formAvancado").serialize();
	        dataTableSolucoes();
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
	         dataTableSolucoes();
	    });


	    $('.table').on("click", ".inverteStatus", function (e) {
		var params = {
			idsolucoes: $(this).attr("codigo")
		}

		$.post(
			'solucoes_script.php?opx=inverteStatus',
			params,
			function (data) {
				var resultado = new String(data.status);

				if (resultado.toString() == 'sucesso') {
					dataTableSolucoes();
				}
				else if (resultado == 'falha') {
					alert('Não foi possível atender a sua solicitação.')
				}

			}, 'json'
		);
	});

}
	var myColumnDefs = [
		{key:"idsolucoes", sortable:true, label:"ID", print:true, data:true},
		{key:"titulo", sortable:true, label:"Título", print:true, data:true},
      {key:"bandeira", sortable:true, label:"Idioma", print:true, data:true}
	]
function columnSolucoes(){
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
function dataTableSolucoes(){
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
                                tr += '<a href="index.php?mod=solucoes&acao=formSolucoes&met=editSolucoes&idu='+value.idsolucoes+'"><img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
                                tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro '+value.titulo_aba+' ?\',\'php\', \'solucoes_script.php?opx=deletaSolucoes&idu='+value.idsolucoes+'\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
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
        id = $("#idsolucoes").val(); 
    } 
    
    $.ajax({
        url:'solucoes_script.php',
        dataType:'json',
        data: "opx=verificarUrlRewrite&idsolucoes="+id+"&urlrewrite="+url,
        type:'post',
        beforeSend:function(){
          $.fancybox.showLoading();
        },
        success:function(data){  
            if(!data.status){
                msgErro("Url já cadastrado para outra Solução!");
                $("#urlamigavel").val($("#urlrewriteantigo").val());
                urlRetorno = false;
            }else{   
                $("#urlamigavel").val(data.url); 
                if(form){
                   $('#formSolucoes').submit();   
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
	let divMostraIcones = $("div.div-mostra-icones").html();
   let divMostraIconesServicos = $("div.div-mostra-icones-servicos").html();
   let divMostraIconesImagem = $("div.div-mostra-icones-imagem").html();

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
        novoinput += '<img src="https://via.placeholder.com/100?text=Upload+Foto" style="max-width: 30px" class="img-upload-recursos img-recursos-'+$('.box-recursos').length+'" data-key="'+$('.box-recursos').length+'" />';
        novoinput += '<input type="file" name="recursos['+$('.box-recursos').length+'][imagem]" class="file-upload-recursos upload-recursos-'+$('.box-recursos').length+'" data-key="'+$('.box-recursos').length+'" style="display:none">';
        novoinput += '<span style="font-size:11px">Tamanho recomendado 30x30px </span>';
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

   $(".btn-servicos").click(function () {
        var novoinput = '';
        novoinput += '<tr class="box-servicos removeServicos-'+$('.box-servicos').length+'">';

        novoinput += '<td align="center" class="td-padding">';
        novoinput += '<img src="https://via.placeholder.com/100?text=Upload+Foto" style="max-width: 30px" class="img-upload-servicos img-servicos-'+$('.box-servicos').length+'" data-key="'+$('.box-servicos').length+'" />';
        novoinput += '<input type="file" name="servicos['+$('.box-servicos').length+'][imagem]" class="file-upload-servicos upload-servicos-'+$('.box-servicos').length+'" data-key="'+$('.box-servicos').length+'" style="display:none">';
        novoinput += '<span style="font-size:11px">Tamanho recomendado 30x30px </span>';
        novoinput += '<input type="hidden" name="servicos['+$('.box-servicos').length+'][imagem]" value="">';

        novoinput += '<div id="mostrar_icone_servicos-'+$('.box-servicos').length+'" style="margin: 15px"><i class="fa fa- fa-2x"></i><input type="hidden" name="servicos['+$('.box-servicos').length+'][icone]" value="" id="imagem_icone-servicos-'+$('.box-servicos').length+'"></div>'
        novoinput += '<input type="button" value="Escolher ícone" class="btn button-escolher-icone-servicos" data-key="'+$('.box-servicos').length+'">';

        novoinput += '<input type="hidden" name="servicos['+$('.box-servicos').length+'][idservicos]" value="0">';
        novoinput += '<input id="excluirServicos-'+$('.box-servicos').length+'" type="hidden" name="servicos['+$('.box-servicos').length+'][excluirRecurso]" value="1">';
        novoinput += '</td>';

        novoinput += '<td colspan="2">';
        novoinput += '<input type="text" class="box_txt inputRecursos w-100" name="servicos['+$('.box-servicos').length+'][nome]" placeholder="Titulo">';
        // novoinput += '<textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="servicos['+$('.box-servicos').length+'][descricao]" placeholder="Descrição"></textarea>';
        novoinput += '</td>';

        novoinput += '<td align="center">';
        novoinput += '<span class="excluirServicos" data-key="'+$('.box-servicos').length+'">';
        novoinput += '<b class="fa fa-trash ico-del"></b>';
        novoinput += '</span>';
        novoinput += '</td>';

        novoinput += '</tr>';

        novoinput += '<tr class="removeServicos-'+$('.box-servicos').length+'">';

        novoinput += '<td colspan="4">';
        novoinput += '<div id="escolha-icone-servicos-'+$('.box-servicos').length+'"><div class="box_ip div-icones" style="width: 100% !important;"></div></div>';
        novoinput += '</td>';

        novoinput += '</tr>';

        $('.servicos').append(novoinput);

        clickEscolherIconeServicos(divMostraIconesServicos);
   });

   $(".btn-imagem").click(function () {
        var novoinput = '';
        novoinput += '<tr class="box-imagem removeImagem-'+$('.box-imagem').length+'">';

        novoinput += '<td align="center" class="td-padding">';
        novoinput += '<img src="https://via.placeholder.com/100?text=Upload+Foto" width="100" class="img-upload img-'+$('.box-imagem').length+'" data-key="'+$('.box-imagem').length+'" />';
        novoinput += '<input type="file" name="imagem['+$('.box-imagem').length+'][imagem]" class="file-upload upload-'+$('.box-imagem').length+'" data-key="'+$('.box-imagem').length+'" style="display:none">';
        novoinput += '<span style="font-size:11px">Tamanho recomendado 634x415px </span>';
        novoinput += '<input type="hidden" name="imagem['+$('.box-imagem').length+'][imagem]" value="">';

        novoinput += '<div id="mostrar_icone_imagem-'+$('.box-imagem').length+'" style="margin: 15px"><i class="fa fa- fa-2x"></i><input type="hidden" name="imagem['+$('.box-imagem').length+'][icone]" value="" id="imagem_icone-imagem-'+$('.box-imagem').length+'"></div>'
        novoinput += '<input type="button" value="Escolher ícone" class="btn button-escolher-icone-imagem" data-key="'+$('.box-imagem').length+'">';

        novoinput += '<input type="hidden" name="imagem['+$('.box-imagem').length+'][idimagem]" value="0">';
        novoinput += '<input id="excluirImagem-'+$('.box-imagem').length+'" type="hidden" name="imagem['+$('.box-imagem').length+'][excluirRecurso]" value="1">';
        novoinput += '</td>';

        novoinput += '<td colspan="2">';
        novoinput += '<input type="text" class="box_txt inputRecursos w-100" name="imagem['+$('.box-imagem').length+'][nome]" placeholder="Titulo">';
        novoinput += '<textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="imagem['+$('.box-imagem').length+'][descricao]" placeholder="Descrição"></textarea>';
        novoinput += '</td>';

        novoinput += '<td align="center">';
        novoinput += '<span class="excluirImagem" data-key="'+$('.box-imagem').length+'">';
        novoinput += '<b class="fa fa-trash ico-del"></b>';
        novoinput += '</span>';
        novoinput += '</td>';

        novoinput += '</tr>';

        novoinput += '<tr class="removeImagem-'+$('.box-imagem').length+'">';

        novoinput += '<td colspan="4">';
        novoinput += '<div id="escolha-icone-imagem-'+$('.box-imagem').length+'"><div class="box_ip div-icones" style="width: 100% !important;"></div></div>';
        novoinput += '</td>';

        novoinput += '</tr>';

        $('.imagem').append(novoinput);

        clickEscolherIconeImagem(divMostraIconesImagem);
   });

    $(document).on('click', '.img-upload-recursos', function(){
        let key = $(this).attr('data-key');
        $(".upload-recursos-"+key).trigger("click");
    });

    $(document).on('click', '.img-upload-servicos', function(){
        let key = $(this).attr('data-key');
        $(".upload-servicos-"+key).trigger("click");
    });

    $(document).on('click', '.img-upload', function(){
        let key = $(this).attr('data-key');
        $(".upload-"+key).trigger("click");
    });

    $(document).on('change', ".file-upload-recursos", function(){
        let key = $(this).attr('data-key');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".img-recursos-"+key).attr('src', e.target.result)
            };
            reader.readAsDataURL(this.files[0]);
            var gridRecursos = parseInt($("input[name='grid-recursos']").val());
            $("input[name='grid-recursos']").val(gridRecursos+1);
        }
    });

    $(document).on('change', ".file-upload-servicos", function(){
        let key = $(this).attr('data-key');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".img-servicos-"+key).attr('src', e.target.result)
            };
            reader.readAsDataURL(this.files[0]);
            var gridServicos = parseInt($("input[name='grid-servicos']").val());
            $("input[name='grid-servicos']").val(gridServicos+1);
        }
    });

    $(document).on('change', ".file-upload", function(){
        let key = $(this).attr('data-key');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(".img-"+key).attr('src', e.target.result)
            };
            reader.readAsDataURL(this.files[0]);
            var gridImagem = parseInt($("input[name='grid-imagem']").val());
            $("input[name='grid-imagem']").val(gridImagem+1);
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
        $('#excluirRecurso-'+key).val('0');
        var gridRecursos = parseInt($("input[name='grid-recursos']").val());
        $("input[name='grid-recursos']").val(gridRecursos-1);
        // $('.removeRecursos-'+key).remove();
    });

    $(document).on("click", ".excluirServicos", function () {
        let key = $(this).attr('data-key');
        $('.removeServicos-'+key).hide();
        $('#excluirServicos-'+key).val('0');
        var gridServicos = parseInt($("input[name='grid-servicos']").val());
        $("input[name='grid-servicos']").val(gridServicos-1);
        // $('.removeServicos-'+key).remove();
    });

    $(document).on("click", ".excluirImagem", function () {
        let key = $(this).attr('data-key');
        $('.removeImagem-'+key).hide();
        $('#excluirImagem-'+key).val('0');
        var gridImagem = parseInt($("input[name='grid-imagem']").val());
        $("input[name='grid-imagem']").val(gridImagem-1);
        // $('.removeImagem-'+key).remove();
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
      clickEscolherIconeServicos(divMostraIconesServicos);
      clickEscolherIconeImagem(divMostraIconesImagem);

   ////////////////////////////////////////////
   ///////// GALERIA DE IMAGENS ///////////////
   ////////////////////////////////////////////
 
      // ABRIR O BOX DE DESCRIÇÃO - da imagem
      $("#content-image").on("click",".editImagemDescricao", function(e){
         e.preventDefault();           
         $("#formDescricaoImagem").find("#idImagem").val($(this).attr('idimagem'));
         var idimagemdescricao = $(this).attr('idimagem');
         var posImagem = $(this).closest("li").attr("id");
         $("#formDescricaoImagem").find("#descricao_imagem").val($(this).closest("li").find("input[name='descricao_imagem[]']").val());
         $("#formDescricaoImagem").find("#posImagem").val(posImagem); 
         $( "#boxDescricao" ).dialog({
            resizable: true,
            height:140,
            width:500,
            modal: true,
            title:'Descrição da imagem:',
            open:function(event,ui){
              $(this).find('.ui-dialog .ui-dialog-content').css('background-image','none!important;');
            } 
         }); 
      });  


      //SALVAR DESCRIÇÃO - confirmacao da descricao da imagem
      $("#boxDescricao").on("click",".btSaveDescricao",function(e){
         e.preventDefault(); 
         descricao = $("#boxDescricao").find("#descricao_imagem").val();
         idImagem =  $("#boxDescricao").find("#idImagem").val(); 
         refImagem = $("#boxDescricao").find("#posImagem").val(); 
         $("#content-image li#"+refImagem).find("input[name='descricao_imagem[]']").val(descricao);

         if($("#mod").val() == "editar"){ 
             //se for editando - salva direto no banco de dados
             $.ajax({
                 url:'solucoes_script.php',
                 data:{ 
                     opx:'salvarDescricao',
                     idImagem: idImagem,
                     descricao: descricao
                 },
                 dataType:'json',
                 type:'post',
                 beforeSend:function(){
                     $.fancybox.showLoading();
                 },
                 success:function(data){

                     if(data.status == true){
                       $("#boxDescricao").dialog("close");
                       $.fancybox.hideLoading();
                       msgSucesso('Descrição salva com sucesso');
                     }else{
                       $.fancybox.hideLoading();
                       msgErro('Erro ao salvar descrição');
                     }
                 } 
             }); 
         }else{
            $("#boxDescricao").dialog("close");
         }
      }); 


      //BOTÃO EXCLUIR - na imagem       
      $("#content-image").on("click",".excluirImagem",function(e){
         e.preventDefault(); 
         ref = $(this).closest("li"); 

         $("#formDeleteImagem").find("#idPosicao").val($(ref).attr('id'));

         var idimagemdescricao = $(ref).attr('idimagem');
         $( "#excluirImagem" ).dialog({
             resizable: true,
             height:140,
             width:330,
             modal: true,  
             title:'Excluir imagem'    
         }); 
      }); 



      //EXCLUI A FOTO SELECIONADA
      $(".btExcluirImagem").click(function(e){
       
        e.preventDefault();
        idPosicao = $("#formDeleteImagem").find("#idPosicao").val();        
        idsolucoes = $("#formSolucoes").find("#idsolucoes").val();
        idsolucoes_imagem = $("#"+idPosicao).find("input[name='idsolucoes_imagem[]']").val();
        imagem = $("#"+idPosicao).find("input[name='imagem_solucoes[]']").val();
        ref = $("#"+idPosicao); 
         
        imagemDelete = $("#"+idPosicao).find("img").attr("src"); 
        imagemDelete = $("#_endereco").val()+imagemDelete.replace('galeria/thumb/',"galeria/original/");  
        
        //excluir imagem do post
        // var post = tinyMCE.get("descricao").getContent();
        // imagePost =  tinyMCE.get("descricao").dom.select('img');
        // $.each(imagePost, function(nodes, name) {
        //     img = tinyMCE.get("descricao").dom.select('img')[nodes]; 
        //     img = $(img)[0];  

        //     if(img.src == imagemDelete){ 
        //        img.remove();
        //     }
        // });

        // var post2 = tinyMCE.get("descricao").getContent(); 
        $.ajax({
            url:'solucoes_script.php',
            type:'post',
            dataType:'json', 
            data:
            {
              opx:'excluirImagemGaleria',
              idsolucoes:idsolucoes,            
              imagem:imagem,
              idsolucoes_imagem:idsolucoes_imagem
              // descricao: post2
            },
            beforeSend:function(){
              $.fancybox.showLoading();
            },        
            success:function(data){
                if(data.status){ 
                    msgSucesso('Imagem excluída com sucesso!');
                    $(ref).remove();
                    resetOrdemImagens();
                }else{
                    msgErro('Erro ao excluir imagem, tente novamente');  
                }
            },
            complete:function(){
              $.fancybox.hideLoading();
              $("#excluirImagem").dialog("close");
            }  
        });
      });


      //EXCLUI A FOTO SELECIONADA
      $(".btCancelarExclusao").click(function(e){
        $("#excluirImagem").dialog("close");
      }); 

      //BOTÃO POST - subir a imagem no texto     
      $("#content-image").on("click",".postImagem",function(e){
        e.preventDefault(); 
        postImagem($(this)); 
      }); 


      //DRAG N DROP 
      $( "#sortable" ).sortable({   
        update: function(event, ui){
           resetOrdemImagens(); 
        }
      });

      //SORTABLE IMAGES
      $( "#sortable" ).disableSelection();  
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

function clickEscolherIconeServicos(divMostraIconesServicos){
   $(".button-escolher-icone-servicos").click(function(){
      var dataKeyIcone = $(this).attr("data-key");
      // $(".div-icones").remove();
      $("#escolha-icone-servicos-"+dataKeyIcone).children().show();
      $("#escolha-icone-servicos-"+dataKeyIcone).children().html('');
      $("#escolha-icone-servicos-"+dataKeyIcone).children().append(divMostraIconesServicos);
      $(".div-icones").not($("#escolha-icone-servicos-"+dataKeyIcone).children()).hide();
      escolheIconeServicos(dataKeyIcone);
      pesquisaIconeServicos(dataKeyIcone);
      // $(".div-mostra-icones").show();
    });
}

function clickEscolherIconeImagem(divMostraIconesImagem){
   $(".button-escolher-icone-imagem").click(function(){
      var dataKeyIcone = $(this).attr("data-key");
      // $(".div-icones").remove();
      $("#escolha-icone-imagem-"+dataKeyIcone).children().show();
      $("#escolha-icone-imagem-"+dataKeyIcone).children().html('');
      $("#escolha-icone-imagem-"+dataKeyIcone).children().append(divMostraIconesImagem);
      $(".div-icones").not($("#escolha-icone-imagem-"+dataKeyIcone).children()).hide();
      escolheIconeImagem(dataKeyIcone);
      pesquisaIconeImagem(dataKeyIcone);
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
        $('div#mostrar_icone-'+dataKeyIcone).html(icone);
    });
}

function escolheIconeServicos(dataKeyIcone){
   $('i.icone_icone-servicos').click(function (e) {
        e.preventDefault();
        var nome = $(this).data('nome');
        var id = $(this).data('id');
        var icone = '';
        icone = '<i class="fa fa-' + nome + ' fa-2x" data-id="' + id + '"></i>';
        icone += '<input type="hidden" name="servicos['+dataKeyIcone+'][icone]" id="" value="' + id + '">';
        $('div#mostrar_icone_servicos-'+dataKeyIcone).html(icone);
    });
}

function escolheIconeImagem(dataKeyIcone){
   $('i.icone_icone-imagem').click(function (e) {
        e.preventDefault();
        var nome = $(this).data('nome');
        var id = $(this).data('id');
        var icone = '';
        icone = '<i class="fa fa-' + nome + ' fa-2x" data-id="' + id + '"></i>';
        icone += '<input type="hidden" name="imagem['+dataKeyIcone+'][icone]" id="" value="' + id + '">';
        $('div#mostrar_icone_imagem-'+dataKeyIcone).html(icone);
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

function pesquisaIconeServicos(dataKeyIcone){
   $('input.pesquisar_icone-servicos').keyup(function (event) {
        var pesquisa = $(this).val();
        $.ajax({
            url: 'servico_script.php?opx=pesquisaIconeServicos',
            type: 'post',
            dataType: 'html',
            data: { nome: pesquisa },
            success(data) {
                $('div.icone_pai-servicos').html(data);
                escolheIconeServicos(dataKeyIcone);
            }
        })
    });
}

function pesquisaIconeImagem(dataKeyIcone){
   $('input.pesquisar_icone-imagem').keyup(function (event) {
        var pesquisa = $(this).val();
        $.ajax({
            url: 'servico_script.php?opx=pesquisaIconeImagem',
            type: 'post',
            dataType: 'html',
            data: { nome: pesquisa },
            success(data) {
                $('div.icone_pai-imagem').html(data);
                escolheIconeServicos(dataKeyIcone);
            }
        })
    });
}

function verificaExt(input){
   //passar o input.files[i] 

   //verifica o tipo do arquivo

   switch(input.type){

      //jpg permitido

      case 'image/jpeg':

      return true;

      break;

      //jpg permitido

      case 'image/png':

      return true;

      break;

      //jpg permitido

      case 'image/gif':

      return true;

      break;

      default:

      return false;

      break;  

   }
}

//VERIFICA A IMAGEM A SER ENVIADA

function enviaImagens(input){ 
   //variável com a posição da imagem;
   quantidadeimagem = $("#sortable").find('li').length; 
   //quantas imagens estão sendo enviadas;
   var totalimagens = input.files.length;
   //tamanho máximo da imagem permitida pelo servidor;
   var tamanhoMaximo;
   tamanhoMaximo = ($("#fileMax").val())*1000000;
   var erros = "";

   numImagem = totalimagens;
   //trata cada dado de arquivo enviado pelo input
      for(var i =0; i<totalimagens; i++ ){        
         $.fancybox.showLoading(); 
         if (input.files && input.files[i]){//verifica se tem dados no input  
         if(verificaExt(input.files[i])){//se valida a extensao do arquivo  
            if(input.files[i].size > tamanhoMaximo){  
               erros += 'A imagem "'+input.files[i].name+'"'+' não foi enviada, pois, seu tamanho excede '+$("#fileMax").val()+'MB <br />';         
            }else{ 
               $.fancybox.showLoading();
               quantidadeimagem++; 
               enviaImagensAjax(input.files[i], quantidadeimagem, totalimagens);
            } 
         }else{//se não valida a extensao do arquivo  
            erros += 'A imagem "'+input.files[i].name+'"'+' não foi enviada, pois, sua extensão não é válida <br />'; 
         }

         }else{ 
            erros += 'Erro: O arquivo: "'+input.files[i].name+'" não foi enviado <br />'; 
         }  
      }  

      if(erros != ""){

      msgErro(erros);

   } 
} 

//sobe a imagem

function enviaImagensAjax(input, posicao, limite){ 
   var formData = new FormData();   
   formData.append('opx', 'salvarGaleria');   
   formData.append('imagem', input); 
   formData.append('idsolucoes', $("#idsolucoes").val()); 
   formData.append('posicao', posicao); 

   $.ajax({ 
      url: "solucoes_script.php", 
      type: "POST", 
      dataType: "json", 
      data: formData, 
      processData: false,  // tell jQuery not to process the data 
      contentType: false,   // tell jQuery not to set contentType  
      //SE DER TUDO CERTO NO AJAX TEMOS QUE MUDAR ALGUMAS COISAS NOS "appends" ANTERIORES
      beforeSend:function(){ 
         $.fancybox.showLoading();  
         $(".ui-sortable").css('opacity',0.3);   
      }, 
      success:function(data){  
         if(data.status == true){ 
            $li = '<li class="ui-state-default'+posicao+' move" id="'+posicao+'" idimagem="'+data.idsolucoes_imagem+'">';
            $li += '<img id="img'+posicao+'" class="imagem-gallery" style="opacity:1;" src="'+data.caminho+'">';
            $li += '<a class="editImagemDescricao" idimagem="'+data.idsolucoes_imagem+'" href="#"><button class="edit"></button></a>';
            $li += '<a class="excluirImagem" idimagemdelete="'+data.idsolucoes_imagem+'" href="#"><button class="delete"></button></a>';
            // $li += '<a class="postImagem" idimagempost="'+data.idsolucoes_imagem+'" href="#"><button class="post_imagem"></button></a>'; 
            // $li += '<a class="postImagem" idimagempost="'+data.idsolucoes_imagem+'" href="#"><button class="post_imagem"></button></a>';
            $li += '<input type="hidden" name="idsolucoes_imagem[]" value="'+data.idsolucoes_imagem+'">'; 
            $li += '<input type="hidden" name="descricao_imagem[]" value="">'; 
            $li += '<input type="hidden" name="imagem_solucoes[]" value="'+data.nome_arquivo+'">';
            $li += '<input type="hidden" name="posicao_imagem[]" value="'+posicao+'">';
            $li += '</li>'; 
            $("#sortable").append($li); 
            $("#idsolucoes").val(data.idsolucoes); 
            if(numImagem > 1){
               numImagem = numImagem -1;
            }else{ 
               $.fancybox.hideLoading();
               $("#sortable").removeAttr("style");  
            } 
         }//fim if
         else{
            msgErro('Erro ao enviar imagem, por favor tente novamente!'); 
         }  
      } 
   });  
   //fim AJAX  
} 

//ORDENA A POSICAO DAS IMAGENS SE UMA IMAGEM É APAGADA

function resetOrdemImagens(){
   $lis = $("#sortable").find("li"); 

   $.each($lis, function(index, value){ 
      pos = parseInt(index) + parseInt(1); 
      $(this).removeClass();  
      $(this).addClass("ui-state-default"+ pos + " move");  
      $(this).attr("id", pos);  
      $(this).find("input[name='posicao_imagem[]']").val(pos); 
   }); 



   if($("#mod").val() == "editar"){  
      //editar a ordem das imagens  
      form = $("#formSolucoes").serialize(); 

      $.ajax({ 
         url: "solucoes_script.php", 
         type: "POST", 
         dataType: "json",  
         data: "opx=alterarPosicaoImagem&"+form, 
         beforeSend:function(){ 
            $.fancybox.showLoading();   
         }, 
         success:function(data){  
            if(data.status == true){  
               $.fancybox.hideLoading();   
            }  
            else{ 
               msgErro('Erro ao alterar posição da imagem. Tente novamente'); 
            }  
         }, 
         complete:function(data){ 
            $.fancybox.hideLoading();  
         } 
      });  
   }
}

function postImagem(campo){ 
   ref = $(campo).parent();
   imagem = $(ref).find("img").attr("src");
   imagem = imagem.replace('galeria/thumb/',"galeria/original/");
   link = $("#_endereco").val()+imagem; 
   // var post = tinyMCE.get("descricao").getContent();
   // post += '<img src="'+link+'" alt="" data-mce-src="'+link+'"/>';
   // tinyMCE.get("descricao").setContent(post);
   // alterarDataSrc();
}

function alterarDataSrc(){  
   var post = tinyMCE.get("descricao").getContent();
   imagePost =  tinyMCE.get("descricao").dom.select('img');
   $.each(imagePost, function(nodes, name) {
      imgDescricao = tinyMCE.get("descricao").dom.select('img')[nodes]; 
      img = $(imgDescricao)[0];
      src = img.src; 
      $(imgDescricao).attr("data-mce-src",src);
   }); 
}

$(window).load(function(){
   // alterarDataSrc();
})