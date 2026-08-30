<?php
/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * digunakan untuk menampilkan button cetak, simpan danpetunjuk
 */
?>
<div class="clear"></div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
echo '&nbsp;';
echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "alert('segera hadir')", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
?>
<?php
echo '&nbsp;';
echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($module . '/' . $controller . '/index', array('nomorbarcode_sample' => $model->nomorbarcode_sample)), array('class' => 'btn btn-danger',
    'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
echo '&nbsp;';
?>
<?php
$content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
$this->widget('UserTips', array('type' => 'admin', 'content' => $content));
echo '&nbsp;';
echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-left-bold"></i>')), Yii::app()->createUrl('bankDarah/InformasiSampelDarah/index'), array('class' => 'btn btn-success'));
?>