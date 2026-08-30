<div class="row-fluid">
    <div class="form-actions">    
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        //if (empty($model->notadinasppk_id)) {
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','id'=>'btn_submit'));
        //}else{
          //  echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
            //    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick'=>'', 'disabled'=>true));
        //}
        echo '&nbsp;';
        
        if (empty($model->syaratkhususkontrak_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
                    echo "&nbsp;";
                }
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/'.$module.'/'.$controller.'/index',array()), array('class' => 'btn btn-danger',
            'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
    ?>  
    </div>
</div>
<script>
//    function print(){
//        window.parent.toastr.warning("Dalam Progress","Perhatian!");
//        //window.open('<?php // echo $this->createUrl('print',array('id'=>$model->syaratkhususkontrak_id)); ?>','printwin','left=100,top=100,width=640,height=480');
//    }
function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->syaratkhususkontrak_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>