// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;
function preTableAtuacao(){
		$("#limit").change(function(){
	         $("#pagina").val(1);
	         dataTableAtuacao();
	    });

	    $("#pagina").keyup(function(e){
	         if(e.keyCode == 13){
	             if(totalPaginasGrid >= $(this).val() && $(this).val() > 0){
	                 dataTableAtuacao();
	             }else{
	                 msgErro("numero de pagina deve ser entre 1 e "+totalPaginasGrid);
	             }
	         }
	    });

	    $(".next").click(function(e){
	          e.preventDefault();
	          $("#pagina").val($(this).attr('proximo'));
	          dataTableAtuacao();
	    });

	    $(".prev").click(function(e){
	         e.preventDefault();
	         $("#pagina").val($(this).attr('anterior'));
	         dataTableAtuacao();
	    });


	    //LISTAGEM BUSCA
	    $("#buscarapida").keyup(function(event){
	        event.preventDefault();
	        if(event.keyCode == '13') {
                $('#pagina').val(1);
	            pesquisar = "&nome="+$("#buscarapida").val();
	            dataTableAtuacao();
	        }
	        return true;
	    });

	    $("#filtrar").click(function(e){
	        e.preventDefault();
            $('#pagina').val(1);
	        pesquisar = "&"+$("#formAvancado").serialize();
	        dataTableAtuacao();
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
	         dataTableAtuacao();
	    });

       $('.table').on("click",".ordemUp",function(e){
            var params = {
                idatuacao: $(this).attr("codigo") 
            }

            $.post(
                'atuacao_script.php?opx=alteraOrdemCima',
                params,
                function(data){
                    var resultado = new String (data.status);

                    if(resultado.toString() == 'sucesso'){
                        dataTableAtuacao();
                    }
                    else if (resultado == 'falha'){
                        alert('Não foi possível atender a sua solicitação.')
                    }

                },'json'
            );
        });

        $('.table').on("click", ".ordemDown", function(e){
                var params = {
                    idatuacao: $(this).attr("codigo") 
                }

                $.post(
                    'atuacao_script.php?opx=alteraOrdemBaixo',
                    params,
                    function(data){
                        var resultado = new String (data.status);

                        if(resultado.toString() == 'sucesso'){
                            dataTableAtuacao();
                        }
                        else if (resultado == 'falha'){
                            alert('Não foi possível atender a sua solicitação.')
                        }

                    },'json'
                );
        });

}
	var myColumnDefs = [
		{key:"idatuacao", sortable:true, label:"ID", print:true, data:true},
		{key:"nome", sortable:true, label:"Nome", print:true, data:true},
      {key:"bandeira", sortable:true, label:"Idioma", print:true, data:true},
      {key:"ordem", sortable:false, label:"Ordem", print:true, data:false},
      {key:"ordemUp", sortable:false, label:"Subir",  print:false, data:true},
      {key:"ordemDown", sortable:false, label:"Descer",  print:false, data:true}
	]
function columnAtuacao(){
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
function dataTableAtuacao(){
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
                                tr += '<a href="index.php?mod=atuacao&acao=formAtuacao&met=editAtuacao&idu='+value.idatuacao+'"><img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
                                tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro '+value.nome+' ?\',\'php\', \'atuacao_script.php?opx=deletaAtuacao&idu='+value.idatuacao+'\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
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
$(document).ready(function(){
	$(".img").change(function(){
        var filename = $(this).val();
        var extension = filename.replace(/^.*\./, '');
        if (extension == filename) { extension = '';
        }else{ extension = extension.toLowerCase(); }
       
        if(extension!='jpg' && extension!='png' && extension!='gif' && extension!='jpeg' ){
          msgErro('A extensão deste arquivo não é permitida!');
          return false;
        }

        var tamanhoMaximo ;
        tamanhoMaximo = ($("#maxFileSize").val())*1000000; 
        if($(this)[0].files[0].size >  tamanhoMaximo){
            msgErro('Arquivo muito grande!');
            return false;
        }

        tipo = $(this).attr("tipo");

        //início AJAX
        var formData = new FormData();
        formData.append('imagem', this.files[0]);
        formData.append('opx', 'salvaImagem');
        formData.append('tipo_atuacao', $(this).attr("tipo"));             
        formData.append('idatuacao', $("#idatuacao").val());
        if(tipo == "logo"){ 
          formData.append('imagem_antigo', $("#logo").val());
        }else{
          formData.append('imagem_antigo', $("#imagem").val());
        } 

        $.ajax({
            url: "atuacao_script.php",
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
                    if(tipo == "logo"){
                      $('.imagem_logo').attr('src', data.caminho).show(); 
                      $('#banner_logo').val(data.nome_arquivo);
                    }else{
                      $('.imagem_grande').attr('src', data.caminho).show(); 
                      $('#banner_full').val(data.nome_arquivo);
                    }
                    $("#idbanner").val(data.idbanner); 
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
});
