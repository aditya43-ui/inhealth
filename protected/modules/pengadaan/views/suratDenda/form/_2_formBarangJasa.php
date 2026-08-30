<table class="table table-bordered table-condensed table-striped" id="rincian-surat-denda">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Barang/Jasa</th>
            <th>Satuan</th>
            <th>Volume</th>
            <th>Harga(Rp)</th>
            <th>Jumlah Harga</th>
            <th>Tanggal Pengiriman</th>
            <th>Keterlambatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<table id="hapus-rincian" class="hide">
    <tbody>
        
    </tbody>
</table>
<div class="clear"></div>
<div class="col-sm-6">
    <?php
        echo $form->textAreaRow($model,'tanggal_keterlambatan',array('readonly' => true, 'class' => 'span3')); 
    ?>
</div>