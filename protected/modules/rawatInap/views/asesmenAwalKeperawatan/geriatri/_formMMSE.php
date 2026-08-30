<div class="panel panel-primary panel-gradient">
   <div class="panel-heading">
       <div class="panel-title"><strong>Mini Mental State Examination (MMSE)</strong></div>
   </div>
    <div class="panel-body">
      <div class="table-responsive" style="overflow-x:auto;">
        <div class='block-tabel'>
          <?php
          $sumTotalMMSE = 0;
           ?>
           <table class="items table table-bordered" id="tbl_mmse">
             <thead>
                 <tr>
                     <th style="text-align: center">Variabel</th>
                     <th style="width: 50px; text-align: center">Nilai Maksimum</th>
                     <th style="width: 200px; text-align: center">Nilai Responden</th>
                     <th style="width: 200px; text-align: center">Keterangan</th>
                 </tr>
             </thead>
             <tbody>
               <?php
                $modMinimentalexamMParent = MinimentalexamM::model()->findAllByAttributes(array('isaktif'=>true,'parent_id'=>null),array('order'=>'urutan ASC'));

                if(count((array)$modMinimentalexamMParent) > 0){
                  $indexNourut = 0;
                  foreach($modMinimentalexamMParent as $dataParent){
                    ?>
                    <tr>
                      <td style="font-weight: bold;">
                        <?php echo $dataParent->variabel; ?>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php
                    $modMinimentalexamM = MinimentalexamM::model()->findAllByAttributes(array('isaktif'=>true,'parent_id'=>$dataParent->minimentalexam_id),array('order'=>'urutan ASC'));
                      if(count((array)$modMinimentalexamM) > 0){
                        foreach($modMinimentalexamM as $dataChild){
                          $sumTotalMMSE += $dataChild->nilai_maksimum;
                          $nilairespone = 0;
                          $ket_mmse = "";
                          $minimentalexampasien_id = null;

                          if(count((array)$modMinimentalexampasienT) > 0){
                            foreach($modMinimentalexampasienT as $dataMiniMentalExP){
                              if($dataMiniMentalExP->minimentalexam_id == $dataChild->minimentalexam_id){
                                $nilairespone = $dataMiniMentalExP->nilai_responden;
                                $ket_mmse = $dataMiniMentalExP->keterangan;
                                $minimentalexampasien_id = $dataMiniMentalExP->minimentalexampasien_id;
                              }
                            }
                          }
                          ?>
                          <tr>
                            <td>
                              <?php echo CHtml::hiddenField('MinimentalexampasienT['.$indexNourut.'][minimentalexam_id]',$dataChild->minimentalexam_id); ?>
                              <?php echo CHtml::hiddenField('MinimentalexampasienT['.$indexNourut.'][minimentalexampasien_id]',$minimentalexampasien_id); ?>
                              <?php
                                  echo $dataChild->variabel;
                                  if($dataChild->isupload_gambar==true && !empty($dataChild->gambar)){
                                    echo '<br/> <img src="'.Params::urlMasterMinimentalexam().$dataChild->gambar.'" />';
                                  }
                               ?>
                            </td>
                            <td style="text-align: center"><?php echo $dataChild->nilai_maksimum; ?></td>
                            <td style="text-align: center">
                              <?php
                                if($dataChild->isupload_gambar==true){
                                  echo CHtml::fileField('uploadgambar_mmse[]','',array('multiple'=>true,'class'=>'uploadgambar_mmse'));
                                  echo '<br/><br/>'.CHtml::htmlButton('Upload Hasil Gambar',array('class'=>'btn btn-primary', 'type'=>'button','id'=>'btn_uploadmmse','onclick'=>'setKlikUploadMMSE();'));
                                  echo '<br/>';
                                  if(count((array)$modMinimentalexampasiendetT)>0){

                                    foreach($modMinimentalexampasiendetT as $k => $dataDetMmseOri){
                                      if($k > 0){
                                        echo '<br/>';
                                      }

                                      echo '<div class="div_serveruploadmmse">'.$dataDetMmseOri->gambar.' '.CHtml::link('<i class="icon-remove"></i>','javascript:void(0)',array('onclick'=>'batalUploadServer(this,'.$dataDetMmseOri->minimentalexampasiendet_id.');
                                      return false;')).'</div>';
                                    }
                                  }
                                  echo '<br/><div id="div_uploadmmse"></div>';
                                }else{
                                echo CHtml::textField('MinimentalexampasienT['.$indexNourut.'][nilai_responden]',$nilairespone,array('class'=>'span1 numbersOnly','style'=>'text-align: right','onblur'=>'setNiliaRespondenMMSE();'));
                                }
                              ?>
                            </td>
                            <td>
                              <?php echo CHtml::textArea('MinimentalexampasienT['.$indexNourut.'][keterangan]',$ket_mmse,array('class'=>'span3')); ?>
                            </td>
                          </tr>
                          <?php
                          $indexNourut++;
                        }
                      }
                  }
                }
                ?>
             </tbody>
             <tfoot>
               <tr>
                 <td>Total Nilai</td>
                 <td style="text-align: center"><?php echo $sumTotalMMSE; ?></td>
                 <td><?php echo CHtml::activeTextField($modAskepgeriatriT,'minimentalexam_skor',array('class'=>'span1', 'style'=>'text-align: right;','readonly'=>true)); ?></td>
                 <td><?php echo CHtml::activeTextField($modAskepgeriatriT,'minimentalexam_keterangan',array('class'=>'span3','readonly'=>true)); ?></td>
               </tr>
             </tfoot>
           </table>
           <br/>
           <table width="100%">
             <tr>
               <td>Pedoman Skor Kognitif Global (Secara Umum) : </td>
             </tr>
             <tr>
               <td>Nilai : 24-30 (Normal)</td>
             </tr>
             <tr>
               <td>Nilai : 17-23 (Probable Gangguan Kognitif)</td>
             </tr>
             <tr>
               <td>Nilai : 0-16 (Definite Gangguan Kognitif)</td>
             </tr>
           </table>
         </div>
     </div>
  </div>
</div>
