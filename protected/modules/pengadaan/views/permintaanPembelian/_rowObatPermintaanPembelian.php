<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>                
    </td>
    <td>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modPermintaanPembelianDetail->sumberdana_id) ? $modPermintaanPembelianDetail->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPermintaanPembelianDetail->obatalkes_id) ? $modPermintaanPembelianDetail->obatalkes->obatalkes_kategori ."<br/>".$modPermintaanPembelianDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPermintaanPembelianDetail, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil">
            <?php echo CHtml::activeDropDownList($modPermintaanPembelianDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        </div>
        <div class="satuanbesar" style="display:none;">
            <?php echo CHtml::activeDropDownList($modPermintaanPembelianDetail, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;')); ?>
            <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]jmlpermintaan',array('readonly'=>false,'class'=>'span2 integer2','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]stokakhir',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]persendiscount',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]jmldiscount',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]minimalstok',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-remove"></i></a>
    </td>
</tr>