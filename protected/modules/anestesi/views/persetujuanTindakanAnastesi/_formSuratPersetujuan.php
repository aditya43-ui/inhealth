<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
    table#persetujuan {

        text-align: center;
    }
</style>
<h3><center>PERSETUJUAN TINDAKAN ANASTESI</center></h3>
<br><br>
<p align="justify">
    Setelah mendapat informasi mengenai tindakan anatesi/sedasi, maka yang bertanda tangan di bawah ini :
</p>
<table width="100%" style="width:500px;">
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>
            <?php echo CHtml::activeTextField($model, 'namapenanggungjawab', array('class' => 'span3', 'onkeyup' => '$("#ATPersetujuananestesiT_nama_pembuatpernyataan").val($(this).val())')) ?>
        </td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td>
            <?php echo CHtml::activeTextField($model, 'umurpenanggungjawab', array('class' => 'span3 integer', 'maxlength' => 2)) ?>
        </td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>
            <?php echo CHtml::activeRadioButtonList($model, 'jeniskelamin_penanggungjawab', LookupM::getItems('jeniskelamin'), array('inline' => true)) ?>
        </td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>
            <?php echo CHtml::activeTextField($model, 'alamat_penanggungjawab', array('class' => 'span3')) ?>
        </td>
    </tr>
    <tr>
        <td>No. Kartu Identitas</td>
        <td>:</td>
        <td>
            <?php echo CHtml::activeDropDownList($model, 'jenisidentitas_penanggungjawab', array('KTP' => 'KTP', 'SIM' => 'SIM'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')) ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>
            <?php echo CHtml::activeTextField($model, 'noidentitas_penanggungjawab', array('class' => 'span3 numbers-only', 'maxlength' => 16, 'onkeyup' => '$("#ATPersetujuananestesiT_identitas_pembuatpernyataan").val($(this).val())')) ?>
        </td>
    </tr>
</table>
<br>
<p align="justify">
    Menyatakan PERSETUJUAN untuk dilakukan tindakan anatesi berupa :
</p>
<table>
    <tr>
        <td>
            <?php echo CHtml::activeRadioButton($model, 'jnsanestesi_sedasiberatsedang', array('class' => 'jnsanestesi', 'onclick' => 'CekJenisAnestesi(this, "sedasiberatsedang");', 'uncheckValue' => null)) ?>
        </td>
        <td><label><b>&nbsp;&nbsp;Sedasi Sedang dan Berat</b></label></td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeRadioButton($model, 'jnsanestesi_umum', array('class' => 'jnsanestesi', 'onclick' => 'CekJenisAnestesi(this, "umum");', 'uncheckValue' => null)) ?>
        </td>
        <td><label><b>&nbsp;&nbsp;Anesti Umum</b></label></td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional', $model->jnsanestesi_regional, array('class' => 'jnsanestesi', 'uncheckValue' => null, 'onclick' => 'CekJenisAnestesi(this, "regional");')) ?>
        </td>
        <td><label><b>&nbsp;&nbsp;Anesti Regional</b></label></td>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional_sedasi', $model->jnsanestesi_regional_sedasi, array('class' => 'regional', 'uncheckValue' => null, 'onclick' => 'CekJenisRegional(this);')) ?>
            <label>Sedasi</label>&nbsp;&nbsp;
        </td>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional_tnpsedasi', $model->jnsanestesi_regional_tnpsedasi, array('class' => 'regional', 'uncheckValue' => null, 'onclick' => 'CekJenisRegional(this);')) ?>
            <label>Tanpa Sedasi</label>&nbsp;&nbsp;
        </td>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional_sab', $model->jnsanestesi_regional_sab, array('class' => 'regional', 'uncheckValue' => null, 'onclick' => 'CekJenisRegional(this);')) ?>
            <label>SAB</label>&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional_epidural', $model->jnsanestesi_regional_epidural, array('class' => 'regional', 'uncheckValue' => null, 'onclick' => 'CekJenisRegional(this);')) ?>
            <label>Epidural</label>&nbsp;&nbsp;
        </td>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional_blokperifer', $model->jnsanestesi_regional_blokperifer, array('class' => 'regional', 'uncheckValue' => null, 'onclick' => 'CekJenisRegional(this);')) ?>
            <label>Block Perifer</label>&nbsp;&nbsp;
        </td>
        <td>
            <?php echo CHtml::radioButton('jnsanestesi_regional_kombinasi', $model->jnsanestesi_regional_kombinasi, array('class' => 'regional', 'uncheckValue' => null, 'onclick' => 'CekJenisRegional(this);')) ?>
            <label>Kombinasi</label>&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeRadioButton($model, 'jnsanestesi_kombinasi', array('class' => 'jnsanestesi', 'onclick' => 'CekJenisAnestesi(this, "kombinasi");', 'uncheckValue' => null)) ?>
        </td>
        <td><label><b>&nbsp;&nbsp;Anesti Kombinasi</b></label></td>
    </tr>
</table>
<br>
<p align="justify">
    Terhadap Pasien :
</p>
<table cellpadding="10">
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= $modPasien->nama_pasien ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?= !empty($modPasien->tempat_lahir) ? $modPasien->tempat_lahir : '-' ?>, <?= !empty($modPasien->tanggal_lahir) ? $format->formatDateTimeForUser($modPasien->tanggal_lahir) : '' ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?= $modPasien->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td>Diagnosis</td>
        <td>:</td>
        <td><?php echo $form->hiddenField($model, 'diagnosa_id', array('readonly' => true)); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'diagnosa_nama',
                'value' => $diagnosa,
                'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteDiagnosa') . '",
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
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                    'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id); 
                                    return false;
                                }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik Nama Diagnosa',
                    'class' => 'span3',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'diagnosa_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
            ));
            ?>
        </td>
    </tr>
    <tr>
        <td>Tindakan</td>
        <td>:</td>
        <td><?php echo CHtml::activeTextField($model, 'tindakan', array('class' => 'span3 ')) ?></td>
    </tr>
