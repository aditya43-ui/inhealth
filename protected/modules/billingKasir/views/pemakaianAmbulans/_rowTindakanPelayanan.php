<tr>
    <td>
       <?php echo $modTindakan->kepropinsi_nama; ?>
    </td>
    <td>
        <?php echo $modTindakan->kekabupaten_nama; ?>
    </td>
    <td>
        <?php echo $modTindakan->kekecamatan_nama; ?>
    </td>
    <td>
        <?php echo $modTindakan->kekelurahan_nama; ?>
    </td>
    <td style="text-align:center;">
        <?php echo $modTindakan->jmlkilometer; ?>
    </td>
    <td style="text-align:right;">
        <?php echo MyFormatter::formatNumberForUser($modTindakan->tarifperkm); ?>
    </td>
    <td style="text-align:right;">
        <?php echo MyFormatter::formatNumberForUser($modTindakan->tarif_pelayanan); ?>
    </td>
</tr>

