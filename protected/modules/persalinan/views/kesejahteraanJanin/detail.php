<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Grafik Kesehatan Janin</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_grafik", array(
            'partograf'=>$partograf
        )); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Pemeriksaan Denyut Jantung Janun (DJJ)</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_riwayatDenyut", array(
            'partograf'=>$partograf, 'is_detail'=>1,
        ), true); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Ait Ketuban & Kenyusupan</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view."_riwayatAirKetuban", array(
            'partograf'=>$partograf, 'is_detail'=>1,
        ), true); ?>
    </div>
</div>