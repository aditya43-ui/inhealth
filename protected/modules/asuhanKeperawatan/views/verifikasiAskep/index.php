<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Verifikasi Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pembayaran',
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
                'onsubmit' => 'return requiredCheck(this);'
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
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengkajian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_ringkasDataPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>

        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'penanggungjawab',
            'content' => array(
                'content-penanggungjawab' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Penanggung Jawab Pasien')) . '<b> Penanggung Jawab Pasien</b>',
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
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Riwayat Anamnesis')) . '<b> Riwayat Anamnesis</b>',
                    'isi' => '
                                        <table class="table table-striped table-condensed table-bordered">
                                            <thead>
                                                <th>Tgl. Anamnesis</th>
                                                <th>Keluhan Utama</th>
                                                <th>Keluhan Tambahan</th>
                                                <th>Riwayat Penyakit Terdahulu</th>
                                                <th>Riwayat Penyakit Keluarga</th>
                                                <th>Riwayat Imunisasi</th>
												<th>Riwayat Alergi Obat</th>
												<th>Riwayat Makanan</th>
												<th>Detail</th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=9>Data tidak ditemukan</td></tr>
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
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Riwayat Pemeriksaan Fisik')) . '<b> Riwayat Pemeriksaan Fisik</b>',
                    'isi' => '
                                        <table class="table table-striped table-condensed table-bordered">
                                            <thead>
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
												<th>Detail</th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=11>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
                    'active' => false,
                ),
            ),
        ));
        ?>

        <?php
        /*
	$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
		'id' => 'pengkajian-askep-t',
		'content' => array(
			'content-pengkajian-askep-t' => array(
				'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Data Pengkajian Keperawatan')) . '<b> Pengkajian Keperawatan</b>',
				'isi' => '',
				'active' => false,
			),
		),
	));
         */
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'rencana-askep-t',
            'content' => array(
                'content-rencana-askep-t' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Data Rencana Keperawatan')) . '<b> Rencana Keperawatan</b>',
                    'isi' => '',
                    'active' => false,
                ),
            ),
        ));
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'implementasi-askep-t',
            'content' => array(
                'content-implementasi-askep-t' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Data Implementasi Keperawatan')) . '<b> Implementasi Keperawatan</b>',
                    'isi' => '',
                    'active' => false,
                ),
            ),
        ));
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'evaluasi-askep-t',
            'content' => array(
                'content-evaluasi-askep-t' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan form Data Evaluasi Keperawatan')) . '<b> Evaluasi Keperawatan</b>',
                    'isi' => '',
                    'active' => false,
                ),
            ),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-check"></i> Verifikasi Asuhan Keperawatan
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataVerifikasi', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'class' => 'btn btn-primary',
                        'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'disabled' => true,

                    )
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/verifikasiAskep/index'), array(
                'class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            ));
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

            $js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&verifikasiaskep_id="+$model->verifikasiaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiPengkajian',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawai->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->searchPerawat(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPegawai",
                            "onClick" => "
								$(\"#ASPengkajianaskepT_pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#ASPengkajianaskepT_nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawaiPengkajian\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        array(
            'header' => 'Jabatan',
            'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiRencana',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));

