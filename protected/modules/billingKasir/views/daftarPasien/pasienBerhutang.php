<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'Pasien Piutang',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BKPembayaranpelayananT_no_rekam_medik',
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
            <i class="entypo-user"></i> Informasi <b>Pasien Piutang Perorangan</b>
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Rekam Medik', 'no_rekam_medik', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nama_bin', array('placeholder' => 'Alias', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
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
                    $content = $this->renderPartial('tips/informasi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Piutang Perorangan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $model->searchPasienBerhutang(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Jumlah Pembayaran</p>',
                            'start' => 13, //indeks kolom 3
                            'end' => 14, //indeks kolom 4
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Bukti Bayar',
                            'name' => 'tglbuktibayar',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tandabuktibayar->tglbuktibayar)."<br>".$data->tandabuktibayar->nobuktibayar',
                        ),
                        array(
                            'name' => 'instalasi',
                            'type' => 'raw',
                            'value' => 'isset($data->pendaftaran->instalasi->instalasi_nama) ? $data->pendaftaran->instalasi->instalasi_nama : " - " ',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => 'isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:" - "',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->pasien->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien/<br>Alias',
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->nama_pasien.(isset($data->nama_bin) ? "/".$data->nama_bin : "")',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'name' => 'carabayar_nama',
                            'type' => 'raw',
                            'value' => 'isset($data->pendaftaran_id)?$data->pendaftaran->carabayar->carabayar_nama."<br>".$data->pendaftaran->penjamin->penjamin_nama:" - "',
                        ),
                        array(
                            'header' => 'Total Tagihan <br>(Rp)',
                            'name' => 'total_tagihan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalbiayapelayanan)',
                        ),
                        array(
                            'header' => 'Tanggungan Asuransi <br>(Rp)',
                            'name' => 'subsidi_asuransi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidiasuransi)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Tanggungan Rumah Sakit <br>(Rp)',
                            'name' => 'subsidi_rs',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidirs)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Tanggungan Pemerintah <br>(Rp)',
                            'name' => 'subsidi_pemerintah',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidipemerintah)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Biaya <br>(Rp)',
                            'name' => 'iur_biaya',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totaliurbiaya)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Keringanan <br>(Rp)',
                            'name' => 'discount',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totaldiscount)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Pembebasan',
                            'name' => 'pembebasan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totalpembebasan)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Tunai <br>(Rp)',
                            'name' => 'jumlah_pembayaran',
                            'type' => 'raw',
                            'value' => function ($data) use (&$angsuran) {
                                $total = 0;
                                $angsuran = BayarangsuranpelayananT::model()->findAllByAttributes(array(
                                    'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id,
                                ));
                                foreach ($angsuran as $item) {
                                    $tandabukti = TandabuktibayarT::model()->findByPk($item->tandabuktibayar_id);
                                    if (!empty($tandabukti)) {
                                        $total += $tandabukti->uangditerima - $tandabukti->uangkembalian;
                                    }
                                }
                                return MyFormatter::formatNumberForPrint($total);
                            }, //'MyFormatter::formatNumberForPrint($data->totalbayartindakan)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Non Tunai <br>(Rp)',
                            'name' => 'jumlah_pembayaran',
                            'type' => 'raw',
                            'value' => function ($data) use (&$angsuran) {
                                $total = 0;
                                foreach ($angsuran as $item) {
                                    $tandabukti = TandabuktibayarT::model()->findByPk($item->tandabuktibayar_id);
                                    if (!empty($tandabukti)) {
                                        $total += $tandabukti->bank_nominal;
                                    }
                                }
                                return MyFormatter::formatNumberForPrint($total);
                            }, //'MyFormatter::formatNumberForPrint($data->totalbayartindakan)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Rincian Piutang',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-rincianhutang\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianHutang",array("id"=>$data->pendaftaran_id, "idpembayaran"=>$data->pembayaranpelayanan_id, "frame"=>true)),
														array("class"=>"", 
															  "target"=>"iframeRincianTagihan",
															  "onclick"=>"$(\"#dialogRincianHutang\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk melihat Rincian Tagihan",
														))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Bayar Angsuran',
                            'type' => 'raw',
                            'value' => '($data->totalsisatagihan == 0)? "Lunas":
											CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("bayarAngsuran/index",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
														array("class"=>"", 
															  "target"=>"iframePembayaran",
															  "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");",
															  "rel"=>"tooltip",
															  "title"=>"Klik untuk membayar angsuran",
														))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php //echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);  
?>
<!--modified by @author Rahman Fad / Tidak ada Status Periksa (EHS-1254) / 22-05-2014-->
<?php //$model->statusperiksa = (!empty($model->statusperiksa)) ? $model->statusperiksa : 'SEDANG PERIKSA';
?>
<?php //echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --')); 
?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    'options' => array(
        'title' => 'Pembayaran Angsuran',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1000,
        'height' => 500,
        'width' => 1000,
        'height' => 550,
        'resizable' => true,
        'close' => 'js:function(){$.fn.yiiGridView.update(\'pencarianpasien-grid\', {data: $("#caripasien-form").serialize()});}'
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianHutang',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien Piutang',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 700,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>