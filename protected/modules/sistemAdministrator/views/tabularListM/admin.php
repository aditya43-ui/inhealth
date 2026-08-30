<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Pengaturan <b>Tabular List</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Satabular List Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tabular List ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tabular List', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Tabular List', 'icon' => 'file', 'url' => array('create'))) :  '';

        //$this->menu=$arrMenu;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					$('#RITabularListM_tabularlist_chapter').focus();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('satabular-list-m-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Tabular List</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<legend class='rim'>Tabel Tabular List</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'satabular-list-m-grid',
                    'dataProvider' => $model->search(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        ////'tabularlist_id',
                        /*array(
							'name'=>'tabularlist_id',
							'value'=>'$data->tabularlist_id',
							'filter'=>false,
						),*/
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'tabularlist_chapter',
                            'htmlOptions' => array(
                                'style' => 'width: 110px;',
                            ),
                        ),
                        array(
                            'name' => 'tabularlist_block',
                            'htmlOptions' => array(
                                'style' => 'text-align: center; width: 80px;',
                            ),
                        ),
                        'tabularlist_title',
                        'tabularlist_title2',
                        array(
                            'name' => 'tabularlist_revisi',
                            'htmlOptions' => array(
                                'style' => 'text-align: center; width: 60px;',
                            ),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->tabularlist_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //	        array(
                        //                        'name'=>'tabularlist_aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->tabularlist_aktif',
                        //                ), 
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Tabular List'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Tabular List'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->tabularlist_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->tabularlist_id)",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Menonaktifkan Tabular List"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tabularlist_id)",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Hapus Tabular List")):CHtml::link("<i class=\'entypo-check\'></i> ","javascript:addTemporary($data->tabularlist_id, 1)",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Aktifkan Tabular List"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tabularlist_id)",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Hapus Tabular List"));',
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
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Tabular List', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah tabular list', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $controller = Yii::app()->controller->id;
            $module = Yii::app()->controller->module->id;
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
			function cekForm(obj){
				$("#satabular-list-m-search :input[name='"+ obj.name +"']").val(obj.value);
			}
			function print(caraPrint){
				window.open("${urlPrint}/"+$('#satabular-list-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
			}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>

            <!--br/><br><br><br><br><br/-->

            <script type="text/javascript">
                function removeTemporary(id) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('satabular-list-m-grid');
                                    } else {
                                        myAlert('Data gagal dinonaktifkan!.')
                                    }
                                }, "json");
                        }
                    });
                }

                function addTemporary(id, add) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id,
                                    add: add
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('satabular-list-m-grid');
                                    } else {
                                        myAlert('Data Gagal di Aktifkan.')
                                    }
                                }, "json");
                        }
                    });
                }

                function deleteRecord(id) {
                    var id = id;
                    var url = '<?php echo $url . "/delete"; ?>';
                    myConfirm("Anda yakin akan menghapus data ini?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('satabular-list-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus!.')
                                    }
                                }, "json");
                        }
                    });
                }
                $(document).ready(function() {
                    $('input[name="SATabularListM[tabularlist_chapter]"]').focus();
                });
            </script>
        </div>
    </div>
</div>