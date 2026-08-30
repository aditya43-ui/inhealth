<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="fas fa-layer-group"></i> Pengaturan <strong>UMDNS</strong></div>
    </div>
    <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'UMDNS'=>array('index'),
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
					$.fn.yiiGridView.update('umdns-m-grid', {
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
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>UMDNS</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'umdns-m-grid',
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
										'header' => 'Kode UMDNS',
										'name' => 'umdns_kode',
										'value' => '$data->umdns_kode',
										'filter' => Chtml::activeTextField($model, 'umdns_kode', array('class'=>'custom-only'))
									),                    
									array(
										'header' => 'Istilah',
										'name' => 'umdns_nama',
										'value' => '$data->umdns_nama',
										'filter' => Chtml::activeTextField($model, 'umdns_nama', array('class'=>'custom-only'))
									), 
									array(
										'header' => 'Nama Lainnya',
										'name' => 'umdns_namalainnya',
										'value' => '$data->umdns_namalainnya',
										'filter' => Chtml::activeTextField($model, 'umdns_namalainnya', array('class'=>'custom-only'))
									),                     
								/*	array(
										'header'=>'<center>Status</center>',
										'value'=>'($data->umdns_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
										'htmlOptions'=>array('style'=>'text-align:center;'),
									),*/
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
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->umdns_id"))',
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
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->umdns_id"))',
                                                   //     'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->lookup_name","tab"=>"'.(isset($_GET['tab'])?$_GET['tab']:'').'"))',                                               
                                        ),
                                ),
                        ),
                        array(
                                'header'=>Yii::t('zii','Delete'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{delete}',
                                'buttons'=>array(
                                         'delete' => array (
                                                'label'=>"<i class='icon-form-sampah'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Delete')),
                                             'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->umdns_id"))',
                                            //    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->lookup_name"))',               
                                        ),
                                )
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
				echo CHtml::link(Yii::t('mds', '{icon} Tambah UMDNS', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
				echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
				echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
				$content = $this->renderPartial($this->path_tips.'master',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
				$url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
				function cekForm(obj){
					$("#umdns-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#umdns-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
				Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
				?>
            </div>
        </div>
    </div>

    