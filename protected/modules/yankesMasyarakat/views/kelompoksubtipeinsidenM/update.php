<?php
/**
 * digunakan untuk Master kelompok subtipe insiden
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Ubah <strong>Kelompok Subtipe Insiden</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Sagolongan Ms' => array('index'),
                    $model->kelompoksubtipeinsiden_id => array('view', 'id' => $model->kelompoksubtipeinsiden_id),
                    'Update',
                );
                $arrMenu = array();
                $this->menu = $arrMenu;
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>
