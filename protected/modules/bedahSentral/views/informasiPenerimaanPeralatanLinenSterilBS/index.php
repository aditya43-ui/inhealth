<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Peralatan Steril</b>
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
            'Informasi Penerimaan Peralatan Steril'
        );
        Yii::app()->clientScript->registerScript('search', "
$('#penerimaanperalatanlinen-info-search').submit(function(){
$('#informasipenerimaanperalatanlinen-grid').addClass('animation-loading');
$.fn.yiiGridView.update('informasipenerimaanperalatanlinen-grid', {
data: $(this).serialize()
});
return false;
});
"); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Peralatan Steril</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipenerimaanperalatanlinen-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right; width:30px;'),
                        ),
                        array(
                            'header' => 'No. Pengiriman',
                            'type' => 'raw',
                            'value' => '$data->kirimperlinensteril_no',
                        ),
                        array(
                            'header' => 'Tanggal Pengiriman',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->kirimperlinensteril_tgl)',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->kirimperlinensteril_ket',
                        ),
                        //				array(
                        //					'header'=>'Lihat Detail',
                        //					'type'=>'raw',
                        //					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPenerimaanPeralatanLinenSteril/detail",array("terimaperlinensteril_id"=>$data->terimaperlinensteril_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Sterilisasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        //				),
                        array(
                            'header' => 'Terima Peralatan Steril',
                            'type' => 'raw',
                            'value' => '$data->cekPenSterilRuangan($data->kirimperlinensteril_id)',
                            'htmlOptions' => array('style' => 'text-align: center; width:100px')
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPengiriman",array("id"=>$data->kirimperlinensteril_id))',
                                    'click' => 'function(){batalPengiriman(this);return false;}',
                                    //								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<script type="text/javascript">
    function batalPengiriman(obj) {
        myConfirm("Anda yakin akan membatalkan data ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('informasipenerimaanperalatanlinen-grid');
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