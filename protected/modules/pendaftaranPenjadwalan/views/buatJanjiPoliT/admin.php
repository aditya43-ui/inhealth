<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppbuat-janji-poli-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Janji Poliklinik',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Janji <?php echo $this->title; ?></b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Janji <?php echo $this->title; ?></b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppbuat-janji-poli-t-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglbuatjanji',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglbuatjanji)',
                        ),
                        array(
                            'name' => 'tgljadwal',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgljadwal)',
                        ),
                        array(
                            'header' => 'No. Antrian',
                            'name' => 'no_antrianjanji',
                            'type' => 'raw',
                            'value' => 'isset($data->no_antrianjanji) ? ($data->ruangan->ruangan_singkatan."-".$data->no_antrianjanji) : ""',
                        ),
                        array(
                            'header' => 'No. Buat Janji',
                            'name' => 'no_buatjanji',
                            'type' => 'raw',
                            'value' => 'isset($data->no_buatjanji) ? $data->no_buatjanji : ""',
                        ),
                        array(
                            'name' => 'pegawai_id',
                            'value' => '(isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "-")',
                        ),
                        array(
                            'name' => 'ruangan_id',
                            'value' => '(isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-")',
                        ),
                        array(
                            'header' => 'No. Rekam <br> Medik',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '(isset($data->pasien_id) ? $data->pasien->no_rekam_medik : "-") ',
                            'htmlOptions' => array('style' => 'text-align: left')
                        ),
                        array(
                            'name' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->getNamaAlias($data->pasien->nama_pasien,$data->pasien->nama_bin)',
                        ),
                        array(
                            'header' => 'No. Telp.',
                            'type' => 'raw',
                            'value' => 'isset($data->pasien->no_mobile_pasien) ? $data->pasien->no_mobile_pasien : ""',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'type' => 'raw',
                            'value' => '(isset($data->penjamin_id) ? $data->penjamin->carabayar->carabayar_nama."/<br>".$data->penjamin->penjamin_nama : "-") ',
                        ),
                       
                        'harijadwal',
                        array(
                            'name' => 'Checkin',
                            'type' => 'raw',
                            'value' => function($data){
                                if($data->is_checkin == 0){
                                    return "Belum";
                                }else{
                                    return "Sudah";
                                }
                            },
                        ),
                        array(
                            'name' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keteranganbuatjanji'
                        ),
                        array(
                            'name' => 'Waktu Checkin',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->waktucheckin)',
                        ),
                        array(
                            'header' => 'Daftar Ke <br> Poliklinik',
                            'type' => 'raw',
                            'value' => '(empty($data->pendaftaran_id) ?((date($data->tgljadwal) < date("Y-m-d"))?"Sudah Melewati Jadwal": CHtml::link("<i class=icon-form-poliklinik></i>", "javascript:daftarKeRJ(\'$data->pasien_id\',\'$data->buatjanjipoli_id\');",array("id"=>"$data->pasien_id","rel"=>"tooltip","title"=>"Klik untuk Mendaftarkan ke Rawat Jalan"))): "Sudah Terdaftar") ',
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("BuatJanjiPoliT/view",array("id"=>$data->buatjanjipoli_id,"frame"=>1)),
                                                    array("class"=>"", 
                                                              "target"=>"iframeDetail",
                                                              "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                                              "rel"=>"tooltip",
                                                              "title"=>"Klik untuk lihat detail ",
                                                    ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        //		array(
                        //			'header'=>Yii::t('zii','View'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //			'template'=>'{view}',
                        //			'buttons'=>array(
                        //				'view' => array (
                        //					'options'=>array('rel'=>'tooltip','title'=>'Lihat pasien janji poli')
                        //				)
                        //			)
                        //		),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah pasien janji poli')
                                    // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->buatjanjipoli_id)",array("id"=>"$data->buatjanjipoli_id","rel"=>"tooltip","title"=>"Batalkan Janji Poliklinik Pasien"))',
                            'htmlOptions' => array('style' => 'text-align: left; width:40px; max-width:80px;'),
                        ),
                        //		array(
                        //			'header'=>Yii::t('zii','Batal'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //			'template'=>'{delete}',
                        //			'buttons'=>array(
                        //				'delete'=> array(
                        //					'options'=>array('rel'=>'tooltip','title'=>'Hapus pasien janji poli')
                        //									// 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        //				),
                        //			)
                        //		),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$urlPendaftaranRJ = Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan');
$urlDelete =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppbuat-janji-poli-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function daftarKeRJ(pasien_id,buatjanjipoli_id,ruangan_id,pegawai_id)
{
    $('#buatjanjipoli_id').val(buatjanjipoli_id);
    $('#pasien_id').val(pasien_id);
    $('#ruangan_id').val(ruangan_id);
    $('#pegawai_id').val(pegawai_id);
    $('#form_hidden').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form_hidden',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'action' => $urlPendaftaranRJ,
    // 'htmlOptions'=>array('target'=>'_new'), dicomment karena RND-7612
)); ?>
<?php echo CHtml::hiddenField('buatjanjipoli_id', '', array('readonly' => true)); ?>
<?php $this->endWidget(); ?>
<?php
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Buat Janji Poliklinik',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="300"></iframe>
<?php
$this->endWidget();
//========= end Copy Resep dialog =============================
?>
<script type="text/javascript">
    //di comment karena RND-7612	
    //setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
    //    function(){
    //        $.fn.yiiGridView.update('ppbuat-janji-poli-t-grid', {   // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
    //            data: $('#ppbuat-janji-poli-t-search').serialize()
    //        });
    //        return false;
    //    }, 
    // 5000  // fungsi di eksekusi setiap 5 detik sekali
    //);
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $urlDelete . "/delete"; ?>';
        myConfirm("Anda yakin akan membatalkan janji poliklinik ini?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            myAlert(data.pesan);
                            $.fn.yiiGridView.update('ppbuat-janji-poli-t-grid');
                        } else {
                            myAlert('Data janji poli tidak bisa dibatalkan karena pasien sudah didaftarkan!')
                        }
                    }, "json");
            }
        });
    }
</script>