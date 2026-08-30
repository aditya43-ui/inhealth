<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Uraian</th>
            <th>Jumlah</th>
            <th>Jumlah Retur</th>
            <th>Harga Satuan</th>
            <th>Keringanan</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totQty = 0; $totHargaSatuan = 0; $toHarga = $totHargaDiskon = 0; $toHargaRet = 0;
        $totBiayaAdministrasi = 0;
        $totalpersenhargajual = ($modPenjualanResep->jenispenjualan != "PENJUALAN BEBAS") ? Yii::app()->user->getState('totalpersenhargajual') :  Yii::app()->user->getState('persjualbebas');
        $persenhargajual = Yii::app()->user->getState('persehargajual');
        $biayaLainLain = 0;
        $totalSubtotal = 0;
        if (count((array)$modReturDetails) > 0){
        foreach ($modReturDetails as $i => $detail) {                 
            $obatpasien = ObatalkespasienT::model()->findByAttributes(array('obatalkespasien_id'=>$detail->obatalkespasien_id));
            $biayaadministrasi = (isset($obatpasien->biayaadministrasi) ? $obatpasien->biayaadministrasi : 0);
            $biayakonseling = (isset($obatpasien->biayakonseling) ? $obatpasien->biayakonseling : 0);
            $biayaservice = (isset($obatpasien->biayaservice) ? $obatpasien->biayaservice : 0);
            $detailqty = $detail->qty_retur;
            $totQty = $totQty + $detail->qty_retur;
            $totalpersen = ($totalpersenhargajual > 0) ? $totalpersenhargajual / 100 : 0;
            $totalppnharga = ($persenhargajual > 0) ? (100 + $persenhargajual) / 100 : 0 ;
            $totHargaSatuan = $totHargaSatuan + $detail->hargasatuan;
            $diskon = (isset($obatpasien->discount) ? $obatpasien->discount : 0) * (isset($detail->hargasatuan) ? $detail->hargasatuan : 0);
            $diskon = ($diskon > 0) ? $diskon/100 : 0;
            $biayaservice = (isset($obatpasien->biayaservice) ? $obatpasien->biayaservice : 0);
            $biayaLainLain += ($biayaadministrasi + $biayakonseling + $biayaservice); //$obatpasien->jasadokterresep+ << SDH TERMASUK DALAM HARGA OBAT
            $toHarga = $toHarga + ($detail->qty_retur * ($detail->hargasatuan-$diskon));
            $subTotalHargaRetur = $detail->qty_retur * ($detail->hargasatuan - $diskon);
            $toHargaRet = ceil((($detail->hargasatuan / $totalpersen / $totalppnharga) * $detail->qty_retur) - $diskon);
            $totHargaDiskon += $diskon;
            $totalSubtotal += $subTotalHargaRetur;
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td>
                <?php // echo CHtml::activeHiddenField($modReturDetails[$i], "obatalkes_id",array("readonly"=>true,"class"=>"span1 number")); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]obatalkespasien_id",array("readonly"=>true,"class"=>"span1")); ?>
                <?php echo (isset($obatpasien->obatalkes->obatalkes_nama) ? $obatpasien->obatalkes->obatalkes_nama : ""); ?>
                <?php  echo CHtml::hiddenField("ReturresepdetT[$i][sumberdana_id]",(isset($obatpasien->sumberdana_id) ? $obatpasien->sumberdana_id : ''),array("readonly"=>true,"class"=>"span1 number")); ?>
                <?php  echo CHtml::activeHiddenField($detail,"[$i]satuankecil_id",array("readonly"=>true,"class"=>"span1 number")); ?></td>
<!--<td style="text-align: right;"><?php //echo $obatpasien->qty_oa; ?></td>-->
            <td style="text-align: right;"><?php echo CHtml::TextField('qty',number_format($detail->qty_retur),array("class"=>"inputFormTabel number lebar2 qty2",'disabled'=>'disabled', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            <td style="text-align: right;"><?php echo CHtml::activeTextField($detail,"[$i]qty_retur",array("class"=>"inputFormTabel number lebar2",'onkeyup'=>'hitungQtyRetur(this);', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            <td style="text-align: right;"><?php /*echo number_format($detail->hargasatuan_oa);*/ echo CHtml::textField("ReturresepdetT[$i][hargasatuan]", number_format($detail->hargasatuan,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2", 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            <td style="text-align: right;"><?php echo CHtml::textField('diskon',number_format($diskon,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2")); ?></td>
            <td style="text-align: right;"><?php /*echo number_format($detail->hargajual_oa);*/ echo CHtml::textField("subtotalhargaretur",number_format($subTotalHargaRetur,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2",'onblur'=>'hitungQtyRetur(this);')); ?></td>
        </tr>
        <?php
        } 
        }else{
            echo '<tr><td colspan=8><i>Data Obat Alkes tidak ditemukan</></td></tr>';
        }
        $toHarga = $toHarga+$biayaLainLain;
        $toHargaRet = $toHargaRet + $biayaLainLain;
        $totHargaRetur = $toHarga - $totBiayaAdministrasi;
        $totBiayaAdministrasi = ceil($toHarga-(($toHarga/($totalpersenhargajual/100))/(($persenhargajual+100)/100))+$biayaLainLain-$obatpasien->biayaservice);
        $toHargaRet = $toHargaRet ;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: right;"><b>Total</b></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totalQty",number_format($totQty,1),array("readonly"=>true,"class"=>"inputFormTabel number lebar2")); //echo number_format($totQty,1); ?></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totalQtyRetur",number_format($totQty,1),array("readonly"=>true,"class"=>"inputFormTabel number lebar2")); ?></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totalHargaSatuan",number_format($totHargaSatuan,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2")); ?></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totalHargaDiskon",number_format($totHargaDiskon,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2")); ?></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totalHargaReturOa",number_format($totalSubtotal,0,"",",") /*$toHarga*/,array("readonly"=>true,"class"=>"inputFormTabel integer lebar2")); ?></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right;"><b>Biaya Administrasi, dll.</b></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totBiayaAdministrasi",number_format($biayaLainLain,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2")); ?></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right;"><b>Total Harga Retur</b></td>
            <td style="text-align: right;"><?php echo CHtml::textField("totalHargaRetur",number_format($totalSubtotal + $biayaLainLain,0,"",","),array("readonly"=>true,"class"=>"inputFormTabel integer lebar2")); ?></td>
        </tr>
    </tfoot>
</table>
<?php
$js = <<< JS
function hitungQtyRetur(obj)
{
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
    var totQty = 0; 
    var subTotalRetur = 0;
    var totHargaretur = 0;
    var totalpersenhargajual = ${totalpersenhargajual};
    var ppnbarang = ${persenhargajual};
    var biayaservice = ${biayaservice};
    var detailqty = ${detailqty};
    var totalbiayaadministrasi = 0;
    var biayaLainLain = ${biayaLainLain};

    $(obj).parents('table').find('input[name$="[qty_retur]"]').each(function(){
        qty = unformatNumber(this.value);
        qty2 =  unformatNumber($(this).parents('tr').find('.qty2').val());
        hargaSatuan = unformatNumber($(this).parents('tr').find('input[name$="[hargasatuan]"]').val());
        hargatotal = unformatNumber($(this).parents('tr').find('input[name$="[subtotalhargaretur]"]').val());
        diskon = unformatNumber($(this).parents('tr').find('input[name$="diskon"]').val());
        totQty = totQty + qty;
        subTotalRetur = qty * (hargaSatuan-diskon);
        totHargaretur += subTotalRetur;
        if (jQuery.isNumeric(qty)){
                    if (qty > qty2){
                        myAlert('Jumlah Jumlah Retur tidak boleh lebih dari Jumlah Jumlah');
                        $(this).parents('tr').find('input[name$="[qty_retur]"]').val(qty2);
                        return false;
                        totQty = totQty + detailqty;
                    }
                    hitungQtyRetur();
                }
        $(this).parents('tr').find('input[name$="subtotalhargaretur"]').val(unformatNumber((subTotalRetur)));
        
    });
    
    totHargaretur = totHargaretur+biayaLainLain;
    totalretur = (qty * (hargaSatuan /(totalpersenhargajual/100)/((ppnbarang+100)/100)) + biayaLainLain);
//    totalbiayaadministrasi2 = (totHargaretur > 0 ) ? totHargaretur-((totHargaretur/(totalpersenhargajual/100))/((ppnbarang+100)/100))+biayaLainLain-biayaservice : 0;
    totHargaRetur2 = totHargaretur - totalretur;
    totalbiayaadministrasi = (totHargaretur > 0 ) ? totHargaretur-((totHargaretur/(totalpersenhargajual/100))/((ppnbarang+100)/100))+biayaLainLain-biayaservice: 0;
      
    if (jQuery.isNumeric(totalbiayaadministrasi))
        $("#totBiayaAdministrasi").val(Math.ceil(totalbiayaadministrasi));
    if (jQuery.isNumeric(totQty))
        $('#totalQtyRetur').val(formatNumber(totQty));
    if (jQuery.isNumeric(totHargaretur))
        $('#totalHargaReturOa').val(unformatNumber(totHargaretur));
    if (jQuery.isNumeric(totHargaRetur2))
        $('#totalHargaRetur').val(Math.ceil(totHargaRetur2));
    
    $('.integer').each(function(){this.value = formatInteger(this.value)});
}
JS;

Yii::app()->clientScript->registerScript('nyobain javascript kk', $js, CClientScript::POS_HEAD);
?>
<script>
function cekInputan(){
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
    return true;
}    
</script>