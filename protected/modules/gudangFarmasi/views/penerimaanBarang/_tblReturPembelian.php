<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<table id="tblReturPembelian" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Retur</th>
            <th>No</th>
            <th>Obat Alkes</th>
            <th>Harga Satuan Retur</th>
            <th>Jumlah Terima</th>
            <th>Jumlah Retur</th>
            <th>Satuan</th>
            <th>Sub Total Retur</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $subTotal = 0;
        $totalSubTotal = 0;
            foreach ($modPenerimaanDet as $i => $mod) {
                if (!empty($mod->satuanbesar_id)) {
                    $mod->jmlterima *= $mod->kemasanbesar;
                }
                
                ?>
                <tr>
                    <td><?php echo CHtml::checkBox('GFReturDetailT['.$i.'][isRetur]', true, array('class'=>'isRetur','onclick'=>'setNullQty(this);hitungTabel();','onKeypress'=>'return formSubmit(this,event)')) ?></td>
                    <td>
                        <?php echo ($i+1);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][penerimaandetail_id]', $mod->penerimaandetail_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][obatalkes_id]', $mod->obatalkes_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][satuanbesar_id]', $mod->satuanbesar_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][fakturdetail_id]', $mod->fakturdetail_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][sumberdana_id]', $mod->sumberdana_id);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][satuankecil_id]', $mod->satuankecil_id);?>
                    </td>
                    <td><?php echo $mod->obatalkes->obatalkes_kode." - ".$mod->obatalkes->obatalkes_nama; ?>
                    </td>
                    <td>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][harganettoretur]', $mod->harganettoper,array('class'=>'nettoretur'));?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][hargappnretur]', $mod->persenppn);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][hargapphretur]', $mod->persenpph);?>
                        <?php echo CHtml::hiddenField('GFReturDetailT['.$i.'][jmldiscount]', $mod->jmldiscount,array('class'=>'diskonretur'));?>
						<?php echo CHtml::textField('GFReturDetailT['.$i.'][hargasatuanretur]', MyFormatter::formatNumberForPrint($mod->hargasatuanper,2), array('class'=>'span2 harga float2', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
					<td><?php echo CHtml::textField('jmlterima', $mod->jmlterima, array('class'=>'span1 integer2 qtyterima', 'style'=>'text-align:right;', 'readonly'=>true));?></td>
                    <td><?php echo CHtml::textField('GFReturDetailT['.$i.'][jmlretur]', $mod->jmlterima, array('class'=>'span1 integer2 qty', 'style'=>'text-align:right;', 'onblur'=>'validasiQty(this); hitungTabel();', 'onKeypress'=>'return formSubmit(this,event)'));?></td>
                    <td><?php echo $mod->obatalkes->satuankecil->satuankecil_nama;?></td>
                    <td>
                        <?php
                            $subTotal = $mod->jmlterima * $mod->hargasatuanper;
                            $totalSubTotal += $subTotal;
                            echo CHtml::textField('subtotal', MyFormatter::formatNumberForPrint($subTotal), array('class'=>'span2 integer2 subtotal', 'style'=>'text-align:right;', 'readonly'=>true));
                        ?>
                    </td>
                </tr>
        <?php } ?>         
    </tbody>
	<tfoot>
		<tr>
            <td colspan="7" style="text-align: right;"><b>Total Retur</b></td>
            <td><?php 
                $totalRetur = $totalSubTotal;
                echo CHtml::textField('GFReturPembelianT[totalretur]', MyFormatter::formatNumberForPrint($totalRetur), array('class'=>'span2 integer2 totalRetur', 'style'=>'text-align:right;', 'readonly'=>true));
                ?>
            </td>
        </tr>
	</tfoot>
</table>


<script>
	$(document).ready(function(){
		hitungTabel();
	});
	
    function hitungTabel(){
        var total = 0;
        var totalRetur = 0;
        var harga = 0;
        var qty = 0;
		var totdis = 0;
		var totnetto = 0;
		var totdisfaktur = 0;
		
        $('#tblReturPembelian tbody').find('tr').each(
            function(){
                if($(this).find('.isRetur').is(':checked') == true){
                    var harga = unformatNumber($(this).find('.harga').val());
                    var qty = unformatNumber($(this).find('.qty').val());
					var terima = unformatNumber($(this).find('.qtyterima').val());
					var diskon = unformatNumber($(this).find('.diskonretur').val());
					var netto = unformatNumber($(this).find('.nettoretur').val());
                
					var subtotal = harga * qty;
					total += subtotal;
					
					totdis +=  (terima-qty) * diskon;
					totnetto += (terima-qty) * netto;
					
					$(this).find('.subtotal').val(formatThousandDecimal(Math.round(subtotal)));                
				}else{					
                    var qty = unformatNumber($(this).find('.qty').val());
					var terima = unformatNumber($(this).find('.qtyterima').val());
					var diskon = unformatNumber($(this).find('.diskonretur').val());
					var netto = unformatNumber($(this).find('.nettoretur').val());
					
					totdis +=  (terima-qty) * diskon;
					totnetto += (terima-qty) * netto;
				}
				//formatNumberSemua();				
            }
        );

		$("#GFReturPembelianT_totalretur").val(formatNumber(Math.round(total)));
		
		totdisfaktur = (parseFloat(totdis.toFixed(2))/totnetto)*100;
	
		$('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val((totdisfaktur.toFixed(2)));
		
		$('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(formatNumber(Math.round(totdis)));
		$('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(formatNumber(Math.round(totnetto)));
		
		hitungTotalFaktur();
    }
	
	function setJmlDiskonFaktur(obj){
		var persen = parseFloat(unformatNumber($(obj).val()));	
		var satuan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto') ?>").val()));

		var jmldiscount = Math.round(satuan * (persen / 100));

		$("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(jmldiscount);
	}
			
	function hitungTotalFaktur(){
		setJmlDiskonFaktur($('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>'));

		unformatNumberSemua();	

		var totalnetto = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totharganetto'); ?>").val()); 
		var jmldiscount = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modFakturPembelian, 'jmldiscount'); ?>").val())); 
		var persendiscount = parseFloat(($("#<?php echo CHtml::activeId($modFakturPembelian, 'persendiscount'); ?>").val())); 
		var persenppn = parseFloat($("#<?php echo CHtml::activeId($modFakturPembelian, 'persenppn'); ?>").val()); 
		var totalppn = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn'); ?>").val()); 
		var totalpph = parseInt($("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakpph'); ?>").val()); 
		var diskontot = 0;
		var totalseluruh = 0;
		var ppntot = 0;

		 //console.log("diskon ",formatThousandDecimal(persendiscount));

		diskontot = jmldiscount;//(totalnetto*(persendiscount/100));
		ppntot = Math.floor((totalnetto-diskontot)*(persenppn/100));

		// console.log("Diskon", diskontot);

		var totalseluruh = totalnetto - diskontot + ppntot - totalpph;

		//if (diskontot == 0){
			//$("#<?php //echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(diskontot);
		//}else{
			//$("#<?php //echo CHtml::activeId($modFakturPembelian, 'jmldiscount') ?>").val(diskontot);
		//}
		$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalpajakppn') ?>").val(ppntot);

		$("#<?php echo CHtml::activeId($modFakturPembelian, 'totalhargabruto') ?>").val(Math.round(totalseluruh));
		
		formatNumberSemua();
	}
	
    function validasiQty(obj){
        var jmlterima = 0;
        jmlterima = unformatNumber($(obj).parent().parent().find('#jmlterima').val());
		
        if(unformatNumber($(obj).val()) > jmlterima){
            myAlert("Jumlah Retur Tidak boleh lebih besar dari Jumlah Terima "+jmlterima+" !");
            $(obj).val(jmlterima);
			//formatNumberSemua();
        }
    }
    function setNullQty(obj){
        if($(obj).is(':checked') == false){
            $(obj).parent().parent().find('.qty').val(0);
        }else{
			
            var jmlterima = unformatNumber($(obj).parent().parent().find('#jmlterima').val());			
            $(obj).parent().parent().find('.qty').val(jmlterima);
        }
    }
</script>