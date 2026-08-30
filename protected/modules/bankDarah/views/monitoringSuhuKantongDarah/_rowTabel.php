<tr>
    <td>
        <?php
        echo !empty($model->kosongtanpalistrik)? $model->kosongtanpalistrik." / ".$model->kosongtanpalistrik_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->kosongdenganlistrik)? $model->kosongdenganlistrik." / ".$model->kosongdenganlistrik_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->listrikdanicepack)? $model->listrikdanicepack." / ".$model->listrikdanicepack_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->mulaiisikantong)? $model->mulaiisikantong." / ".$model->mulaiisikantong_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->setelahdiisikantong)? $model->setelahdiisikantong." / ".$model->setelahdiisikantong_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->lepaslistrik)? $model->lepaslistrik." / ".$model->lepaslistrik_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->kirimkelabitd)? $model->kirimkelabitd." / ".$model->kirimkelabitd_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->sampaidilabitd)? $model->sampaidilabitd." / ".$model->sampaidilabitd_suhu." &#8451;" : "";
        ?>
    </td>
    <td>
        <?php
        echo !empty($model->petugasmonitoring_id)? PegawaiM::model()->findByPk($model->petugasmonitoring_id)->NamaLengkap : "";
        ?>
    </td>
    <td>
        <?php
        echo $model->ket_monitoring;
        ?>
    </td>
    <td>
        <?php
        echo CHtml::activeHiddenField($model, '[ii]kosongtanpalistrik_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]kosongtanpalistrik',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]kosongdenganlistrik_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]kosongdenganlistrik',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]listrikdanicepack_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]listrikdanicepack',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]mulaiisikantong_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]mulaiisikantong',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]setelahdiisikantong_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]setelahdiisikantong',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]lepaslistrik_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]lepaslistrik',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]kirimkelabitd_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]kirimkelabitd',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]sampaidilabitd_suhu',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]sampaidilabitd',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]ket_monitoring',array('class'=>'span2','readonly'=>true));
        echo CHtml::activeHiddenField($model, '[ii]petugasmonitoring_id',array('class'=>'span2','readonly'=>true));
        ?>
        <?php
        echo CHtml::Link("<i class=\"entypo-cancel\"></i>","#",array("class"=>"btn-small","onClick" =>"batalDetail(this);return false;"));
        ?>
    </td>
</tr>