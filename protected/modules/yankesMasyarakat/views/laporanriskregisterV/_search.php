<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'POST',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        ));

$format = new MyFormatter();
?>
<style>
    table{
        margin-bottom: 0px;
    }
    .form-actions{
        padding:4px;
        margin-top:5px;
    }
    .nav-tabs>li>a{display:block; cursor:pointer;}
    .nav-tabs > .active a:hover{cursor:pointer;}
</style>
<div class="row-fluid">
    <?php echo CHtml::hiddenField('type', ''); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Periode Manajemen Resiko', '', array('class' => 'control-label', 'style' => 'width:145px')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'perioderiskregister_id', CHtml::listData($model->getPeriodeResikoItems(), 'perioderiskregister_id', 'nama_perioderiskregister'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sumber Resiko', '', array('class' => 'control-label', 'style' => 'width:145px')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'sumber_resiko', LookupM::getItems("sumber_riskregister"), array('class' => 'span3 required', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Risk Register', '', array('class' => 'control-label', 'style' => 'width:145px')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status_riskregister', LookupM::getItems("status_riskregister"), array('class' => 'span3 required', 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Resiko', '', array('class' => 'control-label', 'style' => 'width:145px')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'tingkatrisiko_id', CHtml::listData($model->getTingkatResikoItems(), 'tingkatrisiko_riskregister_id', 'tingkatrisiko_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div id='searching'>
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('class' => 'form-control', 'multiple' => 'multiple')); ?>                                           
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">                                               
                    <?php
                    if (!empty($model->instalasi_id)) {
                     $tes = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true AND instalasi_id in ( '.implode(',',$model->instalasi_id).') ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama');
                    }else{
                    $tes = array();
                    }
                    echo $form->dropDownList($model, 'ruangan_id', $tes , array('class' => 'form-control', 'multiple' => 'multiple')) ?>                                                    
                </div>
            </div>  
        </div> 
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')) . "&nbsp;"; ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger', 'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>