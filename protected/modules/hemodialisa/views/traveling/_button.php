<div class='form-actions'>
<?php
if (!isset($_GET['sukses'])){
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger btn-simpan', 'type' => 'submit',));
}else{
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger btn-simpan', 'type' => 'button','disabled'=>true));
}
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default  btn-ulang',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '', array(
        'disabled' => isset($_GET['sukses'])?false:true,
        'class' => 'btn btn-success  btn-cetak',
        'rel' =>'tooltip',
        'title' => 'Klik untuk cetak berita acara',
        'onclick' => 'cetakSurat()'));
    ?>    
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('bedahSentral.views.tips.transaksi', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));   
?>
</di>