<?php $this->widget('bootstrap.widgets.BootAlert'); ?>  
<div class="row">
    <div class="col-sm-6">
		
		<div class="control-group">			
            <?php echo CHtml::label("No Faktur <span class='required'>*</span>", 'nofaktur',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php 
				if (!isset($_GET['frame'])){
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modFakturBeli,
							'attribute'=>'nofaktur',
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('AutocompleteFakturFarmasi').'",
											   dataType: "json",
											   data: {
												   no_faktur: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
							'options'=>array(
								'minLength' => 3,
								'focus'=> 'js:function( event, ui ) {
									$(this).val(ui.item.label2);
									$(this).val("");
									return false;
								}',
								'select'=>'js:function( event, ui ) {
									$(this).val(ui.item.label2);
									loadFakturPembelian(ui.item.value);
									return false;
								}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogFaktur'),
							'htmlOptions'=>array('placeholder'=>'No. Faktur','class'=>'all-caps','rel'=>'tooltip','title'=>'No. faktur / klik icon untuk mencari data faktur',
								'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
								),
						)); 
						
					//echo CHtml::activeHiddenField($modFakturBeli, 'nofaktur_ubah', array('readonly'=>false));
				}else{
					$modFakturBeli->nofaktur_ubah = $modFakturBeli->nofaktur;
					echo CHtml::activeTextField($modFakturBeli, 'nofaktur_ubah', array('readonly'=>true,'onblur'=>'ubahNoFaktur(this);'));
				}
				
                ?>
				<?php echo CHtml::hiddenField('FAPendaftaranT[fakturpembelian_id]',$modFakturBeli->fakturpembelian_id, array('readonly'=>true)); ?>
                <?php //echo CHtml::textField('FAPasienM[nofaktur]', $modFakturBeli->nofaktur, array('readonly'=>true)); ?>
            </div>
		</div>
		
		<?php 
			if (!isset($_GET['frame'])){
		?>
		<div class="control-group" id="mengubahnofaktur">
			<label class="control-label">
				<?php echo CHtml::checkBox("ubahfaktur",false,array('onclick'=>'allowUbahFaktur(this);')) ?> Ubah No Faktur
			</label>
			<div class="controls">
				<?php echo CHtml::activeTextField($modFakturBeli, 'nofaktur_ubah', array('readonly'=>true,'onblur'=>'ubahNoFaktur(this);')); ?>
			</div>
		</div>
		
		<div class="control-group">
			<?php echo CHtml::activeLabel($modFakturBeli, 'tglfaktur',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('FAPendaftaranT[tglfaktur]', MyFormatter::formatDateTimeForUser($modFakturBeli->tglfaktur), array('readonly'=>true)); ?>
			</div>
		</div>                                    
			<?php } ?>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modFakturBeli, 'tgljatuhtempo',array('class'=>'control-label')); ?>
			<div class="controls">		
				<?php echo CHtml::textField('FAPendaftaranT[tgljatuhtempo]', MyFormatter::formatDateTimeForUser($modFakturBeli->tgljatuhtempo), array('readonly'=>true)); ?>
			</div>
		</div>
		
		<div id="sudahadapembayaran" hidden>
			<div class="control-group">
				<?php echo CHtml::label("Umur Utang", 'tgljatuhtempo',array('class'=>'control-label')); ?>
				<div class="controls">		
					<?php echo CHtml::textField('FAPendaftaranT[umur_hutang]', !empty($modFakturBeli->fakturpembelian_id)?$modFakturBeli->UmurHutang:'', array('readonly'=>true)); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::activeLabel($modFakturBeli, 'supplier_id',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('FAPendaftaranT[supplier_nama]', (!empty($modFakturBeli->supplier_id)?$modFakturBeli->supplier->supplier_nama:"-"), array('readonly'=>true)); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div id="belumadapembayaran">
			<div class="control-group">
				<?php echo CHtml::label("Umur Utang", 'tgljatuhtempo',array('class'=>'control-label')); ?>
				<div class="controls">		
					<?php echo CHtml::textField('FAPendaftaranT[umur_hutang]', !empty($modFakturBeli->fakturpembelian_id)?$modFakturBeli->UmurHutang:'', array('readonly'=>true)); ?>
				</div>
			</div>

			<div class="control-group">
				<?php //echo CHtml::activeLabel($modFakturBeli, 'supplier_id',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php //echo CHtml::hiddenField('FAPendaftaranT[supplier_id]',$modFakturBeli->supplier_id, array('readonly'=>true)); ?>
					<?php //echo CHtml::textField('FAPendaftaranT[supplier_nama]', (!empty($modFakturBeli->supplier_id)?$modFakturBeli->supplier->supplier_nama:"-"), array('readonly'=>true)); ?>
				</div>
			</div>
                        <?php if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_FINANCE){ ?>
                            <div class="control-group">
                                <?php echo CHtml::label("Supplier <span class='required'>*</span>", 'supplier_id',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeHiddenField($modFakturBeli, 'supplier_id'); ?>
                                    <?php echo CHtml::textField('supplier_nama', empty($modFakturBeli->supplier) ? "" : $modFakturBeli->supplier->supplier_nama ,array('readonly'=>true)); ?>
                                <?php // echo CHtml::activeDropDownList($modFakturBeli,'supplier_id',
//                                        CHtml::listData(SupplierM::model()->SupplierFarmasiItems, 'supplier_id', 'supplier_nama'),
//                                        array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                        'empty'=>'-- Pilih --', 'onchange' => 'refreshDialogOA();')); ?>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="control-group">
                                    <?php echo CHtml::label("Supplier <span class='required'>*</span>", 'supplier_id',array('class'=>'control-label')); ?>
                                    <div class="controls">
                                    <?php echo CHtml::activeDropDownList($modFakturBeli,'supplier_id',
                                            CHtml::listData(SupplierM::model()->SupplierFarmasiItems, 'supplier_id', 'supplier_nama'),
                                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            'empty'=>'-- Pilih --', 'onchange' => 'refreshDialogOA();')); ?>
                                    </div>
                            </div>
                        <?php } ?>
		</div>
		
		
		<div id="sudahadapembayaran2" hidden>
			<div class="control-group">
				<?php echo CHtml::label("Total Harga Netto",'',array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('FAPendaftaranT[totharganetto]', number_format($modFakturBeli->totharganetto,0,"","."), array('readonly'=>true, 'style'=>'text-align: right;')); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::label("Total Keringanan",'',array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('FAPendaftaranT[jmldiscount]', number_format($modFakturBeli->jmldiscount,0,"","."), array('readonly'=>true, 'style'=>'text-align: right;')); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::label("Total PPN",'',array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('FAPendaftaranT[totalpajakppn]', number_format($modFakturBeli->totalpajakppn,0,"","."), array('readonly'=>true, 'style'=>'text-align: right;')); ?>
				</div>
			</div>

			<div class="control-group" hidden>
				<?php echo CHtml::label("Total PPh",'',array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('FAPendaftaranT[totalpajakpph]', number_format($modFakturBeli->totalpajakpph,0,"","."), array('readonly'=>true, 'style'=>'text-align: right;')); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::label("Total Harga Bruto",'',array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('FAPendaftaranT[totalhargabruto]', number_format($modFakturBeli->totalhargabruto,0,"","."), array('readonly'=>true, 'style'=>'text-align: right;')); ?>
				</div>
			</div>
				
       
		</div>
	</div>
</div> 

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogFaktur',
    'options'=>array(
        'title'=>'Faktur Pembelian',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));
$modInfoFaktur=new BKInformasifakturpembelianV;
$format = new MyFormatter();
//$modInfoFaktur->tgl_awal  = date('Y-m-d');
//$modInfoFaktur->tgl_akhir = date('Y-m-d');

if(isset($_GET['BKInformasifakturpembelianV'])){
    $modInfoFaktur->attributes=$_GET['BKInformasifakturpembelianV'];
   // $modInfoFaktur->tgl_awal  = $format->formatDateTimeForDb($_GET['BKInformasifakturpembelianV']['tgl_awal']);
   // $modInfoFaktur->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasifakturpembelianV']['tgl_akhir']);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'fakturpembelian-m-grid',
        'dataProvider' => $modInfoFaktur->searchInformasiUmum(),
        'filter'=>$modInfoFaktur,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
        'columns' => array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        loadFakturPembelian(".$data->fakturpembelian_id.")
                                        $(\'#dialogFaktur\').dialog(\'close\');;
                                        return false;"
                                        ))',
                ),
                'nofaktur',
                array(
                        'name' => 'tglfaktur',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur)))',
                        'filter' => false,
                ),
				array(
                        'name' => 'tgljatuhtempo',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
                        'filter' => false,
                ),
				 array(
                        'header' => 'Umur Utang',
                        'type' => 'raw',
                        'value' => '$data->umurHutang',
                        'filter' => false,
                ),
                array(
                        'name' => 'supplier_id',
                        'type' => 'raw',
                        'value' => '$data->supplier_nama',
                        'filter' => CHtml::activeDropDownList($modInfoFaktur, 'supplier_id', CHtml::listData(SupplierM::model()->SupplierFarmasiItems, 'supplier_id', 'supplier_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
				'empty' => '-- Pilih --',)),
                ),                                               
                array(
                        'name' => 'totharganetto',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totharganetto)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                array(
						'header' => 'Keringanan',
                        'name' => 'jmldiscount',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->jmldiscount)',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                        'filter'=>false,
                ),
				array(
                        'name' => 'totalpajakppn',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakppn)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
                /*array(
                        'name' => 'totalpajakpph',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakpph)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),*/                
                array(
                        'name' => 'totalhargabruto',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto)',
                        'filter' => false,
                        'htmlOptions'=>array('style'=>'text-align: right'),
                ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
