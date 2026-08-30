<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Data Pengajuan Klaim</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-pengajuan" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Pilih <br> <?php echo CHtml::checkbox('chekboxall', false, array('class' => 'checkboxAll', 'onclick' => 'changePilihAll(this);')) ?></th>
                    <th>Nama Asuransi</th>
                    <th>Tgl. Pengajuan Klaim</th>
                    <th>No. Invoice</th>
                    <th>Total Tagihan</th>
                    <th>Keterangan</th>
                    <th>Jasa Pengiriman</th>
                    <th>Tgl. Pengiriman</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="font-weight: bold; text-align: right;">
                        TOTAL
                    </td>
                    <td>
                        <?php echo CHtml::textField('totaltagihan',0,array('class'=>'span2 integer-decimal','readonly'=>true)); ?>
                    </td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>