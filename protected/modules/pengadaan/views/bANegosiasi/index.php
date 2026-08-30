<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>


<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 135px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Berita Acara Klarifikasi/Negosiasi</strong></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data <b> Berita Acara Klarifikasi/Negosiasi</b> </span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPemeriksaan', array('model' => $model, 'modPersiapanPengadaan' => $modPersiapanPengadaan, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Lampiran <b> Klarifikasi/Negosiasi </b></span></div>
            </div>
            <div class="panel-body overflow-x">
                <?php $this->renderPartial('_formLampiran', array('model' => $model, 'modPersiapanPengadaan' => $modPersiapanPengadaan, 'modelDetail' => $modelDetail, 'modDet' => $modDet, 'form' => $form)); ?>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <?php 
                echo CHtml::hiddenField('total_harga', $modPersiapanPengadaan->total_hargaseluruhnya);
            ?>
            <div class="form-actions">
                <span class="required" style="font-size: 10px;"><i> Untuk pengadaan di bawah Rp 10.000.000 tidak perlu mengisi BA Negosiasi </i> </span> <br>
                <?php
                $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'],'isbatal' => false, 'isaddendum' => true));
                if (!empty($cekSPK)) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }else{
                    if (!isset($_GET['sukses'])) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit'));
                        echo "&nbsp;";
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                        echo "&nbsp;";
                    }
                }
            
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('id' => $modPersiapanPengadaan->persiapanpengadaan_id)), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                echo "&nbsp;";
                if (empty($model->banegosiasi_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print()"));
                    echo "&nbsp;";
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php
$this->endWidget();

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$persiapanpengadaan_id = $_GET['id'];

if (!empty($_GET['banegosiasi_id'])) {
    $update = 'iya';
    $pemeriksaanpekerjaan_id = $_GET['banegosiasi_id'];
} else {
    $update = 'tidak';
}

$pemeriksaanpekerjaan_id = $model->banegosiasi_id;

$this->renderPartial('_jsFunctions', array('model' => $model, 'persiapanpengadaan_id' => $persiapanpengadaan_id, 'urlGetRiwayat' => $urlGetRiwayat));

?>    