<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva como_funciona no banco</p>
	 */
	function cadastroComo_funciona($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

      $dados['ordem'] = 1;
      $ordem = buscaComo_funciona(array('max'=>'ordem'));

      if (!empty($ordem)){
         $ordem = $ordem[0];
         $dados['ordem'] = $ordem['max']+1;
      }

		$sql = "INSERT INTO como_funciona( nome, texto, imagem, ordem, ididiomas, logo, servicos, destaque) VALUES (
						'".$dados['nome']."',
						'".$dados['texto']."',
						'".$dados['imagem']."',
                        '".$dados['ordem']."',
						'".$dados['ididiomas']."',
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
	 * <p>edita como_funciona no banco</p>
	 */
	function editComo_funciona($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "UPDATE como_funciona SET
						nome = '".$dados['nome']."',
						texto = '".$dados['texto']."',
						imagem = '".$dados['imagem']."',
                  ordem = '".$dados['ordem']."',
                  ididiomas = '".$dados['ididiomas']."'
					WHERE idcomo_funciona = " . $dados['idcomo_funciona'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idcomo_funciona'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca como_funciona no banco</p>
	 */
	function buscaComo_funciona($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idcomo_funciona',$dados) && !empty($dados['idcomo_funciona']) )
			$buscaId = ' and C.idcomo_funciona = '.intval($dados['idcomo_funciona']).' '; 

      //busca pelo id
      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and C.ididiomas = '.intval($dados['ididiomas']).' '; 

      //busca pelo id
      $buscaOrdem = '';
      if (array_key_exists('order',$dados) && !empty($dados['order']) )
         $buscaOrdem = ' and C.ordem = '.intval($dados['order']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
			$buscaNome = ' and C.nome LIKE "%'.$dados['nome'].'%" '; 


		//busca pelo logo
		$buscaLogo = '';
		if (array_key_exists('logo',$dados) && !empty($dados['logo']) )
			$buscaLogo = ' and C.logo LIKE "%'.$dados['logo'].'%" '; 


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
			$colsSql = ' count(idcomo_funciona) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql FROM como_funciona as C WHERE 1  $buscaId $buscaIdIdiomas $buscaOrdem $buscaNome  $buscaLogo  $buscaTexto  $buscaImagem  $buscaServicos $buscaDestaque $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql, I.bandeira FROM como_funciona as C LEFT JOIN idiomas as I ON C.ididiomas = I.ididiomas WHERE 1  $buscaId $buscaIdIdiomas $buscaOrdem $buscaNome  $buscaLogo  $buscaTexto  $buscaImagem  $buscaServicos $buscaDestaque $orderBy $buscaLimit ";
      }

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
      $iAux = 1;
      $tot =  mysqli_affected_rows($conexao);
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){
            $r['bandeira'] = "<img src=files/idiomas/".$r['bandeira'].">";
            $r['ordemUp'] = "";
            $r['ordemDown'] = "";
            if ($iAux != 1){
               $r['ordemUp'] = '<img src="images/arrUp.png" codigo="'.$r['idcomo_funciona'].'" class="link ordemUp" />';
            }

            if ($iAux != $tot){
               $r['ordemDown'] = '<img src="images/arrDown.png" codigo="'.$r['idcomo_funciona'].'" class="link ordemDown"/>';
            }
            $iAux++;
			}
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta como_funciona no banco</p>
	 */
	function deletaComo_funciona($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM como_funciona WHERE idcomo_funciona = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function apagarImagemComo_funciona($imgs) {
		$path = 'files/como_funciona/';

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