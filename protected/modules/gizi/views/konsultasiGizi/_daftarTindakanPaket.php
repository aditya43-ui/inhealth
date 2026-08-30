<?php     
$modTindakan = new GZTarifTindakanPerdaRuanganV('searchDialogKonsulGizi');
$modTindakan->unsetAttributes();    
$modTindakan->kelaspelayanan_id = !empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->admisi->kelaspelayanan_id:$modPendaftaran->kelaspelayanan_id;

if(isset($_GET['GZTarifTindakanPerdaRuanganV'])) {
	$modTindakan->attributes = $_GET['GZTarifTindakanPerdaRuanganV'];
	$modTindakan->penjamin_id = $_GET['GZTarifTindakanPerdaRuanganV']['penjamin_id'];
	$modTindakan->kelaspelayanan_id = $_GET['GZTarifTindakanPerdaRuanganV']['kelaspelayanan_id'];
	$modTindakan->tipepaket_id = $_GET['GZTarifTindakanPerdaRuanganV']['tipepaket_id'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'giladiagnosa-m-grid2',
		'dataProvider'=>$modTindakan->searchDialogKonsulGizi(),
		'filter'=>$modTindakan,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectTindakan",
								"onClick" => "
									setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);
								"))',
				'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id'),
			),
			array(
				'name'=>'kategoritindakan_nama',
				'value'=>'$data->kategoritindakan_nama',
				'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
			),
			array(
				'name'=>'daftartindakan_kode',
				'value'=>'$data->daftartindakan_kode',
				'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'daftartindakan_kode'),
			),
			array(
				'name'=>'daftartindakan_nama',
				'value'=>'$data->daftartindakan_nama',
				'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'daftartindakan_nama'),
			),
			array(
				'header'=>'Harga',
				'name'=>'harga_tariftindakan',
				'value'=>'number_format($data->harga_tariftindakan,0,"",".")',
				'type'=>'raw', 
				'filter'=>false,
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
    
?>

<script type="text/javascript">
    
    $("#tableDaftarTindakanPaket .pagination ul li a").click(function(event){
        url = $(this).attr("href");
        $.get(url,{},function(data){
            $('#tableDaftarTindakanPaket').html(data);
        });
        return false;
    });
    
function setFilter(obj){
    url = $(obj).attr("attr-route");
    FilterForm = $(obj).val();
    $.get(url,{FilterForm:FilterForm},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
function setFilter2(obj){
    url = $(obj).attr("attr-route");
    FilterForm2 = $(obj).val();
    $.get(url,{FilterForm2:FilterForm2},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
function setFilter3(obj){
    url = $(obj).attr("attr-route");
    FilterForm3 = $(obj).val();
    $.get(url,{FilterForm3:FilterForm3},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}
function setFilter4(obj){
    url = $(obj).attr("attr-route");
    FilterForm4 = $(obj).val();
    $.get(url,{FilterForm4:FilterForm4},function(data){
        $('#tableDaftarTindakanPaket').html(data);
        $.fn.yiiGridView.update('giladiagnosa-m-grid2');
    });
}

function setTindakanDialog(obj,item)
{
    var hargaTindakan = unformatNumber(item.harga_tariftindakan);
    var subsidiAsuransi = unformatNumber(item.subsidiasuransi);
    var subsidiPemerintah = unformatNumber(item.subsidipemerintah);
    var subsidiRumahsakit = unformatNumber(item.subsidirumahsakit);
    if(isNaN(subsidiAsuransi))subsidiAsuransi=0;
    if(isNaN(subsidiPemerintah))subsidiPemerintah=0;
    if(isNaN(subsidiRumahsakit))subsidiRumahsakit=0;
    $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
    $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(formatNumber(item.harga_tariftindakan));
    $(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val('1');
    $(obj).parents('tr').find('input[name$="[persenCyto]"]').val(formatNumber(item.persencyto_tind));
    $(obj).parents('tr').find('input[name$="[jumlahTarif]"]').val(formatNumber(item.harga_tariftindakan));
    $(obj).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(formatNumber(item.subsidiasuransi));
    $(obj).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(formatNumber(item.subsidipemerintah));
    $(obj).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(formatNumber(item.subsidirumahsakit));
    $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(formatNumber(hargaTindakan - (subsidiAsuransi + subsidiPemerintah +subsidiRumahsakit)));
    //$(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(item.iurbiaya);
    tambahTindakanPemakaianBahan(item.daftartindakan_id,item.label);
}

</script>
