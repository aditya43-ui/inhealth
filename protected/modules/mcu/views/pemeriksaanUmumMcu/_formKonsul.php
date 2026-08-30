<div class="panel-body">
    <div class="col-sm-12">
        <div class="control-group">
        <?php echo Chtml::label('Lanjut ke Poli','',array('class'=>'control-label')); ?>
            <div class="controls">
               <?php echo CHtml::activeCheckBox($modpemeriksaanumum,'is_konsul',array('onclick'=>'cekkonsul();')); ?>
            </div>
        </div>
            <div class="control-group">
                <?php echo $form->labelEx($modKonsul,'tglkonsulpoli', array('class'=>'control-label')) ?>
                <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                <div class="controls">
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modKonsul,
                            'attribute'=>'tglkonsulpoli',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2'),
                        ));
                    ?>
                </div>
            </div>
            <?php 
            $ruang_drop = $modKonsul->getRuanganInstalasi();
            echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData($ruang_drop, 'ruangan_id', 'ruangan_nama'),
                array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'setTarif()')); ?>
     
            <?php echo $form->dropDownListRow($modKonsul,'pegawai_id', CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modKonsul,'catatan_dokter_konsul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>        
    </div>
</div>
<script>
function cekkonsul() {
    
     if($("#McuPemeriksaanumumT_is_konsul").is(':checked')){
         $('#KonsulpoliT_tglkonsulpoli').attr('disabled',false);
         $('#KonsulpoliT_ruangan_id').attr('disabled',false);
         $('#KonsulpoliT_pegawai_id').attr('disabled',false);
         $('#KonsulpoliT_catatan_dokter_konsul').attr('disabled',false);
     }else{
         $('#KonsulpoliT_tglkonsulpoli').attr('disabled',true);
         $("#KonsulpoliT_tglkonsulpoli").find(".add-on").hide();
         $('#KonsulpoliT_ruangan_id').attr('disabled',true);
         $('#KonsulpoliT_pegawai_id').attr('disabled',true);
         $('#KonsulpoliT_catatan_dokter_konsul').attr('disabled',true);
     }
}    
</script>
