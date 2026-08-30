<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasistokbarang-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->dropDownListRow($model,'jenisbarang_id', CHtml::listData(JenisbarangM::model()->findAll('jenisbarang_aktif = true ORDER BY jenisbarang_nama DESC'), 'jenisbarang_id', 'jenisbarang_nama'),array('class'=>'span4','empty'=>'-- Pilih --')); 
        ?>
        <?php echo $form->textFieldRow($model, 'barang_kode', array('placeholder' => 'Kode Barang', 'class' => 'span4 custom-only')); ?>
        <?php echo $form->textFieldRow($model, 'barang_nama', array('placeholder' => 'Nama Barang', 'class' => 'span4 custom-only')); ?>
        <?php echo $form->textFieldRow($model, 'barang_merk', array('placeholder' => 'Merk', 'class' => 'span4 hurufs-only')); ?>
    </div>
    <div class="col-sm-6">

        <?php echo $form->textFieldRow($model, 'barang_noseri', array('placeholder' => 'No. Seri', 'class' => 'span4 angkahuruf-only')); ?>
        <?php // echo $form->textFieldRow($model,'barang_ukuran',array('class'=>'span4 angkahuruf-only')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'barang_thnbeli', CustomFunction::getTahun(null, null), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <?php // echo $form->textFieldRow($model,'barang_thnbeli',array('class'=>'span4 numbers-only', 'maxlength' => 4)); 
        ?>

        <?php
        //		echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('disabled'=>$disabled,'empty' => '-- Pilih --', 'class' => 'span4',
        //			'ajax' => array('type' => 'POST',
        //				'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
        //				'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
        ?>
        <?php // echo $form->dropDownListRow($model,'ruangan_id',  CHtml::listData(GURuanganM::getRuanganStokBarangs($model->instalasi_id),'ruangan_id','ruangan_nama'),array('disabled'=>$disabled,'class'=>'span4')); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'ceklisminimal', array('id' => 'ceklisminimal')); ?> <label for="ceklisminimal">Barang yang sudah mencapai minimal stok</label>
            </div>
        </div>
    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php

    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
        '2' => 'print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php



$this->endWidget(); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
function cekForm(obj){
$("#search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint){
window.open("${urlPrint}/"+$('#informasistokbarang-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

?>