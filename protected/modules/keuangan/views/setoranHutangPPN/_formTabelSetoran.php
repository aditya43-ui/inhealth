<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Setoran Utang PPN Keluaran</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-setoran" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Pilih <br> <?php echo CHtml::checkbox('chekboxall', false, array('class' => 'checkboxAll', 'onclick' => 'changePilihAll(this);')) ?></th>
                    <th>No.</th>
                    <th>Tgl. Pembayaran /<br>No. Pembayaran</th>
                    <th>Tgl. Pendaftaran /<br>No. Pendaftaran</th>
                    <th>No. Rekam Medik</th>
                    <th>Nama Pasien</th>
                    <th>Instalasi</th>
                    <th>Ruangan</th>
                    <!--<th>Bayar Ke -</th>-->
                    <th>Jenis Pajak</th>
                    <th>Total Utang Pajak (Rp)</th>
                    <th>Jumlah yang Disetorkan (Rp)</th>
                    <th>Sisa Utang (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>