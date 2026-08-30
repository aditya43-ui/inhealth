<tr>
    <td>
        <?php echo !empty($model->jam_monitoring) ? $model->jam_monitoring : ""; ?>
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
        <?php echo $model->ket_monitoring; ?>
    </td>
    <td>
        <?php
        echo CHtml::activeHiddenField($model, '[ii]jammonitoring', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]monitoring_ke', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]kosongtanpalistrik_suhu', array('class' => 'span2 angkacoma-only', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]kosongtanpalistrik', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]kosongdenganlistrik_suhu', array('class' => 'span2 angkacoma-only', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]kosongdenganlistrik', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]listrikdanicepack_suhu', array('class' => 'span2 angkacoma-only', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]listrikdanicepack', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]mulaiisikantong_suhu', array('class' => 'span2 angkacoma-only', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]mulaiisikantong', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]setelahdiisikantong_suhu', array('class' => 'span2 angkacoma-only', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]setelahdiisikantong', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]lepaslistrik_suhu', array('class' => 'span2 angkacoma-only', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]lepaslistrik', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]ket_monitoring', array('class' => 'span2', 'readonly' => true));
        echo CHtml::activeHiddenField($model, '[ii]petugasmonitoring_id', array('class' => 'span2', 'readonly' => true));
        ?>
        <?php
        echo CHtml::Link("<i class=\"entypo-cancel\"></i>", "#", array("class" => "btn-small", "onClick" => "batalDetail(this);return false;"));
        ?>
    </td>
</tr>