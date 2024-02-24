<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva contatos no banco</p>
	 */
	function cadastroContatos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);
		$dados['email'] = trim($dados['email']);
		$dados['empresa'] = trim($dados['empresa']);
		$dados['mensagem'] = trim($dados['mensagem']);

		date_default_timezone_set('America/Sao_Paulo');
		$data = date("Y-m-d H:i:s"); 
		
		$sql = "INSERT INTO contatos(nome, email, telefone, empresa, assunto, mensagem, ididiomas, conheceu,segmento,cargo,cpf,pedido,plataforma,marca) VALUES (
				'".((isset($dados['nome']))?$dados['nome']:'')."',
				'".((isset($dados['email']))?$dados['email']:'')."',
				'".((isset($dados['telefone']))?$dados['telefone']:'')."',
				'".((isset($dados['empresa']))?$dados['empresa']:'')."',
				'".((isset($dados['assunto']))?$dados['assunto']:'')."',
            '".((isset($dados['mensagem']))?$dados['mensagem']:'')."',
				'".((isset($dados['ididiomas']))?$dados['ididiomas']:'')."',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0',
                '0'
            )";
 	  
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao); 
			return $resultado;
		} else {
			return false;
		}
	} 

	/**
	 * <p>edita contatos no banco</p>
	 */
	function editContatos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);
		$dados['email'] = trim($dados['email']);
		$dados['empresa'] = trim($dados['empresa']);
		$dados['mensagem'] = trim($dados['mensagem']);

		$sql = "UPDATE contatos SET
						nome = '".$dados['nome']."',
						email = '".$dados['email']."',
						telefone = '".$dados['telefone']."',
						empresa = '".$dados['empresa']."',
						assunto = '".$dados['assunto']."',
                  mensagem = '".$dados['mensagem']."',
						ididiomas = '".$dados['ididiomas']."'
					WHERE idcontatos = " . $dados['idcontatos'];
		 
		if (mysqli_query($conexao, $sql)) {
			return $dados['idcontatos'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca contatos no banco</p>
	 */
	function buscaContatos($dados = array())
	{
		include "includes/mysql.php";
		include_once "includes/functions.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idcontatos',$dados) && !empty($dados['idcontatos']) )
			$buscaId = ' and C.idcontatos = '.intval($dados['idcontatos']).' '; 

      //busca pelo id
      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and C.ididiomas = '.intval($dados['ididiomas']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and C.nome LIKE "%'.$dados['nome'].'%" ';

		//busca pelo email
		$buscaEmail = '';
		if (array_key_exists('email',$dados) && !empty($dados['email']) )
			$buscaEmail = ' and C.email LIKE "%'.$dados['email'].'%" ';

		//busca pelo telefone
		$buscaTelefone = '';
		if (array_key_exists('telefone',$dados) && !empty($dados['telefone']) )
			$buscaTelefone = ' and C.telefone LIKE "%'.$dados['telefone'].'%" ';

        //ordem
        $orderBy = "";
        if (isset($dados['ordem']) && !empty($dados['ordem']) && isset($dados['dir'])){
			$orderBy = ' ORDER BY '.$dados['ordem'] ." ". $dados['dir'];
        }

        //busca pelo limit
		$buscaLimit = '';
		if (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('pagina',$dados)) {
            $buscaLimit = ' LIMIT '.($dados['limit'] * $dados['pagina']).','.$dados['limit'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('inicio',$dados)){
            $buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['inicio'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
            $buscaLimit = ' LIMIT '.$dados['limit'];
        }

		//colunas que serão buscadas
		// $colsSql = 'C.*, I.idioma'; 
		$colsSql = 'C.*'; 

		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(C.idcontatos) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		// $sql = "SELECT $colsSql, date_format(C.data_hora, '%d/%m/%Y') as data_formatada
		// 		FROM contatos as C  
		// 		INNER JOIN idiomas as I on C.ididiomas = I.ididiomas
		// 		WHERE 1 $buscaId $buscaIdIdiomas $buscaNome $buscaAssunto $buscaMensagem $buscaEmail $buscaTelefone $buscaObservacao $buscaData $orderBy $buscaLimit ";
      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql	FROM contatos as C WHERE 1 $buscaId $buscaIdIdiomas $buscaNome $buscaEmail $buscaTelefone $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql, I.bandeira FROM contatos as C INNER JOIN idiomas as I on C.ididiomas = I.ididiomas WHERE 1 $buscaId $buscaIdIdiomas $buscaNome $buscaEmail $buscaTelefone $orderBy $buscaLimit ";
      }
		
		
		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
         if (!array_key_exists('totalRecords',$dados)){
            $r['bandeira'] = "<img src=files/idiomas/".$r['bandeira'].">";
         }
			$resultado[] = $r;
		} 
		return $resultado;  
 	}

	/**
	 * <p>deleta contatos no banco</p>
	 */
	function deletaContatos($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM contatos WHERE idcontatos = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	} 
	 
?>