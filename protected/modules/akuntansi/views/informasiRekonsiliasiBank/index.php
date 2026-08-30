<?php $linkHalaman = CustomFunction::getUrlByMenuID(1896); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Rekonsiliasi Bank',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rekonsiliasi Bank</b>
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
                $('#rekonsiliasibank-info-search').submit(function(){
                    $('#informasirekonsiliasibank-grid').addClass('animation-loading');
                        $.fn.yiiGridView.update('informasirekonsiliasibank-grid', {
                            data: $(this).serialize()
                        });
                    return false;
                });
                ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="box search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model, 'format' => $format
                    )); ?>
                </fieldset>
                <!--search-form-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekonsiliasi Bank</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasirekonsiliasibank-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Rekonsiliasi Bank',
                            'type' => 'raw',
                            'value' => '$data->rekonsiliasibank_no',
                        ),
                        array(
                            'header' => 'Tanggal Rekonsiliasi Bank',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->rekonsiliasibank_tgl)',
                        ),
                        array(
                            'header' => 'Bank',
                            'type' => 'raw',
                            'value' => '$data->namabank',
                        ),
                        array(
                            'header' => 'Jenis Rekonsiliasi Bank',
                            'type' => 'raw',
                            'value' => '$data->jenisrekonsiliasibank_nama',
                        ),
                        array(
                            'header' => 'Kode Rekening',
                            'type' => 'raw',
                            'value' => '$data->kdrekening5',
                        ),
                        array(
                            'name' => 'Nama Rekening',
                            'type' => 'raw',
                            'value' => '$data->nmrekening5',
                        ),
                        array(
                            'name' => 'Saldo Debit (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->saldodebit,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'Saldo Kredit (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->saldokredit,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
$urlPrint = $this->createUrl('print');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rekonsiliasibank-info-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>