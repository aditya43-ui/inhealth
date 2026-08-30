<div class="row-fluid">
    <div class="form-actions">    
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        //if (empty($model->notadinasppk_id)) {
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'submit',));// 'onclick'=>'cekForm();',
        //}else{
          //  echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
            //    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'', 'disabled'=>true));
        //}
        echo '&nbsp;';
        
        if (empty($model->notadinasppk_id)) {
           // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
           // echo "&nbsp;";
        } else {
           // echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
            //echo "&nbsp;";
        }
        echo '&nbsp;';
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/'.$module.'/'.$controller.'/index',array()), array('class' => 'btn btn-danger',
            'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
    ?>  
    </div>
</div>