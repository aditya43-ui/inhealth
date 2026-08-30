<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasipendonor-r-search',
    'type' => 'horizontal',
        ));
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5'));  ?>
<style>
    .form-horizontal .control-label{
        width: 150px;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php /*
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Pendaftaran",'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
         */?>
        <div class = "control-group">
            <?php echo Chtml::label("No. Registrasi Donor Darah", 'no_pendonor', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'no_pendonor', array('class' => 'custom-only span4', 'placeholder' => 'Ketik No. Registrasi Donor Darah')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Donor", 'nama_lengkap', array('class' => 'control-label')) ?>
            <div class = "controls">

                <?php echo $form->textField($model,'nama_lengkap',array('class'=>'custom-only span4','placeholder'=>'Ketik Nama Donor')) ?>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Kelamin", 'jenis_kelamin', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'jenis_kelamin', LookupM::getItems("jeniskelamin"), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'gol_darah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Rhesus", 'rhesus', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model, 'rhesus', array('Positif' => 'Positif', 'Negatif' => 'Negatif'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp;";
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
