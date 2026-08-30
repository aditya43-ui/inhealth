<div class="row">
    <?php 
     $tempInstalasiId = '';
     foreach ($modRuanganPemakai as $i=>$ruangan){
         if($tempInstalasiId != $ruangan['instalasi_id']){
             if($i>1)echo '</div></fieldset>';
             echo '<fieldset><legend>'.$ruangan['instalasi_nama'].'</legend><div class="bloc">';
         } 
         $color = ($ruangan['ruangan_aktif'] == TRUE) ? '' : 'style="background-color:#FF3366;"';
         echo "<div class='boxrepeat span2'  $color>";
         echo Chtml::checkBox('ruangan['.$ruangan["ruangan_nama"].']', true  ,array('value'=>$ruangan["ruangan_id"],'uncheckValue'=>0,'disabled'=>true));
         echo $ruangan['ruangan_nama']; echo "<br/>";
         echo "</div>";
         $tempInstalasiId = $ruangan['instalasi_id'];
     } echo '</div></fieldset>';
    ?>
    
</div>