<fieldset>
    <div class="control-group">
		<?php echo CHtml::label('Alat Medis','Alat Medis',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('MyJuiAutoComplete',array(
				'name'=>'alatmedis_nama',
				'value'=>'',
				'source'=>'js: function(request, response) {
					$.ajax({
						url: "'.$this->createUrl('AutocompleteAlatMedis').'",
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
						$(this).val( ui.item.label);
						return false;
					}',
				   'select'=>'js:function( event, ui ) {
						inputAlatMedis(ui.item.alatmedis_id);
						$(this).val(ui.item.alatmedis_nama);
						return false;
					}',

				),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','placeholder'=>'Alat Medis'),
				'tombolDialog'=>array('idDialog'=>'dialogAlatmedis'),
			)); ?>
		</div>
	</div>
    <div class="block-tabel">
        <h6>Tabel Pemakaian <b>Alat Medis</b></h6>
        <table class="items table table-striped table-condensed" id="table-pemakaian-alatmedis">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Alat Medis</th>
                    <th>Harga</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlatmedis',
    'options'=>array(
        'title'=>'Alat Medis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>550,
        'resizable'=>false,
    ),
));
//echo "Menampilkan 10 Data";
$modAlat = new AlatmedisM('search');
$modAlat->unsetAttributes();
if(isset($_GET['AlatmedisM']))
    $modAlat->attributes = $_GET['AlatmedisM'];
//    $modAlat->instalasi_id = Yii::app()->user->getState('instalasi_id');

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'almes-m-grid',
	'dataProvider'=>$modAlat->search(),
	'filter'=>$modAlat,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectObat",
				"onClick" => "
					$(\'#alatmedis_nama\').val(\'$data->alatmedis_nama\');
					inputAlatMedis($data->alatmedis_id);
					$(\'#dialogAlatmedis\').dialog(\"close\");
					return false;"))',
		),
		'jenisalatmedis.jenisalatmedis_nama',
		'alatmedis_nama',		
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>