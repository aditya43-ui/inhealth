<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td align="center">
            <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b><br>
            <?php echo $modProfilRs->alamatlokasi_rumahsakit.", ".$modProfilRs->kabupaten->kabupaten_nama." ".$modProfilRs->propinsi->propinsi_nama; ?><br>
            Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-top: 2px solid #000000"></td>
    </tr>
</table>