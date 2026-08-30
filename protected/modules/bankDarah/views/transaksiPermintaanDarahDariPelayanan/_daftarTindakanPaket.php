<?php 
    
    $modTindakan1 = new DaftartindakanM('search');
    // $modTindakan->unsetAttributes();
    $modTindakan1->komponenunit_id = 60;    
    if(isset($_GET['DaftartindakanM'])) {
        $modTindakan1->attributes = $_GET['DaftartindakanM'];
        $modTindakan1->kategoritindakan_nama = isset($_GET['DaftartindakanM']['kategoritindakan_nama']) ? $_GET['DaftartindakanM']['kategoritindakan_nama'] : '';
        $modTindakan1->daftartindakan_nama = isset($_GET['DaftartindakanM']['daftartindakan_nama']) ? $_GET['DaftartindakanM']['daftartindakan_nama'] : '';
        // var_dump($modTindakan->attributes);die;
        // $modTindakan->daftartindakan_kode = $_GET['RJPaketpelayananV']['daftartindakan_kode'] ?? null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'giladiagnosa-m-grid2',
            'dataProvider'=>$modTindakan1->search(),
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
                                            pilihPemeriksaanTindakanIni(this, \'$data->daftartindakan_id\'); $(\'#dialogDaftarTindakanPaket\').dialog(\'close\');
                                        "))',
                       
                    ),
                    array(
                        'name'=>'daftartindakan_kode',
                        'value'=>'$data->daftartindakan_kode',
                        'type'=>'raw',
                    ),
                    array(
                        'header'=>'Nama Pemeriksaan',
                        'value'=> function ($data) {

                            $daftartindakan_id = $data->daftartindakan_id;

                            $tarif = TariftindakanM::model()->find('daftartindakan_id = ' . $data->daftartindakan_id . ' and ' . ' komponentarif_id = 6');
                            $harga_tariftindakan = $tarif->harga_tariftindakan;
                            $jenistarif_id = $tarif->jenistarif_id;

                           
                            echo CHtml::hiddenField('tindakan_nama[' . $data->daftartindakan_id . ']', $data->daftartindakan_nama,array('readonly'=>true,'class'=>'span3 daftartindakan_nama', 'onkeyup'=>"return $(this).focusNextInputField(event);"));

                            echo CHtml::hiddenField('jenistarif_id[' . $data->daftartindakan_id . ']', $jenistarif_id,array('readonly'=>true,'class'=>'span3 jenistarif_id', 'onkeyup'=>"return $(this).focusNextInputField(event);"));

                            echo CHtml::hiddenField('daftartindakan_id[' . $data->daftartindakan_id . ']', $daftartindakan_id,array('readonly'=>true,'class'=>'span3 daftartindakan_id', 'onkeyup'=>"return $(this).focusNextInputField(event);"));

                            echo CHtml::hiddenField('harga_tariftindakan[' . $data->daftartindakan_id . ']', $harga_tariftindakan,array('readonly'=>true,'class'=>'span3 harga_tariftindakan', 'onkeyup'=>"return $(this).focusNextInputField(event);"));

                            echo $data->daftartindakan_nama;
                        },
                        'type'=>'raw',
                        'filter' => CHtml::activeTextField($modTindakan1, 'daftartindakan_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"))
                    ),
                   

                 
                    array(
                        'name'=>'harga_tarif_tindakan',
                        'value'=> function ($data) {
                            $tariftindakan = TariftindakanM::model()->find('daftartindakan_id = ' . $data->daftartindakan_id . ' and ' . ' komponentarif_id = 6');
                            return number_format($tariftindakan->harga_tariftindakan,0,"",".");
                        },
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
