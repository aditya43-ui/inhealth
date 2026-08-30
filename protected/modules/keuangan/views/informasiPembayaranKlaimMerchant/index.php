<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Klaim Merchant</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('#kupembklaimmerchant-t-search').submit(function(){
					$.fn.yiiGridView.update('kupembklaimmerchant-t-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Pembayaran Klaim Merchant</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                        'id' => 'kupembklaimmerchant-t-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'mergeColumns' => array(
                            'tglpembayaranklaim',
                            'namabank',
                        ),
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                            ),
                            array(
                                'header' => 'Tanggal Pembayaran Klaim',
                                'name' => 'tglpembayaranklaim',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaranklaim)',
                            ),
                            array(
                                'header' => 'Bank',
                                'name' => 'namabank',
                                'value' => '($data->namabank)?$data->namabank:"-"',
                            ),
                            array(
                                'name' => 'totalbayar',
                                'value' => 'number_format($data->totalbayar)',
                            ),
                            array(
                                'header' => 'Rincian Pembayaran',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranKlaimMerchant/detail",array("id"=>$data->pembayarklaim_id,"frame"=>true)),
											array("class"=>"", 
												"target"=>"detailPembayaran",
												"onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
												"rel"=>"tooltip",
												"title"=>"Klik untuk melihat detail Pembayaran Klaim Piutang",
											  ))',
                            ),
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align:center;'),
                                'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:deleteRecord($data->pembayarklaim_id)",array("id"=>"$data->pembayarklaim_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pembayaran Klaim Piutang"))',
                                'htmlOptions' => array('style' => 'text-align:center;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pembayaran Klaim Merchant',
        'autoOpen' => false,
        'width' => 900,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>

<script>
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo Yii::app()->controller->createUrl("InformasiPembayaranKlaimMerchant/batalPembayaran"); ?>';
        myConfirm("Yakin Akan Membatalkan Pembayaran?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('kupembklaimmerchant-t-grid');
                        } else {
                            myAlert('Data gagal dihapus!');
                        }
                    }, "json");
            }
        });
    }
</script>