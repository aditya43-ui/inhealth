<?php
$admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
?>

<tr>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran); ?>
    </td>
    <td>
        <?php echo $data->no_pendaftaran; ?>
    </td>
    <td>
        <?php
        echo $data->instalasi->instalasi_nama;
        ?>
    </td>
    <td>
        <?php
        echo $data->ruangan->ruangan_nama;
        ?>
    </td>
</tr>