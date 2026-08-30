<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tgl. Pelayanan</th>
            <th>Nama Obat Alkes</th>
            <th>Jumlah</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($modViewBmhp as $i => $bmhp) { ?>
<tr>
    <td>
        <?php echo $bmhp->tglpelayanan; ?>
    </td>
    <td>
        <?php echo $bmhp->obatalkes->obatalkes_nama; ?>
    </td>
    <td>
        <?php echo $bmhp->qty_oa; ?>
        <?php echo $bmhp->satuankecil->satuankecil_nama; ?>
    </td>
    <td>
        <?php echo number_format($bmhp->hargajual_oa); ?>
    </td>
</tr>
<?php } ?>
    </tbody>
</table>