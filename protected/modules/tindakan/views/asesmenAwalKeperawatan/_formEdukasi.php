<?php $hide = true; ?>
<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Edukasi</strong></div>
        </div>
         <div class="panel-body">
             <div class="col-md-6">
                 <?php CHtml::activeHiddenField($modAsesmenkebutuhanEdukasiT, 'pendaftaran_id'); ?>
                <?php CHtml::activeHiddenField($modAsesmenkebutuhanEdukasiT, 'pasienadmisi_id'); ?>
                 <div class="control-group">
                    <div class="control-label">
                        <?php echo CHtml::label('Kebutuhan Edukasi', '', array('class' => 'control-label')) ?>
                    </div>

                 <?php
                    $modLookupData = LookupM::model()->findAll("lookup_type = 'edukasipasien'");

                    if(count($modLookupData)>0){

                        foreach ($modLookupData as $i => $dataLook){
                            $html = "";
                            $ModAsseEdu = new RIAsesmenkebutuhanEdukasidetT();
                            if(is_array($modAsesmenkebutuhanEdukasidetT) && count($modAsesmenkebutuhanEdukasidetT)>0){
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
                                       $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i, 'onchange'=>'setChangeDetEdukasiLain(this)')).' <label>'.$dataLook->lookup_name.'</label> ';
                                       $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                       $html .= $form->textField($ModAsseEdu, '['.$i.']edukasipasien_lainnya', array('class' => 'span3','readonly'=>(($ModAsseEdu->isedukasipasien)?false:true)));
                                       $html .=  '</div>';
                               }else{
                                   $html .= '<div class="controls">';
                                       $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($ModAsseEdu,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i)).' <label>'.$dataLook->lookup_name.'</label> ';
                                       $html .= $form->hiddenField($ModAsseEdu, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
                                       $html .=  '</div>';
                               }
//                            if($dataLook->lookup_value == 'LAIN-LAIN'){
//                                    $html .= '<div class="controls">';
//                                       $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($modAsesmenkebutuhanEdukasidetT,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i, 'onchange'=>'setChangeDetEdukasiLain(this)')).' <label>'.$dataLook->lookup_name.'</label> ';
//                                       $html .= $form->hiddenField($modAsesmenkebutuhanEdukasidetT, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
//                                       $html .= $form->textField($modAsesmenkebutuhanEdukasidetT, '['.$i.']edukasipasien_lainnya', array('class' => 'span3','readonly'=>true));
//                                       $html .=  '</div>';
//                               }else{
//                                   $html .= '<div class="controls">';
//                                       $html .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $form->checkbox($modAsesmenkebutuhanEdukasidetT,'['.$i.']isedukasipasien',array('class'=>'', 'text_id'=>$i)).' <label>'.$dataLook->lookup_name.'</label> ';
//                                       $html .= $form->hiddenField($modAsesmenkebutuhanEdukasidetT, '['.$i.']edukasipasien', array('value'=>$dataLook->lookup_value,'class' => 'span3'));
//                                       $html .=  '</div>';
//                               }
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
                 <?php  if ($hide == false){ ?>
                 <?php echo $form->hiddenField($modAsesmenkebutuhanEdukasiT, 'kesediaanmenerimaedukasi_alasantidak', array('placeholder'=>'Alasan tidak bersedia','class' => 'span3','readonly'=>true)); ?>

                 <div class="control-group ">
                    <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'kesediaanmenerimaedukasi_status', array('class'=>'control-label')) ?>
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
                <?php echo $form->dropDownListRow($modAsesmenkebutuhanEdukasiT, 'pendidikan_id', CHtml::listData(PendidikanM::model()->findAll('pendidikan_aktif = true'), 'pendidikan_id', 'pendidikan_nama'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
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
                    <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bahasaasing_nama', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <label>Jenis Bahasa Asing </label>&nbsp;&nbsp;&nbsp;
                        <?php echo $form->textField($modAsesmenkebutuhanEdukasiT, 'bahasaasing_nama', array('class' => 'span3')); ?>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo $form->radioButtonList($modAsesmenkebutuhanEdukasiT,'bahasaasing_kemampuan',array('Aktif'=>'Aktif','Pasif'=>'Pasif') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
             <div class="col-md-6">
               <?php  if ($hide == false){ ?>
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
                 <div class="control-group">
                    <?php echo $form->labelEx($modAsesmenkebutuhanEdukasiT,'bahasaisyarat_status', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'bahasaisyarat_status',array('value'=>'Ada','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?> <label>Ada</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $form->radioButton($modAsesmenkebutuhanEdukasiT,'bahasaisyarat_status',array('value'=>'Tidak Ada','onkeypress'=>"return $(this).focusNextInputField(event);",'uncheckValue'=>null)); ?>  <label>Tidak Ada</label>
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
                <?php } ?>
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
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','onclick'=>'simpanAllDataAnak();')); //RND-8620
                            // echo "&nbsp;";
                            //  echo CHtml::link(Yii::t('mds', '{icon} Cetak Asesmen Awal Keperawatan', array('{icon}'=>'<i class="icon-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-default','disabled'=>true));
                    }
            ?>
    </div>
</div>
