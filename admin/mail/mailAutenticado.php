<?php
require("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); //ENVIAR VIA SMTP
$mail->Host = "mail.rcenter.com.br"; //SERVIDOR DE SMTP, USE smtp.SeuDominio.com OU smtp.hostsys.com.br
$mail->SMTPAuth = true; //ATIVA O /SMTP AUTENTICADO
$mail->Username = "suporte@rcenter.com.br"; //EMAIL PARA SMTP AUTENTICADO (pode ser qualquer conta de email do seu domínio)
$mail->Password = "logx10"; //SENHA DO EMAIL PARA SMTP AUTENTICADO
$mail->From = "suporte@rcenter.com.br"; //E-MAIL DO REMETENTE
$mail->FromName = "Suporte Rcenter"; //NOME DO REMETENTE
$mail->AddAddress("rmengue211251@gmail.com","Rodrigo Mengue"); //E-MAIL DO DESINATÁRIO, NOME DO DESINATÁRIO
//$mail->AddReplyTo("suporte@hostsys.com.br"," Suporte Hostsys "); //UTILIZE PARA DEFINIR OUTRO EMAIL DE RESPOSTA (opcional)
$mail->WordWrap = 50; // ATIVAR QUEBRA DE LINHA
$mail->IsHTML(true); //ATIVA MENSAGEM NO FORMATO HTML
$mail->Subject = utf8_decode("Reunião"); //ASSUNTO DA MENSAGEM
$mail->Body = "<H1>Teste de envio via PHP</H1>"; //MENSAGEM NO FORMATO HTML
$mail->AltBody = "Teste de envio via PHP"; //MENSAGEM NO FORMATO TXT
if(!$mail->Send())
{
echo "A mensagem não pode ser enviada
";
echo "Erro: " . $mail->ErrorInfo;
exit;
}
echo "Mensagem enviada com sucesso!";
?>
