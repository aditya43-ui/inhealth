<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
<p>&nbsp;</p>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'evaluasiprainduksi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
$this->widget('bootstrap.widgets.BootAlert');
$myicon = new MyIcon();
?>

<div class="panel panel-gradient">
    <div class="panel panel-body">
        <?php $this->renderPartial($this->path_view . '_form', array('model' => $model, 'form' => $form)); ?>
    </div>
</div>
<div class="panel panel-gradient">
    <div class="panel panel-body">
        <?php $this->renderPartial($this->path_view . '_form2', array('model' => $model, 'form' => $form)); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.$myicon::getIcons('simpan').'"></i>')),array('class'=>'btn btn-danger required', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.$myicon::getIcons('ulang').'"></i>')), 
                        $this->createUrl($this->path_view.'index&pasienanastesi_id='.$_GET['pasienanastesi_id']), 
                        array('class'=>'btn btn-default',
                                  'onclick'=>'return refreshForm(this);')); ?>
        <?php
            $tips = array(
                '0' => 'tanggal',
                '1' => 'cari',
                '2' => 'ulang'
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.transaksi',array('tips'=>$tips),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . 'jsFunctions', array('model' => $model)); ?>
<?php $this->endWidget(); ?>
