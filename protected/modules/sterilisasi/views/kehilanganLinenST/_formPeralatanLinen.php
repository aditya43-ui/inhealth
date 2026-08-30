<?php

/**
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-1338
 * - digunakan 
 */
?>
<div class="row" id="formLinen">
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Jenis Peralatan</label>
            <div class="controls">
                <?php //echo Chtml::dropDownList('jenis_peralatan','',array('Peralatan'=>'Peralatan','Linen'=>'Linen'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange'=>'peralatanBarang()', 'onkeypress' => "return $(this).focusNextInputField(event)",)); 
                ?>
                <?php echo Chtml::dropDownList('jenisperalatan', '', LookupM::getItemsUrutan('jenisperalatan'), array('onchange' => 'refreshDialog();', 'empty' => '-- Pilih --', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event)",)); //'onchange'=>'peralatanBarang()', 
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Nama Peralatan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('peralatansterilisasi_id', '', array('onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                <?php echo CHtml::hiddenField('barang_id', '', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo CHtml::hiddenField('map_id', '', array('onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaperalatan',
                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
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
                                                                    $(this).val("");
                                                                    return false;
                                                            }',
                        'select' => 'js:function( event, ui ) {
                                                                    $(this).val(ui.item.value);
                                                                    $("#peralatansterilisasi_id").val(ui.item.peralatansterilisasi_id);                                                                    
                                                                    return false;
                                                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Peralatan',
                        'class' => 'custom-only',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPeralatan', 'idTombol' => 'tombolPeralatan'),
                ));
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Jumlah</label>
            <div class="controls">
                <?php echo Chtml::textField('jml', '1', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                &nbsp;&nbsp;&nbsp;
                <?php
                echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'inputPeralatanLinen();return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "inputPeralatanLinen();return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Peralatan Strelisasi",
                    )
                );
                ?>
            </div>
        </div>

        <div class="control-group">
            <label class='control-label'>Status</label>
            <div class="controls">
                <?php echo Chtml::dropDownList('keadaanperalatan', '', array(Params::JENISPERAWATAN_KEHILANGAN => Params::JENISPERAWATAN_KEHILANGAN), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

    </div>
</div>

<?php
//========= Dialog buat cari Peralatan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPeralatanOld',
    'options' => array(
        'title' => 'Daftar Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));

$modPeralatan = new STBarangV('searchDialog');
$modPeralatan->unsetAttributes();
if (isset($_GET['STBarangV'])) {
    $modPeralatan->attributes = $_GET['STBarangV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-v-grid',
    'dataProvider' => $modPeralatan->searchDialog(),
    'filter' => $modPeralatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
			"id" => "selectRegister",
			"onClick" => "
			  $(\'#barang_id\').val(\'$data->barang_id\');
			  $(\'#namaPeralatan\').val(\'$data->barang_nama\');
			  $(\'#dialogPeralatan\').dialog(\'close\');
			  return false;"))',
        ),
        array(
            'header' => 'Tipe',
            'name' => 'barang_type',
            'type' => 'raw',
            'value' => '$data->barang_type'
        ),
        array(
            'header' => 'Kode',
            'name' => 'barang_kode',
            'type' => 'raw',
            'value' => '$data->barang_kode'
        ),
        array(
            'header' => 'Nama',
            'name' => 'barang_nama',
            'type' => 'raw',
            'value' => '$data->barang_nama'
        ),/*
		array(
		  'name'=>'golongan_nama',
		  'type'=>'raw',
		  'value'=>'$data->golongan_nama'
		),*/

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
//========= Dialog buat cari Nama Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLinen',
    'options' => array(
        'title' => 'Daftar Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));

$modLinen = new STLinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['STLinenM'])) {
    $modLinen->attributes = $_GET['STLinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'linen-m-grid',
    'dataProvider' => $modLinen->searchDialog(),
    'filter' => $modLinen,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
        "id" => "selectLinen",
        "onClick" => "
          $(\'#linen_id\').val(\'$data->linen_id\');
		  $(\'#barang_id\').val(\'$data->barang_id\');
          $(\'#namalinen\').val(\'$data->namalinen\');
          $(\'#dialogLinen\').dialog(\'close\');
          return false;"))',
        ),

        array(
            'name' => 'namalinen',
            'type' => 'raw',
            'value' => '$data->namalinen'
        ),
        array(
            'name' => 'noregisterlinen',
            'type' => 'raw',
            'value' => '$data->noregisterlinen'
        ),
        array(
            'header' => 'Tanggal Register',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglregisterlinen)'
        ),
        array(
            'header' => 'Barang',
            'type' => 'raw',
            'value' => 'isset($data->barang_id)?$data->getNamaBarang($data->barang_id):""'
        ),
        array(
            'header' => 'Bahan',
            'type' => 'raw',
            'value' => 'isset($data->bahan)?$data->bahan->bahanlinen_nama:""'
        ),
        //		array(
        //		  'header'=>'Jenis',
        //		  'type'=>'raw',
        //		  'value'=>'isset($data->jenislinen_id)?$data->jenis->jenislinen_nama:""'
        //		),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>