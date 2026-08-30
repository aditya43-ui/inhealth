<?php
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'advancepayment-t-grid',
        'dataProvider'=>$model->searchInformasi(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'columns'=>array(
            array(
                'header'=>'No',
                'type'=>'raw',
                'value'=>'$row+1',
                'htmlOptions'=>array('style'=>'width:20px')
            ),
            array(
                'header' => 'Klinik',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->profilrs->nama_rumahsakit;
                }
            ),
            array(
                'header' => 'Tgl. Pengajuan | <br> No.Pengajuan  ',
                'type'   => 'raw',
                'value'  => function($data){
                    return MyFormatter::formatDateTimeForUser($data->tglpengajuan) .' | <br>'. $data->nopengajuan;
                }
            ),
            array(
                'header' => 'Tgl.Kas Keluar | <br> No. Kas Keluar  ',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->tandabuktikeluar ? (MyFormatter::formatDateTimeForUser($data->tandabuktikeluar->tglkaskeluar) .' | <br>'. $data->tandabuktikeluar->nokaskeluar) : '';
                }
            ),
            // 'jenistransaksi',
            // array(
            //     'header' => 'Jenis Transaksi',
            //     'type'   => 'raw',
            //     'value'  => function($data){
            //         // return 'Rp.'.number_format($data->jmlpembayaran,2,',','.');
            //         $lookup = LookupM::model()->findByAttributes(array(
            //             'lookup_type' => 'advancepayment',
            //             'lookup_value' => $data->jenistransaksi
            //         ));
            //
            //         return $lookup->lookup_name;
            //     }
            // ),
            'nodokumen',
            'noanggaran',
            array(
                'header' => 'Jumlah Pembayaran',
                'type'   => 'raw',
                'value'  => function($data){
                    return 'Rp.'.number_format($data->jmlpembayaran,2,',','.');
                }
            ),
            array(
                'header' => 'Biaya Administrasi',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->tandabuktikeluar ? 'Rp.'.number_format($data->tandabuktikeluar->biayaadministrasi,2,',','.') : 'Rp.'.number_format(0,2,'.',',');
                }
            ),
            array(
                'header' => 'Jumlah Kas Keluar',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->tandabuktikeluar ? 'Rp.'.number_format($data->tandabuktikeluar->jmlkaskeluar,2,',','.') : 'Rp.'.number_format(0,2,'.',',');
                }
            ),
            'keterangan',
            array(
                'header' => 'Pegawai Yang Mengajukan',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->pegawai->namaLengkap;
                }
            ),
            array(
                'header' => 'Pegawai Pemeriksa',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->pegawaipemeriksa->namaLengkap;
                }
            ),
            array(
                'header' => 'Pegawai Menyetujui',
                'type'   => 'raw',
                'value'  => function($data){
                    return $data->pegawaimenyetujui->namaLengkap;
                }
            ),
            array(
                'header'=>'<center>Rincian</center>',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("Print",array("advancepayment_id"=>$data->advancepayment_id,"frame"=>true)),
                array("class"=>"",
                    "target"=>"iframeRincianAdvancePayment",
                    "onclick"=>"$(\"#dialogRincianAdvancePayment\").dialog(\"open\");",
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk rincian Advance Payment",
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
            array(
                'header' => 'Settlement',
                'type' => 'raw',
                // 'value' => '<i class=\"icon-form-detail\"></i>',
                'value' => function($data){
                  $settelement = SettlementpaymentT::model()->findByAttributes(array(
                    'advancepayment_id' => $data->advancepayment_id,
                    // 'order' => 'tglsettlement desc'
                  ),array('order' => 'tglsettlement desc'));
                  $sisaadvance = 0;
                  $sisakekurangan = 0;
                  $sisarealisasi = 0;
                  if($settelement){
                    $sisaadvance = $settelement->sisaadvance;
                    $sisakekurangan = $settelement->sisaadvance;
                    $sisarealisasi = $settelement->sisaadvance;
                    }
                  // if(count($settelement) > 0 ){
                  //     foreach ($settelement as $val) {
                  //       $sisaadvance += $val->sisaadvance;
                  //       $sisakekurangan += $val->sisakekurangan;
                  //       $sisarealisasi += $val->sisarealisasi;
                  //     }
                  // }
                  if(isset($settelement) && $sisaadvance == 0 && $sisakekurangan == 0 && $sisarealisasi == 0){
                      return 'SUDAH SELESAI';
                  }else {
                    return  CHtml::Link("<i class=\"icon-kop-cairpinjaman\"></i>",Yii::app()->controller->createUrl("SettlementPaymentT/index",array("advancepayment_id"=>$data->advancepayment_id,"frame"=>true)),
                    array("class"=>"",
                        "rel"=>"tooltip",
                        "title"=>"Klik Untuk Melakukan Settlement",
                    ));
                  }

                  }
            ),
            array(
                'header' => 'Status Advance Payment',
                'type' => 'raw',
                'value' => function($data){
                    $btn = '<button class="btn btn-danger">BELUM LUNAS</button>';
                    // $settelement = SettlementpaymentT::model()->findByAttributes(array('advancepayment_id' => $data->advancepayment_id));
                    $settelement = SettlementpaymentT::model()->findByAttributes(array(
                      'advancepayment_id' => $data->advancepayment_id,

                    ),array('order' => 'tglsettlement desc'));
                    $sisaadvance = 0;
                    $sisakekurangan = 0;
                    $sisarealisasi = 0;
                    if($settelement){
                      $sisaadvance = $settelement->sisaadvance;
                      $sisakekurangan = $settelement->sisaadvance;
                      $sisarealisasi = $settelement->sisaadvance;
                      }
                    if($settelement){
                        if ($sisaadvance == 0 && $sisakekurangan == 0 && $sisarealisasi == 0) {
                            $btn = '<button class="btn btn-success">LUNAS</button>';
                        }
                    }
                    // if()
                    return $btn;
                    // settlementpayment_t.hutangrealisasi = 0 and settlementpayment_t.sisarealisasi = 0 /
                }
                // 'value' => 'CHtml::Link("",Yii::app()->controller->createUrl("Print",array("advancepayment_id"=>$data->advancepayment_id,"frame"=>true)) )'
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
                        return 'Dibatalkan Oleh : '.$data->pegawaibatal->namaLengkap .'('.MyFormatter::formatDateTimeForUser($data->tglbatal).')'.'<br>'.'Alasan :'.$data->alasanbatal;
                    }else{
                        // $d =''
                      return  CHtml::link("<i class='icon-form-silang'></i>",Yii::app()->createUrl("keuangan/AdvancePaymentT/batal",array("frame"=>1,"advancepayment_id"=>$data->advancepayment_id)) ,array("title"=>"Klik Untuk Batal Advance Payment","target"=>"iframeRetur", "onclick"=>"$('#dialogRetur').dialog('open');", "rel"=>"tooltip"));
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
    'id'=>'dialogRincianAdvancePayment',
    'options'=>array(
        'title'=>'Rincian Advance Payment',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianAdvancePayment" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogRetur',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Form Pembatalan Advance Payment',
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
