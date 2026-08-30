<div class="form-actions">
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
// var_dump($model);die;
if(!empty($model->suratakadijarah_id)){
    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '', array(
        'class' => 'btn btn-success  btn-cetak',
        'rel' =>'tooltip',
        'title' => 'Klik untuk cetak berita acara',
        // 'disabled' => isset($_GET['sukses'])?false:true,
        'onclick' => 'printCetak()'));
}else{
    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '', array(
        'class' => 'btn btn-success  btn-cetak',
        'rel' =>'tooltip',
        'title' => 'Klik untuk cetak berita acara',
        'disabled' => isset($_GET['sukses'])?false:true,
        'onclick' => 'printCetak()'));
}
?>    
</div>

