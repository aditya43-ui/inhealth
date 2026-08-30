<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Jurnal Rekening Kolom</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Rekening Kolom' => array('admin'),
            'Pengaturan',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rek Penerimaan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rekeningcolumn-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening Kolom</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'rekeningcolumn-m-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Keterangan Penggunaan Rekening',
                            'name' => 'keterangan',
                            'value' => '$data->keterangan',
                        ),
                        array(
                            'header' => 'Nama Tabel',
                            'name' => 'table_name',
                            'value' => '$data->table_name',
                        ),
                        array(
                            'header' => 'Nama Kolom',
                            'name' => 'column_name',
                            'value' => '$data->column_name',
                        ),

                        array(
                            'header' => 'Rekening Debit',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $r = RekeningcolumnM::model()->findAllByAttributes(array(
                                    'rekeningcolumn_id' => $data->rekeningcolumn_id,
                                    'debitkredit' => 'D'
                                ));
                                $str = "<ul>";

                                if (count((array)$r) == 0) return "-";
                                foreach ($r as $item) {
                                    $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                                    $str .= "<li>" . $r5->nmrekening5 . "</li>";
                                }

                                $str .= "</ul>";
                                return $str;
                            }
                        ),
                        array(
                            'header' => 'Rekening Kredit',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $r = RekeningcolumnM::model()->findAllByAttributes(array(
                                    'rekeningcolumn_id' => $data->rekeningcolumn_id,
                                    'debitkredit' => 'K'
                                ));
                                $str = "<ul>";

                                if (count((array)$r) == 0) return "-";
                                foreach ($r as $item) {
                                    $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                                    $str .= "<li>" . $r5->nmrekening5 . "</li>";
                                }

                                $str .= "</ul>";
                                return $str;
                            }
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='icon-view'></i>",
                                    'options' => array('title' => Yii::t('mds', 'View')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->rekeningcolumn_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
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
                                    'label' => "<i class='icon-update'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Update')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->rekeningcolumn_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus Rekening',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return    CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "'></i>", "javascript:deleteRecord(" . $data->rekeningcolumn_id . " )", array("id" => $data->rekeningcolumn_id, "rel" => "tooltip", "title" => "Hapus Rekening"));
                            },
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
                        }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jurnal Rekening Kolom', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Tambah jurnal rekening kolom', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('akuntansi.views.tips.master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#rekeningcolumn-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rekeningcolumn-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script>
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.get(url, {
                            id: id
                        },
                        function(data) {
                            $.fn.yiiGridView.update('rekeningcolumn-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        }, "json");
                }
            });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data rekening ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function() {
                            $.fn.yiiGridView.update('rekeningcolumn-m-grid');
                        });
                }
            });
    }

    function deleteRecordMaster(id) {
        var id = id;
        var url = '<?php echo $url . "/deleteMaster"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            $.fn.yiiGridView.update('rekeningcolumn-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert("Data tidak bisa dihapus karena sudah dipakai oleh Transaksi lain.");
                            }
                        }, "json");
                }
            });
    }
</script>