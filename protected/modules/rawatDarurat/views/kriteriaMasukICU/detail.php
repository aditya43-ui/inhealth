<style type="text/css">
  html{
    font-size: 11pt !important;
    color: black;
  }

  body{
      color: black !important;
      margin: 0;
      padding: 0;
  }

  .tableBorder th, .tableBorder td {
      border:1px solid #000;
      padding: 10px;
  }

  .tablePadding th, .tablePadding td {
      padding: 10px;
  }
</style>
<div style="float: right; padding-right: 10px; padding-top: 5px; padding-bottom: 10px; font-weight: bold;">FRM/91A/RSBMB</div>
<table class="tablePadding" width="100%">
  <tr>
    <td width="150px">Tanggal Pemeriksaan</td>
    <td width="5px">:</td>
    <td>
      <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_pemeriksaan); ?>
    </td>
  </tr>
  <tr>
    <td>Petugas Pemeriksa</td>
    <td>:</td>
    <td>
      <?php echo MyFormatter::formatDateTimeForUser($model->petugas_pemeriksa); ?>
    </td>
  </tr>
  <tr>
    <td>Ruangan</td>
    <td>:</td>
    <td>
      <?php $ruangan = RuanganM::model()->findByPk($model->create_ruangan);
          echo (!empty($ruangan)?$ruangan->ruangan_nama:""); ?>
    </td>
  </tr>
</table>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><strong>Checklist Kriteria Masuk ICU</strong></div>
    </div>
    <div class="panel-body">
      <table class="tableBorder" width="100%">
          <thead>
              <tr>
                  <th style="text-align: center; font-weight: bold" colspan="3">Kriteria Fisiologi</th>
                  <th style="text-align: center; font-weight: bold" width="10%">Ya</th>
                  <th style="text-align: center; font-weight: bold" width="10%">Tidak</th>
              </tr>
           </thead>
           <tbody>
             <?php
               $abcd=array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'e',5=>'f',6=>'g',7=>'h',8=>'i',9=>'j',10=>'k',11=>'l',12=>'m',13=>'n',14=>'0',15=>'p',16=>'q',17=>'r',18=>'s',19=>'t',20=>'u',21=>'v',22=>'w',23=>'x',24=>'y',25=>'z');
               $nourutParent = 0;
               $nourutChild = 0;

               $parentKriteriaIcu = KriteriaicuM::model()->findAllByAttributes(array('jenis_kriteria'=>'Masuk ICU','berhubungan_dengan'=>null,'level_kriteria'=>1),array('order'=>'urutan ASC'));

               if(count($parentKriteriaIcu)){
                 foreach($parentKriteriaIcu as $i => $parent){
                   $nourutParent += 1;
                   $ischeckParent = null;

                   if(count($modDetail) > 0){
                     foreach($modDetail as $dataDetail){
                       if($dataDetail->kriteriaicu_id == $parent->kriteriaicu_id){
                         if($dataDetail->is_kriteria == true){
                           $ischeckParent = 1;
                         }else if($dataDetail->is_kriteria == false){
                           $ischeckParent = 2;
                         }

                       }
                     }
                   }

                   $childKriteriaIcu = KriteriaicuM::model()->findAllByAttributes(array('jenis_kriteria'=>'Masuk ICU','berhubungan_dengan'=>$parent->kriteriaicu_id,'level_kriteria'=>2),array('order'=>'urutan ASC'));
                   ?>
                   <tr>
                     <td style="text-align: center; vertical-align: middle;" rowspan="<?php echo (count($childKriteriaIcu)+1); ?>"><?php echo $nourutParent.'.'; ?></td>
                     <td colspan="2" style="font-weight: bold">
                       <?php echo $parent->deskripsi; ?>
                     </td>
                     <td style="text-align: center;">
                       <span class="<?php echo (($ischeckParent != null && $ischeckParent == 1)? "fa fa-check":""); ?>"></span>
                     </td>
                     <td style="text-align: center;">
                       <span class="<?php echo (($ischeckParent != null && $ischeckParent == 2)? "fa fa-check":""); ?>"></span>
                     </td>
                   </tr>
                   <?php
                   if(count($childKriteriaIcu) > 0){
                     $nourutChild = 0;
                     foreach ($childKriteriaIcu as $j => $child) {
                       $ischeckChild = null;

                       if(count($modDetail) > 0){
                         foreach($modDetail as $dataDetail){
                           if($dataDetail->kriteriaicu_id == $child->kriteriaicu_id){
                             if($dataDetail->is_kriteria == true){
                               $ischeckChild = 1;
                             }else if($dataDetail->is_kriteria == false){
                               $ischeckChild = 2;
                             }
                           }
                         }
                       }

                       ?>
                       <tr>
                         <td style="text-align: center; width: 35px"><?php echo $abcd[$nourutChild].'.'; ?></td>
                         <td>
                           <?php echo $child->deskripsi; ?>
                         </td>
                         <td style="text-align: center;">
                           <span class="<?php echo (($ischeckChild != null && $ischeckChild == 1)? "fa fa-check":""); ?>"></span>
                         </td>
                         <td style="text-align: center;">
                           <span class="<?php echo (($ischeckChild != null && $ischeckChild == 2)? "fa fa-check":""); ?>"></span>
                         </td>
                       </tr>
                       <?php
                       $nourutChild++;
                     }
                   }
                 }
               }
              ?>
           </tbody>
      </table>
    </div>
</div>
