<tr>
    <td>
        <?php
        echo CHtml::activeHiddenField(
            $modDetail,
            '[ii]bahanperawatan_id',
            array('readonly' => true, 'class' => 'span1')
        );
        ?>
        <span name="[ii][bahanperawatan_nama]">
            <?php 
            $resultBahanPerawatan = BahanperawatanM::model()->findByPk($modDetail->bahanperawatan_id);
            if(!empty($resultBahanPerawatan)){
                echo $resultBahanPerawatan->bahanperawatan_nama;
            }else{
                echo "";
            }
            ?>
        </span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]jmlpemakaian', array('readonly' => true, 'class' => 'span2 integer', 'style' => 'width:45px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modDetail, '[ii]satuanpemakaian', CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_nama', 'satuankecil_nama'), array('style' => 'width:80px;')); ?>
    </td>

    <td>
        <a onclick="batalBahanPerawatan(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan mutasi obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>