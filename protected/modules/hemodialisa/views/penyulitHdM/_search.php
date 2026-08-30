<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
        ));
?>
<br>
<div class="row-fluid">
    <div class="row-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Penyulit HD Nama <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penyulit_hd_nama', array('class' => 'span3', 'maxlength' => 200, 'onkeyup'=>"namaLain(this)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Penyulit HD Nama Lainnya <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penyulit_hd_namalainnya', array('class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div><br>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onClick'=>'return cekForm();')); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . MyIcon::getIcons('ulang') . '"></i>')), Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create'), array('class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang data ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            ?>        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    function cekForm() {
        var nama = $('#PenyulitHdM_penyulit_hd_nama').val();
        var namalain = $('#PenyulitHdM_penyulit_hd_namalainnya').val();

        if (nama === '' || namalain === '') {
            myAlert('Silakan isi yang bertanda bintang <span class="required">*</span> untuk melakukan pencarian data !');
        } 
    }
    
    function namaLain(nama)
    {
        document.getElementById('PenyulitHdM_penyulit_hd_namalainnya').value = nama.value.toUpperCase();
    }
</script>