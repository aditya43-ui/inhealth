<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jenis Kegiatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jenis Kegiatan' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Unit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Unit', 'icon'=>'list', 'url'=>array('index'))) ;
        //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Unit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#SAKJenisKegiatanM_jeniskegiatan_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sajenis-kegiatan-m-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Jenis Kegiatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sajenis-kegiatan-m-grid',
                    'dataProvider' => $model->search(),
                    //  'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        ////'komponenunit_id',
                        array(
                            'header' => 'ID',
                            'name' => 'jeniskegiatan_id',
                            'value' => '$data->jeniskegiatan_id',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Kode Jenis Kegiatan',
                            'name' => 'jeniskegiatan_kode',
                            'value' => '$data->jeniskegiatan_kode',
                            'filter' => Chtml::activeTextField($model, 'jeniskegiatan_kode', array('class' => 'custom-only'))
                        ),
                        array(
                            'header' => 'Nama Jenis Kegiatan',
                            'name' => 'jeniskegiatan_nama',
                            'value' => '$data->jeniskegiatan_nama',
                            'filter' => Chtml::activeTextField($model, 'jeniskegiatan_nama', array('class' => 'custom-only'))
                        ),
                        array(
                            'header' => 'Ruang Jenis Kegiatan',
                            'name' => 'jeniskegiatan_ruangan',
                            'value' => '$data->jeniskegiatan_ruangan',
                            //'filter' => Chtml::activeTextField($model, 'jeniskegiatan_ruangan', array('class'=>'custom-only'))
                            'filter' => Chtml::activeDropDownList($model, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->jeniskegiatan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //'komponenunit_aktif',
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',
                        //                        'selectableRows'=>0,
                        //                        'checked'=>'$data->komponenunit_aktif',
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Jenis Kegiatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->jeniskegiatan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jeniskegiatan_id)",array("id"=>"$data->jeniskegiatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Jenis Kegiatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniskegiatan_id)",array("id"=>"$data->jeniskegiatan_id","rel"=>"tooltip","title"=>"Hapus Jenis Kegiatan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniskegiatan_id)",array("id"=>"$data->jeniskegiatan_id","rel"=>"tooltip","title"=>"Hapus Jenis Kegiatan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
                $(".custom-only").keyup(function() {
                    setCustomOnly(this);
                });
            }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jenis Kegiatan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah jenis kegiatan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $tips = array(
                '0' => 'lihat',
                '1' => 'ubah',
                '2' => 'nonaktif',
                '3' => 'hapus',
                '4' => 'masterPDF',
                '5' => 'masterEXCEL',
                '6' => 'masterPRINT',
                '7' => 'pencarianlanjut',
                '8' => 'cari',

            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajenis-kegiatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sajenis-kegiatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>

    <script type="text/javascript">
        function removeTemporary(obj) {
            myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
                function(r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function(data) {
                                $.fn.yiiGridView.update('sajenis-kegiatan-m-grid');
                                if (data.sukses > 0) {

                                } else {
                                    myAlert('Data gagal dinonaktifkan!');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                myAlert('Data gagal dinonaktifkan!');
                                console.log(errorThrown);
                            }
                        });
                    }
                }
            );
            return false;
        }

        function deleteRecord(id) {
            var id = id;
            var url = '<?php echo $url . "/delete"; ?>';
            myConfirm("Apakah Anda yakin ingin menghapus data ini?", "Perhatian!", function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenis-kegiatan-m-grid');
                            } else if (data.status == 'gagal_form') {
                                myAlert('Maaf, Data tidak bisa dihapus, karena sedang digunakan di tabel lain.')
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
        }
    </script>
</div>