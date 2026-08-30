<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
    $jenisAset = "'". ParamsConst::KODE_GOLONGAN_GEDUNG_BANGUNAN."'";
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            <i class="glyphicon glyphicon-file"></i> Data Barang																	
        </div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group ">
                    <label class="control-label" for="bidang">
                        <?php echo CHtml::label("Nomor Perolehan <span class='required'>*</span>",'nopenerimaan');?>
                    </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'nopenerimaan',
                            'value' => $modBarang->nopenerimaan,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('GetBarangAset') . '",
                                    dataType: "json",
                                    data: {
                                        nopenerimaan: request.term,
                                        golongan_kode: ' . $jenisAset . ',
                                    },
                                    success: function (data) {
                                            response(data);
                                    }
                                })
                             }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nopenerimaan);
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nopenerimaan);
                                    $(\'#barang_nama\').val(ui.item.barang_nama);
                                    $(\'#MABarangM_jmlterima\').val(ui.item.jmlterima);
                                    $(\'#MABarangM_subsubkelompok_nama\').val(ui.item.subsubkelompok_nama);
                                    $(\'#MABarangM_subsubkelompok_kode\').val(ui.item.subsubkelompok_kode);
                                    
                                    $("#MAInvgedungT_invgedung_namabrg").val(ui.item.barang_nama);   
                                    $("#MAInvgedungT_barang_id").val(ui.item.barang_id);   
                                    $("#MAInvgedungT_terimapersdetail_id").val(ui.item.terimapersdetail_id);   
                                    
                                    cekSelisihTerimaInventarisasi(ui.item.jmlterima,ui.item.barang_id,ui.item.terimapersdetail_id);
                                    setKodeRegister(ui.item.barang_id);
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nomor Perolehan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogBarang'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="bidang">
                        <?php echo CHtml::label("Nama Aset <span class='required'>*</span>",'barang_nama');?>
                    </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'barang_nama',
                            'value' => $modBarang->barang_nama,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('GetBarangAset') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        golongan_kode: ' . $jenisAset . ',
                                    },
                                    success: function (data) {
                                            response(data);
                                    }
                                })
                             }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.barang_nama);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.barang_nama);
                                    $("#nopenerimaan").val(ui.item.nopenerimaan);
                                    $(\'#barang_nama\').val(ui.item.barang_nama);
                                    $(\'#MABarangM_jmlterima\').val(ui.item.jmlterima);
                                    $(\'#MABarangM_subsubkelompok_nama\').val(ui.item.subsubkelompok_nama);
                                    $(\'#MABarangM_subsubkelompok_kode\').val(ui.item.subsubkelompok_kode);
                                    
                                    $("#MAInvgedungT_invgedung_namabrg").val(ui.item.barang_nama);   
                                    $("#MAInvgedungT_barang_id").val(ui.item.barang_id);   
                                    $("#MAInvgedungT_terimapersdetail_id").val(ui.item.terimapersdetail_id);   
                                    
                                    cekSelisihTerimaInventarisasi(ui.item.jmlterima,ui.item.barang_id,ui.item.terimapersdetail_id);
                                    setKodeRegister(ui.item.barang_id);
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Ketik Nama Aset', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogBarang'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">
                        <?php echo CHtml::label("Jumlah Diterima Belum Inventarisasi",'jmlterima');?>
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modBarang, 'jmlterima', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <label class="control-label">
                        <?php echo CHtml::label("Sub-sub Kelompok Barang",'subsubkelompok_nama');?>
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modBarang, 'subsubkelompok_nama', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">
                        <?php echo CHtml::label("Kode Sub-sub Kelompok Barang",'subsubkelompok_kode');?>
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modBarang, 'subsubkelompok_kode', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group " hidden>
                    <label class="control-label">
                        <?php echo CHtml::label("No. Urut",'No Register');?>
                    </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modBarang, 'register_awal', array('readonly' => true, 'class' => 'span1')); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Data Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));

$barang = new MABarangM('searchDialogAsetGedung');
$barang->unsetAttributes();
$barang->golongan_kode = ParamsConst::KODE_GOLONGAN_GEDUNG_BANGUNAN;
if(isset($_GET['MABarangM'])){
    $barang->attributes = $_GET['MABarangM'];
    $barang->bidang_nama = isset($_GET['MABarangM']['bidang_nama']) ? $_GET['MABarangM']['bidang_nama'] : null;
    $barang->subkelompok_nama = isset($_GET['MABarangM']['subkelompok_nama']) ? $_GET['MABarangM']['subkelompok_nama'] : null;
    $barang->kelompok_nama = isset($_GET['MABarangM']['kelompok_nama']) ? $_GET['MABarangM']['kelompok_nama'] : null;
    $barang->golongan_nama = isset($_GET['MABarangM']['golongan_nama']) ? $_GET['MABarangM']['golongan_nama'] : null;
    $barang->nopenerimaan = isset($_GET['MABarangM']['nopenerimaan']) ? $_GET['MABarangM']['nopenerimaan'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-v-grid',
    'dataProvider' => $barang->searchDialogAsetGedung(),
    'filter' => $barang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectKelompoks",
                            "onClick" => "
                            
                            $(\"#' . CHtml::activeId($modBarang, 'subsubkelompok_nama') . '\").val(\"$data->subsubkelompok_nama\");     
                            $(\"#' . CHtml::activeId($modBarang, 'subsubkelompok_kode') . '\").val(\"$data->subsubkelompok_kode\");
                            $(\"#nopenerimaan\").val(\"$data->nopenerimaan\");
                            $(\"#barang_nama\").val(\"$data->barang_nama\");
                            
                            $(\"#MAInvgedungT_invgedung_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvgedungT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvgedungT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvgedungT_terimapersdetail_id\").val($data->terimapersdetail_id);   
                            
                            setKodeRegister(\'$data->barang_id\');
                            cekSelisihTerimaInventarisasi(\'$data->jmlterima\',\'$data->barang_id\',\'$data->terimapersdetail_id\');
                            
                            if(\"$data->barang_image\" != \"\"){
                                $(\"td.img img\").attr(\'src\',\'' . Params::urlBarangDirectory() . '\'+\"$data->barang_image\");
                            } else {
                                $(\"td.img img\").attr(\'src\',\'' . Params::urlBarangDirectory() . 'no_photo.jpeg\');
                            }
                               $(\"#dialogBarang\").dialog(\"close\");
                               cekDisabled(\'form\');
                               return false;
                            "))
                        ',
        ),

        array(
            'header'=>'Nomor Perolehan',
            'name'=>'nopenerimaan',
            'value'=>'isset($data->nopenerimaan) ? $data->nopenerimaan : ""',
            
        ),
        array(
            'header' => 'Nama Golongan',
            'name' => 'golongan_nama',
            'value' => 'isset($data->golongan_nama) ? $data->golongan_nama : ""',
            'filter' => false,

        ),
        array(
            'header' => 'Nama Kelompok',
            'name' => 'kelompok_nama',
            'value' => 'isset($data->kelompok_nama) ? $data->kelompok_nama : ""'

        ),
        array(
            'header' => 'Nama Sub Kelompok',
            'name' => 'subkelompok_nama',
            'value' => '$data->subkelompok_nama'

        ),
        array(
            'header' => 'Nama Aset',
            'name' => 'barang_nama',
            'value' => '$data->barang_nama'

        ),
        array(
            'header' => 'Total Penerimaan',
            'name' => 'jmlterima',
            'value' => '$data->jmlterima',
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>




