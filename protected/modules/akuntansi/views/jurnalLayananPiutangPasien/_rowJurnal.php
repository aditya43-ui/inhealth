<tr class="<?php echo $classTr; ?>">
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 desimal', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeCheckBox($modDetail,'[ii]checklist', array('class'=>'checklist checkParent',"onclick"=>"setNol(this);")); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]daftar_tindakan',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]jenisjurnal_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pendaftaran_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]tindakan_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]jenistransaksi'); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]tindpelayanan_id'); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]nourut'); ?>

    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]jenisjurnal_nama',array('class'=>'span2 checkParent','readonly'=>true,'disabled'=>true)); ?>
    </td>
    <td><span><?php echo $modDetail->instalasi_nama .'/<br>'.$modDetail->ruangan_nama ?></span></td>
    <td><span><?php echo MyFormatter::formatDateTimeForUser($modDetail->tglpelayanan); ?></span></td>
    <td><span><?php echo $modDetail->no_pendaftaran .'/<br>'.$modDetail->no_rekam_medik ?></span></td>
    <td><span><?php echo $modDetail->nama_pasien ?></span></td>
    <td><span><?php echo $modDetail->tindakan_kode ?></span></td>
    <td><span><?php echo $modDetail->tindakan_nama ?></span></td>
    <?php
    // if(count((array)$indexTransaksi) > 0){
    //   for ($i=0; $i<$indexTransaksi; $i++){
      ?>
      <td>

        <?php
            $this->widget('MyDateTimePicker',array(
                'model'=>$modDetail,
                'attribute'=>'[ii]tglbuktijurnal',
                'mode'=>'datetime',
                'options'=> array(
                    'showOn' => false,
                    'minDate' => 'd',
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
                  'placeholder'=>'00/00/0000 00:00:00',
                  'class'=>'span3 datetimemask required',
                  'onkeyup'=>"return $(this).focusNextInputField(event)",
                  'style' => 'width: 150px;',
                  'disabled'=>true
                ),
        ));
         ?>
      </td>
      <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]nobuktijurnal',array('class'=>'span2','readonly'=>true,'disabled'=>true)); ?>
      </td>
      <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]kodejurnal',array('class'=>'span2','readonly'=>true,'disabled'=>true)); ?>
      </td>
      <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]noreferensi',array('class'=>'span2','disabled'=>true)); ?>
      </td>
      <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]uraian',array('class'=>'span2','disabled'=>true)); ?>
      </td>
      <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]kdrekening5',array('class'=>'span2 kode5','readonly'=>true,'disabled'=>true)); ?>
      </td>
      <td>
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modDetail,
                'attribute' => '[ii]nmrekening5',
                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ){return false;}',
                    'select' => 'js:function( event, ui ) {
                        tambahDataRekening(ui.item.rincianobyek_id);
                        return false;
                    }'
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder'=>'Rekening',
                    'class'=>'span2 nama5 required'
                ),
                'tombolDialog' => array(
					'idDialog' =>'dialogRek',
					'jsFunction'=>'ubahRekening(this); return false;',
				),
            ));
        ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]rekening1_id',array('class'=>'rek1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]rekening2_id',array('class'=>'rek2')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]rekening3_id',array('class'=>'rek3')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]rekening4_id',array('class'=>'rek4')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]rekening5_id',array('class'=>'rek5')); ?>
      </td>
      <td><?php echo CHtml::activeTextField($modDetail,'[ii]saldodebit',array('style'=>'width:100px', 'class'=>'span2 integer-decimal saldodebit','readonly'=>$debitReadonly)); ?></td>
      <td><?php echo CHtml::activeTextField($modDetail,'[ii]saldokredit',array('style'=>'width:100px', 'class'=>'span2 integer-decimal saldokredit','readonly'=>$kreditReadonly)); ?></td>
      </tr>
      <?php
      // }

    //} ?>
