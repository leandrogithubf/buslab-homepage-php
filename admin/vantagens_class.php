<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva vantagens no banco</p>
	 */

	function cadastroVantagens($dados)
	{
		include "includes/mysql.php";
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['titulo'] = trim($dados['titulo']);
		$dados['descricao'] = trim($dados['descricao']);

		$dados['ordem'] = 1;
		$ordem = buscaVantagens(array('max'=>'ordem')); 
		
		if (!empty($ordem)){
			$ordem = $ordem[0];	
			$dados['ordem'] = (int)$ordem['max']+1;	
		}

		if(empty($dados['icone'])){
			$dados['icone'] = 1;
		}

		$sql = "INSERT INTO vantagens(icone, titulo, descricao, ordem, ididiomas, numero) VALUES (
						'".$dados['icone']."',
						'".$dados['titulo']."',
						'".$dados['descricao']."',
                        '".$dados['ordem']."',
						'".$dados['ididiomas']."',
                        '".$dados['numero']."'
                    )";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita vantagens no banco</p>
	 */
	function editVantagens($dados)
	{

		include "includes/mysql.php";
		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['titulo'] = trim($dados['titulo']);
		$dados['descricao'] = trim($dados['descricao']);

		$sql = "UPDATE vantagens SET
                        icone = '".$dados['icone']."',
						titulo = '".$dados['titulo']."',
                  descricao = '".$dados['descricao']."',
						ididiomas = '".$dados['ididiomas']."'
					WHERE idvantagens = " . $dados['idvantagens'];

	 	if (mysqli_query($conexao, $sql)) {
			return $dados['idvantagens'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca vantagens no banco</p>
	 */

	function buscaVantagens($dados = array())
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
		if (array_key_exists('idvantagens',$dados) && !empty($dados['idvantagens']) )
			$buscaId = ' and C.idvantagens = '.intval($dados['idvantagens']).' '; 

      //busca pelo id
      $buscaIdIdiomas = '';
      if (array_key_exists('ididiomas',$dados) && !empty($dados['ididiomas']) )
         $buscaIdIdiomas = ' and C.ididiomas = '.intval($dados['ididiomas']).' '; 

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
			$colsSql = ' count(idvantagens) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

      if (array_key_exists('totalRecords',$dados)){
		   $sql = "SELECT $colsSql $buscaMax FROM vantagens as C WHERE 1  $buscaId $buscaIdIdiomas $buscaNome $buscaNumero $buscaOrdem $orderBy $buscaLimit ";
      }else{
         $sql = "SELECT $colsSql $buscaMax, I.bandeira FROM vantagens as C LEFT JOIN idiomas as I ON C.ididiomas = I.ididiomas
            WHERE 1  $buscaId $buscaIdIdiomas $buscaNome $buscaNumero $buscaOrdem $orderBy $buscaLimit ";
      }
	 
		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		$iAux = 1;        
		$tot =  mysqli_affected_rows($conexao);

		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r); 
			if (!array_key_exists('totalRecords',$dados)){
            $r['bandeira'] = "<img src=files/idiomas/".$r['bandeira'].">";
				$StringIcone = strlen($r['icone']);
                if ($StringIcone < 4) {
                    $icones_Edit = buscaFW3(array('idfw' => $r['icone']));
                    $icones_Edit = $icones_Edit[0];
                }
                $StringIcone > 4 ? $r['icone_caminho'] = "<img src='files/vantagens/" . $r['icone'] . "' class='icone' />" : $r['icone_caminho'] = '<i class="fa fa-' . $icones_Edit['nome'] . ' fa-2x icone"></i>';
                // $StringIcone > 4 ? $r['icone_front'] = "<img src='admin/files/vantagens/" . $r['icone'] . "' class='mr-2 icone' />" : $r['icone_front'] = '<i class="fa fa-' . $icones_Edit['nome'] . ' fa-lg mr-2 icone" style="color:#2460a7; font-size: 53px"></i>';

            	$r['ordemUp'] = "";
                $r['ordemDown'] = "";

                if ($iAux != 1){
                        $r['ordemUp'] = '<img src="images/arrUp.png" codigo="'.$r['idvantagens'].'" class="link ordemUp" />';
                }

                if ($iAux != $tot){
                        $r['ordemDown'] = '<img src="images/arrDown.png" codigo="'.$r['idvantagens'].'" class="link ordemDown"/>';
				}
                $iAux++;
	        }  
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta vantagens no banco</p>
	 */
	function deletaVantagens($dados)
	{
		include "includes/mysql.php";

		$vantagens = buscaVantagens(array("idvantagens"=>$dados));
		$ordem = $vantagens[0]['ordem'];
		$imagem = $vantagens[0]['imagem_icone']; 
		 
		$sql = "DELETE FROM vantagens WHERE idvantagens = $dados";
		if (mysqli_query($conexao, $sql)) {
			$num = mysqli_affected_rows($conexao);
			$sql ="UPDATE vantagens SET ordem = (ordem - 1) WHERE ordem > ".$ordem;
			mysqli_query($conexao, $sql);
			apagarImagemVantagens($imagem); 
			return $num;
		} else {
			return FALSE;
		}
	} 
 
 	function editarImagemVantagens($imgs) {
		$path = 'files/vantagens/';

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
	function apagarImagemVantagens($imgs) {  
		$path = 'files/vantagens/'; 

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
	 * <p>busca vantagens_imagem no banco</p>
	 */
	function buscaVantagens_imagem($dados = array())
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
		if (array_key_exists('idvantagens_imagem',$dados) && !empty($dados['idvantagens_imagem']) )
			$buscaId = ' and idvantagens_imagem = '.intval($dados['idvantagens_imagem']).' '; 

		//busca pelo idvantagens
		$buscaIdvantagens = '';
		if (array_key_exists('idvantagens',$dados) && !empty($dados['idvantagens']) )
			$buscaIdvantagens = ' and idvantagens = "'.$dados['idvantagens'].'" '; 


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
			$colsSql = ' count(idvantagens_imagem) as totalRecords'; 
	        $buscaLimit = '';
	        $orderBy = '';
	    } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}  

		$sql = "SELECT $colsSql FROM vantagens_imagem 
				WHERE 1  $buscaId  $buscaIdvantagens  
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


	function cadastroVantagens_imagem($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "INSERT INTO vantagens_imagem( idvantagens, nome_imagem, descricao_imagem, urlrewrite_imagem, posicao_imagem, m2y_imagem,is_default) VALUES (
					'".$dados['idvantagens']."',
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
	 * <p>edita vantagens_imagem no banco</p>
	 */
	function editVantagens_imagem($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			if (get_magic_quotes_gpc()) $v = stripslashes($v); 
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$sql = "UPDATE vantagens_imagem SET
						idvantagens = '".$dados['idvantagens']."',
						descricao_imagem = '".$dados['descricao_imagem']."',
						urlrewrite_imagem = '".$dados['urlrewrite_imagem']."',
						posicao_imagem = '".$dados['posicao_imagem']."',
						is_default = '".$dados['is_default']."',
						nome_imagem = '".$dados['nome_imagem']."',
						m2y_imagem = '".$dados['m2y_imagem']."'
					WHERE idvantagens_imagem = " . $dados['idvantagens_imagem'];
  
		if (mysqli_query($conexao, $sql)) {
			return $dados['idvantagens_imagem'];
		} else {
			return false;
		}
	}


	function salvaImagemVantagens($dados){   

		include_once "includes/functions.php"; 
		$dadosGravar = array(); 

		$idvantagens = $dados['idvantagens'];
		//urlrewrite
		$nomeimagem = explode('.', $dados['nome_imagem']);
		$nomeimagem = $nomeimagem[0];
		$dados['urlrewrite_imagem'] = converteUrl($dados['nome_imagem']);	
		
		//atribuir m2y 
		$urlamigavel = 'admin/files/vantagens/'.$idvantagens.'/galeria/thumb/'.$dados['nome_imagem'];
	 
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

		return cadastroVantagens_imagem($dados); 
	}

	//APAGA UM IMAGEM ESPECIFICA DA GALERIA
	function deletarImagemVantagensGaleria($idvantagens_imagem, $idvantagens){ 

		include "includes/mysql.php"; 
		$return = false;

		$imagem = buscaVantagens_imagem(array("idvantagens_imagem"=>$idvantagens_imagem));
           	 
    	$posicao = $imagem[0]['posicao_imagem'];
    	$sql = 'DELETE from vantagens_imagem WHERE idvantagens_imagem = '.$idvantagens_imagem;

		if (mysqli_query($conexao, $sql)) {
    		//update nas posicao das imagens
			$sql = 'UPDATE vantagens_imagem SET posicao_imagem = (posicao_imagem - 1) WHERE idvantagens = '.$idvantagens.' and posicao_imagem > '.$posicao;
			if (mysqli_query($conexao, $sql)) {
				//marca a primeira posicao como default - caso apague q primeira imagem
				$sql = 'UPDATE vantagens_imagem SET is_default = 1 WHERE idvantagens = '.$idvantagens.' and posicao_imagem = 1';
				mysqli_query($conexao, $sql);
				$return = true;
			}
		} else {
			$return = false;
		} 
		 
        return $return;	
    }   
	    

    function alterarPosicaoImagemVantagens($dados){

    	include "includes/mysql.php"; 	

    	$imagens = $dados['idvantagens_imagem'];
    	$posicao = $dados['posicao_imagem'];
    	$idvantagens = $dados['idvantagens'];

		if(!empty($imagens)){
			 
			foreach($imagens as $k => $v){
				$sql = 'UPDATE vantagens_imagem SET 
						posicao_imagem = "'.$posicao[$k].'",
						is_default = 0
						WHERE idvantagens_imagem = '.$v;
				 
				mysqli_query($conexao, $sql);		
			} 

			$sql = 'UPDATE vantagens_imagem SET is_default = 1 WHERE idvantagens = '.$idvantagens.' and posicao_imagem = 1';
		  			mysqli_query($conexao, $sql);
					return true;  
		}else{ 
			return true;
		}
    } 

    function editOrdemVantagens($dados)
	{
	    include "includes/mysql.php";
	   
	    $sql = "UPDATE vantagens SET					
						ordem = '".$dados['ordem']."'						
					WHERE idvantagens = " . $dados['idvantagens'];
	    
	    if (mysqli_query($conexao, $sql)) {
	        return $dados['idvantagens'];
	    } else {
	        return false;
	    }
	}


?>