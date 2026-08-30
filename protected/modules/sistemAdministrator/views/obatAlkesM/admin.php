<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pengaturan <strong>Obat Alkes</strong></div>
            </div>
            <div class="panel-body">
				<?php  
				$sukses = null;
				if(isset($_GET['id'])){
					$sukses = $_GET['id'];
				}
				if($sukses > 0){
					Yii::app()->user->setFlash('success',"Data Obat Alkes & Obat Supplier berhasil disimpan !");
				}

				?>
				<?php
				$this->breadcrumbs=array(
//						'Obat Alkes'=>array('index'),
						'Obat Alkes',
				);

				$arrMenu = array();
				//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
				//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAObatalkesM', 'icon'=>'list', 'url'=>array('index'))) ;
				//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Alkes ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

				$this->menu=$arrMenu;

				Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
						$('.search-form').toggle();
						$('#GFObatalkesM_obatalkes_nama').focus();
						return false;
				});
				$('#search').submit(function(){
						$.fn.yiiGridView.update('gfobat-alkes-m-grid', {
								data: $(this).serialize()
						});
						return false;
				});
				");

				$this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
				<p></p>
				<div class="cari-lanjut2 search-form" style="display:none;padding: 10px; border: 1px solid">
					<?php $this->renderPartial($this->path_view.'_search',array(
							'model'=>$model,
					)); ?>
				</div><hr>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Obat Alkes</strong></div>
                    </div>
					<?php $konfiFarm = KonfigfarmasiK::model()->find(); ?>
                    <div class="panel-body" style="overflow-x: scroll">
						<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
							'id'=>'gfobat-alkes-m-grid',
							'dataProvider'=>$model->searchGudangFarmasi(),
							'filter'=>$model,
							'template'=>"{summary}\n{items}\n{pager}",
							'itemsCssClass'=>'table table-striped table-bordered table-condensed',
							'columns'=>array(
								array(
									'header'=>'Sumber Dana',
									'name'=>'sumberdana_id',
									'filter'=>  Chtml::activeDropDownList($model, 'sumberdana_id',CHtml::listData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE ORDER BY sumberdana_nama ASC"), 'sumberdana_id', 'sumberdana_nama'), array('empty'=>'-- Pilih --')),
									'value'=>'$data->sumberdana->sumberdana_nama',
								),
								array(
									'header' => 'Jenis Kelompok',
									'name' => 'jnskelompok',
									'value' => function($data){
										return $data->getNameLookup($data->jnskelompok);
									},
									'filter' => Chtml::activeDropDownList($model, 'jnskelompok', LookupM::getItems('jnskelompok'), array('empty'=>'-- Pilih --'))
								),
								array(
										'header'=>'Jenis Obat',
										'name'=>'jenisobatalkes_id',
										'filter'=> CHtml::dropDownList('SAObatalkesM[jenisobatalkes_id]',$model->jenisobatalkes_id,CHtml::listData($model->JenisObatAlkesItems, 'jenisobatalkes_id', 'jenisobatalkes_nama'),array('empty'=>'--Pilih--')),
										'value'=>'(isset($data->jenisobatalkes->jenisobatalkes_nama) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
								),
								array(
										'header'=>'Golongan',
										'name'=>'obatalkes_golongan',
										'filter'=>Chtml::activeDropDownList($model, 'obatalkes_golongan', ObatAlkesGolongan::items(), array('empty'=>'-- Pilih --')),
								),
								array(
										'header'=>'Kategori',
										'name'=>'obatalkes_kategori',
										'filter'=>Chtml::activeDropDownList($model, 'obatalkes_kategori', ObatAlkesKategori::items(), array('empty'=>'-- Pilih --')),
								),
								array(
										'header'=>'Kode Obat',
										'name'=>'obatalkes_kode',
										'value'=>'$data->obatalkes_kode',
										'filter'=>CHtml::activeTextField($model, 'obatalkes_kode', array('class'=>'custom-only')),
								),
								array(
										'header'=>'Nama Obat',
										'name'=>'obatalkes_nama',
										'value'=>'$data->obatalkes_nama',
										'filter'=>CHtml::activeTextField($model, 'obatalkes_nama', array('class'=>'custom-only')),
								), /*
								array(
										'header'=>'Satuan Besar',
										'name'=>'satuanbesar_id',
										'filter'=> CHtml::dropDownList('SAObatalkesM[satuanbesar_id]',$model->satuanbesar_id,CHtml::listData($model->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'),array('empty'=>'--Pilih--')),
										'value'=>'(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "")',
								),

								array(
										'header'=>'Satuan Kecil',
										'name'=>'satuankecil_id',
										'filter'=>  CHtml::dropDownList('SAObatalkesM[satuankecil_id]',$model->satuankecil_id,CHtml::listData($model->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'), array('empty'=>'--Pilih--')),
										'value'=>'(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "")',
								),
								array(
										'header'=>'Tanggal Kadaluarsa',
										'name'=>'tglkadaluarsa',
										'value'=>'$data->tglkadaluarsa',
								),
								array(
										'header'=>'Isi Kemasan  / <br> Min. Stok',
				//                        'name'=>'obatalkes_kategori',
										'type'=>'raw',
										'value'=>'$data->kemasanbesar ."/ <br/>". $data->minimalstok',
								), */
								array(
									'header'=>'Harga Netto',
									'name'=>'harganetto',
									'type'=>'raw',
									'filter'=>CHtml::activeTextField($model, 'harganetto', array('class'=>'numbers-only', 'style'=>'text-align:right;')),
									'htmlOptions'=>array('style'=>'text-align: right'),
				//                    'value'=>'"Rp. ".number_format($data->harganetto)',
									'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i>", Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/updateHarga", array("idObat"=>$data->obatalkes_id, "status"=>"harganetto")), array("title"=>"Ubah harga netto", "target"=>"iframeUpdateHarga", "onclick"=>"$(\"#doalogUpdateHarga\").dialog(\"open\")", "rel"=>"tooltip"))."&nbsp;&nbsp;".number_format($data->harganetto,2,",",".")',
								),
								array(
								  'header'=>'Harga Jual',
								  'name'=>'hargajual',
								  'type'=>'raw',
				                 'value'=>'"Rp. ".number_format($data->hargajual)',
									'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i>", Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/updateHarga", array("idObat"=>$data->obatalkes_id, "status"=>"hargajual")), array("title"=>"Ubah harga jual", "target"=>"iframeUpdateHarga", "onclick"=>"$(\"#doalogUpdateHarga\").dialog(\"open\")", "rel"=>"tooltip"))."&nbsp;&nbsp;".number_format($data->hargajual,0,",",".")',
								), /*
				//                array(
				//                  'header'=>'HJA Resep',
				//                  'name'=>'hjaresep',
				//                  'type'=>'raw',
				//                    'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i>", Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/updateHarga", array("idObat"=>$data->obatalkes_id, "status"=>"hargajual")), array("title"=>"Ubah HJA Resep", "target"=>"iframeUpdateHarga", "onclick"=>"$(\"#doalogUpdateHarga\").dialog(\"open\")", "rel"=>"tooltip"))."&nbsp;&nbsp;".number_format($data->hjaresep,0,",",".")',
				//                ),
				//                array(
				//                  'header'=>'HJA Non-Resep',
				//                  'name'=>'hjanonresep',
				//                  'type'=>'raw',
				//                    'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i>", Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/updateHarga", array("idObat"=>$data->obatalkes_id, "status"=>"hargajual")), array("title"=>"Ubah HJA Non-Resep", "target"=>"iframeUpdateHarga", "onclick"=>"$(\"#doalogUpdateHarga\").dialog(\"open\")", "rel"=>"tooltip"))."&nbsp;&nbsp;".number_format($data->hjanonresep,0,",",".")',
				//                ), */
								 array(
									'header'=>'<center>Status</center>',
									'value'=>'($data->obatalkes_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
									'htmlOptions'=>array('style'=>'text-align:center;'),
								),
								array(
									'header' => 'Harga Obat Alkes Penjamin',
									'type' => 'raw',
									'value' => function ($data) {
										return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl("viewHargaObatAlkesPenjamin", array("obatalkes_id" => $data->obatalkes_id)), array("id" => "$data->obatalkes_id", "rel" => "tooltip", "title" => "Klik untuk melihat harga obat alkes penjamin"));
									},
									'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
									'visible'=>((!empty($konfiFarm) && $konfiFarm->ishargaperpenjamin==true)?true:false)
								),
								 /*
								 array(
										// 'header'=>'Satuan Kecil',
										'name'=>'ven',
										'filter'=>  CHtml::dropDownList('SAObatalkesM[ven]',$model->ven,LookupM::getItems('ven'),array('empty'=>'--Pilih--')),//,
										'value'=>'(isset($data->ven) ? ($data->ven=="v"?"Viral":($data->ven=="e"?"Essential":($data->ven=="n"?"Non-essential":""))) : "")',
								),
				//                array(
				//                    'header'=>'Aktif',
				//                    'class'=>'CCheckBoxColumn',
				//                    'id'=>'rows',
				//                    'checked'=>'$data->obatalkes_aktif',
				//                    'selectableRows'=>0,
				//                ),
								 * 
								 */
								array(
									'header'=>Yii::t('zii','View'),
									'class'=>'bootstrap.widgets.BootButtonColumn',
									'template'=>'{view}',
									'buttons'=>array(
										'view'=>array(
											'options'=>array('rel'=>'tooltip','title'=>'Lihat Obat Alkes'),
										),
									),
								),
								array(
									'header'=>Yii::t('zii','Update'),
									'class'=>'bootstrap.widgets.BootButtonColumn',
									'template'=>'{update}',
									'buttons'=>array(
										'update' => array (
											'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
											'options'=>array('rel'=>'tooltip','title'=>'Ubah Obat Alkes'),
										),
									),
								),
								array(
									'header'=>'Hapus',
									'type'=>'raw',
									'value'=>'($data->obatalkes_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->obatalkes_id)",array("id"=>"$data->obatalkes_id","rel"=>"tooltip","title"=>"Menonaktifkan Obat Alkes"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->obatalkes_id)",array("id"=>"$data->obatalkes_id","rel"=>"tooltip","title"=>"Hapus Obat Alkes")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->obatalkes_id)",array("id"=>"$data->obatalkes_id","rel"=>"tooltip","title"=>"Hapus Obat Alkes"));',
									'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
								),
							),
							'afterAjaxUpdate'=>'function(id, data){
								jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
								$("table").find("input[type=text]").each(function(){
									cekForm(this);
								});
								$("table").find("select").each(function(){
									cekForm(this);
								});
								$(".custom-only").keyup(function() {
									setCustomOnly(this);
								});
								$(".numbers-only").keyup(function() {
									setNumbersOnly(this);
								});
							}',
						)); ?>
                    </div>
                </div>
				<?php 
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				echo CHtml::link(Yii::t('mds', '{icon} Tambah Obat Alkes', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
				echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
				$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
				$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
				$url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
				function cekForm(obj){
					$("#search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
				Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
				?>
            </div>
        </div>
    </div>
</div>
      
<?php 
// Dialog untuk update harga =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'doalogUpdateHarga',
    'options'=>array(
        'title'=>'Update Harga Netto',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>450,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeUpdateHarga" width="100%" height="450">
</iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('gfobat-alkes-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
            }
        }); 

    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('gfobat-alkes-m-grid');
                            }else if(data.status == 'warning'){
                                myAlert(data.pesan);
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
    $('.filters #GFObatalkesM_obatalkes_kode').focus();
</script>