<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva clientes no banco</p>
	 */
	function cadastroClientes($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

      $atuacaoString = '';

      foreach ($dados['atuacoes'] as $key => $atuacoes) {
         $atuacaoString .= $atuacoes.', ';
      }

      $atuacaoString = substr($atuacaoString, 0, -2);

      // print_r($atuacaoString);die;

		$sql = "INSERT INTO clientes( nome, logo, atuacoes, categoria, texto, imagem, servicos, destaque) VALUES (
						'".$dados['nome']."',
                        '".$dados['logo']."',
						'".$atuacaoString."',
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
	 * <p>edita clientes no banco</p>
	 */
	function editClientes($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

      $atuacaoString = '';

      // print_r($dados);die;

      foreach ($dados['atuacoes'] as $key => $atuacoes) {
         $atuacaoString .= $atuacoes.', ';
      }

      $atuacaoString = substr($atuacaoString, 0, -2);

		$sql = "UPDATE clientes SET
						nome = '".$dados['nome']."',
                  logo = '".$dados['logo']."',
						atuacoes = '".$atuacaoString."'
					WHERE idclientes = " . $dados['idclientes'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idclientes'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca clientes no banco</p>
	 */
	function buscaClientes($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idclientes',$dados) && !empty($dados['idclientes']) )
			$buscaId = ' and C.idclientes = '.intval($dados['idclientes']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and C.nome LIKE "%'.$dados['nome'].'%" '; 

      //busca pelo atuacoes
      $buscaAtuacoes = '';
      if (array_key_exists('atuacoes',$dados) && !empty($dados['atuacoes']) )
         $buscaAtuacoes = ' and C.atuacoes LIKE "%'.$dados['atuacoes'].'%" '; 


		//busca pelo logo
		$buscaLogo = '';
		if (array_key_exists('logo',$dados) && !empty($dados['logo']) )
			$buscaLogo = ' and C.logo LIKE "%'.$dados['logo'].'%" '; 


		//busca pelo categoria
		$buscaCategoria = '';
		if (array_key_exists('categoria',$dados) && !empty($dados['categoria']) )
			$buscaCategoria = ' and C.categoria = '.$dados['categoria'].' '; 


		//busca pelo texto
		$buscaTexto = '';
		if (array_key_exists('texto',$dados) && !empty($dados['texto']) )
			$buscaTexto = ' and C.texto LIKE "%'.$dados['texto'].'%" '; 


		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and C.imagem LIKE "%'.$dados['imagem'].'%" '; 


		//busca pelo servicos
		$buscaServicos = '';
		if (array_key_exists('servicos',$dados) && !empty($dados['servicos']) )
			$buscaServicos = ' and C.servicos LIKE "%'.$dados['servicos'].'%" '; 

      //busca pelo destaque
      $buscaDestaque = '';
      if (array_key_exists('destaque',$dados) && !empty($dados['destaque']) )
         $buscaDestaque = ' and C.destaque LIKE "%'.$dados['destaque'].'%" '; 

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
		$colsSql = 'C.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idclientes) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql FROM clientes as C WHERE 1  $buscaId  $buscaNome $buscaAtuacoes $buscaLogo $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){
				// $r['categoria'] = $r['titulo'];
			}
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta clientes no banco</p>
	 */
	function deletaClientes($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM clientes WHERE idclientes = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function apagarImagemClientes($imgs) {
		$path = 'files/clientes/';

		if(file_exists($path)){
        	//apaga os arquivos que foram salvos
			if(is_array($imgs)){
				foreach ($imgs as $img) {
					//imagem fundo
	                $arquivo = $img['logo'];
		        	$original = "original_".$arquivo;

	                if(file_exists($path.$arquivo)){
						unlink($path.$arquivo);
					}
		        	if(file_exists($path.$original)){
						unlink($path.$original);
					}

					//imagem fundo
	                $arquivo = $img['imagem'];
		        	$original = "original_".$arquivo;

	                if(file_exists($path.$arquivo)){
						unlink($path.$arquivo);
					}
		        	if(file_exists($path.$original)){
						unlink($path.$original);
					}
				}
			}else{
                $arquivo = $imgs;
	        	$original = "original_".$arquivo;

                if(file_exists($path.$arquivo)){
					unlink($path.$arquivo);
				}
	        	if(file_exists($path.$original)){
					unlink($path.$original);
				}
			}
        }
		return true;
	}


?>