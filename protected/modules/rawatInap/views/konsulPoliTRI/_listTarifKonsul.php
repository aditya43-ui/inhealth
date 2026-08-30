<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Daftar Tindakan Konsultasi Poliklinik
        </div>
    </div>
    <div class="panel-body">-->
<table class="items table table-striped table-bordered table-condensed" id="tblListKonsul">
    <thead>
        <tr>
            <th>Ruangan Tujuan</th>
            <th>Uraian Tindakan</th>
            <th <?php echo Params::HIDDEN_HARGA ?>>Tarif</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count((array)$model) > 0) {
            foreach ($model as $i => $konsul) { ?>
                <tr>
                    <td><?php echo $ruangan_nama; ?></td>
                    <td><?php echo $konsul->daftartindakan->daftartindakan_nama; ?></td>
                    <td <?php echo Params::HIDDEN_HARGA ?>><?php echo MyFormatter::formatNumberForPrint($konsul->harga_tariftindakan); ?>
                        <?php echo CHtml::activehiddenField($konsul, 'harga_tariftindakan', array('readonly' => true)); ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="3">Data tidak ditemukan.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<table class="table table-bordered table-condensed">
    <tr <?php echo Params::HIDDEN_HARGA ?>>
        <td width="95%" style="text-align: right;">Total Nominal Tarif</td>
        <td><?php echo CHtml::textField('totalTarif', '', array('class' => 'span2', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td>
    </tr>
</table>
<!--</div>
</div>-->