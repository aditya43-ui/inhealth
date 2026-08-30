<?php
/**
* digunakan untuk Master pasal perjanjian
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Tambah <strong>Pasal Perjanjian</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs=array(
                        'checklist monev Ms'=>array('index'),
                        'Create',
                );
                $arrMenu = array();
                $this->menu=$arrMenu;
                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>