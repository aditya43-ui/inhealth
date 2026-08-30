<div class="row-fluid">
    <div class="form-actions">    
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        //if (empty($model->notadinasppk_id)) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary','id'=>'btn_submit', 'type' => 'button', 'onclick'=>'cekForm();',));
        //}else{
          //  echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
            //    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'', 'disabled'=>true));
        //}
        echo '&nbsp;';
        
        echo '&nbsp;';
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/'.$module.'/'.$controller.'/index',array()), array('class' => 'btn btn-danger',
            'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
    ?>  
    </div>
</div>