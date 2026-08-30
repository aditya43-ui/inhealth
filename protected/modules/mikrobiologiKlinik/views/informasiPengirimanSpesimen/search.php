<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pengiriman-spesimen-r-search',
    'type' => 'horizontal',
        ));
$format = new MyFormatter();
?>
<style>
    .btn-group .dropdown-toggle {
        width: 117% !important;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Pendaftaran", 'waktu_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("No. Pengiriman", 'no_kirimspesimen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'no_kirimspesimen', array('placeholder' => 'Ketik Nomor Pengiriman', 'class' => 'span3')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Ruangan", 'ruanganasal_id', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE order by ruangan_nama"), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",  'multiple' => 'multiple')); ?>				 
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Petugas Pengiriman", 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Ketik Nama Petugas Pengirim', 'class' => 'span3 custom-only')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Status Pengiriman", 'status', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'status', array('Belum Diterima' => 'Belum Diterima', 'Sudah Diterima' => 'Sudah Diterima'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp;";
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function () {
        var ruangantujuan = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');

        jQuery(ruangantujuan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>