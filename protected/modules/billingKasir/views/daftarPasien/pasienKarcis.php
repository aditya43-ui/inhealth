<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'PasienKarcis',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BKTindakanPelayananT_no_rekam_medik',
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
$provider = $model->searchPasienKarcis();
$provider->sort->defaultOrder = 'tgl_pendaftaran desc';
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-ticket"></i> Informasi <b>Pasien Karcis</b>
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
                <?php echo $this->renderPartial('_formKriteriaPencarianPKarcis', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Karcis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $provider,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'name' => 'umur',
                            'type' => 'raw',
                            'value' => '$data->umur',
                        ),
                        array(
                            'header' => 'Alamat',
                            'name' => 'alamat_pasien',
                            'type' => 'raw',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Jenis Kasus Penyakit',
                            'name' => 'jeniskasuspenyakit_nama',
                            'type' => 'raw',
                            'value' => '(isset($data->jeniskasuspenyakit_id) ? $data->jeniskasuspenyakit_nama : "")',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'name' => 'carabayar_nama',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
                        ),
                        array(
                            'header' => 'Instalasi/<br>Ruangan',
                            'name' => 'instalasi',
                            'type' => 'raw',
                            'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Nama Karcis',
                            'name' => 'daftartindakan_nama',
                            'type' => 'raw',
                            'value' => '$data->daftartindakan_nama',
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::htmlButton($data->statusperiksa, array(
                                    'class' => 'btn ' . Params::statusPeriksaCol()[$data->statusperiksa],
                                    'style' => 'min-width: 200px;'
                                ));
                            }, //'$data->statusperiksa',
                        ),
                        /*
										array(
											'header'=>'Tarif',
											'name'=>'tarif_tindakan',
											'type'=>'raw',
											'value'=>'CHtml::link("<i class=icon-form-print></i> ".MyFormatter::formatUang($data->tarif_tindakan),"javascript:void(0)",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Print Karcis","onclick"=>"printKarcis($data->pendaftaran_id)"))',
										),  */
                        array(
                            'header' => 'Pembayaran Karcis',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $pt = PembayaranpelayananT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id,
                                ));
                                // var_dump($data);die;
                                return empty($data->tindakansudahbayar_id) ? CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("pembayaranTagihanKarcis/index",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
                                array("class"=>"", 
                                      "target"=>"iframePembayaran",
                                      "onclick"=>"$(\"#dialogBayarKarcis\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk membayar karcis",
                                )) : "Sudah Bayar"."<br>".
                                CHtml::link("<i class=\"icon-print\"></i>","javascript:void(0);", array(
                                    'onclick'=>"printRincianSudahBayar(". $pt->pembayaranpelayanan_id .");return false",
                                    'disabled'=>FALSE,
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melihat INVOICE Pembayaran",));
                            },
                            // 'empty($data->tindakansudahbayar_id) ? CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("pembayaranTagihanKarcis/index",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)),
							// 							array("class"=>"", 
							// 								  "target"=>"iframePembayaran",
							// 								  "onclick"=>"$(\"#dialogBayarKarcis\").dialog(\"open\");",
							// 								  "rel"=>"tooltip",
							// 								  "title"=>"Klik untuk membayar karcis",
							// 							)) : "Sudah Bayar"."<br>".
                            //                             "CHtml::link("<i class=\"icon-print\"></i>","javascript:void(0);", array(
                            //                                 'onclick'=>"printRincianSudahBayar(". $data->pembayaranpelayanan_id .");return false",
                            //                                 'disabled'=>FALSE,
                            //                                 "rel"=>"tooltip",
                            //                                 "title"=>"Klik untuk melihat INVOICE Pembayaran",  ));
                            //                         },  ',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBayarKarcis',
    'options' => array(
        'title' => 'Pembayaran Karcis',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'zIndex' => 1001,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<script type="text/javascript">
    function printKarcis(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/printKarcis'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
    function printRincianSudahBayar(id)
    {
        
        window.open("<?php echo $this->createUrl('/billingKasir/PembayaranTagihanPasien/printRincianSudahBayarKwitansi') ?>&pembayaranpelayanan_id="+id,"",'location=_new, width=1024px, height=480');
    }
</script>