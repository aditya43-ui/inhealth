<div class="row-fluid">
   <div class="panel panel-primary panel-gradient">
      <div class="panel-heading">
          <div class="panel-title"><strong>Psiko-Sosial-Spritual</strong></div>
      </div>
       <div class="panel-body">
         <div class="row">
             <div class="col-sm-6">
               <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_kebsosialekonomi_statusperkawinan', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_kebsosialekonomi_statusperkawinan', LookupM::getItems('statusperkawinan'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   </div>
               </div>
               <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'isada_anak', array('class'=>'control-label','label'=>'Anak')) ?>
                   <div class="controls">
                       <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'isada_anak', array('Tidak Ada'=>'Tidak Ada','Ada'=>'Ada'), array('class'=>'isada_anak','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setAnak_anak();')); ?>
                   </div>
               </div>
               <div class="control-group">
                   <?php echo CHtml::label('','', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <div class="control-group">
                         <?php echo CHtml::label('Jumlah Anak','', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php echo $form->textField($modAsesmenawalkeperawatanT,'jml_anak', array('class'=>'span1 integer2','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                         </div>
                     </div>
                   </div>
               </div>
               <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_pendidikanortu', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_pendidikanortu', CHtml::listdata(PendidikanM::model()->findAll('pendidikan_aktif = true'),'pendidikan_nama','pendidikan_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   </div>
               </div>
               <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_warganegaraortu', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_warganegaraortu', LookupM::getItems('warganegara'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                   </div>
               </div>
               <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_tinggalbersama', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_tinggalbersama', LookupM::getItems('asesmen_tinggalbersama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'changeTinggalBersama_anak(this);')); ?>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <span style="color: black">Nama Pihak Lainnya </span> <br/><?php echo $form->textField($modAsesmenawalkeperawatanT,'neonatus_tinggalbersamalainnya_nama',array('class'=>'span3 tinggalbersama disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <span style="color: black">No. telp Pihak Lainnya</span> <br/><?php echo $form->textField($modAsesmenawalkeperawatanT,'neonatus_tinggalbersamalainnya_notlp',array('class'=>'span3 tinggalbersama disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                   </div>
               </div>
               <div class="control-group ">
                 <div class="controls">
                   <span style="color:black"><u>Kebiasaan</u></span>
                 </div>
               </div>
               <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'statusmerokok', array('class'=>'control-label')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'statusmerokok',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusrokok','onclick'=>'setJumlahRokok(this);','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="control-group">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT, 'jmlrokok_btg_hr', array('class' => 'control-label')) ?>
                  <div class="controls">
                    <?php echo $form->textField($modAsesmenawalkeperawatanT, 'jmlrokok_btg_hr', array('class' => 'span1 jmlbtg', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    Per Hari
                  </div>
                </div>
                <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_kebiasaanortualkohol_status', array('class'=>'control-label')) ?>
                  <div class="controls">
                    <div class="radio inline">
                      <div class="form-inline">
                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'neonatus_kebiasaanortualkohol_status',array('0'=>'Tidak','1'=>'Ya'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'neonatus_kebiasaanortualkohol_status','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis & Jumlah Alkohol yang dikonsumsi</label>
                    <div class="controls">
                      <?php echo $form->textField($modAsesmenawalkeperawatanT,'neonatus_kebiasaanortualkohol_jenis',array('placeholder'=>'Jenis','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?> <span style="color: black">/</span>
                      <?php echo $form->textField($modAsesmenawalkeperawatanT,'neonatus_kebiasaanortualkohol_jml',array('placeholder'=>'Jumlah','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                      <span style="color: black">Per Hari</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Kebiasaan Lainnya</label>
                    <div class="controls">
                      <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'neonatus_kebiasaanortulainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_agamaortu', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_agamaortu', LookupM::getItems('agama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

             </div>
             <div class="col-sm-6">
               <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'masalahdlm_berbicara', array('class'=>'control-label','label'=>'Masalah dalam berbicara')) ?>
                   <div class="controls">
                       <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'masalahdlm_berbicara', array('Tidak'=>'Tidak','Ya'=>'Ya'), array('class'=>'masalahdlm_berbicara','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setMasalahDlmBerbicara_anak();')); ?>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     Jelaskan <br />
                     <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'masalahbicara_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                   </div>
               </div>
               <div class="control-group ">
                   <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bahasaseharihari_jenis', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'bahasaseharihari_jenis',array('Indonesia'=>'Bahasa Indonesia','Daerah'=>'Bahasa Daerah') , array('class'=>'bahasaseharihari_jenis','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setEduBahasaSehari(this);')); ?>
                   </div>
               </div>
              <div class="control-group">
                 <label class="control-label"></label>
                 <div class="controls">
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'bahasadaerah_nama', array('placeholder'=>'Sebutkan jenis bahasa daerah','class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>
             <div class="control-group ">
                 <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status', array('class'=>'control-label')) ?>
                 <div class="controls">
                     <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status',array('class'=>'kebutuhanpenerjemah_status','value'=>'Tidak','onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerjemah(this);','uncheckValue'=>null)); ?> <label>Tidak</label>
                 </div>
             </div>
              <div class="control-group ">
                 <label class="control-label"></label>
                 <div class="controls">
                     <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status',array('class'=>'kebutuhanpenerjemah_status','value'=>'Ya','onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerjemah(this);','uncheckValue'=>null)); ?> <label>Ya, Bahasa</label>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa', array('class' => 'span3','readonly'=>true)); ?>
                 </div>
             </div>
             <div class="control-group ">
               <div class="controls">
                 <span style="color:black"><u>Ekonomi</u></span>
               </div>
             </div>
             <div class="control-group">
                 <?php echo $form->labelEx($modAsesmenawalkeperawatanT,'neonatus_pekerjaanortu', array('class'=>'control-label')) ?>
                 <div class="controls">
                     <?php echo $form->dropDownList($modAsesmenawalkeperawatanT,'neonatus_pekerjaanortu', CHtml::listdata(PekerjaanM::model()->findAll('pekerjaan_aktif = true'),'pekerjaan_nama','pekerjaan_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 </div>
             </div>
             <div class="control-group ">
                <label class="control-label">Pembiayaan Kesehatan</label>
                <div class="controls">
                    <?php echo CHtml::textField('carabayar_nama', (isset($modPendaftaran->carabayar)? $modPendaftaran->carabayar->carabayar_nama:""), array('class' => 'span3','readonly'=>true)); ?>
                </div>
            </div>
          </div>
       </div>
     </div>
   </div>
</div>
