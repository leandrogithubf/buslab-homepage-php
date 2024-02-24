<?php 

// Versao do modulo: 3.00.010416
if (isset($_REQUEST['ajax'])) {
	# code...
}else{
require_once 'includes/verifica.php'; // checa user logado
 }

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_BLOG_POST") || define("CADASTRO_BLOG_POST","cadastroBlog_post");
defined("EDIT_BLOG_POST") || define("EDIT_BLOG_POST","editBlog_post");
defined("DELETA_BLOG_POST") || define("DELETA_BLOG_POST","deletaBlog_post");
  
//GALERIA
defined("SALVA_GALERIA") || define("SALVA_GALERIA","salvarGaleria");
defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","salvarDescricao");
defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","excluirImagemGaleria");
defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alterarPosicaoImagem");
defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","excluiImagensTemporarias");


defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");
defined("ADICIONAL_LIKE") || define("ADICIONAL_LIKE","adicionaLike");
defined("ADICIONAL_CONTADOR") || define("ADICIONAL_CONTADOR","adicionaContador");
defined("VERIFICA_TIPOS") || define("VERIFICA_TIPOS","VerificaTipos");

defined("INVERTE_STATUS_POST") || define("INVERTE_STATUS_POST", "inverteStatusPost");

switch ($opx) {

	case CADASTRO_BLOG_POST:
	
		include_once 'blog_post_class.php';
		include_once 'includes/functions.php'; 
		include_once 'includes/fileImage.php'; 
		 
		$dados = $_REQUEST; 

		$dados['imagem'] = "";		
		$idtemporario = $dados['idblog_post']; 

		$texto = $dados['descricao'];
		$end = ENDERECO."admin/files/blog/";
		$texto = str_replace('src="files/blog/"', $end, $texto);
	 	$dados['descricao'] = $texto;
 

	 	//IMAGEM LISTAGEM PRINCIPAL
		if(isset($_FILES['imagemPost']) && $_FILES['imagemPost']['error'] == 0){   
		    ///////////////////////
		    //FOTO POR CROPPED////	
		    //////////////////////  
		    $imagem = $_FILES; 
		    $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);  
		    $nomeimagem = fileImage("blog", '', '', $imagem['imagemPost'], 742, 375, 'cropped', $coordenadas);  		     
		    $thumb = fileImage("blog", $nomeimagem, "thumb", $imagem['imagemPost'], 400, 400, 'crop');  
		    $thumb2 = fileImage("blog", $nomeimagem, "thumb2", $imagem['imagemPost'], 187, 94, 'crop');  
		  	$dados['imagem'] = $nomeimagem;  
        } 

		$idBlog_post = cadastroBlog_post($dados);

		$idg = "";
		if(isset($dados['idg'])){
			$idg = "&idg=".$dados['idg'];
		}
		
		if (is_int($idBlog_post)) { 

			if(isset($dados['imagem_blog_post'])){
				$imagens = $dados['imagem_blog_post'];
				//galeria
				if(!empty($imagens)){
					$descricao = $dados['descricao_imagem'];
					$posicao = $dados['posicao_imagem']; 
					foreach($imagens as $k=>$v){
						$imagem['idblog_post'] = $idBlog_post;
						$imagem['descricao_imagem'] = $descricao[$k];
						$imagem['posicao_imagem'] = $posicao[$k];
						$imagem['nome_imagem'] = $v; 
						salvaImagemBlog_post($imagem);					
					} 
				} 
			} 

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'blog_post';
			$log['descricao'] = 'Cadastrou blog_post ID('.$idBlog_post.') nome ('.$dados['nome'].') suspensorio ('.$dados['suspensorio'].') resumo ('.$dados['resumo'].') descricao ('.$dados['descricao'].') imagem ('.$dados['imagem'].') blog_post ('.$dados['blog_post'].') inicio ('.$dados['inicio'].') fim ('.$dados['fim'].') detalhe_data ('.$dados['detalhe_data'].') status ('.$dados['status'].') urlrewrite ('.$dados['urlrewrite'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('Post criado com sucesso!'));
		} else {
			header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('ERRO ao criar novo post!'));
		}

	break;

	case EDIT_BLOG_POST:
		include_once 'blog_post_class.php';
		include_once 'includes/functions.php'; 
		include_once 'includes/fileImage.php'; 

		$dados = $_REQUEST;
		 
		$antigo = buscaBlog_post(array('idblog_post'=>$dados['idblog_post']));
		$antigo = $antigo[0]; 

		//IMAGEM LISTAGEM PRINCIPAL
		if(isset($_FILES['imagemPost']) && $_FILES['imagemPost']['error'] == 0){   
		    ///////////////////////
		    ///FOTO POR CROPPED///
		    //////////////////////  
		    $imagem = $_FILES; 
		    $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']); 
		    $nomeimagem = fileImage("blog", "", "", $imagem['imagemPost'], 742, 375, 'cropped',$coordenadas); 
		    $thumb = fileImage("blog", $nomeimagem, "thumb", $imagem['imagemPost'], 400, 400, 'crop'); 
    		$thumb2 = fileImage("blog", $nomeimagem, "thumb2", $imagem['imagemPost'], 187, 94, 'crop');  
    		 	 
			//apaga qualquer outra foto anterior 
       		apagarImagemBlog($antigo['imagem']);  
    		$dados['imagem'] = $nomeimagem;  
        } 
       

		$idBlog_post = editBlog_post($dados);

		$idg = "";
		if(isset($dados['idg'])){
			$idg = "&idg=".$dados['idg'];
		}

		if ($idBlog_post > 0) {   
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'blog_post';
			$log['descricao'] = 'Editou blog_post ID('.$idBlog_post.') DE  nome ('.$antigo['nome'].') resumo ('.$antigo['resumo'].') descricao ('.$antigo['descricao'].') imagem ('.$antigo['imagem'].') blog_post ('.$antigo['blog_post'].') status ('.$antigo['status'].') urlrewrite ('.$antigo['urlrewrite'].') PARA  nome ('.$dados['nome'].') resumo ('.$dados['resumo'].') descricao ('.$dados['descricao'].') imagem ('.$dados['imagem'].') blog_post ('.$dados['blog_post'].') status ('.$dados['status'].') urlrewrite ('.$dados['urlrewrite'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('Post salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('ERRO ao salvar post!'));
		}

	break;

	case DELETA_BLOG_POST:
		include_once 'blog_post_class.php';
		include_once 'usuario_class.php'; 

		$dados = $_REQUEST;
		$idg = "";
		if(isset($dados['idg'])){
			$idg = "&idg=".$dados['idg'];
		}

		if (!verificaPermissaoAcesso('blog_post_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			
			$antigo = buscaBlog_post(array('idblog_post'=>$dados['idu']));

			if (deletaBlog_post($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'blog_post';
				$log['descricao'] = 'Deletou blog_post ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('Post deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=blog_post&acao=listarBlog_post'.$idg.'&mensagemalerta='.urlencode('ERRO ao deletar post!'));
			}
		}

	break;



    //SALVA IMAGENS DA GALERIA 
    case SALVA_GALERIA:
            
        include_once ('blog_post_class.php');
				include_once 'includes/fileImage.php';
            
				$dados = $_POST;
        $idblog_post = $dados['idblog_post'];
        $posicao = $dados['posicao']; 

        $imagem = $_FILES;
        
        $caminhopasta = "files/blog";
        if(!file_exists($caminhopasta)){
        	mkdir($caminhopasta, 0777);
        }  
       
        //galeria grande
      	$nomeimagem = fileImage("blog", "", "", $imagem['imagem'], 342, 264, 'resize');  
      	$thumb = fileImage("blog", $nomeimagem, "thumb", $imagem['imagem'], 342, 264, 'crop'); 
       
        $caminho = $caminhopasta.'/thumb_'.$nomeimagem;

        //vai cadastrar se já tiver o id do servicos, senao so fica na pasta.
        $idblog_post_imagem = $nomeimagem; 

        if(is_numeric($idblog_post)){
        	//CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
			$imagem['idblog_post'] = $idblog_post;
			$imagem['descricao_imagem'] = "";
			$imagem['posicao_imagem'] = $posicao;
			$imagem['nome_imagem'] = $nomeimagem; 
			$idblog_post_imagem = salvaImagemBlog_post($imagem);	
        } 
       
        print '{"status":true, "caminho":"'.$caminho.'", "idblog_post":"'.$idblog_post.'", "idblog_post_imagem":"'.$idblog_post_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
    break; 
 
   case SALVAR_DESCRICAO_IMAGEM:
		include_once('blog_post_class.php');
		$dados = $_POST;

		$imagem = buscaBlog_post_imagem(array("idblog_post_imagem"=>$dados['idImagem']));
		$imagem = $imagem[0];
		if($imagem){
			$imagem['descricao_imagem'] = $dados['descricao'];
			if(editBlog_post_imagem($imagem)){
				print '{"status":true}';
			}else{
				print '{"status":false}';
			}
		}else{
			print '{"status":false}';
		}
		
	break; 

	//EXCLUI A IMAGEM DA GALERIA SELECIONADA
	case EXCLUIR_IMAGEM_GALERIA:
				
		include_once('blog_post_class.php');

		$dados = $_POST;  
		$idblog_post = $dados['idblog_post'];
		$idblog_post_imagem = $dados['idblog_post_imagem'];
		$imagem = $dados['imagem']; 
 
		if(is_numeric($idblog_post) && $idblog_post > 0){ 
			//esta editando, apagar a imagem da pasta e do banco
			deletarImagemBlogGaleria($idblog_post_imagem, $idblog_post);
			$retorno['status'] = apagarImagemBlog($imagem);
		}else{
			//apagar somente a imagem da pastar
			$retorno['status'] = apagarImagemBlog($imagem);
		}  
		print json_encode($retorno);   

	break;

	 
	//ALTERAR POSICAO DA IMAGEM
	case ALTERAR_POSICAO_IMAGEM:
				
		include_once('blog_post_class.php');
		$dados = $_POST;  
		alterarPosicaoImagemBlog_post($dados);
		print '{"status":true}';

	break; 
	 

	//EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
	case EXCLUIR_IMAGENS_TEMPORARIAS: 
		include_once('blog_post_class.php');
		$dados = $_POST;	
		
		if(isset($dados['imagem_blog_post'])){
			$imgs = $dados['imagem_blog_post'];
			foreach ($imgs as $key => $value) { 
				apagarImagemBlog($value);
			}
		} 
		print '{"status":true}'; 
	break; 
 
  

	case VERIFICAR_URLREWRITE:

		include_once('blog_post_class.php'); 
		include_once('includes/functions.php');
		
		$dados = $_POST;
		 
		$urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $dados['urlrewrite'])));
 		
 		if($dados['idblog_post'] && $dados['idblog_post'] <= 0){
 			$url = buscaBlog_post(array("urlrewrite"=>$urlrewrite)); 	
 		}else{ 
 			$url = buscaBlog_post(array("urlrewrite"=>$urlrewrite,"not_idblog_post"=>$dados['idblog_post'])); 
 		} 

 		if(empty($url)){ 
 			print '{"status":true,"url":"'.$urlrewrite.'"}';
 		}else{
 			print '{"status":false}';
 		} 

	break;

	case ADICIONAL_LIKE:

		include_once('blog_post_class.php'); 
		include_once('includes/functions.php');
		
		$dados = $_POST;
		$likes_atuais = buscaBlog_post(array('idblog_post'=>$dados['idblog_post']));
		$likes_atuais = $likes_atuais[0];
		$likes_atuais['likes'] = (int)$likes_atuais['likes'] + 1;
		$new_like['likes'] = $likes_atuais['likes'];
		$new_like['idblog_post'] = $likes_atuais['idblog_post'];
		$up = UpdateLike($new_like);
		if ($up != false) {
			$new_busca = buscaBlog_post(array('idblog_post'=>$dados['idblog_post']));
			$new_busca = $new_busca[0];
			echo json_encode(array('status'=>true, 'likes'=>$new_busca['likes']));
		}else{
			echo json_encode(array('status'=>false));
		}
	break;
	case ADICIONAL_CONTADOR:

		include_once('blog_post_class.php'); 
		include_once('includes/functions.php');
		
		$dados = $_POST;
		$contador_atual = buscaBlog_post(array('idblog_post'=>$dados['idblog_post']));
		$contador_atual = $contador_atual[0];
		$contador_atual['contador'] = (int)$contador_atual['contador'] +  1;
		$new_contador['contador'] = $contador_atual['contador'];
		$new_contador['idblog_post'] = $contador_atual['idblog_post'];
		$cont = UpdateContador($new_contador);
		if ($cont != false) {
			echo json_encode(array('status'=>true));
		}else{
			echo json_encode(array('status'=>false));
		}
	break;


	case VERIFICA_TIPOS:

			include_once('blog_post_class.php'); 
			include_once('includes/functions.php');
			
			$dados = $_POST;
		
			if ($dados['tipo'] == 1) {
				$blogss = buscaBlog_post(array('status'=>'A', 'limit'=>3, 'ordem'=>'data_hora desc'));

				
			}else if($dados['tipo'] == 2){
				$blogss = buscaBlog_post(array('status'=>'A', 'limit'=>3, 'ordem'=>'contador desc'));
			}else if($dados['tipo'] == 3){
				
				$blogss = buscaBlog_post(array('status'=>"A", 'destaque'=>1, 'limit'=>3));
			
			}

			$html ='';
			foreach ($blogss as $key => $b) {
				$html ='<li>';
				$html .='<a href="'.ENDERECO.'blog/'.$b['urlrewrite'].'">';
				$html .='<div class="list-blog-">';
				$html .='<img src="admin/files/blog/'.$b['imagem'].'" class="img-blog-list">';
				$html .='<span>'.$b['data_formatado_pointer'].'</span>';
				$html .='<p>'.$b['nome'].'</p>';
				$html .='</div></a>';
				$html .='</li>';

				echo $html;
			}
			
		break;

	case INVERTE_STATUS_POST:
		include_once("blog_post_class.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';
		include_once("includes/functions.php");
		$tabela = 'blog_post';
		$id = 'idblog_post';

		try {
			$blog_post = buscaBlog_post(array('idblog_post' => $dados['idblog_post']));
			$blog_post = $blog_post[0];

			// print_r($blog_post);
			if($blog_post['status'] == 1){
				$status = 0;
			}
			else{
				$status = 1;
			}

			$dadosUpdate = array();
			$dadosUpdate['idblog_post'] = $dados['idblog_post'];
			$dadosUpdate['status'] = $status;
			inverteStatus($dadosUpdate,$tabela,$id);

			print json_encode($resultado);
		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	default:
		if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
			header('Location: index.php?mod=home&mensagemalerta='.urlencode('Nenhuma acao definida...'));
		} else {
			trigger_error('Erro...', E_USER_ERROR);
			exit;
		}

}
?>