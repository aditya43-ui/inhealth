<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembayaran Klaim Piutang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('#aspembklaimpiutang-t-search').submit(function(){
                    $.fn.yiiGridView.update('aspembklaimpiutang-t-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Klaim Piutang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'aspembklaimpiutang-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        array(
                            'name' => 'tglpembayaranklaim',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaranklaim)',
                        ),
                        array(
                            'name' => 'nopembayaranklaim',
                            'value' => '$data->nopembayaranklaim',
                        ),
                        array(
                            'name' => 'totalbayar',
                            'value' => 'number_format($data->totalbayar)',
                        ),
                        array(
                            'header' => 'Detail Pembayaran',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranKlaimPiutang/detail",array("id"=>$data->pembayarklaim_id,"frame"=>true)),
                                             array("class"=>"", 
                                                   "target"=>"detailPembayaran",
                                                   "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                                   "rel"=>"tooltip",
                                                   "title"=>"Klik untuk melihat detail Pembayaran Klaim Piutang",
                                         ))',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => 'Klik untuk membatalkan Pembayaran Klaim Piutang'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPembayaran",array("id"=>$data->pembayarklaim_id))',
                                    'click' => 'function(){deleteRecords(this);return false;}',
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
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
        'title' => 'Detail Pembayaran Klaim Piutang',
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
<?php
// ===========================Dialog Pembatalan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPembatalan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pembatalan Pembayaran Gaji',
        'autoOpen' => false,
        'width' => 550,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="batalPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pembatalan================================
?>
<script>
    function deleteRecords(obj) {
        myConfirm("Yakin Akan Membatalkan Pembayaran Klaim Piutang ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            if (data.sukses > 0) {
                                $.fn.yiiGridView.update('aspembklaimpiutang-t-grid');
                                myAlert(data.pesan);
                            } else {
                                myAlert(data.pesan);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>