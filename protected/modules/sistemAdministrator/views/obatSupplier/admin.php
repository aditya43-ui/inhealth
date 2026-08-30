<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Obat Supplier</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Obat Supplier',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Supplier', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					$('#GFObatSupplierM_supplier_kode').focus();    
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('gfsupplier-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Obat Supplier</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Obat Supplier</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'gfsupplier-m-grid',
                    'dataProvider' => $model->searchObatSupplierGF(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    //        'mergeColumns' => array('supplier_nama','supplier_kode','supplier_alamat'),
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Kode Supplier',
                            'type' => 'raw',
                            'name' => 'supplier_kode',
                            'filter' =>  CHtml::activeTextField($model, 'supplier_kode'),
                            'value' => '(isset($data->supplier->supplier_kode) ? $data->supplier->supplier_kode : "")',
                        ),
                        array(
                            'header' => 'Nama Supplier',
                            'type' => 'raw',
                            'name' => 'supplier_nama',
                            'value' => '(isset($data->supplier->supplier_id) ? $data->supplier->supplier_nama : "")',
                        ), /*
									array(
										'header'=>'Alamat Supplier',
										'type'=>'raw',
										'name'=>'supplier_alamat',
										'value'=>'(isset($data->supplier->supplier_alamat) ? $data->supplier->supplier_alamat : "")',
									), */
                        array(
                            'header' => 'Nama Obat Alkes',
                            'type' => 'raw',
                            'name' => 'obatalkes_nama',
                            'value' => '(isset($data->obatalkes->obatalkes_nama) ? $data->obatalkes->obatalkes_nama : "Tidak Diset")',
                        ), /*
									array(
										'header'=>'Satuan Kecil',
										'type'=>'raw',
										'name'=>'satuankecil_id',
										'value'=>'(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "Tidak Diset")',
									),
									array(
										'header'=>'Satuan Besar',
										'type'=>'raw',
										'name'=>'satuanbesar_id',
										'value'=>'(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "Tidak Diset")',
									), */
                        array(
                            'header' => 'Harga Beli <br> Satuan Besar',
                            'type' => 'raw',
                            'name' => 'hargabelibesar',
                            'htmlOptions' => array('style' => 'text-align: right'),
                            'value' => '(isset($data->hargabelibesar) ? $data->hargabelibesar."/".(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "Tidak Diset") : "Tidak Diset" )',
                        ),
                        array(
                            'header' => 'Harga Beli <br> Satuan Kecil',
                            'type' => 'raw',
                            'name' => 'hargabelikecil',
                            'htmlOptions' => array('style' => 'text-align: right'),
                            'value' => '(isset($data->hargabelikecil) ? $data->hargabelikecil."/".(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "Tidak Diset") : "Tidak Diset")',
                        ), /*
									array(
										'header'=>'Diskon(%)',
										'type'=>'raw',
										'name'=>'diskon_persen',
										'htmlOptions'=>array('style'=>'text-align: right'),
										'value'=>'(isset($data->diskon_persen) ? $data->diskon_persen : "Tidak Diset")',
									),
									array(
										'header'=>'Ppn(%)',
										'type'=>'raw',
										'name'=>'ppn_persen',
										'htmlOptions'=>array('style'=>'text-align: right'),
										'value'=>'(isset($data->ppn_persen) ? $data->ppn_persen : "Tidak Diset")',
									), */

                        //                array(
                        //                     'name'=>'obatalkes_nama',
                        //                     'type'=>'raw',
                        ////                     'filter'=>
                        //                     'value'=>'$this->grid->getOwner()->renderPartial(\'_obatSupplier\',array(\'supplier_id\'=>$data[supplier_id],\'obatalkes_id\'=>$data[obatalkes_id]),true)',
                        //                ),
                        // array(
                        //     'header' => 'Status',
                        //     'value'=>'($data->supplier->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        //     'htmlOptions'=>array('style'=>'text-align:center;'),
                        // ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='icon-view'></i>",
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Obat Supplier'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->supplier_id"))',
                                    //'visible'=>'($data->supplier->supplier_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                    //                                               
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Obat Supplier'),
                                    //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("obatalkes_id"=>"$data->obatalkes_id","supplier_id"=>"$data->supplier_id"))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus Obat Supplier'),
                                    //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
                        ),

                    ),
                    'afterAjaxUpdate' => 'function(id, data){
									jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
									$("table").find("input[type=text]").each(function(){
										cekForm(this);
									})
								}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Obat Supplier', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl($controller . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah obat supplier', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $js = <<< JSCRIPT
				function cekForm(obj){
					if(obj.name == 'GFSupplierM[supplier_alamat]'){
						$("textarea[name='"+ obj.name +"']").val(obj.value);
					}else{
						$("#gfsupplier-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
				}
				function print(caraPrint){	
					window.open("${urlPrint}/"+$('#gfsupplier-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script>
    $('.filters #GFObatSupplierM_supplier_kode').focus();
</script>