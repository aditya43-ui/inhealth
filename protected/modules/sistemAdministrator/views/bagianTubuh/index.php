<?php /*
$this->breadcrumbs=array(
	'Sabagiantubuh Ms',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-cancel"></i>')), 
            $this->createUrl($this->id.'/admin'), 
            array('class' => 'btn btn-default',
                    'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bagian Tubuh',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
    <?php $this->widget('UserTips',array('type'=>'list'));?>
</div>
<?php
 * 
 */
?>

<?php
$this->breadcrumbs = array(
    'Anatomi Tubuh Manusia',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
<i class="fas fa-layer-group"></i> Anatomi Tubuh Manusia</div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_tab', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

            <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>