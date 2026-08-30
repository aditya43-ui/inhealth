<?php 
    echo CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/detailBahanmenudiet", array("pendaftaran_id"=>$pendaftaran_id,"pasienadmisi_id"=>$pasienadmisi_id,"jeniswaktu_id"=>$jeniswaktu_id,"menudiet_id"=>$menudiet_id,"jenismakanan_id"=>$jenismakanan_id,  'tipediet_id' => $tipediet_id,  'kelaspelayanan_id' => isset($model->kelaspelayanan_id) ? $model->kelaspelayanan_id : null)), array(
        "target" => "frameDetail",
        "rel"=>"tooltip",
        "data-original-title"=>"klik untuk melihat detail bahan makanan",
        "onclick" => "$('#dialogDetail').dialog('open');")); 
?>

