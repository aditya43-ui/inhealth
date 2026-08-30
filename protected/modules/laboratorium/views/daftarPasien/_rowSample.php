<?php
if (isset($modPengambilanSample->kirimsamplelab_id)) {
    $modKirimSample = LBKirimSampleLabT::model()->findByAttributes(array('kirimsamplelab_id' => $modPengambilanSample->kirimsamplelab_id));
} else {
    $modKirimSample = new LBKirimSampleLabT;
    $modKirimSample->nokirimsample = '- Otomatis-';

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
            
            <?php echo $form->dropDownListRow($modPengambilanSample, '[' . $i . ']samplelab_id', CHtml::listData($modPengambilanSample->getSampleLabItems(), 'samplelab_id', 'samplelab_nama'), array('autofocus' => true, 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            <div class="control-group">
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
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                    <?php echo $form->error($modPengambilanSample, '[' . $i . ']tglpengambilansample'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']pengambilansample_id', array('readonly' => true,)); ?>
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']no_pengambilansample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']jmlpengambilansample', array('class' => 'span3')); ?>

        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']tempatsimpansample', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textAreaRow($modPengambilanSample, '[' . $i . ']keterangansample', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modPengambilanSample, '[' . $i . ']alatmedis_id', CHtml::listData(LBAlatmedisM::getAlatLabItems(), 'alatmedis_id', 'alatmedis_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>

        </div>
        <div class="clear"></div>
      
        <p>&nbsp;</p>
        <div class="col-sm-12">
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'content' => array(
                'content-kirimsample-'.$i => array(
                    'header' => '<b>Kirim Sampel</b>',
                    'isi' => $this->renderPartial($this->path_view . '_formKirimSample', array(
                        'form' => $form,
                        'modKirimSample' => $modKirimSample,
                        'i' => $i
                            ), true),
                    'active' => false,
                ),
            )       
            ));
        ?>  
        </div>

            <?php
            if (isset($modPengambilanSample->pengambilansample_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusLabel('" . $_GET['pendaftaran_id'] . "&pengambilansample_id=$modPengambilanSample->pengambilansample_id');return false", 'disabled' => FALSE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
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
        window.open('<?php echo $this->createUrl('/laboratorium/pendaftaranLaboratorium/printStatusLabel'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
</script>
