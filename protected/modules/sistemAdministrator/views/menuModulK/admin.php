<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Pengaturan <b>Menu</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (Yii::app()->session['modul_id'] != Params::MODUL_ID_ANTRIAN) {
            $this->renderPartial($this->path_view . '_tab');
        }
        ?>

        <?php
        $this->breadcrumbs = array(
            'Menu' => array('admin'),
            'Pengaturan',
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','Manage').' Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Menu', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Menu', 'icon'=>'file', 'url'=>array('create','modul_id'=>(isset($_REQUEST['modul_id']) ? $_REQUEST['modul_id'] : ''))),
        );

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SAMenuModulK_kelmenu_id').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('samenu-modul-k-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Menu</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<div class='block-tabel'>-->
                <!--<legend class="rim">Tabel Menu</legend>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'samenu-modul-k-grid',
                    'dataProvider' => $model->search(),
                    //    'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        ////'menu_id',
                        array(
                            'name' => 'menu_id',
                            'value' => '$data->menu_id',
                            'filter' => false,
                        ),
                        //'kelmenu_id',
                        array(
                            'name' => 'modul_id',
                            'value' => '$data->modulk->modul_nama',
                            'filter' => CHtml::dropDownList('SAMenuModulK[modul_id]', $model->modul_id, CHtml::listData($model->getModulItems(), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'name' => 'kelmenu_id',
                            'value' => '$data->kelompokmenu->kelmenu_nama',
                            'filter' => CHtml::dropDownList('SAMenuModulK[kelmenu_id]', $model->kelmenu_id, CHtml::listData($model->getKelompokMenuItems(), 'kelmenu_id', 'kelmenu_nama'), array('empty' => '-- Pilih --')),
                        ),
                        //'kelompokmenu.kelmenu_nama',

                        //'modul_id',
                        //'modulk.modul_nama',
                        'menu_nama',
                        'menu_fungsi',
                        // 'menu_namalainnya',
                        //'menu_url',
                        //'menu_urutan',
                        /*
                            'menu_key',
                            'menu_fungsi',
                            'menu_aktif',
                            */
                        array(
                            'header' => 'Icon',
                            'name' => 'menu_icon',
                            'type' => 'raw',
                            'value' => '$data->menu_icon ? "<i class=\'$data->menu_icon\'></i> $data->menu_icon" : "Belum ada icon"',
                            'htmlOptions' => array('style' => 'min-width: 100px;'),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->menu_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=> 'CCheckBoxColumn',
                        //                        'selectableRows'=>0,
                        //                        'checked'=>'$data->menu_aktif',
                        //                ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Menu'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Menu'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->menu_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Menonaktifkan Menu"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Hapus Menu")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Hapus Menu"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                         $("table").find("select").each(function(){
                            cekForm(this);
                        })
                    }',
                )); ?>
                <!--</div>-->
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Menu', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah menu', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#samenu-modul-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#samenu-modul-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>

    <script type="text/javascript">
        function removeTemporary(id) {
            var url = '<?php echo $url . "/removeTemporary"; ?>';
            myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('samenu-modul-k-grid');
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
            myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('samenu-modul-k-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
        }
        $('.filters #SAMenuModulK_kelmenu_id').focus();
    </script>
</div>