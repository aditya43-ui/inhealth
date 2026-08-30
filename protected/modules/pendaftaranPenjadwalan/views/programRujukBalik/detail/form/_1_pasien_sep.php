
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nama</label>
        <div class="controls">: <?= $model->nama_pasien ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">No Rekam Medik</label>
        <div class="controls">: <?= $model->no_rekam_medik ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">No Pendaftaran</label>
        <div class="controls">: <?= $model->no_pendaftaran ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal Lahir</label>
        <div class="controls">: <?= $model->tanggal_lahir ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Jenis Kelamin</label>
        <div class="controls">: <?= $model->jeniskelamin ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">No Telepon</label>
        <div class="controls">: <?= $model->no_telepon_peserta ?></div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Cara Bayar/Penjamin</label>
        <div class="controls">: <?= $model->carabayar_nama.'/'.$model->penjamin_nama ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">No Kartu Peserta</label>
        <div class="controls">: <?= $model->nokartuasuransi ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">No SEP</label>
        <div class="controls">: <?= $model->nosep ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Alamat</label>
        <div class="controls">: <?= $model->alamat_pasien ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Email</label>
        <div class="controls">: <?= $model->alamatemail ?></div>
    </div>
</div>

<div class="clear"></div>