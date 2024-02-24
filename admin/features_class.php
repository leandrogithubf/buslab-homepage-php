<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva features no banco</p>
	 */

	function cadastroFeatures($dados)
	{
		include "includes/mysql.php";
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['titulo'] = trim($dados['titulo']);

		$dados['ordem'] = 1;
		$ordem = buscaFeatures(array('max'=>'ordem')); 
		
		if (!empty($ordem)){
			$ordem = $ordem[0];	
			$dados['ordem'] = (int)$ordem['max']+1;	
		}

      // if($dados['tipo'] == 1){
      //    $dados['numero'] = str_replace(".", "", $dados['numero']);
      //    $dados['numero'] = str_replace(",", "", $dados['numero']);
      // }

		$sql = "INSERT INTO features(titulo, numero, ordem, ididiomas, idatuacao, icone, tipo) VALUES (
						'".$dados['titulo']."',
                        '".$dados['numero']."',
                        '".$dados['ordem']."',
                        '".$dados['ididiomas']."',
						'".$dados['idatuacao']."',
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
	 * <p>edita features no banco</p>
	 */
	function editFeatures($dados)
	{

		include "includes/mysql.php";
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['titulo'] = trim($dados['titulo']);

      // if($dados['tipo'] == 1){
      //    $dados['numero'] = str_replace(".", "", $dados['numero']);
      //    $dados['numero'] = str_replace(",", "", $dados['numero']);
      // }

		$sql = "UPDATE features SET
                  numero = '".$dados['numero']."',
                  titulo = '".$dados['titulo']."',
                  ididiomas = '".$dados['ididiomas']."',
						idatuacao = '".$dados['idatuacao']."'
					WHERE idfeatures = " . $dados['idfeatures'];

	 	if (mysqli_query($conexao, $sql)) {
			return $dados['idfeatures'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca features no banco</p>
	 */

	function buscaFeatures($dados = array())
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
		if (array_key_exists('idfeatures',$dados) && !empty($dados['idfeatures']) )
			$buscaId = ' and C.idfeatures = '.intval($dados['idfeatures']).' '; 

      //busca pelo id
      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and C.ididiomas = '.intval($dados['ididiomas']).' '; 

      //busca pelo id
      $buscaIdAtuacao = '';
      if (array_key_exists('idatuacao',$dados) && !empty($dados['idatuacao']) )
         $buscaIdAtuacao = ' and C.idatuacao = '.intval($dados['idatuacao']).' '; 

		//busca pelo nome
		$buscaNome = '';
		if (array_key_exists('titulo',$dados) && !empty($dados['titulo']) )
			$buscaNome = ' and C.titulo LIKE "%'.$dados['titulo'].'%" '; 

		//busca pelo imagem_icone
		$buscaNumero = '';
		if (array_key_exists('numero',$dados) && !empty($dados['numero']) )
			$buscaNumero = ' and C.numero = "'.$dados['numero'].'" ';

		//busca pelo descricao
		$buscaDescricao = '';
		if (array_key_exists('descricao',$dados) && !empty($dados['descricao']) )
			$buscaDescricao = ' and C.descricao = "'.$dados['descricao'].'" ';

		$buscaOrdem = '';
			if (array_key_exists('order',$dados) && !empty($dados['order']) )
				$buscaOrdem = ' and C.ordem = "'.$dados['order'].'" ';

		$buscaPagina = '';
			if (array_key_exists('pagina',$dados) && !empty($dados['pagina']))
				$buscaPagina = ' and C.pagina = "'.$dados['pagina'].'" ';

         //ordem
        $orderBy = "";                   
        if (array_key_exists('ordem',$dados) && !empty($dados['ordem'])){ 
	    	$orderBy = ' ORDER BY '.$dados['ordem']; 
	    	if (array_key_exists('dir',$dados) && !empty($dados['dir'])){ 
		    	$orderBy .= " ". $dados['dir']; 
	        } 
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
		$colsSql = 'C.*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idfeatures) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql $buscaMax FROM features as C
				WHERE 1  $buscaId $buscaIdIdiomas $buscaIdAtuacao $buscaNumero $buscaNome $buscaOrdem $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql, I.bandeira $buscaMax FROM features as C LEFT JOIN idiomas as I ON C.ididiomas = I.ididiomas
            WHERE 1  $buscaId $buscaIdIdiomas $buscaIdAtuacao $buscaNumero $buscaNome $buscaOrdem $orderBy $buscaLimit ";
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
                        $r['ordemUp'] = '<img src="images/arrUp.png" codigo="'.$r['idfeatures'].'" class="link ordemUp" />';
                }

                if ($iAux != $tot){
                        $r['ordemDown'] = '<img src="images/arrDown.png" codigo="'.$r['idfeatures'].'" class="link ordemDown"/>';
				}
                $iAux++;
	        }  
			$resultado[] = $r;
		}
		return $resultado;
		
 	}

	/**
	 * <p>deleta features no banco</p>
	 */
	function deletaFeatures($dados)
	{
		include "includes/mysql.php";

		$features = buscaFeatures(array("idfeatures"=>$dados));
		$ordem = $features[0]['ordem'];
		$imagem = $features[0]['imagem_icone']; 
		 
		$sql = "DELETE FROM features WHERE idfeatures = $dados";
		if (mysqli_query($conexao, $sql)) {
			$num = mysqli_affected_rows($conexao);
			$sql ="UPDATE features SET ordem = (ordem - 1) WHERE ordem > ".$ordem;
			mysqli_query($conexao, $sql);
			apagarImagemFeatures($imagem); 
			return $num;
		} else {
			return FALSE;
		}
	} 
 
 	function editarImagemFeatures($imgs) {
		$path = 'files/features/';

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

	//APAGAR IMAGENS DA PASTA
	function apagarImagemFeatures($imgs) {  
		$path = 'files/features/'; 

		if(file_exists($path)){   
        	//apaga os arquivos que foram salvos   
			$arquivo = $imgs; 
		    $original = "original_".$arquivo;
		    if(file_exists($path.$arquivo)){  
				unlink($path.$arquivo);
			} 
        	if(file_exists($path.$original)){  
				unlink($path.$original);
			} 	  
        }  
		return true; 
	}

//////////////////////////////////////////////////////

	/**
	 * <p>busca features_imagem no banco</p>
	 */
	function buscaFeatures_imagem($dados = array())
	{
		include "includes/mysql.php";
		include_once('includes/functions.php');
 
		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		} 
	 

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idfeatures_imagem',$dados) && !empty($dados['idfeatures_imagem']) )
			$buscaId = ' and idfeatures_imagem = '.intval($dados['idfeatures_imagem']).' '; 

		//busca pelo idfeatures
		$buscaIdfeatures = '';
		if (array_key_exists('idfeatures',$dados) && !empty($dados['idfeatures']) )
			$buscaIdfeatures = ' and idfeatures = "'.$dados['idfeatures'].'" '; 


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
			$colsSql = ' count(idfeatures_imagem) as totalRecords'; 
	        $buscaLimit = '';
	        $orderBy = '';
	    } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}  

		$sql = "SELECT $colsSql FROM features_imagem 
				WHERE 1  $buscaId  $buscaIdfeatures  
				$buscaDescricao_imagem  $buscaUrlrewrite_imagem 
				$buscaPosicao_imagem  $buscaM2y_imagem  $orderBy $buscaLimit ";
				
		 
		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		while ($r = mysqli_fetch_assoc($query)){
			if(isset($dados['url'])){
				$r['descricao_imagem_url']= converteUrl($r['descricao_imagem']);	
			}  
			$r = array_map('utf8_encode', $r); 
			$resultado[] = $r;
		}
		
		return $resultado; 
	}


	function cadastroFeatures_imagem($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "INSERT INTO features_imagem( idfeatures, nome_imagem, descricao_imagem, urlrewrite_imagem, posicao_imagem, m2y_imagem,is_default) VALUES (
					'".$dados['idfeatures']."',
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
	 * <p>edita features_imagem no banco</p>
	 */
	function editFeatures_imagem($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v); 
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "UPDATE features_imagem SET
						idfeatures = '".$dados['idfeatures']."',
						descricao_imagem = '".$dados['descricao_imagem']."',
						urlrewrite_imagem = '".$dados['urlrewrite_imagem']."',
						posicao_imagem = '".$dados['posicao_imagem']."',
						is_default = '".$dados['is_default']."',
						nome_imagem = '".$dados['nome_imagem']."',
						m2y_imagem = '".$dados['m2y_imagem']."'
					WHERE idfeatures_imagem = " . $dados['idfeatures_imagem'];
  
		if (mysqli_query($conexao, $sql)) {
			return $dados['idfeatures_imagem'];
		} else {
			return false;
		}
	}


	function salvaImagemFeatures($dados){   

		include_once "includes/functions.php"; 
		$dadosGravar = array(); 

		$idfeatures = $dados['idfeatures'];
		//urlrewrite
		$nomeimagem = explode('.', $dados['nome_imagem']);
		$nomeimagem = $nomeimagem[0];
		$dados['urlrewrite_imagem'] = converteUrl($dados['nome_imagem']);	
		
		//atribuir m2y 
		$urlamigavel = 'admin/files/features/'.$idfeatures.'/galeria/thumb/'.$dados['nome_imagem'];
	 
		$dados['m2y_imagem'] = ''; 
		$shorturl = ENDERECO.$urlamigavel;
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

		return cadastroFeatures_imagem($dados); 
	}

	//APAGA UM IMAGEM ESPECIFICA DA GALERIA
	function deletarImagemFeaturesGaleria($idfeatures_imagem, $idfeatures){ 

		include "includes/mysql.php"; 
		$return = false;

		$imagem = buscaFeatures_imagem(array("idfeatures_imagem"=>$idfeatures_imagem));
           	 
    	$posicao = $imagem[0]['posicao_imagem'];
    	$sql = 'DELETE from features_imagem WHERE idfeatures_imagem = '.$idfeatures_imagem;

		if (mysqli_query($conexao, $sql)) {
    		//update nas posicao das imagens
			$sql = 'UPDATE features_imagem SET posicao_imagem = (posicao_imagem - 1) WHERE idfeatures = '.$idfeatures.' and posicao_imagem > '.$posicao;
			if (mysqli_query($conexao, $sql)) {
				//marca a primeira posicao como default - caso apague q primeira imagem
				$sql = 'UPDATE features_imagem SET is_default = 1 WHERE idfeatures = '.$idfeatures.' and posicao_imagem = 1';
				mysqli_query($conexao, $sql);
				$return = true;
			}
		} else {
			$return = false;
		} 
		 
        return $return;	
    }   
	    

    function alterarPosicaoImagemFeatures($dados){

    	include "includes/mysql.php"; 	

    	$imagens = $dados['idfeatures_imagem'];
    	$posicao = $dados['posicao_imagem'];
    	$idfeatures = $dados['idfeatures'];

		if(!empty($imagens)){
			 
			foreach($imagens as $k => $v){
				$sql = 'UPDATE features_imagem SET 
						posicao_imagem = "'.$posicao[$k].'",
						is_default = 0
						WHERE idfeatures_imagem = '.$v;
				 
				mysqli_query($conexao, $sql);		
			} 

			$sql = 'UPDATE features_imagem SET is_default = 1 WHERE idfeatures = '.$idfeatures.' and posicao_imagem = 1';
		  			mysqli_query($conexao, $sql);
					return true;  
		}else{ 
			return true;
		}
    } 

    function editOrdemFeatures($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE features SET					
						ordem = '".$dados['ordem']."'						
					WHERE idfeatures = " . $dados['idfeatures'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idfeatures'];
	    } else {
	        return false;
	    }
	}


?>