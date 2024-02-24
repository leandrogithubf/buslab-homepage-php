<?php
// Versao do modulo: 3.00.010416

include_once "depoimento_class.php";
include_once "idiomas_class.php";

    $idiomas = buscaIdiomas(array('status'=>'1'));
if (!isset($_REQUEST['acao']))
   $_REQUEST['acao'] = "";
?>
<link rel="stylesheet" type="text/css" href="depoimento_css.css" />
<script type="text/javascript" src="depoimento_js.js"></script>
<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
                        *******************************-->
<?php if ($_REQUEST['acao'] == "formDepoimento") {
   if ($_REQUEST['met'] == "cadastroDepoimento") {
      if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
         header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
         exit;
      }
      $action = "depoimento_script.php?opx=cadastroDepoimento";
      $metodo_titulo = "Cadastro Depoimento";
      $idDepoimento = 0;

      // dados para os campos
      $depoimento['nome'] = "";
      $depoimento['depoimento'] = "";
      $depoimento['imagem'] = "";
      $depoimento['status'] = "";
      $depoimento['ididiomas'] = "";
      $depoimento['cargo'] = "";
      $depoimento['logo'] = "";

   } else {
      if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
         header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
         exit;
      }
      $action = "depoimento_script.php?opx=editDepoimento";
      $metodo_titulo = "Editar Depoimento";
      $idDepoimento = (int) $_GET['idu'];
      $depoimento = buscaDepoimento(array('iddepoimento' => $idDepoimento));
      if (count($depoimento) != 1) exit;
      $depoimento = $depoimento[0];
   }
