<?php
$this->breadcrumbs = array(
    'Supplier',
);

$arrMenu = array();
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Supplier', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	$('#GFSupplierM_supplier_kode').focus();
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
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-layer-group"></i> Pengaturan <b>Supplier</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Supplier</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'gfsupplier-m-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'supplier_id',
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'name' => 'supplier_kode',
                                    'value' => '$data->supplier_kode',
                                    'filter' => CHtml::activeTextField($model, 'supplier_kode'),
                                ),
                                'supplier_nama',
                                'supplier_alamat',
                                'supplier_cp',
                                array(
                                    'header' => 'No. Telepon',
                                    'name' => 'supplier_cp',
                                    'value' => '$data->supplier_cp',

                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),
                                array(
                                    'header' => 'Lihat',
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(
                                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat Supplier'),
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
                                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            'options' => array('rel' => 'tooltip', 'title' => 'Ubah Supplier'),
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->supplier_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Menonaktifkan Supplier"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Hapus Supplier")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:activeTemporary($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Mengaktifkan Supplier"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Hapus Supplier"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
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
                    echo CHtml::link(Yii::t('mds', '{icon} Tambah Supplier', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl($controller . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                    $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                    $js = <<< JSCRIPT
				function cekForm(obj){
					if(obj.name == 'SASupplierM[supplier_alamat]'){
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
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gfsupplier-m-grid');
                            } else {
                                myAlert('Data gagal dinonaktifkan!')
                            }
                        }, "json");
                }
            });

    }

    function activeTemporary(id) {
        var url = '<?php echo $url . "/activeTemporary"; ?>';
        myConfirm('Apakah Anda yakin ingin mengaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gfsupplier-m-grid');
                            } else {
                                myAlert('Data Gagal di Aktifkan')
                            }
                        }, "json");
                }
            });

    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Apakah Anda yakin ingin menghapus data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gfsupplier-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }

    $('.filters #GFSupplierM_supplier_kode').focus();
</script>