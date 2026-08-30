<?php
$this->breadcrumbs = array(
    'Informasi Pesangon Pegawai' => array('informasi'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gjpesangonpeg-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pesangon Pegawai <span id="jenisasal"></span></b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pesangon Pegawai </b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gjpesangonpeg-t-grid',
                    'dataProvider' => $model->search(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Periode',
                            'name' => 'periodegaji',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->periodegaji))
                                    return MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->periodegaji)));
                                return MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->tglpesangon)));
                            },
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Tgl. Pengajuan/<br>No. Pengajuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                //                                            return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($data->tglpesangon) . '/<br>' . $data->nopesangon . '</u>', Yii::app()->createUrl("kepegawaian/pesangonpegT/detailPenggajian", array("id" => $data->pesangonpeg_id)), array("rel" => "tooltip", "title" => "Klik untuk Detail Pesangon"));
                                return MyFormatter::formatDateTimeForUser($data->tglpesangon) . '/<br>' . $data->nopesangon;
                            } //'MyFormatter::formatDateTimeForUser($data->tglpesangon)',
                        ),
                        array(
                            'header' => 'Kelompok Pegawai',
                            'value' => '(isset($data->pegawai->kelompokpegawai->kelompokpegawai_nama) ? $data->pegawai->kelompokpegawai->kelompokpegawai_nama : "-")',
                        ),
                        array(
                            'header' => 'Jabatan',
                            'value' => '(isset($data->pegawai->jabatan->jabatan_nama) ? $data->pegawai->jabatan->jabatan_nama : "-")',
                        ),
                        array(
                            'header' => 'NIP',
                            'name' => 'nomorindukpegawai',
                            'value' => '$data->pegawai->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->pegawai->nama_pegawai',
                        ),
                        array(
                            'header' => 'Kategori Pegawai Asal',
                            //										'name'=>'kategoripegawaiasal',
                            'value' => '$data->pegawai->kategoripegawaiasal',
                        ),
                        array(
                            'header' => 'Pegawai RS Mengetahui',
                            'type' => 'raw',
                            //                                        'value'=>'$data->mengetahui'
                            'value' => '(isset($data->mengetahui)? $data->mengetahui : "-").
                                                (isset($data->tgl_mengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahui) : 
                                                (CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui", array("pesangonpeg_id"=>$data->pesangonpeg_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                               )',
                        ),
                        array(
                            'header' => 'Pegawai PT Mengetahui',
                            'type' => 'raw',
                            //                                        'value'=>'$data->mengetahuipt'
                            'value' => '(isset($data->mengetahuipt)? $data->mengetahuipt : "-").
                                                (isset($data->tgl_mengetahuipt) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahuipt) : 
                                                (!isset($data->tgl_mengetahui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahuiPT", array("pesangonpeg_id"=>$data->pesangonpeg_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                                )',
                        ),
                        array(
                            'header' => 'Pegawai Menyetujui',
                            'type' => 'raw',
                            //                                        'value'=>'$data->menyetujui'
                            'value' => '(isset($data->menyetujui)? $data->menyetujui : "-").
                                                (isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) :
                                                (isset($data->tgl_mengetahuipt) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui", array("pesangonpeg_id"=>$data->pesangonpeg_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : "")
                                                )',
                        ),
                        //  array(
                        //     'header'=>'No. Rekening',
                        //     'value'=>'$data->pegawai->norekening',
                        // ),
                        'keterangan',
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalpesangonpeg($data->pesangonpeg_id)", array("id" => "$data->pesangonpeg_id", "rel" => "tooltip", "title" => "Klik untuk membatalkan pesangon pegawai", "data-placement" => "left"));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        )
                        //                                    array(
                        //                                        'header' => 'Status',
                        //                                        'type' => 'raw',
                        //                                        'value' => function($data) {
                        //                                            $col = 'red';
                        //                                            $txt = 'BELUM DIBAYAR';
                        //
                        //                                            if (!empty($data->pengeluaranumum_id)) {
                        //                                                $col = 'green';
                        //                                                $txt = 'SUDAH DIBAYAR';
                        //                                            }
                        //
                        //                                            return CHtml::button($txt, array('class' => 'btn btn-' . $col, 'style' => 'width:150px;'));
                        //                                        },
                        //                                        'htmlOptions' => array(
                        //                                            'style' => 'text-align: center;',
                        //                                        )
                        //                                    ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--Dialog untuk mengetahui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpesangonpeg-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpesangonpeg-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<script>
    function batalpesangonpeg(pesangonpeg_id) {
        myConfirm("Anda yakin akan membatalkan pesangon pegawai ini?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPesangonPeg'); ?>',
                    data: {
                        pesangonpeg_id: pesangonpeg_id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        if (data.status == true) {
                            myAlert(data.pesan);
                            $.fn.yiiGridView.update('gjpesangonpeg-t-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            myAlert(data.pesan);
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