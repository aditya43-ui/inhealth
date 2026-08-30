<?php
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'advancepayment-t-grid',
        'dataProvider'=>$model->searchInformasi(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(            
            array(
                'header' => 'Klinik',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->profilrs->nama_rumahsakit;
                }
            ),
            array(
                'header' => 'Tgl. Settlement | <br> No.Settlement  ',
                'type'   => 'raw',
                'value'  => function($data){
                    return MyFormatter::formatDateTimeForUser($data->tglsettlement) .' | <br>'. $data->nosettlement;
                }
            ),
            array(
                'header' => 'Tgl. Pengajuan AP | <br> No. Pengajuan AP',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->advancepayment ? (MyFormatter::formatDateTimeForUser($data->advancepayment->tglpengajuan) .' | <br>'. $data->advancepayment->nopengajuan) : '';
                }
            ),
            array(
                'header' => 'Petugas Yang Menggajukan AP',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->pegawai ? $data->pegawai->namaLengkap : '';
                // .' | <br>'. $data->advancepayment->nopengajuan) : '';
                }
            ),
            // array(
            //     'header' => 'NIP | <br> Jabatan',
            //     'type'   => 'raw',
            //     'value'  => function($data){
            //         return $data->pegawai ? $data->pegawai->jabatan->jabatan_nama : '';
            //     // .' | <br>'. $data->advancepayment->nopengajuan) : '';
            //     }
            // ),

            array(
                'header' => 'NIP | <br> Jabatan',
                'type'   => 'raw',
                'value'  => function($data){
                   if($data->pegawai){
                        return $data->pegawai->nomorindukpegawai ."<br>".$data->pegawai->jabatan->jabatan_nama;
                   }else{
                       return '';
                   }
                    // $data->pegawai ? 
                // .' | <br>'. $data->advancepayment->nopengajuan) : '';
                }
            ),
            array(
                'header' => 'Petugas Settlement',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->pegawaisettlement ? $data->pegawaisettlement->namaLengkap : '';
                // .' | <br>'. $data->advancepayment->nopengajuan) : '';
                }
            ),

            array(
                'header' => 'Status',
                'type' => 'raw',
                'value' => function($data){
                    $btn = '<button class="btn btn-danger">BELUM LUNAS</button>';
                    // settlementpayment_t. sisakekurangan = 0 and  settlementpayment_t.sisapembelian = 0 and settlementpayment_t.sisaadvance <> 0 maka munculkan LUNAS
                    
                    if($data->sisakekurangan == 0 && $data->sisapengembalian == 0 && $data->sisaadvance != 0){
                        $btn = '<button class="btn btn-success">LUNAS</button>';
                    }
                    return $btn;
                    // settlementpayment_t.hutangrealisasi = 0 and settlementpayment_t.sisarealisasi = 0 /
                }
                // 'value' => 'CHtml::Link("",Yii::app()->controller->createUrl("Print",array("advancepayment_id"=>$data->advancepayment_id,"frame"=>true)) )'
            ),
            array(
                'header'=>'<center>Rincian</center>',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("Print",array("settlementpayment_id"=>$data->settlementpayment_id,"frame"=>true)),
                array("class"=>"", 
                    "target"=>"iframeRincianSettlementPayment",
                    "onclick"=>"$(\"#dialogRincianSettlementPayment\").dialog(\"open\");",
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk rincian Settlement Payment",
                ))',
                'htmlOptions'=>array(
                    'style'=>'text-align: center;'
                ),
                'htmlOptions' => array(
                    'style' => 'width: 100px; text-align: center;',
                ),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                'footer'=>'',
            ),
            // array(
            //     'header' => 'Settlement',
            //     'type'   => 'raw',
            //     'value'  => function($data){
            //         return $data->pegawaisettlement ? $data->pegawaisettlement->namaLengkap : '';
            //     // .' | <br>'. $data->advancepayment->nopengajuan) : '';
            //     }
            // ),
            array(
                'header' => 'Settlement',
                'type' => 'raw',
                'value' => function($data){
                    // $link = CHtml::Link("<i class=\"icon-realanggarankeluar\"></i>");
                    $link=CHtml::Link("<i class=\"icon-realanggarankeluar\"></i>",Yii::app()->controller->createUrl("SettlementPaymentT/index",array("advancepayment_id"=>$data->advancepayment_id,"settlementpayment_id"=>$data->settlementpayment_id,"frame"=>true)), 
                    array("class"=>"", 
                        "rel"=>"tooltip",
                        "title"=>"Klik Untuk Melakukan Settlement",
                    ));
                    if($data->ispotonggaji){
                        $link = 'Pemotongan Gaji';
                    }
                    if($data->ispiutang){
                        $link ='Piutang Pegawai';
                    }
                    if($data->ishutang){
                        $link = 'Hutang Klinik';
                    }
                    echo $link;
                }
            ),
            array( 
                'header'=>'Batal',
                'type'=>'raw',
                'htmlOptions' => array(
                    'style' => 'width: 100px; text-align: center;',
                ),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                'footer'=>'&nbsp;',
                'value'=>function($data){
                    if ($data->pegawaibatal_id) {
                        return 'Dibatalkan Oleh : '.$data->pegawaibatal->namaLengkap .'('.MyFormatter::formatDateTimeForUser($data->tglpembatalan).')'.'<br>'.'Alasan :'.$data->alasanpembatalan;
                    }else{
                        // $d =''
                      return  CHtml::link("<i class='icon-form-silang'></i>",Yii::app()->createUrl("keuangan/SettlementPaymentT/batal",array("frame"=>1,"settlementpayment_id"=>$data->settlementpayment_id)) ,array("title"=>"Klik Untuk Batal Settlement Payment","target"=>"iframeRetur", "onclick"=>"$('#dialogRetur').dialog('open');", "rel"=>"tooltip"));
                    }
                },
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianSettlementPayment',
    'options'=>array(
        'title'=>'Rincian Settlement Payment',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianSettlementPayment" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogRetur',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Form Pembatalan Settlement Payment',
                        'autoOpen'=>false,
                        'minWidth'=>500,
                        'minHeight'=>70,
                            'zIndex'=>1004,
                        'resizable'=>false,
                        'close'=>"js:function(){ $.fn.yiiGridView.update('advancepayment-t-grid', {
                            data: $(this).serialize()
                        }); }",
                         ),
                    ));
?>
<iframe src="" name="iframeRetur" width="100%" height="250">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');?>