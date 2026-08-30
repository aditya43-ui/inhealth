<div class="col-sm-12">
    <table class='table' style="width: 100%;">
        <tr>
            <td>
                <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('nopemakaianbrg')); ?></b>
                <br>
                <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('tglpemakaianbrg')); ?></b>
            </td>
            <td>
                : <?php echo CHtml::encode($modPemakaianbarang->nopemakaianbrg); ?>
                <br>
                : <?php echo CHtml::encode($modPemakaianbarang->tglpemakaianbrg); ?>
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('ruangan_id')); ?></b>
                <br>
                <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('untukkeperluan')); ?></b>
            </td>
            <td>
                : <?php echo CHtml::encode($modPemakaianbarang->ruangan->ruangan_nama); ?>
                <br>
                : <?php echo CHtml::encode($modPemakaianbarang->untukkeperluan); ?>
            </td>
        </tr>
    </table>

    <br>

    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed" style="width: 100%;">
        <thead>
            <th>No. Urut</th>
            <th>Barang</th>
            <th>Jml Pakai</th>
            <th>Satuan</th>
            <th>Catatan</th>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($modDetailPemakaian as $detail) : ?>
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
</div>