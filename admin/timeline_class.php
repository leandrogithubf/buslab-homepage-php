<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva timeline no banco</p>
	 */
	function cadastroTimeline($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, $v);
		}

		$dados['titulo'] = trim($dados['titulo']);
      // $dataExplode = explode('/', $dados['data']);
      // $dados['data'] = $dataExplode[2].'-'.$dataExplode[1].'-'.$dataExplode[0];

		$sql = "INSERT INTO timeline(titulo, status, ano, texto, imagem, ididiomas, data) VALUES (
						'".$dados['titulo']."',
						'".$dados['status']."',
                  '".$dados['ano']."',
                  '".$dados['texto']."',
                  '".$dados['imagem']."',
						'".$dados['ididiomas']."',
                        'CURDATE()'
                    )";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita timeline no banco</p>
	 */
	function editTimeline($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, $v);
		}

		$dados['titulo'] = trim($dados['titulo']);
      // $dataExplode = explode('/', $dados['data']);
      // $dados['data'] = $dataExplode[2].'-'.$dataExplode[1].'-'.$dataExplode[0];

		$sql = "UPDATE timeline SET
						titulo = '".$dados['titulo']."',
						ano = '".$dados['ano']."',
                  status = '".$dados['status']."',
                  texto = '".$dados['texto']."',
                  imagem = '".$dados['imagem']."',
						ididiomas = '".$dados['ididiomas']."'
					WHERE idtimeline = " . $dados['idtimeline'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idtimeline'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca timeline no banco</p>
	 */
	function buscaTimeline($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, $v);
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idtimeline',$dados) && !empty($dados['idtimeline']) )
			$buscaId = ' and T.idtimeline = '.intval($dados['idtimeline']).' '; 

      //busca pelo id
      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and T.ididiomas = '.intval($dados['ididiomas']).' '; 

		//busca pelo titulo
		$buscaTitulo = '';
		if (array_key_exists('titulo',$dados) && !empty($dados['titulo']) )
			$buscaTitulo = ' and T.titulo LIKE "%'.$dados['titulo'].'%" ';

		$buscaData = '';
		if (array_key_exists('data',$dados) && !empty($dados['data']) )
			$buscaData = ' and T.data LIKE "%'.$dados['data'].'%" ';

		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and T.imagem LIKE "%'.$dados['imagem'].'%" '; 

      //busca pelo texto
      $buscaTexto = '';
      if (array_key_exists('texto',$dados) && !empty($dados['texto']) )
         $buscaTexto = ' and T.texto LIKE "%'.$dados['texto'].'%" '; 

		//busca pelo status
		$buscaStatus = '';
		if (array_key_exists('status',$dados) && $dados['status'] != '')
			$buscaStatus = ' and T.status LIKE "%'.$dados['status'].'%" '; 

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
		$colsSql = 'T.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idtimeline) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

      $meses = ['', 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql FROM timeline as T WHERE 1 $buscaId $buscaIdIdiomas $buscaTitulo $buscaStatus $buscaTexto $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql, I.bandeira FROM timeline as T LEFT JOIN idiomas as I ON T.ididiomas = I.ididiomas WHERE 1 $buscaId $buscaIdIdiomas $buscaTitulo $buscaStatus $buscaTexto $orderBy $buscaLimit ";
      }

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			//$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){
            // $r["data_exp"] = explode("/", $r['data_formatada']);
            // $r["data_exp"][1] = ltrim($r['data_exp'][1], '0');
            // $r['mes_'] = $meses[$r['data_exp'][1]];
            $r['bandeira'] = "<img src=files/idiomas/".$r['bandeira'].">";
				$r["status_nome"] = ($r["status"] == '1' ? "Ativo":"Inativo");
                $r["status_icone"] = '<img src="images/estrela'.($r["status"] =="1" ? "sim":"nao").'.png" class="icone inverteStatus" codigo="'.$r['idtimeline'].'" width="20px" />';
         }
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta timeline no banco</p>
	 */
	function deletaTimeline($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM timeline WHERE idtimeline = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function editOrdemTimeline($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE timeline SET					
						ordem = '".$dados['ordem']."'						
					WHERE idtimeline = " . $dados['idtimeline'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idtimeline'];
	    } else {
	        return false;
	    }
	}

	function apagarImagemTimeline($imgs) {
        $path = 'files/timeline/';
        if(file_exists($path)){
            //apaga os arquivos que foram salvos
            if(is_array($imgs)){
                foreach ($imgs as $img) {
                    //imagem fundo
                    $arquivo = $img['imagem_old'];
                    $arquivo2 = str_replace('_', '', $arquivo);
                    $original = "original_".$arquivo;

                    if(file_exists($path.$arquivo)){
                        unlink($path.$arquivo);
                    }
                    if(file_exists($path.$arquivo2)){
                        unlink($path.$arquivo2);
                    }
                    if(file_exists($path.$original)){
                        unlink($path.$original);
                    }

                    //imagem fundo
                    $arquivo = $img['imagem_old'];
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

                $arquivo2 = str_replace('_', '', $arquivo);
                $original = "original_".$arquivo;

                if(file_exists($path.$arquivo)){
                    unlink($path.$arquivo);
                }
                if(file_exists($path.$arquivo2)){
                    unlink($path.$arquivo2);
                }
                if(file_exists($path.$original)){
                    unlink($path.$original);
                }
            }
        }
        return true;
    }

?>