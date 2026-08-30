<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPemusnahanDetail,'[ii]stokobatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPemusnahanDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPemusnahanDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <span name="[ii][ruanganasal_nama]"><?php echo (!empty($modPemusnahanDetail->pemusnahanobatalkes->ruanganasal_id) ? $modPemusnahanDetail->pemusnahanobatalkes->ruanganasal->ruangan_nama : $modPemusnahanDetail->ruangan_nama) ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPemusnahanDetail->obatalkes_id) ? $modPemusnahanDetail->obatalkes->obatalkes_kategori ."<br>".$modPemusnahanDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]nobatch',array('readonly'=>true,'class'=>'span3','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
        $modPemusnahanDetail->tglkadaluarsa = MyFormatter::formatDateTimeForUser($modPemusnahanDetail->tglkadaluarsa);
        echo CHtml::activeTextField($modPemusnahanDetail, '[ii]tglkadaluarsa',array('readonly'=>true,'style'=>'width:80px;')); 
        ?>
    </td>
    <td>
        <?php // echo CHtml::activeDropDownList($modPemusnahanDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        <?php echo CHtml::activeHiddenField($modPemusnahanDetail, '[ii]satuankecil_id', array('style'=>'width:80px;')); ?>
        <?php echo CHtml::textField('[ii]satuankecil_nama', (isset($modPemusnahanDetail->obatalkes->satuankecil_id) ? $modPemusnahanDetail->obatalkes->satuankecil->satuankecil_nama : ""),array('style'=>'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]jmlstok',array('readonly'=>true,'class'=>'span2 intege2r','style'=>'width:45px;text-align:right;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);", )); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]jmlbarang',array('readonly'=>false,'class'=>'span2 integer2','style'=>'width:45px;text-align:right;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]kondisibarang',array('readonly'=>false,'class'=>'span3','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]harganetto',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:80px;text-align:right;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]hargajualsatuan',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:80px;text-align:right;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemusnahanDetail,'[ii]totalharga',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;text-align:right;')); ?>
    </td>
    <td>
        <a onclick="batalPemusnahanDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan mutasi obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>