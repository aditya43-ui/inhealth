<?php 
$modTarif = new AMTarifambulansM;
$modTarif->unsetAttributes();
if(isset($_GET['AMTarifambulansM'])){
    $modTarif->attributes = $_GET['AMTarifambulansM'];
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'tarifambulans-t-grid',
    'dataProvider'=>$modTarif->search(),
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
            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
        ),
        array(
            'name'=>'daftartindakan.daftartindakan_nama',
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
                            "onClick" => "inputTarifAmbulans($data->jmlkilometer,
                                                             $data->tarifperkm,
                                                             $data->tarifambulans,
                                                             \'$data->kepropinsi_nama\',
                                                             \'$data->kekabupaten_nama\',
                                                             \'$data->kekecamatan_nama\',
                                                             \'$data->kekelurahan_nama\',
                                                             \'$data->daftartindakan_id\');return false;"))',
        )
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function inputTarifAmbulans(jmlKM,tarifKM,tarif,propinsi,kabupaten,kecamatan,kelurahan,daftatindakanId)
{
    var tr = '<tr><td><input type="text" value="'+propinsi+'" name="tarif[propinsi][]" class="span2"></td>'+
                '<td><input type="text" value="'+kabupaten+'" name="tarif[kabupaten][]" class="span2"></td>'+
                '<td><input type="text" value="'+kecamatan+'" name="tarif[kecamatan][]" class="span2"></td>'+
                '<td><input type="text" value="'+kelurahan+'" name="tarif[kelurahan][]" class="span2"></td>'+
                '<td><input type="text" value="'+jmlKM+'" name="tarif[jmlKM][]" onblur="hitungTarif(this);" class="span1 number">'+
                '    <input type="hidden" value="'+daftatindakanId+'" name="tarif[daftartindakanId][]" class="span1 number"></td>'+
                '<td><input type="text" value="'+tarifKM+'" name="tarif[tarifKM][]" onblur="hitungTarif(this);" class="span1 currency"></td>'+
                '<td><input type="text" value="'+tarif+'" name="tarif[tarifAmbulans][]" onblur="hitungTarif(this);" readonly="readonly" class="span2 currency"></td>'+
            '</tr>';
        
//    $("#AMPemakaianambulansT_jumlahkm").val(jmlKM);
//    $("#AMPemakaianambulansT_tarifperkm").val(tarifKM);
//    $("#AMPemakaianambulansT_totaltarifambulans").val(tarif);
    $("#dialogTarif").dialog('close');
    
    $("#tblTarifAmbulans > tbody").append(tr);
    $("#tblTarifAmbulans > tbody > tr:last .currency").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
    $('.currency').each(function(){this.value = formatNumber(this.value)});
    $("#tblTarifAmbulans > tbody > tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
    $('.number').each(function(){this.value = formatNumber(this.value)});
}

function hitungTarif(obj)
{
    var km = $(obj).parent().parent().find('input[name$="[jmlKM][]"]');
    var tarifkm = $(obj).parent().parent().find('input[name$="[tarifKM][]"]');
    var tarif = $(obj).parent().parent().find('input[name$="[tarifAmbulans][]"]');
    
    tarif.val(formatNumber(unformatNumber(km.val()) * unformatNumber(tarifkm.val())) );
}
</script>

    