?>

   <div id="titulo">
      <!-- <img src="images/modulos/depoimento_preto.png" height="24" width="24" alt="ico" /> -->
      <i class="fa fa-plus fa-2x"></i>
      <span><?php print $metodo_titulo; ?></span>
      <ul class="other_abs">
         <li class="other_abs_li"><a href="index.php?mod=depoimento&acao=listarDepoimento">Listagem</a></li>
         <li class="others_abs_br"></li>
         <li class="other_abs_li"><a href="index.php?mod=depoimento&acao=formDepoimento&met=cadastroDepoimento">Cadastro</a></li>
      </ul>
   </div>

   <!-- CSS PARA O CROPPER-->
   <link href="css/cropper-depoimento.css" rel="stylesheet">
   <link href="css/main.css" rel="stylesheet">
   <link href="css/bootstrap.min.css" rel="stylesheet">

   <div id="principal">
      <form class="form" name="formDepoimento" id="formDepoimento" enctype="multipart/form-data" method="post" action="<?php echo $action; ?>">
         <div id="informacaoDepoimento" class="content">
            <div class="content_tit">Dados Depoimento:</div>
            <div class="box_ip">
               <label style="font-family: unset;" for="nome">Nome</label>
               <input type="text" name="nome" id="nome" size="30" value="<?php echo $depoimento['nome']; ?>" class="required"/>
            </div>
            <div class="box_ip">
               <label style="font-family: unset;" for="cargo">Cargo</label>
               <input type="text" name="cargo" id="cargo" size="30" value="<?php echo $depoimento['cargo']; ?>" class="required"/>
            </div>
            <div class="box_ip" style='width:30%;'>
               <label style="font-family: unset;" for="status">Status</label>
               <div class="box_sel" style='width:100%;margin-left:0;'>
                  <label style="font-family: unset;" for="status">Status</label>
                  <div class="box_sel_d" style='width:99%;'>
                     <select name="status" id="status" class='required'>
                     <!-- <option></option> -->
                        <option value="1" <?php print ($depoimento['status'] == "1" ? ' selected="selected" ' : ''); ?> > Ativo </option>
                        <option value="0" <?php print ($depoimento['status'] == "0" ? ' selected="selected" ' : ''); ?> > Inativo </option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="box_ip" style='width:30%;'>
                 <label  for="ididiomas">Idioma</label>
                 <div class="box_sel" style='width:100%;margin-left:0;'>
                     <label for="">Idioma</label>
                     <div class="box_sel_d" style='width:99%;'>
                         <select name="ididiomas" id="ididiomas" class='required'>
                             <?php foreach($idiomas as $key => $idioma):?>
                                 <option value="<?=$idioma['ididiomas']?>" <?php print ($depoimento['ididiomas'] == $idioma['ididiomas'] ? ' selected="selected" ' : ''); ?> > <?=$idioma['idioma']?> </option>
                             <?php endforeach;?>
                         </select>
                     </div>
                </div>
             </div>
            <div class="box_ip box_txt">
               <font style='font-weight:bold'>Depoimento</font><br>
               <textarea class="required" name="depoimento" id="depoimento" cols="34" rows="4"><?php echo $depoimento['depoimento'];?></textarea>
            </div>
            <?php $caminho = 'files/depoimento/'; ?>
            <div class="box_ip imagem separar" style="width:100%;padding-left:0;">
               <div class="box_ip separa" style="width:100%;">
                  <div class="img_pricipal">
                     <div>
                        <div class="content_tit">Imagem</div>
                        <?php if ($depoimento['imagem'] != '') { ?>
                           <div class="box_ip">
                              <img src="<?=$caminho.$depoimento['imagem'];?>" class="img-depoimento-form" alt="Imagem atual"/>
                           </div>
                        <?php } ?>
                     </div>
                  </div>
                  <div class="box-img-crop">
                     <input type="hidden" value="" name="coordenadas" id="coordenadas" />
                     <div class="docs-buttons">
                        <div class="btn-group" style="width: 100%;">
                           <!--input FILE -->
                           <input id="inputImage" class="<?=empty($depoimento['imagem'])?'required':''?>" name="imagemCadastrar" type="file"/>
                           <br />
                           <p class="pre">Tamanho recomendado: 110x110 (ou maior proporcional) - Extensão recomendada: png</p>
                           <span>O arquivo não pode ser maior que:
                              <?php
                              $tamanho = explode('M', ini_get('upload_max_filesize'));
                              $tamanho = $tamanho[0];
                              echo $tamanho . 'MB';
                              ?>
                           </span>
                           <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                        </div>
                     </div><!-- /.docs-buttons -->
                     <div class="img-container" id="img-container" style="display:none;">
                        <img alt="">
                     </div>
                     <!-- Show the cropped image in modal -->
                     <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                              </div>
                              <div class="modal-body"></div>
                           </div>
                        </div>
                     </div><!-- /.modal -->
                  </div>
               </div>
            </div>

            <div class="box_ip imagem" style="width: 100%;">
               <div class="content_tit" style="margin-left:0px;">Logo</div>
               <?php
                   $caminho = '';
                   if($depoimento['logo'] !='' ){
                           $caminho = 'files/depoimento/'.$depoimento['logo'];
                   }
               ?>
               <img src="<?php echo $caminho;?>" class="imagem_logo" width="150" <?php echo ($_REQUEST['met']=='cadastroBanner') ? 'style="display:none;"' : 'style="margin: 15px"' ;?> />
               <?php if(empty($depoimento['logo'])):?>
                  <input type="file" id="logo" class=" img" name="logo" tipo="logo" value="<?php echo $depoimento['logo'] ?>"/>
               <?php else:?>
                  <input type="file" id="logo" class="img" name="logo" tipo="logo" value="<?php echo $depoimento['logo'] ?>"/>
               <?php endif;?>
               <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>151x35</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
               <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                   <?php
                       $tamanho = explode('M', ini_get('upload_max_filesize'));
                       $tamanho = $tamanho[0];
                       echo $tamanho.'MB';
                   ?>
               </span>
           </div>
         </div>

         <input type="hidden" name="imagem" value="<?php echo $depoimento['imagem']; ?>" />
         <input type="hidden" id="logo_old" name="logo" value="<?= $depoimento['logo'] ?>"/>
         <input type="hidden" name="iddepoimento" id="iddepoimento" value="<?php echo $idDepoimento; ?>" />
         <input type="submit" value="Salvar" class="bt_save salvar" />
         <input type="button" value="Cancelar" onclick="history.go(-1);" class="bt_cancel cancelar" />
         <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='150'>
         <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='150'>
      </form>
   </div>

   <!-- Scripts PARA O CROPPER-->
   <script src="js/bootstrap.min.js"></script>
   <script src="js/cropper.js"></script>
   <script src="js/main.js"></script>

