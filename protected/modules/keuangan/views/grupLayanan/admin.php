<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Grup Layanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Grup Layanan' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Generik ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Generik', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Generik', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					$('#KUGrouplayananM_grouplayanan_nama').focus();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('gfgenerik-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Grup Layanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gfgenerik-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'generik_id',
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                        ),
                        'grouplayanan_kode',
                        'grouplayanan_nama',
                        'grouplayanan_definisi',
                        array(
                            'header' => 'Pengelompokkan',
                            'value' => function ($data) {
                                if ($data->is_oa) {
                                    return 'Jenis Obat Alkes';
                                } else {
                                    return 'Tindakan';
                                }
                            },
                            'filter' => CHtml::activeDropDownList($model, 'is_oa', array(
                                'is_oa' => 'Jenis Obat dan Alkes',
                                'is_tindakan' => 'Tindakan'
                            ), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->grouplayanan_aktif == true ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Grup Layanan'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Grup Layanan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->grouplayanan_aktif == true)?CHtml::link("<i class=\'' . MyIcon::getIcons('batal') . '\'></i> ","javascript:removeTemporary($data->grouplayanan_id)",array("id"=>"$data->grouplayanan_id","rel"=>"tooltip","title"=>"Menonaktifkan Generik"))." ".CHtml::link("<i class=\'' . MyIcon::getIcons('hapus') . '\'></i> ", "javascript:deleteRecord($data->grouplayanan_id)",array("id"=>"$data->grouplayanan_id","rel"=>"tooltip","title"=>"Hapus Grup Layanan")):CHtml::link("<i class=\'' . MyIcon::getIcons('hapus') . '\'></i> ", "javascript:deleteRecord($data->grouplayanan_id)",array("id"=>"$data->grouplayanan_id","rel"=>"tooltip","title"=>"Hapus Grup Layanan"));',
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
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Grup Layanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah grup layanan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $js = <<< JSCRIPT
					function cekForm(obj){
						$("#gfgenerik-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#gfgenerik-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gfgenerik-m-grid');
                            } else {
                                myAlert('Data gagal dinonaktifkan!')
                            }
                        }, "json");
                }
            });

    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('gfgenerik-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
    $('.filters #KUGrouplayananM_grouplayanan_nama').focus();
</script>