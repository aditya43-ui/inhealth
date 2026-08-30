<fieldset class="box">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'sapegawai-m-search',
        'type' => 'horizontal',
    )); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span4', 'maxlength' => 30)); ?>
            <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4', 'maxlength' => 50)); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'), array('class' => 'span4', 'maxlength' => 50, 'empty' => '-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/Registrasifingerprint/informasi'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
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
</fieldset>
<?php $this->endWidget(); ?>

<?php

$content = $this->renderPartial('../tips/master', array(), true);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Informasiprint');
// $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');
$js = <<< JSCRIPT
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#sapegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>