<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPermohonanOaDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermohonanOaDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1','value'=>isset($modPermohonanOaDetail->sumberdana_id) ? $modPermohonanOaDetail->sumberdana_id : null)); ?>
        <?php echo CHtml::activeHiddenField($modPermohonanOaDetail,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1','value'=>isset($maxStok) ? $maxStok : 0)); ?>
    </td>
    <td>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modPermohonanOaDetail->obatalkes_id) ? $modPermohonanOaDetail->obatalkes->sumberdana->sumberdana_nama : (isset($modPermohonanOaDetail->sumberdana)?$modPermohonanOaDetail->sumberdana->sumberdana_nama:"")) ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPermohonanOaDetail->obatalkes->obatalkes_kategori) ? $modPermohonanOaDetail->obatalkes_kategori : "")."<br>".(!empty($modPermohonanOaDetail->obatalkes_id) ? $modPermohonanOaDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>    
    <td>
        <?php echo CHtml::activeTextField($modPermohonanOaDetail,'[ii]stokakhir',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPermohonanOaDetail, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil" <?php echo (empty($modPermohonanOaDetail->satuankecil_id) ?  'style="display:none;"' : "");?>>
            <?php echo CHtml::activeDropDownList($modPermohonanOaDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        </div>
        <div class="satuanbesar" <?php echo (empty($modPermohonanOaDetail->satuanbesar_id) ?  'style="display:none;"' : "");?> >
            <?php echo CHtml::activeDropDownList($modPermohonanOaDetail, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;')); ?>
            <?php echo CHtml::activeTextField($modPermohonanOaDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span1')); ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermohonanOaDetail,'[ii]permohonanoadetail_qty',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>    
    <td>
        <?php echo CHtml::activeTextField($modPermohonanOaDetail,'[ii]minimalstok',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermohonanOaDetail,'[ii]harganetto',array('readonly'=>false,'class'=>'span2 integer','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermohonanOaDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:90px;')); ?>
    </td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>