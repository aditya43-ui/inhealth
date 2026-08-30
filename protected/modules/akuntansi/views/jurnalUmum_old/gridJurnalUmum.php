<?php
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
<div class="white-container">
    <legend class="rim2">Informasi <b>Jurnal</b></legend>
    <?php
    $this->widget(
        'ext.bootstrap.widgets.HeaderGroupGridView',
        array(
            'id' => 'AK-grid-jurnal-umum',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => 'Saldo',
                    'start' => 6,
                    'end' => 7,
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'Tanggal Jurnal',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($data->tglbuktijurnal)))',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                'kodejurnal',
                array(
                    'header' => 'Tanggal Posting',
                    'type' => 'raw',
                    'value' => 'isset($data->tgljurnalpost) ? MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($data->tgljurnalpost))) : "-" ',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                'nobuktijurnal',
                array(
                    'header' => 'Tanggal Referensi <br> No. Referensi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($data->tglreferensi))) . " <br> " . $data->noreferensi',
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
                array(
                    'header' => 'Debit',
                    'name' => 'saldodebit',
                    'value' => 'number_format($data->saldodebit)',
                    'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(saldodebit)',
                ),
                array(
                    'header' => 'Kredit',
                    'name' => 'saldokredit',
                    'value' => 'number_format($data->saldokredit)',
                    'htmlOptions' => array('style' => 'width:100px;text-align:right', 'class' => 'currency'),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'footer' => 'sum(saldokredit)',
                ),
                array(
                    'header' => 'Posting Jurnal',
                    'type' => 'raw',
                    'value' => '(!empty($data->jurnalposting_id) ? "Sudah Posting Jurnal" : CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("jurnalUmum/postingJurnal",array("nobuktijurnal"=>$data->nobuktijurnal,"frame"=>1)),
								 array("class"=>"", 
									   "target"=>"iframePostingJurnal",
									   "onclick"=>"$(\"#dialogPostingJurnal\").dialog(\"open\");",
									   "rel"=>"tooltip",
									   "title"=>"Klik untuk Posting Jurnal",
						  ))) ',
                    'htmlOptions' => array('style' => 'width:100px;text-align:center;'),
                    'footer' => '-',
                    'footerHtmlOptions' => array('style' => 'color:white;'),
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
    <?php

    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    echo $this->renderPartial('__formSearch', array('model' => $model));

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

<?php
// Dialog untuk posting jurnal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPostingJurnal',
    'options' => array(
        'title' => 'Posting Jurnal',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'minHeight' => 610,
        'resizable' => false,
        'before'
    ),
));
?>
<iframe src="" name="iframePostingJurnal" width="100%" height="550">
</iframe>
<?php
$this->endWidget();
//========= end posting jurnal Dialog =============================
?>