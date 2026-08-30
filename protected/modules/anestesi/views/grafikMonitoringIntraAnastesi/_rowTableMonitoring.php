<tr>
    <td style="text-align: center">
        <?php echo isset($data->menit_ke) ? $data->menit_ke : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']menit_ke', array('readonly' => true, 'class' => 'kontrol-waktu')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->nadi) ? $data->nadi : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']nadi', array('readonly' => true, 'class' => 'kontrol-nadi')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->tekanandarah_sistolik) ? $data->tekanandarah_sistolik : " - " ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']tekanandarah_sistolik', array('readonly' => true, 'class' => 'kontrol-systolic')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->tekanandarah_diastolik) ? $data->tekanandarah_diastolik : " - " ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']tekanandarah_diastolik', array('readonly' => true, 'class' => 'kontrol-diastolic')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->mean_arterial_press) ? $data->mean_arterial_press : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']mean_arterial_press', array('readonly' => true, 'class' => 'kontrol-map')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->spont_respiration) ? $data->spont_respiration : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']spont_respiration', array('readonly' => true, 'class' => 'kontrol-spontresp')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->assissted_respiration) ? $data->assissted_respiration : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']assissted_respiration', array('readonly' => true, 'class' => 'kontrol-assistedresp')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->controlled_respiration) ? $data->controlled_respiration : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']controlled_respiration', array('readonly' => true, 'class' => 'kontrol-controlledresp')); ?>
    </td>
    <td style="text-align: center">
        <?php echo isset($data->tourniquet) ? $data->tourniquet : " - "; ?>
        <?php echo CHtml::activeHiddenField($data, '[' . $i . ']tourniquet', array('readonly' => true, 'class' => 'kontrol-torniquet')); ?>
    </td>
    <td style="text-align: center"><?php echo isset($data->spo2) ? $data->spo2 : " - "; ?></td>
    <td style="text-align: center"><?php echo isset($data->etco2) ? $data->etco2 : " - "; ?></td>
    <td style="text-align: center"><?php echo isset($data->cvp_spo2) ? $data->cvp_spo2 : " - "; ?></td>
    <td style="text-align: center"><?php echo isset($data->bis) ? $data->bis : " - "; ?></td>
    <td style="text-align: center"><?php echo isset($data->temp) ? $data->temp : " - "; ?></td>  
    <td style="text-align: center">
        <?php
        echo CHtml::Link("<span style='font-size:17px'><i class='" . MyIcon::getIcons('lihat2') . "'></i></span>", Yii::app()->controller->createUrl("monitoringIntraAnastesi/detailObat", array('monitoringintraanastesi_id' => "$data->monitoringintraanastesi_id")), array("class" => "",
            "target" => "frameDetailObat",
            "onclick" => "$('#dialogDetailObat').dialog('open');",
            "rel" => "tooltip",
            'data-placement' => 'left',
            "title" => "Klik untuk melihat rincian input obat",
        ));
        ?>
    </td>
    <td style="text-align: center">
        <?php
        echo CHtml::Link("<span style='font-size:17px'><i class='" . MyIcon::getIcons('lihat2') . "'></i></span>", Yii::app()->controller->createUrl("monitoringIntraAnastesi/detailCairan", array('monitoringintraanastesi_id' => "$data->monitoringintraanastesi_id")), array("class" => "",
            "target" => "frameDetailselainObat",
            "onclick" => "$('#dialogDetailselainObat').dialog('open');",
            "rel" => "tooltip",
            'data-placement' => 'left',
            "title" => "Klik untuk melihat rincian input cairan",
        ));
        ?>
    </td>
    <td style="text-align: center">
        <?php
        echo CHtml::Link("<span style='font-size:17px'><i class='" . MyIcon::getIcons('lihat2') . "'></i></span>", Yii::app()->controller->createUrl("monitoringIntraAnastesi/detailOutput", array('monitoringintraanastesi_id' => "$data->monitoringintraanastesi_id")), array("class" => "",
            "target" => "frameDetailOutput",
            "onclick" => "$('#dialogDetailOutput').dialog('open');",
            "rel" => "tooltip",
            'data-placement' => 'left',
            "title" => "Klik untuk melihat rincian output",
        ));
        ?>
    </td>
    <td style="text-align: center">
        <?php 
        if(!empty($frame) && $frame == 1){
            echo CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->createUrl('anestesi/monitoringIntraAnastesi/tambah', array('pasienanastesi_id' => "$data->pasienanastesi_id", 'monitoringintraanastesi_id' => "$data->monitoringintraanastesi_id", 'frame' => 1))); 
        } else {
            echo CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->createUrl('anestesi/monitoringIntraAnastesi/tambah', array('pasienanastesi_id' => "$data->pasienanastesi_id", 'monitoringintraanastesi_id' => "$data->monitoringintraanastesi_id"))); 
        }
        ?>
    </td>
    <td style="text-align: center">
        <?php echo CHtml::link("<i class='entypo-trash'></i>", Yii::app()->createUrl('anestesi/GrafikMonitoringIntraAnastesi/Delete', array('id' => "$data->monitoringintraanastesi_id")), array('onclick' => 'hapus(this);return false;')); ?>
    </td>
</tr>

