    <?php
    $this->breadcrumbs = array(
        'Pbf',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pbf ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pbf', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pbf', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu = $arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#GFPbfM_pbf_kode').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gfpbf-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-layer-group"></i> Pengaturan <b>PBF</b>
            </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

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
                        <i class="entypo-credit-card"></i> Tabel <b>PBF</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">

                    <!--<h6>Tabel <b>PBF</b></h6>-->
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'gfpbf-m-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            ////'pbf_id',
                            array(
                                'name' => 'pbf_id',
                                'value' => '$data->pbf_id',
                                'filter' => false,
                            ),
                            array(
                                'name' => 'pbf_kode',
                                'value' => '$data->pbf_kode',
                                'filter' => CHtml::activeTextField($model, 'pbf_kode'),
                            ),
                            'pbf_nama',
                            'pbf_singkatan',
                            'pbf_alamat',
                            'pbf_propinsi',
                            array(
                                'header' => 'Status',
                                'value' => '($data->pbf_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            //                 array(
                            //                        'name'=>'pbf_aktif',
                            //                        'class'=>'CCheckBoxColumn',     
                            //                        'selectableRows'=>0,
                            //                        'id'=>'rows',
                            //                        'checked'=>'$data->pbf_aktif',
                            //                ), 
                            array(
                                'header' => 'Lihat',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'template' => '{view}',
                                'buttons' => array(
                                    'view' => array(
                                        'options' => array('rel' => 'tooltip', 'title' => 'Lihat Pbf'),
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
                                        'options' => array('rel' => 'tooltip', 'title' => 'Ubah Pbf'),
                                    ),
                                ),
                            ),
                            array(
                                'header' => 'Hapus',
                                'type' => 'raw',
                                'value' => '($data->pbf_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pbf_id)",array("id"=>"$data->pbf_id","rel"=>"tooltip","title"=>"Menonaktifkan Pbf"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pbf_id)",array("id"=>"$data->pbf_id","rel"=>"tooltip","title"=>"Hapus Pbf")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pbf_id)",array("id"=>"$data->pbf_id","rel"=>"tooltip","title"=>"Hapus Pbf"));',
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
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                echo CHtml::link(Yii::t('mds', '{icon} Tambah PBF', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#gfpbf-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gfpbf-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                    $.fn.yiiGridView.update('gfpbf-m-grid');
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
                                    $.fn.yiiGridView.update('gfpbf-m-grid');
                                } else {
                                    myAlert('Data gagal dihapus!')
                                }
                            }, "json");
                    }
                });
        }
        $('.filters #GFPbfM_pbf_kode').focus();
    </script>