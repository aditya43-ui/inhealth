<?php
if (isset($modPengambilanSample->kirimsamplelab_id)) {
    $modKirimSample = BDKirimSampleLabT::model()->findByAttributes(array('kirimsamplelab_id' => $modPengambilanSample->kirimsamplelab_id));
} else {
    $modKirimSample = new BDKirimSampleLabT;
}
?>
<tr>
    <td>
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
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($modPengambilanSample, '[' . $i . ']tglpengambilansample'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']pengambilansample_id', array('readonly' => true, 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']no_pengambilansample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php // echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']jmlpengambilansample', array('class' => 'span1 integer')); 
        ?>
        <div class="control-group">
            <label class="control-label">Jumlah Sampel <span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->textField($modPengambilanSample, '[' . $i . ']jmlpengambilansample', array('class' => 'span1 integer')); ?>
                <?php
                echo $form->dropDownList($modPengambilanSample, '[' . $i . ']satuansampellab', LookupM::getItems('satuansampellab'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'));
                ?>
            </div>
        </div>


        <?php echo $form->textFieldRow($modPengambilanSample, '[' . $i . ']tempatsimpansample', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($modPengambilanSample, '[' . $i . ']keterangansample', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($modPengambilanSample, '[' . $i . ']alatmedis_id', CHtml::listData(BDAlatmedisM::getAlatLabItems(), 'alatmedis_id', 'alatmedis_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
    </td>
    <td>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'content' => array(
                'content-kirimsample' . $i => array(
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
    </td>
    <td>
        <?php
        echo CHtml::htmlButton("<i class='icon icon-white icon-minus'></i>", array('onclick' => isset($modPengambilanSample->pengambilansample_id) ? 'hapusRowSample(this,' . $modPengambilanSample->pengambilansample_id . ');return false;' : 'hapusRowSample(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan data sample', 'class' => 'btn btn-danger'));
        ?>
        <?php
        if (isset($modPengambilanSample->pengambilansample_id)) {
            echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusLabel('" . $_GET['pendaftaran_id'] . "&pengambilansample_id=$modPengambilanSample->pengambilansample_id');return false", 'disabled' => FALSE));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        }
        ?>
    </td>
</tr>
<script type="text/javascript">
    /**
     * Link Print Label 
     */
    function printStatusLabel(pendaftaran_id, pengambilansample_id) {
        window.open('<?php echo $this->createUrl('/bankDarah/pendaftaranBankDarah/printStatusLabel'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
</script>