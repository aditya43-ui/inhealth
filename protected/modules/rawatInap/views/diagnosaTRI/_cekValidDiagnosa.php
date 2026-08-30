<?php foreach ($modMorbiditas as $i => $morbiditas) { ?>
<tr id="tr_<?php echo $morbiditas->diagnosa_id; ?>">
    <td><?php echo $morbiditas->tglmorbiditas; ?></td>
    <td><?php echo CHtml::dropDownList("Morbiditas[$i][kelompokDiagnosa]",$morbiditas->kelompokdiagnosa_id,CHtml::listData(RIKelompokDiagnosaM::model()->findAll(), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                                        array('class'=>'span2')); ?></td>
    <td><?php echo $morbiditas->diagnosa->diagnosa_kode; ?></td>
    <td>
        <?php echo CHtml::hiddenField("Morbiditas[$i][diagnosa]", $morbiditas->diagnosa_id, array('readonly'=>true,'class'=>'span1 idDiagnosa')); ?>
        <?php echo $morbiditas->diagnosa->diagnosa_nama; ?>
    </td>
    <!--<td><?php //echo $morbiditas->diagnosa->diagnosa_namalainnya; ?></td>-->
    <td><?php echo $morbiditas->diagnosa->diagnosa_katakunci; ?></td>
    <td>
        <span id="diagnosaTindakanNama">
            <?php echo (!empty($morbiditas->diagnosaicdix_id)) ? $morbiditas->diagnosatindakan->diagnosaicdix_nama: ''; ?>
        </span><br>
        <?php echo CHtml::button('Diagnosa Tindakan', array('onclick'=>'addDiagnosaTindakan(this,'.$morbiditas->diagnosa_id.');return false;','class'=>'btn btn-info')) ?>
        <?php //echo (!empty($morbiditas->diagnosaicdix_id)) ? $morbiditas->diagnosatindakan->diagnosaicdix_id : ''; ?>
        <?php echo CHtml::hiddenField("Morbiditas[$i][diagnosaTindakan]", $morbiditas->diagnosaicdix_id, array('readonly'=>true,'class'=>'span1')); ?>
        <?php //echo CHtml::dropDownList("Morbiditas[$i][diagnosaTindakan]", $morbiditas->diagnosaicdix_id, CHtml::listData(RIDiagnosaicdixM::model()->findAll(), 'diagnosaicdix_id', 'diagnosaicdix_nama'),
                //                        array('empty'=>'-- Pilih --','id'=>'diagnosaTindakan_'.$morbiditas->diagnosa_id,'class'=>'span2')) ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList("Morbiditas[$i][sebabDiagnosa]", $morbiditas->sebabdiagnosa_id, CHtml::listData(RISebabDiagnosaM::model()->findAll(), 'sebabdiagnosa_id', 'sebabdiagnosa_nama'),
                                        array('empty'=>'-- Pilih --','id'=>'sebabDiagnosa_'.$morbiditas->diagnosa_id,'class'=>'span2')) ?>
        <?php //echo $morbiditas->sebabdiagnosa_id; ?>
    </td>
</tr>
<?php } ?>