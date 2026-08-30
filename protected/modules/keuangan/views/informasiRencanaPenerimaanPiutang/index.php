<div class="white-container">
    <legend class="rim2">Informasi <b>Rencana Penerimaan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'infoRencanaPenerimaan Ts'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('#infoRencanaPenerimaan-search-form').toggle();
            return false;
    });
    $('#infoRencanaPenerimaan-search-form').submit(function(){
            $.fn.yiiGridView.update('infoRencanaPenerimaan-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Penerimaan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'infoRencanaPenerimaan-t-grid',
            'dataProvider'=>$modKlaimDetail->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Tanggal Pengajuan Klaim',
                        'name'=>'tglpengajuanklaimanklaim',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->pengajuanklaimpiutang->tglpengajuanklaimanklaim)',
                    ),
                    array(
                        'header'=>'No. Pengajuan Klaim',
                        'name'=>'nopengajuanklaimanklaim',
                        'value'=>'$data->pengajuanklaimpiutang->nopengajuanklaimanklaim',
                    ),
                     array(
                        'header'=>'Jumlah Piutang',
                                            'name'=> 'jmlpiutang',
                        'value'=>'$data->jmlpiutang',
                    ),
                     array(
                        'header'=>'Jumlah Bayar',
                                            'name'=> 'jumlahbayar',
                        'value'=>'$data->jumlahbayar',
                    ),
                     array(
                        'header'=>'Jumlah Sisa Piutang',
                                            'name'=> 'jmlsisapiutang',
                        'value'=>'$data->jmlsisapiutang',
                    ),
                    array(
                        'header'=>'Tanggal Jatuh Tempo',
                        'name'=>'tgljatuhtempo',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->pengajuanklaimpiutang->tgljatuhtempo)',
                    ),
                    array(
                        'header'=>'No. Pembayaran',
                        'name'=>'nopembayaran',
                        'value'=>'$data->pembayaranpelayanan->nopembayaran',
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array(
                'modKlaimPiutang'=>$modKlaimPiutang,	
                'modKlaimDetail'=>$modKlaimDetail,
        )); ?>
    </fieldset>
</div>