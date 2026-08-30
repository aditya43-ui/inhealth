<div class="row" id="formDetailBarang">
    <div class="col-sm-6">   
        <div class="control-group">
            <label class='control-label'>No. Kantong Darah <span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::hiddenField('jeniskantongdarah_id'); ?>
                <?php echo CHtml::hiddenField('komponendarah_id'); ?>
                <?php echo CHtml::hiddenField('stokkantongdarah_id'); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'nomorbarcode',
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
                            'placeholder' => 'Nama Kantong Darah',
                            'class' => 'span3 custom-only',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogKantongDarah'),
                    )); 
                ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
    </div>
</div>
<?php
/* ========= Dialog buat cari Kantong Darah =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Daftar Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modKantong = new BDInfostokkantongdarahV('searchDialogPengujianKompatibilitas');
$modKantong->unsetAttributes();
if (isset($_GET['BDInfostokkantongdarahV'])){
    $modKantong->attributes = $_GET['BDInfostokkantongdarahV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'kantong-m-grid',
    'dataProvider'=>$modKantong->searchDialogPengujianKompatibilitas(),
    'filter'=>$modKantong,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
					$(\'#jeniskantongdarah_id\').val(\'$data->jeniskantongdarah_id\');
					$(\'#komponendarah_id\').val(\'$data->komponendarah_id\');
                                        $(\'#nomorbarcode\').val(\'$data->no_kantongdarah\');
                                        $(\'#stokkantongdarah_id\').val(\'$data->stokkantongdarah_id\');
					inputKantong();                                       
                                        $(\'#dialogKantongDarah\').dialog(\'close\');
					return false;"))',
        ),
        array(
            'header'=>'No. Identitas Pendonor',
            'name'=>'no_identitas',
            'value'=>'$data->no_identitas',
        ),
        array(
            'header'=>'Nomor Formulir',
             'name'=>'no_formulir',
            'value'=>'$data->no_formulir',
        ),
        array(
            'header'=>'Nomor Kantong Darah',
            'name'=>'no_kantongdarah',
            'value'=>'$data->no_kantongdarah',
        ),
        array(
            'header'=>'Golongan Darah',
            'name'=>'gol_darah',
            'value'=>'$data->gol_darah',
            'filter'=> CHtml::activeDropDownList($modKantong, 'gol_darah', LookupM::getItems('golongandarah'),array('empty' => '-- Pilih --'))
        ),
        array(
            'header'=>'Rhesus',
            'name'=>'rhesus',
            'value'=>'$data->rhesus',
        ),
        array(
            'header'=>'Jenis Kantong',
            'name'=>'nama_jenis',
            'value'=>'$data->nama_jenis',
       ),               
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
 * 
 */
?>


