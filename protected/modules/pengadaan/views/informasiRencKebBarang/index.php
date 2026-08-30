<?php
    $this->breadcrumbs=array(
        'Informasi Rencana Kebutuhan Barang Umum',
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
<div class="row">
    <div class="col-md-12">
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
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Kebutuhan Barang Umum</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Rencana Kebutuhan Barang Umum</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                                'id'=>'rencana-m-grid',
                                'dataProvider'=>$model->searchInformasi(),
                                'template'=>"{summary}\n{items}\n{pager}",
                                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                                // 'replaceUrl'=>true,
                                'columns'=>array(
                                    array(
                                        'name'=>'renkebbarang_tgl',
                                        'type'=>'raw',
                                        'value'=>'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                                    ),
                                    'renkebbarang_no',
                                    array(
                                        'header' => 'Waktu Pemakaian Barang',
                                        'value' => '$data->ro_barang_bulan',
                                        'htmlOptions' => array('style'=>'text-align:right;')
                                    ),
                                    array(
                                        'header' => 'Sumber Dana',
                                        'type'=>'raw',
                                        'value' => '$data->sumberdana_nama',
                                    ),
                                    array(
                                        'header'=>'Pegawai Menyetujui',
                                        'type'=>'raw',
//                                        'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
                                        'value' => function($data){
                                            $dataDialog = 'myAlert("Hanya '.(isset($data->pegmenyetujui_id)? $data->pegawaimengetahui($data->pegmenyetujui_id) : "-").' yang bisa mengakses");';
                                           if($data->pegmenyetujui_id==Yii::app()->user->getState('pegawai_id')){
                                               $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                           }
                                                $html = (isset($data->pegmenyetujui_id)? $data->pegawaimengetahui($data->pegmenyetujui_id) : "-").(isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : (!isset($data->pegmenyetujui_id)? "" : (!isset($data->pegmenyetujui_id) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApproveMenyetujui', array("renkebbarang_id"=>$data->renkebbarang_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Menyetujui", "onclick"=>$dataDialog)))));
                                                return $html;
                                        }
                                    ),

                                    array(
                                        'header'=>'Rincian',
                                        'type'=>'raw',
                                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Rincian", array("renkebbarang_id"=>$data->renkebbarang_id)),
                                                                 array("class"=>"",
                                                                           "target"=>"rencana",
                                                                           "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
                                                                           "rel"=>"tooltip",
                                                                           "title"=>"Klik untuk melihat details Rencana",
                                                                 ))',
                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                                            array(
                                        'header'=>'Ubah Rencana',
                                        'type'=>'raw',
                                        'value' => function($data){
                                            if(isset($data->tglmenyetujui)){
                                                return "<a rel='tooltip' title='Tidak dapat diubah karena sudah disetujui oleh pegawai menyetujui'><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a> ";
                                            }else{
                                                if($data->pegmengetahui_id == Yii::app()->user->getState('pegawai_id')){
                                                   return CHtml::link("<icon class='icon-form-ubah'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.$this->path_rencana.'/index', array("renkebbarang_id"=>$data->renkebbarang_id,"ubah"=>true)), array("target"=>"BLANK","rel"=>"tooltip", "title"=>"Klik untuk mengubah rencana"));
                                                }else{
                                                  return "<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh ".$data->pegawaimengetahui($data->pegmengetahui_id)." '><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a>";
                                                }
                                            }

                                        },
                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                                    array(
                                        'header' => 'Pembelian',
                                        'type' => 'raw',
                                        'value' => function ($data) {
                                            $p = PembelianbarangT::model()->findAllByAttributes(array(
                                                'renkebbarang_id' => $data->renkebbarang_id
                                            ));
                                            $pembelian = PembelianbarangT::model()->findByAttributes(array(
                                                'renkebbarang_id' => $data->renkebbarang_id
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
                                            $renDet = RenkebbarangdetT::model()->findAllByAttributes(array(
                                                'renkebbarang_id' => $data->renkebbarang_id
                                            ));
                                            $jum = 0;
                                            $jumRen = 0;
                                            $getDetR = array();
                                            $getTerima = array();
                                            $ok = true;
                                            if (count((array)$renDet) > 0) {
                                                foreach ($renDet as $det) {
                                                    $getDetR[] = array(
                                                        'barang_id' => $det->barang_id,
                                                        'stok' => $det->jmlpermintaanbarangdet * $data->ro_barang_bulan,
                                                    );
                                                }
                                            }
                                            if (count((array)$p) > 0) {
                                                foreach ($p as $brg) {
                                                    if (!empty($brg->terimapersediaan_id)) {
                                                        $det = TerimapersdetailT::model()->findAll(" terimapersediaan_id = '" . $brg->terimapersediaan_id . "' AND retpendetail_id IS NULL ORDER BY barang_id");
                                                        foreach ($det as $dt) {
                                                            if (isset($jumDt[$dt->barang_id])) {
                                                                $jumDt[$dt->barang_id] = $jumDt[$dt->barang_id] + $dt->jmlterima;
                                                            } else {
                                                                $jumDt[$dt->barang_id]  = $dt->jmlterima;
                                                            }
                                                            $getTerima[$dt->barang_id] = array(
                                                                'barang_id' => $dt->barang_id,
                                                                'stok' => $jumDt[$dt->barang_id],
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                            if (is_array($getDetR) && count((array)$getDetR) > 0) {
                                                if (is_array($getTerima) && count((array)$getTerima) > 0) {
                                                    foreach ($getDetR as $cekR) {
                                                        if (
                                                            isset($getTerima[$cekR['barang_id']]) &&
                                                            !empty($getTerima[$cekR['barang_id']]) &&
                                                            $cekR['barang_id'] == $getTerima[$cekR['barang_id']]['barang_id']
                                                        ) {
                                                            if ($cekR['stok'] > $getTerima[$cekR['barang_id']]['stok']) {
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
                                            $linkpermintaan = CHtml::link(
                                                "<i class=\"icon-form-mintabeli\"></i>",
                                                $this->createUrl($this->controllerPembelian . '/index', array(
                                                    'rencana_id' => $data->renkebbarang_id,
                                                ))
                                            );
                                            if ($ok) return "SUDAH MELAKUKAN PEMBELIAN";
                                            if (!empty($pembelian->renkebbarang_id)) {
                                                if (!empty($pembelian->batalpermintaanpembelian_id)) {
                                                    $modBatalPembelian = BatalpermintaanpembelianT::model()->findByPk($pembelian->batalpermintaanpembelian_id);
                                                    if (isset($modBatalPembelian)) {
                                                        return "Telah Dibatalkan Oleh " . $modBatalPembelian->userotorisasi->namaLengkap . " dengan tanggal dan waktu " . MyFormatter::formatDateTimeForUser($modBatalPembelian->tglbatalpermintaan);
                                                    }
                                                } else {
                                                    return "Permintaan oleh " . $pegawaiPem . " dengan tanggal dan waktu " . $tglCreateTime;
                                                }
                                            } else {
                                                return (isset($data->tglmenyetujui) ? $linkpermintaan : "Belum Disetujui");
                                            }
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center;'),
                                    ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => '(!empty($data->tglmenyetujui)?"":CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->renkebbarang_id)",array("id"=>"$data->renkebbarang_id","rel"=>"tooltip","title"=>"Batalkan Rencana Kebutuhan Barang Umum")))',
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
     function deleteRecord(id){
        var id = id;
        var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id)."/delete"; ?>';
        myConfirm('Yakin Akan Membatalkan Rencana Kebutuhan barang ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rencana-m-grid');
                            }else{
                                myAlert('Rencana Kebutuhan Gagal di Dibatalkan')
                            }
                },"json");
            }
        });

    }

</script>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogRencana',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Detail Rencana Kebutuhan Barang Umum',
                'autoOpen'=>false,
                'width'=>800,
                'height'=>500,
                'resizable'=>false,
                'scroll'=>false
                 ),
        ));
        ?>
        <iframe src="" name="rencana" width="100%" height="100%">
        </iframe>
        <?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Pegawai Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
            'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
                            data: $(this).serialize()
                    }); }",
        ),
));
?>
<iframe name='frameMenyetujui' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
