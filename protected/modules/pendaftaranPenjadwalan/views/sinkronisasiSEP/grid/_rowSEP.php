<tr>
    <td><?php echo CHtml::Link('<i class="icon-form-check"></i>',"javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectSEP",
                "onClick" => "
                    cariDataSep('".$detail['noSep']."', this);
                    $(\"#dialogRiwayatSep\").dialog(\"close\");
                ",
                )); ?></td>
    <td><?php echo $detail['noSep']; ?></td>
    <td><?php echo MyFormatter::formatDateTimeForUser($detail['tglSep']); ?></td>
    <td><?php echo $detail['noKartu']."<br/>".$detail['namaPeserta']; ?></td>
    <td><?php echo $detail['noRujukan']; ?></td>
    <td class="diagnosa"><?php echo $detail['diagnosa']; ?></td>
    <td><?php echo $detail['poli']; ?></td>
</tr>