<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'reinformasipenjualanprodukpos-v-grid',
	'dataProvider'=>$model->search(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
//		'brg_id',
//		'category_id',
                'stock_code',
		'stock_name',
		'category_name',
//		'subcategory_id',
		'subcategory_code',
		'subcategory_name',
                
		'satuankecil_nama',
                'qty_oa',
//                'hargajual_oa',
//                'totalhargajual',
		/*
		
		'barang_barcode',
		'obatalkes_id',
		
		'hargasatuan_oa',
		
		'tglpenjualan',
		'jenispenjualan',
		
		
		////'obatalkespasien_id',
		array(
                        'name'=>'obatalkespasien_id',
                        'value'=>'$data->obatalkespasien_id',
                        'filter'=>false,
                ),
		'noresep',
		'ruangan_id',
		'ruangan_nama',
		'pegawai_id',
		'nama_pegawai',
		'nama_pemakai',
		'oasudahbayar_id',
		'pembayaranpelayanan_id',
		'tglpembayaran',
		'nopembayaran',
		'tandabuktibayar_id',
		'shift_id',
		'nourutkasir',
		
		'dengankartu',
		'bankkartu',
		'nokartu',
		'nostrukkartu',
		'jmlpembulatan',
		'jmlpembayaran',
		'biayaadministrasi',
		'uangditerima',
		'uangkembalian',
		'keterangan_pembayaran',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'create_time',
		*/
//		array(
//                        'header'=>Yii::t('zii','View'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{view}',
//		),
//		array(
//                        'header'=>Yii::t('zii','Update'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{update}',
//                        'buttons'=>array(
//                            'update' => array (
//                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                        ),
//                         ),
//		),
//		array(
//                        'header'=>Yii::t('zii','Delete'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-form-silang'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->obatalkespasien_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                        ),
//                        )
//		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
