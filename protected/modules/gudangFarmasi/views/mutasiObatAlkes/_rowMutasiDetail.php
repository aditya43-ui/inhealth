<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:30px !important; ')); ?>
        <?php echo CHtml::activeHiddenField($modMutasiDetail,'[ii]pesanoadetail_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modMutasiDetail,'[ii]stokobatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modMutasiDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modMutasiDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td hidden>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modMutasiDetail->sumberdana_id) ? $modMutasiDetail->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modMutasiDetail->obatalkes_id) ? $modMutasiDetail->obatalkes->obatalkes_kategori ."<br>".$modMutasiDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modMutasiDetail, '[ii]tglterima',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <?php 
        $modMutasiDetail->tglkadaluarsa = MyFormatter::formatDateTimeForUser($modMutasiDetail->tglkadaluarsa);
        echo CHtml::activeTextField($modMutasiDetail, '[ii]tglkadaluarsa',array('readonly'=>true,'style'=>'width:120px;')); 
        ?>
    </td>
    <td hidden>
        <?php // TIDAK BOLEH MERUBAH SATUAN DI TRANSAKSI  echo CHtml::activeDropDownList($modMutasiDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        <?php echo CHtml::activeHiddenField($modMutasiDetail, '[ii]satuankecil_id', array('style'=>'width:80px;')); ?>
        <?php echo CHtml::textField('[ii]satuankecil_nama', (isset($modMutasiDetail->satuankecil_id) ? $modMutasiDetail->satuankecil->satuankecil_nama : ""),array('style'=>'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modMutasiDetail,'[ii]jmlstok',array('readonly'=>true,'class'=>'span1 float2 stok','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modMutasiDetail,'[ii]jmlpesan',array('readonly'=>true,'class'=>'span1 integer-decimal-global','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo isset($modMutasiDetail->satuankecil_id) ? $modMutasiDetail->satuankecil->satuankecil_nama : ""; ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modMutasiDetail,'[ii]jmlmutasi',array('readonly'=>false,'class'=>'span1 integer-decimal-global qty','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo isset($modMutasiDetail->satuankecil_id) ? $modMutasiDetail->satuankecil->satuankecil_nama : ""; ?>
    </td>
    
    <td>
        <?php echo CHtml::activeTextField($modMutasiDetail,'[ii]harganetto',array('readonly'=>true,'class'=>'span2 integer-decimal-global','style'=>'width:80px;')); ?>
        <?php echo CHtml::activeHiddenField($modMutasiDetail,'[ii]persendiscount',array('readonly'=>true,'class'=>'span2 integer-decimal-global','style'=>'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modMutasiDetail,'[ii]hargajualsatuan',array('readonly'=>true,'class'=>'span2 integer-decimal-global','style'=>'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modMutasiDetail,'[ii]totalharga',array('readonly'=>true,'class'=>'span2 integer-decimal-global','style'=>'width:90px;')); ?>
    </td>
    <td>
        <a onclick="batalMutasiDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan mutasi obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>