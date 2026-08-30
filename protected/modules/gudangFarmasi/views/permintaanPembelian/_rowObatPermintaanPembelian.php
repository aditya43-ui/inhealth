<?php
$oa = ObatalkesM::model()->findByPk($modPermintaanPembelianDetail->obatalkes_id);

?>

<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]maksimalstok',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>                
    </td>
    <td>
        <?php echo $modPermintaanPembelian->supplier_nama; ?>
    </td>
    <td>
        <span name="[ii][obatalkes_kode]"><?php echo $modPermintaanPembelianDetail->obatalkes->obatalkes_kode ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPermintaanPembelianDetail->obatalkes_id) ? $modPermintaanPembelianDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php 
        $modZatAktif = ObatalkeszataktifM::model()->findAllByAttributes(array(
            'obatalkes_id'=>$oa->obatalkes_id
        ));
        
        $zatAktif = "-";
        if (count((array)$modZatAktif) > 0) {
            $zatAktif = "<ul>";
            foreach ($modZatAktif as $item) {
                $zatAktif .= "<li>".$item->obatalkeszataktif_nama."</li>";
            }
            $zatAktif .= "</ul>";
        }
        echo $zatAktif;
        ?>
    </td>
    <td>
        <?php echo $oa->bentuk_obat." / ".$oa->kekuatan." ".$oa->satuankekuatan; ?>
    </td>
    <td style="text-align:right;">
        <?php
            $satuanObat = "";
            echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]satuanobat',array('readonly'=>true,'class'=>'span2','style'=>'width:90px;'));
            
            if(!empty($modPermintaanPembelianDetail->satuanbesar_id)){
                $satuanObat = $modPermintaanPembelianDetail->satuanbesar->satuanbesar_nama;
                //echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;'));
                 echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]satuanbesar_id',array('readonly'=>true,'class'=>'span2'));
            }else  if(!empty($modPermintaanPembelianDetail->satuankecil_id)){
                $satuanObat = $modPermintaanPembelianDetail->satuankecil->satuankecil_nama;
                echo CHtml::activeHiddenField($modPermintaanPembelianDetail,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span2'));
            }
        ?>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]jmlpermintaan',array('readonly'=>false,'class'=>'span1 integer-decimal','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.$satuanObat; ?>
    </td>    
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span1 integer2','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.(!empty($oa->satuankecil)? $oa->satuankecil->satuankecil_nama : ""); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]stokakhir',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;','onblur'=>'hitungTotal();')):CHtml::activePasswordField($modPermintaanPembelianDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;','onblur'=>'hitungTotal();')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]persendiscount',array('readonly'=>false,'class'=>'span1 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]jmldiscount',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')):CHtml::activePasswordField($modPermintaanPembelianDetail,'[ii]jmldiscount',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]persenppn',array('readonly'=>false,'class'=>'span1 integer2','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;', 'onblur'=>'hitungTotal();')); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]ppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')):CHtml::activePasswordField($modPermintaanPembelianDetail,'[ii]ppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]persenpph',array('class'=>'span1 integer-decimal','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);", 'onblur'=>'hitungTotal();')); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]jmlpph',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')):CHtml::activePasswordField($modPermintaanPembelianDetail,'[ii]jmlpph',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]minimalstok',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]hpp',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')):CHtml::activePasswordField($modPermintaanPembelianDetail,'[ii]hpp',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPermintaanPembelianDetail,'[ii]hargasatuanper',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px; text-align: right;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modPermintaanPembelianDetail,'[ii]hargasatuanper',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px; text-align: right;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeTextArea($modPermintaanPembelianDetail,'[ii]keterangan',array('readonly'=>false,'class'=>'span2','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td hidden>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-remove"></i></a>
    </td>
</tr>