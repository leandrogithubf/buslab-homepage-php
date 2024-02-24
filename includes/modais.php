<div class="modal-overlay">
	<!--########################################
		MODAL [SOLUÇÕES]{HARDWARE/SOFTWARE}
	########################################-->
	<!-- MODAL HARDWARE -->
   <?php if(!empty($solucoes)):?>
      <?php foreach($solucoes as $key => $s):?>
      	<div class="modal lg pure-g modal-solutions" data-modal="solutions-<?=$s['urlamigavel']?>" id="m-1-<?=$s['urlamigavel']?>">
      		<a href="javascript:void(0)" class="close prevent-default" data-modal='close'></a>
      		<div class="modal-container pure-u-2-5 pure-u-sm-2-5 pure-u-md-2-5 pure-u-lg-2-5 pure-u-xl-2-5">
      			<img class="box-mode m-0 bd-rds-10" src="<?=ENDERECO?>admin/files/solucoes/thumbs2_<?=$s['thumbs']?>" width="315" height="215" alt="<?=$s['titulo']?>">

      			<ul class="list-checked-circle">
                  <?php foreach($s['diferenciais'] as $key => $diferenciais):?>
                     <?php foreach($diferenciais['icone'] as $key => $icone):?>
                        <?php if(empty($diferenciais['imagem'])):?>
                           <li><i class="fa fa-<?=$icone['nome']?> fa-1x"></i>&nbsp;&nbsp;<?=$diferenciais['nome']?></li>
                        <?php else:?>
                           <li><img class="solucoes-modais-diferenciais" alt="imagem" width="18" src="<?=ENDERECO?>admin/files/recursos/<?=$diferenciais['imagem']?>">&nbsp;&nbsp;<?=$diferenciais['nome']?></li>
                        <?php endif;?>
                     <?php endforeach;?>
                  <?php endforeach;?>
      			</ul>
      		</div>
      		<div class="modal-container pure-u-3-5 pure-u-sm-3-5 pure-u-md-3-5 pure-u-lg-3-5 pure-u-xl-3-5">
      			<h2 class="subtitle box-mode m-b-md"><?=$s['titulo']?></h2>
      			<div class="modal-content sm overflow mCustomScrollbar" data-mcs-axis="y">
      				<p class="paragraph">
      					<?=$s['resumo']?>
      				</p>		
      			</div>	
      			<div class="flex-container flex-direction-row flex-wrap flex-justify-space-evenly">
                  <?php foreach($s['servicos'] as $key => $servicos):?>
         				<div class="card mini shadow box-mode m-b-2">
                        <?php if(empty($servicos['imagem'])):?>
                           <?php foreach($servicos['icone'] as $key => $icone):?>
               					<div class="card-header-icon">
               						<i class="fa fa-<?=$icone['nome']?> fa-1x icon icon-thin-advantage" role="icon"></i>
               					</div>
                           <?php endforeach;?>
                        <?php else:?>
                           <div class="card-header-icon">
                              <img width="18" class="solucoes-interna-servicos" alt="imagem" src="<?=ENDERECO?>admin/files/servicos/<?=$servicos['imagem']?>">
                           </div>
                        <?php endif;?>
         					<div class="card-body">
         						<p class="paragraph"><?=$servicos['nome']?></p>
         					</div>
         				</div>
                  <?php endforeach;?>
      			</div>
      			<a href="<?=ENDERECO_IDIOMA?>solucoes/<?=$s['urlamigavel']?>" class="btn primary"><?=$solucoes_conhecer_solucao_completa?></a>
      		</div>
      	</div>
      <?php endforeach;?>
   <?php endif;?>

	<!-- MODAL AGENDE UMA CONVERSA -->
	<div class="modal md pure-g" data-modal="schedule-conversation" id="m-3">
		<a href="javascrip:void(0)" class="close prevent-default" data-modal='close'></a>
		<div class="modal-container image pure-u-1 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-1-2 pure-u-xl-1-2">
			<img src="/images/business-team.webp" alt="business">
		</div>
		<div class="modal-container pure-u-1 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-1-2 pure-u-xl-1-2 box-mode">
			<h2 class="subtitle box-mode m-b-md"><?=$solucoes_agende_uma_conversa_agora?></h2>

			<form id="form-contato" class="flex-container flex-direction-column flex-nowrap flex-center">
				<input class="form-input width-100 bg-gray-100 box-mode m-b-md required" name="nome" type="text" placeholder="<?=$blog_nome?>">
				<input class="form-input width-100 bg-gray-100 box-mode m-b-md required telefone" name="telefone" type="tel" placeholder="<?=$solucoes_telefone?>">
				<input class="form-input width-100 bg-gray-100 box-mode m-b-md required" name="email" type="email" placeholder="<?=$blog_email?>">
				<input class="form-input width-100 bg-gray-100 box-mode m-b-md required" name="empresa" type="text" placeholder="<?=$solucoes_empresa?>">
            <input name="ididiomas" value="<?=$_SESSION['IDIDIOMA']?>" type="hidden">
				<button id="enviar-contato" type="submit" class="btn primary"><?=$solucoes_solicitar_contato_agora?></button>
			</form>
		</div>
	</div>
</div><!-- end modal-overlay -->