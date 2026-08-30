<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Jenis Pengeluaran Berhasil Disimpan!");
}
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Jurnal Rekening Pengeluaran</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jenis Rekening Pengeluaran' => array('index'),
            'Pengaturan',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Pengeluaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rek Pengeluaran ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#AKJnsPengeluaranRekM_jenispengeluaran_kode').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('jenispengeluaran-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert');
        //$this->renderPartial('_tabMenuPengeluaran',array());
        ?>
        <!--<div class="biru">
        <div class="white">-->
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening Pengeluaran</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'jenispengeluaran-m-grid',
                    'dataProvider' => $model->search(),
                    //  'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
                        array(
                            'header' => 'Kode',
                            'name' => 'jenispengeluaran_kode',
                            'value' => '$data->jenispengeluaran_kode',
                        ),
                        array(
                            'header' => 'Jenis Pengeluaran',
                            'name' => 'jenispengeluaran_nama',
                            'value' => '$data->jenispengeluaran_nama',
                        ), /*
                        array(
                            'header'=>'Nama Lain',
                            'name'=>'jenispengeluaran_namalain',
                            'value'=>'$data->jenispengeluaran->jenispengeluaran_namalain',
                        ), */
                        array(
                            'header' => 'Rekening Debit',
                            //'name'=>'rekeningdebit_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $tr = '';
                                $r = JnspengeluaranrekM::model()->findAllByAttributes(array(
                                    'jenispengeluaran_id' => $data->jenispengeluaran_id,
                                    'debitkredit' => 'D'
                                ));
                                //var_dump(count((array)$r));
                                if (empty($r)) return "-";

                                $tr = '<ul>';
                                foreach ($r as $rekD) {
                                    $tr .= '<li>' . $rekD->rekeningdebit->kdrekening5 . ' - ' . $rekD->rekeningdebit->nmrekening5 . '</li>';
                                }
                                $tr .= '</ul>';

                                return $tr;
                                //if (empty($r5)) return "-";
                                //return $r5->nmrekening5;
                            }
                            //'value'=>'$this->grid->owner->renderPartial("_rekPenerimaanD",array("saldonormal"=>"D","jenispenerimaan_id"=>$data->jenispenerimaan_id),true)',
                        ),
                        // array(
                        //     'header' => 'Rekening Kredit',
                        //     //'name'=>'rekeningkredit_id',
                        //     'type' => 'raw',
                        //     'value' => function ($data) {
                        //         $r = JnspengeluaranrekM::model()->findAllByAttributes(array(
                        //             'jenispengeluaran_id' => $data->jenispengeluaran_id,
                        //             'debitkredit' => 'K'
                        //         ));

                        //         if (empty($r)) return "-";

                        //         //echo count((array)$r);
                        //         $tr = '<ul>';
                        //         foreach ($r as $rekK) {
                        //             $tr .= '<li>' . $rekK->rekeningkredit->kdrekening5 . ' - ' . $rekK->rekeningkredit->nmrekening5 . '</li>';
                        //         }
                        //         $tr .= '</ul>';

                        //         return $tr;
                        //         //$r5 = Rekening5M::model()->findByPk($r->rekening5_id);

                        //         //  if (empty($r5)) return "-";
                        //         //return $r5->nmrekening5;
                        //     }
                        //     //'value'=>'$this->grid->owner->renderPartial("_rekPenerimaanK",array("saldonormal"=>"K","jenispenerimaan_id"=>$data->jenispenerimaan_id),true)',
                        // ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->jenispengeluaran_aktif = 1 ) ? "Aktif" : "Tidak Aktif" ',
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'label' => "<i class='" . MyIcon::getIcons('lihat') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'View')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->jenispengeluaran_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',

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
                                    'label' => "<i class='" . MyIcon::getIcons('ubah') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Update')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->jenispengeluaran_id","tab"=>"' . (isset($_GET['tab']) ? $_GET['tab'] : '') . '"))',
                                ),
                            ),
                        ),
                        /*   array(
                            'header'=>'Hapus',
                            'type'=>'raw',
                            'value'=>function($data){
								
                                if ($data->jenispengeluaran_aktif){
                                        return	CHtml::link("<i class='".MyIcon::getIcons('hapus')."'></i>", "javascript:deleteRecordMaster(".$data->jenispengeluaran_id." )",array("id"=>$data->jenispengeluaran_id,"rel"=>"tooltip","title"=>"Hapus")); //CHtml::link("<i class='".MyIcon::getIcons('batal')."'></i> ","javascript:removeTemporary(".$data->jenispengeluaran_id." )",array("id"=>$data->jenispengeluaran_id,"rel"=>"tooltip","title"=>"Menonaktifkan"))." ".
                                }else{
                                        return CHtml::link("<i class='".MyIcon::getIcons('hapus')."'></i>", "javascript:deleteRecordMaster(".$data->jenispengeluaran_id.")",array("id"=>"$data->jenispengeluaran_id","rel"=>"tooltip","title"=>"Hapus"));
                                }		
									
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),*/
                        array(
                            'header' => 'Hapus Rekening',
                            'type' => 'raw',
                            'value' => function ($data) {

                                return    CHtml::link("<i class='" . MyIcon::getIcons('hapus') . "'></i>", "javascript:deleteRecord(" . $data->jenispengeluaran_id . " )", array("id" => $data->jenispengeluaran_id, "rel" => "tooltip", "title" => "Hapus Rekening"));
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
                Yii::t('mds', '{icon} Tambah Jurnal Rekening Pengeluaran', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Tambah jurnal rekening pengeluaran', 'class' => 'btn btn-danger',)
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
    $("#jenispengeluaran-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenispengeluaran-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
            'minWidth' => 800,
            'height' => 400,
            'resizable' => false,
            'close' => 'js:function(){$.fn.yiiGridView.update(\'jenispengeluaran-m-grid\', {})}'
        ),
    ));
    ?>
    <iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300">
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
                            $.fn.yiiGridView.update('jenispengeluaran-m-grid');
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
                            $.fn.yiiGridView.update('jenispengeluaran-m-grid');
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
                            $.fn.yiiGridView.update('jenispengeluaran-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert("Data tidak bisa dihapus karena sudah dipakai oleh Transaksi lain.");
                            }
                        }, "json");
                }
            });
    }
</script>