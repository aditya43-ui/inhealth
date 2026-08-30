<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="verifikasi-action">
<?php echo $this->renderPartial($this->path_view.'_view', array('model'=>$model, 'modDet'=>$modDet, 'modFaktur'=>$modFaktur)); ?>
</div>
