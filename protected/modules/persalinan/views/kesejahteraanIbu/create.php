<?php
//$this->breadcrumbs=array(
//	'Kesejahteraanibu Ts'=>array('index'),
//	'Create',
//);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Pemeriksaan Kesejahteraan Ibu</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tambah Data Pemeriksaan Kesejahteraan Ibu</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'pendaftaran_id'=>$pendaftaran_id)); ?>

            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Grafik Tekanan Darah, Nadi, dan Suhu</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view."_grafik", array(
                    'model'=>$model, 'pendaftaran_id'=>$pendaftaran_id, 'partograf'=>$partograf,
                ), true); ?>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Riwayat Kesejahteraan Ibu</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view."_riwayat", array(
                    'model'=>$model, 'pendaftaran_id'=>$pendaftaran_id,
                ), true); ?>
            </div>
        </div>

    </div>
</div>