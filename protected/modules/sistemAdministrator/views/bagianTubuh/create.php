<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Bagian Tubuh</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sabagiantubuh Ms' => array('index'),
            'Create',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formNew', array('model' => $model, 'modGambarTubuh' => $modGambarTubuh,)); ?>
        <!--</div>-->
    </div>
</div>