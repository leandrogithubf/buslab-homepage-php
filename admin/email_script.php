<?php @session_start();
	
	$opx = $_REQUEST["opx"];
	
   $destinatario = 'contato@buslab.com.br';

	switch ($opx) {
      case 'newsletter':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'newsletter_class.php';
         
         $dados = $_POST;

         $idcontato = cadastroNewsletter($dados);

         $texto = '<p>Solicitou receber novidades </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>Email: '.strtolower($dados['email']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'footer':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'newsletter_class.php';
         
         $dados = $_POST;

         $idcontato = cadastroNewsletter($dados);

         $texto = '<p>Solicitou receber novidades </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>Email: '.strtolower($dados['email']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'newsletter-footer':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'newsletter_class.php';
         
         $dados = $_POST;

         $dados['nome'] = 'Newsletter';

         $idcontato = cadastroNewsletter($dados);

         $texto = '<p>Solicitou receber novidades </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>Email: '.strtolower($dados['email']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'contato':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'contatos_class.php';
         
         $dados = $_POST;

         $dados['assunto'] = "Agendar uma conversa";
         $dados['mensagem'] = "";

         $idcontato = cadastroContatos($dados);

         $texto = '<p>'.$dados['assunto'].' </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
         $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
         $texto .= '<p>Empresa: '.strtolower($dados['empresa']).'</p>';
         // $texto .= '<p>Mensagem:</p>';
         // $texto .= '<p>'.nl2br($dados['mensagem']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'cases':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'contatos_class.php';
         
         $dados = $_POST;

         $dados['assunto'] = "Agendar uma conversa";
         $dados['mensagem'] = "";

         $idcontato = cadastroContatos($dados);

         $texto = '<p>'.$dados['assunto'].' </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
         $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
         $texto .= '<p>Empresa: '.strtolower($dados['empresa']).'</p>';
         // $texto .= '<p>Mensagem:</p>';
         // $texto .= '<p>'.nl2br($dados['mensagem']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'comercial':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'contatos_class.php';
         
         $dados = $_POST;

         $dados['assunto'] = "Contato comercial";
         $dados['mensagem'] = "";

         $idcontato = cadastroContatos($dados);

         $texto = '<p>'.$dados['assunto'].' </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
         $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
         $texto .= '<p>Empresa: '.strtolower($dados['empresa']).'</p>';
         // $texto .= '<p>Mensagem:</p>';
         // $texto .= '<p>'.nl2br($dados['mensagem']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'cliente':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'contatos_class.php';
         
         $dados = $_POST;

         $dados['assunto'] = "Já sou cliente";

         $idcontato = cadastroContatos($dados);

         $texto = '<p>'.$dados['assunto'].' </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
         $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
         $texto .= '<p>Empresa: '.strtolower($dados['empresa']).'</p>';
         $texto .= '<p>Mensagem:</p>';
         $texto .= '<p>'.nl2br($dados['mensagem']).'</p>';
         
         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/
         
          $email = array();
                  
          $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
          $email['email_remetente'] = strtolower($dados['email']);      
         
          $email['destinatario'] = array(
            'Buslab' => $destinatario
           );
         
          $email['assunto'] = 'E-mail vindo do site';
         
          $email['texto'] = $texto;    
         
          if(enviaEmail($email)){
            echo '{"status" : true}';
          }else{
            echo '{"status" : false}';
          }
      break;

      case 'trabalhe-conosco':
         include_once 'includes/functions.php';
         include_once 'mail/class.phpmailer.php';
         include_once 'contatos_class.php';
         include_once 'area_pretendida_class.php';
         
         $dados = $_POST;

         $texto = '<p>Trabalhe conosco </p>';
         $texto .= '<p>Nome: '.ucwords(strtolower($dados['nome'])).'</p>';
         $texto .= '<p>E-mail: '.strtolower($dados['email']).'</p>';
         $texto .= '<p>Telefone: '.strtolower($dados['telefone']).'</p>';
         $texto .= '<p>Baixar Curriculum: '.strtolower($link).'</p>';

         /*******************************************************
         ****         Script de Envio de Email        ****
         ********************************************************/

         $email = array(); 

         $email['nome_remetente'] = ucwords(strtolower($dados['nome']));
         $email['email_remetente'] = strtolower($dados['email']);    

         $email['destinatario'] = array('Buslab' => $destinatario);

         $email['assunto'] = 'E-mail vindo do site';

         $email['texto'] = $texto;

         if(enviaEmail($email)){
            echo '{"status" : true}';
         }else{
            echo '{"status" : false}'; 
         }
      break;
	}
	
?>

