<?php
/**
* issue RSST-2375
* issue RSST-2376 
* view utama untuk menampilkan form - form dan kelompok data yang digunakan pada transaksi publikasi 
* digunakan untuk informasi publikasi 
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @author      Yusuf Putra Anugrah <yusufputra@.com>
* @version     2.0.0
* @link    <http://172.9.1.15/simpp/docs/>
* @link    <http://piindonesia.co.id>
* @link    <http://.com> 
* 
*/
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

if (!isset($_GET['sukses'])){
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'cekForm();'));
} else {
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'', 'disabled'=>true));
}
echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/'.$module.'/'.$controller.'/index',array()), array('class' => 'btn btn-default',
    'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang ini?")) return false;'));

$tips = array(
    '0' => 'cari2',
    '1' => 'simpan',
    '2' => 'ulang',
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
