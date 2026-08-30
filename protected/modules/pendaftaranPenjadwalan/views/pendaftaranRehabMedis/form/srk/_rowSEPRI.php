<tr>
    <td>
        <?php
        $diagnosa = explode("-", $detail['diagnosa']);
        echo CHtml::Link('<i class="icon-form-check"></i>', "javascript:void(0);", array(
            "class" => "btn-small",
            "id" => "selectSEP",
            "onClick" => "
                    rujukanSetKontrolDariSEP('" . $detail['noSep'] . "', '" . trim($diagnosa[0]) . "', '" . trim($diagnosa[1]) . "', '" . $detail['tglSep'] . "');
                    $(\"#dialogRSKRiwayatSEPRI\").dialog(\"close\");
                ",
        ));
        ?>
    </td>
    <td><?php echo $detail['noSep']; ?></td>
    <td><?php echo MyFormatter::formatDateTimeForUser($detail['tglSep']); ?></td>
    <td><?php echo $detail['noKartu'] . "<br/>" . $detail['namaPeserta']; ?></td>
    <td><?php echo $detail['noRujukan']; ?></td>
    <td><?php echo $detail['diagnosa']; ?></td>
    <td><?php echo $detail['poli']; ?></td>
    <td><?php echo $detail['ppkPelayanan']; ?></td>
</tr>