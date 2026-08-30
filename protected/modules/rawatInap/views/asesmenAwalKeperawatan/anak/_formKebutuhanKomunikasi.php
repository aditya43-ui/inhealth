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
              <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bicara_status', array('class'=>'control-label')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'bicara_status',array('Normal'=>'Normal','Serangan Awal Bicara'=>'Serangan awal gangguan bicara') , array('class'=>'bicara_status','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setEdukasiBicara(this);')); ?>
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
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_bahasa',array('class'=>'kebEliminasiBak')); ?>     <label>Bahasa</label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_emosi',array('class'=>'kebEliminasiBak')); ?>     <label>Emosi</label>
                 </div>
             </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_pendengaran',array('class'=>'kebEliminasiBak')); ?>     <label>Pendengaran</label>
                       &nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_butahuruf',array('class'=>'kebEliminasiBak')); ?>     <label>Buta Huruf</label>
               </div>
           </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_penglihatan',array('class'=>'kebEliminasiBak')); ?>     <label>Pengelihatan</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_usia',array('class'=>'kebEliminasiBak')); ?>     <label>Usia</label>
               </div>
           </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_motivasi',array('class'=>'kebEliminasiBak')); ?>     <label>Motivasi</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_kognitif',array('class'=>'kebEliminasiBak')); ?>     <label>Kognitif</label>
               </div>
           </div>
            <div class="control-group">
               <label class="control-label"></label>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_fisik',array('class'=>'kebEliminasiBak')); ?>     <label>Fisik</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_tidakada',array('class'=>'kebEliminasiBak')); ?>     <label>Tidak</label>
               </div>
           </div>
            <div class="control-group">
               <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_menulis', array('class'=>'control-label')) ?>
               <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_menulis',array('class'=>'kebEliminasiBak')); ?>     <label>Menulis</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_demonstrasi',array('class'=>'kebEliminasiBak')); ?>     <label>Demonstrasi</label>
               </div>
           </div>
           <div class="control-group">
             <label class="control-label"></label>
             <div class="controls">
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_audiovisual',array('class'=>'kebEliminasiBak')); ?>     <label>Audio-Visual / Gambar</label>
                     &nbsp;
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_membaca',array('class'=>'kebEliminasiBak')); ?>     <label>Membaca</label>
             </div>
           </div>
           <div class="control-group">
             <label class="control-label"></label>
             <div class="controls">
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_diskusi',array('class'=>'kebEliminasiBak')); ?>     <label>Diskusi</label>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_mendengarkan',array('class'=>'kebEliminasiBak')); ?>     <label>Mendengarkan</label>
             </div>
           </div>

            </div>
            <div class="col-md-6">
              <div class="control-group">
                  <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'nilaikepercayaankhusus', array('class'=>'control-label','label'=>'Kajian budaya, nilai-nilai budaya atau kepercayaan khusus')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'nilaikepercayaankhusus', array('Tidak'=>'Tidak','Ya'=>'Ya'), array('class'=>'nilaikepercayaankhusus_dewasa','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNilaiKepercayaanKhusus_anak();')); ?>
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
                     <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kesediaanmenerimaedukasi_status',array('class'=>'kesediaanmenerimaedukasi_status','value'=>'0','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerima(this);')); ?> <label>Tidak</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak', array('placeholder'=>'Alasan tidak bersedia','class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>
             <div class="control-group ">
                 <label class="control-label"></label>
                 <div class="controls">
                     <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kesediaanmenerimaedukasi_status',array('class'=>'kesediaanmenerimaedukasi_status','value'=>'1','uncheckValue'=>null,'onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerima(this);')); ?> <label>Ya</label>
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
                     &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ispenerimaedukasi_keluargapasien',array('class'=>'edukasipenerima','disabled'=>true,'onchange'=>'setEdukasiPenerimaKeluarga(this);')); ?>     <label>Keluarga Pasien</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_namakeluargapasien', array('class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>
             <div class="control-group">
                 <label class="control-label"></label>
                 <div class="controls">
                     <label> </label>&nbsp;&nbsp;&nbsp;
                     &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ispenerimaedukasi_lainnya',array('class'=>'edukasipenerima','disabled'=>true,'onchange'=>'setEdukasiPenerimaLainnya(this);')); ?>     <label>Lainnya</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'penerimaedukasi_lainnyanama', array('class' => 'span3','readonly'=>true)); ?>
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
          }else{
                  echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','onclick'=>'simpanAllDataAnak();')); //RND-8620
          }
        ?>
    </div>
</div>
