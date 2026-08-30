<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash("success", "Data Penerimaan Spesimen berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Penerimaan Spesimen</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Penerimaan Spesimen' => array('index'),
            'Tambah',
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        echo $this->renderPartial($this->path_view . '_form', array(
            'modTerimaSpesimen' => $modTerimaSpesimen,
            'modTerimaSpesimenDet' => $modTerimaSpesimenDet,
            'modKirimSpesimendetail' => $modKirimSpesimendetail,
            'modKirimSpesimen' => $modKirimSpesimen,
            'format' => $format,
        ));
        ?>
    </div>
</div>