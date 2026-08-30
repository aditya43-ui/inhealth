<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jenis Alat Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sajenisalatmedis Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Alat Medis ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        // array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisalatmedisM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Alat Medis', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAJenisalatmedisM_jenisalatmedis_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sajenisalatmedis-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="row">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        </div>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->
        <div class='block-tabel'>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Table <b>Jenis Alat Medis</b></div>
                </div>
                <div class="panel-body">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'sajenisalatmedis-m-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'name' => 'jenisalatmedis_nama',
                                'value' => '$data->jenisalatmedis_nama',
                                'filter' => CHtml::activeTextField($model, 'jenisalatmedis_nama'),
                            ),
                            'jenisalatmedis_namalain',
                            array(
                                'header' => 'Status',
                                'value' => '($data->jenisalatmedis_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            //                array(
                            //                        'header'=>'Aktif',
                            //                        'class'=>'CCheckBoxColumn',     
                            //                        'selectableRows'=>0,
                            //                        'id'=>'rows',
                            //                        'checked'=>'$data->jenisalatmedis_aktif',
                            //                ),
                            array(
                                'header' => 'Lihat',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{view}',
                                'buttons' => array(
                                    'view' => array(
                                        'options' => array('rel' => 'tooltip', 'title' => 'Lihat Jenis Alat Medis'),
                                    ),
                                ),
                            ),
                            array(
                                'header' => 'Ubah',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{update}',
                                'buttons' => array(
                                    'update' => array(
                                        'options' => array('rel' => 'tooltip', 'title' => 'Ubah Jenis Alat Medis'),
                                        'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    ),
                                ),
                            ),
                            array(
                                'header' => 'Hapus',
                                'type' => 'raw',
                                'value' => '($data->jenisalatmedis_aktif)?CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->jenisalatmedis_id)",array("id"=>"$data->jenisalatmedis_id","rel"=>"tooltip","title"=>"Menonaktifkan Jenis Alat Medis"))." ".CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->jenisalatmedis_id)",array("id"=>"$data->jenisalatmedis_id","rel"=>"tooltip","title"=>"Hapus Jenis Alat Medis")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisalatmedis_id)",array("id"=>"$data->jenisalatmedis_id","rel"=>"tooltip","title"=>"Hapus Jenis Alat Medis"));',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            //		array(
                            //                        'header'=>Yii::t('zii','Delete'),
                            //			'class'=>'bootstrap.widgets.BootButtonColumn',
                            //                        'template'=>'{remove} {delete}',
                            //                        'buttons'=>array(
                            //                                        'remove' => array (
                            //                                                'label'=>"<i class='icon-form-silang'></i>",
                            //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                            //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->jenisalatmedis_id"))',
                            //                                                'visible'=>'($data->jenisalatmedis_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                            //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                            //                                        ),
                            //                                        'delete'=> array(
                            //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                            //                                        ),
                            //                        )
                            //		),
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
                    ));
                    ?>

                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Alat Medis', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                    $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                    $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajenisalatmedis-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sajenisalatmedis-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
            myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenisalatmedis-m-grid');
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
            myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('sajenisalatmedis-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
        }
        $('.filters #SAJenisalatmedisM_jenisalatmedis_nama').focus();
    </script>