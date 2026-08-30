<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Rujukan Ke Luar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Lkrujukankeluar Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Rujukan Keluar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) : '';
        //array_push($arrMenu,array('label'=>Yii::t('mds','List').' Rujukan Keluar', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Rujukan Keluar', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                $('.search-form').toggle();
                $('#LKRujukankeluarM_rumahsakitrujukan').focus();
                return false;
                });
                $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('lkrujukankeluar-m-grid', {
                data: $(this).serialize()
                });
                return false;
                });
                ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rujukan Ke Luar</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Rujukan Keluar</b></h6>-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'lkrujukankeluar-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'rujukankeluar_id',
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        'rumahsakitrujukan',
                        'alamatrsrujukan',
                        'telp_fax',
                        array(
                            'header' => 'Status',
                            'value' => '($data->rujukankeluar_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //'rujukankeluar_aktif',
                        //                array(
                        //                    'header'=>'Aktif',
                        //                    'class'=>'CCheckBoxColumn',
                        //                    'selectableRows'=>0,
                        //                    'id'=>'rows',
                        //                    'checked'=>'$data->rujukankeluar_aktif',
                        //                ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->rujukankeluar_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->rujukankeluar_id)",array("id"=>"$data->rujukankeluar_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rujukankeluar_id)",array("id"=>"$data->rujukankeluar_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->rujukankeluar_id, 1)",array("id"=>"$data->rujukankeluar_id","rel"=>"tooltip","title"=>"Mengaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rujukankeluar_id)",array("id"=>"$data->rujukankeluar_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                        cekForm(this);
                        })
                        }',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Rujukan Keluar', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array(
                    'class' => 'btn btn-danger',
                    'title' => 'Tambah rujukan keluar',
                )
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            // $js = <<< JSCRIPT
            //     function cekForm(obj)
            //     {
            //     $("#lkrujukankeluar-m-search :input[name='"+ obj.name +"']").val(obj.value);
            //     }     

            //     function print(caraPrint)
            //     {
            //     window.open("${urlPrint}/"+$('#lkrujukankeluar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
            //     }
            //     JSCRIPT;
            // Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            $js = <<< JSCRIPT
				function cekForm(obj){
					$("#lkrujukankeluar-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}     
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#lkrujukankeluar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

            ?>
            <script type="text/javascript">
                function removeTemporary(id) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('lkrujukankeluar-m-grid');
                                    } else {
                                        myAlert('Data gagal dinonaktifkan!')
                                    }
                                }, "json");
                        }
                    });
                }

                function addTemporary(id, add) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm('Yakin akan mengaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id,
                                    add: add
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('lkrujukankeluar-m-grid');
                                    } else {
                                        myAlert('Data gagal diaktifkan!')
                                    }
                                }, "json");
                        }
                    });
                }

                function deleteRecord(id) {
                    var id = id;
                    var url = '<?php echo $url . "/delete"; ?>';
                    myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('lkrujukankeluar-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus!')
                                    }
                                }, "json");
                        }
                    });
                }
                $(document).ready(function() {
                    $("input[name='SARujukankeluarM[rumahsakitrujukan]']").focus();
                });
            </script>
        </div>
    </div>
</div>