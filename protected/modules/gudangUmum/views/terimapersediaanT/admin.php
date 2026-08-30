<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Penerimaan <strong>Barang</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'Guterimapersediaan Ts'=>array('index'),
					'Manage',
				);

				$arrMenu = array();
				(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUTerimapersediaanT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
				array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUTerimapersediaanT', 'icon'=>'list', 'url'=>array('index'))) ;
				(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUTerimapersediaanT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

				$this->menu=$arrMenu;

				Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('guterimapersediaan-t-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

				$this->widget('bootstrap.widgets.BootAlert'); ?>

				<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
				<div class="search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
				</div><!-- search-form -->
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Penerimaan Barang</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
							'id'=>'guterimapersediaan-t-grid',
							'dataProvider'=>$model->search(),
							'filter'=>$model,
							'template'=>"{summary}\n{items}\n{pager}",
							'itemsCssClass'=>'table table-striped table-bordered table-condensed',
							'columns'=>array(
								////'terimapersediaan_id',
								array(
									'name'=>'terimapersediaan_id',
									'value'=>'$data->terimapersediaan_id',
									'filter'=>false,
								),
								'pembelianbarang_id',
								'sumberdana_id',
								'returpenerimaan_id',
								'tglterima',
								'nopenerimaan',
								/*
								'tglsuratjalan',
								'nosuratjalan',
								'tglfaktur',
								'nofaktur',
								'keterangan_persediaan',
								'totalharga',
								'discount',
								'biayaadministrasi',
								'pajakpph',
								'pajakppn',
								'nofakturpajak',
								'peg_penerima_id',
								'peg_mengetahui_id',
								'ruanganpenerima_id',
								'create_time',
								'update_time',
								'create_loginpemakai_id',
								'update_loginpemakai_id',
								'create_ruangan',
								*/
								array(
									'header'=>Yii::t('zii','View'),
									'class'=>'bootstrap.widgets.BootButtonColumn',
									'template'=>'{view}',
								),
								array(
									'header'=>Yii::t('zii','Update'),
									'class'=>'bootstrap.widgets.BootButtonColumn',
									'template'=>'{update}',
									'buttons'=>array(
										'update' => array (
											'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
										),
									 ),
								),
								array(
									'header'=>Yii::t('zii','Delete'),
									'class'=>'bootstrap.widgets.BootButtonColumn',
									'template'=>'{remove} {delete}',
									'buttons'=>array(
										'remove' => array (
											'label'=>"<i class='icon-remove'></i>",
											'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->terimapersediaan_id"))',
											//'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
											'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
										),
										'delete'=> array(
											'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
										),
									)
								),
							),
							'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
						)); ?>
                    </div>
                </div>
				<?php 
					echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
					echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
					echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
					$this->widget('UserTips',array('type'=>'admin'));
					$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
					$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
					$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$js = <<< JSCRIPT
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#guterimapersediaan-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
				Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
				?>				
            </div>
        </div>
    </div>
</div>

