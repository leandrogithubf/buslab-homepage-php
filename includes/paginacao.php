<div id="blog-paginacao" class="blg-pag">
    <ul class="blg-pag-list">
      <?php
          if($total > 1) {

              if($pag > 0){
               $active = "on";
              }else{
               $active = "off";
              }

              if($pag < $total - 1){
               $active2 = "on";
              }else{
               $active2 = "off";
              }

              // if($pag > 0){
                  echo "<li class='blg-pag-list-nav'><a class='blg-pag-list-nav-prev' data-actived='".$active."' href='".$urlpag.(($pag > 1)? "/".$pag:"")."'></a></li>";
              // }

              $total_paginas = $total;

              $aux = 0;
              $pagAux = 0;

              if($total_paginas > 5)
                   $limitPaginacao = 4;
              else
                  $limitPaginacao = $total_paginas - 1;

              if($pag >= 3) {
                  $pagAux = $pag - 2; 
                  if(($pag + 1) == $total_paginas)
                      $limitPaginacao = $limitPaginacao - 1;
              } 

              while($aux <= $limitPaginacao) {
                  $num = $pagAux + 1;

                  if($pagAux == $pag){
                      echo  "<li class='blg-pag-list-item'><a class='blg-pag-list-num' data-actived='on' href='javascript:;'>".$num."</a></li>";
                  }else if($num<= $total_paginas){
                      echo  "<li class='blg-pag-list-item'><a class='blg-pag-list-num' href='".$urlpag.(($num > 1)? "/".$num:"")."'>".$num."</a></li>";
                  }   

                  $pagAux = $pagAux + 1;
                  $aux = $aux + 1;
              }

              // if($pag < $total - 1){
                   echo '<li class="blg-pag-list-nav"><a class="blg-pag-list-nav-next" data-actived="'.$active2.'" href="'.$urlpag."/".($pag + 2).'"></a></li>';
              // }
          } 
      ?>


<!-- RETIRAR 
    <span class='prev'>
        <a href="#">Anteriores</a>
    </span>

    <span><a href='#' class='ativo'>1</a></span>
    <span><a href='#'>2</a></span>
    <span><a href='#'>3</a></span>

    <span class="next">
        <a href="#">Próximos</a>
    </span>
 RETIRAR -->
   </ul>
</div> 