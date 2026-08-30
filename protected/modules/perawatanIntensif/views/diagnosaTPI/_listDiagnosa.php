<?php foreach ($modMorbiditas as $i => $morbiditas) { ?>
<tr style="background-color: #b4ff39;">
    <td><?php echo $morbiditas->tglmorbiditas; ?></td>
    <td>
        <?php echo (isset($morbiditas->kelompokdiagnosa->kelompokdiagnosa_nama) ? $morbiditas->kelompokdiagnosa->kelompokdiagnosa_nama : ""); ?>
        <?php //echo CHtml::dropDownList("VMorbiditas[$i][VkelompokDiagnosa]",$morbiditas->kelompokdiagnosa_id,CHtml::listData(PIKelompokDiagnosaM::model()->findAll(), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                //                        array('class'=>'span2','disabled'=>true)); ?>
    </td>
	<td><?php echo isset($morbiditas->diagnosa->klasifikasidiagnosa_id) ? $morbiditas->diagnosa->klasifikasidiagnosa->KlasifikasiKodeNama : "-"; ?></td>
    <td><?php echo (isset($morbiditas->diagnosa->diagnosa_kode) ? $morbiditas->diagnosa->diagnosa_kode : ""); ?></td>
    <td>
        <?php echo CHtml::hiddenField("VMorbiditas[$i][Vdiagnosa]", $morbiditas->diagnosa_id, array('readonly'=>true,'class'=>'span1 idDiagnosa','disabled'=>true)); ?>
        <?php echo (isset($morbiditas->diagnosa->diagnosa_nama) ? $morbiditas->diagnosa->diagnosa_nama : ""); ?>
    </td>
    <td><?php echo (isset($morbiditas->diagnosa->diagnosa_namalainnya) ? $morbiditas->diagnosa->diagnosa_namalainnya : ""); ?></td>
    <td><?php echo (isset($morbiditas->diagnosa->diagnosa_katakunci) ? $morbiditas->diagnosa->diagnosa_katakunci : ""); ?></td>
    <td>
        <?php echo (isset($morbiditas->diagnosatindakan->diagnosaicdix_nama) ? $morbiditas->diagnosatindakan->diagnosaicdix_nama : ""); ?>
    </td>
    <td>
        <?php echo (isset($morbiditas->sebabdiagnosa->sebabdiagnosa_nama) ? $morbiditas->sebabdiagnosa->sebabdiagnosa_nama : ""); ?>
        <?php //echo CHtml::dropDownList("VMorbiditas[$i][VsebabDiagnosa]", $morbiditas->sebabdiagnosa_id, CHtml::listData(PISebabDiagnosaM::model()->findAll(), 'sebabdiagnosa_id', 'sebabdiagnosa_nama'),
                //                        array('empty'=>'-- Pilih --','id'=>'sebabDiagnosa_'.$morbiditas->diagnosa_id,'class'=>'span2','disabled'=>true)) ?>
    </td>
    <td>
        <?php
            echo CHtml::link("<span class='icon-trash'>&nbsp;</span>",'',array("rel"=>"tooltip","title"=>"Klik untuk menghapus data dari Database",'href'=>'','onclick'=>'deleteDiagnosa(this,'.$morbiditas->diagnosa_id.');return false;','style'=>'text-decoration:none;'));
        ?>
    </td>
</tr>
<?php } ?>