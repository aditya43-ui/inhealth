<style>
    .clsOdd {
        background-color: #f9f9f9;
    }

    /*.clsEven {
  background-color: #f9f9f9;
}*/
</style>
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
$prov = $model->searchInformasi();
if (isset($_GET['AKInformasijurnaltransaksiV_items'])) {
    $prov->pagination->pageSize = $_GET['AKInformasijurnaltransaksiV_items'];
}
$aa = array();
foreach ($prov->data as $i => $itemd) {
    $aa[$itemd->kodejurnal][] = $itemd;
}
$index = 0;
foreach ($aa as $i => $itemd) {
    foreach ($itemd as $data) {
        $data->cehk = $index;
    }
    $index++;
}
$bb = array();
foreach ($prov->data as $i => $itemx) {
    // $itemx->jeniskodejurnal = $itemx->setJenisKode();
    $itemx->jeniskodejurnal = $itemx->jurnalrekening_id . '' . $itemx->kodejurnal;
    $bb[$itemx->jeniskodejurnal][] = $itemx;
}
$index1 = 0;
foreach ($bb as $i => $itemx) {
    foreach ($itemx  as $data) {
        $data->chrow = $index1;
    }
    $index1++;
}
$provTot = clone $prov;
$provTot->pagination = false;
$dat = array('d' => 0, 'k' => 0);
foreach ($provTot->data as $item) {
    $dat['d'] += $item->saldodebit;
    $dat['k'] += $item->saldokredit;
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Jurnal</b>
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
                <?php
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
                echo $this->renderPartial('__formSearch', array('model' => $model));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Jurnal</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'AK-grid-jurnal-umum',
                    'dataProvider' => $prov,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-condensed',
                    'rowCssClassExpression' => '($data->cehk % 2 == 0)?"clsOdd" :"clsEven"',
                    'mergeColumns' => array('kodejurnal', 'jeniskodejurnal'),
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Saldo',
                            'start' => 7,
                            'end' => 8,
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'Jenis Jurnal',
                            'type' => 'raw',
                            'name' => 'jeniskodejurnal',
                            'value' => function ($data) {
                                $a = "<span hidden>" . $data->jeniskodejurnal . "</span>";
                                return $a . "<br>" . $data->jenisjurnal_nama;
                            },
                            'htmlOptions' => array('style' => 'width:100px')
                        ),
                        array(
                            'header' => 'Tgl. Jurnal/<br> No. Bukti Jurnal',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglbuktijurnal)."/<br> ".$data->nobuktijurnal',
                            'htmlOptions' => array('style' => 'width:100px')
                        ),
                        array(
                            'header' => 'Kode Jurnal',
                            'name' => 'kodejurnal',
                            'type' => 'raw',
                            // 'value' => '$data->kodejurnal',
                            'value' => function ($data) {
                                $rekColumnKosongDebit = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_REKENING5M, 'column_name' => Params::REKENINGCOLUMN_COLUMN_REKENINGKOSONGDEBIT, 'debitkredit' => 'D'));
                                $rekColumnKosongKredit = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_REKENING5M, 'column_name' => Params::REKENINGCOLUMN_COLUMN_REKENINGKOSONGKREDIT, 'debitkredit' => 'K'));
                                $html = "";
                                $modKonfigOto = ApprovalotorisasiM::model()->find();
                                // $dataDialog = 'myAlert("Hanya '.(isset($modKonfigOto->manageraccountingrs)? $modKonfigOto->manageraccountingrs->namaLengkap : "-").' yang bisa mengakses");';
                                // if($modKonfigOto->manageraccountingrs_id == Yii::app()->user->getState('pegawai_id')){
                                $dataDialog = "$('#dialogUbahAkun').dialog('open');";
                                // }
                                $htmlUbah = CHtml::Link(
                                    "<i class='icon-form-ubah'></i>",
                                    Yii::app()->controller->createUrl("JurnalUmum/ubahRekening", array("jurnalrekening_id" => $data->jurnalrekening_id, "frame" => true)),
                                    array(
                                        "class" => "",
                                        "target" => "ubahRekening",
                                        "onclick" => $dataDialog,
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk merubah Akun Jurnal",
                                    )
                                );
                                // if($data->is_posting != 1){
                                //   if(!empty($data->kdrekening5) && ((isset($rekColumnKosongDebit) && ($rekColumnKosongDebit->rekening5_id == $data->rekening5_id)) || (isset($rekColumnKosongKredit) && ($rekColumnKosongKredit->rekening5_id == $data->rekening5_id)))){
                                //       $html = $htmlUbah;
                                //   }else{
                                //     if(empty($data->kdrekening5)){
                                //         $html = $htmlUbah;
                                //       }
                                //   }
                                // }
                                // return $data->kodejurnal."<br>".$html;
                                return $data->kodejurnal . "<br>" . $htmlUbah;
                            },
                        ),
                        //                                'noreferensi',
                        /* array(
                                    'header' => 'Tanggal Posting',
                                    'type' => 'raw',
                                    'value' => 'isset($data->tgljurnalpost) ? MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($data->tgljurnalpost))) : "-" ',
                                    'htmlOptions' => array('style' => 'width:100px')
                                ),*/
                        array(
                            'header' => 'Tanggal Referensi/ <br> No. Referensi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglreferensi) . "/ <br> " . $data->noreferensi',
                            'htmlOptions' => array('style' => 'width:100px')
                        ),
                        array(
                            'header' => 'Kode Akun',
                            'type' => 'raw',
                            //                                    'value' => '$data->kdrekening5',
                            'value' => function ($data) {
                                $rekColumnKosongDebit = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_REKENING5M, 'column_name' => Params::REKENINGCOLUMN_COLUMN_REKENINGKOSONGDEBIT, 'debitkredit' => 'D'));
                                $rekColumnKosongKredit = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_REKENING5M, 'column_name' => Params::REKENINGCOLUMN_COLUMN_REKENINGKOSONGKREDIT, 'debitkredit' => 'K'));
                                $value = $data->kdrekening5;
                                if ((isset($rekColumnKosongDebit) && ($rekColumnKosongDebit->rekening5_id == $data->rekening5_id)) || (isset($rekColumnKosongKredit) && ($rekColumnKosongKredit->rekening5_id == $data->rekening5_id))) {
                                    $value = '-';
                                }
                                return $value;
                            },
                            'htmlOptions' => array('style' => 'width:100px'),
                        ),
                        array(
                            'header' => 'Nama Akun',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $rekColumnKosongDebit = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_REKENING5M, 'column_name' => Params::REKENINGCOLUMN_COLUMN_REKENINGKOSONGDEBIT, 'debitkredit' => 'D'));
                                $rekColumnKosongKredit = RekeningcolumnM::model()->findByAttributes(array('table_name' => Params::REKENINGCOLUMN_TABLE_REKENING5M, 'column_name' => Params::REKENINGCOLUMN_COLUMN_REKENINGKOSONGKREDIT, 'debitkredit' => 'K'));
                                $value = $data->nmrekening5;
                                if ((isset($rekColumnKosongDebit) && ($rekColumnKosongDebit->rekening5_id == $data->rekening5_id)) || (isset($rekColumnKosongKredit) && ($rekColumnKosongKredit->rekening5_id == $data->rekening5_id))) {
                                    $value = '-';
                                }
                                return $value;
                            },
                            //'value' => '($data->getNamaRekDebit() == "-" ?  $data->getNamaRekKredit() : $data->getNamaRekDebit())',
                            //									'value' => '$data->nmrekening5',
                            'htmlOptions' => array('style' => 'width:100px'),
                        ),
                        array(
                            'header' => 'Uraian Jurnal',
                            //                                    'name' => 'urianjurnal',
                            'type' => 'raw',
                            'value' => '(!empty($data->uraiantransaksi)?$data->uraiantransaksi:$data->urianjurnal)',
                            'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-style:italic;'),
                            'footer' => 'Jumlah Total',
                        ),
                        array(
                            'header' => 'Debit (Rp)',
                            'name' => 'saldodebit',
                            'value' => 'MyFormatter::formatNumberForPrint($data->saldodebit,2)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            'footer' => MyFormatter::formatNumberForPrint($dat['d'], 2),
                        ),
                        array(
                            'header' => 'Kredit (Rp)',
                            'name' => 'saldokredit',
                            'value' => 'MyFormatter::formatNumberForPrint($data->saldokredit,2)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            'footer' => MyFormatter::formatNumberForPrint($dat['k'], 2),
                        ),
                        /*    array(
                                    'header' => 'Posting Jurnal',
                                    'type' => 'raw',
                                    'value' => '(!empty($data->jurnalposting_id) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljurnalpost))) : "") ',
                                    'htmlOptions' => array('style' => 'width:100px;text-align:center;'),
                                    'footer' => '-',
                                    'footerHtmlOptions' => array('style' => 'color:white;'),
                                ),/*CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("jurnalUmum/postingJurnal",array("nobuktijurnal"=>$data->nobuktijurnal,"frame"=>1)),
                                        array("class"=>"",
                                        "target"=>"iframePostingJurnal",
                                        "onclick"=>"$(\"#dialogPostingJurnal\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk Posting Jurnal",
                                    )))
								 *
								 */
                        array(
                            'header' => 'Status Posting',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->is_posting == 1) {
                                    return Params::getWrStatusPosting(Params::STATUS_POSTING_SUDAH);
                                } else {
                                    return Params::getWrStatusPosting(Params::STATUS_POSTING_BELUM);
                                }
                            },
                            'footer' => ' ',
                        ),
                        array(
                            'header' => 'Operator',
                            'type' => 'raw',
                            'value' => function ($data) {
                                // $det = JurnaldetailT::model()->findByPk($data->jurnaldetail_id);
                                // $peg = JurnalrekeningT::model()->findByPk($det->jurnalrekening_id);
                                //if (!empty($peg)){
                                $log = LoginpemakaiK::model()->findByPK($data->create_loginpemakai_id);
                                if ($log->loginpemakai_id == Params::LOGINPEMAKAI_ID_ADMIN) {
                                    return 'OTOMATIS';
                                } else {
                                    if (!empty($log->pegawai_id)) {
                                        return $log->pegawai->namaLengkap;
                                    }
                                }
                                //}
                            },
                            'footer' => ' '
                        ),
                        array(
                            'header' => 'Jurnal Pembalik',
                            'type' => 'raw',
                            'name' => 'kodejurnal',
                            'value' => '(empty($data->jurnalbalik_id)? (($data->is_posting == 1)?CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->controller->createUrl(("jurnalPembalik/index"),array("jurnalrekening_id"=>$data->jurnalrekening_id)),
                                                array("class"=>"",
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik untuk Jurnal Pembalik",
                                                )
                                            ):""):"")',
                            'footer' => ' '
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
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianJurnal',
    'options' => array(
        'title' => 'Rincian Jurnal',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 750,
        'height' => 300,
        'resizable' => true
    ),
));
?>
<iframe src="" name="iframeRincianJurnal" style="width: 100%; height: 98%;"></iframe>
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
        'height' => 610,
        'resizable' => false,
        'before'
    ),
));
?>
<iframe src="" name="iframePostingJurnal" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end posting jurnal Dialog =============================
?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahAkun',
    'options' => array(
        'title' => 'Mapping Akun Jurnal',
        'autoOpen' => false,
        'minWidth' => 1000,
        'height' => 320,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('AK-grid-jurnal-umum', {
                    			data: $(this).serialize()
                    		}); }",
    ),
));
?>
<iframe src="" name="ubahRekening" width="100%" height="300"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--<script type="javascript">
$( document ).ready(function() {
});
</script>-->