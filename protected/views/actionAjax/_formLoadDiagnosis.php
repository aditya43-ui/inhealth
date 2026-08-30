<tr id="tr_<?php echo $modDiagnosa->diagnosa_id; ?>">
    <td><?php echo $tglDiagnosa; ?></td>
    <td>
        <?php echo CHtml::dropDownList("Morbiditas[0][kelompokDiagnosa]",$idKelDiagnosa,
                CHtml::listData(KelompokdiagnosaM::model()->findAll(), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array('class'=>'span2')); ?>
    </td>
    <td><?php echo $modDiagnosa->diagnosa_kode; ?></td>
    <td>
        <?php echo $modDiagnosa->diagnosa_nama; ?>
        <?php echo CHtml::hiddenField('Morbiditas[0][diagnosa]', $modDiagnosa->diagnosa_id, array('readonly'=>true,'class'=>'span1 idDiagnosa')); ?>
    </td>
    <td><?php echo $modDiagnosa->diagnosa_namalainnya; ?></td>
    <td><?php echo $modDiagnosa->diagnosa_katakunci; ?></td>
    <td>
        <span id="diagnosaTindakanNama"></span><br/>
        <?php echo CHtml::link('<i class="icon-chevron-right icon-white"></i>', 'javascript:void(0)',array('onclick'=>'addDiagnosaTindakan(this,'.$modDiagnosa->diagnosa_id.');return false;','class'=>'btn btn-info')) ?>
        <?php echo CHtml::hiddenField("Morbiditas[0][diagnosaTindakan]", '', array('readonly'=>true,'class'=>'span1')); ?>
        <?php //echo CHtml::dropDownList('Morbiditas[0][diagnosaTindakan]', '', CHtml::listData($modDiagnosaicdixM, 'diagnosaicdix_id', 'diagnosaicdix_nama'),
                //                        array('empty'=>'-- Pilih --','id'=>'diagnosaTindakan_'.$modDiagnosa->diagnosa_id,'class'=>'span2')) ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('Morbiditas[0][sebabDiagnosa]', '', CHtml::listData($modSebabDiagnosa, 'sebabdiagnosa_id', 'sebabdiagnosa_nama'),
                                        array('empty'=>'-- Pilih --','id'=>'sebabDiagnosa_'.$modDiagnosa->diagnosa_id,'class'=>'span2')) ?>
        <?php //echo CHtml::button('Sebab Diagnosa', array('onclick'=>'addSebabDiagnosa(this);return false;','class'=>'btn btn-info')) ?>
    </td>
</tr>
