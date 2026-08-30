<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Komunikasi & Edukasi</strong></div>
        </div>
         <div class="panel-body">
           <?php CHtml::activeHiddenField($modAsesmenkebutuhanEdukasiT, 'pendaftaran_id'); ?>
            <?php CHtml::activeHiddenField($modAsesmenkebutuhanEdukasiT, 'pasienadmisi_id'); ?>

           <div class="row">
             <div class="col-sm-6">
               <div class="control-group ">
                  <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'neonatus_edukasidiberikankpd', array('class'=>'control-label')) ?>
                  <div class="controls">
                      <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'neonatus_edukasidiberikankpd', array('Orang Tua'=>'Orang Tua','Keluarga'=>'Keluarga'), array('class'=>'neonatus_edukasidiberikankpd','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'changeEdukasiDiberikan(this)')); ?>
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <span style="color: black">Hubungan dengan Pasien </span> <br/>
                      <?php echo $form->dropDownList($modAsesmenkebutuhanEdukasiT,'neonatus_hubkeluargapenerimaedukasi', LookupM::getItems('hubungankeluarga'),array('disabled'=>true,'class'=>'span3 disabledinputan', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group ">
                   <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bicara_status', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'bicara_status_neonatus', array('Normal'=>'Normal','Serangan awal gangguan bicara'=>'Serangan awal gangguan bicara'), array('class'=>'bicara_status_neonatus','onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'changeBicaraStatusNeonatus(this)')); ?>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <span style="color: black">Kapan </span>
                     <?php echo $form->textField($modAsesmenkebutuhanEdukasiT,'mulaiseranganawal_neonatus',array('disabled'=>true,'class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label">Bahasa Sehari-hari</label>
                   <div class="controls">
                     <label class="checkbox inline">
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_indo',array('onchange'=>'changeSehariIndo(this)')); ?> <label>Indonesia</label>
                     </label>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls" style="padding-left: 20px;">
                     <?php echo $form->hiddenField($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_indostatus'); ?>
                    <div style="width: 150px;"><div style="cursor: pointer;" class='bahasastatusindoAktif disabledstatusspan' onclick="clickIndoStatus(this,'Aktif')">Aktif</div><div style="float: left; color:black;"> / </div><div style="cursor: pointer;" class='bahasastatusindoPasif disabledstatusspan' onclick="clickIndoStatus(this,'Pasif')"> Pasif</div></div>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <label class="checkbox inline">
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_inggris',array('onchange'=>'changeSehariEng(this)')); ?> <label>Inggris</label>
                     </label>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls" style="padding-left: 20px;">
                     <?php echo $form->hiddenField($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_inggrisstatus'); ?>
                    <div style="width: 150px;"><div style="cursor: pointer;" class='bahasastatusinggrisAktif disabledstatusspan' onclick="clickEngStatus(this,'Aktif')">Aktif</div><div style="float: left;"> / </div><div style="cursor: pointer;" class='bahasastatusinggrisPasif disabledstatusspan' onclick="clickEngStatus(this,'Pasif')"> Pasif</div></div>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <label class="checkbox inline">
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_daerah',array('onchange'=>'changeSehariDaerah(this)')); ?> <label>Daerah, Jelaskan</label>
                     </label>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls" style="padding-left: 20px;">
                    <?php echo $form->textField($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_daerahket',array('disabled'=>true,'class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <label class="checkbox inline">
                         <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_lainnya',array('onchange'=>'changeSehariLainnya(this)')); ?> <label>Lainnya, Jelaskan</label>
                     </label>
                   </div>
               </div>
               <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls" style="padding-left: 20px;">
                    <?php echo $form->textField($modAsesmenkebutuhanEdukasiT,'neonatus_bahasaseharihari_lainnyaket',array('disabled'=>true,'class'=>'span3 disabledinputan', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                   </div>
               </div>
               <div class="control-group ">
                   <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status', array('class'=>'control-label')) ?>
                   <div class="controls">
                       <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status_neonatus',array('class'=>'kebutuhanpenerjemah_status','value'=>'Tidak','onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerjemah_neonatus(this);','uncheckValue'=>null)); ?> <label>Tidak</label>
                   </div>
               </div>
                <div class="control-group ">
                   <label class="control-label"></label>
                   <div class="controls">
                       <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'kebutuhanpenerjemah_status_neonatus',array('class'=>'kebutuhanpenerjemah_status','value'=>'Ya','onkeypress'=>"return $(this).focusNextInputField(event);",'onclick'=>'setEdukasiPenerjemah_neonatus(this);','uncheckValue'=>null)); ?> <label>Ya, Bahasa</label>
                       <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'kebutuhanpenerjemah_jenisbahasa_neonatus', array('disabled'=>true,'class' => 'span3 disabledinputan')); ?>
                   </div>
               </div>
                <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bahasaisyarat_status', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <div class="radio inline">
                       <div class="form-inline">
                         <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'bahasaisyarat_status_neonatus',array('Tidak'=>'Tidak','Ada'=>'Ada'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'','labelOptions'=>array('style'=> 'padding-left:5px;padding-right:10px;'))); ?>
                       </div>
                     </div>
                   </div>
               </div>
             </div>
             <div class="col-sm-6">
               <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_bahasa', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_bahasa_neonatus',array('class'=>'')); ?>     <label>Bahasa</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_emosi_neonatus',array('class'=>'')); ?>     <label>Emosi</label>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                            <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_pendengaran_neonatus',array('class'=>'')); ?>     <label>Pendengaran</label>
                            &nbsp;&nbsp;&nbsp;
                            <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_butahuruf_neonatus',array('class'=>'')); ?>     <label>Buta Huruf</label>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                            <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_penglihatan_neonatus',array('class'=>'')); ?>     <label>Pengelihatan</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_usia_neonatus',array('class'=>'')); ?>     <label>Usia</label>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                            <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_motivasi_neonatus',array('class'=>'')); ?>     <label>Motivasi</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_kognitif_neonatus',array('class'=>'')); ?>     <label>Kognitif</label>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                      <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_fisik_neonatus',array('class'=>'')); ?>     <label>Fisik</label>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'ishambatanbelajar_tidakada_neonatus',array('class'=>'')); ?>     <label>Tidak</label>
                    </div>
                </div>
                <div class="control-group">
                   <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_menulis', array('class'=>'control-label')) ?>
                   <div class="controls">
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_menulis_neonatus',array('class'=>'')); ?>     <label>Menulis</label>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_demonstrasi_neonatus',array('class'=>'')); ?>     <label>Demonstrasi</label>
                   </div>
               </div>
                 <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_audiovisual_neonatus',array('class'=>'')); ?>     <label>Audio-Visual / Gambar</label>
                     &nbsp;
                     <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_membaca_neonatus',array('class'=>'')); ?>     <label>Membaca</label>
                   </div>
               </div>
                 <div class="control-group">
                   <label class="control-label"></label>
                   <div class="controls">
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_diskusi_neonatus',array('class'=>'')); ?>     <label>Diskusi</label>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?php echo $form->checkbox($modAsesmenkebutuhanEdukasiT,'iscarabelajardisukai_mendengarkan_neonatus',array('class'=>'')); ?>     <label>Mendengarkan</label>
                   </div>
               </div>

               <div class="control-group">
                 <label class="control-label">Kebutuhan Edukasi</label>
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
                            if($dataLook->lookup_value == 'LAIN-LAIN'){
                                    $html .= '<div class="controls">';
                                       $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i, 'onchange'=>'setChangeDetEdukasiLain_neonatus(this)')).' <label>'.$dataLook->lookup_name.'</label> ';
                                       $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                       $html .= $form->textField($ModAsseEdu, '['.$i.']edukasipasien_lainnya', array('class' => 'span3 disabledinputan','disabled'=>(($ModAsseEdu->isedukasipasien)?false:true)));
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
             </div>
           </div>

         </div>
     </div>
</div>
