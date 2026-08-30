<?php
/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai view detail nama pendonor
 * RSST-1498
 */
?>

<div class="panel panel-success">
    <!--<span class="group-title">
        Data Pendonor
    </span>-->
    <div class="panel-heading">
        <div class="panel-title">
            Data Pendonor
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-5">
            <div class="control-group">
                <label class="control-label">No. Formulir</label>
                <div class="controls">
                    <?php
                    echo $form->hiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly' => true));
                    echo $form->hiddenField($modDaftarDonasi, 'pendonor_id', array('readonly' => true));
                    echo $form->hiddenField($modDaftarDonasi, 'observasipendonor_id', array('readonly' => true));

                    if (empty($modDaftarDonasi->daftardonasi_id)) {
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modDaftarDonasi,
                            'attribute' => 'no_formulir',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/GetDaftarPendonorLulusSeleksi'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);

                                                return false;
                                            }',
                                'select' => 'js:function( event, ui ) {                                                  
                                                    setDaftarDonasi(ui.item);
                                                    return false;
                                                  }',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'No Formulir',
                                'size' => 20,
                                'class' => 'span3 angkahuruf-only',
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modDaftarDonasi, 'pendaftaran_id') . '").val(""); ',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDaftarDonasi', 'idTombol' => 'tombolDaftarDonasi'),
                        ));
                    } else {
                        echo $form->textField($modDaftarDonasi, 'no_formulir', array('placeholder' => 'No Formulir', 'readonly' => true));
                    }
                    ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("No. Registrasi", 'no_pendonor', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($modPendonor, 'no_pendonor', array('readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nama Lengkap</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'nama_lengkap', array('placeholder' => 'Nama Lengkap', 'readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tanggal Lahir</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'tgllahir', array('placeholder' => 'Tanggal Lahir', 'readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Umur</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'umur', array('placeholder' => 'Umur', 'readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Jenis Kelamin</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'jenis_kelamin', array('placeholder' => 'Jenis Kelamin', 'readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="control-group">
                <label class="control-label">Agama</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'agama', array('placeholder' => 'Agama', 'readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'statusperkawinan', array('placeholder' => 'Status Perkawinan', 'readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Golongan Darah</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'gol_darah', array('placeholder' => 'Golongan Darah', 'readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Rhesus</label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'rhesus', array('placeholder' => 'Rhesus', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Riwayat Donor Terakhir </label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'waktu_observasi', array('placeholder' => 'Riwayat Donor Terakhir', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> Berat Badan </label>
                <div class="controls">
                    <?php echo $form->textField($modPendonor, 'beratbadan_kg', array('placeholder' => 'Berat Badan', 'readonly' => true)); ?> <label> Kg </label>
                </div>
            </div>
        </div>

        <div class = "col-sm-2">
            <?php $url_photopasien = (!empty($modPendonor->photopendonor) ? Params::urlPendonorDirectory() . $modPendonor->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="184px"/>     
        </div>
    </div>
</div>
<div class="clear"></div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarDonasi',
    'options' => array(
        'title' => 'Daftar Pendonor yang Lolos Seleksi',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
    ),
));

$modDaftar = new BDDaftardonasiT();

if (isset($_GET['BDDaftardonasiT'])) {
    $modDaftar->attributes = $_GET['BDDaftardonasiT'];
    $modDaftar->nama_lengkap = isset($_GET['BDDaftardonasiT']['nama_lengkap']) ? $_GET['BDDaftardonasiT']['nama_lengkap'] : null;
    $modDaftar->no_pendonor = isset($_GET['BDDaftardonasiT']['no_pendonor']) ? $_GET['BDDaftardonasiT']['no_pendonor'] : null;
    $modDaftar->gol_darah = isset($_GET['BDDaftardonasiT']['gol_darah']) ? $_GET['BDDaftardonasiT']['gol_darah'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftardonasi-t-grid',
    'dataProvider' => $modDaftar->searchDataPendonorDariSeleksi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'filter' => $modDaftar,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {

                $seleksi = BDSeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $data->daftardonasi_id));
                $kan = BDKantongdarahT::model()->findByAttributes(array('daftarpendonor_id' => $data->daftardonasi_id));
                $kantong['nama_jenis'] = !empty($kan)?$kan->jeniskantongdarah->nama_jenis:'';
                $kantong['nomorbarcode_utama'] = !empty($kan)?$kan->nomorbarcode_utama:'';
                $kantong['nomorbarcode_sample'] = !empty($kan)?$kan->nomorbarcode_sample:'';
                $res = array(
                    'daftar' => $data->attributes,
                    'pendonor' => $data->pendonor->attributes,
                    'seleksi' => $seleksi->attributes,
                    'kantong' => $kantong
                );

                if(!empty($data->ruangrekrutmen)) {
                    $res['daftar']['ruangrekrutmen_nama'] = $data->ruangrekrutmen->ruangan_nama;
                } else {
                    $res['daftar']['ruangrekrutmen_nama'] = $data->lokasi_rekruitmen;
                }

                $res['pendonor']['umur'] = CustomFunction::getUmur($data->pendonor->tgllahir);
                $res['pendonor']['tgllahir'] = !empty($data->pendonor->tgllahir) ? MyFormatter::formatDateTimeForUser($data->pendonor->tgllahir) : null;

                $res['seleksi']['dokter_nama'] = !empty($seleksi->dokter->namaLengkap) ? $seleksi->dokter->namaLengkap : null;
                $res['seleksi']['petugas_nama'] = !empty($seleksi->petugas->namaLengkap) ? $seleksi->petugas->namaLengkap : null;

                $res['seleksi']['cek'] = !empty($seleksi) ? 'ada' : 'tidakada';
                $criteria = new CDbCriteria();
                $criteria->select = "pendonor_id, max(observasipendonor_id), date(waktu_observasi) as waktu_observasi";
                $criteria->addCondition('pendonor_id =' . $data->pendonor_id);
                $criteria->order = 'observasipendonor_id DESC';
                $criteria->group = 'observasipendonor_id, waktu_observasi, pendonor_id';
                $modObservasi = ObservasipendonorT::model()->find($criteria);
                if (!empty($modObservasi)) {
                    $res['pendonor']['waktu_observasi'] = !empty($modObservasi->pendonor_id) ? MyFormatter::formatDateTimeForUser($modObservasi->waktu_observasi) : '-';
                } else {
                    $res['pendonor']['waktu_observasi'] = '-';
                }
                $res = CJSON::encode($res);

                return CHtml::link('<span style="font-size:20px;"><i class="' . MyIcon::getIcons('tambah') . '"></i></span>', 'javascript:;', array(
                            'onclick' => 'setDaftarDonasi(' . $res . ',"dialog");'
                            . '$("#dialogDaftarDonasi").dialog("close"); return false;',
                ));
            }
        ),
        'no_formulir',
        'no_pendonor',
        array(
            'header' => 'Pendonor',
            'name' => 'nama_lengkap',
            'value' => '$data->nama_lengkap'
        ),
        array(
            'header' => 'Golongan Darah',
            'name' => 'gol_darah',
            'value' => function($data) {
                return $data->gol_darah . ', Rhesus ' . $data->rhesus;
            },
            'filter' => CHtml::activeDropDownList($modDaftar, 'gol_darah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>