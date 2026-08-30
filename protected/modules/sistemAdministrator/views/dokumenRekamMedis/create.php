<div class="white-container">
    <legend class="rim2">Tambah Dokumen <b>Rekam Medis</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadokrekammedis Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php
    if(isset($_GET['id'])){
        if($_GET['id'] > 0){
            Yii::app()->user->setFlash("success","Tambah Dokumen Rekam Medis berhasil disimpan!");
        }
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</div>