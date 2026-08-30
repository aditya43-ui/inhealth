<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> <b>Konfigurasi Otorisasi Approval</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Konfigurasi Otorisasi Approval',
        );

        $this->menu = array(
            array('label' => 'List ApprovalotorisasiM', 'url' => array('index')),
            array('label' => 'Create ApprovalotorisasiM', 'url' => array('create')),
            array('label' => 'View ApprovalotorisasiM', 'url' => array('view', 'id' => $model->approvalotorisasi_id)),
            array('label' => 'Manage ApprovalotorisasiM', 'url' => array('admin')),
        );

        $this->widget('bootstrap.widgets.BootAlert');

        ?>

        <?php echo $this->renderPartial('_fromUpdate', array(
            'model' => $model,
            'dataApprovalBatalTindakan' => $dataApprovalBatalTindakan,
            'dataApprovalBatalVerifikasi' => $dataApprovalBatalVerifikasi,
            'dataApprovalBatalAlokasi' => $dataApprovalBatalAlokasi,
            'dataApprovalBatalPembayaran' => $dataApprovalBatalPembayaran
            )); ?>
    </div>
</div>