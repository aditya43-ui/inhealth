<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Komponen Tarif</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sakomponen Tarif Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Komponen Tarif ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif Instalasi', 'icon'=>'file', 'url'=>array('createKomponenTarifInstalasi'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sakomponen-tarif-m-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Komponen Tarif</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id;
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sakomponen-tarif-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'komponentarif_id',
                        array(
                            'name' => 'komponentarif_id',
                            'value' => '$data->komponentarif_id',
                            'filter' => false,
                        ),
                        'komponentarif_nama',
                        'komponentarif_namalainnya',
                        'komponentarif_urutan',
                        //'komponentarif_aktif',
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.komponentarifM._komponenTarifInstalasi\',array(\'komponentarif_id\'=>$data->komponentarif_id),true)',
                            'filter' => (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? CHtml::link('<i class="icon-file"></i>' . Yii::t('mds', 'Create'), Yii::app()->createUrl($module . '/' . $controller . '/createKomponenTarifInstalasi')) : '',
                        ),
                        //		array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',
                        //                        'selectableRows'=>0,
                        //                        'checked'=>'$data->komponentarif_aktif',
                        //      ),
                        array(
                            'header' => 'Kelompok Komponen/ Persentase',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $kel = PersenkelkomponentarifM::model()->findAllByAttributes(array(
                                    'komponentarif_id' => $data->komponentarif_id,
                                ));
                                if (count((array)$kel) == 0) return "-";

                                $st = "<ul>";
                                foreach ($kel as $item) {
                                    $st .= "<li>" . $item->kelompokkomponentarif->kelompokkomponentarif_nama
                                        . " (" . $item->persentase . "%)</li>";
                                }
                                $st .= "</ul>";

                                return $st;
                            }
                        ),
                        array(
                            'header' => 'Komponen Pembayaran Jasa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->ispembayaranjasa == TRUE) {
                                    echo CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small"));
                                } else {
                                    echo "-";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align:center'),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->komponentarif_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
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
                            'value' => '($data->komponentarif_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->komponentarif_id)",array("id"=>"$data->komponentarif_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->komponentarif_id)",array("id"=>"$data->komponentarif_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->komponentarif_id)",array("id"=>"$data->komponentarif_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width:100px;'),
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

            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Komponen Tarif', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah komponen tarif', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('sistemAdministrator.views.tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sakomponen-tarif-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakomponen-tarif-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
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
                                    $.fn.yiiGridView.update('sakomponen-tarif-m-grid');
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
                                    $.fn.yiiGridView.update('sakomponen-tarif-m-grid');
                                } else {
                                    myAlert('Data gagal dihapus!')
                                }
                            }, "json");
                    }
                });
            }
            $(document).ready(function() {
                $("input[name='SAKomponentarifM[komponentarif_nama]']").focus();
            });
        </script>
    </div>
</div>