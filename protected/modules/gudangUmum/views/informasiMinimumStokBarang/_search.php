<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasiminimumstokbarang-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenisbarang_id', CHtml::listData(JenisbarangM::model()->findAll('jenisbarang_aktif = true ORDER BY jenisbarang_nama DESC'), 'jenisbarang_id', 'jenisbarang_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'barang_kode', array('placeholder' => 'Kode Barang', 'class' => 'span4 custom-only')); ?>
        <?php echo $form->textFieldRow($model, 'barang_nama', array('placeholder' => 'Nama Barang', 'class' => 'span4 custom-only')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'barang_merk', array('placeholder' => 'Merk', 'class' => 'span4 hurufs-only')); ?>
        <?php echo $form->textFieldRow($model, 'barang_noseri', array('placeholder' => 'No. Seri', 'class' => 'span4 angkahuruf-only')); ?>
        <?php echo $form->dropDownListRow($model, 'barang_thnbeli', CustomFunction::getTahun(null, null), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
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
            // 'onclick' => 'return refreshForm(this);',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

    $content = $this->renderPartial('gudangUmum.views.informasiStokBarang.tips.informasi', array(), true);
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
            window.open("${urlPrint}/"+$('#informasiminimumstokbarang-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

?>