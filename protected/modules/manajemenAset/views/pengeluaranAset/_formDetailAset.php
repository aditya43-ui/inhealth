
<div class="row-fluid" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group ">
            <label class='control-label'>Barang</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('invperalatan_id'); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'namaBarang',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                                url: "'.$this->createUrl('AutocompleteBarang').'",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                         'options'=>array(
                            'showAnim'=>'fold',
                            'minLength' => 3,
                            'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                            'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#invperalatan_id").val(ui.item.invperalatan_id);
                                $("#namaBarang").val(ui.item.invperalatan_namabrg);
                                return false;
                            }',
                        ),
                        'htmlOptions'=>array(
                            'placeholder' => 'Ketik Nama Barang',
                            'class' => 'span3 custom-only',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogBarang'),
                    )); 
                ?>
            </div>
        </div>
    </div>
      <div class="col-sm-6">
        <div class="control-group">
            <div class="controls">
            <?php
                echo CHtml::htmlButton('<i class="entypo-plus"></i>', 
                    array('onclick' => 'inputBarang(); return false;',
                        'class' => 'btn btn-primary',
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Barang",));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBarang = new MAInvperalatanT('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['MAInvperalatanT'])){
    $modBarang->attributes = $_GET['MAInvperalatanT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->searchDialog(),
    'filter'=>$modBarang,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
					$(\'#invperalatan_id\').val(\'$data->invperalatan_id\');
					$(\'#namaBarang\').val(\'$data->invperalatan_namabrg\');
					$(\'#dialogBarang\').dialog(\'close\');
					return false;"))',
        ),
        array(
            'header'=>'Nama Barang',
            'name'=>'invperalatan_namabrg',
            'value'=>'$data->invperalatan_namabrg',
        ),
        array(
          'header'=>'Kode Aset',
          'name'=>'invperalatan_namabrg',
          'value'=>'$data->invperalatan_kode'
        ),
        
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>