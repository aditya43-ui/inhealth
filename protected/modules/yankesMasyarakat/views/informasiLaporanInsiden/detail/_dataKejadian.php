<style>
    .alig{
      text-align:left !important;   
    }
</style>
<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label('1.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Tanggal Pelaporan <span class="required">*</span>', 'insidenrs_tgllapor', array('class' => 'control-label required alig')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'insidenrs_tgllapor',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,'disabled'=>true,'class'=>'dtPicker2-5 span3 required',
                                        'placeholder'=>'Pilih Tanggal Pelaporan',
                                    ),
                                )); 
                                ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('2.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Tanggal dan Waktu Insiden <span class="required">*</span>', 'insidenrs_tglinsiden', array('class' => 'alig control-label required')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'insidenrs_tglinsiden',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                        'disabled'=>true,
                                        'class'=>'dtPicker2-5 span3 required',
                                        'placeholder'=>'Pilih Tanggal Insiden',
                                    ),
                                )); 
                                ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('3.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Insiden <span class="required">*</span>', 'insidenrs_tglinsiden', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php echo $form->textField($model,'insidenrs_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('4.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Kronologis <span class="required">*</span>', 'insidenrs_kronologis', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model,'insidenrs_kronologis',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('5.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Jenis Insiden <span class="required">*</span>', 'insidenrs_jenis', array('class' => 'control-label required alig')) ?>
        <div class="controls"> 
            <?php echo $form->dropDownList($model,'insidenrs_jenis',LookupM::getItems('jenisinsiden'), 
                                          array( 'disabled'=>true,'empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3 required')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('6.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Orang yang Pertama Melaporkan <span class="required">*</span>', 'insidenrs_pelapor', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php echo $form->dropDownList($model,'insidenrs_pelapor',LookupM::getItems('pelaporinsidenpertama'), 
                                          array('disabled'=>true,'empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3 required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('7.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Insiden yang menyangkut pasien', 'insidenrs_menyangkutpasien', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php echo $form->dropDownList($model,'insidenrs_menyangkutpasien',LookupM::getItems('jenispasien'), 
                                          array( 'disabled'=>true,'empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3 required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('8.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Ruangan Kejadian<span class="required">*</span>', 'lokasikejadian_id', array('class' => 'alig control-label required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'lokasikejadian_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutoCompleteRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            inputRuangan(ui.item.lokasikejadian_id);
                            return false;
                        }',
                ),
                'htmlOptions' => array('disabled'=>true,'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikan nama ruangan',
                    'onblur' => 'if($(this).val()==""){clearRuangan();}',
                ),
            ));
            echo CHtml::activeHiddenField($model, 'lokasikejadian_id', array('class' => 'span3 ', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <label class="control-label alig">Unit Kerja Kejadian</label>
        <div class="controls">
            <?php echo $form->textField($model, 'unitkerja', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'placeholder'=>'unit kerja')); ?>
            <?php echo $form->hiddenField($model, 'unitkerjatempat_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'placeholder'=>'unit kerja')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Mengetahui Atasan Kejadian', 'mengetahui_nama', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
             <?php echo $form->textField($model,'mengetahui_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Mengetahui Kepala Instalasi', 'mengetahui_kepalainstalasi_kejadian_nama', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
             <?php echo $form->textField($model,'mengetahui_kepalainstalasi_kejadian_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('9.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Ruangan Penyebab <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'alig control-label required')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'ruangan_nama', array('disabled' => true, 'class' => 'span3', 'value' => $model->ruanganpenyebab->ruangan_nama)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Unit Kerja Penyebab <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'alig control-label required')) ?>
        <div class="controls">
        <?php
            echo CHtml::activeHiddenField($model, 'unitkerjapenyebab_id', array('class' => 'span3', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'unitkerjapenyebab_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteUnitKerja') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.unitkerjapenyebab_nama);
                            $("#InsidenrsT_unitkerjapenyebab_id").val( ui.item.unitkerjapenyebab_id );
                            return false;
                        }',
                ),
                'htmlOptions' => array('disabled'=>true,'onkeypress' => "return $(this).focusNextInputField(event)",  'class' => 'span3', 'placeholder' => 'Pilih Nama Unit Kerja Penyebab',
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Mengetahui Atasan Penyebab', 'mengetahui_kepalaunitpenyebab_nama', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
             <?php echo $form->textField($model,'mengetahui_kepalaunitpenyebab_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Mengetahui Kepala Instalasi', 'mengetahui_kepalainstalasi_penyebab_nama', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
             <?php echo $form->textField($model,'mengetahui_kepalainstalasi_penyebab_nama',array('disabled'=>true,'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('10.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Akibat Insiden Terhadap Pasien<span class="required">*</span>', 'insidenrs_akibat', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php 
                 echo $form->dropDownList($model,'insidenrs_akibat',LookupM::getItems('akibatinsiden'), 
                                          array('disabled'=>true,'empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3 required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('11.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Tindakan yang dilakukan setelah kejadian <span class="required">*</span>', 'tindakan_setelah', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model,'tindakan_setelah',array('disabled'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('12.', '', array('class' => 'alig control-label ','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Tindakan dilakukan oleh <span class="required">*</span>', 'tindakan_oleh', array('class' => 'alig control-label required')) ?>
        <div class="controls"> 
            <?php  echo $form->checkBox($model,'tindakan_olehdokter',array('disabled'=>true,'value'=>1,'uncheckValue'=>0,)); ?> <label>Dokter</label>
            <?php  echo $form->checkBox($model,'tindakan_olehperawat',array('disabled'=>true,'value'=>1,'uncheckValue'=>0,)); ?> <label>Perawat</label>
            <?php  echo $form->checkBox($model,'tindakan_olehpetugaslain',array('disabled'=>true,'value'=>1,'uncheckValue'=>0,'onclick'=>'setTindakanLainnya();')); ?> <label>Petugas Lainnya</label>
            <br>  
        </div>
    </div>
    
    <?php if($model->tindakan_olehpetugaslain == true){ ?>
    <div class="control-group">
        <?php echo CHtml::label(' ', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label(' ', 'tindakan_olehlainnya', array('class' => 'control-label alig')) ?>
        <div class="controls">
            <?php echo $form->textField($model,'tindakan_olehlainnya',array('disabled'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <?php } ?>
</div>
<div class="span6">
    <div class="control-group kejadian">
        <?php echo CHtml::label('13.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Kejadian yang sama terjadi di unit lain <span class="required">*</span>', 'terjadiunitlain', array('class' => 'control-label alig')); ?>
        <div class='controls'>
            <?php echo $form->checkBox($model, 'terjadiunitlain_ya', array(($model->terjadiunitlain_ya != "") ? ' ' : 'checked' => false, 'disabled'=>true, 'class' => 'pilih required')); ?> <label>Ya</label> 
            <?php echo $form->checkBox($model, 'terjadiunitlain_tidak', array('disabled'=>true, 'class' => 'required')); ?> <label>Tidak</label>                        
        </div>
    </div>
    <div class="control-group kejadian">
        <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Kapan', 'kejadian_diunitlain', array('class' => 'control-label alig')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'kejadian_diunitlain',array('disabled'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('14.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Langkah/Tindakan apa yang telah diambil pada Unit Kerja tersebut untuk mencegah terulang kejadian yang sama?', 'tindakan_pencegahan', array('class' => 'control-label alig')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model,'tindakan_pencegahan',array('disabled'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100, 'rows'=>4)); ?> 
        </div>
    </div>
    <div class="control-group">
         <?php echo CHtml::label('15.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Tipe Insiden', 'tipeinsiden', array('class' => 'control-label alig')) ?>
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
        <?php echo CHtml::label('16.', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
        <?php echo CHtml::label('Sub Tipe Insiden', 'tipetindakan', array('class' => 'control-label alig')) ?>
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
                                echo $this->renderPartial($this->path_detail.'/_rowDetail',array('modInsiden'=>$det, 'i'=>$i));
                            }                                                                                       
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

