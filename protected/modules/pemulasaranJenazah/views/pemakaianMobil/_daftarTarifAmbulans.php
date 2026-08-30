<?php 
$modTarif = new PJTarifambulansM('searchDialog');
$modTarif->unsetAttributes();
$modTarif->penjamin_id = Params::PENJAMIN_ID_UMUM;
if(isset($_GET['PJTarifambulansM'])){
    $modTarif->attributes = $_GET['PJTarifambulansM'];
    $modTarif->daftartindakan_nama = isset($_GET['PJTarifambulansM']['daftartindakan_nama']) ? $_GET['PJTarifambulansM']['daftartindakan_nama'] : null;
    $modTarif->penjamin_id = isset($_GET['PJTarifambulansM']['penjamin_id']) ? $_GET['PJTarifambulansM']['penjamin_id'] : null;
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'tarifambulans-t-grid',
    'dataProvider'=>$modTarif->searchDialog(),
    'filter'=>$modTarif,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'mergeHeaders'=>array(
//        array(
//            'name'=>'<p style="margin: 0; text-align: center;">Tujuan</p>',
//            'start'=>0, //indeks kolom 3
//            'end'=>3, //indeks kolom 4
//        ),
//    ),
    'columns'=>array(
        array(
                'name'=>'tarifambulans_kode',
		'filter'=>CHtml::activeHiddenField($modTarif, 'penjamin_id'),
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
        array(
            'name'=>'kepropinsi_nama',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'kekabupaten_nama',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'kekecamatan_nama',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'kekelurahan_nama',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'jmlkilometer',
            'value'=>'number_format($data->jmlkilometer)',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'daftartindakan_nama',
            'value'=>'$data->daftartindakan->daftartindakan_nama',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'tarifperkm',
            'value'=>'number_format($data->tarifperkm)',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'tarifambulans',
            'value'=>'number_format($data->tarifambulans)',
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputTarifAmbulans(
                                        \"".$data->jmlkilometer."\",
                                        \"".$data->tarifperkm."\",
                                        \"".$data->tarifambulans."\",
                                        \"".$data->kepropinsi_nama."\",
                                        \"".$data->kekabupaten_nama."\",
                                        \"".$data->kekecamatan_nama."\",
                                        \"".$data->kekelurahan_nama."\",
                                        \"".$data->daftartindakan_id."\");return false;"))',
            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function refreshDialogTarifMobil(){
    var penjamin_id = $("#penjamin_id").val();
    $.fn.yiiGridView.update('tarifambulans-t-grid', {
        data: {
            "PJTarifambulansM[penjamin_id]":penjamin_id,
        }
    });
}      
function inputTarifAmbulans(jmlKM,tarifKM,tarif,propinsi,kabupaten,kecamatan,kelurahan,daftatindakanId)
{
    var tambahkantarif = true;
    var jmlTr = $("#tblTarifAmbulans > tbody > tr").length;
        
    var tr = '<tr><td><input type="text" value="'+propinsi+'" name="tarif[propinsi][]" class="span2"></td>'+
                '<td><input type="text" value="'+kabupaten+'" name="tarif[kabupaten][]" class="span2"></td>'+
                '<td><input type="text" value="'+kecamatan+'" name="tarif[kecamatan][]" class="span2"></td>'+
                '<td><input type="text" value="'+kelurahan+'" name="tarif[kelurahan][]" class="span2"></td>'+
                '<td><input type="text" value="'+jmlKM+'" name="tarif[jmlKM][]" onblur="hitungTarif(this);" class="span1 integer">'+
                '    <input type="hidden" value="'+daftatindakanId+'" name="tarif[daftartindakanId][]" class="span1 integer"></td>'+
                '<td><input type="text" value="'+tarifKM+'" name="tarif[tarifKM][]" onblur="hitungTarif(this);" class="span2 integer"></td>'+
                '<td><input type="text" value="0" name="tarif[biayatol][]" onblur="hitungTarif(this);" class="span2 integer"></td>'+
                '<td><input type="text" value="'+tarif+'" name="tarif[tarifAmbulans][]" onblur="hitungTarif(this);" readonly="readonly" class="span2 integer"></td>'+
                '<td><i class="icon-form-silang" onclick="batalTarif(this);return false;"></i></td>'+
            '</tr>';
      if(jmlTr >= 1){
		myConfirm("Apakah Anda akan input ulang tarif ambulans ini?","Perhatian!",
		function(r){
			if(r){
				$("#tblTarifAmbulans > tbody > tr:first").each(function(){
					$(this).detach();
				});
				if(tambahkantarif){
					$("#tblTarifAmbulans > tbody").append(tr);
					$("#dialogTarif").dialog('close');
					$("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":"","thousands":"","precision":0}
					);
					$("#tblTarifAmbulans > tbody > tr:last .integer").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
					$("#tblTarifAmbulans > tbody > tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
					$('.integer2').each(function(){
                        this.value = formatNumber(this.value);
                    });
					hitungTotalTarif();
				}
			}else{
				$("#tblTarifAmbulans > tbody > tr:last").each(function(){
					$(this).detach();
				});
				tambahkantarif = false;
			}
		}); 
	}else{
		if(tambahkantarif){
			$("#tblTarifAmbulans > tbody").append(tr);
			$("#dialogTarif").dialog('close');
			$("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
				{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
			);
            $("#tblTarifAmbulans > tbody > tr:last .integer").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
            $("#tblTarifAmbulans > tbody > tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
			$('.integer2').each(function(){this.value = formatNumber(this.value)});
			hitungTotalTarif();
		}
	}
    $("#tblTarifAmbulansAPI tbody").empty();
}

function hitungTotalTarif(obj)
{
	unformatNumberSemua();
    totaltarif = 0;
    $('#tblTarifAmbulans > tbody > tr').each(function(){
        totaltarif = parseFloat( $(this).find('input[name*="[jmlKM]"]').val() * $(this).find('input[name*="[tarifKM]"]').val() );
		 $(this).find('input[name*="[tarifAmbulans]"]').val(totaltarif);
    });
    
    formatNumberSemua();	
}

function hitungTarif(obj)
{
    var km = $(obj).parent().parent().find('input[name$="[jmlKM][]"]');
    var tarifkm = $(obj).parent().parent().find('input[name$="[tarifKM][]"]');
    var biayatol = $(obj).parent().parent().find('input[name$="[biayatol][]"]');
    var tarif = $(obj).parent().parent().find('input[name$="[tarifAmbulans][]"]');
    
    tarif.val(formatNumber(unformatNumber(km.val()) * unformatNumber(tarifkm.val()) + unformatNumber(biayatol.val()) ) );
}
</script>

    
