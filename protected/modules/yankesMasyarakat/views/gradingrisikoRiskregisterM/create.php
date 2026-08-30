<?php
/**
* digunakan untuk Master grading risiko
* @author Elham Budianto <elhambudianto@.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Tambah <strong>Grading Risiko</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs=array(
                        'Subtipe Insiden'=>array('index'),
                        'Create',
                );
                $arrMenu = array();
                $this->menu=$arrMenu;
                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
                <?php echo $this->renderPartial("_jsFunctions", array('model'=>$model), true); ?>
            </div>
        </div>
    </div>
</div>