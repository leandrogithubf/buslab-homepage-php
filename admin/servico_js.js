// Versao do modulo: 3.00.010416

var preventCache = Math.random();
var requestInicio = "";
var ordem = "";
var dir = "";
var pesquisar = "";
var limit = 20;
var pagina = 0;
var totalPaginasGrid = 1;
function preTableServico(){
	$("#limit").change(function(){
			$("#pagina").val(1);
			dataTableServico();
	});

	$("#pagina").keyup(function(e){
			if(e.keyCode == 13){
				if(totalPaginasGrid >= $(this).val() && $(this).val() > 0){
					dataTableServico();
				}else{
					msgErro("numero de pagina deve ser entre 1 e "+totalPaginasGrid);
				}
			}
	});

	$(".next").click(function(e){
			e.preventDefault();
			$("#pagina").val($(this).attr('proximo'));
			dataTableServico();
	});

	$(".prev").click(function(e){
			e.preventDefault();
			$("#pagina").val($(this).attr('anterior'));
			dataTableServico();
	});


	//LISTAGEM BUSCA
	$("#buscarapida").keyup(function(event){
		event.preventDefault();
		if(event.keyCode == '13') {
			$('#pagina').val(1);
			pesquisar = "&nome="+$("#buscarapida").val();
			dataTableServico();
		}
		return true;
	});

	$("#filtrar").click(function(e){
		e.preventDefault();
		$('#pagina').val(1);
		pesquisar = "&"+$("#formAvancado").serialize();
		dataTableServico();
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
			dataTableServico();
	});
}
var myColumnDefs = [
	{key:"idservico", sortable:true, label:"ID Servico", print:true, data:false},
	{key:"icone_caminho", sortable: true, label: "Icone", print:false, data: true },
	{key:"nome", sortable:true, label:"Nome", print:true, data:true},
	{key:"pessoa", sortable:true, label:"Pessoa", print:true, data:false},
	{key:"tipo_pessoa", sortable:true, label:"Pessoa", print:true, data:true},
	{key:"icone", sortable:true, label:"Icone", print:true, data:false},
	{key:"descricao", sortable:true, label:"Descricao", print:true, data:false}
]
function columnServico(){
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

function dataTableServico(){
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
									console.log(value);
									tr += '<td><span>'+value[key]+'</span></td>';
								}
							});

							tr += '<td><div class="acts">';
							tr += '<a href="index.php?mod=servico&acao=formServico&met=editServico&idu='+value.idservico+'">';
							tr += '<img src="images/ico_edit.png" height="16" width="16" alt="ico" /><div class="tt"><span class="one">Editar</span><span class="two"></span></div></a>';
							tr += '<a href="#" onclick="wConfirm(\'Excluir Registro\',\'Tem certeza que deseja excluir o registro '+value.nome+' ?\',\'php\', \'servico_script.php?opx=deletaServico&idu='+value.idservico+'\');"><img src="images/ico_del.png" height="17" width="17" alt="ico" /><div class="tt"><span class="one">Excluir</span><span class="two"></span></div></a>';
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

$(document).ready(function () {
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
});