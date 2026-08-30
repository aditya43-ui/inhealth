<?php 
    $filtersForm=new MyFiltersForm;
    if (isset($_GET['MyFiltersForm'])){
        $filtersForm->filters=$_GET['MyFiltersForm'];
    }
        $sql = "SELECT * FROM paketpelayanan_m
                            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
                            JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id
                            JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id ";
//                                AND komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL."
//                            WHERE tariftindakan_m.kelaspelayanan_id = 22 
//                                AND ruangan_id = ".Yii::app()->user->getState('ruangan_id');
    if (isset($filtersForm->filters)){
        if(!empty($filtersForm->filters['kategoritindakan_nama'])){
            $sql .= "AND LOWER(kategoritindakan_m.kategoritindakan_nama) LIKE '".strtolower($filtersForm->filters['kategoritindakan_nama'])."%'";
        }
        if(!empty($filtersForm->filters['daftartindakan_kode'])){
            $sql .= "AND LOWER(daftartindakan_m.daftartindakan_kode) LIKE '".strtolower($filtersForm->filters['daftartindakan_kode'])."%'";
        }
        if(!empty($filtersForm->filters['daftartindakan_nama'])){
            $sql .= "AND LOWER(daftartindakan_m.daftartindakan_nama) LIKE '".strtolower($filtersForm->filters['daftartindakan_nama'])."%'";
        }
    }
    
    $rawData=Yii::app()->db->createCommand($sql)->queryAll();
    $dataProvider=new CArrayDataProvider($rawData, array(
        'id'=>'daftartindakan-dataprovider',
        'keyField'=>'daftartindakan_nama',
        'sort'=>array(
            'attributes'=>array(
                 'daftartindakan_kode', 'daftartindakan_nama',
            ),
        ),
        'pagination'=>array(
            'pageSize'=>2,
        ),
    ));
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'diagnosa-m-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$filtersForm,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "onClick" => "setTindakan(this, ui.item);return false;"))',
            ),
            array(
                'header'=>'Kategori',
                'name'=>'kategoritindakan_nama',
                'value'=>'$data["kategoritindakan_nama"]',
            ),
            array(
                'header'=>'Kode',
                'name'=>'daftartindakan_kode',
                'value'=>'$data["daftartindakan_kode"]',
            ),
            array(
                'header'=>'Uraian Tindakan',
                'name'=>'daftartindakan_nama',
                'value'=>'$data["daftartindakan_nama"]',
            ),
            array(
                'header'=>'Harga',
                'value'=>'number_format($data["harga_tariftindakan"])',
                'htmlOptions'=>array('style'=>'text-align:right'),
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>

<script type="text/javascript">
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
