<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Pengaturan <b>Kelompok Menu</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_tab'); ?>
        <div class='biru'>
            <div class='white'>
                <?php
                $this->breadcrumbs = array(
                    'Kelompok Menu' => array('admin'),
                    'Pengaturan',
                );

                $this->menu = array(
                    //        array('label'=>Yii::t('mds','Manage').' Kelompok Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
                    //	array('label'=>Yii::t('mds','List').' Kelompok Menu', 'icon'=>'list', 'url'=>array('index')),
                    //	array('label'=>Yii::t('mds','Create').' Kelompok Menu', 'icon'=>'file', 'url'=>array('create')),
                );

                Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SAKelompokMenuK_kelmenu_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('sakelompok-menu-k-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <div class="cari-lanjut search-form">
                    <?php $this->renderPartial('_search', array(
                        'model' => $model,
                    )); ?>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Kelompok Menu</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--<div class='block-tabel'>-->
                        <!--<legend class="rim">Tabel Kelompok Menu</legend>-->
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'sakelompok-menu-k-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped datatable',
                            'columns' => array(
                                ////'kelmenu_id',
                                array(
                                    'header' => 'ID',
                                    'value' => '$data->kelmenu_id',
                                ),
                                array(
                                    'header' => 'Kelompok Menu',
                                    'value' => '$data->kelmenu_nama',
                                    'filter' => CHtml::activeTextField($model, 'kelmenu_nama'),
                                ),
                                'kelmenu_namalainnya',
                                'kelmenu_key',
                                'kelmenu_url',
                                'kelmenu_urutan',
                                array(
                                    'header' => 'Icon',
                                    // 'name' => 'kelmenu_icon',
                                    'type' => 'raw',
                                    'value' => '$data->kelmenu_icon ? "<i class=\'$data->kelmenu_icon\'></i> $data->kelmenu_icon" : "Belum ada icon"',
                                    'htmlOptions' => array('style' => 'min-width: 100px;'),
                                ),
                                /*
                            'kelmenu_aktif',
                            */
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->kelmenu_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                                //                array(
                                //                        'header'=>'Aktif',
                                //                        'class'=>  'CCheckBoxColumn',
                                //                        'selectableRows'=>0,
                                //                        'checked'=>'$data->kelmenu_aktif',
                                //                ),
                                array(
                                    'header' => 'Lihat',
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(
                                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat Kelompok Menu'),
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
                                            'options' => array('rel' => 'tooltip', 'title' => 'Ubah Kelompok Menu'),
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->kelmenu_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kelmenu_id)",array("id"=>"$data->kelmenu_id","rel"=>"tooltip","title"=>"Menonaktifkan Kelompok Menu"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelmenu_id)",array("id"=>"$data->kelmenu_id","rel"=>"tooltip","title"=>"Hapus Kelompok Menu")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelmenu_id)",array("id"=>"$data->kelmenu_id","rel"=>"tooltip","title"=>"Hapus Kelompok Menu"));',
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
                        Yii::t('mds', '{icon} Tambah Kelompok Menu', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                        $this->createUrl('/sistemAdministrator/kelompokMenuK/create', array('modul_id' => Yii::app()->session['modul_id'])),
                        array('title' => 'Tambah kelompok menu', 'class' => 'btn btn-danger',)
                    );
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                    $content = $this->renderPartial('../tips/master', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                    $js = <<< JSCRIPT
                function cekForm(obj)
                {
                    $("#sakelompok-menu-k-search :input[name='"+ obj.name +"']").val(obj.value);
                }
                function print(caraPrint)
                {
                    window.open("${urlPrint}/"+$('#sakelompok-menu-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                    ?>
                </div>
            </div>
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
                            $.fn.yiiGridView.update('sakelompok-menu-k-grid');
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
                            $.fn.yiiGridView.update('sakelompok-menu-k-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $('.filters #SAKelompokMenuK_kelmenu_nama').focus();
</script>
</div>