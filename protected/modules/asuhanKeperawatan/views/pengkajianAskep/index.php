<?php $linkHalaman = CustomFunction::getUrlByMenuID(3571); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengkajian Keperawatan</b> <?= isset($_GET['status']) ? CHtml::link("<b>Lanjut ke Diagnosa Keperawatan</b>", $this->createUrl('diagnosisKeperawatan/index', ['pengkajianaskep_id' => $modPengkajian->pengkajianaskep_id]), ['class' => 'btn btn-info', 'style' => 'color:#fff;']) : ''; ?>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Pengkajian Keperawatan',
        );
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#ASPendaftaranT_no_pendaftaran',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return cekRequired();'
                // 'onsubmit'=>'return cekOtorisasi();'
            ),
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_ringkasDataPasien', array('modPengkajian' => $modPengkajian, 'modInfoPengkajian' => $modInfoPengkajian, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'penanggungjawab',
            'content' => array(
                'content-penanggungjawab' => array(
                    'header' => '<b>Penanggung Jawab Pasien</b>',
                    'isi' => $this->renderPartial($this->path_view . '_penanggungJawab', array(
                        'form' => $form,
                        'modPenanggungJawab' => $modPenanggungJawab,
                    ), true),
                    'active' => false,
                ),
            ),
        ));
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'anemnesa',
            'content' => array(
                'content-anemnesa' => array(
                    'header' => '<b>Riwayat Anamnesis</b>',
                    'isi' => '
                                        <table class="table table-striped table-condensed table-bordered">
                                            <thead>
												<th>Pilih</th>
                                                <th>Tgl. Anamnesis</th>
                                                <th>Keluhan Utama</th>
                                                <th>Keluhan Tambahan</th>
                                                <th>Riwayat Penyakit Terdahulu</th>
                                                <th>Riwayat Penyakit Keluarga</th>
                                                <th>Riwayat Imunisasi</th>
												<th>Riwayat Alergi Obat</th>
												<th>Riwayat Makanan</th>
												<th></th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=10>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
                    'active' => false,
                ),
            ),
        ));
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'periksafisik',
            'content' => array(
                'content-periksafisik' => array(
                    'header' => '<b>Riwayat Pemeriksaan Fisik</b>',
                    'isi' => '
                                        <table class="table table-striped table-condensed table-bordered">
                                            <thead>
												<th>Pilih</th>
                                                <th>Tgl. Periksa Fisik</th>
                                                <th>Keadaan Umum</th>
                                                <th>Berat Badan (Kg)</th>
                                                <th>Tinggi Badan (cm)</th>
                                                <th>Tekanan Darah</th>
                                                <th>Detak Nadi</th>
												<th>Suhu Tubuh</th>
												<th>Pernapasan</th>
												<th>Kesadaran / GCS (Eye / Verbal / Motorik)</th>
												<th>Kelainan Pada Bag. Tubuh</th>
												<th></th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=12>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
                    'active' => false,
                ),
            ),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengkajian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
            </div>
        </div>
        <?php
        //	$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        //		'id' => 'pengkajian-askep-t',
        //		'content' => array(
        //			'content-pengkajian-askep-t' => array(
        //				'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Data Pengkajian Keperawatan')) . '<b> Data Pengkajian Keperawatan</b>',
        //				'isi' => $this->renderPartial($this->path_view . '_formPengkajian', array(
        //					'form' => $form,
        //					'modPengkajian' => $modPengkajian,
        //						), true),
        //				'active' => false,
        //			),
        //		),
        //	));
        //	
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penunjang</b>
                </div>
            </div>
            <div class="panel-body">
                <table id="table-penunjang" class="table table-striped table-bordered table-condensed">
                    <thead>
                        <th>Tanggal</th>
                        <th>Data Penunjang</th>
                        <th>Hasil Pemeriksaan</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if ($modPengkajian->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger',
                        'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'disabled' => true
                    )
                );
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/pengkajianAskep/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            /*
		  echo CHtml::htmlButton(
		  Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
		  array(
		  'class'=>'btn btn-danger',
		  'type'=>'reset'
		  )
		  );
		 * 
		 */
            ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            Yii::app()->clientScript->registerScript('print', '
    function print(caraPrint)
    {
        window.open("' . $urlPrint . '/&pengkajianaskep_id=' . $modPengkajian->pengkajianaskep_id . '&caraPrint="+caraPrint,"","location=_new, width=900px, scrollbars=yes");
    }
', CClientScript::POS_END); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->renderPartial('_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'modPenanggungJawab' => $modPenanggungJawab,
    'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
    'modRiwayatPeriksaFisik' => $modRiwayatPeriksaFisik,
    'modPengkajian' => $modPengkajian,
    'modPenunjang' => $modPenunjang,
    'form' => $form
));
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailAnamnesis',
    'options' => array(
        'title' => 'Detail Riwayat Anamnesis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetailAnamnesis" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailFisik',
    'options' => array(
        'title' => 'Detail Riwayat Pemeriksaan Fisik',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetailFisik" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPK',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="framePK" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget();
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPA',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="framePA" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRad',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemeriksaan Radiologi',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frameRad" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>