<?php } ?>



<!--************************************
     _       _        _        _     _
    | |     | |      | |      | |   | |
  __| | __ _| |_ __ _| |_ __ _| |__ | | ___
 / _` |/ _` | __/ _` | __/ _` | '_ \| |/ _ \
| (_| | (_| | || (_| | || (_| | |_) | |  __/
 \__,_|\__,_|\__\__,_|\__\__,_|_.__/|_|\___|
               *******************************-->


<?php if ($_REQUEST['acao'] == "listarDepoimento") { ?>
   <?php
      if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
         header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
   ?>
   <div id="titulo">
      <!-- <img src="images/modulos/depoimento_preto.png" height="22" width="24" alt="ico" /> -->
      <i class="fa fa-comment fa-2x"></i>
      <span>Listagem de Depoimento</span>
      <ul class="other_abs">
         <li class="other_abs_li"><a href="index.php?mod=depoimento&acao=listarDepoimento">Listagem</a></li>
         <li class="others_abs_br"></li>
         <li class="other_abs_li"><a href="index.php?mod=depoimento&acao=formDepoimento&met=cadastroDepoimento">Cadastro</a></li>
      </ul>
   </div>
   <div class="search">
      <form name="formbusca" method="post" action="#" onsubmit="return false">
         <input type="text" name="buscarapida" value="Buscar" onblur="campoBuscaEscreve(this);" onfocus="campoBuscaLimpa(this);" id="buscarapida" />
      </form>
      <a href="" class="search_bt">Busca Avançada</a>
   </div>
   <div class="advanced">
      <form name="formAvancado" id="formAvancado" method="post" action="#" onsubmit="return false">
         <p class="advanced_tit">Busca Avançada</p>
         <img class="advanced_close" src="images/ico_close.png" height="10" width="11" alt="ico" />
         <div class="box_ip"><label for="adv_nome">Nome</label><input type="text" name="nome" id="adv_nome"></div>
         <a href="" class="advanced_bt" id="filtrar">Filtrar</a>
      </form>
   </div>

   <div id="principal">
      <div id="abas">
         <ul class="abas_list">
            <li class="abas_list_li action"><a href="javascript:void(0)">Depoimento</a></li>
         </ul>
         <ul class="abas_bts">
            <li class="abas_bts_li"><a href="index.php?mod=depoimento&acao=formDepoimento&met=cadastroDepoimento"><img src="images/novo.png" alt="Cadastro Depoimento" title="Cadastrar Depoimento" /></a></li>
            <li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=depoimento&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
            <li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=depoimento&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
         </ul>
      </div>
      <table class="table" cellspacing="0" cellpadding="0" id="listagem">
         <thead>
         </thead>
         <tbody>
         </tbody>
      </table>
      <?php include_once("paginacao/paginacao.php"); ?>

      <?php
         $dados = isset($_POST) ? $_POST : array();
         $buscar = '';
         foreach ($dados as $k => $v) {
            if (!empty($v))
               $buscar .= $k . '=' . $v . '&';
         }
      ?>
      <script type="text/javascript">
         queryDataTable = '<?php print $buscar; ?>';
         requestInicio = "tipoMod=depoimento&p=" + preventCache + "&";
         ordem = "iddepoimento";
         dir = "asc";
         $(document).ready(function() {
            preTableDepoimento();
         });
         dataTableDepoimento('<?php print $buscar; ?>');
         columnDepoimento();
      </script>
   </div>
<?php } ?>