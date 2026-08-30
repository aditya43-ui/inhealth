<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengiriman Spesimen</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengiriman Spesimen' => array('index'),
            'Tambah',
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        if (!empty($_GET['id'])) {
            ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Pengiriman Spesimen Berhasil Disimpan !"); ?>
        <?php } ?>

        <?php
        echo $this->renderPartial($this->path_view . '_form', array(
            'modKirimSpesimen' => $modKirimSpesimen,
            'modKirimSpesimenDetail' => $modKirimSpesimenDetail,
            'format' => $format
        ));
        ?>
    </div>
</div>
