<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Penerimaan Darah dari UTD PMI
        </div>
    </div>
    <div class="panel-body">
        
        <?php 
        
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penerimaandarah-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
                // 'enctype' => 'multipart/form-data',
            ),
            //'focus'=>'#',
        )); ?>
    
        <?php echo $this->renderPartial($this->path_view."form._permintaan", array(
            'form'=>$form,
            'model'=>$model,
            'permintaan'=>$permintaan,
        ), true); ?>
        
        <?php echo $this->renderPartial($this->path_view."form._detailPenerimaanDarah", array(
            'form'=>$form,
            'model'=>$model,
            'permintaan'=>$permintaan,
        ), true); ?>
        
        <?php echo $this->renderPartial($this->path_view."form._dataPenerimaanDarah", array(
            'form'=>$form,
            'model'=>$model,
            'permintaan'=>$permintaan,
        ), true); ?>
            
        <div class="form-actions">
            <?php
            
            $disabled = isset($_GET['sukses'])?true:false;
            
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary '.($disabled ? '' :'submit'), 
                'disabled'=>$disabled,
                'type' => 'submit'));
            echo "&nbsp;";
            if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = '.$this->createUrl('index').';}); return false;'));
                echo "&nbsp;";
            }

            if(isset($_GET['id'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="'.MyIcon::getIcons('pdf').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="'.MyIcon::getIcons('pdf').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp"; 
            }

            $content = $this->renderPartial($this->path_view.'tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $idPenerimaanDarah = isset($_GET['id'])?$_GET['id']:null;
            $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$model->penerimaandarahpmi_id);
                $js = <<< JSCRIPT
                    function print(caraPrint)
                    {
                        window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
                    }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
            ?>
        </div>    
        
        
        <?php $this->endWidget(); ?>
        
    </div>
</div>

<?php echo $this->renderPartial($this->path_view.'form/_jsFunctions', array(
    'permintaandarahpmi_id' => $permintaandarahpmi_id,
    'model' => $model
), true); ?>
<?php echo $this->renderPartial($this->path_view.'form/_dialog', array(), true); ?>