<main>
<!--####################
      BANNER PAGE
  ####################-->
  <div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-lg">
    <div class="layout-max-width overflow-v">
      <div class="page-banner-title-wrapper left ghost">
        <h1 class="title primary left">Cases</h1>
      </div>      
    </div>
    <img src="/images/page-banner-buslab.webp" alt="banner" aria-hidden="true">
  </div>

  <!--##########################################
      SECTION: FAÇA COMO AS GRANDES EMPRESAS
  ##########################################-->
  <section id="cases-s01" class="page-stripe pure-g">
    <div class="layout-max-width">
      <h1 class="title text left bottom-line">Faça como as<br>grandes empresas<br><span class="paragraph gray-400 text bold box-mode m-t-sm">E seja também um case da BusLab</span></h1>

      <?php if(!empty($clientes)):?>
         <div class="slider-company-partners pure-u-1 box-mode m-t-lg">
           <div class="slider-container">
             <?php foreach ($clientes as $key => $c):?>
               <div><img class="slider-company-partners-logo" src="<?=ENDERECO?>admin/files/clientes/<?=$c['logo']?>" width="167" alt="<?=$c['nome']?>"></div>
             <?php endforeach;?>  
           </div> 
           <div class="slider-company-partners-nav box-mode m-t-md m-b-lg"></div>
         </div>
      <?php endif;?>
    </div>
  </section>

  <!--##############################
      SECTION: ONDE ATENDEMOS
  ##############################-->
  <section id="cases-s02" class="page-stripe pure-g">
    <div class="layout-max-width">
      <h1 class="title text center box-mode m-t-lg m-b-lg">Onde atendemos?</h1>
      <div class="flex-container flex-direction-row flex-wrap box-mode m-b-lg" data-feature="change-content-nav">
         <?php foreach($atuacao as $key => $a):?>
           <div class="image color-filter base-color box-mode bd-rds-sm m-r-md m-b-md" data-feature="button" data-feature-id="<?=$key?>" data-active="<?=$key == 0?'on':'off'?>">
             <span class="text bold medium white pos-abs middle"><?=$a['nome']?></span>          
             <img src="<?=ENDERECO?>admin/files/atuacao/<?=$a['imagem']?>" class="image fit" width="209" height="209" alt="<?=$a['nome']?>">
           </div>
         <?php endforeach;?>

        <div class="control-pointer"></div>        
      </div>

      <div class="pure-u-1 box-mode p-md p-t-lg border thin solid gray-200 bd-rds-sm" data-feature="change-content-container">
         <?php foreach($atuacao as $key => $a):?>
           <?php $clientes = buscaClientes(array('atuacoes'=>$a['idatuacao']));?>
           <?php $features = buscaFeatures(array('idatuacao'=>$a['idatuacao']));?>
           <div data-feature="change-content" data-feature-id="<?=$key?>" data-active="<?=$key == 0?'on':'off'?>">
             <div class="flex-container flex-direction-row flex-wrap flex-center box-mode m-b-md--double">
               <?php if(!empty($clientes)):?>
                  <?php foreach ($clientes as $key => $c):?>
                     <img class="slider-company-partners-logo box-mode m-t-md" src="<?=ENDERECO?>admin/files/clientes/<?=$c['logo']?>" width="167" alt="<?=$c['nome']?>">
                  <?php endforeach;?>
               <?php endif;?>
             </div>
             <p class="paragraph box-mode m-b-md--double">
               <?=$a['texto']?>
             </p>
             <div class="flex-container flex-direction-row flex-wrap flex-justify-space-around">
               <?php if(!empty($features)):?>
                  <?php foreach ($features as $key => $c):?>
                     <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
                       <p class="counter-animate flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle"><?=$c['numero']?></p>
                       <p class="paragraph text bold gray-400"><?=$c['titulo']?></p>
                     </div>
                  <?php endforeach;?>
               <?php endif;?>
             </div>
           </div>
         <?php endforeach;?>
        <!-- <div data-feature="change-content" data-feature-id="1" data-active="off">
          <div class="flex-container flex-direction-row flex-wrap flex-center box-mode m-b-md--double">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
          </div>
          <p class="paragraph box-mode m-b-md--double">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias, similique labore vitae temporibus voluptates, repellendus minima maiores dignissimos rerum ipsa saepe aliquid adipisci, aspernatur laudantium vero magnam at. Nihil explicabo esse adipisci expedita corrupti dicta atque dolorum quisquam, soluta veniam porro odit sapiente dignissimos obcaecati vel eius, mollitia sint magni!
          </p>
          <div class="flex-container flex-direction-row flex-wrap flex-justify-space-around">
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">200</p>
              <p class="paragraph text bold gray-400">Colaboradores</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">100</p>
              <p class="paragraph text bold gray-400">Projetos implementados</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Lorem ipsum</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Lorem ipsum</p>
            </div>
          </div>
        </div>

        <div data-feature="change-content" data-feature-id="2" data-active="off">
          <div class="flex-container flex-direction-row flex-wrap flex-center box-mode m-b-md--double">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
          </div>
          <p class="paragraph box-mode m-b-md--double">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias, similique labore vitae temporibus voluptates, repellendus minima maiores dignissimos rerum ipsa saepe aliquid adipisci, aspernatur laudantium vero magnam at. Nihil explicabo esse adipisci expedita corrupti dicta atque dolorum quisquam, soluta veniam porro odit sapiente dignissimos obcaecati vel eius, mollitia sint magni!
          </p>
          <div class="flex-container flex-direction-row flex-wrap flex-justify-space-around">
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">405</p>
              <p class="paragraph text bold gray-400">Colaboradores</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">150</p>
              <p class="paragraph text bold gray-400">Projetos implementados</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Lorem ipsum</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Lorem ipsum</p>
            </div>
          </div>
        </div>

        <div data-feature="change-content" data-feature-id="3" data-active="on">
          <div class="flex-container flex-direction-row flex-wrap flex-center box-mode m-b-md--double">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
            <img class="slider-company-partners-logo box-mode m-t-md" src="/images/logo-ipsum.svg" width="167" alt="nome da empresa 1">
          </div>
          <p class="paragraph box-mode m-b-md--double">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestias, similique labore vitae temporibus voluptates, repellendus minima maiores dignissimos rerum ipsa saepe aliquid adipisci, aspernatur laudantium vero magnam at. Nihil explicabo esse adipisci expedita corrupti dicta atque dolorum quisquam, soluta veniam porro odit sapiente dignissimos obcaecati vel eius, mollitia sint magni!
          </p>
          <div class="flex-container flex-direction-row flex-wrap flex-justify-space-around">
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Colaboradores</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">10</p>
              <p class="paragraph text bold gray-400">Projetos implementados</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Lorem ipsum</p>
            </div>
            <div class="big-numbers text center pure-u-1 pure-u-sm-1 pure-u-md-1-4 pure-u-lg-1-4 pure-u-xl-1-4">
              <p class="flex-container flex-center text bold large base-color box-mode m-0 m-b-md p-md border thin solid gray-200 circle">45</p>
              <p class="paragraph text bold gray-400">Lorem ipsum</p>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </section>

  <!--##########################
      SECTION: DEPOIMENTOS
  ##########################-->
  <?php if(!empty($depoimento)):?>
     <section id="cases-s03" class="bg-gray-100 page-stripe pure-g box-mode m-t-lg">
       <div class="layout-max-width">
         <h1 class="title bottom-line text right box-mode m-b-lg">Depoimentos</h1>
         <div class="testemonials">
           <div class="testemonials-container">
            <?php foreach($depoimento as $key => $d):?>
             <div class="testemonials-slide">
               <div class="pure-u-1 pure-u-sm-1-1 pure-u-md-6-24 pure-u-lg-6-24 pure-u-xl-6-24">
                 <img src="<?=ENDERECO?>admin/files/depoimento/<?=$d['imagem']?>" alt="foto do cliente" class="image cover center box-mode circle display blk layout-center" aria-hidden="true" width="110" height="110">
                 <p class="base-color bold text center box-mode m-b-sm"><?=$d['nome']?></p>
                 <p class="paragraph text center gray-400"><?=$d['cargo']?></p>
               </div>
               <div class="pure-u-1 pure-u-sm-1-1 pure-u-md-18-24 pure-u-lg-18-24 pure-u-xl-18-24">
                 <img src="<?=ENDERECO?>admin/files/depoimento/<?=$d['logo']?>" width="151" alt="logo empresa" class="box-mode m-b-md display blk" aria-hidden="true">
                 <p class="paragraph gray-400"><?=$d['depoimento']?></p>
               </div>
             </div>
            <?php endforeach;?>
           </div>
           <div class="testemonials-nav pure-u-1 flex-container flex-direction-row flex-nowrap flex-center">
             <a href="javascript:void(0)" id="testemonials-nav-prev" class="btn-circle sm arrow-circle-fill display in-blk box-mode m-r-sm left"></a>
             <a href="javascript:void(0)" id="testemonials-nav-next" class="btn-circle sm arrow-circle-fill display in-blk box-mode m-r-sm"></a>
           </div>
         </div>
       </div>
     </section>
  <?php endif;?>

  <!--#################################
      SECTION: AGENDE UMA CONVERSA
  #################################-->
  <section id="cases-s04" class="page-stripe pure-g box-mode p-0">
    <div class="layout-max-width">
      <div class="bg-gray-100 box-mode p-md--double pure-u-1 pure-u-sm-3-5 pure-u-md-1-2 pure-u-lg-10-24 pure-u-xl-10-24 control-container">
        <h1 class="subtitle box-mode m-b-md">Agende uma <br> conversa agora</h1>
        <form id="form-cases" class="flex-container flex-direction-column flex-nowrap">
          <input type="text" name="nome" id="" placeholder="Nome" class="form-input box-mode m-b-md required">
          <input type="text" name="telefone" id="" placeholder="Telefone" class="form-input telefone box-mode m-b-md required">
          <input type="text" name="email" id="" placeholder="E-mail" class="form-input box-mode m-b-md required">
          <input type="text" name="empresa" id="" placeholder="Empresa" class="form-input box-mode m-b-md required">
          <input type="hidden" name="ididiomas" value="1">
          <button id="enviar-cases" type="submit" class="btn primary">Solicitar contato agora</button>
        </form>
      </div>
    </div>
    <img src="/images/faces.webp" alt="pessoas sorrindo" class="image container-background" aria-hidden="true">
  </section>


  <?php include_once("includes/modais.php");?>
  <?php include_once("includes/floating_vertical_bar.php");?>
</main>
