<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Teknisi Peralatan</b>
        </div>
    </div>
    <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Teknisi Peralatan'=>array('admin'),
					'Pengaturan',
				);

				$arrMenu = array();
				//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
								//array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAGolonganM', 'icon'=>'list', 'url'=>array('index'))) ;
								// (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

				$this->menu=$arrMenu;

				Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('teknisi-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
				<p></p>
				<div class="cari-lanjut search-form" style="display:none; padding: 10px;">
					<?php $this->renderPartial($this->path_view.'_search',array(
							'model'=>$model,
					)); ?>
				</div><!-- search-form --><hr>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Teknisi Peralatan</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'teknisi-m-grid',
								'dataProvider'=>$model->search(),
								'filter'=>$model,
								'template'=>"{summary}\n{items}\n{pager}",
								'itemsCssClass'=>'table table-striped table-bordered table-condensed',
								'columns'=>array(
									array(
                                        'header'=>'No',
                                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                        'type'=>'raw',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                    ),
									array(
										'header' => 'Nama Teknisi',
										'name' => 'namateknisi',
										'value' => '$data->namateknisi',
										'filter' => Chtml::activeTextField($model, 'namateknisi', array('class'=>'custom-only'))
									), 
                                    array(
										'header' => 'Supplier',
										'name' => 'supplier_id',
                                        'value' => function($data){
                                            $supplier = SupplierM::model()->findByPk($data->supplier_id);
                                            return $supplier->supplier_nama;
                                        },
										//'filter' => Chtml::activeDropDownList($model, 'supplier_id', CHtml::listData(SupplierM::model()->findAll(), 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --')),
                                           'filter'=> $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'supplier_nama',
                                        'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutoCompleteSupplier') . '",
                                                        dataType: "json",
                                                        data: {
                                                                term: request.term,
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                })
                                        }',
                                        'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        refreshDialogOA();
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#'.Chtml::activeId($model, 'supplier_id') . '").val(ui.item.supplier_id); 
                                                        $("#'.Chtml::activeId($model, 'supplier_nama') . '").val(ui.item.supplier_nama); 
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'class'=>'span3',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        ),
                                        ),true),
									),
                                    array(
										'header' => 'Domisili',
										'name' => 'kabupaten_id',
                                        'value' => function($data){
                                            $kabupaten = KabupatenM::model()->findByPk($data->kabupaten_id);
                                            return $kabupaten->kabupaten_nama;
                                        },
										//'filter' => Chtml::activeDropDownList($model, 'kabupaten_id', CHtml::listData(KabupatenM::model()->findAll(), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --')),
                                            'filter'=> $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'kabupaten_nama',
                                        'source' => 'js: function(request, response) {
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutoCompleteKabupaten') . '",
                                                        dataType: "json",
                                                        data: {
                                                                term: request.term,
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                })
                                        }',
                                        'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        refreshDialogOA();
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $("#'.Chtml::activeId($model, 'kabupaten_id') . '").val(ui.item.kabupaten_id); 
                                                        $("#'.Chtml::activeId($model, 'kabupaten_nama') . '").val(ui.item.kabupaten_nama); 
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'class'=>'span3',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        ),
                                        ),true),
									),
									array(
										'header' => 'Jenis Kelamin',
										'name' => 'jeniskelamin',
										'value' => '$data->jeniskelamin',
										'filter' => Chtml::activeDropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
									),  
                                    array(
										'header' => 'No Kontak',
										'name' => 'no_kontak_teknisi',
										'value' => '$data->no_kontak_teknisi',
                                        'filter' => Chtml::activeTextField($model, 'no_kontak_teknisi', array('class'=>'numbers-only'))
									),  
                                            array(
										'header'=>'<center>Status</center>',
										'value'=>'($data->teknisiperalatan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
										'htmlOptions'=>array('style'=>'text-align:center;'),
									),
									array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array (
                                    'label'=>"<i class='".  MyIcon::getIcons('lihat')."'></i>",
                                    'options'=>array('title'=>Yii::t('mds','View')),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->teknisiperalatan_id"))',
                                    //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
        //                                               
                                ),
                            ),
                        ),
                        array(
                                'header'=>Yii::t('zii','Update'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(
                                        'update' => array (
                                                        'label'=>"<i class='".  MyIcon::getIcons('ubah')."'></i>",
                                                        'options'=>array('title'=>Yii::t('mds','Update')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->teknisiperalatan_id"))',
                                                   //     'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->lookup_name","tab"=>"'.(isset($_GET['tab'])?$_GET['tab']:'').'"))',                                               
                                        ),
                                ),
                        ),
                        /*array(
                                'header'=>Yii::t('zii','Delete'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{delete}',
                                'buttons'=>array(
                                         'delete' => array (
                                                'label'=>"<i class='".  MyIcon::getIcons('hapus')."'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Delete')),
                                             'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->teknisiperalatan_id"))',
                                            //    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->lookup_name"))',               
                                        ),
                                )
                        ),*/
                         array(
									'header'=>'Hapus',
									'type'=>'raw',
									//'value'=>'()?:',
                                    'value'=>function($data){
                                            if($data->teknisiperalatan_aktif == true){
                                              return CHtml::link("<i class='icon-form-silang'></i> ","javascript:removeTemporary($data->teknisiperalatan_id)",array("id"=>"$data->teknisiperalatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Teknisi Peralatan")).' '.CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->teknisiperalatan_id)",array("id"=>"$data->teknisiperalatan_id","rel"=>"tooltip","title"=>"Hapus Teknisi Peralatan"));  
                                            }else{
                                              return CHtml::link("<i class='icon-form-check'></i> ","javascript:aktifkan($data->teknisiperalatan_id)",array("id"=>"$data->teknisiperalatan_id","rel"=>"tooltip","title"=>"Mengaktifkan Teknisi Peralatan")).' '.CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->teknisiperalatan_id)",array("id"=>"$data->teknisiperalatan_id","rel"=>"tooltip","title"=>"Hapus Teknisi Peralatan"));
                                            }
                                    },
									'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
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
									$(".numbers-only").keyup(function() {
										setNumbersOnly(this);
									});
									$(".custom-only").keyup(function() {
										setNumbersOnly(this);
									});
								}',
							)); ?>
						</div>
                    </div>
                </div>
                                
                                <div class="form-actions">
				<?php 
				echo CHtml::link(Yii::t('mds', '{icon} Tambah Teknisi Peralatan', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
				echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
				echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
				$content = $this->renderPartial($this->path_tips.'informasi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
				$url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
				function cekForm(obj){
					$("#teknisi-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#teknisi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
				Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
				?>
                                </div>
            </div>
        </div>    

<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('teknisi-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
        });
    }
    
    function aktifkan(id){
        var url = '<?php echo $url."/aktifkan"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('teknisi-m-grid');
                            }else{
                                myAlert('Data Gagal di Aktifkan')
                            }
                },"json");
           }
        });
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('teknisi-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
    $('.filters #MAIpmchecklistM_ipm_listnama').focus();
</script>