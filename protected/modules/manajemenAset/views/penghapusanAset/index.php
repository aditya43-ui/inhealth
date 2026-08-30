<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - 
* RSST-1640
*/

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penghapusan Aset</b></div>
    </div>
    <div class="panel-body">
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripengeluaran-search-form',    
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>
<?php echo $this->renderPartial($this->path_view.'form/_formCariPengeluaranAset',array('model'=>$viewPengeluaran,'form'=>$form)); ?>
<?php $this->endWidget(); ?>

<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penghapusanaset-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<?php 
 if (!isset($_GET['sukses'])){
    echo $this->renderPartial($this->path_view.'tabel/_tablePengeluaranAset',array('view'=>$viewPengeluaran,'model'=>$modDet,'form'=>$form));
 }
 ?>
<p>&nbsp;</p>
<?php echo $this->renderPartial($this->path_view.'form/_formPenghapusanAset',array('model'=>$model,'form'=>$form)); ?>

<?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'form'=>$form,'view'=>$viewPengeluaran)); ?>
<?php echo $this->renderPartial($this->path_view.'_dialog',array('model'=>$model,'form'=>$form)); ?>


<div class="form-actions">
      <?php
            if (!isset($_GET['sukses'])){
                      echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                          Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-primary danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            }else{
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                          Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class'=>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-primary danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled'=>true));
            }
        ?>
        <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/index'), array('class' => 'btn btn-default',
                     'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'));
        ?>
</div>
<?php $this->endWidget(); ?>
    </div>
</div>