</table>
<br>
<p align="justify">
    Saya menyatakan dengan sesungguhnya dan tanpa aksaan bahwa :
</p>
<p align="justify">
    1. Saya telah membaca penjelasan secara teliti tentang tindakan yang diberikan, mengerti dan menyetujui 
    penjelasan tentang tindakan yang akan dilakukan termasuk kemungkinan komplikasi yang mungkin terjadi serta 
    kelebihan atau kelemahan dari setiap jenis pilihan pembiusan yang dapat dilakukan, serta telah diberikan kesempatan 
    untuk bertanya dan berdiskusi dengan dokter
</p>
<p align="justify">
    2. Saya menyadari bahwa pelayanan di rumah sakit ini merupakan suatu kerja team (termasuk dokter dan perawat anestesi) 
    dan bahwasanya anestesi untuk tindakan operasi ini akan dilakukan di bawah pengawasan dokter 
    <?php
    $this->widget('MyJuiAutoComplete', array(
        'name' => 'dokteranestesi_nama',
        'value' => $model->dokteranestesi_nama,
        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteDokter') . '",
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
            'minLength' => 3,
            'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
            'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($model, 'dokteranestesi_id') . '").val(ui.item.pegawai_id); 
                                    $("#dokteranestesi_nama2").val(ui.item.nama_pegawai); 
                                    return false;
                                }',
        ),
        'htmlOptions' => array(
            'placeholder' => 'Ketik Nama Dokter',
            'class' => 'span3 required',
            'onkeyup' => "return $(this).focusNextInputField(event)",
            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'dokteranestesi_id') . '").val(""); '
        ),
        'tombolDialog' => array('idDialog' => 'dialogDokter'),
    ));
    echo CHtml::activeHiddenField($model, 'dokteranestesi_id', array('readonly' => true,'class'=>'required'));
    ?>
</p>
<p align="justify">
    3. Saya mengerti bahwa tindakan anestesi mengandung beberapa risiko, termasuk perubahan tekanan darah, reaksi obat (alergi), 
    henti jantung, kerusakan otak, kelumpuhan, kerusakan saraf serta kompilasi lain yang juga mungkin terjadi, bahkan kematian.
</p>
<p align="justify">
    4. Saya menyadari dan mengerti bahwa ilmu kedokteran (termasuk anestesi) bukan merupakan ilmu pengetahuan yang pasti dalam praktiknya, 
    sehingga tidak ada seorang pun yang dapat menjanjikan atau menjamin sesuatu yang berhubungan dengan praktik ilmu kedokteran (termasuk anestesi).
</p>
<p align="justify">
    5. Saya mempunyai kewajiban untuk memberikan kepada dokter mengenai semua penyakit dan obat yang saya/pasien minum seperti aspirin, pengencer darah, 
    kontrasepsi, obat-obat flu, narkotika, marijuana, kokain dan lain-lain, mengingat hal-hal tersebut dapat menimbulkan kompilasi bagi anestesi maupun pembedahan.
