<?php $linkHalaman = CustomFunction::getUrlByMenuID(963); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penjualan Obat untuk Pegawai',
);
?>
<!--div class="white-container"-->
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'search',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modInfoPenjualan, 'noresep'),
    'method' => 'get',
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penjualan Obat untuk Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Penjualan", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Resep', 'no_resep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modInfoPenjualan, 'noresep', array('placeholder' => 'No. Resep', 'autofocus' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Dokter', 'nama_dokter', array('class' => 'control-label')); ?>
                            <div class="controls">

                            <?php echo $form->hiddenField($modInfoPenjualan, 'pegawai_id', array('readonly' => true)) ?>
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'name' => 'pasienpegawai_nama',
                                'value' => null,
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . Yii::app()->createUrl('autoPasienPegawai') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ){
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(\'#FAInformasipenjualanresepV_pegawai_id\').val(ui.item.value);
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    //'readonly'=>$edit,
                                    'placeholder' => 'Nama Pegawai',
                                    'size' => 13,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDokter',
                            ),
                            )); ?>
                                
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Dokter Resep', 'nama_dokter', array('class' => 'control-label')); ?>
                            <div class="controls">

                            <?php $this->widget('MyJuiAutoComplete', array(
                                'name' => 'dokter_nama',
                                'value' => null,
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . Yii::app()->createUrl('autoPasienPegawai') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ){
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(\'#FAInformasipenjualanresepV_pegawai_id\').val(ui.item.value);
                                        $(this).val(ui.item.label);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    //'readonly'=>$edit,
                                    'placeholder' => 'Nama Pegawai',
                                    'size' => 13,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDokter2',
                            ),
                            )); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-default',
                            'title' => 'Ulang',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiPenjualanPegawai', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjualan Obat untuk Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    Yii::app()->clientScript->registerScript('cariPasien', "
                                $('#search').submit(function(){
                                    $.fn.yiiGridView.update('informasipenjualankaryawan-grid', {
                                        data: $(this).serialize()
                                    });
                                    return false;
                                });
                                ");
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasipenjualankaryawan-grid',
                        'dataProvider' => $modInfoPenjualan->searchInfoJualKaryawan(),
                        //        'filter'=>$modInfo,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tanggal Penjualan/<br>Tanggal Resep',
                                'type' => 'raw',
                                'value' => '$data->tglpenjualan." / ".$data->tglresep',
                            ),
                            array(
                                'header' => 'No. Resep',
                                'type' => 'raw',
                                'value' => '$data->noresep',
                            ),
                            array(
                                'header' => 'Jenis Penjualan',
                                'type' => 'raw',
                                'value' => '$data->jenispenjualan',
                            ),
                            array(
                                'header' => 'Nama Pegawai',
                                'type' => 'raw',
                                'value' => '$data->getNamaPegawai($data->pasienpegawai_id)',
                            ),
                            array(
                                'header' => 'Nama Dokter Resep',
                                'type' => 'raw',
                                'value' => '(isset($data->NamaDokter) ? $data->NamaDokter : "-")',
                            ),
                            array(
                                'header' => 'Umur/<br>Jenis Kelamin',
                                'type' => 'raw',
                                'value' => '"$data->umur"."<br>"."$data->jeniskelamin"',
                            ),
                            array(
                                'header' => 'Status Obat',
                                'type' => 'raw',
                                'value' => '$data->getStatusObat($data->statusobat,$data->penjualanresep_id)',
                                'htmlOptions' => array('style' => 'text-align:center;')
                            ),
                            array(
                                'header' => 'Etiket',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $racikan = ObatalkespasienT::model()->findByAttributes(array(
                                        'penjualanresep_id' => $data->penjualanresep_id,
                                        'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                                    ));
                                    $nonRacikan = ObatalkespasienT::model()->findByAttributes(array(
                                        'penjualanresep_id' => $data->penjualanresep_id,
                                        'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                                    ));
                                    $str = array();
                                    if (!empty($racikan)) {
                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br>Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                                            'penjualanresep_id' => $data->penjualanresep_id, 
                                            'racikan' => Params::RACIKAN_ID_RACIKAN
                                        )), array(
                                            'target' => 'frameEtiket',
                                            'onclick' => "$('#dialogEtiket').dialog('open');"
                                        ));
                                    }
                                    if (!empty($nonRacikan)) {
                                        $str[] = CHtml::link('<i class="icon-form-print"></i><br>Non Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                                            'penjualanresep_id' => $data->penjualanresep_id, 
                                            'racikan' => Params::RACIKAN_ID_NONRACIKAN
                                        )), array(
                                            'target' => 'frameEtiket',
                                            'onclick' => "$('#dialogEtiket').dialog('open');"
                                        ));
                                    }
                                    return implode("<br>", $str);
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width:60px')
                            ),
                            array(
                                'name' => 'Penyerahan Obat',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $oa = ObatalkespasienT::model()->findByAttributes(array(
                                        'penjualanresep_id' => $data->penjualanresep_id,
                                    ), array(
                                        'condition' => 'oasudahbayar_id is null',
                                    ));
                                    if (!empty($oa)) {
                                        return 'BELUM LUNAS';
                                    } else if (!empty($data->tglpenyerahan)) {
                                        return "Penyerahan Obat Tgl " . $data->tglpenyerahan;
                                    } else {
                                        return CHtml::Link("<i class=\"icon-form-verifikasi\"></i>", Yii::app()->controller->createUrl("InformasiResepPasien/ambilObat", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1, "popup" => "true")), array(
                                            "class" => "",
                                            "target" => "iframeAmbilObat",
                                            "onclick" => "$(\"#dialogAmbilObat\").dialog(\"open\");",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Penyerahan Obat",
                                        ));
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width:60px')
                            ),
                            array(
                                'header' => 'Ubah',
                                'type' => 'raw',
                                'value' => '(!empty($data->nomorResepSudahBayar) ? "<p style=\"margin: 0; text-align: center;\">-</p>" : CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->controller->createUrl(("InformasiPenjualanKaryawan/ubahPenjualanResep"),array("penjualanresep_id"=>$data->penjualanresep_id)),
                                            array("class"=>"", 
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk lihat ubah penjualan",
                                            )))',
                            ),
                            array(
                                'header' => 'Detail Penjualan',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("PenjualanKaryawan/print",array("penjualanresep_id"=>$data->penjualanresep_id,"frame"=>1)),
                                            array("class"=>"", 
                                                "target"=>"iframePenjualanResep",
                                                "onclick"=>"$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk lihat detail penjualan",
                                            ))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Batal / Retur Penjualan',
                                'type' => 'raw',
                                'value' => '(!empty($data->returresep_id)) ? $data->getStatusPenjualan($data->alasanretur) : 
                                            (!empty($data->nomorResepSudahBayar) ? 
                                            "Sudah Lunas": 
                                            CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0);",
                                            array("class"=>"", 
                                                "onclick"=>"cekHakBatal(".$data->penjualanresep_id.");return false;",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk Batal Penjualan Resep",
                                            ))."&nbsp;&nbsp;".CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
                                            array("class"=>"", 
                                                "target"=>"iframeReturPenjualan",
                                                "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk Retur Penjualan",
                                            )))',
                                'htmlOptions' => array('style' => 'text-align: left; width:80px'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogEtiket',
    'options' => array(
        'title' => 'Etiket',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameEtiket' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Detail Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePenjualanResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>

<?php
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCopyResep',
    'options' => array(
        'title' => 'Salin Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeCopyResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end Copy Resep dialog =============================
?>
<!--/div-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'logindialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => true,
    ),
));
?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'loginform')); ?>
<div class="control-group">
    <?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo CHtml::hiddenField('penjualanresep_id', '', array()); ?>
        <?php echo CHtml::hiddenField('untukaction', '', array()); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Kata Kunci', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'submitLogin();return false;', 'onkeypress' => 'submitLogin();return false;'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#logindialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk ambil Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAmbilObat',
    'options' => array(
        'title' => 'Penyerahan Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualankaryawan-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="iframeAmbilObat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end ambil Obat =============================
?>
<?php
// Dialog buat lihat Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturPenjualan',
    'options' => array(
        'title' => 'Retur Penjualan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
        'before'
    ),
));
?>
<iframe src="" name="iframeReturPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end lihat Retur Penjualan Dialog =============================
?>
<?php
// Dialog buat retur penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPrintPenjualan',
    'options' => array(
        'title' => 'Print Struk',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 700,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('infopenjualanapotik-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeReturResep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end retur penjualan resep dialog =============================
?>


<!--============================== Widget Dialog Dokter 1 ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokterPegawai = new DokterV;
$modDokterPegawai->unsetAttributes();
$modDokterPegawai->pegawai_aktif = true;

if (isset($_GET['DokterV'])) {
    $modDokterPegawai->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'adiagnosa-grid',
    'dataProvider' => $modDokterPegawai->searchAllDokter(),
    'filter' => $modDokterPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit",
                                        "onClick" => "\$(\"#FAInformasipenjualanresepV_pasienpegawai_id\").val($data->pegawai_id);
                                                              \$(\"#pasienpegawai_nama\").val(\"$data->namaLengkap\");
                                                              \$(\"#dialogDokter\").dialog(\"close\");"
                                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $jabatan = '-';

                if(!empty($data->jabatan_id)) {

                    $jb = JabatanM::model()->findByPk($data->jabatan_id);
                    $jabatan = $jb->jabatan_nama;

                }

                return $jabatan;
            },
            'filter' => CHtml::activeDropDownList($modDokterPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),

        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog Dokter 1 ====================================-->



<!--============================== Widget Dialog Dokter 2 ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter2',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDokterPegawai = new DokterV;
$modDokterPegawai->unsetAttributes();
$modDokterPegawai->pegawai_aktif = true;

if (isset($_GET['DokterV'])) {
    $modDokterPegawai->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'adiagnosa2-grid',
    'dataProvider' => $modDokterPegawai->searchAllDokter(),
    'filter' => $modDokterPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectKasuspenyakit2",
                                        "onClick" => "\$(\"#FAInformasipenjualanresepV_pegawai_id\").val($data->pegawai_id);
                                                              \$(\"#dokter_nama\").val(\"$data->namaLengkap\");
                                                              \$(\"#dialogDokter2\").dialog(\"close\");"
                                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $jabatan = '-';

                if(!empty($data->jabatan_id)) {

                    $jb = JabatanM::model()->findByPk($data->jabatan_id);
                    $jabatan = $jb->jabatan_nama;

                }

                return $jabatan;
            },
            'filter' => CHtml::activeDropDownList($modDokterPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),

        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<!--============================== endWidget Dialog Dokter 2 ====================================-->


<?php $this->renderPartial($this->path_view . "_jsFunctionsIndex"); ?>
<script type="text/javascript">
    function printEtiket(penjualanresep_id, racikan) {
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiket'); ?>&racikan=' + (racikan ? 1 : 0) + '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function setStatusObat(obj, status, penjualanresep_id) {
        if (status == 'BELUM') {
            window.parent.myConfirm('Apakah obat akan dipersiapkan?', 'Perhatian!', function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ubahStatusObat'); ?>', {
                        status: status,
                        penjualanresep_id: penjualanresep_id
                    }, function(data) {
                        if (data.pesan == 'ok') {
                            $.fn.yiiGridView.update('informasipenjualankaryawan-grid');
                        }
                    }, 'json');
                }
            });
        } else {
            window.parent.myConfirm('Apakah obat sudah dipersiapkan?', 'Perhatian!', function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ubahStatusObat'); ?>', {
                        status: status,
                        penjualanresep_id: penjualanresep_id
                    }, function(data) {
                        if (data.pesan == 'ok') {
                            $.fn.yiiGridView.update('informasipenjualankaryawan-grid');
                        }
                    }, 'json');
                }
            });
        }
        return false;
    }
</script>