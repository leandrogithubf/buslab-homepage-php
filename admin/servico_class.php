<?php
// Versao do modulo: 3.00.010416


/**
 * <p>salva servico no banco</p>
 */
function cadastroServico($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}
	$sql = "INSERT INTO servico( nome, pessoa, icone, descricao) VALUES (
						'" . $dados['nome'] . "',
						'" . $dados['pessoa'] . "',
						'" . $dados['icone'] . "',
						'" . $dados['descricao'] . "')";
	if (mysqli_query($conexao, $sql)) {
		$resultado = mysqli_insert_id($conexao);
		return $resultado;
	} else {
		return false;
	}
}

/**
 * <p>edita servico no banco</p>
 */
function editServico($dados)
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v)) continue;
		if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	$sql = "UPDATE servico SET
						nome = '" . $dados['nome'] . "',
						pessoa = '" . $dados['pessoa'] . "',
						icone = '" . $dados['icone'] . "',
						descricao = '" . $dados['descricao'] . "'
					WHERE idservico = " . $dados['idservico'];

	if (mysqli_query($conexao, $sql)) {
		return $dados['idservico'];
	} else {
		return false;
	}
}

/**
 * <p>busca servico no banco</p>
 */
function buscaServico($dados = array())
{
	include "includes/mysql.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v) || $k == "colsSql") continue;
		if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	//busca pelo id
	$buscaId = '';
	if (array_key_exists('idservico', $dados) && !empty($dados['idservico']))
		$buscaId = ' and idservico = ' . intval($dados['idservico']) . ' ';

	//busca pelo nome
	$buscaNome = '';
	if (array_key_exists('nome', $dados) && !empty($dados['nome']))
		$buscaNome = ' and nome LIKE "%' . $dados['nome'] . '%" ';


	//busca pelo pessoa
	$buscaPessoa = '';
	if (array_key_exists('pessoa', $dados) && !empty($dados['pessoa']))
		$buscaPessoa = ' and pessoa LIKE "%' . $dados['pessoa'] . '%" ';


	//busca pelo icone
	$buscaIcone = '';
	if (array_key_exists('icone', $dados) && !empty($dados['icone']))
		$buscaIcone = ' and icone LIKE "%' . $dados['icone'] . '%" ';


	//busca pelo descricao
	$buscaDescricao = '';
	if (array_key_exists('descricao', $dados) && !empty($dados['descricao']))
		$buscaDescricao = ' and descricao LIKE "%' . $dados['descricao'] . '%" ';

	//ordem
	$orderBy = "";
	if (isset($dados['ordem']) && !empty($dados['ordem']) && isset($dados['dir'])) {
		$orderBy = ' ORDER BY ' . $dados['ordem'] . " " . $dados['dir'];
	}

	//busca pelo limit
	$buscaLimit = '';
	if (array_key_exists('limit', $dados) && !empty($dados['limit']) && array_key_exists('pagina', $dados)) {
		$buscaLimit = ' LIMIT ' . ($dados['limit'] * $dados['pagina']) . ',' . $dados['limit'] . ' ';
	} elseif (array_key_exists('limit', $dados) && !empty($dados['limit']) && array_key_exists('inicio', $dados)) {
		$buscaLimit = ' LIMIT ' . $dados['limit'] . ',' . $dados['inicio'] . ' ';
	} elseif (array_key_exists('limit', $dados) && !empty($dados['limit'])) {
		$buscaLimit = ' LIMIT ' . $dados['limit'];
	}

	//colunas que serão buscadas
	$colsSql = '*';
	if (array_key_exists('totalRecords', $dados)) {
		$colsSql = ' count(idservico) as totalRecords';
		$buscaLimit = '';
		$orderBy = '';
	} elseif (array_key_exists('colsSql', $dados)) {
		$colsSql = ' ' . $dados['colsSql'] . ' ';
	}

	$sql = "SELECT $colsSql FROM servico WHERE 1  $buscaId  $buscaNome  $buscaPessoa  $buscaIcone  $buscaDescricao  $orderBy $buscaLimit ";

	$query = mysqli_query($conexao, $sql);
	$resultado = array();
	while ($r = mysqli_fetch_assoc($query)) {
		if (!array_key_exists('totalRecords', $dados)) {
			$r = array_map('utf8_encode', $r);
			$StringIcone = strlen($r['icone']);
			if ($StringIcone < 4) {
				$icones_Edit = buscaFW(array('idfw' => $r['icone']));
				$icones_Edit = $icones_Edit[0];
			}
			$StringIcone > 4 ? $r['icone_caminho'] = "<img src='files/servico/" . $r['icone'] . "' width='25' />" : $r['icone_caminho'] = '<i class="fa fa-' . $icones_Edit['nome'] . ' fa-2x"></i>';
			$StringIcone > 4 ? $r['icone_front'] = "<img src='admin/files/servico/" . $r['icone'] . "' width='30' class='mr-2' />" : $r['icone_front'] = '<i class="fa fa-' . $icones_Edit['nome'] . ' fa-lg mr-2" style="color:#2460a7"></i>';
			$r['tipo_pessoa'] = $r['pessoa'] == 'F' ? 'Física' : ' Jurídica';
		}
		$resultado[] = $r;
	}
	return $resultado;
}

