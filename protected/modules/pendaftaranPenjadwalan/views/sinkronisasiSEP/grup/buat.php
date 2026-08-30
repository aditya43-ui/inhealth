<div class="panel panel-gradient">    
    <div class="panel-heading">
        <div class="panel-title">Sinkronisasi SEP (Multi)</div>
    </div>
    <div class="panel-body form-horizontal" id="form-infopasien">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'sinkronisasi-sep-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
            'focus' => '#',
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
                <?= $this->renderPartial($this->pathView.'grup._formPencarian',[
                    //'model'=>$model,
                ], true)  ?>
                <hr/>
                <?= $this->renderPartial($this->pathView.'grup._formDataSep',[
                    //'model'=>$model,
                ], true)  ?>

        <div class="row-fluid">
            <div class="form-actions">
                <?php
                $sukses = (isset($_GET['sukses']) ? $_GET['sukses'] : null);
                $disabledSave = (isset($_GET['id']) ? true : (($sukses == 1) ? true : false));
                ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Sinkronisasi SEP', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'return cekInput()')); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('index'),
                    array(
                        'class' => 'btn btn-danger',
                        'onclick' => 'return refreshForm(this);'
                    )
                ); ?>
                
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>    
</div>

 <?= $this->renderPartial($this->pathView.'grup._jsFunction',[
            //'model'=>$model
        ], true)  ?>
 <?= $this->renderPartial($this->pathView.'_dialog',[           
        ], true)  ?>