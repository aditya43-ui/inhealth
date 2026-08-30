<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - 
* RSST-1584
*/
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); 

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pspersalinan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
    'focus' => '#',
        ));

$this->widget('bootstrap.widgets.BootAlert'); 
?>

<p>&nbsp;</p>
<?php echo $this->renderPartial($this->path_view.'form/_formDataPJ',array('model'=>$model,'form'=>$form)); ?>
<p>&nbsp;</p>
<?php echo $this->renderPartial($this->path_view.'form/_formWorkOrder',array('model'=>$model,'form'=>$form)); ?>

<?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model,'form'=>$form)); ?>

<?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>


<?php $this->endWidget(); ?>

