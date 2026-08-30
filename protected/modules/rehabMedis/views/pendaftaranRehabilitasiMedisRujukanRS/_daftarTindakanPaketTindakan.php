<?php 
    
    $modTindakan1 = new RMDaftartindakanM('searchTindakanRM');
    // $modTindakan->unsetAttributes();
    // $modTindakan->kelaspelayanan_id = 5;    
    if(isset($_GET['RMDaftartindakanM'])) {
        $modTindakan1->attributes = $_GET['RMDaftartindakanM'];
        $modTindakan1->kategoritindakan_nama = $_GET['RMDaftartindakanM']['kategoritindakan_nama'];
        $modTindakan1->kelaspelayanan_id = $_GET['RMDaftartindakanM']['kelaspelayanan_id'];
        // var_dump($modTindakan->attributes);die;
        // $modTindakan->daftartindakan_kode = $_GET['RJPaketpelayananV']['daftartindakan_kode'] ?? null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'giladiagnosa-m-grid2',
            'dataProvider'=>$modTindakan1->searchTindakan(),
            'filter'=>$modTindakan1,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectTindakan",
                                        "onClick" => "
                                            pilihPemeriksaanTindakanIni(this); $(\'#dialogDaftarTindakanPaket\').dialog(\'close\');
                                        "))',
                        // 'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id').CHtml::activeHiddenField($modTindakan,'penjamin_id'),
                    ),
                    array(
                        'name'=>'kategoritindakan_nama',
                        'value'=> function ($data) {

                            $dt = TindakanrmM::model()->find('daftartindakan_id = ' . $data->daftartindakan_id);

                            $tindakan_id = !empty($dt) ? $dt->tindakanrm_id : null;
                            $tindakan_nama = $data->daftartindakan_nama;
                            $jenistindakan_id = !empty($dt) ? $dt->jenistindakanrm_id : null;
                            $daftartindakan_id = $data->daftartindakan_id;

                            $harga_tariftindakan = $data->harga_tariftindakan;

                            echo CHtml::hiddenField('tindakan_id[' . $data->daftartindakan_id . ']', $tindakan_id,array('readonly'=>true,'class'=>'span3 tindakanrm_id', 'onkeyup'=>"return $(this).focusNextInputField(event);"));;
                            echo CHtml::hiddenField('tindakan_nama[' . $data->daftartindakan_id . ']', $data->daftartindakan_nama,array('readonly'=>true,'class'=>'span3 tindakanrm_nama', 'onkeyup'=>"return $(this).focusNextInputField(event);"));;
                            echo CHtml::hiddenField('jenistindakan_id[' . $data->daftartindakan_id . ']', $jenistindakan_id,array('readonly'=>true,'class'=>'span3 jenistindakan_id', 'onkeyup'=>"return $(this).focusNextInputField(event);"));;
                            echo CHtml::hiddenField('daftartindakan_id[' . $data->daftartindakan_id . ']', $daftartindakan_id,array('readonly'=>true,'class'=>'span3 daftartindakan_id', 'onkeyup'=>"return $(this).focusNextInputField(event);"));;
                            echo CHtml::hiddenField('harga_tariftindakan[' . $data->daftartindakan_id . ']', $harga_tariftindakan,array('readonly'=>true,'class'=>'span3 harga_tariftindakan', 'onkeyup'=>"return $(this).focusNextInputField(event);"));;
                            echo $data->kategoritindakan->kategoritindakan_nama;
                        },
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
                        'header'=>'Kelas Pelayanan',
                        'name'=>'kelaspelayanan_nama',
                        'value'=>function($data) {
                            $kelasPelayanan = KelaspelayananM::model()->findByPk($data->kelaspelayanan_id);
                            if(!empty($kelasPelayanan)) {
                                echo $kelasPelayanan->kelaspelayanan_nama;
                            }
                        },
                        'type'=>'raw',
                        'filter'=>CHtml::activeDropDownList($modTindakan1,'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'name'=>'harga_tarif_tindakan',
                        'value'=> function ($data) {
                            return number_format($data->harga_tariftindakan,0,"",".");
                        },
                        'type'=>'raw', 
                        'filter'=>false,
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
    
//    $this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'giladiagnosa-m-grid2',
//	'dataProvider'=>$dataProvider,
//        'filter'=>$models,
////	'filter'=>$filtersForm,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//            array(
//                'header'=>'Pilih',
//                'type'=>'raw',
//                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//                                "id" => "selectObat",
//                                "onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"))',
//            ),
////            'daftartindakan_id',
////            'kelaspelayanan_id',
//            array(
//                'header'=>'Kategori',
//                'filter'=>'<input type="text" name="FilterForm[kategoritindakan_nama]" value="'.(isset($_GET['FilterForm']) ? $_GET['FilterForm'] : "").'" attr-route ="'.$route.'" onblur="setFilter(this);">',
//                'name'=>'kategoritindakan_nama',
//                'value'=>'$data["kategoritindakan_nama"]',
//            ),
//            array(
//                'header'=>'Kode',
//                'name'=>'daftartindakan_kode',
//                'filter'=>'<input type="text" name="FilterForm2[daftartindakan_kode]" value="'.(isset($_GET['FilterForm2']) ? $_GET['FilterForm2'] : "").'" attr-route ="'.$route2.'" onblur="setFilter2(this);">',
//                'value'=>'$data["daftartindakan_kode"]',
//            ),
//            array(
//                'header'=>'Nama Tindakan',
//                'filter'=>'<input type="text" name="FilterForm3[daftartindakan_nama]" value="'.(isset($_GET['FilterForm3']) ? $_GET['FilterForm3'] : "").'" attr-route ="'.$route3.'" onblur="setFilter3(this);">',
//                'name'=>'daftartindakan_nama',
//                'value'=>'$data["daftartindakan_nama"]',
//            ),
//            array(
//                'header'=>'Harga',
//                'filter'=>'<input type="hidden" name="FilterForm4[harga_tariftindakan]" value="'.(isset($_GET['FilterForm4']) ? $_GET['FilterForm4'] : "").'" attr-route ="'.$route4.'" onblur="setFilter4(this);">',
//                'name'=>'harga_tariftindakan',
//                'value'=>'number_format($data["harga_tariftindakan"])',
//                'htmlOptions'=>array('style'=>'text-align:right'),
//            ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//    )); 
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
