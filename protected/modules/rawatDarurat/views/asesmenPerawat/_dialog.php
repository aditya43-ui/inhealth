<?php

Yii::import('application.modules.rawatJalan.models.RJObatAlkesM');

// =============================== Dialog OA Terapi ----------------------------------------

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogTerapi',
    'options'=>array(
        'title'=>'Daftar Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialog = new RJObatAlkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$modObatDialog->ruangan_id = Params::RUANGAN_ID_APOTEK_1;
$format = new MyFormatter();
if (isset($_GET['RJObatAlkesM'])){
	$modObatDialog->attributes = $_GET['RJObatAlkesM'];
	$modObatDialog->therapiobat_id = isset($_GET['RJObatAlkesM']['therapiobat_id']) ? $_GET['RJObatAlkesM']['therapiobat_id'] : null;
}

$prov = $modObatDialog->searchObatFarmasiRuangan();
$prov->sort->defaultOrder = 'obatalkes_nama';
    
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
//    'dataProvider'=>$modObatDialog->searchObatFarmasi(),
    'dataProvider'=>$prov,
    'filter'=>$modObatDialog,
    'template'=>"{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                $res = $data->attributes;
                $res = CJSON::encode($res);
    
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>'addObatTerapi('.$res.');
							$("#dialolg").dialog("close");
                            return false;',
                ));
            },
                'filter'=>CHtml::activeHiddenField($modObatDialog, 'therapiobat_id').CHtml::activeHiddenField($modObatDialog, 'ruangan_id'),//RND-7948
        ),
        array(
            'header'=>'Jenis Obat Alkes',
            'name'=>'jenisobatalkes_id',
            'type'=>'raw',
            'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter'=>  CHtml::activeDropDownList($modObatDialog, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                'condition'=>'jenisobatalkes_aktif = true',
                'order'=>'jenisobatalkes_nama'
            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'obatalkes_kategori',
            'filter'=> CHtml::activeDropDownList($modObatDialog, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'name'=>'obatalkes_golongan',
            'filter'=> CHtml::activeDropDownList($modObatDialog, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
                /*
        array(
            'header'=>'Tanggal Kedaluwarsa',
            'name'=>'tglkadaluarsa',
            'filter'=>'',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
        ),         /*
        array(
            'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ), */
		// dicomment karena RND-5732
//        array(
//            'header'=>'HJA Resep',
//            'type'=>'raw',
//            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
//        array(
//            'header'=>'HJA Non Resep',
//            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
                /*
		array(
				'name'=>'hargajual',
				'value'=>'MyFormatter::formatNumberForPrint($data->hargajual)',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right;',
                                ),
                                'visible' => Params::HIDDEN_GRID_HARGA
			),
        array(
            'header'=>'Stok',
            'type'=>'raw',
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialog->ruangan_id.'")." ".$data->satuankecil->satuankecil_nama',
            'htmlOptions'=>array(
                                    'style'=>'text-align: right;',
                                ),
        ),
                 * 
                 */

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>


<?php
    //=============================== Dialog Pemeriksa Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogDokterTerapi',
            'options'=>array(
                'title'=>'Pemeriksa' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$modDokterTerapi=new PegawaiV('search');
	$modDokterTerapi->unsetAttributes();
	if(isset($_GET['PegawaiV'])){
		$modDokterTerapi->attributes=$_GET['PegawaiV'];
	}
    
    $prov = $modDokterTerapi->searchDokter();
    $prov->sort->defaultOrder = 'nama_pegawai';
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dokter-terapi-pemeriksa-grid',
		'dataProvider'=>$prov,
		'filter'=>$modDokterTerapi,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res['nama_pegawai'] = $data->namaLengkap;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " addDokterTerapi(".$res."); return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
            array(
                'name'=>'jabatan_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $model = JabatanM::model()->findByPk($data->jabatan_id);
                    return $model->jabatan_nama;
                },
                'filter'=>CHtml::activeDropDownList($modDokterTerapi, 'jabatan_id', JabatanM::jabatanList(), array(
                    'empty'=>'--- Pilih ---',
                )),
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemeriksa Terapi =======================================
?>

<?php
    //=============================== Dialog Pemberi Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPemberiTerapi',
            'options'=>array(
                'title'=>'Pemberi' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$modPemberiTerapi=new PegawaiV('search');
	$modPemberiTerapi->unsetAttributes();
    $modPemberiTerapi->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
	if(isset($_GET['PegawaiV'])){
		$modPemberiTerapi->attributes=$_GET['PegawaiV'];
	}
    
    $prov = $modPemberiTerapi->search();
    $prov->sort->defaultOrder = 'nama_pegawai';
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-dokter-terapi-penerima-grid',
		'dataProvider'=>$prov,
		'filter'=>$modPemberiTerapi,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res['nama_pegawai'] = $data->namaLengkap;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " addPemberiTerapi(".$res."); return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
            array(
                'name'=>'jabatan_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $model = JabatanM::model()->findByPk($data->jabatan_id);
                    return $model->jabatan_nama;
                },
                'filter'=>CHtml::activeDropDownList($modPemberiTerapi, 'jabatan_id', JabatanM::jabatanList(), array(
                    'empty'=>'--- Pilih ---',
                )),
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemberi Terapi =======================================
?>

<?php
    //=============================== Dialog Pemberi Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPegawaiTindakan',
            'options'=>array(
                'title'=>'Pegawai Tindakan' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
    
	$modPegawaiTindakan=new PegawaiV('search');
	$modPegawaiTindakan->unsetAttributes();
    $modPegawaiTindakan->kelompokpegawai_id = array(
        Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN
    );
	if(isset($_GET['PegawaiV'])){
		$modPegawaiTindakan->attributes=$_GET['PegawaiV'];
	}
    
    $prov = $modPegawaiTindakan->search();
    $prov->sort->defaultOrder = 'nama_pegawai';
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-pegawai-tindakan-grid',
		'dataProvider'=>$prov,
		'filter'=>$modPegawaiTindakan,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res['nama_pegawai'] = $data->namaLengkap;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " addPegawaiTindakan(".$res."); return false; "));
                },
			),
			array(
                'name'=>'nama_pegawai',
                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                'value'=>'$data->namaLengkap',
            ),
            array(
                'name'=>'jabatan_id',
                'type'=>'raw',
                'value'=>function($data) {
                    if (empty($data->jabatan_id)) return "-";
                    $model = JabatanM::model()->findByPk($data->jabatan_id);
                    return $model->jabatan_nama;
                },
                'filter'=>CHtml::activeDropDownList($modPegawaiTindakan, 'jabatan_id', JabatanM::jabatanList(), array(
                    'empty'=>'--- Pilih ---',
                )),
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemberi Terapi =======================================
?>



<?php
    //=============================== Dialog Pemberi Terapi =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogTindakan',
            'options'=>array(
                'title'=>'Tindakan' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
    
	$modTindakan=new TindakanruanganV('search');
	$modTindakan->unsetAttributes();
    $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    
	if(isset($_GET['TindakanruanganV'])){
		$modTindakan->attributes=$_GET['TindakanruanganV'];
	}
    
    $prov = $modTindakan->searchTindakanAsesmen();
    $prov->sort->defaultOrder = 'daftartindakan_nama';
    
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dialog-tindakan-grid',
		'dataProvider'=>$prov,
		'filter'=>$modTindakan,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
                'value'=>function($data) {
                    $res = $data->attributes;
                    $res = CJSON::encode($res);
        
                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
								"onclick" => " addTindakan(".$res."); return false; "));
                },
			),
			array(
                'name'=>'kategoritindakan_nama',
                'value'=>'$data->kategoritindakan_nama',
            ),
            array(
                'name'=>'daftartindakan_kode',
                'value'=>'$data->daftartindakan_kode',
            ),
            array(
                'name'=>'daftartindakan_nama',
                'value'=>'$data->daftartindakan_nama',
            ),
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Pemberi Terapi =======================================
?>