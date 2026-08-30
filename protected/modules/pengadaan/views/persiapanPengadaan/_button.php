<?php
/** 
 * view ini digunakan untuk menampilkan button - button
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

echo "<div>";
if (!isset($_GET['sukses'])){
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'cekForm();', 'id'=>'btn_submit'));
}else{
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'', 'disabled'=>true));
}
echo '&nbsp;';
if (empty($_GET['rencanaumumpengadaan_id'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
} else {
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('rencanaumumpengadaan_id' => $_GET['rencanaumumpengadaan_id'])), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
}
echo '&nbsp;';
$content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
$this->widget('UserTips',array('type'=>'admin','content'=>$content));
echo "</div>";
?>