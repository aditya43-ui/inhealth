<?php foreach ($modShow as $model){ ?>
<tr>
    <td>
        <?php echo !empty($model->jammonitoring) ? $model->jammonitoring : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->kosongtanpalistrik_suhu) ? $model->kosongtanpalistrik_suhu . " &#8451;" : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->kosongdenganlistrik_suhu) ? $model->kosongdenganlistrik_suhu . " &#8451;" : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->listrikdanicepack_suhu) ? $model->listrikdanicepack_suhu . " &#8451;" : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->mulaiisikantong_suhu) ? $model->mulaiisikantong_suhu . " &#8451;" : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->setelahdiisikantong_suhu) ? $model->setelahdiisikantong_suhu . " &#8451;" : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->lepaslistrik_suhu) ? $model->lepaslistrik_suhu . " &#8451;" : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->petugasmonitoring_id) ? PegawaiM::model()->findByPk($model->petugasmonitoring_id)->NamaLengkap : ""; ?>
    </td>
    <td>
        <?php echo !empty($model->ket_monitoring) ? $model->ket_monitoring : ''; ?>
    </td>
    <td>
    </td>
</tr>
<?php } ?>