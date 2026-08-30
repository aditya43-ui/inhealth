<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label class="control-label">Tanggal Kunjungan</label>
            <div class="controls" id="tglKunjungan">
                <?php echo $rujukan['tglKunjungan']; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Kunjungan</label>
            <div class="controls" id="noKunjungan">
                <?php echo $rujukan['noKunjungan']; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kode Poli</label>
            <div class="controls" id="kdPoli">
                <?php echo $rujukan['poliRujukan']['kode']; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nama Poli</label>
            <div class="controls" id="nmPoli">
                <?php echo $rujukan['poliRujukan']['nama']; ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label">Keluhan</label>
            <div class="controls" id="keluhan">
                <?php echo $rujukan['keluhan']; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Diagnosa</label>
            <div class="controls" id="nmDiag">
                <?php echo $rujukan['diagnosa']['kode'] . '-' . $rujukan['diagnosa']['nama']; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Pemeriksaan Fisik</label>
            <div class="controls" id="pemFisikLain">
                <?php echo '-'; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Catatan</label>
            <div class="controls" id="catatan">
                <?php echo $rujukan['keluhan']; ?>
            </div>
        </div>
    </div>
</div>
<hr>