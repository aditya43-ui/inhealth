<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
echo $this->renderPartial('__formSearch', array('model' => $model));

Yii::app()->clientScript->registerScript('search_jurnal', "
$('#search-jurnal-umum').submit(function(){
    $.fn.yiiGridView.update('AK-grid-jurnal-umum', {
            data: $(this).serialize()
    });
    return false;
});

$('#btn_reset').click(function()
{
    setTimeout(function(){
        $.fn.yiiGridView.update('AK-grid-jurnal-umum', {
                data: $('#search-jurnal-umum').serialize()
        });    
    }, 1000);
});
");
?>
<div style="width: 980px;overflow: auto;">
    <?php
    $this->widget(
        'ext.bootstrap.widgets.HeaderGroupGridView',
        array(
            'id' => 'AK-grid-jurnal-umum',
            'dataProvider' => $model->searchWithJoin(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeHeaders' => array(
                //                    array(
                //                        'name'=>'Rekening',
                //                        'start'=>5,
                //                        'end'=>6,
                //                    ),
                array(
                    'name' => 'Saldo',
                    'start' => 6,
                    'end' => 8,
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'Tgl. Jurnal',
                    'type' => 'raw',
                    'value' => 'date("d-m-Y", strtotime($data->jurnalRekening->tglbuktijurnal))',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                'jurnalRekening.kodejurnal',
                array(
                    'header' => 'Tgl. Posting',
                    'type' => 'raw',
                    'value' => 'isset($data->jurnalPosting->tgljurnalpost) ? date("d-m-Y", strtotime($data->jurnalPosting->tgljurnalpost)) : "-" ',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                'jurnalRekening.nobuktijurnal',
                array(
                    'header' => 'Tgl. Referensi <br> No. Referensi',
                    'type' => 'raw',
                    'value' => 'date("d-m-Y", strtotime($data->jurnalRekening->tglreferensi)) . " <br> " . $data->jurnalRekening->noreferensi',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                array(
                    'header' => 'Rekening',
                    'type' => 'raw',
                    'value' => '($data->getNamaRekDebit() == "-" ?  $data->getNamaRekKredit() : $data->getNamaRekDebit())',
                    'htmlOptions' => array('style' => 'width:100px'),
                    'footerHtmlOptions' => array('colspan' => 6, 'style' => 'text-align:right;font-style:italic;'),
                    'footer' => 'Jumlah Total',
                ),
                //                    array(
                //                      'header'=>'Kredit',
                //                      'type'=>'raw',
                //                      'value'=>'$data->getNamaRekKredit()',
                //                      'htmlOptions'=>array('style'=>'width:100px')
                //                    ),
                array(
                    'header' => 'Debit',
                    'name' => 'saldodebit',
                    'value' => '$data->saldodebit',
                    'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(saldodebit)',
                ),
                array(
                    'header' => 'Kredit',
                    'name' => 'saldokredit',
                    'value' => '$data->saldokredit',
                    'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(saldokredit)',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                    $(this).find("td[class$=\'currency\']").unmaskMoney(
                        {"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    $(this).find("td[class$=\'currency\']").maskMoney(
                        {"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                }',
        )
    );
    ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianJurnal',
    'options' => array(
        'title' => 'Rincian Jurnal',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 750,
        'minHeight' => 300,
        'resizable' => true
    ),
));
?>
<iframe src="" name="iframeRincianJurnal" height="300" width="100%"></iframe>
<?php
$this->endWidget();
?>