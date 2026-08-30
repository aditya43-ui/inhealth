<?php
if (!isset($_GET['sukses'])){
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('id'=>'btn_submit','class' => 'btn btn-danger btn-simpan', 'type' => 'button','onclick'=>'cekForm();'));
}else{
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('id'=>'btn_submit','class' => 'btn btn-danger btn-simpan', 'type' => 'button','disabled'=>true));
}
?>
<?php
    echo '&nbsp;';
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default  btn-ulang',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo '&nbsp;';
        $this->renderPartial('_buttonPengaturan',['model'=>$model]);
?>    
