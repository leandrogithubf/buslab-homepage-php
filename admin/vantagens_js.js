// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;
var flag = "";

function preTableVantagens(){
		 $("#limit").change(function(){
	         $("#pagina").val(1);
	         dataTableVantagens();
	    });

	    $("#pagina").keyup(function(e){
	         if(e.keyCode == 13){
	             if(totalPaginasGrid >= $(this).val() && $(this).val() > 0){
	                 dataTableVantagens();
	             }else{
	                 msgErro("Número de página deve ser entre 1 e "+totalPaginasGrid);
	             }
	         }
	    });

	    $(".next").click(function(e){
	          e.preventDefault();
	          $("#pagina").val($(this).attr('proximo'));
	          dataTableVantagens();
	    });

	    $(".prev").click(function(e){
	         e.preventDefault();
	         $("#pagina").val($(this).attr('anterior'));
	         dataTableVantagens();
	    });


	    //LISTAGEM BUSCA
	    $("#buscarapida").keyup(function(event){
	        event.preventDefault();
	        if(event.keyCode == '13') {
                $('#pagina').val(1);
	            pesquisar = "&titulo="+$("#buscarapida").val();
	            dataTableVantagens();
	        }
	        return true;
	    });

	    $("#filtrar").click(function(e){
	        e.preventDefault();
          $('#pagina').val(1);
	        pesquisar = "&"+$("#formAvancado").serialize();
	        dataTableVantagens();
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
	         dataTableVantagens();
	   }); 

      $('.table').on("click",".ordemUp",function(e){ 
          var params = { idvantagens: $(this).attr("codigo")}
          $.post( 'vantagens_script.php?opx=alteraOrdemCima', params,
                function(data){  
                  var resultado = new String (data.status); 
                  if(resultado.toString() == 'sucesso'){ 
                       dataTableVantagens(); 
                  }  
                  else if (resultado == 'falha'){ 
                       alert('Não foi possível atender a sua solicitação.')
                  }
              },'json'
          );  
      });  
         

    $('.table').on("click", ".ordemDown", function(e){  
        var params = {idvantagens: $(this).attr("codigo")}  
        $.post( 'vantagens_script.php?opx=alteraOrdemBaixo', params,
         function(data){  
            var resultado = new String (data.status);  
            if(resultado.toString() == 'sucesso'){ 
              dataTableVantagens(); 
            }  
            else if (resultado == 'falha'){ 
              alert('Não foi possível atender a sua solicitação.')
            } 
          },'json' 
        );  
    }); 
}

var myColumnDefs = [
	{key:"idvantagens", sortable:true, label:"ID", print:true, data:true},
	{key:"titulo", sortable:true, label:"Título", print:true, data:true}, 
   {key:"bandeira", sortable:true, label:"Idioma", print:true, data:true}, 
  // {key:"descricao", sortable:false, label:"Descrição", print:true, data:true},
  { key: "ordem", sortable: false, label: "Ordem", print: true, data: false },
  { key: "ordemUp", sortable: false, label: "Subir", print: false, data: true },
  { key: "ordemDown", sortable: false, label: "Descer", print: false, data: true },
]

