<?php

if (!isset($_GET['sukses'])) {
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary btn-simpan', 'type' => 'submit',));
} else {
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary btn-simpan', 'type' => 'button', 'disabled' => true));
}
?>

<?php
// echo $this->action->id; -- buat mendapatkan function yg sekarang
if (!empty($_GET['id'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/'.$this->action->id, array('id' => $_GET['id'])), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
} else {
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/'.$this->action->id, array()), array('class' => 'btn btn-danger',
        'onclick' => 'return refreshForm(this);'));
}
?>
<?php

echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '', array(
    'class' => 'btn btn-success  btn-cetak hide',
    'rel' => 'tooltip',
    'title' => 'Klik untuk cetak berita acara',
    'onclick' => 'toastr.info("In Progress","Perhatian!")'));
?>    
<?php

$tips = array(
    '0' => 'simpan',
    '1' => 'ulang',
);
$content = $this->renderPartial($this->path_tips . 'detailTips', array('tips' => $tips), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>