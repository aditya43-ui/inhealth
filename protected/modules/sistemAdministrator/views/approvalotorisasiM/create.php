<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> <b>Konfigurasi Otorisasi Approval</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Konfigurasi Otorisasi Approval' => array('admin'),
            'Create',
        );

        $this->menu = array(
            array('label' => 'List ApprovalotorisasiM', 'url' => array('index')),
            array('label' => 'Manage ApprovalotorisasiM', 'url' => array('admin')),
        );


        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>

    </div>
</div>