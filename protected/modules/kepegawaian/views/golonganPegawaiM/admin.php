<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Golongan Pegawai</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Golongan Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sagolongan Pegawai Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Golongan Pegawai', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan Pegawai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#KPGolonganPegawaiM_golonganpegawai_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sagolongan-pegawai-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert');
        //$this->renderPartial('_tabMenu',array());
        ?>
        <!--<div class="biru">
        <div class="white">-->
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Golongan Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sagolongan-pegawai-m-grid',
                    'dataProvider' => $model->search(),
                    //  'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        ////'golonganpegawai_id',
                        array(
                            'name' => 'golonganpegawai_id',
                            'value' => '$data->golonganpegawai_id',
                            'filter' => false,
                        ),
                        'golonganpegawai_nama',
                        'golonganpegawai_namalainnya',
                        array(
                            'header' => 'Status',
                            'value' => '($data->golonganpegawai_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        //                 array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->golonganpegawai_aktif',
                        //                ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
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
                            'value' => '($data->golonganpegawai_aktif)?CHtml::link("<i class=\'entypo-cancel\'></i> ","javascript:removeTemporary($data->golonganpegawai_id)",array("id"=>"$data->golonganpegawai_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->golonganpegawai_id)",array("id"=>"$data->golonganpegawai_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->golonganpegawai_id)",array("id"=>"$data->golonganpegawai_id","rel"=>"tooltip","title"=>"Hapus"));',
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
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Golongan Pegawai', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        $content = $this->renderPartial('../tips/master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

        $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sagolongan-pegawai-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sagolongan-pegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
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
                                    $.fn.yiiGridView.update('sagolongan-pegawai-m-grid');
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
                                    $.fn.yiiGridView.update('sagolongan-pegawai-m-grid');
                                } else {
                                    myAlert('Data gagal dihapus!')
                                }
                            }, "json");
                    }
                });
        }
    </script>
</div>