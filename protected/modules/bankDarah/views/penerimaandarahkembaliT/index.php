<style>        
     .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
</style>
<div class="panel panel-gradient">
    
    <div class="panel-heading">
        <div class="panel-title">Penerimaan Darah Kembali / Retur Darah</div>
    </div>
    <div class="panel-body">
        <?php
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'returdarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        ));
               
        echo $this->renderPartial($this->path_view.'_dataKantongDarah',array('form'=>$form,'model'=>$model),true);               
        ?>
        <?php
        echo $this->renderPartial($this->path_view.'_formPenerimaan',array('model'=>$model,'form'=>$form),true);                
        ?>
        <div class="form-action">
        <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

            if (empty($model->ujidarahpasien_id)){
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button','onclick'=>'cekSubmit();', 'onKeypress' => 'return formSubmit(this,event)'));
                echo '&nbsp;';
                // echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"alert('segera hadir')",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
            }else{
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>true));
                echo '&nbsp;';
                // echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"alert('segera hadir')"));
            }        
        ?>
        <?php
        echo '&nbsp;';
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($module.'/'.$controller.'/index'), array('class' => 'btn btn-danger',
                 'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));
            echo '&nbsp;';
        ?>
        <?php 
            $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
            $this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
        </div>
       
        <?php
        echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model),true);        
        $this->endWidget();                 
        echo $this->renderPartial($this->path_view.'_jsFunction', array('model'=>$model), true);
        ?>
    </div>
</div>
