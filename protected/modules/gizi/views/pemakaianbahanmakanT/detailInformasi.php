<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('nopemakaianbrg')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->nopemakaianbrg); ?>
            <br>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('tglpemakaianbrg')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->tglpemakaianbrg); ?>
             <br>
        </td>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('ruangan_id')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->ruangan->ruangan_nama); ?>
            <br>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('untukkeperluan')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->untukkeperluan); ?>
            <br>
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No. Urut</th>
        <th>Barang</th>
        <th>Jml Pakai</th>
        <th>Satuan</th>
        <th>Catatan</th>
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDetailPemakaian AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $detail->barang->barang_nama; ?></td>
                <td><?php echo $detail->jmlpakai; ?></td>
                <td><?php echo $detail->satuanpakai; ?></td>
                <td><?php echo $detail->catatanbrg; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
</table>