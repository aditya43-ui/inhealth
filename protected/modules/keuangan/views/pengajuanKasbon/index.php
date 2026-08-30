<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong> Pengajuan Kasbon </strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Pengajuan Kasbon'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view.'_form',array(
            'model'=>$model,
        )); ?>
    </div>
</div>
<?= $this->renderPartial($this->path_view.'_dialog',['model'=>$model], true) ?>
<?= $this->renderPartial($this->path_view.'_jsFunction',['model'=>$model], true) ?>


