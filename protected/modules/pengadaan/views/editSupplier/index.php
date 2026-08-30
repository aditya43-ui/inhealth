<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype'=>'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel panel-heading">
                <div class="panel-title"> <b> Penyedia </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPenyedia', array('form' => $form, 'model' => $model))?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel panel-heading">
                <div class="panel-title"> <b> Dokumen Pendukung Penyedia </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formDokumen', array('form' => $form, 'modDok' => $modDok))?>

            </div>
        </div> 
        <div class="row-fluid">
        <?php
            
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                'type' => 'submit'));
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('index'), 
                        array('class'=>'btn btn-danger',
                                  'onclick'=>'return refreshForm(this);')); ?>
        <?php 
            $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
    </div>
    </div>
</div>


<?php $this->renderPartial('_jsFunction', array('form' => $form, 'model' => $model))?>

<?php $this->endWidget(); ?>