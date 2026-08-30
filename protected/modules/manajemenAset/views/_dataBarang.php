<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modBarang)) {
    $jenisAset = isset($jenisAset) ? $jenisAset : '';
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            <i class="entypo-credit-card"></i> Data Barang																	
        </div>
    </div>
    <div class="panel-body">
        
    <?php echo CHtml::css ('table.table tr td.img img{max-width:120px;max-height:120px;}'); ?>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
            <div class="control-group ">
                    <label class="control-label" for="bidang">
                        <?php echo CHtml::label("Nama Aset <span class='required'>*</span>",'barang_nama', array('class'=>'control-label'));?>
                        <?php // echo CHtml::activeLabel($modBarang, 'barang_nama',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                        <?php // echo CHtml::activeHiddenField($model,'barang_id'); ?>
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            
                                            'name'=>'barang_nama',
                                            'value'=>$modBarang->barang_nama,
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/getBarang') . '",
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
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                        'select' => 'js:function( event, ui ) { 
                                                        
                                                  $("#' . CHtml::activeId($modBarang, 'barang_id') . '").val(ui.item.barang_id);
                                                  $("#' . CHtml::activeId($modBarang, 'barang_type') . '").val(ui.item.barang_type);   
                                                  $("#' . CHtml::activeId($modBarang, 'barang_image') . '").val(ui.item.barang_image);     
                                                  $("#' . CHtml::activeId($modBarang, 'barang_kode') . '").val(ui.item.barang_kode);
                                                  $("#' . CHtml::activeId($modBarang, 'barang_nama') . '").val(ui.item.barang_nama);   
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
                                                  $("#' . CHtml::activeId($modBarang, 'barang_noseri') . '").val(ui.item.barang_noseri);   
                                                  $("#' . CHtml::activeId($modBarang, 'barang_thnbeli') . '").val(ui.item.barang_thnbeli);     
                                                  $("#' . CHtml::activeId($modBarang, 'barang_satuan') . '").val(ui.item.barang_satuan);  
                                                  $("#' . CHtml::activeId($modBarang, 'barang_jmldlmkemasan') . '").val(ui.item.barang_jmldlmkemasan);
                                                      
                                                    if(ui.item.barang_image != null){
                                                        $("td.img img").attr(\'src\',\'' . Params::urlBarangDirectory() . '\'+ui.item.barang_image);
                                                    } else {
                                                        $("td.img img").attr(\'src\',\'' . Params::urlBarangDirectory() . 'no_photo.jpeg\');
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
            </td>            
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_type">
                        <?php echo CHtml::label("Tipe Aset",'barang_nama', array('class'=>'control-label'));?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_type', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td></td>
            
        </tr>
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_kode">
                        <?php echo CHtml::label("Kode Aset",'barang_nama', array('class'=>'control-label'));?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_kode', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_nama">
                        <?php echo CHtml::label("Nama Aset",'barang_nama', array('class'=>'control-label'));?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_nama', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            
        </tr>
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_thnbeli">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_thnbeli',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_thnbeli', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_thnbeli">
                        <?php echo CHtml::label("Satuan Aset",'barang_nama', array('class'=>'control-label'));?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_satuan', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            
        </tr>
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_jmldlmkemasan">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_jmldlmkemasan',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang,'barang_jmldlmkemasan', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_jmldlmkemasan">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_noseri',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_noseri', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            
            
            </tr>
    </table>
    </div>
    <?php
    //========= Dialog buat cari data Bidang =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogBarang',
        'options' => array(
            'title' => 'Data Barang',
            'autoOpen' => false,
            'modal' => true,
            'width' => 600,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $barang = new MABarangM('searchDialog');
    $barang->unsetAttributes();
    $barang->golongan_kode = isset($jenisAset) ? $jenisAset : '';
    if (isset($_GET['MABarangM'])) {
        $barang->attributes = $_GET['MABarangM'];
        $barang->bidang_nama = isset($_GET['MABarangM']['bidang_nama']) ? $_GET['MABarangM']['bidang_nama'] : null;
        $barang->subkelompok_nama = isset($_GET['MABarangM']['subkelompok_nama']) ? $_GET['MABarangM']['subkelompok_nama'] : null;
        $barang->kelompok_nama = isset($_GET['MABarangM']['kelompok_nama']) ? $_GET['MABarangM']['kelompok_nama'] : null;
        $barang->golongan_nama = isset($_GET['MABarangM']['golongan_nama']) ? $_GET['MABarangM']['golongan_nama'] : null;
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'barang-v-grid',
        'dataProvider' => $barang->searchDialog(),
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
							setKodeRegister(\'$data->barang_id\');
                            $(\"#' . CHtml::activeId($modBarang, 'barang_id') . '\").val($data->barang_id);
                            $(\"#' . CHtml::activeId($modBarang, 'barang_type') . '\").val(\"$data->barang_type\");   
                            $(\"#' . CHtml::activeId($modBarang, 'barang_image') . '\").val(\"$data->barang_image\");     
                            $(\"#' . CHtml::activeId($modBarang, 'barang_kode') . '\").val(\"$data->barang_kode\");
                                $(\"#barang_nama\").val(\"$data->barang_nama\");
                            $(\"#' . CHtml::activeId($modBarang, 'barang_nama') . '\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_invtanah_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_barang_id\").val($data->barang_id);   
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
                            $(\"#' . CHtml::activeId($modBarang, 'barang_noseri') . '\").val(\"$data->barang_noseri\");   
                            $(\"#' . CHtml::activeId($modBarang, 'barang_thnbeli') . '\").val($data->barang_thnbeli);     
                            $(\"#' . CHtml::activeId($modBarang, 'barang_satuan') . '\").val(\"$data->barang_satuan\");  
                            $(\"#' . CHtml::activeId($modBarang, 'barang_jmldlmkemasan') . '\").val($data->barang_jmldlmkemasan);
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
                'header' => 'Nama Golongan',
                'name' => 'golongan_nama',
                'value' => 'isset($data->golongan_nama) ? $data->golongan_nama : ""',
                'filter' => false,

            ),
            //		array(
            //            'header'=>'Nama Bidang',
            //            'name'=>'bidang_nama',
            //            'value'=>'isset($data->bidang_nama) ? $data->bidang->bidang_nama : ""'     
            //        ),
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
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>
<?php } ?>

