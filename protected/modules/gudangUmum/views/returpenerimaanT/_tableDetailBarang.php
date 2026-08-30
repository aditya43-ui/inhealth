<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
            <!--<th>Bidang</th>
            <th>Kelompok</th>
            <th>Sub Kelompok</th>
            <th>Sub Sub Kelompok</th>-->
            <th>Tipe Barang</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Isi Kemasan</th>
            <th>Jumlah Terima</th>
            <th>Jumlah Retur</th>
            <th>Harga Satuan (Rp)</th>
            <th>Total Keringanan (Rp)</th>
            <th>Total PPN (Rp)</th>
            <th>Total PPh (Rp)</th>
            <th>Harga Satuan Retur</th>            
            <th>Kondisi Barang</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $this->renderPartial('_rowBarang', array('modDetails' => $modDetails), true); ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">Total Retur</td>
            <td>
                <?php echo CHtml::textField('totalretur',0,array('class'=>'span2 integer2','readonly'=>true,'style'=>'text-align: right;'))?>
            </td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

