<?php


$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('modPPBuatJanjiPoli'=>$modPPBuatJanjiPoli)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>