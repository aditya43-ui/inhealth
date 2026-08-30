<div class="row-fluid">
    <div class="col-sm-6">	
	<div class="control-group ">
            <?php echo CHtml::activeLabel($modBeli, 'nopembelian', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modBeli, 'pembelianbarang_id'); ?>
                <?php
                echo CHtml::activeTextField($modBeli,'nopembelian', array('readonly'=>TRUE, 'class'=>'span3 namaPegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                ?>
            </div>
	</div>
	 <div class="control-group ">
            <?php echo CHtml::activeLabel($modBeli, 'tglpembelian', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeTextField($modBeli, 'tglpembelian', array('class'=>'span3','readonly'=>true))
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">	
        <div class="control-group ">
            <?php echo CHtml::label('Sumber Dana <span class="required">*</span>', 'sumberdana_id', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($model,'sumberdana_id'); ?>
                <?php echo CHtml::activeTextField($model,'sumberdana',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Supplier <span class="required">*</span>', '', array('class'=>'control-label required')) ?>
            <div class="controls">				
                <?php
                        echo CHtml::activeHiddenField($model, 'supplier_id');
                        echo CHtml::activeTextField($model,'supplier_nama', array('readonly'=>TRUE, 'class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                ?>
            </div>
	</div>
    </div>
</div>


<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPembelian',
    'options' => array(
        'title' => 'Daftar Pembelian Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPembelian=new GUPembelianbarangT('search');
$format= new MyFormatter;
$modPembelian->unsetAttributes();  // clear any default values
$modPembelian->belum = true;
if(isset($_GET['GUPembelianbarangT'])){
	 $modPembelian->attributes=$_GET['GUPembelianbarangT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pembelian-m-grid',
    'dataProvider'=>$modPembelian->searchInformasi(),
    'filter'=>$modPembelian,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '
				CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
									$(\"#PembelianbarangT_tglpembelian\").val(\"".MyFormatter::formatDateTimeForUser($data->tglpembelian)."\");
									$(\"#PembelianbarangT_pembelianbarang_id\").val(\"".($data->pembelianbarang_id)."\");
									$(\"#PembelianbarangT_nopembelian\").val(\"".($data->nopembelian)."\");
									$(\"#PembelianbarangT_supplier_id\").val(\"".($data->supplier_id)."\");
                                                                        $(\"#PembelianbarangT_supplier_nama\").val(\"".($data->supplier->supplier_nama)."\");
									$(\"#GUTerimapersediaanT_sumberdana_id\").val(\"".($data->sumberdana_id)."\");                                                                        
									loadPembelian(".$data->pembelianbarang_id.");
									$(\'#dialogPembelian\').dialog(\'close\');
                                    return false;"));',
        ),
		'nopembelian',
		array(
			'name'=>'sumberdana_id',
			'type'=>'raw',
			'value'=>'$data->sumberdana->sumberdana_nama',
			'filter'=>CHtml::activeDropDownList($modPembelian, 'sumberdana_id', 
					CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true order by sumberdana_nama'), 'sumberdana_id', 'sumberdana_nama'),
					array('empty'=>'-- Pilih --')),
		),
		array(
			'name'=>'supplier_id',
			'type'=>'raw',
			'value'=>'$data->supplier->supplier_nama',
			'filter'=>CHtml::activeDropDownList($modPembelian, 'supplier_id', 
					CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true order by supplier_nama'), 'supplier_id', 'supplier_nama'),
					array('empty'=>'-- Pilih --')),
		),                  
		 array(
			'header' => 'Tanggal Pembelian',
			'value' => 'Myformatter::formatDateTimeForUser($data->tglpembelian)',
		),  
		 array(
			'header' => 'Tanggal Dikirim',
			'value' => 'Myformatter::formatDateTimeForUser($data->tgldikirim)',
		), 
		array(
			'header' => 'Pegawai Pemesan',
			'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai'
		),                    
		array(
			'header' => 'Pegawai Mengetahui',
			'value' => 'empty($data->mengetahui)?"-":$data->mengetahui->nama_pegawai'
		),                    
		array(
			'header' => 'Pegawai Menyetujui',
			'value' => 'empty($data->menyetujui)?"-":$data->menyetujui->nama_pegawai'
		),     
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>