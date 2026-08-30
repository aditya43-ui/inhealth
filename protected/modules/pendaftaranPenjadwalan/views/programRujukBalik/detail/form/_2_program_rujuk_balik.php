
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">No. SRB</label>
        <div class="controls">: <?= $model->nosrb ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal SRB</label>
        <div class="controls">: <?= $model->tglsrb ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Program PRB</label>
        <div class="controls">: <?= $model->programprb_nama. ' - '.$model->programprb_kode ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal Pembuatan PRB</label>
        <div class="controls">: <?= $model->tglbuat_prb ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Dokter DPJP</label>
        <div class="controls">: <?= $model->gelardepan.' '.$model->nama_pegawai.' '.$model->gelarbelakang_nama ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Klinik Tujuan RPB</label>
        <div class="controls">: <?= $model->ruangan_nama ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">User Pembuat SRB</label>
        <div class="controls">: <?= $model->user_pembuat ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Saran</label>
        <div class="controls">: <?= $model->saran ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Keterangan</label>
        <div class="controls">: <?= $model->keterangan ?></div>
    </div>
    <div class="control-group">
        <label class="control-label">Obat Generik PRB</label>
    </div>
</div>


<div class="clear"></div>
<br/>