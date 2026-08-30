<?php
if (isset($modPengambilanSample->kirimsamplelab_id)) {
    $modKirimSample = LBKirimSampleLabT::model()->findByAttributes(array('kirimsamplelab_id' => $modPengambilanSample->kirimsamplelab_id));
} else {
    $modKirimSample = new LBKirimSampleLabT;
}
?>
<tr>
    <td>
          <div class="col-sm-12" style="text-align:right;">
            <?php
                echo CHtml::htmlButton("<i class='icon icon-white icon-minus'></i>", array('onclick' => isset($modPengambilanSample->pengambilansample_id) ? 'hapusRowSample(this,' . $modPengambilanSample->pengambilansample_id . ');return false;' : 'hapusRowSample(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan data sample', 'class' => 'btn btn-danger'));
            ?>
        </div>
        </div>
        <div class="clear"></div>
        <div class="col-sm-6">        
            
            <?php echo $form->radioButtonListInlineRow($modPengambilanSample,  '[' . $i . ']kualitassample', array('laik'=>'laik', 'tidak laik'=>'tidak laik'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modPengambilanSample, '[' . $i . ']samplelab_id', CHtml::listData($modPengambilanSample->getSampleLabItems(), 'samplelab_id', 'samplelab_nama'), array('autofocus' => true, 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($modPengambilanSample, '[' . $i . ']tglpengambilansample', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengambilanSample,
                        'attribute' => '[' . $i . ']tglpengambilansample',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPengambilanSample, '[' . $i . ']tglpengambilansample'); ?>
                </div>
            </div>
            <?php // echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']pengambilansample_id', array('readonly' => true,)); ?>
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']no_pengambilansample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']jmlpengambilansample', array('class' => 'span3 numbers-only')); ?> 
            <div class="control-group ">
                <?php echo $form->labelEx($modPengambilanSample, '[' . $i . ']tglkirimsample', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modPengambilanSample,
                        'attribute' => '[' . $i . ']tglkirimsample',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPengambilanSample, '[' . $i . ']tglkirimsample'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']tempatsimpansample', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modPengambilanSample, '[' . $i . ']keterangansample', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']antibiotikygdiberi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                 <?php echo $form->labelEx($modPengambilanSample, '[' . $i . ']antibiotik_hari', array('class' => 'control-label')) ?>
                <div class="controls">
            <?php echo $form->textField($modPengambilanSample, '[' . $i . ']antibiotik_hari', array('class' => 'span2 numbers-only')); echo'  Hari'; ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modPengambilanSample, '[' . $i . ']alatmedis_id', CHtml::listData(LBAlatmedisM::getAlatLabItems(), 'alatmedis_id', 'alatmedis_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
            
        </div>
        <div class="clear"></div>
      
        <p>&nbsp;</p>
        <div class="col-sm-12"> 
        </div>
            <?php
            if (isset($modPengambilanSample->pengambilansample_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcode();return false"));
                echo '&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Print QR Code Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printQr();return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                echo '&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Print QR Code Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
            }

            ?>
           <hr style="background:red;height:1px;" />
   
        
    </td>
</tr>
<script type="text/javascript">
    /**
     * Link Print Label 
     */
    function printStatusLabel(pendaftaran_id, pengambilansample_id)
    {
        window.open('<?php echo $this->createUrl('/laboratoriumPA/pendaftaranLaboratorium/printStatusLabel'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    } 
    
    function printBarcode()
    {
        var pengambilansample_id = '<?php echo isset($modPengambilanSample->pengambilansample_id) ? $modPengambilanSample->pengambilansample_id: '' ?>';
        if (pengambilansample_id != "") {
            window.open('<?php echo $this->createUrl('printBarcodeSample'); ?>&pengambilansample_id=' + pengambilansample_id, 'printwin', 'left=100,top=0,width=768,height=640');
        } else {
            myAlert("Tidak Ada Data Pasien");
        }
    }
    
    function printQr() {
        var pengambilansample_id = '<?php echo isset($modPengambilanSample->pengambilansample_id) ? $modPengambilanSample->pengambilansample_id: '' ?>';
        if (pengambilansample_id != "") {
            window.open('<?php echo $this->createUrl('printQrSample'); ?>&pengambilansample_id=' + pengambilansample_id, 'printwin', 'left=100,top=0,width=768,height=640');
        } else {
            myAlert("Tidak Ada Data Pasien");
        }

    }
    
    $(document).ready(function() {
	$("#LBPengambilanSampleT_0_kualitassample_0").prop("checked", true); // true or false
    });
</script>
