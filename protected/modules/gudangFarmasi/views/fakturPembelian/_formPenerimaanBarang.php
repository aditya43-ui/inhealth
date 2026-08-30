<div class = "row-fluid">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('fakturpembelian_id',$modFakturPembelian->fakturpembelian_id, array('class'=>'span3 isRequired','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
        <?php // echo $form->textFieldRow($modPenerimaanBarang,'noterima', array('class'=>'span3 isRequired','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
		<?php echo CHtml::activehiddenField($modPenerimaanBarang,'penerimaanbarang_id',array('readonly'=>TRUE));?>

		<div class="control-group ">
            <?php echo CHtml::label("No Permintaan","",array('class' => 'control-label')) ?>
            <div class="controls">
			<?php 
					echo $form->hiddenField($modPenerimaanBarang,'permintaanpembelian_id',array('readonly'=>true));
					echo $form->textField($modPenerimaanBarang,'nopermintaan',array('readonly' => true, 'class'=>'span3'));
				?>
            </div>
        </div>

		<div class="control-group ">
			<?php echo $form->labelEx($modPenerimaanBarang,'noterima', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php 
				
				if (!isset($_GET['penerimaanbarang_id'])){
					$this->widget('MyJuiAutoComplete',array(
						'model'=>$modPenerimaanBarang,
						'attribute'=>'noterima',
						'sourceUrl'=> $this->createUrl('AutoCompletePenerimaanBarang'),
						'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 2,
						   'select'=>'js:function( event, ui ) {
								$("#'.CHtml::activeId($modPenerimaanBarang,'permintaanpembelian_id').'").val(ui.item.permintaanpembelian_id);
								$("#'.CHtml::activeId($modPenerimaanBarang,'nopermintaan').'").val(ui.item.pegawainopermintaan);
								$("#'.CHtml::activeId($modPenerimaanBarang,'noterima').'").val(ui.item.noterima);
								$("#'.CHtml::activeId($modPenerimaanBarang,'penerimaanbarang_id').'").val(ui.item.penerimaanbarang_id);
								$("#'.CHtml::activeId($modPenerimaanBarang,'tglterima').'").val(ui.item.tglterima);
								$("#'.CHtml::activeId($modPenerimaanBarang,'supplier_id').'").val(ui.item.supplier_id);
								$("#'.CHtml::activeId($modPenerimaanBarang,'supplier_nama').'").val(ui.item.supplier_nama);
								$("#'.CHtml::activeId($modPenerimaanBarang,'pegawaimengetahui_id').'").val(ui.item.pegawaimengetahui_id);
								$("#'.CHtml::activeId($modPenerimaanBarang,'mengetahui_nama').'").val(ui.item.pegawaimengetahui_nama);
								$("#'.CHtml::activeId($modPenerimaanBarang,'pegawaimenyetujui_id').'").val(ui.item.pegawaimenyetujui_id);
								$("#'.CHtml::activeId($modPenerimaanBarang,'menyetujui_nama').'").val(ui.item.pegawaimenyetujui_nama);
								$("#'.CHtml::activeId($modPenerimaanBarang,'pegawai_nama').'").val(ui.item.pegawaipenerima_nama);
								$("#'.CHtml::activeId($modPenerimaanBarang,'statuspenerimaan').'").val(ui.item.statuspenerimaan);
								$("#'.CHtml::activeId($modPenerimaanBarang,'keteranganterima').'").val(ui.item.keteranganterima);
								$("#totneto").val(replaceseparators(ui.item.harganettotal));
								$("#totdiskon").val(replaceseparators(ui.item.totaljmldiscount));
								$("#totppn").val(replaceseparators(ui.item.totalpajakppn));
								$("#totpph").val(replaceseparators(ui.item.totalpajakpph));
								$("#tothargabruto").val(replaceseparators(ui.item.totalharga));
								
								$("#'.CHtml::activeId($modPenerimaanBarang,'penerimaanbarang_id').'").val(ui.item.penerimaanbarang_id)
								setFakturObatAlkes(ui.item.penerimaanbarang_id);
							}',
						),
						'htmlOptions'=>array(
							'disabled'=>false,
							'onkeypress'=>"$(this).focusNextInputField(event)",'class'=>'span3 ','readonly'=>FALSE),
						'tombolDialog' => array('idDialog' => 'dialogPenerimaanBarang'),
						)); 
				}else{
					echo $form->textField($modPenerimaanBarang,'noterima',array('readonly' => true, 'class'=>'span3'));
				}
				?>
			</div>
		</div>		    
        <div class="control-group ">
            <?php echo $form->labelEx($modPenerimaanBarang,'tglterima', array('class'=>'control-label')) ?>
            <div class="controls">
				<?php echo $form->textField($modPenerimaanBarang,'tglterima', array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
            </div>
        </div>
		
		<div class="control-group">
			<?php echo CHtml::label("Pegawai Penerima","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo $form->textField($modPenerimaanBarang,'pegawai_nama',array('readonly' => true, 'class'=>'span3'));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Pegawai Mengetahui","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo $form->hiddenField($modPenerimaanBarang,'pegawaimengetahui_id',array('readonly'=>true));
					echo $form->textField($modPenerimaanBarang,'mengetahui_nama',array('readonly' => true, 'class'=>'span3'));
				?>
			</div>
		</div>
		
		<div class="control-group hide">
			<?php // echo CHtml::label("Pegawai Menyetujui","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php // 
					echo $form->hiddenField($modPenerimaanBarang,'pegawaimenyetujui_id',array('readonly'=>true));
					echo $form->textField($modPenerimaanBarang,'menyetujui_nama',array('readonly' => true, 'class'=>'span3'));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Status Penerimaan","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo $form->textField($modPenerimaanBarang,'statuspenerimaan',array('readonly' => true, 'class'=>'span3'));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Keterangan","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo $form->textField($modPenerimaanBarang,'keteranganterima',array('readonly' => true, 'class'=>'span3'));
				?>
			</div>
		</div>
		
    </div>
    <div class="col-sm-6">
        <div class="control-group">
			<?php echo CHtml::label("Supplier",'',array( 'class'=>'control-label')) ?>
			<?php echo CHtml::activehiddenField($modPenerimaanBarang,'supplier_id',array('readonly'=>TRUE));?>
			<div class="controls">
			<?php echo $form->textField($modPenerimaanBarang,'supplier_nama', array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
			</div>
        </div>
		
		<div class="control-group">
			<?php echo CHtml::label("Total Harga Bruto","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
                                    echo (Params::cekHiddenHargaGudangFarmasi()==true) ? CHtml::textField('totneto',$modPenerimaanBarang->harganetto,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;')) : CHtml::passwordField('totneto',$modPenerimaanBarang->harganetto,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;'));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Total Keringanan","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo CHtml::textField('totdiskon',$modPenerimaanBarang->jmldiscount,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;'));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Total PPN","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo CHtml::textField('totppn',$modPenerimaanBarang->totalpajakppn,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;'));
				?>
			</div>
		</div>

		<div class="control-group">
			<?php echo CHtml::label("Total PPh","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo CHtml::textField('totpph',$modPenerimaanBarang->totalpajakpph,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;'));
				?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::label("Total Harga Netto","",array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					echo (Params::cekHiddenHargaGudangFarmasi()==true)?  CHtml::textField('tothargabruto',$modPenerimaanBarang->totalharga,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;')) : CHtml::passwordField('tothargabruto',$modPenerimaanBarang->totalharga,array('readonly' => true, 'class'=>'span3 integer-decimal','style'=>'text-align:right;'));
				?>
			</div>
		</div>
    </div>
</div>
<?php 
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPenerimaanBarang',
    'options'=>array(
        'title'=>'Penerimaan Supplier Farmasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$format = new MyFormatter();
$modTerimaPers = new GFInformasipenerimaanbarangV();
if (isset($_GET['GFInformasipenerimaanbarangV'])){
    $modTerimaPers->attributes = $_GET['GFInformasipenerimaanbarangV'];
    $modTerimaPers->pegawaipenerima_id = isset($_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_id'])?$_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_id']:null;
	//$modTerimaPers->pegawaipenerima_id = isset($_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_nama'])?$_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_nama']:null;
	$modTerimaPers->pegawaipenerima_nama = isset($_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_nama'])?$_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_nama']:null;
//    $modTerimaPers->tglterima = $format->formatDateTimeForDb($_GET['GFInformasipenerimaanbarangV']['tglterima']);
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'permintaan-m-grid',
	'dataProvider'=>$modTerimaPers->searchDialog(),
	'filter'=>$modTerimaPers,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPenerimaan",
									"onClick" => "	$(\"#'.CHtml::activeId($modPenerimaanBarang,'permintaanpembelian_id').'\").val(\"$data->permintaanpembelian_id\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'nopermintaan').'\").val(\"$data->nopermintaan\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'noterima').'\").val(\"$data->noterima\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'tglterima').'\").val(\"".MyFormatter::formatDateTimeForUser($data->tglterima)."\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'supplier_id').'\").val(\"$data->supplier_id\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'supplier_nama').'\").val(\"$data->supplier_nama\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'penerimaanbarang_id').'\").val(\"$data->penerimaanbarang_id\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimengetahui_id').'\").val(\"$data->pegawaimengetahui_id\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'mengetahui_nama').'\").val(\"$data->PegawaimengetahuiLengkap\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawaimenyetujui_id').'\").val(\"$data->pegawaimenyetujui_id\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'menyetujui_nama').'\").val(\"$data->PegawaimenyetujuiLengkap\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'pegawai_nama').'\").val(\"$data->PegawaiPenerima\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'statuspenerimaan').'\").val(\"$data->statuspenerimaan\");
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'keteranganterima').'\").val(\"$data->keteranganterima\");
													$(\"#totneto\").val(replaceseparators($data->harganettotal));
													$(\"#totdiskon\").val(replaceseparators($data->totaljmldiscount));
													$(\"#totppn\").val(replaceseparators($data->totalpajakppn));
													$(\"#totpph\").val(replaceseparators($data->totalpajakpph));
													$(\"#tothargabruto\").val(replaceseparators($data->totalharga));
													$(\"#'.CHtml::activeId($modPenerimaanBarang,'penerimaanbarang_id').'\").val(\"$data->penerimaanbarang_id\");
													$(\"#dialogPenerimaanBarang\").dialog(\"close\");   
													setFakturObatAlkes(\"$data->penerimaanbarang_id\");
                                        "))',
                ),
				'noterima',
                array(
			'name' => 'tglterima',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)',
                    'filter' => false,
		),
                array(
                        'header'=>'Supplier',
                        'name'=>'supplier_nama',
                ),
				'pegawaimengetahui_nama',
				array(
					'header' => 'Pegawai Penerima',
					'name' => 'pegawaipenerima_nama',
					'value' => function($data){
						$peg = GFPenerimaanBarangT::model()->findByPk($data->penerimaanbarang_id);
						
						return $peg->pegawai->namaLengkap;
					}
				),
				array(
					'header' => 'Total Harga Bruto',
					'value' => '"Rp. ".MyFormatter::formatNumberForPrint($data->totalharga,2)',
					'htmlOptions' => array('style' => 'text-align:right;')
				),
	),
        'afterAjaxUpdate'=>'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();

//========= end Permintaan dialog =============================
?>