<?php
$this->breadcrumbs = array(
    'Kporganigram Ms' => array('index'),
    $model->organigram_id => array('view', 'id' => $model->organigram_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Tabel Organigram</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model, 'from' => $from)); ?>

        <?php //$this->renderPartial($this->path_view.'_tabMenu',array()); 
        ?>
        <?php //$this->renderPartial($this->path_view.'_jsFunctions',array()); 
        ?>

        <!--<iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll"></iframe>-->
    </div>
</div>