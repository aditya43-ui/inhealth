<!--<div id="form-pemeriksaan">-->
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
    <?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>
    
    <?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
    <?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis();", 'class'=>'span3')); ?>
<!--<div class="control-group">
        <?php // echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php // echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
        </div>
    </div>-->
    <?php /* echo CHtml::htmlButton(Yii::t('mds','{icon} Pilih Pemeriksaan',array('{icon}'=>'<i class="icon-edit icon-white"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', "onclick"=>"SetChecklistTindakan($('#form-pemeriksaan')); ")); ?>
    <div id="form-tindakanpelayanan">
        <table class="table table-condensed table-striped">
            <thead>
                <th>No.</th>
                <th>Jenis / Tindakan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Batal</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
<!--</div>-->
<?php
//====== dialog box pilih tarif tindakan ====
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialog-pilihtindakan',
    'options'=>array(
        'title'=>'Pilih Tindakan',
        'autoOpen'=>false,
        'width'=>840,
        'height'=>450,
        'modal'=>true,
        'resizable'=>false,
    ),
));?>
    <?php 
    $modTarifTindakan = new PJTarifTindakanPerdaRuanganV('searchDialog');
	$modTarifTindakan->ruangan_id = 0;
	$modTarifTindakan->unsetAttributes();
    if(isset($_GET['PJTarifTindakanPerdaRuanganV'])){
        $modTarifTindakan->attributes = $_GET['PJTarifTindakanPerdaRuanganV'];
        $modTarifTindakan->ruangan_id = $_GET['PJTarifTindakanPerdaRuanganV']['ruangan_id'];
        $modTarifTindakan->kelaspelayanan_id = $_GET['PJTarifTindakanPerdaRuanganV']['kelaspelayanan_id'];
        $modTarifTindakan->penjamin_id = $_GET['PJTarifTindakanPerdaRuanganV']['penjamin_id'];
        $modTarifTindakan->kategoritindakan_nama = isset($_GET['PJTarifTindakanPerdaRuanganV']['kategoritindakan_nama']) ? $_GET['PJTarifTindakanPerdaRuanganV']['kategoritindakan_nama'] : null;
        $modTarifTindakan->daftartindakan_kode = isset($_GET['PJTarifTindakanPerdaRuanganV']['daftartindakan_kode']) ? $_GET['PJTarifTindakanPerdaRuanganV']['daftartindakan_kode'] : null;
        $modTarifTindakan->daftartindakan_nama = isset($_GET['PJTarifTindakanPerdaRuanganV']['daftartindakan_nama']) ? $_GET['PJTarifTindakanPerdaRuanganV']['daftartindakan_nama'] : null;
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'tariftindakanperdaruangan',
			'dataProvider'=>$modTarifTindakan->searchDialog(),
			'filter'=>$modTarifTindakan,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectTindakan",
									"onClick" => "
										pilihTindakanIni($data->kelompoktindakan_id,$data->daftartindakan_id,\'$data->kelompoktindakan_nama\',\'$data->daftartindakan_kode\',\'$data->daftartindakan_nama\',$data->harga_tariftindakan,$data->jenistarif_id);
                                                                                $(\"#dialog-pilihtindakan\").dialog(\"close\");
									"))',
				),
				array(
					'name'=>'kategoritindakan_nama',
					'value'=>'$data->kategoritindakan_nama',
					'type'=>'raw',
				),
				array(
					'name'=>'daftartindakan_kode',
					'value'=>'$data->daftartindakan_kode',
					'type'=>'raw',
				),
				array(
					'name'=>'daftartindakan_nama',
					'value'=>'$data->daftartindakan_nama',
					'type'=>'raw',
				),
				array(
					'header'=>'harga_tariftindakan',
					'value'=>'number_format($data->harga_tariftindakan,0,"",".")',
					'type'=>'raw', 
					'filter'=>CHtml::activeHiddenField($modTarifTindakan, 'ruangan_id',array('readonly'=>true))."<br>".CHtml::activeHiddenField($modTarifTindakan, 'kelaspelayanan_id',array('readonly'=>true))."<br>".CHtml::activeHiddenField($modTarifTindakan, 'penjamin_id',array('readonly'=>true)),
					'htmlOptions'=>array('style'=>'text-align:right;'),
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
    ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
     * 
     */ ?>

