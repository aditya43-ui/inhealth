<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Faktur Pembelian</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-setoran" class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th>Pilih <br> <?php echo CHtml::checkbox('chekboxall', false, array('class' => 'checkboxAll', 'onclick' => 'changePilihAll(this);')) ?></th>
                    <th>No.</th>
                    <th>No. Faktur</th>
                    <th>Tanggal Faktur</th>
                    <th>Tgl. Jatuh Tempo</th>
                    <th>Instalasi</th>
                    <th>Ruangan</th>
                    <th>Bayar Ke-</th>
                    <th>Total Tagihan</th>
                    <th>Jumlah Yang Dibayarkan</th>
                    <th>Sisa Tagihan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>