function columnVantagens(){ 
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

function dataTableVantagens(){
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
                      tr += '<a href="index.php?mod=vantagens&acao=formVantagens&met=editVantagens&idu='+value.idvantagens+'"><img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
                      tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro '+value.nome+' ?\',\'php\', \'vantagens_script.php?opx=deletaVantagens&idu='+value.idvantagens+'\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
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

function carregaIconeServico() {
    $('i.icone_icone_categ').click(function (e) {
        e.preventDefault();
        var nome = $(this).data('nome');
        var id = $(this).data('id');
        var icone = '';
        icone = '<i class="fa fa-' + nome + ' fa-2x" data-id="' + id + '"></i>';
        icone += '<input type="hidden" name="icone_categ" id="icone_categ" data-icone="' + nome + '" value="' + id + '">';
        $('div#mostrar_icone_categ').html(icone);
    });
}

function carregaIconeAcao() {
    $('i.icone_icone').click(function (e) {
        e.preventDefault();
        var nome = $(this).data('nome');
        var id = $(this).data('id');
        var icone = '';
        icone = '<i class="fa fa-' + nome + ' fa-2x" data-id="' + id + '"></i>';
        icone += '<input type="hidden" name="icone" id="icone" value="' + id + '">';
        $('div#mostrar_icone').html(icone);
    });
}

$(document).ready(function(){

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

    $('input#numero').keyup(function() {
        $(this).val(this.value.replace(/\D/g, ''));
    });

 
  	$("#inputImage").change(function(){
  		$("#img-container").css('display','block');
  		$("#imagem_icone").val(true);
  	});  
     

  	$(".bt_save").click(function(event){
  		  event.preventDefault(); 
    		var valida = true;
    		msg = "";
    		$("#inputImage").css("border", "1px solid #d9d9d9");
    		$('#formVantagens').find('.required').each(function(){
    	      	$(this).css("border","1px solid #d9d9d9"); 
    	      	if($(this).attr('name') == 'imagem_icone' && $(this).val() == ""){
    	            $("#inputImage").css("border", "solid 1px  red");
    	            valida = false;
    	      	} 
    	      	else{ 
    		        if($.trim($(this).val())==''){ 
                    if (this.type == "select-one") {
                       $(this).parent().css("border", "solid 1px red");     
                    } 
		                else {
                      $(this).css("border", "solid 1px red");		                  
                    }
                    valida = false; 
    		        }
    		    }
    		});  

    		if(valida){
    		    $.fancybox.showLoading();  
    		    $('#formVantagens').submit();
    		}else{
    		   msgErro('Preencha o(s) campo(s) obrigatórios!');
    		}
	});


//SE CANCELAR O CADASTRO EXCLUI AS IMAGENS, SE HOUVER
$(".bt_cancel").click(function(e){
  e.preventDefault();
  
  if($("#mod").val() == 'cadastro' && $('#idvantagens').val() != 0){
      $.ajax({
          url:'vantagens_script.php',
          data: { opx:'excluiImagensTemporarias', idgaleria:$('#idgaleria').val()},
          dataType:'json',
          type:'post',
          success:function(data){
          if(data.status == true){
              location.href = 'index.php?mod=galeria&acao=listarGaleria';
          } 
          }
      });
  }else{
    location.href = 'index.php?mod=vantagens&acao=listarVantagens';
  }
});

    

////////////////////////////////////////////
///////// GALERIA DE IMAGENS //////////////
//////////////////////////////////////////

    $("#image").change(function(){              
        enviaImagens(this);  
    }); 


    // ABRIR O BOX DE DESCRIÇÃO - da imagem
    $("#content-image").on("click",".cropImagem", function(e){
        e.preventDefault();  
        idimagem = $(this).closest("li").attr("id");
        pasta = "vantagens"; 
        idrelacao = $("#idvantagens").val();
        width = 175;
        height = 130;
        nome_imagem = $(this).closest("li").find("input[name='imagem_vantagens[]']").val();
        $.ajax({
            data: { 'acao': 'crop_galeria', 'idimagem':idimagem, 'pastaUpload':'thumb','idrelacao':idrelacao,"nome_imagem":nome_imagem, "pasta":pasta, "width":width, "height":height},          
            success: function(telaStatus){
              if(telaStatus != 'false'){  
                $.facebox(telaStatus);  
                $("#img-containerGaleria").css('display','block'); 
                $("#inputImageGaleria").trigger("click");
              }
            },
            type: 'post',
            url: 'cropImagem_galeria.php'
        }); 
    });   


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
              url:'vantagens_script.php',
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
        idvantagens = $("#formVantagens").find("#idvantagens").val();
        idvantagens_imagem = $("#"+idPosicao).find("input[name='idvantagens_imagem[]']").val();
        imagem = $("#"+idPosicao).find("input[name='imagem_vantagens[]']").val();

        ref = $("#"+idPosicao);

        imagemDelete = $("#"+idPosicao).find("img").attr("src"); 
        imagemDelete = imagemDelete.replace('original/',"thumb/");

         //excluir imagem do post
        var post = tinyMCE.get("descricao").getContent();
        imagePost =  tinyMCE.get("descricao").dom.select('img')
        $.each(imagePost, function(nodes, name) {
            img = tinyMCE.get("descricao").dom.select('img')[nodes]; 
            img = $(img)[0];  
            if(img.src == imagemDelete){ 
               img.remove();
            }
        });

        var post2 = tinyMCE.get("descricao").getContent(); 
        $.ajax({
            url:'vantagens_script.php',
            type:'post',
            dataType:'json', 
            data:
            {
              opx:'excluirImagemGaleria',
              idvantagens:idvantagens,            
              imagem:imagem,
              idvantagens_imagem:idvantagens_imagem,
              descricao: post2
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
 
});  



////////////////////////////////////////////
///////// FUNCTION GALERIA DE IMAGENS /////
//////////////////////////////////////////

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
  formData.append('idvantagens', $("#idvantagens").val());
  formData.append('posicao', posicao); 

  $.ajax({
    url: "vantagens_script.php",
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
            $li = '<li class="ui-state-default'+posicao+' move" id="'+posicao+'" idimagem="'+data.idvantagens_imagem+'">';
            $li += '<img id="img'+posicao+'" class="imagem-gallery" style="opacity:1;" src="'+data.caminho+'">';
            $li += '<a class="editImagemDescricao" idimagem="'+data.idvantagens_imagem+'" href="#"><button class="edit"></button></a>';
            $li += '<a class="excluirImagem" idimagemdelete="'+data.idvantagens_imagem+'" href="#"><button class="delete"></button></a>';
            //$li += '<a class="postImagem" idimagempost="'+data.idvantagens_imagem+'" href="#"><button class="post_imagem"></button></a>'; 
            //$li += '<a class="cropImagem" idImagemCrop="'+data.idvantagens_imagem+'"><button class="crop_imagem"></button></a>'; 
            $li += '<input type="hidden" name="idvantagens_imagem[]" value="'+data.idvantagens_imagem+'">'; 
            $li += '<input type="hidden" name="descricao_imagem[]" value="">'; 
            $li += '<input type="hidden" name="imagem_vantagens[]" value="'+data.nome_arquivo+'">';
            $li += '<input type="hidden" name="posicao_imagem[]" value="'+posicao+'">';
            $li += '</li>'; 
            $("#sortable").append($li); 
            $("#idvantagens").val(data.idvantagens); 
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
     form = $("#formVantagens").serialize();
      
      $.ajax({
          url: "vantagens_script.php",
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


////////////////////////////////////////////
/// fim FUNCTION GALERIA DE IMAGENS ///////
//////////////////////////////////////////
