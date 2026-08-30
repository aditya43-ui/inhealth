<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'permintaanDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));

        $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="col-sm-12">
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Terima", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modPenyiapanDarah,
                'attribute' => 'tgl_terimadarah',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Petugas Penerima", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
                echo $form->dropDownList($modPenyiapanDarah, 'peg_penerimapermintaan_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif is true and kelompokpegawai_id in (1,2)'), 'pegawai_id', 'namaLengkap'), ['class' => 'span3 searchDropdown', 'empty' => '-- Pilih --']);
            ?>
        </div>
    </div>
</div>
<div class="form-action">
    <?php 
         echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
         echo "&nbsp;";
    ?>
</div>
<?php $this->endWidget(); ?>

<script>
    $(function(){
        var dropdown  = jQuery('.searchDropdown');
     
        jQuery(dropdown).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '282px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>