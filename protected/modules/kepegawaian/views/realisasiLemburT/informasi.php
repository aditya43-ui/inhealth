<?php
$this->breadcrumbs = array(
    'Informasi Realisasi Lembur',
);
$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => 'Informasi Realisasi Lembur ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
});
$('.search-form form').submit(function(){
        $.fn.yiiGridView.update('realisasi-lembur-t-grid', {
                data: $(this).serialize()
        });
        return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Realisasi Lembur</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('modRealisasiLembur' => $modRealisasiLembur,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Realisasi Lembur</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'realisasi-lembur-t-grid',
                    'dataProvider' => $modRealisasiLembur->searchInformasiRealisasiLembur(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'no',
                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'header' => 'No.',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'tglrealisasi',
                            'value' => 'date("d M Y H:i:s",strtotime($data->tglrealisasi))',
                        ),
                        array(
                            'name' => 'norealisasi',
                            'value' => '$data->norealisasi',
                        ),
                        //                                        array(
                        //                                                'name'=>'mengetahui_nama',
                        //                                                'header'=>'Mengetahui',
                        //                                                'value'=>'$data->getPegawaiAttributes($data->mengetahui_id,\'nama_pegawai\')',
                        //                                                'filter'=>false,
                        //                                        ),
                        array(
                            'name' => 'menyetujui_nama',
                            'header' => 'Menyetujui',
                            'value' => '$data->getPegawaiAttributes($data->menyetujui_id,\'nama_pegawai\')',
                            //'value'=>'$data->menyetujui_id',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'pemberitugas_nama',
                            'header' => 'Pemberi Tugas',
                            'value' => '$data->getPegawaiAttributes($data->pemberitugas_id,\'nama_pegawai\')',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/lihatdetail",
                                                array("id"=>$data->realisasilembur_id)),
                                                array("title"=>"Klik untuk Lihat Rincian","target"=>"iframeLihatDetail", "onclick"=>"$(\'#dialogLihatDetail\').dialog(\'open\')"))', //'CHtml::link("<i class=\'icon-search\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",array("id"=>$data->pegawai_id)),array("title"=>"Klik untuk Pindah Kamar","target"=>"iframeLihatDetail", "onclick"=>"$(\"#dialogLihatDetail\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Keterangan',
                            'value' => '$data->keterangan'
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                                    'rel' => 'tooltip',
                                    'title' => 'Klik untuk Hapus Realisasi Lembur.',
                                    'onclick' => 'hapusRealisasiLembur(' . $data->realisasilembur_id . '); return false;',
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $js = <<< JSCRIPT
                function print(caraPrint)
                {
                    window.open("${urlPrint}/"+$('#realisasi-lembur-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php
        //============================ Dialog Lihat Detail =============================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogLihatDetail',
            'options' => array(
                'title' => 'Lihat Rincian Realisasi Lembur',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 900,
                'zIndex' => 1002,
                'resizable' => true,
            ),
        ));
        echo '<iframe src="" name="iframeLihatDetail" width="100%" style="overflow-x" height="400"></iframe>';
        $this->endWidget();
        //==============================================================================
        ?>
    </div>
</div>
<script type="text/javascript">
    function hapusRealisasiLembur(id) {
        myConfirm("Anda yakin untuk menghapus data ini?", "Peringatan", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRealisasiLembur'); ?>',
                    data: {
                        id: id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 'ok') {
                            myAlert(data.keterangan);
                            $.fn.yiiGridView.update('realisasi-lembur-t-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            myAlert(data.keterangan);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>