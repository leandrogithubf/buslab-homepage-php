<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva servicos no banco</p>
	 */
	function cadastroServicos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		// print_r($dados);die;

		$dados['titulo'] = trim($dados['titulo']);
		$dados['resumo'] = trim($dados['resumo']);
		$dados['descricao'] = trim($dados['descricao']);

		$dados['ordem'] = 1;
		$ordem = buscaServicos(array('max'=>'ordem'));
		if (!empty($ordem)){
			$ordem = $ordem[0];	
			$dados['ordem'] = (int)$ordem['max']+1;	
		}

		if(empty($dados['icone2'])){
			$dados['icone2'] = 1;
		}

		// print_r($dados);die;

		$sql = "INSERT INTO servicos(titulo, resumo, descricao, ididiomas, ordem, icone) VALUES (
						'".$dados['titulo']."',
						'".$dados['resumo']."',
						'".$dados['descricao']."',
						'".$dados['ididiomas']."',
						'".$dados['ordem']."',
						'".$dados['icone2']."')";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita servicos no banco</p>
	 */
	function editServicos($dados)
	{
		include "includes/mysql.php";

      $trans = get_html_translation_table(HTML_ENTITIES);
      $dados['descricao'] = strtr($dados['descricao'], $trans);

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
         // $v = utf8_encode($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['titulo'] = trim($dados['titulo']);
		$dados['resumo'] = trim($dados['resumo']);
		$dados['descricao'] = trim($dados['descricao']);

		$sql = "UPDATE servicos SET
						titulo = '".$dados['titulo']."',
						resumo = '".$dados['resumo']."',
						descricao = '".$dados['descricao']."',
						ididiomas = '".$dados['ididiomas']."',
						icone = '".$dados['icone2']."'
					WHERE idservicos = " . $dados['idservicos'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idservicos'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca servicos no banco</p>
	 */
	function buscaServicos($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idservicos',$dados) && !empty($dados['idservicos']) )
			$buscaId = ' and idservicos = '.intval($dados['idservicos']).' '; 

		//busca pelo id
		$buscaIdNot = '';
		if (array_key_exists('not_idservicos',$dados) && !empty($dados['not_idservicos']) )
			$buscaIdNot = ' and P.idservicos != '.intval($dados['not_idservicos']).' ';

		//busca pelo titulo
		$buscaTitulo = '';
		if (array_key_exists('titulo',$dados) && !empty($dados['titulo']) )
			$buscaTitulo = ' and titulo LIKE "%'.$dados['titulo'].'%" '; 

		//busca pelo resumo
		$buscaResumo = '';
		if (array_key_exists('resumo',$dados) && !empty($dados['resumo']) )
			$buscaResumo = ' and resumo LIKE "%'.$dados['resumo'].'%" '; 

		//busca pelo descricao
		$buscaDescricao = '';
		if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
			$buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 

		
		//busca pelo ididiomas
		$buscaIdidiomas = '';
		if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
			$buscaIdidiomas = ' and ididiomas LIKE "%'.$dados['ididiomas'].'%" '; 

		$buscaOrdem = '';
			if (array_key_exists('order',$dados) && !empty($dados['order']) )
				$buscaOrdem = ' and ordem = "'.$dados['order'].'" ';

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

        $buscaMax = '';
		if(array_key_exists('max',$dados))
			$buscaMax = ', max('.$dados['max'].') as max ';

		//colunas que serão buscadas
		$colsSql = '*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idservicos) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql $buscaMax FROM servicos WHERE 1 $buscaId $buscaTitulo $buscaResumo $buscaDescricao $buscaIdidiomas $buscaOrdem $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		$iAux = 1;        
		$tot =  mysqli_affected_rows($conexao);
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){
				$r['ordemUp'] = "";
                $r['ordemDown'] = "";

                if ($iAux != 1){
                        $r['ordemUp'] = '<img src="images/arrUp.png" codigo="'.$r['idservicos'].'" class="link ordemUp" />';
                }

                if ($iAux != $tot){
                        $r['ordemDown'] = '<img src="images/arrDown.png" codigo="'.$r['idservicos'].'" class="link ordemDown"/>';
				}
                $iAux++;
            }
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta servicos no banco</p>
	 */
	function deletaServicos($dados)
	{
		include "includes/mysql.php";
		$ordem = $servicos[0]['ordem'];

		$sql = "DELETE FROM servicos WHERE idservicos = $dados";
		if (mysqli_query($conexao, $sql)) {
			$num = mysqli_affected_rows($conexao);
			$sql ="UPDATE servicos SET ordem = (ordem - 1) WHERE ordem > ".$ordem;
			mysqli_query($conexao, $sql);
			// apagarImagemServicos($imagem);
			return $num;
		} else {
			return FALSE;
		}
	}

	function editOrdemServicos($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE servicos SET					
						ordem = '".$dados['ordem']."'						
					WHERE idservicos = " . $dados['idservicos'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idservicos'];
	    } else {
	        return false;
	    }
	}

	function apagarImagemServicos($imgs) {
        $path = 'files/servicos/';
        if(file_exists($path)){
            //apaga os arquivos que foram salvos
            if(is_array($imgs)){
                foreach ($imgs as $img) {
                    //imagem fundo
                    $arquivo = $img['imagem_old'];
                    $arquivo2 = str_replace('_', '', $arquivo);
                    $original = "original_".$arquivo;
                    $medium = "medium_".$arquivo;

                    if(file_exists($path.$arquivo)){
                        unlink($path.$arquivo);
                    }
                    if(file_exists($path.$arquivo2)){
                        unlink($path.$arquivo2);
                    }
                    if(file_exists($path.$original)){
                        unlink($path.$original);
                    }
                    if(file_exists($path.$medium)){
                        unlink($path.$medium);
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
                $medium = "medium_".$arquivo;

                if(file_exists($path.$arquivo)){
                    unlink($path.$arquivo);
                }
                if(file_exists($path.$arquivo2)){
                    unlink($path.$arquivo2);
                }
                if(file_exists($path.$original)){
                    unlink($path.$original);
                }
                if(file_exists($path.$medium)){
                    unlink($path.$medium);
                }
            }
        }
        return true;
    }

    function editarImagemServicos($imgs) {
		$path = 'files/servicos/';

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


    /*===============================================Recursos===================================================*/

	function cadastroRecursos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['ordem'] = 1;
		$ordem = buscaRecursos(array('max'=>'ordem'));
		if (!empty($ordem)){
			$ordem = $ordem[0];	
			$dados['ordem'] = (int)$ordem['max']+1;	
		}

		if(!empty($dados['nome']) || !empty($dados['descricao']) || !empty($dados['imagem']) || !empty($dados['icone'])){
			$dados['nome'] = trim($dados['nome']);
			$dados['descricao'] = trim($dados['descricao']);

			$sql = "INSERT INTO recursos(idservicos, nome, descricao, imagem, icone, ordem) VALUES (
							'".$dados['idservicos']."',
							'".$dados['nome']."',
							'".$dados['descricao']."',
							'".$dados['imagem']."',
							'".$dados['icone']."',
							'".$dados['ordem']."')";
			if (mysqli_query($conexao, $sql)) {
				$resultado = mysqli_insert_id($conexao);
				return $resultado;
			} else {
				return false;
			}
		}
	}

	/**
	 * <p>edita recursos no banco</p>
	 */
	function editRecursos($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['nome'] = trim($dados['nome']);
		$dados['descricao'] = trim($dados['descricao']);

		$sql = "UPDATE recursos SET
						nome = '".$dados['nome']."',
						descricao = '".$dados['descricao']."',
						imagem = '".$dados['imagem']."',
						icone = '".$dados['icone']."'
					WHERE idservicos = ".$dados['idservicos']."
					AND idrecursos = ".$dados['idrecursos'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idrecursos'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca recursos no banco</p>
	 */
	function buscaRecursos($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idrecursos',$dados) && !empty($dados['idrecursos']) )
			$buscaId = ' and idrecursos = '.intval($dados['idrecursos']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

		//busca pelo descricao
		$buscaDescricao = '';
		if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
			$buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 

		//busca pelo idservicos
		$buscaIdServicos = '';
		if (array_key_exists('idservicos',$dados) && !empty($dados['idservicos']) )
			$buscaIdServicos = ' and idservicos LIKE "%'.$dados['idservicos'].'%" '; 

		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and imagem LIKE "%'.$dados['imagem'].'%" '; 

		$buscaOrdem = '';
			if (array_key_exists('order',$dados) && !empty($dados['order']) )
				$buscaOrdem = ' and ordem = "'.$dados['order'].'" ';

		$buscaMax = '';
		if(array_key_exists('max',$dados))
			$buscaMax = ', max('.$dados['max'].') as max ';

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
		$colsSql = '*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idrecursos) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql $buscaMax FROM recursos WHERE 1 $buscaId $buscaIdServicos $buscaNome $buscaOrdem $buscaDescricao $buscaImagem $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){

            }
			$resultado[] = $r;
		}
		return $resultado; 
 	}

 	/**
	 * <p>deleta recursos no banco a partir da edição</p>
	 */
	function deletaRecursos2($dados,$dados2)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM recursos WHERE idservicos = $dados AND idrecursos = $dados2";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	/**
	 * <p>deleta recursos no banco</p>
	 */
	function deletaRecursos($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM recursos WHERE idservicos = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function editOrdemRecursos($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE recursos SET					
						ordem = ".$dados['ordem']."						
					WHERE idrecursos = " . $dados['idrecursos'] . " AND idservicos = ".$dados['idservicos'];

	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idrecursos'];
	    } else {
	        return false;
	    }
	}

	function apagarImagemRecursos($imgs) {
        $path = 'files/recursos/';
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

                if(!empty($arquivo)){
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
        }
        return true;
    }

?>