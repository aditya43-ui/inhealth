<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tabelverifikasi-search',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'GET',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('tabelVerifikasi', "
$('#tabelverifikasi-search').submit(function(){
	$.fn.yiiGridView.update('pencarianbatalverifikasi-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$format = new MyFormatter();
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Order Batal Verifikasi Tagihan</b>
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
                <?php echo $this->renderPartial($this->path_view."_searchInformasiBatal", array(
                    'model'=>$model, 'form'=>$form
                ), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Order Batal Verifikasi Tagihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianbatalverifikasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{pager}{summary}\n{items}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header'=>'Tgl. Pendaftaran /<br/>No. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
                        ),
                        array(
                            'header'=>'Nama Pasien / No. Rekam Medik / Umur / Alamat',
                            'type'=>'raw',
                            'value'=>function($data) {
                                $str = "<strong>".$data->nama_pasien."</strong><br/>";
                                $str .= $data->no_rekam_medik."<br/>";
                                $str .= $data->umur." Tahun<br/>";
                                $str .= $data->alamat_pasien;

                                return $str;
                            }
                        ),
                        array(
                            'header'=>'Dokter/<br/>Ruangan',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return ($data->dpjp_nama ?? "-")."<br/>".$data->ruangan_nama;
                            }
                        ),
                        array(
                            'header'=>'Jenis Penjamin/<br/>Penjamin',
                            'type'=>'raw',
                            'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                        ),
                        array(
                            'header'=>'Detail',
                            'type' => 'raw',
                            'value' => function ($data) use ($format) {
                                echo CHtml::link("<icon class='icon-form-verifikasi'></icon>",
                                    Yii::app()->controller->createUrl('detail', array('pendaftaran_id' => $data->pendaftaran_id)),
                                    array(
                                        'target' => 'iframeDetail',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Pembayaran Tagihan',
                                        'onclick' => '$("#dialogDetail").dialog("open");'
                                    )
                                );
                            }
                        ),
                        array(
                            'header'=>'Petugas',
                            'name'=>'pegawaibatal_nama'
                        ),
                        array(
                            'header'=>'Aksi',
                            'type' => 'raw',
                            'value' => function ($data) use ($format) {
                                $verif = TindakanpelayananT::model()->find("isverifbataltindakan = true and pendaftaran_id = $data->pendaftaran_id");

                                if(!empty($verif)) {
                                        echo CHtml::link("<icon class='icon-form-check'></icon>",
                                        "javascript::void(0)", array('onclick' => "ubahVerif($data->pendaftaran_id)")
                                    );
                                    // echo 'is not null';
                                } else {
                                    echo CHtml::link(
                                        Yii::t('mds', '{icon}SUDAH<br>BATAL VERIFIKASI', array('{icon}' => '')),
                                        "javascript::void(0)", array('title' => '', 'class' => 'btn btn-warning', 'onclick' => "ubahVerif($data->pendaftaran_id)")
                                    );
                                    // echo 'is null';

                                }
                                
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Pembayaran Kasir',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1124,
        'height' => 510,
        'resizable' => true,
    ),
));
?>
<iframe src="" id="iframeDetail" name="iframeDetail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<script>

    /**
 * Mengubah verifikasi rencana tindakan dari database
 */
function ubahVerif(pendaftaran_id){

            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('ubahVerifikasi'); ?>',
                data: {pendaftaran_id:pendaftaran_id},
                dataType: "json",
                success:function(data){
                    $.fn.yiiGridView.update('pencarianbatalverifikasi-grid', {
                                data: $('#tabelverifikasi-search').serialize()
                            });
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log(errorThrown);
                }
            });
}

</script>