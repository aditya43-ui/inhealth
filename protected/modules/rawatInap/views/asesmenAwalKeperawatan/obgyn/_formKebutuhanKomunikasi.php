<?php $hide = true; ?>


<div class="row-fluid">
   <div class="panel panel-primary panel-gradient">
      <div class="panel-heading">
          <div class="panel-title"><strong>Kebutuhan Komunikasi/ Pendidikan dan Pengajaran</strong></div>
      </div>
       <div class="panel-body">
         <?php CHtml::activeHiddenField($modAsesmenkebutuhanEdukasiT, 'pendaftaran_id'); ?>
         <?php CHtml::activeHiddenField($modAsesmenkebutuhanEdukasiT, 'pasienadmisi_id'); ?>

         <div class="row">
            <div class="col-md-6">
              <div class="control-group">
                 <div class="control-label">
                     <?php echo CHtml::label('Potensial kebutuhan pembelajaran', '', array('class' => 'control-label')) ?>
                 </div>

              <?php
                 $modLookupData = LookupM::model()->findAll("lookup_type = 'edukasipasien'");

                 if(count((array)$modLookupData)>0){

                     foreach ($modLookupData as $i => $dataLook){
                         $html = "";
                         $ModAsseEdu = new RIAsesmenkebutuhanEdukasidetT();
                         if(is_array($modAsesmenkebutuhanEdukasidetT) && count((array)$modAsesmenkebutuhanEdukasidetT)>0){
//                                $ModAsseEdu = new RDAsesmenkebutuhanEdukasidetT();
                             foreach ($modAsesmenkebutuhanEdukasidetT as $dataKebEduDet){
                                 if($dataKebEduDet->edukasipasien == $dataLook->lookup_value){
                                     $ModAsseEdu->isedukasipasien = true;
                                     $ModAsseEdu->edukasipasien_lainnya = $dataKebEduDet->edukasipasien_lainnya;
                                 }


                             }

                         }else{

                         }
                         if($dataLook->lookup_value == 'LAIN-LAIN'){
                                 $html .= '<div class="controls">';
                                    $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i, 'onchange'=>'setChangeDetEdukasiLain_obgyn(this)')).' <label>'.$dataLook->lookup_name.'</label> ';
                                    $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                    $html .= $form->textField($ModAsseEdu, '['.$i.']edukasipasien_lainnya', array('class' => 'span3','readonly'=>(($ModAsseEdu->isedukasipasien)?false:true)));
                                    $html .=  '</div>';
                            }else{
                                $html .= '<div class="controls">';
                                    $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i)).' <label>'.$dataLook->lookup_name.'</label> ';
                                    $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                    $html .=  '</div>';
                            }
                         if($i == 0){
                             echo $html;
                              echo '</div>';
                         }else{
                             echo '<div class="control-group">';
                              echo '<label class="control-label"></label>';
                              echo $html;
                             echo '</div>';
                         }
                     }
                 }else{
                     echo '</div>';
                 }
              ?>

              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bicara_status', array('class'=>'control-label')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'bicara_status',array('Normal'=>'Normal','Serangan Awal Bicara'=>'Serangan awal gangguan bicara') , array('class'=>'bicara_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setEdukasiBicara_obgyn(this);')); ?>
                  </div>
              </div>
               <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                      <label>Kapan </label>&nbsp;&nbsp;&nbsp;
                      <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'mulaiseranganawal', array('class' => 'span3','readonly'=>true)); ?>
                  </div>
              </div>
              <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_bahasa', array('class'=>'control-label')) ?>
                 <div class="controls">
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_bahasa',array('class'=>'')); ?>     <label>Bahasa</label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_emosi',array('class'=>'')); ?>     <label>Emosi</label>
                 </div>
             </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_pendengaran',array('class'=>'')); ?>     <label>Pendengaran</label>
                       &nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_butahuruf',array('class'=>'')); ?>     <label>Buta Huruf</label>
               </div>
           </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_penglihatan',array('class'=>'')); ?>     <label>Pengelihatan</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_usia',array('class'=>'')); ?>     <label>Usia</label>
               </div>
           </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_motivasi',array('class'=>'')); ?>     <label>Motivasi</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_kognitif',array('class'=>'')); ?>     <label>Kognitif</label>
               </div>
           </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_fisik',array('class'=>'')); ?>     <label>Fisik</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_tidakada',array('class'=>'')); ?>     <label>Tidak</label>
               </div>
           </div>
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_menulis', array('class'=>'control-label')) ?>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_menulis',array('class'=>'')); ?>     <label>Menulis</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_demonstrasi',array('class'=>'')); ?>     <label>Demonstrasi</label>
               </div>
           </div>
           <div class="control-group">
             <label class="control-label"></label>
             <div class="controls">
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_audiovisual',array('class'=>'')); ?>     <label>Audio-Visual / Gambar</label>
                     &nbsp;
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_membaca',array('class'=>'')); ?>     <label>Membaca</label>
             </div>
           </div>
           <div class="control-group">
             <label class="control-label"></label>
             <div class="controls">
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_diskusi',array('class'=>'')); ?>     <label>Diskusi</label>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_mendengarkan',array('class'=>'')); ?>     <label>Mendengarkan</label>
             </div>
           </div>

            </div>
            <div class="col-md-6">
              <div class="control-group">
                  <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'nilaikepercayaankhusus', array('class'=>'control-label','label'=>'Kajian budaya, nilai-nilai budaya atau kepercayaan khusus')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'nilaikepercayaankhusus', array('Tidak'=>'Tidak','Ya'=>'Ya'), array('class'=>'nilaikepercayaankhusus_dewasa','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNilaiKepercayaanKhusus_obgyn();')); ?>
                  </div>
              </div>
              <div class="control-group">
                  <label class="control-label"></label>
                  <div class="controls">
                    <?php echo $form->textArea($modAsesmenkebutuhanEdukasiT, 'nilaikepercayaankhususket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                  </div>
              </div>
              <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'kesediaanmenerimaedukasi_status', array('class'=>'control-label','label'=>'Pasien dan/keluarga pasien bersedia diberikan edukasi')) ?>
                 <div class="controls">
                     <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kesediaanmenerimaedukasi_status',array('class'=>'kesediaanmenerimaedukasi_status','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerima_obgyn(this);')); ?> <label>Tidak</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak', array('placeholder'=>'Alasan tidak bersedia','class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>
             <div class="control-group ">
                 <label class="control-label"></label>
                 <div class="controls">
                     <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kesediaanmenerimaedukasi_status',array('class'=>'kesediaanmenerimaedukasi_status','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerima_obgyn(this);')); ?> <label>Ya</label>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label"></label>
                 <div class="controls">
                     <label>Pihak Penerima Edukasi </label>&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ispenerimaedukasi_pasien',array('class'=>'edukasipenerima','disabled'=>true)); ?>     <label>Pasien</label>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label"></label>
                 <div class="controls">
                     <label> </label>&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ispenerimaedukasi_keluargapasien',array('class'=>'edukasipenerima','disabled'=>true,'onchange'=>'setEdukasiPenerimaKeluarga_obgyn(this);')); ?>     <label>Keluarga Pasien</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien', array('class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label"></label>
                 <div class="controls">
                     <label> </label>&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ispenerimaedukasi_lainnya',array('class'=>'edukasipenerima','disabled'=>true,'onchange'=>'setEdukasiPenerimaLainnya_obgyn(this);')); ?>     <label>Lainnya</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama', array('class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>

            </div>
         </div>
       </div>
   </div>
</div>
<?php if(Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_RI && Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_PI){ ?>
<div class="row-fluid">
    <div class="form-actions pull-right">
        <?php
          if(isset($_GET['sukses'])){
                  echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','id'=>'btn_simpan','disabled'=>true));
          }else{
                  echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','onclick'=>'simpanAllData_obgyn();')); //RND-8620
          }
        ?>
    </div>
</div>
<?php } ?>
