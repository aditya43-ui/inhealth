<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Grading <span class="required">*</span>', 'tgl_gradingunit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$grading,
                            'attribute'=>'tgl_gradingunit',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'changeYear' => false,
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker2 span3','onkeyup' => "return $(this).focusNextInputField(event)"),

            )); ?>
                
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang <span class="required">*</span>', 'peluang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($grading, 'peluang_id', 
                                PeluangM::model()->getListPeluang(), array(
                                'empty'=>'-- Pilih --',
                                    'class'=>'span3',                                     
                                    'onblur' => 'setTindakan()',
                                    'ajax' => array('type'=>'POST',
                                        'url'=> $this->createUrl('/actionDynamic/GetKonsekuensi',array('encode'=>false,'namaModel'=>get_class($model))), 
                                        'success'=>'function(data){$("#'.CHtml::activeId($grading, "konsekuensi_id").'").html(data); }',
           
                            ))); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi <span class="required">*</span>', 'konsekuensi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($grading, 'konsekuensi_id', 
                                KonsekuensiM::model()->getListNamaKonsekuensi(), array(
                                'empty'=>'-- Pilih --',
                                    'class'=>'span3', 
                                    'onblur' => 'setTindakan()',
                                    'ajax' => array('type'=>'POST',
                                        'url'=> $this->createUrl('/actionDynamic/GetTingkatRisiko',array('encode'=>false,'namaModel'=>get_class($model))), 
                                        'success'=>'function(data){$("#'.CHtml::activeId($grading, "tingkatrisiko_id").'").html(data); setTindakan(); }',
                  
                ))); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($grading, 'skor_risiko', array('class' => 'span3', 'readonly' => true))?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Risiko <span class="required">*</span>', 'tingkatrisiko_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($grading,'tingkatrisiko_id', Chtml::listData(TingkatrisikoM::model()->findAllByAttributes(array('tingkatrisiko_aktif' => true)),'tingkatrisiko_id','tingkatrisiko_nama'), array(
                                    'empty'=>'-- Pilih --',
                                    'class'=>'span3', 
                                     'readonly'=>true,
                                    'onblur' => 'setTindakan()',
                                    'ajax' => array('type'=>'POST',
                                        'url'=> $this->createUrl('/actionDynamic/GetWarnaRisiko',array('encode'=>false,'namaModel'=>get_class($grading))), 
                                        'success'=>'function(data){$("#'.CHtml::activeId($grading, "regradingrisiko").'").html(data); }',
                                    ),
                                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Grading Risiko Kejadian <span class="required">*</span>','regradingrisiko',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->dropDownList($grading, 'regradingrisiko', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'tingkatwarna_risiko')), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'readonly'=>true,)); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tindakan <span class="required">*</span>', 'tindakan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($grading,'tindakan',array('class'=>'span3 required', 'rows'=>5, 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tindak Lanjut', 'tindaklanjut', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($grading,'tindaklanjut',array('class'=>'span3', 'rows'=>4, 'readonly'=>false)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Grader <span class="required">*</span>','grader2',array('class'=>'control-label'));?>
            <div class="controls">
                <?php 
                $pegawai = Yii::app()->user->getState('pegawai_id');
                $cekPegawai = PegawaiM::model()->findByPk($pegawai);
                $grading->grader2 = $cekPegawai->pegawai_id;
                
                echo $form->textField($grading, 'grader_nama', array('value' => $cekPegawai->namaLengkap, 'class' => 'span3 required', 'disabled' => true ,'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>
    
<div class="form-action">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
</div>
<script type="text/javascript">
    function setTindakan(){
        var risiko = $("#GradinginsidenrsT_tingkatrisiko_id").val();
        var peluang = $("#GradinginsidenrsT_peluang_id").val();
        var konsekuensi = $("#GradinginsidenrsT_konsekuensi_id").val();
        
        if (risiko != ''){
            $.ajax({
                type:'POST',
                data: {risiko : risiko, peluang:peluang, konsekuensi:konsekuensi},
                url:'<?php echo $this->createUrl('generateTindakan'); ?>',
                dataType: "json",
                success:function(data) {
                    if (data.ok != 1) {
                        toastr.warning(data.msg);
                        $("#GradinginsidenrsT_tindakan").val("");
                        return false;
                    }
                    $("#GradinginsidenrsT_skor_risiko").val(data.skor);
                    $("#GradinginsidenrsT_tindakan").val(data.tingkatrisiko_tindakan);
                    $("#GradinginsidenrsT_regradingrisiko").val(data.tingkatrisiko_warna);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert('Tidak ada data tingkat risiko');
            $("#GradinginsidenrsT_tindakan").val("");
            return false;
        }
    }
    
</script>