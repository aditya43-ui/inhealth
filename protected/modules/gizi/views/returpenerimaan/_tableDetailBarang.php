<?php echo CHtml::css('#tableDetailBarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="tableDetailBarang">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kelompok</th>
            <th>Nama Bahan Makanan</th>
            <th>Harga Satuan (Rp)</th>
            <th>Total Keringanan</th>
            <th>Total PPN</th>
            <th>Total PPh</th>
            <th>Jumlah Terima</th>
            <th>Jumlah Retur</th>
            <th>Harga Satuan Retur</th> 
            <th>Sub Total Retur</th> 
            <th>Kondisi Bahan Makan</th>
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
                <?php echo CHtml::textField('totalretur',0,array('class'=>'span2 integer2','readonly'=>true,'style'=>'text-align: right;'));?>
            </td>
        </tr>
    </tfoot>
</table>

