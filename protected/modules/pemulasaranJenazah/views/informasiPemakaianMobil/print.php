<div class="row" style="text-align:center">
    <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
</div>
<div class="row" style="text-align:center; margin-bottom:10px;">
    <b><?php echo $judul_print ?></b>
</div>
<?php echo $this->renderPartial('_view',array('model'=>$model)); ?>