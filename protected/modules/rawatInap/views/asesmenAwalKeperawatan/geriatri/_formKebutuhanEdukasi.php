<div class="row-fluid">
   <div class="panel panel-primary panel-gradient">
      <div class="panel-heading">
          <div class="panel-title"><strong>Kebutuhan Edukasi</strong></div>
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
                 <div class="controls">
                   <?php
                      $modLookupData = LookupM::model()->findAll("lookup_type = 'edukasipasien'");

                      if(count((array)$modLookupData)>0){

                          foreach ($modLookupData as $i => $dataLook){
                              $html = "";
                              $ModAsseEdu = new RIAsesmenkebutuhanEdukasidetT();
                              if(is_array($modAsesmenkebutuhanEdukasidetT) && count((array)$modAsesmenkebutuhanEdukasidetT)>0){
                                  foreach ($modAsesmenkebutuhanEdukasidetT as $dataKebEduDet){
                                      if($dataKebEduDet->edukasipasien == $dataLook->lookup_value){
                                          $ModAsseEdu->isedukasipasien = true;
                                          $ModAsseEdu->edukasipasien_lainnya = $dataKebEduDet->edukasipasien_lainnya;
                                      }
                                  }

                              }

                              if($i > 0){
                                $html .= "<br/>";
                              }

                              if($dataLook->lookup_value == 'LAIN-LAIN'){
                                         $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i, 'onchange'=>'setChangeDetEdukasiLain_geriatri(this)')).' <label>'.$dataLook->lookup_name.'</label> ';
                                         $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                         $html .= $form->textField($ModAsseEdu, '['.$i.']edukasipasien_lainnya', array('class' => 'span3','readonly'=>(($ModAsseEdu->isedukasipasien)?false:true)));
                                 }else{
                                         $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i)).' <label>'.$dataLook->lookup_name.'</label> ';
                                         $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                 }
                              if($i == 0){
                                  echo $html;
                              }else{
                                   echo $html;
                              }
                          }
                      }
                   ?>
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
              <label class="control-label"></label>
              <div class="controls">
                <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_lainnya',array('onchange'=>'setHambatanLainnya_geriatri()')); ?>     <label>Lainnya</label>
                <?php echo $form->textField($modAsesmenkebutuhanEdukasiT,'hambatanbelajar_lainnya',array('class'=>'span3 ')); ?>
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
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status', array('class'=>'control-label')) ?>
                  <div class="controls">
                      <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status',array('class'=>'kebutuhanpenerjemah_status','value'=>'Tidak','onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerjemah_geriatri();','uncheckValue'=>null)); ?> <label>Tidak</label>
                  </div>
              </div>
               <div class="control-group ">
                  <label class="control-label"></label>
                  <div class="controls">
                      <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status',array('class'=>'kebutuhanpenerjemah_status','value'=>'Ya','onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerjemah_geriatri(this);','uncheckValue'=>null)); ?> <label>Ya, Bahasa</label>
                      <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa', array('class' => 'span3 disabledinputan')); ?>
                  </div>
              </div>
            </div>
         </div>
       </div>
   </div>
</div>
<div class="row-fluid">
    <div class="form-actions pull-right">
        <?php
          if(isset($_GET['sukses'])){
                  echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','id'=>'btn_simpan','disabled'=>true));
                  // echo "&nbsp;";
                  // echo CHtml::link(Yii::t('mds', '{icon} Cetak Asesmen Awal Keperawatan', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','onclick'=>"print('PRINT');return false"));
          }else{
                  echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','onclick'=>'simpanAllData_geriatri();')); //RND-8620
                  // echo "&nbsp;";
                  //  echo CHtml::link(Yii::t('mds', '{icon} Cetak Asesmen Awal Keperawatan', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','disabled'=>true));
          }
        ?>
    </div>
</div>
