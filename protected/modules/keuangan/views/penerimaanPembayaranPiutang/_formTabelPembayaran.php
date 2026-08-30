<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Piutang Bank dan Pembayaran Digital</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-setoran" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Pilih <br> <?php echo CHtml::checkbox('chekboxall', false, array('class' => 'checkboxAll', 'onclick' => 'changePilihAll(this);')) ?></th>
                    <th>No.</th>
                    <th>Tgl. Pembayaran /<br> No. Pembayaran</th>
                    <th>Tgl. Jatuh Tempo</th>
                    <th>Tgl. Pendaftaran /<br> No. Pendaftaran</th>
                    <th>No. Rekam Medik</th>
                    <th>Nama Pasien</th>
                    <th>Instalasi</th>
                    <th>Ruangan</th>
                    <th>Bayar Ke -</th>
                    <th>Jenis Pembayaran</th>
                    <th>Bank</th>
                    <th>Jumlah Piutang (Rp)</th>
                    <th>Jumlah yang Dibayarkan (Rp)</th>
                    <th>Jumlah Biaya Administrasi Bank (Rp)</th>
                    <th>Jumlah Biaya Meterai (Rp)</th>
                    <th>Jumlah Penerimaan (Rp)</th>
                    <th>Jumlah Sisa Piutang (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>