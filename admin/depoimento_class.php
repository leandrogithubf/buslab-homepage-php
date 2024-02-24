<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva depoimento no banco</p>
	 */
	function cadastroDepoimento($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

      $dados['nome'] = trim($dados['nome']);
      $dados['depoimento'] = trim($dados['depoimento']);
      $dados['cargo'] = trim($dados['cargo']);

		$sql = "INSERT INTO depoimento( nome, depoimento, imagem, status, ididiomas, cargo, logo, subtitulo, ordem) VALUES (
						'".$dados['nome']."',
						'".$dados['depoimento']."',
                        '".$dados['imagem']."',
                        '".$dados['status']."',
                        '".$dados['ididiomas']."',
                        '".$dados['cargo']."',
						'".$dados['logo']."',
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
	 * <p>edita depoimento no banco</p>
	 */
	function editDepoimento($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);
		$dados['depoimento'] = trim($dados['depoimento']);

      // print_r($dados);die;

		$sql = "UPDATE depoimento SET
						nome = '".$dados['nome']."',
						depoimento = '".$dados['depoimento']."',
                  imagem = '".$dados['imagem']."',
                  status = '".$dados['status']."',
                  ididiomas = '".$dados['ididiomas']."',
                  cargo = '".$dados['cargo']."',
						logo = '".$dados['logo']."'
					WHERE iddepoimento = " . $dados['iddepoimento'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['iddepoimento'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca depoimento no banco</p>
	 */
	function buscaDepoimento($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('iddepoimento',$dados) && !empty($dados['iddepoimento']) )
			$buscaId = ' and D.iddepoimento = '.intval($dados['iddepoimento']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and D.nome LIKE "%'.$dados['nome'].'%" '; 

      //busca pelo cargo
      $buscaCargo = '';
      if (array_key_exists('cargo',$dados) && !empty($dados['cargo']) )
         $buscaCargo = ' and D.cargo LIKE "%'.$dados['cargo'].'%" '; 

      //busca pelo email
      $buscaEmail = '';
      if (array_key_exists('email',$dados) && !empty($dados['email']) )
         $buscaEmail = ' and D.email LIKE "%'.$dados['email'].'%" '; 

      //busca pelo status
      $buscaStatus = '';
      if (array_key_exists('status',$dados) && !empty($dados['status']) )
         $buscaStatus = ' and D.status LIKE "%'.$dados['status'].'%" '; 

      //busca pelo ididiomas
      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and D.ididiomas ='.$dados['ididiomas'].' '; 

		//busca pelo depoimento
		$buscaDepoimento = '';
		if (array_key_exists('depoimento',$dados) && !empty($dados['depoimento']) )
			$buscaDepoimento = ' and D.depoimento LIKE "%'.$dados['depoimento'].'%" '; 


		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and D.imagem LIKE "%'.$dados['imagem'].'%" '; 

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
		$colsSql = 'D.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(iddepoimento) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql FROM depoimento as D WHERE 1  $buscaId $buscaIdIdiomas $buscaNome $buscaCargo $buscaStatus $buscaDepoimento  $buscaImagem  $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql, I.bandeira FROM depoimento as D LEFT JOIN idiomas as I ON D.ididiomas = I.ididiomas WHERE 1  $buscaId $buscaIdIdiomas $buscaNome $buscaCargo $buscaStatus $buscaDepoimento  $buscaImagem  $orderBy $buscaLimit ";
      }

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		$iAux = 1;
		$tot =  mysqli_affected_rows($conexao);

		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r); 
			if (!array_key_exists('totalRecords',$dados)){
            $r['bandeira'] = "<img src=files/idiomas/".$r['bandeira'].">";

				!empty($r['imagem']) ? $r['imagem-caminho'] = '<img src="files/depoimento/'.$r['imagem'].'" class="img-depoimento"/>' : $r['imagem-caminho'] = 'SEM IMAGEM';
             $r["status_nome"] = ($r["status"]=='1' ? "Ativo":"Inativo");
               $r["status_icone"] = "<img src='images/estrela".($r["status"]=='1' ? "sim":"nao").".png' class='icone inverteStatus' codigo='".$r['iddepoimento']."' width='20px' />";
	        }  
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta depoimento no banco</p>
	 */
	function deletaDepoimento($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM depoimento WHERE iddepoimento = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function editOrdemDepoimento($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE depoimento SET					
						ordem = '".$dados['ordem']."'						
					WHERE iddepoimento = " . $dados['iddepoimento'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['iddepoimento'];
	    } else {
	        return false;
	    }
	}

	function apagarImagemDepoimento($imgs) {
		$path = 'files/depoimento/';

		$nameArquivo = array();
		$nameArquivo[] = "";
		$nameArquivo[] = "thumb_";
		$nameArquivo[] = "original_";

		if(file_exists($path)){
			if(is_array($imgs)){
				foreach ($imgs as $img) {
					foreach ($nameArquivo as $key => $_name) {
						$arquivo = $_name.$img['nome_imagem'];
						if(file_exists($path.$arquivo)){
							unlink($path.$arquivo);
						}
					}
				}
			}else{
				foreach ($nameArquivo as $key => $_name) {
					$arquivo = $_name.$imgs;
					if(file_exists($path.$arquivo)){
						unlink($path.$arquivo);
					}
				}
			}
    	}
		return true;
	}

?>