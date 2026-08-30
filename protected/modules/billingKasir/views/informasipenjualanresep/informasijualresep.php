<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'PasienRJ',
); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BKPenjualanresepT_noresep',
    'method' => 'GET',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penjualan Alkes</b>
        </div>
    </div>
    <div class="panel-body"> <?php echo $this->renderPartial('_formKriteriaPencarian', array('model' => $model, 'form' => $form), true); ?>
        <?php Yii::app()->clientScript->registerScript('', "
        function printKasir(penjualanresep_id,tandabuktibayar_id,caraPrint)
        {
            if(tandabuktibayar_id!=''){ 
                     window.open('" . Yii::app()->createUrl('billingKasir/informasipenjualanresep/buktiKasMasukFarmasi') . "&penjualanresep_id='+penjualanresep_id+'&tandabuktibayar_id='+tandabuktibayar_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=840,height=400,scrollbars=1');
            }     
        }
        function printFaktur(penjualanresep_id,tandabuktibayar_id,caraPrint)
        {
            if(tandabuktibayar_id!=''){ 
                     window.open('" . Yii::app()->createUrl('billingKasir/informasipenjualanresep/fakturPembayaranApotek') . "&penjualanresep_id='+penjualanresep_id+'&tandabuktibayar_id='+tandabuktibayar_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=840,height=400,scrollbars=1');
            }     
        }
        ",  CClientScript::POS_HEAD);
        ?>
        <?php $this->endWidget(); ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array(
                    'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penjualan Alkes</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pencarianpasien-grid',
            'dataProvider' => $model->searchPenjualanBebasLuar(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tanggal Penjualan',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenjualan)',
                ),
                array(
                    'header' => 'No. Resep / Struk',
                    'value' => '$data->noresep',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'NIK /<br> Nama Pasien/<br> Tgl Lahir',
                    'value' => function ($data) {
                        echo $data->pasien->no_identitas_pasien;
                        echo "<br>";
                        echo $data->pasien->nama_pasien;
                        echo "<br>";
                        echo $data->pasien->tanggal_lahir;
                    },
                    'type' => 'raw',
                ),
                'jenispenjualan',
                array(
                    'header' => 'Total Harga Jual',
                    'value' => '"Rp ".number_format($data->totalhargajual,0,"",".")',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'No. BKM / No. Faktur',
                    'type' => 'raw',
                    'value' => '((!empty($data->NoFaktur)) ? 
                                                            CHtml::Link("<i class=\"icon-print\"></i> $data->NoBkm","",
                                                            array("class"=>"", 
                                                                  "href"=>"",
                                                                  "onclick"=>"printKasir($data->penjualanresep_id,$data->tandaBuktiBayar,\"PRINT\");return false",
                                                                  "rel"=>"tooltip",
                                                                  "title"=>"Klik untuk print BKM",
                                                            ))."<br>"
                                                            .CHtml::Link("<i class=\"icon-print\"></i> $data->NoFaktur","",
                                                            array("class"=>"", 
                                                                  "href"=>"",
                                                                  "onclick"=>"printFaktur($data->penjualanresep_id,$data->tandaBuktiBayar,\"PRINT\");return false",
                                                                  "rel"=>"tooltip",
                                                                  "title"=>"Klik untuk print faktur",
                                                            )) : "Belum Lunas")'
                ),
                array(
                    'header' => 'Rincian Penjualan',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("informasipenjualanresep/FakturPembayaranApotek",array("penjualanresep_id"=>$data->penjualanresep_id, "tandabuktibayar_id"=>$data->tandaBuktiBayar)),
                                                            array("class"=>"", 
                                                                  "target"=>"iframeRincianTagihan",
                                                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                                  "rel"=>"tooltip",
                                                                  "title"=>"Klik untuk melihat Rincian Tagihan",
                                                            ))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                //                        array(
                //                            'header'=>'Pembayaran',
                //                            'type'=>'raw',
                //                            'value'=>'((empty($data->NoFaktur)) ? CHtml::Link("<i class=\"icon-list-silver\"></i>",Yii::app()->createAbsoluteUrl("farmasiApotek/pembayaranLangsung/index",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>true)),
                //                                        array("class"=>"", 
                //                                              "target"=>"iframePembayaran",
                //                                              "onclick"=>"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                //                                              "rel"=>"tooltip",
                //                                              "title"=>"Klik untuk membayar ke kasir",
                //                                        )) : "Sudah Lunas")',          
                //                            'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                //                        ),
                //TEST NEW 
                array(
                    'header' => 'Pembayaran',
                    'type' => 'raw',
                    'value' => '((empty($data->NoFaktur)) ? CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->createAbsoluteUrl("/billingKasir/pembayaranPenjualanApotek/index",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>true)),
                                                            array("class"=>"", 
                                                                  "target"=>"iframePembayaran",
                                                                  "onclick"=>"$(\"#dialogPembayaranKasir\").dialog(\"open\");",
                                                                  "rel"=>"tooltip",
                                                                  "title"=>"Klik untuk membayar ke kasir",
                                                            )) : "Sudah Lunas")',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(penjualanresep_id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>
</div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPembayaranKasir',
    'options' => array(
        'title' => 'Pembayaran',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1100,
        'height' => 610,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Penjualan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>