</p>
<p align="justify">
    Berdasrkan hal-hal tersebut di atas, saya menjamin sepenuhnya bahwa tindakan saya untuk menyetujui tindakan anestesi di atas adalah untuk mewakili kepentingan saya/pasien 
    dan keluarga pasien, dan saya bertanggung jawab sepenuhnya apabila terdapat pihak lain yang mengajukan keberatan atas persetujuan ini.
</p>
<p align="justify">
    Demikian surat persetujuan ini dibuat dengan penuh kesadaran dan tanpa paksaan dari pihak manapun juga.
</p>
<table width="100%" id="persetujuan">
    <tr>
        <td style="width:165px !important"></td>
        <td style="width:265px !important">Surabaya, <?= date(' d M Y') ?></td>
        <td></td>
        <td></td>
        <td style="width:265px !important"></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Yang membuat pernyataan,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak Keluarga,</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::activeDropDownList($model, 'hubungan_pembuatpernyataan', LookupM::getItems('hubungankeluarga'), array('empty' => 'Hubungan Keluarga', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')) ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::activeTextField($model, 'nama_pembuatpernyataan', array('class' => 'span3', 'placeholder' => 'Nama', 'readonly' => true)) ?></td>
        <td></td>
        <td></td>
        <td><?php echo CHtml::activeTextField($model, 'nama_pihakkeluarga', array('class' => 'span3', 'placeholder' => 'Nama')) ?></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: right">No. KTP/SIM</td>
        <td><?php echo CHtml::activeTextField($model, 'identitas_pembuatpernyataan', array('class' => 'span3', 'placeholder' => 'No. KTP/SIM', 'maxlength' => 16, 'readonly' => true)) ?></td>
        <td></td>
        <td style="text-align: right">No. KTP/SIM</td>
        <td><?php echo CHtml::activeTextField($model, 'noidentitas', array('class' => 'span3', 'placeholder' => 'No. KTP/SIM', 'maxlength' => 16)) ?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Dokter,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak RS,</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokteranestesi_nama2',
                'value' => $model->dokteranestesi_nama2,
                'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteDokter') . '",
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
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                    'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($model, 'dokteranestesi_id') . '").val(ui.item.pegawai_id); 
                                    $("#dokteranestesi_nama").val(ui.item.nama_pegawai); 
                                    return false;
                                }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik Nama Dokter',
                    'class' => 'span3',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'dokteranestesi_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogDokter'),
            ));
            ?>
        </td>
        <td></td>
        <td></td>
        <td>
            <?php
            echo CHtml::activeHiddenField($model, 'saksipihakrs_id', array('readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'saksipihakrs_nama',
                'value' => $model->saksipihakrs_nama,
                'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteSaksi') . '",
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
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                    'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($model, 'saksipihakrs_id') . '").val(ui.item.pegawai_id); 
                                    return false;
                                }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik Nama Pegawai',
                    'class' => 'span3',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'saksipihakrs_id') . '").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
            ));
            ?>
        </td>
        <td></td>
    </tr>
</table>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modDiagnosa = new DiagnosaM('search');
$modDiagnosa->unsetAttributes();
//$modDiagnosa->kelompokdiagnosa_id = 2;
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'diagnosa_id') . '\").val(\"$data->diagnosa_id\");
                                                  $(\"#diagnosa_nama\").val(\"$data->diagnosa_nama\");
                                                  $(\"#dialogDiagnosa\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'Nama Diagnosa',
            'filter' => CHtml::activeTextField($modDiagnosa, 'diagnosa_nama'),
            'value' => '$data->diagnosa_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();

//Dialog DOkter
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modDokter = new PegawairuanganV('searchDokter');
$modDokter->unsetAttributes();
if (isset($_GET['PegawairuanganV'])){
    $modDokter->attributes = $_GET['PegawairuanganV'];
}
$modDokter->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-grid',
    'dataProvider' => $modDokter->searchDialogPegRuangan(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'dokteranestesi_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#dokteranestesi_nama\").val(\"$data->namaLengkap\");
                                                  $(\"#dokteranestesi_nama2\").val(\"$data->namaLengkap\");
                                                  $(\"#dialogDokter\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modDokter, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modDokter, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $hasil = '';
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    $hasil = $j->jabatan_nama;
                }
                return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();


//Dialog Pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modDokter = new PegawairuanganV('searchDialogPegRuangan');
$modDokter->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modDokter->attributes = $_GET['PegawairuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $modDokter->searchDialogPegRuangan(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'saksipihakrs_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#saksipihakrs_nama\").val(\"$data->namaLengkap\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modDokter, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modDokter, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $hasil = '';
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    $hasil = $j->jabatan_nama;
                }
                return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>