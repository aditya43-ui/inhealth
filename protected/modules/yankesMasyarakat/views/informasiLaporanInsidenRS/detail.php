<style>
    .control-label-left {
      float: left;
      width: 140px;
      padding-top: 5px;
      text-align: left;
    }
    
    .control-label-left-margin {
        margin-left: 15px;  
        float: left; 
        width: 125px; 
        padding-top: 5px; 
        text-align: left;
    }
</style>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('1. Tanggal Pelaporan <span class="required">*</span>', 'insidenrs_tgllapor', array('class' => 'control-label-left required')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'insidenrs_tgllapor',array('disabled'=>true, 'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('2. Tanggal dan Waktu Insiden <span class="required">*</span>', 'insidenrs_tglinsiden', array('class' => 'control-label-left required')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'insidenrs_tglinsiden',array('disabled'=>true, 'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('3. Insiden <span class="required">*</span>', 'insidenrs_tglinsiden', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php echo $form->textField($model,'insidenrs_nama',array('disabled'=>true, 'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('4. Kronologis <span class="required">*</span>', 'insidenrs_kronologis', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php echo $form->textArea($model,'insidenrs_kronologis',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('5. Jenis Insiden <span class="required">*</span>', 'insidenrs_jenis', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php echo $form->dropDownList($model,'insidenrs_jenis',LookupM::getItems('jenisinsiden'), 
                                              array( 'empty'=>'-- Pilih --', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                    'class'=>'span3 required')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('6. Orang yang Pertama Melaporkan <span class="required">*</span>', 'insidenrs_pelapor', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php echo $form->dropDownList($model,'insidenrs_pelapor',LookupM::getItems('pelaporinsidenpertama'), 
                                              array('empty'=>'-- Pilih --', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                    'class'=>'span3 required')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('7. Insiden yang menyangkut pasien', 'insidenrs_menyangkutpasien', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php echo $form->dropDownList($model,'insidenrs_menyangkutpasien',LookupM::getItems('jenispasien'), 
                                              array( 'empty'=>'-- Pilih --', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                    'class'=>'span3 required')); ?>
            </div>
        </div>
        <div class="control-group">

            <?php echo CHtml::label('8. Ruangan Kejadian <span class="required">*</span>', 'lokasikejadian_id', array('class' => 'control-label-left required')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'lokasikejadian_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'placeholder'=>'unit kerja')); ?>
                <?php 
                 if (!empty($model->lokasikejadian_id)) {
                     $ruangan = RuanganM::model()->findByPk($model->lokasikejadian_id);
                     $model->lokasikejadian_nama = $ruangan->ruangan_nama;
                 }
                    echo $form->textField($model, 'lokasikejadian_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'placeholder'=>'unit kerja')); ?>
            </div>
        </div>
         <div class="control-group">
            <?php echo CHtml::label('Mengetahui Kepala Unit Kejadian', 'mengetahui_nama', array('class' => 'control-label-left-margin required')) ?>
            <div class="controls"> 
                 <?php echo $form->textField($model,'mengetahui_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
        <?php echo CHtml::label('Mengetahui Kepala Instalasi', 'mengetahui_kepalainstalasi_kejadian_nama', array('class' => 'control-label-left-margin required')) ?>
        <div class="controls"> 
             <?php echo $form->textField($model,'mengetahui_kepalainstalasi_kejadian_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
        <div class="control-group">
            <?php echo CHtml::label('9. Ruangan Penyebab <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'control-label-left required')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'ruanganpenyebab_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'placeholder'=>'unit kerja')); ?>
                <?php 
                 if (!empty($model->ruanganpenyebab_id)) {
                     $unit = RuanganM::model()->findByPk($model->ruanganpenyebab_id);
                     $model->ruanganpenyebab_nama = $unit->ruangan_nama;
                 }
                    echo $form->textField($model, 'ruanganpenyebab_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'placeholder'=>'unit kerja')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Mengetahui Kepala Unit Penyebab', 'mengetahui_kepalaunitpenyebab_nama', array('class' => 'control-label-left-margin required')) ?>
            <div class="controls"> 
                 <?php echo $form->textField($model,'mengetahui_kepalaunitpenyebab_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Mengetahui Kepala Instalasi', 'mengetahui_kepalainstalasi_penyebab_nama', array('class' => 'control-label-left-margin required')) ?>
            <div class="controls"> 
                 <?php echo $form->textField($model,'mengetahui_kepalainstalasi_penyebab_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('10. Akibat Insiden <span class="required">*</span>', 'insidenrs_akibat', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php 
                     echo $form->dropDownList($model,'insidenrs_akibat',LookupM::getItems('akibatinsiden'), 
                                              array('empty'=>'-- Pilih --', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                    'class'=>'span3 required')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('11. Tindakan yang dilakukan setelah kejadian <span class="required">*</span>', 'tindakan_setelah', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php echo $form->textArea($model,'tindakan_setelah',array('class'=>'span3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('12. Tindakan dilakukan oleh <span class="required">*</span>', 'tindakan_oleh', array('class' => 'control-label-left required')) ?>
            <div class="controls"> 
                <?php  echo $form->checkBox($model,'tindakan_olehdokter',array('value'=>1,'uncheckValue'=>0, 'disabled'=>true)); ?> <label>Dokter</label>
                <?php  echo $form->checkBox($model,'tindakan_olehperawat',array('value'=>1,'uncheckValue'=>0, 'disabled'=>true)); ?> <label>Perawat</label>
                <?php  echo $form->checkBox($model,'tindakan_olehpetugaslain',array('value'=>1,'uncheckValue'=>0,'onclick'=>'setTindakanLainnya();', 'disabled'=>true)); ?> <label>Petugas Lainnya</label>
                <br>

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(' ', 'tindakan_olehlainnya', array('class' => 'control-label-left')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'tindakan_olehlainnya',array('class'=>'span3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group kejadian">
            <?php echo CHtml::label('13. Kejadian yang sama terjadi di unit lain <span class="required">*</span>', 'terjadiunitlain', array('class' => 'control-label-left')); ?>
            <div class='controls'>
                <?php 
                    $model->terjadiunitlain = ($model->terjadiunitlain == 1 ) ? "Ya" : "Tidak";
                    echo $form->textField($model,'terjadiunitlain',array('class'=>'span3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('14. Tindakan yang dilakukan pada unit tersebut untuk pencegahan', 'tindakan_pencegahan', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <?php echo $form->textArea($model,'tindakan_pencegahan',array('class'=>'span3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('15. Tipe Insiden', 'tipeinsiden', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
               <?php 
                $cekDetail = InsidenrsdetT::model()->findByAttributes(array('insidenrs_id'=>$model->insidenrs_id));
                if(!empty($cekDetail)){
                $cektipeinsiden = SubtipeinsidenM::model()->findByAttributes(array('subtipeinsiden_id'=>$cekDetail->subtipeinsiden_id));
                $model->tipeinsiden = $cektipeinsiden->tipeinsiden->tipeinsiden_id;
                }
                echo Chtml::activeDropDownList($model,'tipeinsiden',Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif'=>true)),'tipeinsiden_id','tipeinsiden_nama'),array('disabled'=>true,'class'=>'span3','empty'=>'-- Pilih --','onchange'=>'setTipeInsiden();')); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('16. Sub Tipe Insiden', 'tipetindakan', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <table id="table-insiden" class="table table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <td colspan="2">Subtipe Insiden</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($model->insidenrs_id)){                                                                                        
                                $cekInsiden = InsidenrsdetT::model()->findAllByAttributes(array('insidenrs_id'=>$model->insidenrs_id));
                                foreach($cekInsiden as $i => $det){                                                                                               
                                    echo $this->renderPartial($this->path_view.'_rowDetail',array('modInsiden'=>$det, 'i'=>$i));
                                }                                                                                       
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>