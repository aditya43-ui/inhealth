    <?php
    $this->breadcrumbs=array(
            'Sabarang Ms'=>array('index'),
            'Manage',
    );

//    $arrMenu = array();
//    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SABarangM', 'icon'=>'list', 'url'=>array('index'))) ;
//                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Barang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//
//    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#SABarangM_barang_type').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sabarang-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
	?>
<div class="white-container">
    <legend class="rim2">Pengaturan <b>Barang</b></legend>
		
   <?php 
	if (!empty($_GET['sukses'])){
		$this->widget('bootstrap.widgets.BootAlert'); 
		Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
	}
	?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <div class="block-tabel">
        <h6>Tabel <b>Barang</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sabarang-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'barang_id',
                    array(
                            'name'=>'barang_id',
                            'value'=>'$data->barang_id',
                            'filter'=>false,
                    ),
                    array(
                            'name'=>'bidang_id',
                            'filter'=>  CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
                            'value'=>'!empty($data->bidang_id)?$data->bidang->bidang_nama:" - "',
                    ),
                    'barang_type',
                    'barang_kode',
                    'barang_nama',
                    'barang_namalainnya',
                    array(
                        'header' => 'Status',
                        'value'=>'($data->barang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->barang_aktif',
    //                ),
                    /*
                    'barang_merk',
                    'barang_noseri',
                    'barang_ukuran',
                    'barang_bahan',
                    'barang_thnbeli',
                    'barang_warna',
                    'barang_statusregister',
                    'barang_ekonomis_thn',
                    'barang_satuan',
                    'barang_jmldlmkemasan',

                    */
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array(
                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Barang' ),
                                ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
                                            'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Barang' ),
                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            ),
                             ),
                    ),
//                    array(
//                        'header'=>'Hapus',
//                        'type'=>'raw',
//                        'value'=>'($data->barang_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->barang_id)",array("id"=>"$data->barang_id","rel"=>"tooltip","title"=>"Menonaktifkan Barang"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->barang_id)",array("id"=>"$data->barang_id","rel"=>"tooltip","title"=>"Hapus Barang")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->barang_id)",array("id"=>"$data->barang_id","rel"=>"tooltip","title"=>"Hapus Barang"));',
//                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
//                    ),
				array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{remove}{add}{delete}',
				'buttons'=>array(
					'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->barang_id))',
							'click'=>'function(){nonActive(this);return false;}',
//							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
							'visible'=>'(($data->barang_aktif) ? TRUE : FALSE)',
					),
					'add' => array (
										'label'=>"<i class='icon-form-check'></i>",
										'options'=>array('title'=>Yii::t('mds','Diaktifkan')),
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->barang_id))',
										'click'=>'function(){active(this);return false;}',
										'visible'=>'(($data->barang_aktif) ? FALSE : TRUE)',
								 ),
					'delete'=> array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
					),
				)
			),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Barang', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $this->widget('UserTips',array('content'=>'')); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sabarang-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sabarang-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function nonActive(obj){
		myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sabarang-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
	
	function active(obj){
		myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sabarang-m-grid');
							if(data.sukses > 0){
								myAlert('Data berhasil diaktifkan!');
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal diaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
    
    $(document).ready(function(){
        $('input[name="SABarangM[barang_type]"]').focus();
    })
</script>