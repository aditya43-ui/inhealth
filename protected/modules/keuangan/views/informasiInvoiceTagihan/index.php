<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Invoice Tagihan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Invoice Tagihan',
        );
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#kuinvoicetagihan-t-search').submit(function(){
            $.fn.yiiGridView.update('kuinvoicetagihan-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Invoice Tagihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kuinvoicetagihan-t-grid',
                    'dataProvider' => $model->searchInvoice(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        array(
                            'name' => 'invoicetagihan_no',
                            'value' => '$data->invoicetagihan_no',
                        ),
                        array(
                            'header' => 'Tanggal Tagihan Invoice',
                            'name' => 'invoicetagihan_tgl',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->invoicetagihan_tgl)',
                        ),
                        array(
                            'header' => 'Dari',
                            'name' => 'namapenagih',
                            'value' => '$data->namapenagih',
                        ),
                        array(
                            'header' => 'Perihal',
                            'value' => '$data->perihal_tagihan',
                        ),
                        array(
                            'header' => 'Rekanan',
                            'value' => '$data->rekanan_tagihan',
                        ),
                        array(
                            'header' => 'Total Tagihan',
                            'name' => 'total_tagihan',
                            'value' => 'number_format($data->total_tagihan)',
                        ),
                        array(
                            'header' => 'Tanggal Verifikasi',
                            'name' => 'tgl_verfikasi_tagihan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_verfikasi_tagihan)',
                        ),
                        array(
                            'header' => 'Nama Verifikator',
                            'name' => 'verifikator_nama',
                            'value' => '$data->verifikator_nama',
                        ),
                        array(
                            'header' => 'Status Verifikasi',
                            'name' => 'status_verifikasi',
                            'type' => 'raw',
                            'value' => '$data->status_verifikasi == 1 ? "Sudah Verifikasi" : CHtml::link("Belum Verifikasi <icon class=\'icon-form-ubah\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Status", array("invoicetagihan_id"=>$data->invoicetagihan_id,"frame"=>true)), array("target"=>"frameStatus","rel"=>"tooltip", "title"=>"Klik untuk ubah verifikasi", "onclick"=>"$(\'#dialogStatus\').dialog(\'open\');"))'
                            //'value'=>'$data->status_verifikasi == 1 ? "Sudah Verifikasi" : CHtml::link("<i class=icon-form-ubah></i>". $data->invoicetagihan_id," ",array("onclick"=>"ubahStatusverifikasi(\'$data->invoicetagihan_id\');$(\'#editKelasPelayanan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk ubah verifikasi"))',
                        ),
                        array(
                            'header' => 'Detail',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/Detail",array("id"=>$data->invoicetagihan_id,"frame"=>true)),
						array("class"=>"", 
							  "target"=>"detailDetail",
							  "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
							  "rel"=>"tooltip",
							  "title"=>"Klik untuk melihat detail",
					))',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => '$data->status_verifikasi == 1 ? "" : Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalInvoice",array("id"=>$data->invoicetagihan_id))',
                                    'click' => 'function(){batalInvoice(this);return false;}',
                                ),
                            ),
                        ),
                        //			array(
                        //				'header'=>'Pengeluaran',
                        //				'type'=>'raw',
                        //				'value'=>'($data->status_verifikasi == 1) ? CHtml::Link("<i class=\"icon-pengeluarankas\"></i>",Yii::app()->controller->createUrl("'.$this->createUrl('PengeluaranUmum/Index').'",array("invoicetagihan_id"=>$data->invoicetagihan_id,"frame"=>true)),
                        //					array("class"=>"", 
                        //						"target"=>"pengeluaranKas",
                        //						"onclick"=>"$(\"#dialogPengeluaran\").dialog(\"open\");",
                        //						"rel"=>"tooltip",
                        //						"title"=>"Klik untuk melakukan pengeluaran kas / umum",
                        //				)) : CHtml::Link("<i class=\"icon-pengeluarankas\"></i>","#",
                        //					array("class"=>"", 
                        //						"style"=>"opacity: 0.3",
                        //						"rel"=>"tooltip",
                        //				))',
                        //				'htmlOptions'=>array('style'=>'text-align:center'),
                        //			),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog statu=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogStatus',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Status Verifikasi',
        'autoOpen' => false,
        'width' => 400,
        'height' => 300,
        'resizable' => false,
        //						'show'=>'blind',
        //						'hide'=>'blind',
        'close' => "js:function(){ $.fn.yiiGridView.update('kuinvoicetagihan-t-grid', {
								data: $(this).serialize()
							}); }",
    ),
));
?>
<iframe src="" name="frameStatus" width="400" height="250"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir status================================
?>
<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Invoice Tagihan',
        'autoOpen' => false,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('kuinvoicetagihan-t-grid', {
							data: $(this).serialize()
						}); }",
    ),
));
?>
<iframe src="" name="detailDetail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>
<?php
// ===========================Dialog Pengeluaran Kas=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPengeluaran',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pengeluaran Kas',
        'autoOpen' => false,
        'width' => 900,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('kuinvoicetagihan-t-grid', {
			data: $(this).serialize()
		}); }",
    ),
));
?>
<iframe src="" name="pengeluaranKas" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pengeluaran Kas================================
?>
<script type="text/javascript">
    function batalInvoice(obj) {
        myConfirm("Anda yakin akan membatalkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('kuinvoicetagihan-t-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dibatalkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dibatalkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>