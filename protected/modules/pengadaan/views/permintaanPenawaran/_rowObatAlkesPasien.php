<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPenawaranDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPenawaranDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1','value'=>isset($modObatAlkes->sumberdana_id) ? $modObatAlkes->sumberdana_id : null)); ?>
        <?php echo CHtml::activeHiddenField($modPenawaranDetail,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1','value'=>isset($maxStok) ? $maxStok : 0)); ?>
        <?php // echo CHtml::activeHiddenField($modPenawaranDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1','value'=>isset($modObatAlkes->tglkadaluarsa) ? MyFormatter::formatDateTimeForUser($modObatAlkes->tglkadaluarsa) : null)); ?>        
        <?php // echo CHtml::activeHiddenField($modPenawaranDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;','value'=>0)); ?>
        <?php // echo CHtml::activeHiddenField($modPenawaranDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;','value'=>0)); ?>
    </td>
    <td>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modPenawaranDetail->obatalkes_id) ? $modPenawaranDetail->obatalkes->sumberdana->sumberdana_nama : (isset($modObatAlkes->sumberdana)?$modObatAlkes->sumberdana->sumberdana_nama:"")) ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modObatAlkes->obatalkes_kategori) ? $modObatAlkes->obatalkes_kategori : "")."<br/>".(!empty($modPenawaranDetail->obatalkes_id) ? $modPenawaranDetail->obatalkes->obatalkes_nama : $modObatAlkes->obatalkes_nama) ?></span>
    </td>    
    <td>
        <?php 
        $modPenawaranDetail->stokakhir = StokobatalkesT::getJumlahStok($modPenawaranDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
        echo CHtml::activeTextField($modPenawaranDetail,'[ii]stokakhir',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
    </td>
	<td>
        <?php echo CHtml::activeTextField($modPenawaranDetail,'[ii]qty',array('readonly'=>false,'class'=>'span2 integer-decimal','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPenawaranDetail, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil">
            <?php echo CHtml::activeDropDownList($modPenawaranDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        </div>
        <div class="satuanbesar" style="display:none;">
            <?php echo CHtml::activeDropDownList($modPenawaranDetail, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;')); ?>
            <?php echo CHtml::activeTextField($modPenawaranDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span1 integer-decimal')); ?>
        </div>
    </td>        
    <td>
        <?php echo CHtml::activeTextField($modPenawaranDetail,'[ii]minimalstok',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPenawaranDetail,'[ii]harganetto',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPenawaranDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
    </td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-remove"></i></a>
    </td>
</tr>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPermintaanPenawaran'=>$modPermintaanPenawaran,'modPenawaranDetail'=>$modPenawaranDetail)); ?>