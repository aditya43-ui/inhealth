<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
    $jenisAset = "'".ParamsConst::KODE_GOLONGAN_MESIN_ALAT."'";
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
                        <?php echo CHtml::label("Nama Aset <span class='required'>*</span>",'barang_nama');?>
                    </label>
                    <div class="controls">
                        <?php
                        echo CHtml::hiddenField("temp_barang_nama","",['class'=>'temp_barang_nama']);
                        echo CHtml::hiddenField("temp_barang_id","",['class'=>'temp_barang_id']);
                        
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'barang_nama',
                            'value' => $modBarang->barang_nama,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/actionAutoComplete/getBarang') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        type: "'.ParamsConst::TYPE_BARANG_INVENTARIS.'"
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
                                'select'=>'js:function( event, ui ) {
                                    setBarang(ui.item);
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
                        <?php echo CHtml::label("Jumlah Aset",'jmlterima');?>
                    </label>
                    <div class="controls">
                        
                       <?php 
                        echo CHtml::hiddenField("temp_jmlterima","",['class'=>'temp_jmlterima']);
                        echo CHtml::activeTextField($modBarang, 'jmlterima', array('class'=>'span3 numbers-only jumlahaset','onblur'=>'setDetailInvAlat(this);')); ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <label class="control-label">
                        <?php echo CHtml::label("Sub-sub Kelompok Barang",'subsubkelompok_nama');?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'subsubkelompok_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">
                        <?php echo CHtml::label("Kode Sub-sub Kelompok Barang",'subsubkelompok_kode');?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'subsubkelompok_kode', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">
                        <?php echo CHtml::label("No. Urut",'No Register');?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'register_awal', array('readonly'=>true,'class'=>'span1')); ?>
                        &nbsp;<label>s/d</label>&nbsp;
                       <?php echo CHtml::activeTextField($modBarang, 'register_akhir', array('readonly'=>true,'class'=>'span1')); ?>
                    </div>
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
        'title'=>'Data Aset',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>700,
        'height'=>600,
        'resizable'=>false,
    ),
));

$barang= new MABarangM('searchDialogAsetAlat');
$barang->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;
if(isset($_GET['MABarangM'])){
    $barang->attributes = $_GET['MABarangM'];
    $barang->bidang_nama = isset($_GET['MABarangM']['bidang_nama']) ? $_GET['MABarangM']['bidang_nama'] : null;
    $barang->subkelompok_nama = isset($_GET['MABarangM']['subkelompok_nama']) ? $_GET['MABarangM']['subkelompok_nama'] : null;
    $barang->kelompok_nama = isset($_GET['MABarangM']['kelompok_nama']) ? $_GET['MABarangM']['kelompok_nama'] : null;
    $barang->golongan_nama = isset($_GET['MABarangM']['golongan_nama']) ? $_GET['MABarangM']['golongan_nama'] : null;
    $barang->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-v-grid',
    'dataProvider'=>$barang->searchDialog(),
    'filter'=>$barang,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data){
                $dt = $data->attributes;
                $dt['subsubkelompok_nama'] = $data->subsubkelompok_nama;
                $dt['subsubkelompok_kode'] = $data->subsubkelompok_kode;
                $res = json_encode($dt);
                
                return CHtml::Link("<i class='icon-form-check'></i>",
                        "javascript:;",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectKelompoks",
                            "onClick" => "                            
                                setBarang(".$res.");
                               return false;
                            "));
            },
        ),        		        
        array(
            'header'=>'Nama Golongan',
            'name'=>'golongan_nama',
            'value'=>'!empty($data->golongan_nama) ? $data->golongan_nama : ""',
            'filter'=>false,
            
        ),
        array(
            'header'=>'Nama Kelompok',
            'name'=>'kelompok_nama',
            'value'=>'!empty($data->kelompok_nama) ? $data->kelompok_nama : ""'
            
        ),
        array(
            'header'=>'Nama Sub Kelompok',
            'name'=>'subkelompok_nama',
            'value'=>'$data->subkelompok_nama'
            
        ),
        array(
            'header'=>'Nama Aset',
            'name'=>'barang_nama',
            'value'=>'$data->barang_nama'
            
        ),       
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();


?>


<script>
    function setBarang(data){
        setKodeRegister(data.barang_id);
        $('#<?= CHtml::activeId($modBarang,'subsubkelompok_nama') ?>').val(data.subsubkelompok_nama);     
        $('#<?= CHtml::activeId($modBarang,'subsubkelompok_kode') ?>').val(data.subsubkelompok_kode);                 
        $("#nopenerimaan").val(data.nopenerimaan);
        $("#barang_nama").val(data.barang_nama);
        $(".barang_id").val(data.barang_id);
        $("#MAInvperalatanT_invperalatan_namabrg").val(data.barang_nama);
        $("#MAInvperalatanT_barang_nama").val(data.barang_nama);
        $("#MAInvperalatanT_barang_id").val(data.barang_id);
                                     
        if(data.barang_image != ''){
            $('td.img img').attr('src','<?= Params::urlBarangDirectory().'/' ?>'+data.barang_image);
        } else {
            $('td.img img').attr('src','<?= Params::urlBarangDirectory().'/no_photo.jpeg' ?>');
        }
        
        var jumlah = $("#<?php echo CHtml::activeId($modBarang,'jmlterima'); ?>").val();
        if (jumlah > 0){
            setDetailInvAlat($('.jumlahaset'));
        }else{
            $("#temp_barang_id").val(data.barang_id);
            $("#temp_barang_nama").val(data.barang_nama);
        }
        
        $('#dialogBarang').dialog('close');
        cekDisabled('form');
    }
</script>

