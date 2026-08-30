<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'konfigtemplatesurat-k-search',
    'type' => 'horizontal',
        ));
?>

<div class="row-fluid">

    <div class="col-md-6">
        <div class="control-group">
            <?php
            echo CHtml::label("Jenis Dokumen", "", array(
                'class' => 'control-label'
            ));
            ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenissurat_id', CHtml::listData(JenisSuratM::model()->findAll('jenissurat_aktif IS TRUE AND modul_id = '.Params::MODUL_ID_PENGADAAN.'  order by jenissurat_id DESC'), 'jenissurat_id', 'jenissurat_nama'), array('empty'=>'-- Pilih --','class' => 'span3 jenisform required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
            </div>   
        </div>
        <div class="control-group">
            <?php
            echo CHtml::label("Nama Template Dokumen", "", array(
                'class' => 'control-label'
            ));
            ?>
            <div class="controls">
                <?php echo $form->textField($model, 'konfigtemplatesurat_nama', array('class' => 'span4')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_lain', array('class' => 'span4')); ?>
        <?php echo $form->textAreaRow($model, 'konfigtemplatesurat_isi', array('rows' => 6, 'cols' => 25, 'class' => 'span4')); ?>

        `   </div>
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model, 'keterangan', array('class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'urutan', array('class' => 'span4')); ?>
        <div class="control-group">
            <?php
            echo CHtml::label("", "", array(
                'class' => 'control-label'
            ));
            ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'konfigtemplatesurat_aktif', array('checked' => 'checked')) . "Aktif"; ?>
            </div>
        </div>

    </div>
</div>



<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('admin') . '";}); return false;')) . "&nbsp;";
    ?>
</div>

<?php $this->endWidget(); ?>
