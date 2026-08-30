<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Kelas Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Kelas Pelayanan' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Pelayanan  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Pelayanan ', 'icon'=>'list', 'url'=>array('index'))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Pelayanan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan ', 'icon'=>'file', 'url'=>array('createRuangan'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAKelasPelayananM_jeniskelas_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sakelas-pelayanan-m-grid', {
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
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kelas Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sakelas-pelayanan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'kelaspelayanan_id',
                        array(
                            'header' => 'ID',
                            'value' => '$data->kelaspelayanan_id',
                        ),
                        array(
                            'name' => 'jeniskelas_id',
                            'filter' => CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),
                            'value' => '$data->jeniskelas->jeniskelas_nama',
                        ),
                        'kelaspelayanan_nama',
                        'kelaspelayanan_namalainnya',
                        array(
                            'header' => 'Status',
                            'value' => '($data->kelaspelayanan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                 array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->kelaspelayanan_aktif',
                        //                ),
                        array(
                            'header' => 'Ruangan ',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id),true)',
                        ),
                        array(
                            'name'=>'urutankelas', 
                            'filter'=>false,
                        ),
                        array(
                            'name'=>'kelasbpjs_id', 
                            'filter'=>false,
                        ),
                        array(
                            'name'=>'kelasnaikbpjs_id', 
                            'filter'=>false,
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Kelas Pelayanan'),
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
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Kelas Pelayanan'),
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->kelaspelayanan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Menonaktifkan Kelas Pelayanan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Kelas Pelayanan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Kelas Pelayanan"));',
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Kelas Pelayanan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah kelas pelayanan', 'class' => 'btn btn-danger',)
            );
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) : '';
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) : '';
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) : '';
            $content = $this->renderPartial('../tips/master8', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print'); //
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sajenis-kelas-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(obj)
{
    window.open("${urlPrint}/"+$('#sajenis-kelas-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');

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
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sakelas-pelayanan-m-grid');
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
                            $.fn.yiiGridView.update('sakelas-pelayanan-m-grid');
                        } else {
                            myAlert(data.konfirmasi);
                        }
                    }, "json");
            }
        });
    }
</script>