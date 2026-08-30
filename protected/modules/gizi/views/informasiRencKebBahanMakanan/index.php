<?php
$this->breadcrumbs = array(
    'Informasi Rencana Kebutuhan Bahan Makanan',
);
Yii::app()->clientScript->registerScript('search', "
$('#rencana-t-search').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rencana Kebutuhan Bahan Makanan</b>
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
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Kebutuhan Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rencana-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'renkebbahanmakanan_tgl',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->renkebbahanmakanan_tgl)',
                        ),
                        'renkebbahanmakanan_no',
                        array(
                            'name' => 'ro_bahanmakanan_bulan',
                            'value' => '$data->ro_bahanmakanan_bulan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Sumber Dana',
                            'type' => 'raw',
                            'value' => '$data->sumberdana_nama',
                        ),
                        array(
                            'header' => 'Kepala Instalasi Gizi',
                            'type' => 'raw',
                            //                                        'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
                            'value' => function ($data) {
                                //$dataDialog = 'myAlert("Hanya '.(isset($data->pegmenyetujui_id)? $data->pegawaimenyetujui($data->pegmenyetujui_id) : "-").' yang bisa mengakses");';
                                //if($data->pegmenyetujui_id==Yii::app()->user->getState('pegawai_id')){
                                $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                //}
                                $html = (isset($data->pegmenyetujui_id) ? $data->pegawaimengetahui($data->pegmenyetujui_id) : "-")
                                    . (!empty($data->tglmenyetujui)
                                        ? "<br>" . MyFormatter::formatDateTimeForUser($data->tglmenyetujui)
                                        : (!isset($data->pegmenyetujui_id)
                                            ? ""
                                            : (!isset($data->pegmenyetujui_id)
                                                ? ""
                                                : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui', array("renkebbahanmakanan_id" => $data->renkebbahanmakanan_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Menyetujui", "onclick" => $dataDialog)))));
                                return $html;
                            }
                        ),
                        //                                    array(
                        //                                        'header'=>'Pegawai Menyetujui',
                        //                                        'type'=>'raw',
                        //                                        'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
                        //                                    ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Rincian", array("renkebbahanmakanan_id"=>$data->renkebbahanmakanan_id)),
                                                                 array("class"=>"", 
                                                                           "target"=>"rencana",
                                                                           "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
                                                                           "rel"=>"tooltip",
                                                                           "title"=>"Klik untuk melihat details Rencana",
                                                                 ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Ubah Rencana',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (isset($data->tglmenyetujui)) {
                                    return "<a rel='tooltip' title='Tidak dapat diubah karena sudah disetujui oleh Kepala Instalasi Gizi'><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a> ";
                                } else {
                                    if ($data->pegmengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                                        return CHtml::link("<icon class='icon-form-ubah'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . $this->path_rencana . '/index', array("renkebbahanmakanan_id" => $data->renkebbahanmakanan_id, "ubah" => true)), array("target" => "BLANK", "rel" => "tooltip", "title" => "Klik untuk mengubah rencana"));
                                    } else {
                                        return "<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh " . $data->pegawaimengetahui($data->pegmengetahui_id) . " '><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a>";
                                    }
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Permintaan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->tglmenyetujui)) {
                                    return "Belum Disetujui";
                                }
                                $p = PengajuanbahanmknT::model()->findAllByAttributes(array(
                                    'renkebbahanmakanan_id' => $data->renkebbahanmakanan_id
                                ));
                                $pembelian = PengajuanbahanmknT::model()->findByAttributes(array(
                                    'renkebbahanmakanan_id' => $data->renkebbahanmakanan_id
                                ));
                                $renDet = RenkebbahanmakanandetT::model()->findAllByAttributes(array(
                                    'renkebbahanmakanan_id' => $data->renkebbahanmakanan_id
                                ));
                                $pegawaiPem = "";
                                $tglCreateTime = "";
                                if (isset($pembelian)) {
                                    $loginCreate = LoginpemakaiK::model()->findByPk($pembelian->create_loginpemakai_id);
                                    if (isset($loginCreate)) {
                                        $peg = PegawaiM::model()->findByPk($loginCreate->pegawai_id);
                                        if (isset($peg)) {
                                            $pegawaiPem = $peg->namaLengkap;
                                        }
                                    }
                                    $tglCreateTime = MyFormatter::formatDateTimeForUser($pembelian->create_time);
                                }
                                $jum = 0;
                                $jumRen = 0;
                                $getDetR = array();
                                $getTerima = array();
                                $ok = true;
                                $jumDt = array();
                                if (count((array)$renDet) > 0) {
                                    foreach ($renDet as $det) {
                                        $getDetR[] = array(
                                            'bahanmakanan_id' => $det->bahanmakanan_id,
                                            'stok' => $det->jmlpermintaandet * $data->ro_bahanmakanan_bulan,
                                        );
                                    }
                                }
                                if (count((array)$p) > 0) {
                                    foreach ($p as $brg) {
                                        if (!empty($brg->terimabahanmakan_id)) {
                                            $det = TerimabahandetailT::model()->findAll(" terimabahanmakan_id = '" . $brg->terimabahanmakan_id . "' AND returpenbahanmakandetail_id IS NULL ORDER BY bahanmakanan_id");
                                            foreach ($det as $dt) {
                                                if (isset($jumDt[$dt->bahanmakanan_id])) {
                                                    $jumDt[$dt->bahanmakanan_id] = $jumDt[$dt->bahanmakanan_id] + $dt->qty_terima;
                                                } else {
                                                    $jumDt[$dt->bahanmakanan_id]  = $dt->qty_terima;
                                                }
                                                $getTerima[$dt->bahanmakanan_id] = array(
                                                    'bahanmakanan_id' => $dt->bahanmakanan_id,
                                                    'stok' => $jumDt[$dt->bahanmakanan_id],
                                                );
                                            }
                                        }
                                    }
                                }
                                if (is_array($getDetR)) {
                                    if (is_array($getTerima)) {
                                        foreach ($getDetR as $cekR) {
                                            if (
                                                isset($getTerima[$cekR['bahanmakanan_id']]['bahanmakanan_id']) && !empty($getTerima[$cekR['bahanmakanan_id']]['bahanmakanan_id'])
                                                && $cekR['bahanmakanan_id'] == $getTerima[$cekR['bahanmakanan_id']]['bahanmakanan_id']
                                            ) {
                                                if ($cekR['stok'] > $getTerima[$cekR['bahanmakanan_id']]['stok']) {
                                                    $ok = $ok && false;
                                                } else {
                                                    $ok = $ok && true;
                                                }
                                            }
                                        }
                                    }
                                }
                                if (empty($getTerima)) {
                                    $ok = false;
                                }
                                if ($ok) return "SUDAH MELAKUKAN PEMBELIAN";
                                $linkpermintaan = CHtml::link(
                                    "<i class=\"icon-form-mintabeli\"></i>",
                                    $this->createUrl($this->controllerPembelian . '/index', array(
                                        'rencana_id' => $data->renkebbahanmakanan_id,
                                    ))
                                );
                                if (isset($pembelian)) {
                                    if (!empty($pembelian->batalpermintaanpembelian_id)) {
                                        $modBatalPembelian = BatalpermintaanpembelianT::model()->findByPk($pembelian->batalpermintaanpembelian_id);
                                        if (isset($modBatalPembelian)) {
                                            return "Telah Dibatalkan Oleh " . $modBatalPembelian->userotorisasi->namaLengkap . " dengan tanggal dan waktu " . MyFormatter::formatDateTimeForUser($modBatalPembelian->tglbatalpermintaan);
                                        }
                                    } else {
                                        return "Permintaan oleh " . $pegawaiPem . " dengan tanggal dan waktu " . $tglCreateTime;
                                    }
                                } else {
                                    return $linkpermintaan;
                                }
                                //                                                
                                //                                                return (isset($pembelian))?"Permintaan oleh ".$pegawaiPem." dengan tanggal dan waktu ".$tglCreateTime : CHtml::link("<i class=\"icon-form-mintabeli\"></i>", 
                                //                                                                $this->createUrl($this->controllerPembelian.'/index', array(
                                //                                                                        'rencana_id'=>$data->renkebbahanmakanan_id,
                                //                                                                )));
                            },
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->renkebbahanmakanan_id)",array("id"=>"$data->renkebbahanmakanan_id","rel"=>"tooltip","title"=>"Batalkan Rencana Kebutuhan Barang Umum"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id) . "/delete"; ?>';
        myConfirm('Yakin Akan Membatalkan Rencana Kebutuhan barang ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('rencana-m-grid');
                            } else {
                                myAlert('Rencana Kebutuhan Gagal di Dibatalkan')
                            }
                        }, "json");
                }
            });
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRencana',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Rencana Kebutuhan Bahan Makanan',
        'autoOpen' => false,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="rencana" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
                            data: $(this).serialize()
                    }); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>