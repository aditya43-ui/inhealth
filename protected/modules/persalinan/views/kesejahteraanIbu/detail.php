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
    <div class="panel-body" style="overflow-x: auto;">
        <?php echo $this->renderPartial($this->path_view."_riwayat", array(
            'model'=>$model, 'pendaftaran_id'=>$pendaftaran_id, 'is_detail'=>1,
        ), true); ?>
    </div>
</div>