<?php $linkHalaman = CustomFunction::getUrlByMenuID(460); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penerimaan Bahan Makanan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Bahan Makanan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
            });
            $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gzterimabahanmakan-grid', {
                    data: $(this).serialize()
                });
                return false;
            });
		");
        ?>
        <?php $this->renderPartial('_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'gzterimabahanmakan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Penerimaan / No. Penerimaan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglterimabahan)." / ".$data->nopenerimaanbahan',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Tgl. Permintaan / No. Permintaan',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuanbahanmkn->tglpengajuanbahan)." / ".$data->pengajuanbahanmkn->nopengajuan',
                        ),
                        array(
                            'header' => 'Sumber Dana',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => '$data->sumberdanabhn',
                        ),
                        array(
                            'header' => 'No. Surat Jalan',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => '$data->nosuratjalan'
                        ),
                        array(
                            'header' => 'Tanggal Surat Jalan',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                            'value' => '(!empty($data->tglsurjalan)? MyFormatter::formatDateTimeForUser($data->tglsurjalan) : "")'
                        ),
                        //							array(
                        //								'header'=>'No.',
                        //								'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        //								'value'=>'$data->nofaktur'
                        //							),
                        //							array(
                        //								'header'=>'Tanggal',
                        //								'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        //								'value'=>'$data->tglfaktur'
                        //							),
                        //							array(
                        //								'name'=>'totaldiscount',
                        //								'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        //								'value'=>'((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($data->totaldiscount,2,",","."):"Hidden")',
                        //								'htmlOptions'=>array(
                        //									'style'=>'text-align: right',
                        //								),
                        //							),
                        //							array(
                        //								'name'=>'totalharganetto',
                        //								'value'=>'((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($data->totalharganetto,2,",","."):"Hidden")',
                        //								'htmlOptions'=>array(
                        //									'style'=>'text-align: right',
                        //								),
                        //								'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                        //							),
                        //							array(
                        //								'name'=>'biayapengiriman',
                        //								'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayapengiriman)',
                        //								'htmlOptions'=>array(
                        //									'style'=>'text-align: right',
                        //								)
                        //							),
                        //							array(
                        //								'name'=>'biayatransportasi',
                        //								'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->biayatransportasi)',
                        //								'htmlOptions'=>array(
                        //									'style'=>'text-align: right',
                        //								)
                        //							),
                        //							array(
                        ////								'name'=>'biayapajak',
                        //                                                            'header'=>'Total PPN',
                        //                                                            'type'=>'raw',
                        //								'value'=>'((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($data->biayapajak,2,",","."):"Hidden")',
                        //								'htmlOptions'=>array(
                        //									'style'=>'text-align: right',
                        //								)
                        //							),
                        array(
                            'name' => 'keterangan_terima_bahan',
                            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/Terimabahanmakan/detailPenerimaan",array("id"=>$data->terimabahanmakan_id,"frame"=>true)),array("id"=>"$data->terimabahanmakan_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penerimaan Bahan Makanan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')", "data-placement"=>"left"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Retur Penerimaan',
                            'type' => 'raw',
                            'value' => '(empty($data->nofaktur) ? "Belum Difaktur":((empty($data->returpenbahanmakan_id)) ? CHtml::link("<i class=\'icon-form-retur\'></i> ",  Yii::app()->controller->createUrl("/gizi/Returpenerimaan/index",array("id"=>$data->terimabahanmakan_id)),array( "rel"=>"tooltip","title"=>"Klik untuk Retur Penerimaan Persediaan Bahan Makanan", )) : "Telah Diretur"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <!--search-form-->
    </div>
</div>
<?php
$js = <<< JSCRIPT
function openDialog(id){
    $('#dialogDetail').dialog('open');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('head', $js, CClientScript::POS_HEAD);
?>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>