/**
 * <p>deleta servico no banco</p>
 */
function deletaServico($dados)
{
	include "includes/mysql.php";

	$sql = "DELETE FROM servico WHERE idservico = $dados";
	if (mysqli_query($conexao, $sql)) {
		return mysqli_affected_rows($conexao);
	} else {
		return FALSE;
	}
}


/**
 * <p> ESCOLHA OU ANEXO DE ICONES 
 * 
 **/
function buscaFW($dados = array())
{
	include "includes/mysql.php";
	include_once "includes/functions.php";

	foreach ($dados as $k => &$v) {
		if (is_array($v) || $k == "colsSql") continue;
		if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$v = mysqli_real_escape_string($conexao, utf8_decode($v));
	}

	//busca pelo id
	$buscaId = '';
	if (array_key_exists('idfw', $dados) && !empty($dados['idfw']))
		$buscaId = ' and C.idfw = ' . intval($dados['idfw']) . ' ';

	//busca pelo nome
	$buscaNome = '';
	if (array_key_exists('nome', $dados) && !empty($dados['nome']))
		$buscaNome = ' and C.nome LIKE "%' . $dados['nome'] . '%" ';

	//ordem
	$orderBy = "";
	if (array_key_exists('ordem', $dados) && !empty($dados['ordem'])) {
		$orderBy = ' ORDER BY ' . $dados['ordem'];
		if (array_key_exists('dir', $dados) && !empty($dados['dir'])) {
			$orderBy .= " " . $dados['dir'];
		}
	}

	//busca pelo limit
	$buscaLimit = '';
	if (array_key_exists('limit', $dados) && !empty($dados['limit']) && array_key_exists('pagina', $dados)) {
		$buscaLimit = ' LIMIT ' . ($dados['limit'] * $dados['pagina']) . ',' . $dados['limit'] . ' ';
	} elseif (array_key_exists('limit', $dados) && !empty($dados['limit']) && array_key_exists('inicio', $dados)) {
		$buscaLimit = ' LIMIT ' . $dados['limit'] . ',' . $dados['inicio'] . ' ';
	} elseif (array_key_exists('limit', $dados) && !empty($dados['limit'])) {
		$buscaLimit = ' LIMIT ' . $dados['limit'];
	}

	//colunas que serão buscadas
	$colsSql = 'C.*';
	if (array_key_exists('totalRecords', $dados)) {
		$colsSql = ' count(idservicos) as totalRecords';
		$buscaLimit = '';
		$orderBy = '';
	} elseif (array_key_exists('colsSql', $dados)) {
		$colsSql = ' ' . $dados['colsSql'] . ' ';
	}

	$buscaMax = '';
	if (array_key_exists('max', $dados))
		$buscaMax = ', max(' . $dados['max'] . ') as max ';


	$sql = "SELECT $colsSql FROM fw as C
		WHERE 1  $buscaId  $buscaNome $orderBy $buscaLimit ";

	$query = mysqli_query($conexao, $sql);
	$resultado = array();
	$iAux = 1;
	$tot =  mysqli_affected_rows($conexao);
	while ($r = mysqli_fetch_assoc($query)) {
		$r = array_map('utf8_encode', $r);
		$resultado[] = $r;
	}
	return $resultado;
}
// <!========================== FIM ESCOLHA OU ANEXO DE ICONES ========================== !>