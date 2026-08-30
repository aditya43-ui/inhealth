<table>
<?php 
foreach ($modViewBmhp as $i => $bmhp) { 
    if($bmhp->tindakanpelayanan_id == $modTindakan->tindakanpelayanan_id) {
//    if($bmhp->tindakanpelayanan_id == $modTindakan->tindakanpelayanan_id && $bmhp->daftartindakan_id == $modTindakan->daftartindakan_id) {
?>
<tr>
    <td>
        <?php //echo $bmhp->obatalkes_id; ?>
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
<?php } } ?>
<tr>
    <td>
        <?php //echo $bmhp->obatalkes_id; ?>
        <?php echo isset($modTindakan->alatmedis->alatmedis_nama)?$modTindakan->alatmedis->alatmedis_nama:' - '; ?>
    </td>
    <td>
        <?php //echo $bmhp->qty_oa; ?>
        <?php //echo $bmhp->satuankecil->satuankecil_nama; ?>
    </td>
    <td>
        <?php //echo number_format($bmhp->hargajual_oa); ?>
    </td>
</tr>
</table>