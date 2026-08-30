<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>     
            <th> <?= CHtml::checkBox('pilhan', false, ['onclick' => 'pilihsemua(this,"pilih")']) ?></th>             
            <th>No</th>
            <th>No. Barcode</th>
            <th>Jenis Kantong Darah</th>
            <th>No. Kantong Pabrik</th>
            <th>Gol Darah</th>
            <th>Rhesus</th>            
            <th>Sample Konfirmasi Golongan Darah <?= CHtml::checkBox('pilhan', false, ['onclick' => 'pilihsemua(this,"ada_samplekonfirmasi")']) ?></th>
            <th>Sample Skrining IMLTD <?= CHtml::checkBox('pilhan', false, ['onclick' => 'pilihsemua(this,"ada_sampleimltd")']) ?></th>
            <th>Kantong Darah <?= CHtml::checkBox('pilhan', false, ['onclick' => 'pilihsemua(this,"ada_kantongdarah")']) ?></th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>