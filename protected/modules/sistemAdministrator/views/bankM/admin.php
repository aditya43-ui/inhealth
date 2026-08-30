<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Bank Penerimaan / Pengeluaran RS</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Bank',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bank ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bank', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SABankRekM_propinsi_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bank-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Bank Penerimaan / Pengeluaran RS</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Bank</b></h6>-->
                <!--<div style='max-width:970;overflow-x:scroll'>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'bank-m-grid',
                    'dataProvider' => $model->searchBank2(),
                    // 'filter'=>$model,
                    'overflowx' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Nama Bank',
                            'name' => 'namabank',
                            'value' => '$data->namabank',
                        ),
                        array(
                            'header' => 'No. Rekening',
                            'name' => 'norekening',
                            'value' => '$data->norekening',
                        ),
                        array(
                            'header' => 'Atas Nama',
                            'name' => 'bank_atasnama',
                            'value' => '$data->bank_atasnama',
                        ),
                        array(
                            'header' => 'Mata Uang',
                            'name' => 'matauang_id',
                            'value' => 'empty($data->matauang_id)?"-":$data->matauang->matauang',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Provinsi',
                            'name' => 'propinsi_id',
                            'value' => 'empty($data->propinsi_id)?"-":$data->propinsi->propinsi_nama',
                            'filter' => false,
                            //'filter'=>CHtml::activeDropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                            //	'empty'=>'-- Pilih --',
                            //)),
                        ),
                        array(
                            'header' => 'Kabupaten',
                            'name' => 'kabupaten_id',
                            'value' => 'empty($data->kabupaten_id)?"-":$data->kabupaten->kabupaten_nama',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Alamat Bank',
                            'name' => 'alamatbank',
                            'value' => '$data->alamatbank',
                        ),
                        array(
                            'header' => 'Cabang dari/<br>Negara',
                            'name' => 'cabangdari',
                            'value' => '$data->cabangdari ." / ".$data->negara',
                        ),
                        array(
                            'header' => 'Rekening Debit',
                            //'name'=>'rekening_debit',
                            'type' => 'raw',
                            // 'value' => '$data->rekeningdebit.rekDebit',
                            'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.bankM._rekBankD",array("saldonormal"=>"D","bank_id"=>$data->bank_id),true)',
                        ),
                        array(
                            'header' => 'Rekening Kredit',
                            //'name'=>'rekeningKredit',
                            'type' => 'raw',
                            'value' => '$data->rekKredit',
                            'value' => '$this->grid->owner->renderPartial("sistemAdministrator.views.bankM._rekBankK",array("saldonormal"=>"K","bank_id"=>$data->bank_id),true)',
                        ),
                        array(
                            'header' => 'Aktif',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'value' => '($data->bank_aktif) ? "Aktif" : "Tidak Aktif" ',
                        ),
                        array(
                            'header' => 'Lihat',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='icon-view'></i>",
                                    'options' => array('title' => Yii::t('mds', 'View')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->bank_id"))',

                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'label' => "<i class='icon-form-ubah'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Update')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->bank_id))',

                                ),
                            ),
                        ),
                        /* array(
                            'header'=>Yii::t('zii','Delete'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove} {delete}',
                            'buttons'=>array(
                                    'remove' => array (
                                            'label'=>"<i class='".MyIcon::getIcons('batal')."'></i>",
                                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->bank_id"))',
                                            'visible'=>'($data->bank->bank_aktif)?FALSE:FALSE',
                                           // 'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                    ),
                                    'delete' => array (
											'label'=>"<i class='".MyIcon::getIcons('hapus')."'></i>",
											'options'=>array('title'=>Yii::t('mds','Delete')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->bank_id"))',               
									),
                            )
            ),*/
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->bank_aktif) {
                                    return    CHtml::link("<i class='" . MyIcon::getIcons('batal') . "'></i> ", "javascript:removeTemporary(" . $data->bank_id . " )", array("id" => $data->bank_id, "rel" => "tooltip", "title" => "Menonaktifkan")) . " " .
                                        CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "'></i>", "javascript:deleteRecordMaster(" . $data->bank_id . " )", array("id" => $data->bank_id, "rel" => "tooltip", "title" => "Hapus"));
                                } else {
                                    CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "'></i>", "javascript:deleteRecordMaster(" . $data->bank_id . ")", array("id" => "$data->bank_id", "rel" => "tooltip", "title" => "Hapus"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Hapus Rekening',
                            'type' => 'raw',
                            'value' => function ($data) {

                                return    CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "' style='filter: hue-rotate(250deg);'></i>", "javascript:deleteRecord(" . $data->bank_id . " )", array("id" => $data->bank_id, "rel" => "tooltip", "title" => "Hapus Rekening"));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                        . '$(".numbers-only").keyup(function() {
                        setNumbersOnly(this);
                    });
                    $(".hurufs-only").keyup(function() {
                         setHurufsOnly(this);                    
                    });}',


                )); ?>
                <!--</div></br>-->
                <!--</div>-->
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Bank Penerimaan / Pengeluaran RS', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Bank Penerimaan / Pengeluaran RS', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . '/tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bank-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>

    <?php
    // Dialog buat lihat penjualan resep =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogUbahRekeningDebitKredit',
        'options' => array(
            'title' => 'Ubah Data Rekening',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 1000,
            'height' => 700,
            'resizable' => false,
            'close' => 'js:function(){$.fn.yiiGridView.update(\'bank-m-grid\', {})}'
        ),
    ));
    ?>
    <iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="600">
    </iframe>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.get(url, {
                            id: id
                        },
                        function(data) {
                            $.fn.yiiGridView.update('bank-m-grid');
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
                        function(data) {
                            $.fn.yiiGridView.update('bank-m-grid');
                        }, "json");
                }
            });
    }

    function deleteRecordMaster(id) {
        var id = id;
        var url = '<?php echo $url . "/deleteMaster"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data bank ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            $.fn.yiiGridView.update('bank-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert("Data tidak bisa dihapus karena sudah dipakai oleh Transaksi lain.");
                            }
                        }, "json");
                }
            });
    }
</script>