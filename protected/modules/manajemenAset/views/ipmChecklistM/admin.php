<?php
/**
* - digunakan sebagai Admin IPM Cheklist
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>

        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="fas fa-layer-group"></i> Pengaturan <strong>IPM Checklist</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'IPM Checklist'=>array('index'),
					'Manage',
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
					$.fn.yiiGridView.update('ipm-m-grid', {
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
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>IPM Checklist</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'ipm-m-grid',
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
										'header' => 'Jenis Checklist',
										'name' => 'ipm_jenis',
										'value' => '$data->ipm_jenis',
										'filter' => CHtml::activeDropDownList($model, 'ipm_jenis', LookupM::getItems('ipmchecklist'), array(
                                            'empty'=>'-- Pilih --',
                                        )),
									),                    
									array(
										'header' => 'Checklist',
										'name' => 'ipm_listnama',
										'value' => '$data->ipm_listnama',
										'filter' => Chtml::activeTextField($model, 'ipm_listnama', array('class'=>''))
									), 
									array(
										'header' => 'No Urut',
										'name' => 'ipm_list_nourut',
										'value' => '$data->ipm_list_nourut',
										'filter' => Chtml::activeTextField($model, 'ipm_list_nourut', array('class'=>'numbers-only'))
									),                     
									array(
										'header'=>'<center>Status</center>',
										'value'=>'($data->ipm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
										'htmlOptions'=>array('style'=>'text-align:center;'),
									),
					//		array(
					//                        'header'=>'Aktif',
					//                        'class'=>'CCheckBoxColumn',     
					//                        'selectableRows'=>0,
					//                        'id'=>'rows',
					//                        'checked'=>'$data->golongan_aktif',
					//                ),
                                    
									array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array (
                                    'label'=>"<i class='".  MyIcon::getIcons('lihat')."'></i>",
                                    'options'=>array('title'=>Yii::t('mds','View')),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->ipmchecklist_id"))',
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
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->ipmchecklist_id"))',
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
                                             'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->ipmchecklist_id"))',
                                            //    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->lookup_name"))',               
                                        ),
                                )
                        ),*/
                        array(
									'header'=>'Hapus',
									'type'=>'raw',
									'value'=>'($data->ipm_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->ipmchecklist_id)",array("id"=>"$data->ipmchecklist_id","rel"=>"tooltip","title"=>"Menonaktifkan Ipm Checklist"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->ipmchecklist_id)",array("id"=>"$data->ipmchecklist_id","rel"=>"tooltip","title"=>"Hapus Ipm Checklit")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->ipmchecklist_id)",array("id"=>"$data->ipmchecklist_id","rel"=>"tooltip","title"=>"Hapus Ipm Checklist"));',
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
				echo CHtml::link(Yii::t('mds', '{icon} Tambah IPM Checklist', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp";
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
					$("#ipm-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#ipm-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('ipm-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('ipm-m-grid');
                            }else{
                                myAlert('Data gagal di hapus karena digunakan di transaksi lain')
                            }
                },"json");
           }
        });
    }
    $('.filters #MAIpmchecklistM_ipm_listnama').focus();
</script>