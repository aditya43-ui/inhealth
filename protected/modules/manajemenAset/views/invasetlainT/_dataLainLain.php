<?php
/**
 * Duplikasi dari manajementAset.views._dataBarang dengan beberapa penyesuaian untuk 
 * inventarisasi Tanah.
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */

?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php

if(!empty($modBarang)){
    $jenisAset = isset($jenisAset)? $jenisAset : '';
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            <i class="glyphicon glyphicon-file"></i> Data Aset																	
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label" for="bidang">
                    <?php echo CHtml::label("Nomor Perolehan<span class='required'>*</span>",'barang_nama', array('class'=>'control-label'));?>
                    <?php // echo CHtml::activeLabel($modBarang, 'barang_nama',array('class'=>'control-label')); ?>
                </label>
                <div class="controls">
                    <?php echo CHtml::activeHiddenField($model, 'terimapersdetail_id', array(
                        'id'=>'terimapersdetail_id'
                    )); ?>
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modBarang,
                                'attribute'=>'nopenerimaan',
                                        //'name'=>'barang_nama',
                                        //'value'=>$modBarang->barang_nama,
                                        'source'=>'js: function(request, response) {
                                                       $.ajax({
                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/getBarangAsetNomorNama').'",
                                                           dataType: "json",
                                                           data: {
                                                               term: request.term,
                                                               golongan_kode: '.$jenisAset.',
                                                               tipe:1
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                                         'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 2,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                               'select'=>'js:function( event, ui ) { 
                                                   cekSelisihTerimaInventarisasi(ui.item.jmlterima,ui.item.barang_id,ui.item.terimapersdetail_id);
                                                   setKodeRegister(ui.item.barang_id);
                                                   $("#terimapersdetail_id").val(ui.item.terimapersdetail_id);
                                              $("#'.CHtml::activeId($modBarang,'barang_id').'").val(ui.item.barang_id);
                                              $("#'.CHtml::activeId($modBarang,'barang_type').'").val(ui.item.barang_type);   
                                              $("#'.CHtml::activeId($modBarang,'barang_image').'").val(ui.item.barang_image);     
                                              $("#'.CHtml::activeId($modBarang,'barang_kode').'").val(ui.item.barang_kode);
                                              $("#'.CHtml::activeId($modBarang,'nopenerimaan').'").val(ui.item.nopenerimaan);   
                                              $("#'.CHtml::activeId($modBarang,'barang_nama').'").val(ui.item.barang_nama);   
                                              $("#harga_tanah").val(formatNumber(ui.item.hargabeli));   
                                              $("#MAInvtanahT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvtanahT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvgedungT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvgedungT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvperalatanT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvperalatanT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvasetlainT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvasetlainT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvjalanT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvjalanT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvjalanT_invjalan_namabrg").val(ui.item.barang_nama);   
                                              $("#'.CHtml::activeId($modBarang,'barang_noseri').'").val(ui.item.barang_noseri);   
                                              $("#'.CHtml::activeId($modBarang,'barang_thnbeli').'").val(ui.item.barang_thnbeli);     
                                              $("#'.CHtml::activeId($modBarang,'barang_satuan').'").val(ui.item.barang_satuan);  
                                              $("#'.CHtml::activeId($modBarang,'barang_jmldlmkemasan').'").val(ui.item.barang_jmldlmkemasan);
                                              $("#'.CHtml::activeId($modBarang,'jmlterima').'").val(ui.item.jmlterima);
                                              $("#'.CHtml::activeId($modBarang,'subsubkelompok_nama').'").val(ui.item.subsubkelompok_nama);
                                              $("#'.CHtml::activeId($modBarang,'subsubkelompok_kode').'").val(ui.item.subsubkelompok_kode);

                                                if(ui.item.barang_image != null){
                                                    $("td.img img").attr(\'src\',\''.Params::urlBarangDirectory().'\'+ui.item.barang_image);
                                                } else {
                                                    $("td.img img").attr(\'src\',\''.Params::urlBarangDirectory().'no_photo.jpeg\');
                                                }
                                                    return false;
                                                }',
                                        ),
                                        'htmlOptions'=>array(
                                                'placeholder'=>'Ketik Nomor Perolehan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required'
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogBarang'),
                                    )); 
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="bidang">
                    <?php echo CHtml::label("Nama Aset<span class='required'>*</span>",'barang_nama', array('class'=>'control-label'));?>
                    <?php // echo CHtml::activeLabel($modBarang, 'barang_nama',array('class'=>'control-label')); ?>
                </label>
                <div class="controls">
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modBarang,
                                'attribute'=>'barang_nama',
                                        //'name'=>'barang_nama',
                                        //'value'=>$modBarang->barang_nama,
                                        'source'=>'js: function(request, response) {
                                                       $.ajax({
                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/getBarangAsetNomorNama').'",
                                                           dataType: "json",
                                                           data: {
                                                               term: request.term,
                                                               golongan_kode: '.$jenisAset.',
                                                               tipe:2
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                                         'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 2,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                               'select'=>'js:function( event, ui ) { 
                                                   cekSelisihTerimaInventarisasi(ui.item.jmlterima,ui.item.barang_id,ui.item.terimapersdetail_id);
                                                   setKodeRegister(ui.item.barang_id);
                                                   $("#terimapersdetail_id").val(ui.item.terimapersdetail_id);
                                              $("#'.CHtml::activeId($modBarang,'barang_id').'").val(ui.item.barang_id);
                                              $("#'.CHtml::activeId($modBarang,'barang_type').'").val(ui.item.barang_type);   
                                              $("#'.CHtml::activeId($modBarang,'barang_image').'").val(ui.item.barang_image);     
                                              $("#'.CHtml::activeId($modBarang,'barang_kode').'").val(ui.item.barang_kode);
                                              $("#'.CHtml::activeId($modBarang,'nopenerimaan').'").val(ui.item.nopenerimaan);   
                                              $("#'.CHtml::activeId($modBarang,'barang_nama').'").val(ui.item.barang_nama);   
                                              $("#harga_tanah").val(formatNumber(ui.item.hargabeli));   
                                              $("#MAInvtanahT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvtanahT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvgedungT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvgedungT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvperalatanT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvperalatanT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvasetlainT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvasetlainT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvjalanT_barang_nama").val(ui.item.barang_nama);   
                                              $("#MAInvjalanT_barang_id").val(ui.item.barang_id);   
                                              $("#MAInvjalanT_invjalan_namabrg").val(ui.item.barang_nama);   
                                              $("#'.CHtml::activeId($modBarang,'barang_noseri').'").val(ui.item.barang_noseri);   
                                              $("#'.CHtml::activeId($modBarang,'barang_thnbeli').'").val(ui.item.barang_thnbeli);     
                                              $("#'.CHtml::activeId($modBarang,'barang_satuan').'").val(ui.item.barang_satuan);  
                                              $("#'.CHtml::activeId($modBarang,'barang_jmldlmkemasan').'").val(ui.item.barang_jmldlmkemasan);
                                              $("#'.CHtml::activeId($modBarang,'jmlterima').'").val(ui.item.jmlterima);
                                              $("#'.CHtml::activeId($modBarang,'subsubkelompok_nama').'").val(ui.item.subsubkelompok_nama);
                                              $("#'.CHtml::activeId($modBarang,'subsubkelompok_kode').'").val(ui.item.subsubkelompok_kode);

                                                if(ui.item.barang_image != null){
                                                    $("td.img img").attr(\'src\',\''.Params::urlBarangDirectory().'\'+ui.item.barang_image);
                                                } else {
                                                    $("td.img img").attr(\'src\',\''.Params::urlBarangDirectory().'no_photo.jpeg\');
                                                }
                                                    return false;
                                                }',
                                        ),
                                        'htmlOptions'=>array(
                                                'placeholder'=>'Ketik Nama Aset','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required'
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogBarang'),
                                    )); 
                    ?>
                </div>
            </div>
            <?php /*
            <div class="control-group ">
                <?php echo CHtml::label("Kode Aset",'barang_kode', array('class'=>'control-label'));?>
                <div class="controls">
                   <?php echo CHtml::activeTextField($modBarang, 'barang_kode', array('readonly'=>true)); ?>
                </div>
            </div>
             * 
             */ ?>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modBarang, 'jmlterima',array('class'=>'control-label', 'label'=>'Jumlah Terima')); ?>

                <div class="controls">
                   <?php echo CHtml::activeTextField($modBarang, 'jmlterima', array('readonly'=>true, 'class'=>'span2')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label" for="barang_type">
                    <?php echo CHtml::label("Sub-Sub Kelompok Barang",'subsubkelompok_nama', array('class'=>'control-label', 'label'=>'Kode Sub-Sub Kelompok Barang'));?>
                </label>
                <div class="controls">
                   <?php echo CHtml::activeTextField($modBarang, 'subsubkelompok_nama', array('readonly'=>true)); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="barang_kode">
                    <?php echo CHtml::label("Kode Sub-Sub Kelompok Barang",'subsubkelompok_kode', array('class'=>'control-label', 'label'=>'Kode Sub-Sub Kelompok Barang'));?>
                </label>
                <div class="controls">
                   <?php echo CHtml::activeTextField($modBarang, 'subsubkelompok_kode', array('readonly'=>true)); ?>
                </div>
            </div>
            
                    
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBarang',
    'options'=>array(
        'title'=>'Data Inventarisasi Aset tetap lainnya',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>600,
        'resizable'=>false,
    ),
));

$barang= new MABarangM('searchDialog');
$barang->unsetAttributes();
$barang->golongan_kode = isset($jenisAset)? $jenisAset : '';
if(isset($_GET['MABarangM'])){
    $barang->attributes = $_GET['MABarangM'];
    $barang->bidang_nama = isset($_GET['MABarangM']['bidang_nama']) ? $_GET['MABarangM']['bidang_nama'] : null;
    $barang->subkelompok_nama = isset($_GET['MABarangM']['subkelompok_nama']) ? $_GET['MABarangM']['subkelompok_nama'] : null;
    $barang->kelompok_nama = isset($_GET['MABarangM']['kelompok_nama']) ? $_GET['MABarangM']['kelompok_nama'] : null;
    $barang->golongan_nama = isset($_GET['MABarangM']['golongan_nama']) ? $_GET['MABarangM']['golongan_nama'] : null;
    $barang->nopenerimaan = isset($_GET['MABarangM']['nopenerimaan']) ? $_GET['MABarangM']['nopenerimaan'] : null;
}



$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-v-grid',
    'dataProvider'=>$barang->searchDialogAset2(),
    'filter'=>$barang,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectKelompoks",
                            "onClick" => "
                            cekSelisihTerimaInventarisasi(\'$data->jmlterima\',\'$data->barang_id\',\'$data->terimapersdetail_id\');
                            setKodeRegister(\'$data->barang_id\');
                            $(\"#'.CHtml::activeId($modBarang,'barang_id').'\").val($data->barang_id);
                            $(\"#'.CHtml::activeId($modBarang,'barang_type').'\").val(\"$data->barang_type\");   
                            $(\"#'.CHtml::activeId($modBarang,'barang_image').'\").val(\"$data->barang_image\");     
                            $(\"#'.CHtml::activeId($modBarang,'barang_kode').'\").val(\"$data->barang_kode\");
                                $(\"#barang_nama\").val(\"$data->barang_nama\");
                            $(\"#terimapersdetail_id\").val(\"$data->terimapersdetail_id\");
                            $(\"#'.CHtml::activeId($modBarang,'barang_nama').'\").val(\"$data->barang_nama\");   
                            $(\"#'.CHtml::activeId($modBarang,'nopenerimaan').'\").val(\"$data->nopenerimaan\");   
                            $(\"#MAInvtanahT_invtanah_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_barang_id\").val($data->barang_id);   
                            $(\"#harga_tanah\").val(formatNumber($data->hargabeli));   
                            $(\"#MAInvgedungT_invgedung_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvgedungT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvgedungT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvperalatanT_invperalatan_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvperalatanT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvperalatanT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvasetlainT_invasetlain_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvasetlainT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvasetlainT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvjalanT_invjalan_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvjalanT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvjalanT_barang_id\").val($data->barang_id);   
                            $(\"#'.CHtml::activeId($modBarang,'barang_noseri').'\").val(\"$data->barang_noseri\");   
                            $(\"#'.CHtml::activeId($modBarang,'barang_thnbeli').'\").val($data->barang_thnbeli);     
                            $(\"#'.CHtml::activeId($modBarang,'barang_satuan').'\").val(\"$data->barang_satuan\");  
                            $(\"#'.CHtml::activeId($modBarang,'jmlterima').'\").val($data->jmlterima);
                            $(\"#'.CHtml::activeId($modBarang,'subsubkelompok_nama').'\").val(\"$data->subsubkelompok_nama\");
                            $(\"#'.CHtml::activeId($modBarang,'subsubkelompok_kode').'\").val(\"$data->subsubkelompok_kode\");
                            if(\"$data->barang_image\" != \"\"){
                                $(\"td.img img\").attr(\'src\',\''.Params::urlBarangDirectory().'\'+\"$data->barang_image\");
                            } else {
                                $(\"td.img img\").attr(\'src\',\''.Params::urlBarangDirectory().'no_photo.jpeg\');
                            }
                               $(\"#dialogBarang\").dialog(\"close\");
                               cekDisabled(\'form\');
                               return false;
                            "))
                        ',
        ),
        array(
            'header'=>'Nomor Perolehan',
            'type'=>'raw',
            'value'=>'$data->nopenerimaan',
            'filter'=>CHtml::activeTextField($barang, 'nopenerimaan'),
        ),
        array(
            'header'=>'Golongan',
            'name'=>'golongan_nama',
            'value'=>'isset($data->golongan_nama) ? $data->golongan_nama : ""',
            'filter'=>false,
            'filter'=>CHtml::activeTextField($barang, 'golongan_nama'),
            
        ),		
		array(
            'header'=>'Bidang',
            'name'=>'bidang_nama',
            'value'=>'isset($data->bidang_nama) ? $data->bidang_nama : ""'     
        ),
		array(
            'header'=>'Kelompok',
            'name'=>'kelompok_nama',
            'value'=>'isset($data->kelompok_nama) ? $data->kelompok_nama : ""'
            
        ),
		array(
            'header'=>'Kelompok',
            'name'=>'subkelompok_nama',
            'value'=>'$data->subkelompok_nama'
            
        ),
		array(
            'header'=>'Sub Sub Kelompok',
            'name'=>'subkelompok_nama',
            'value'=>'$data->subsubkelompok_nama'
            
        ),
        array(
            'header'=>'Nama Aset',
            'name'=>'barang_nama',
            'value'=>'$data->barang_nama'
            
        ),
        array(
            'name'=>'jmlterima',
            'header'=>'Jumlah Terima',
            'value'=>'$data->jmlterima." ".$data->barang_satuan',
        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php } ?>