$modPegawaiRencana = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawaiRencana->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-rencana-grid',
    'dataProvider' => $modPegawaiRencana->searchPerawat(),
    'filter' => $modPegawaiRencana,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPegawai",
                            "onClick" => "
								$(\"#ASRencanaaskepT_pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#ASRencanaaskepT_nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawaiRencana\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modPegawaiRencana,
                    'attribute' => 'tgl_lahirpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tgl_lahirpegawai_rencana', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
        ),
        array(
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'statusperkawinan',
            'value' => '$data->statusperkawinan',
            'filter' => LookupM::model()->getItems('statusperkawinan'),
        ),
        array(
            'name' => 'jabatan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modPegawaiRencana, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif=TRUE'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tgl_lahirpegawai_rencana\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tgl_lahirpegawai_rencana_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai_rencana\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiImplementasi',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));

$modPegawaiImplementasi = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawaiImplementasi->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-implementasi-grid',
    'dataProvider' => $modPegawaiImplementasi->searchPerawat(),
    'filter' => $modPegawaiImplementasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPegawai",
                            "onClick" => "
								$(\"#ASImplementasiaskepT_pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#ASImplementasiaskepT_nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawaiImplementasi\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modPegawaiImplementasi,
                    'attribute' => 'tgl_lahirpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tgl_lahirpegawai_impl', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
        ),
        array(
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'statusperkawinan',
            'value' => '$data->statusperkawinan',
            'filter' => LookupM::model()->getItems('statusperkawinan'),
        ),
        array(
            'name' => 'jabatan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modPegawaiImplementasi, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif=TRUE'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tgl_lahirpegawai_impl\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tgl_lahirpegawai_impl_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai_impl\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiEvaluasi',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));

$modPegawaiEvaluasi = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawaiEvaluasi->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-evaluasi-grid',
    'dataProvider' => $modPegawaiEvaluasi->searchPerawat(),
    'filter' => $modPegawaiEvaluasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPegawai",
                            "onClick" => "
								$(\"#ASEvaluasiaskepT_pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#ASEvaluasiaskepT_nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawaiEvaluasi\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modPegawaiEvaluasi,
                    'attribute' => 'tgl_lahirpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tgl_lahirpegawai_ev', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
        ),
        array(
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'statusperkawinan',
            'value' => '$data->statusperkawinan',
            'filter' => LookupM::model()->getItems('statusperkawinan'),
        ),
        array(
            'name' => 'jabatan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modPegawaiEvaluasi, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif=TRUE'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tgl_lahirpegawai_ev\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tgl_lahirpegawai_ev_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai_ev\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiVerifikasi',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiVerifikasi = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawaiVerifikasi->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-verifikasi-grid',
    'dataProvider' => $modPegawaiVerifikasi->searchPerawat(),
    'filter' => $modPegawaiVerifikasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPegawai",
                            "onClick" => "
								$(\"#ASVerifikasiaskepT_petugasverifikasi_nama\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawaiVerifikasi\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modPegawaiVerifikasi,
                    'attribute' => 'tgl_lahirpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tgl_lahirpegawai_v', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
        ),
        array(
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'statusperkawinan',
            'value' => '$data->statusperkawinan',
            'filter' => LookupM::model()->getItems('statusperkawinan'),
        ),
        array(
            'name' => 'jabatan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modPegawaiVerifikasi, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif=TRUE'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tgl_lahirpegawai_v\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tgl_lahirpegawai_v_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai_v\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawaiMengetahui->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-mengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPerawat(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPegawai",
                            "onClick" => "
								$(\"#ASVerifikasiaskepT_mengetahui_nama\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawaiMengetahui\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modPegawaiMengetahui,
                    'attribute' => 'tgl_lahirpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tgl_lahirpegawai_m', 'placeholder' => '23 Jan 1993'),
                ),
                true
            ),
        ),
        array(
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
        ),
        array(
            'name' => 'statusperkawinan',
            'value' => '$data->statusperkawinan',
            'filter' => LookupM::model()->getItems('statusperkawinan'),
        ),
        array(
            'name' => 'jabatan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif=TRUE'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tgl_lahirpegawai_m\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tgl_lahirpegawai_m_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai_m\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 420,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new ASDiagnosakepM('searchDialog');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['ASDiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['ASDiagnosakepM'];
    $modDiagnosaKep->diagnosakep_aktif = $_GET['diagnosakep_aktif'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->searchDialog(),
    'filter' => $modDiagnosaKep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
									setDiagnosaAutoDialog($data->diagnosakep_id);
									"))'
        ),
        array(
            'header' => 'Kode Diagnosa',
            'name' => 'diagnosakep_kode',
            'value' => '$data->diagnosakep_kode',
        ),
        array(
            'header' => 'Diagnosa Keperawatan',
            'type' => 'raw',
            'name' => 'diagnosakep_nama',
            'value' => '$data->diagnosakep_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'diagnosakep_deskripsi',
            'value' => '$data->diagnosakep_deskripsi',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
            'filter' => CHtml::dropDownList(
                'diagnosakep_aktif',
                $modDiagnosaKep->diagnosakep_aktif,
                array(
                    '1' => 'Aktif',
                    '0' => 'Tidak Aktif',
                ),
                array('empty' => '-- Pilih --')
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengkajian Keperawatan / Kebidanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';

$this->endWidget();
?>
<?php
$this->renderPartial('_jsFunctions', array(
    'model' => $model,
    'modPengkajian' => $modPengkajian,
    'modPenunjang' => $modPenunjang,
    'modRencana' => $modRencana,
    'modRencanaDet' => $modRencanaDet,
    'modPilihRencana' => $modPilihRencana,
    'modImplementasi' => $modImplementasi,
    'modImplementasiDet' => $modImplementasiDet,
    'modPilihImpl' => $modPilihImpl,
    'modEvaluasi' => $modEvaluasi,
    'modEvaluasiDet' => $modEvaluasiDet,
    'modPendaftaran' => $modPendaftaran,
    'modPenanggungJawab' => $modPenanggungJawab,
    'modRiwayatAnemnesa' => $modRiwayatAnemnesa,
    'modPeriksaFisik' => $modPeriksaFisik,
    'modPasien' => $modPasien,
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