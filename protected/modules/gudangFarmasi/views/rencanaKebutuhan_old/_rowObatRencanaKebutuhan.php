<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>                
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]on_order',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]x_ratapemakaian',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]stokonhand',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]kategori_abc',array('readonly'=>true,'class'=>'span2','style'=>'width:90px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]persen_abc',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
		<?php echo CHtml::activeHiddenField($modRencanaDetailKeb,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span2 numbers-only','style'=>'width:90px;')); ?>
    </td>
    <td>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modRencanaDetailKeb->sumberdana_id) ? $modRencanaDetailKeb->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modRencanaDetailKeb->obatalkes_id) ? $modRencanaDetailKeb->obatalkes_kategori ."<br>".$modRencanaDetailKeb->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil">
            <?php echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        </div>
        <div class="satuanbesar" style="display:none;">
            <?php echo CHtml::activeDropDownList($modRencanaDetailKeb, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;')); ?>
            <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]jmlpermintaan',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]buffer_stok',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]harganettorenc',array('readonly'=>false,'class'=>'span2 integer','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]stokakhir',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]minimalstok',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaDetailKeb,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
    </td>
	<td><?php echo isset($modRencanaDetailKeb->jenis_material) ? $modRencanaDetailKeb->jenis_material : "-"; ?></td>
	<td><?php echo isset($modRencanaDetailKeb->kategori_abc) ? $modRencanaDetailKeb->kategori_abc : "-"; ?></td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php //$this->renderPartial($this->path_view.'_jsFunctions', array('modRencanaKebFarmasi'=>$modRencanaKebFarmasi,'modRencanaDetailKeb'=>$modRencanaDetailKeb)); ?>