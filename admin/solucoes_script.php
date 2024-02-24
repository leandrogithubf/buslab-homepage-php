<?php 
	 // Versao do modulo: 3.00.010416
require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("INVERTE_STATUS") || define("INVERTE_STATUS", "inverteStatus");
defined("CADASTRO_SOLUCOES") || define("CADASTRO_SOLUCOES","cadastroSolucoes");
defined("EDIT_SOLUCOES") || define("EDIT_SOLUCOES","editSolucoes");
defined("DELETA_SOLUCOES") || define("DELETA_SOLUCOES","deletaSolucoes");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");

//GALERIA
defined("SALVA_GALERIA") || define("SALVA_GALERIA","salvarGaleria");
defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","salvarDescricao");
defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","excluirImagemGaleria");
defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alterarPosicaoImagem");
defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","excluiImagensTemporarias");

switch ($opx) {

	case CADASTRO_SOLUCOES:
		include_once 'solucoes_class.php';
		include_once 'includes/fileImage.php';

		$dados = $_REQUEST;
		$imagens = $_FILES;

		$caminhopasta = "files/recursos";

        if(!file_exists($caminhopasta)){
        	mkdir($caminhopasta, 0777);
        }

        $arrayImg = "";
         if($dados['grid-imagem'] > 0){
           if(!empty($imagens['imagem'])){
               foreach($imagens['imagem'] as $key => $imgArray){
                   foreach($imgArray as $keyName => $img){
                       $arrayImg[$keyName][$key] = $img['imagem'];              
                   }
               }
               foreach($arrayImg as $img){
                   $nomeimagem[] = fileImage("imagem", "", "", $img, 634, 415, 'resize');
               }
               foreach($dados['imagem'] as $keys => $imagem){
                   foreach($nomeimagem as $key => $names){
                       $dados['imagem'][$key]['imagem'] = $names;
                   }
               }
           }
         }

        $arrayImg2 = "";
        if($dados['grid-recursos'] > 0){
           if(!empty($imagens['recursos'])){
               foreach($imagens['recursos'] as $key => $imgArray){
                   foreach($imgArray as $keyName => $img){
                       $arrayImg2[$keyName][$key] = $img['recursos'];              
                   }
               }
               foreach($arrayImg2 as $img){
                   $nomeimagem2[] = fileImage("imagem", "", "", $img, 30, 30, 'resize');
               }
               foreach($dados['recursos'] as $keys => $imagem){
                   foreach($nomeimagem2 as $key => $names){
                       $dados['recursos'][$key]['imagem'] = $names;
                   }
               }
           }
        }

        $arrayImg3 = "";
        if($dados['grid-servicos'] > 0){
           if(!empty($imagens['servicos'])){
               foreach($imagens['servicos'] as $key => $imgArray){
                   foreach($imgArray as $keyName => $img){
                       $arrayImg3[$keyName][$key] = $img['servicos'];              
                   }
               }
               foreach($arrayImg3 as $img){
                   $nomeimagem3[] = fileImage("imagem", "", "", $img, 30, 30, 'resize');
               }
               foreach($dados['servicos'] as $keys => $imagem){
                   foreach($nomeimagem3 as $key => $names){
                       $dados['servicos'][$key]['imagem'] = $names;
                   }
               }
           }
        }

		$idSolucoes = cadastroSolucoes($dados);
		// $idRecursos = cadastroRecursos($dados);

		if (is_int($idSolucoes)) {
			   foreach($dados['recursos'] as $keys => $rec){
                $dados['recursos'][$keys]['idsolucoes'] = $idSolucoes;
                // if(empty($rec['icone'])){
                // 	$rec['icone'] = 1;
                // }
                cadastroRecursos($dados['recursos'][$keys]);
            }
            foreach($dados['servicos'] as $keys => $rec){
                $dados['servicos'][$keys]['idsolucoes'] = $idSolucoes;
                // if(empty($rec['icone'])){
                //   $rec['icone'] = 1;
                // }
                cadastroServicos($dados['servicos'][$keys]);
            }
            foreach($dados['imagem'] as $keys => $rec){
                $dados['imagem'][$keys]['idsolucoes'] = $idSolucoes;
                // if(empty($rec['icone'])){
                //   $rec['icone'] = 1;
                // }
                cadastroImagem($dados['imagem'][$keys]);
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'solucoes';
			$log['avaliacao'] = 'Cadastrou solucoes ID('.$idSolucoes.') titulo ('.$dados['titulo'].') descricao ('.$dados['descricao'].') urlamigavel ('.$dados['urlamigavel'].') title ('.$dados['title'].') description ('.$dados['description'].') keyword ('.$dados['keyword'].') imagem ('.$dados['thumbs'].') banner_topo ('.$dados['banner_topo'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('Solucoes criado com sucesso!'));
		} else {
			header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('ERRO ao criar novo Solucoes!'));
		}

		break;

	case EDIT_SOLUCOES:
		include_once 'solucoes_class.php';
		include_once "includes/fileImage.php";
		
		$dados = $_REQUEST;
		$imagens = $_FILES;

		$antigo = buscaSolucoes(array('idsolucoes'=>$dados['idsolucoes']));
		$antigo = $antigo[0];

        $arrayImg = "";
        if(!empty($imagens['imagem'])){
            foreach($imagens['imagem'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $arrayImg2 = "";
        if(!empty($imagens['recursos'])){
            foreach($imagens['recursos'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg2[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $arrayImg3 = "";
        if(!empty($imagens['servicos'])){
            foreach($imagens['servicos'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg3[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $idSolucoes = editSolucoes($dados);

      if(!empty($arrayImg)){
        foreach($arrayImg as $key => $imgsUpload){
            if(!empty($imgsUpload['tmp_name'])){
                apagarImagemImagem($dados['imagem'][$key]['imagem']);
                $nomeimagem[] = fileImage("imagem", "", "", $imgsUpload, 634, 415, 'resize');
                foreach($nomeimagem as $names){
                    $dados['imagem'][$key]['imagem'] = $names;
                }
            }
            elseif($dados['imagem'][$key]['idimagem'] != 0){
               $antigoRecurso = buscaImagem(array('idimagem'=>$dados['imagem'][$key]['idimagem'], 'idsolucoes' => $idSolucoes));
               $dados['imagem'][$key]['imagem'] = $antigoRecurso[0]['imagem'];
            }
        }
      }

      if(!empty($arrayImg2)){
        foreach($arrayImg2 as $key => $imgsUpload){
            if(!empty($imgsUpload['tmp_name'])){
                apagarImagemRecursos($dados['recursos'][$key]['imagem']);
                $nomeimagem2[] = fileImage("recursos", "", "", $imgsUpload, 30, 30, 'resize');
                foreach($nomeimagem2 as $names){
                    $dados['recursos'][$key]['imagem'] = $names;
                }
            }
            elseif($dados['recursos'][$key]['idrecursos'] != 0){
               $antigoRecurso = buscaRecursos(array('idrecursos'=>$dados['recursos'][$key]['idrecursos'], 'idsolucoes' => $idSolucoes));
               $dados['recursos'][$key]['imagem'] = $antigoRecurso[0]['imagem'];
            }
        }
      }

      if(!empty($arrayImg3)){
        foreach($arrayImg3 as $key => $imgsUpload){
            if(!empty($imgsUpload['tmp_name'])){
                apagarImagemServicos($dados['servicos'][$key]['imagem']);
                $nomeimagem2[] = fileImage("servicos", "", "", $imgsUpload, 30, 30, 'resize');
                foreach($nomeimagem2 as $names){
                    $dados['servicos'][$key]['imagem'] = $names;
                }
            }
            elseif($dados['servicos'][$key]['idservicos'] != 0){
               $antigoServicos = buscaServicos(array('idservicos'=>$dados['servicos'][$key]['idservicos'], 'idsolucoes' => $idSolucoes));
               $dados['servicos'][$key]['imagem'] = $antigoServicos[0]['imagem'];
            }
        }
      }

      if(!empty($dados['recursos'])){
         foreach($dados['recursos'] as $keys => $recursos){
            if($dados['recursos'][$keys]['idrecursos'] == 0 && $dados['recursos'][$keys]['excluirRecurso'] != 0){
               $dados['recursos'][$keys]['idsolucoes'] = $idSolucoes;
               cadastroRecursos($dados['recursos'][$keys]);
            }
            elseif($dados['recursos'][$keys]['excluirRecurso'] == 0){
               $antigoRecurso = buscaRecursos(array('idrecursos'=>$dados['recursos'][$keys]['idrecursos']));
               apagarImagemRecursos($antigoRecurso[0]['imagem']);
               deletaRecursos2($idSolucoes,$dados['recursos'][$keys]['idrecursos']);
            }
            else{
               $dados['recursos'][$keys]['idsolucoes'] = $idSolucoes;
               editRecursos($dados['recursos'][$keys]);
            }
         }
      }

      if(!empty($dados['servicos'])){
         foreach($dados['servicos'] as $keys => $servicos){
            if($dados['servicos'][$keys]['idservicos'] == 0 && $dados['servicos'][$keys]['excluirRecurso'] != 0){
               $dados['servicos'][$keys]['idsolucoes'] = $idSolucoes;
               cadastroServicos($dados['servicos'][$keys]);
            }
            elseif($dados['servicos'][$keys]['excluirRecurso'] == 0){
               $antigoRecurso = buscaServicos(array('idservicos'=>$dados['servicos'][$keys]['idservicos']));
               apagarImagemServicos($antigoRecurso[0]['imagem']);
               deletaServicos2($idSolucoes,$dados['servicos'][$keys]['idservicos']);
            }
            else{
               $dados['servicos'][$keys]['idsolucoes'] = $idSolucoes;
               editServicos($dados['servicos'][$keys]);
            }
         }
      }

      if(!empty($dados['imagem'])){
         foreach($dados['imagem'] as $keys => $imagem){
            if($dados['imagem'][$keys]['idimagem'] == 0 && $dados['imagem'][$keys]['excluirRecurso'] != 0){
               $dados['imagem'][$keys]['idsolucoes'] = $idSolucoes;
               cadastroImagem($dados['imagem'][$keys]);
            }
            elseif($dados['imagem'][$keys]['excluirRecurso'] == 0){
               $antigoRecurso = buscaImagem(array('idimagem'=>$dados['imagem'][$keys]['idimagem']));
               apagarImagemImagem($antigoRecurso[0]['imagem']);
               deletaImagem2($idSolucoes,$dados['imagem'][$keys]['idimagem']);
            }
            else{
               $dados['imagem'][$keys]['idsolucoes'] = $idSolucoes;
               editImagem($dados['imagem'][$keys]);
            }
         }
      }

      // die;

		if ($idSolucoes != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'solucoes';
			$log['avaliacao'] = 'Editou solucoes ID('.$idSolucoes.') DE titulo ('.$antigo['titulo'].') descricao ('.$antigo['descricao'].') urlamigavel ('.$antigo['urlamigavel'].') title ('.$antigo['title'].') description ('.$antigo['description'].') keyword ('.$antigo['keyword'].') imagem ('.$antigo['thumbs'].') banner_topo ('.$antigo['banner_topo'].') PARA titulo ('.$dados['titulo'].') resumo ('.$dados['resumo'].') descricao ('.$dados['descricao'].') urlamigavel ('.$dados['urlamigavel'].') title ('.$dados['title'].') description ('.$dados['description'].') keyword ('.$dados['keyword'].') imagem ('.$dados['thumbs'].') banner_topo ('.$dados['banner_topo'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('Solucoes salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('ERRO ao salvar Solucoes!'));
		}

		break;

	case DELETA_SOLUCOES:
		include_once 'solucoes_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('solucoes_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaSolucoes(array('idsolucoes'=>$dados['idu']));

			apagarImagemSolucoes($antigo[0]['thumbs']);
			apagarImagemSolucoes($antigo[0]['banner_topo']);

			$antigoRecursos = buscaRecursos(array('idsolucoes'=>$dados['idu']));

			foreach ($antigoRecursos as $key => $oldRec) {
				apagarImagemRecursos($oldRec['imagem']);
			}

			if (deletaSolucoes($dados['idu']) == 1) {
				deletaRecursos($dados['idu']);
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'solucoes';
				$log['avaliacao'] = 'Deletou solucoes ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('Solucoes deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=solucoes&acao=listarSolucoes&mensagemalerta='.urlencode('ERRO ao deletar Solucoes!'));
			}
		}

	break;

	case SALVA_IMAGEM:
		include_once('solucoes_class.php');
		include_once 'includes/fileImage.php';

		$dados = $_POST;
        $idsolucoes = $dados['idsolucoes'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_banner = $dados['tipo'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($idsolucoes) &&  $idsolucoes > 0){
            $antigo = buscaSolucoes(array('idsolucoes'=>$idsolucoes));
			$antigo = $antigo[0];
        }    
        
        //dados para o crop
        if($tipo_banner == 'thumbs'){
            //banner thumb
            $width = 300;
            $height = 374;
        }
        else if($tipo_banner == 'banner_topo'){
            //banner topo
            $width = 1920;
            $height = 523;
        }
       	
        //imagem 
        $nomeimagem = fileImage("solucoes", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        if($tipo_banner == 'thumbs'){
         $nomeimage = fileImage("solucoes", $nomeimagem, "thumbs2", $imagem['imagem'], 315, 215, 'crop');
        }
        // $nomeimagem = fileImage("solucoes", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
	     
        $caminho = 'files/solucoes/'.$nomeimagem;

        if(file_exists($caminho)){
        	//apaga os arquivos anteriores que foram salvos
        	if(!empty($imgAntigo)){
        		$apgImage = apagarImagemSolucoes($imgAntigo); 
        	}
		 	 
			if(is_numeric($idsolucoes) && $idsolucoes > 0){
				//edita o nome do banner, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$solucoes = $antigo; 
				$solucoes[$tipo_banner] = $nomeimagem;
				$edita = editSolucoes($solucoes);
			} 
            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_banner.'", "idsolucoes":"'.$idsolucoes.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_banner.'", "idsolucoes":"'.$idsolucoes.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }
	break;

	case INVERTE_STATUS:
		include_once("solucoes_class.php");
		include_once("includes/functions.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';

		$tabela = 'solucoes';
		$id = 'idsolucoes';

		try {
			$solucoes = buscaSolucoes(array('idsolucoes' => $dados['idsolucoes']));
			$solucoes = $solucoes[0];

			// print_r($depoimento);
			if($solucoes['status'] == 1){
				$status = 0;
			}
			else{
				$status = 1;
			}

			$dadosUpdate = array();
			$dadosUpdate['idsolucoes'] = $dados['idsolucoes'];
			$dadosUpdate['status'] = $status;
			inverteStatus($dadosUpdate,$tabela,$id);

			print json_encode($resultado);
		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case VERIFICAR_URLREWRITE:

		include_once('solucoes_class.php'); 
		include_once('includes/functions.php');
		
		$dados = $_POST;
		 
		$urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $dados['urlrewrite'])));
 		
 		if($dados['idsolucoes'] && $dados['idsolucoes'] <= 0){
 			$url = buscaSolucoes(array("urlamigavel"=>$urlrewrite)); 	
 		}else{ 
 			$url = buscaSolucoes(array("urlamigavel"=>$urlrewrite,"not_idsolucoes"=>$dados['idsolucoes'])); 
 		} 

 		if(empty($url)){ 
 			print '{"status":true,"url":"'.$urlrewrite.'"}';
 		}else{
 			print '{"status":false}';
 		} 

	break;

   //SALVA IMAGENS DA GALERIA 
   case SALVA_GALERIA:
        include_once ('solucoes_class.php');
            include_once 'includes/fileImage.php';
            
            $dados = $_POST;
        $idsolucoes = $dados['idsolucoes'];
        $posicao = $dados['posicao']; 

        $imagem = $_FILES;
        
        $caminhopasta = "files/solucoes/galeria";
        if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
        }  
       
        //galeria grande
         $nomeimagem = fileImage("solucoes/galeria", "", "", $imagem['imagem'], 326, 247, 'inside');  
         $thumb = fileImage("solucoes/galeria", $nomeimagem, "thumb", $imagem['imagem'], 100, 100, 'crop'); 
       
        $caminho = $caminhopasta.'/thumb_'.$nomeimagem;

        //vai cadastrar se já tiver o id do servicos, senao so fica na pasta.
        $idsolucoes_imagem = $nomeimagem; 

        if(is_numeric($idsolucoes)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['idsolucoes'] = $idsolucoes;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $idsolucoes_imagem = salvaImagemSolucoes($imagem);  
        } 
       
        print '{"status":true, "caminho":"'.$caminho.'", "idsolucoes":"'.$idsolucoes.'", "idsolucoes_imagem":"'.$idsolucoes_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
   break; 
 
   case SALVAR_DESCRICAO_IMAGEM:
      include_once('solucoes_class.php');
      $dados = $_POST;

      $imagem = buscaSolucoes_imagem(array("idsolucoes_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editSolucoes_imagem($imagem)){
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
      include_once('solucoes_class.php');

      $dados = $_POST;  
      $idsolucoes = $dados['idsolucoes'];
      $idsolucoes_imagem = $dados['idsolucoes_imagem'];
      $imagem = $dados['imagem']; 
 
      if(is_numeric($idsolucoes) && $idsolucoes > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemSolucoesGaleria($idsolucoes_imagem, $idsolucoes);
         $retorno['status'] = apagarImagemSolucoesGaleria($imagem);
      }else{
         //apagar somente a imagem da pastar
         $retorno['status'] = apagarImagemSolucoesGaleria($imagem);
      }  
      print json_encode($retorno);   
   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:
      include_once('solucoes_class.php');
      $dados = $_POST;  
      alterarPosicaoImagemSolucoes($dados);
      print '{"status":true}';
   break;

   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('solucoes_class.php');
      $dados = $_POST;  
      
      if(isset($dados['imagem_solucoes'])){
         $imgs = $dados['imagem_solucoes'];
         foreach ($imgs as $key => $value) { 
            apagarImagemSolucoes($value);
         }
      } 
      print '{"status":true}'; 
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