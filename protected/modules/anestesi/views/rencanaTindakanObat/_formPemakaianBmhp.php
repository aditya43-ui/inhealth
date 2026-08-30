<fieldset>
	<div class="control-group">
		<?php echo CHtml::label('Nama Paket BMHP','Nama Paket BMHP',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php $this->widget('MyJuiAutoComplete',array(
				'name'=>'paketBMHP',
				'value'=>'',
				'source'=>'js: function(request, response) {
					$.ajax({
						url: "'.$this->createUrl('AutocompletePemakaianBmhp').'",
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
						inputBMHP(ui.item.daftartindakan_id, ui.item.kelompokumur_id);
						$(this).val(\'\');
						return false;
					}',

				),
				'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','placeholder'=>'Paket BMHP'),
				'tombolDialog'=>array('idDialog'=>'dialogPaketBMHP'),
			)); ?>
		</div>
	</div>
    <div class="block-tabel">
        <h6>Tabel Pemakaian <b>Paket BMHP</b></h6>
			<table class="items table table-striped table-condensed" id="table-pemakaian-bmhp">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Uraian Tindakan BMHP</th>
                    <th>Nama Paket BMHP</th>
                    <th>Harga</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div>
            <b>Total BMHP : </b>
            <?php echo CHtml::textField("totHargaBmhp", 0,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>
        </div>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Paket BMHP =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPaketBMHP',
    'options'=>array(
        'title'=>'Paket BMHP',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>550,
        'resizable'=>false,
    ),
));
echo "Menampilkan 10 Data";
$filtersForm=new MyFiltersForm;
if (isset($_GET['MyFiltersForm']))
	$filtersForm->filters=$_GET['MyFiltersForm'];
$modBMHP = new ATPaketbmhpM('searchPaket');
    $modBMHP->unsetAttributes();    
    if(isset($_GET['ATPaketbmhpM'])) {
        $modBMHP->attributes = $_GET['ATPaketbmhpM'];
        $modBMHP->kelompokumurNama = $_GET['ATPaketbmhpM']['kelompokumurNama'];
        $modBMHP->daftartindakanNama = $_GET['ATPaketbmhpM']['daftartindakanNama'];
    }

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjpaketobat-alkes-m-grid',
    'dataProvider'=>$modBMHP->searchPaket(),
    'filter'=>$modBMHP,
	'template'=>"\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
			"id" => "selectObat",
			"onClick" => "inputBMHP($data->daftartindakan_id,$data->kelompokumur_id);return false;"))',
		),
		array(
			'header'=>'Daftar Tindakan',
			'name'=>'daftartindakanNama',
			'value'=>'$data->daftartindakan_nama',
		),
		array(
			'header'=>'Kelompok Umur',
			'name'=>'kelompokumurNama',
			'value'=>'$data->kelompokumur_nama',
		),
		array(
			'header'=>'Harga Pemakaian',
			'name'=>'hargapemakaian',
			'value'=>'number_format($data->hargapemakaian)',
		),                
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>