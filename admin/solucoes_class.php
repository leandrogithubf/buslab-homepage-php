<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva solucoes no banco</p>
	 */
	function cadastroSolucoes($dados)
	{
		include "includes/mysql.php";

        $dados['titulo'] = htmlentities($dados['titulo']);
        $dados['resumo'] = htmlentities($dados['resumo']);
        $dados['descricao'] = htmlentities($dados['descricao']);
        $dados['title'] = htmlentities($dados['title']);
        $dados['keyword'] = htmlentities($dados['keyword']);
        $dados['description'] = htmlentities($dados['description']);

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		// print_r($dados);die;

		$dados['titulo'] = trim($dados['titulo']);
		$dados['resumo'] = trim($dados['resumo']);
		$dados['descricao'] = trim($dados['descricao']);
		$dados['urlamigavel'] = trim($dados['urlamigavel']);
		$dados['title'] = trim($dados['title']);
		$dados['description'] = trim($dados['description']);
		$dados['keyword'] = trim($dados['keyword']);
		// $dados['slogan_faq'] = trim($dados['slogan_faq']);
		// $dados['resumo_faq'] = trim($dados['resumo_faq']);

		// print_r($dados);die;

		$sql = "INSERT INTO solucoes(titulo, resumo, descricao, urlamigavel, title, description, keyword, thumbs, banner_topo, ididiomas, slogan_faq, resumo_faq) VALUES (
						'".$dados['titulo']."',
						'".$dados['resumo']."',
                        '".$dados['descricao']."',
						'".$dados['urlamigavel']."',
						'".$dados['title']."',
						'".$dados['description']."',
						'".$dados['keyword']."',
						'".$dados['thumbs']."',
                        '".$dados['banner_topo']."',
						'".$dados['ididiomas']."',
                        '',
                        ''
                    )";

        // print_r($sql);die;

		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita solucoes no banco</p>
	 */
	function editSolucoes($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['titulo'] = trim($dados['titulo']);
		$dados['resumo'] = trim($dados['resumo']);
		$dados['descricao'] = trim($dados['descricao']);
		$dados['urlamigavel'] = trim($dados['urlamigavel']);
		$dados['title'] = trim($dados['title']);
		$dados['description'] = trim($dados['description']);
		$dados['keyword'] = trim($dados['keyword']);
		// $dados['slogan_faq'] = trim($dados['slogan_faq']);
		// $dados['resumo_faq'] = trim($dados['resumo_faq']);

		$sql = "UPDATE solucoes SET
						titulo = '".$dados['titulo']."',
						descricao = '".$dados['descricao']."',
                  resumo = '".$dados['resumo']."',
						urlamigavel = '".$dados['urlamigavel']."',
						title = '".$dados['title']."',
						description = '".$dados['description']."',
						keyword = '".$dados['keyword']."',
						thumbs = '".$dados['thumbs']."',
						banner_topo = '".$dados['banner_topo']."',
                  ididiomas = '".$dados['ididiomas']."'
					WHERE idsolucoes = " . $dados['idsolucoes'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idsolucoes'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca solucoes no banco</p>
	 */
	function buscaSolucoes($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idsolucoes',$dados) && !empty($dados['idsolucoes']) )
			$buscaId = ' and solucoes.idsolucoes = '.intval($dados['idsolucoes']).' '; 

		//busca pelo id
		$buscaIdNot = '';
		if (array_key_exists('not_idsolucoes',$dados) && !empty($dados['not_idsolucoes']) )
			$buscaIdNot = ' and solucoes.idsolucoes != '.intval($dados['not_idsolucoes']).' ';

      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and solucoes.ididiomas = '.intval($dados['ididiomas']).' '; 

		//busca pelo titulo
		$buscaTitulo = '';
		if (array_key_exists('titulo',$dados) && !empty($dados['titulo']) )
			$buscaTitulo = ' and solucoes.titulo LIKE "%'.$dados['titulo'].'%" '; 

		//busca pelo resumo
		$buscaResumo = '';
		if (array_key_exists('resumo',$dados) && !empty($dados['resumo']) )
			$buscaResumo = ' and solucoes.resumo LIKE "%'.$dados['resumo'].'%" '; 

		//busca pelo descricao
		$buscaDescricao = '';
		if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
			$buscaDescricao = ' and solucoes.descricao LIKE "%'.$dados['descricao'].'%" '; 

		//busca pelo urlamigavel
		$buscaUrlamigavel = '';
		if (array_key_exists('urlamigavel',$dados) && !empty($dados['urlamigavel']) )
			$buscaUrlamigavel = ' and solucoes.urlamigavel LIKE "%'.$dados['urlamigavel'].'%" '; 

		//busca pelo title
		$buscaTitle = '';
		if (array_key_exists('title',$dados) && !empty($dados['title']) )
			$buscaTitle = ' and title LIKE "%'.$dados['title'].'%" '; 

		//busca pelo description
		$buscaDescription = '';
		if (array_key_exists('description',$dados) && !empty($dados['description']) )
			$buscaDescription = ' and description LIKE "%'.$dados['description'].'%" '; 

		//busca pelo keyword
		$buscaKeyword = '';
		if (array_key_exists('keyword',$dados) && !empty($dados['keyword']) )
			$buscaKeyword = ' and keyword LIKE "%'.$dados['keyword'].'%" '; 

		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('thumbs',$dados) && !empty($dados['thumbs']) )
			$buscaImagem = ' and thumbs LIKE "%'.$dados['thumbs'].'%" ';

		//busca pelo banner_topo
		$buscaBannerTopo = '';
		if (array_key_exists('banner_topo',$dados) && !empty($dados['banner_topo']) )
			$buscaBannerTopo = ' and banner_topo LIKE "%'.$dados['banner_topo'].'%" '; 

		//busca pelo slogan_faq
		$buscaSloganFaq = '';
		if (array_key_exists('slogan_faq',$dados) && !empty($dados['slogan_faq']) )
			$buscaSloganFaq = ' and slogan_faq LIKE "%'.$dados['slogan_faq'].'%" '; 

		//busca pelo resumo_faq
		$buscaResumoFaq = '';
		if (array_key_exists('resumo_faq',$dados) && !empty($dados['resumo_faq']) )
			$buscaResumoFaq = ' and resumo_faq LIKE "%'.$dados['resumo_faq'].'%" '; 

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
			$colsSql = ' count(idsolucoes) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql FROM solucoes WHERE 1 $buscaId $buscaIdIdiomas $buscaIdNot $buscaTitulo $buscaDescricao $buscaUrlamigavel $buscaTitle $buscaDescription $buscaKeyword $buscaImagem $buscaBannerTopo $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql, i.bandeira, solucoes.urlamigavel as urlamigavel, i.urlamigavel as url_idioma FROM solucoes LEFT JOIN idiomas as i ON solucoes.ididiomas = i.ididiomas WHERE 1 $buscaId $buscaIdIdiomas $buscaIdNot $buscaTitulo $buscaDescricao $buscaUrlamigavel $buscaTitle $buscaDescription $buscaKeyword $buscaImagem $buscaBannerTopo $orderBy $buscaLimit ";
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
	 * <p>deleta solucoes no banco</p>
	 */
	function deletaSolucoes($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM solucoes WHERE idsolucoes = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	function editOrdemSolucoes($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE solucoes SET					
						ordem = '".$dados['ordem']."'						
					WHERE idsolucoes = " . $dados['idsolucoes'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idsolucoes'];
	    } else {
	        return false;
	    }
	}

	function apagarImagemSolucoes($imgs) {
        $path = 'files/solucoes/';
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


    /*===============================================Diferenciais===================================================*/

	function cadastroRecursos($dados)
	{

		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		// if(empty($dados['icone'])){
		// 	$dados['icone'] = 1;
		// }

        $dados['descricao'] = '';

		if(!empty($dados['nome']) || !empty($dados['descricao']) || !empty($dados['icone']) || !empty($dados['imagem'])){
         if(empty($dados['icone'])){
            $dados['icone'] = 1;
         }

			$dados['nome'] = trim($dados['nome']);
			// $dados['descricao'] = trim($dados['descricao']);

			$sql = "INSERT INTO recursos(idsolucoes, nome, icone, imagem, descricao) VALUES (
							'".$dados['idsolucoes']."',
							'".$dados['nome']."',
                            '".$dados['icone']."',
							'".$dados['imagem']."',
                            '".$dados['descricao']."'
                        )";
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

		$sql = "UPDATE recursos SET
						nome = '".$dados['nome']."',
						icone = '".$dados['icone']."',
                  imagem = '".$dados['imagem']."'
					WHERE idsolucoes = ".$dados['idsolucoes']."
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

		//busca pelo idsolucoes
		$buscaIdSolucoes = '';
		if (array_key_exists('idsolucoes',$dados) && !empty($dados['idsolucoes']) )
			$buscaIdSolucoes = ' and idsolucoes LIKE "%'.$dados['idsolucoes'].'%" '; 

		//busca pelo imagem
		$buscaImagem = '';
		if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
			$buscaImagem = ' and imagem LIKE "%'.$dados['imagem'].'%" '; 

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

		$sql = "SELECT $colsSql FROM recursos WHERE 1 $buscaId $buscaIdSolucoes $buscaNome $buscaImagem $orderBy $buscaLimit ";

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

		$sql = "DELETE FROM recursos WHERE idsolucoes = $dados AND idrecursos = $dados2";
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

		$sql = "DELETE FROM recursos WHERE idsolucoes = $dados";
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
						ordem = '".$dados['ordem']."'						
					WHERE idrecursos = " . $dados['idrecursos'];
	    
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

    /*===============================================Serviços===================================================*/

   function cadastroServicos($dados)
   {
      // print_r($dados);die;
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      // if(empty($dados['icone'])){
      //    $dados['icone'] = 1;
      // }

      $dados['descricao'] = '';

      if(!empty($dados['nome']) || !empty($dados['descricao']) || !empty($dados['icone']) || !empty($dados['imagem'])){
         if(empty($dados['icone'])){
            $dados['icone'] = 1;
         }

         $dados['nome'] = trim($dados['nome']);
         // $dados['descricao'] = trim($dados['descricao']);

         $sql = "INSERT INTO servicos(idsolucoes, nome, icone, imagem, descricao) VALUES (
                     '".$dados['idsolucoes']."',
                     '".$dados['nome']."',
                     '".$dados['icone']."',
                     '".$dados['imagem']."',
                     '".$dados['descricao']."'
                 )";
         if (mysqli_query($conexao, $sql)) {
            $resultado = mysqli_insert_id($conexao);
            return $resultado;
         } else {
            return false;
         }
      }
   }

   /**
    * <p>edita servicos no banco</p>
    */
   function editServicos($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $dados['nome'] = trim($dados['nome']);

      $sql = "UPDATE servicos SET
                  nome = '".$dados['nome']."',
                  icone = '".$dados['icone']."',
                  imagem = '".$dados['imagem']."'
               WHERE idsolucoes = ".$dados['idsolucoes']."
               AND idservicos = ".$dados['idservicos'];

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

      //busca pelo nome
      $buscaNome = '';
      if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
         $buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

      //busca pelo descricao
      $buscaDescricao = '';
      if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
         $buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 

      //busca pelo idsolucoes
      $buscaIdSolucoes = '';
      if (array_key_exists('idsolucoes',$dados) && !empty($dados['idsolucoes']) )
         $buscaIdSolucoes = ' and idsolucoes LIKE "%'.$dados['idsolucoes'].'%" '; 

      //busca pelo imagem
      $buscaImagem = '';
      if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
         $buscaImagem = ' and imagem LIKE "%'.$dados['imagem'].'%" '; 

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
         $colsSql = ' count(idservicos) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
         $colsSql = ' '.$dados['colsSql'].' ';
      }

      $sql = "SELECT $colsSql FROM servicos WHERE 1 $buscaId $buscaIdSolucoes $buscaNome $buscaImagem $orderBy $buscaLimit ";

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
    * <p>deleta servicos no banco a partir da edição</p>
    */
   function deletaServicos2($dados,$dados2)
   {
      include "includes/mysql.php";

      $sql = "DELETE FROM servicos WHERE idsolucoes = $dados AND idservicos = $dados2";
      if (mysqli_query($conexao, $sql)) {
         return mysqli_affected_rows($conexao);
      } else {
         return FALSE;
      }
   }

   /**
    * <p>deleta servicos no banco</p>
    */
   function deletaServicos($dados)
   {
      include "includes/mysql.php";

      $sql = "DELETE FROM servicos WHERE idsolucoes = $dados";
      if (mysqli_query($conexao, $sql)) {
         return mysqli_affected_rows($conexao);
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

    /*===============================================Imagem===================================================*/

   function cadastroImagem($dados)
   {
      // print_r($dados);die;
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      // if(empty($dados['icone'])){
      //    $dados['icone'] = 1;
      // }

      if(!empty($dados['nome']) || !empty($dados['descricao']) || !empty($dados['imagem']) || !empty($dados['icone'])){
         if(empty($dados['icone'])){
            $dados['icone'] = 1;
         }

         $dados['nome'] = trim($dados['nome']);
         $dados['descricao'] = trim($dados['descricao']);

         $sql = "INSERT INTO imagem(idsolucoes, nome, descricao, imagem, icone) VALUES (
                     '".$dados['idsolucoes']."',
                     '".$dados['nome']."',
                     '".$dados['descricao']."',
                     '".$dados['imagem']."',
                     '".$dados['icone']."')";
         if (mysqli_query($conexao, $sql)) {
            $resultado = mysqli_insert_id($conexao);
            return $resultado;
         } else {
            return false;
         }
      }
   }

   /**
    * <p>edita imagem no banco</p>
    */
   function editImagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $dados['nome'] = trim($dados['nome']);
      $dados['descricao'] = trim($dados['descricao']);

      $sql = "UPDATE imagem SET
                  nome = '".$dados['nome']."',
                  descricao = '".$dados['descricao']."',
                  imagem = '".$dados['imagem']."',
                  icone = '".$dados['icone']."'
               WHERE idsolucoes = ".$dados['idsolucoes']."
               AND idimagem = ".$dados['idimagem'];

      if (mysqli_query($conexao, $sql)) {
         return $dados['idimagem'];
      } else {
         return false;
      }
   }

   /**
    * <p>busca imagem no banco</p>
    */
   function buscaImagem($dados = array())
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v) || $k == "colsSql") continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      //busca pelo id
      $buscaId = '';
      if (array_key_exists('idimagem',$dados) && !empty($dados['idimagem']) )
         $buscaId = ' and idimagem = '.intval($dados['idimagem']).' '; 

      //busca pelo nome
      $buscaNome = '';
      if (array_key_exists('nome',$dados) && !empty($dados['nome']) )
         $buscaNome = ' and nome LIKE "%'.$dados['nome'].'%" '; 

      //busca pelo descricao
      $buscaDescricao = '';
      if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
         $buscaDescricao = ' and descricao LIKE "%'.$dados['descricao'].'%" '; 

      //busca pelo idsolucoes
      $buscaIdSolucoes = '';
      if (array_key_exists('idsolucoes',$dados) && !empty($dados['idsolucoes']) )
         $buscaIdSolucoes = ' and idsolucoes LIKE "%'.$dados['idsolucoes'].'%" '; 

      //busca pelo imagem
      $buscaImagem = '';
      if (array_key_exists('imagem',$dados) && !empty($dados['imagem']) )
         $buscaImagem = ' and imagem LIKE "%'.$dados['imagem'].'%" '; 

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
         $colsSql = ' count(idimagem) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
         $colsSql = ' '.$dados['colsSql'].' ';
      }

      $sql = "SELECT $colsSql FROM imagem WHERE 1 $buscaId $buscaIdSolucoes $buscaNome $buscaDescricao $buscaImagem $orderBy $buscaLimit ";

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
    * <p>deleta imagem no banco a partir da edição</p>
    */
   function deletaImagem2($dados,$dados2)
   {
      include "includes/mysql.php";

      $sql = "DELETE FROM imagem WHERE idsolucoes = $dados AND idimagem = $dados2";
      if (mysqli_query($conexao, $sql)) {
         return mysqli_affected_rows($conexao);
      } else {
         return FALSE;
      }
   }

   /**
    * <p>deleta imagem no banco</p>
    */
   function deletaImagem($dados)
   {
      include "includes/mysql.php";

      $sql = "DELETE FROM imagem WHERE idsolucoes = $dados";
      if (mysqli_query($conexao, $sql)) {
         return mysqli_affected_rows($conexao);
      } else {
         return FALSE;
      }
   }

   function editOrdemImagem($dados)
   {
       include "includes/mysql.php";
      
       $sql = "UPDATE imagem SET              
                  ordem = '".$dados['ordem']."'                
               WHERE idimagem = " . $dados['idimagem'];
       
       if (mysqli_query($conexao, $sql)) {
           return $dados['idimagem'];
       } else {
           return false;
       }
   }

   function apagarImagemImagem($imgs) {
        $path = 'files/imagem/';
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


   /*===============================================Galeria===================================================*/
   /**
    * <p>busca solucoes_imagem no banco</p>
    */
   function buscaSolucoes_imagem($dados = array())
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v) || $k == "colsSql") continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }


      //busca pelo id
      $buscaId = '';
      if (array_key_exists('idsolucoes_imagem',$dados) && !empty($dados['idsolucoes_imagem']) )
         $buscaId = ' and idsolucoes_imagem = '.intval($dados['idsolucoes_imagem']).' ';

      //busca pelo idsolucoes
      $buscaIdsolucoes = '';
      if (array_key_exists('idsolucoes',$dados) && !empty($dados['idsolucoes']) )
         $buscaIdsolucoes = ' and idsolucoes = "'.$dados['idsolucoes'].'" ';


      //busca pelo descricao_imagem
      $buscaDescricao_imagem = '';
      if (array_key_exists('descricao_imagem',$dados) && !empty($dados['descricao_imagem']) )
         $buscaDescricao_imagem = ' and descricao_imagem LIKE "%'.$dados['descricao_imagem'].'%" ';


      //busca pelo urlrewrite_imagem
      $buscaUrlrewrite_imagem = '';
      if (array_key_exists('urlrewrite_imagem',$dados) && !empty($dados['urlrewrite_imagem']) )
         $buscaUrlrewrite_imagem = ' and urlrewrite_imagem LIKE "%'.$dados['urlrewrite_imagem'].'%" ';


      //busca pelo m2y_imagem
      $buscaM2y_imagem = '';
      if (array_key_exists('m2y_imagem',$dados) && !empty($dados['m2y_imagem']) )
         $buscaM2y_imagem = ' and m2y_imagem LIKE "%'.$dados['m2y_imagem'].'%" ';


      //busca pela posicao_imagem
      $buscaPosicao_imagem = '';
      if (array_key_exists('posicao_imagem',$dados) && !empty($dados['posicao_imagem']) )
         $buscaM2y_imagem = ' and posicao_imagem = '.$dados['posicao_imagem'].' ';


       //ordem
        $orderBy = "";
        if (isset($dados['ordem']) && !empty($dados['ordem'])){
         $orderBy = ' ORDER BY '.$dados['ordem'];
         if (isset($dados['dir']) && !empty($dados['dir'])){
            $orderBy .= ' '.$dados['dir'];
           }
        }

       //busca pelo limit
      $buscaLimit = '';
      if (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('pagina',$dados)) {
           $buscaLimit = ' LIMIT '.($dados['limit'] * $dados['pagina']).','.$dados['limit'].' ';
       } elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('data_hora',$dados)){
           $buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['data_hora'].' ';
       } elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
           $buscaLimit = ' LIMIT '.$dados['limit'];
       }

      //colunas que serão buscadas
      $colsSql = '*';
      if (array_key_exists('totalRecords',$dados)){
         $colsSql = ' count(idsolucoes_imagem) as totalRecords';
           $buscaLimit = '';
           $orderBy = '';
       } elseif (array_key_exists('colsSql',$dados)) {
         $colsSql = ' '.$dados['colsSql'].' ';
      }

      $sql = "SELECT $colsSql FROM solucoes_imagem
            WHERE 1  $buscaId  $buscaIdsolucoes
            $buscaDescricao_imagem  $buscaUrlrewrite_imagem
            $buscaPosicao_imagem  $buscaM2y_imagem  $orderBy $buscaLimit ";

      include_once('includes/functions.php');

      $query = mysqli_query($conexao, $sql);
      $resultado = array();
      while ($r = mysqli_fetch_assoc($query)){

         if (!array_key_exists('totalRecords',$dados)){
            if(isset($dados['url'])){
               $r['descricao_imagem_url']= converteUrl($r['descricao_imagem']);
            }

            if(isset($dados['tamanho'])){
               $tamanhoImagem = getimagesize('files/solucoes/'.$r['idsolucoes'].'/galeria/thumbnail/'.$r['nome_imagem']);
                $r['w'] = $tamanhoImagem[0];
                $r['h']= $tamanhoImagem[1];
            }

            $r['imgthumb'] = "admin/files/solucoes/".$r['idsolucoes']."/galeria/thumb/".$r['nome_imagem'];
            $r['imgfull'] = "admin/files/solucoes/".$r['idsolucoes']."/galeria/original/".$r['nome_imagem'];
         }

         $r = array_map('utf8_encode', $r);
         $resultado[] = $r;
      }

      return $resultado;
   }


   function cadastroSolucoes_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }
      $sql = "INSERT INTO solucoes_imagem( idsolucoes, nome_imagem, descricao_imagem, urlrewrite_imagem, posicao_imagem, m2y_imagem,is_default) VALUES (
               '".$dados['idsolucoes']."',
               '".$dados['nome_imagem']."',
               '".$dados['descricao_imagem']."',
               '".$dados['urlrewrite_imagem']."',
               '".$dados['posicao_imagem']."',
               '".$dados['m2y_imagem']."',
               '".$dados['is_default']."')";
      if (mysqli_query($conexao, $sql)) {
         $resultado = mysqli_insert_id($conexao);
         return $resultado;
      } else {
         return false;
      }
   }

   /**
    * <p>edita solucoes_imagem no banco</p>
    */
   function editSolucoes_imagem($dados)
   {
      include "includes/mysql.php";

      foreach ($dados AS $k => &$v) {
         if (is_array($v)) continue;
         if (get_magic_quotes_gpc()) $v = stripslashes($v);
         $v = mysqli_real_escape_string($conexao, utf8_decode($v));
      }

      $sql = "UPDATE solucoes_imagem SET
                  idsolucoes = '".$dados['idsolucoes']."',
                  descricao_imagem = '".$dados['descricao_imagem']."',
                  urlrewrite_imagem = '".$dados['urlrewrite_imagem']."',
                  posicao_imagem = '".$dados['posicao_imagem']."',
                  is_default = '".$dados['is_default']."',
                  nome_imagem = '".$dados['nome_imagem']."',
                  m2y_imagem = '".$dados['m2y_imagem']."'
               WHERE idsolucoes_imagem = " . $dados['idsolucoes_imagem'];

      if (mysqli_query($conexao, $sql)) {
         return $dados['idsolucoes_imagem'];
      } else {
         return false;
      }
   }


   function salvaImagemSolucoes($dados){

      include_once "includes/functions.php";
      $dadosGravar = array();

      $idsolucoes = $dados['idsolucoes'];
      //urlrewrite
      $nomeimagem = explode('.', $dados['nome_imagem']);
      $nomeimagem = $nomeimagem[0];
      $dados['urlrewrite_imagem'] = converteUrl($dados['nome_imagem']);
      //atribuir m2y
      $urlrewrite = 'admin/files/solucoes/'.$idsolucoes.'/galeria/thumbnail/'.$dados['nome_imagem'];

      $dados['m2y_imagem'] = '';
      $shorturl = ENDERECO.$urlrewrite;
      $authkey = "3H34kAfJ36c7VUR3oCqBR15R33P554V6";

      $returns = file_get_contents("http://www.m2y.me/webservice/create/?url=".$shorturl."&authkey=".$authkey);

      if($returns != -1 && $returns != -2){
         $dados['m2y_imagem'] = $returns;
      }

      if($dados['posicao_imagem'] == 1){
         $dados['is_default'] = 1;
      }else{
         $dados['is_default'] = 0;
      }

      return cadastroSolucoes_imagem($dados);
   }

   function alterarPosicaoImagemSolucoes($dados){

      include "includes/mysql.php";

      $imagens = $dados['idsolucoes_imagem'];
      $posicao = $dados['posicao_imagem'];
      $idsolucoes = $dados['idsolucoes'];

      if(!empty($imagens)){

         foreach($imagens as $k => $v){
            $sql = 'UPDATE solucoes_imagem SET
                  posicao_imagem = "'.$posicao[$k].'",
                  is_default = 0
                  WHERE idsolucoes_imagem = '.$v;

            mysqli_query($conexao, $sql);
         }

         $sql = 'UPDATE solucoes_imagem SET is_default = 1 WHERE idsolucoes = '.$idsolucoes.' and posicao_imagem = 1';
               mysqli_query($conexao, $sql);
               return true;
      }else{
         return true;
      }
   }

   //APAGAR IMAGENS DA PASTA
   function apagarImagemSolucoesGaleria($imgs) {
      $path = 'files/solucoes/galeria/';

      $nameArquivo = array();
      $nameArquivo[] = "";
      $nameArquivo[] = "thumb_";

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

   //APAGA UM IMAGEM ESPECIFICA DA GALERIA
   function deletarImagemSolucoesGaleria($idsolucoes_imagem, $idpost){

      include "includes/mysql.php";
      $return = false;

      $imagem = buscaSolucoes_imagem(array("idsolucoes_imagem"=>$idsolucoes_imagem));

      $posicao = $imagem[0]['posicao_imagem'];
      $sql = 'DELETE from solucoes_imagem WHERE idsolucoes_imagem = '.$idsolucoes_imagem;

      if (mysqli_query($conexao, $sql)) {
         //update nas posicao das imagens
         $sql = 'UPDATE solucoes_imagem SET posicao_imagem = (posicao_imagem - 1) WHERE idsolucoes = '.$idpost.' and posicao_imagem > '.$posicao;
         if (mysqli_query($conexao, $sql)) {
            //marca a primeira posicao como default - caso apague q primeira imagem
            $sql = 'UPDATE solucoes_imagem SET is_default = 1 WHERE idsolucoes = '.$idpost.' and posicao_imagem = 1';
            mysqli_query($conexao, $sql);
            $return = true;
         }
      } else {
         $return = false;
      }

        return $return;
   }
?>