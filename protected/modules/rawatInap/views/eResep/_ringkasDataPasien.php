<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'no_pendaftaran', array('id' => 'fokus', 'class' => 'control-label',)); ?>
                    <div class="controls">
                        <?php // echo CHtml::activeTextField($modKunjungan, 'no_pendaftaran', array('readonly'=>true)); 
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'InfokunjunganriV[no_pendaftaran]',
                            'value' => $modKunjungan->no_pendaftaran,
                            'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('daftarPasienRawatInap') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    tipe: 1,
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
                                $(this).val(ui.item.value);
                                return false;
                            }',
                                'select' => 'js:function( event, ui ) {
                                isiDataPasien_fungsi(null, ui.item.value);
                                $("#InfokunjunganriV_no_pendaftaran").val(ui.item.no_pendaftaran);
                                return false;
                            }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Nomer Pendaftaran'),
                            'tombolDialog' => array('idDialog' => 'dialogRekamedik', 'idTombol' => 'tombolDialogRekamedik'),
                        ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeHiddenField($modKunjungan, 'nama_bin', array('readonly' => true)); ?>
                    <?php echo CHtml::activeLabel($modKunjungan, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modKunjungan, 'pendaftaran_id'); ?>
                        <?php echo CHtml::activeHiddenField($modKunjungan, 'pasien_id'); ?>
                        <?php echo CHtml::activeTextField($modKunjungan, 'tgl_pendaftaran', array('readonly' => true, 'placeholder' => 'Tanggal Pendaftaran')); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Diagnosa", 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('diagnosa', '', array('readonly' => true, 'placeholder' => 'Diagnosa')); ?>
                        <?php echo CHtml::activeHiddenField($modKunjungan, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modKunjungan, 'carabayar_id', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modKunjungan, 'kelaspelayanan_nama', array('readonly' => true, 'placeholder' => 'Kelas Pelayanan')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'cara bayar ', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modKunjungan, 'carabayar_nama', array('readonly' => true, 'placeholder' => 'Jenis Penjamin')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'penjamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modKunjungan, 'penjamin_nama', array('readonly' => true, 'placeholder' => 'Nama Penjamin')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'InfokunjunganriV[no_rekam_medik]',
                            'value' => $modKunjungan->no_rekam_medik,
                            'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('daftarPasienRawatInap') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    tipe: 2,
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
                                $(this).val(ui.item.value);
                                return false;
                            }',
                                'select' => 'js:function( event, ui ) {
                                isiDataPasien_fungsi(null, ui.item.value);
                                $("#InfokunjunganriV_no_rekam_medik").val(ui.item.no_rekam_medik);
                                return false;
                            }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required numbers-only', 'placeholder' => 'Nomer Rekam Medik'),
                            'tombolDialog' => array('idDialog' => 'dialogRekamedik', 'idTombol' => 'tombolDialogRekamedik'),
                        ));

                        ?>

                        <?php // echo CHtml::activeTextField($modKunjungan, 'no_rekam_medik', array('readonly'=>true)); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'InfokunjunganriV[nama_pasien]',
                            'value' => $modKunjungan->nama_pasien,
                            'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('daftarPasienRawatInap') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    tipe: 3,
                                },
                                success: function (data) {
                                        response(data);
                                }
                            })
                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                return false;
                            }',
                                'select' => 'js:function( event, ui ) {
                                isiDataPasien_fungsi(null, ui.item.value);
                                $("#InfokunjunganriV_nama_pasien").val(ui.item.nama_pasien);
                                return false;
                            }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Nama Pasien'),
                            'tombolDialog' => array('idDialog' => 'dialogRekamedik', 'idTombol' => 'tombolDialogRekamedik'),
                        ));

                        ?>
                        <?php // echo CHtml::activeTextField($modKunjungan, 'nama_pasien', array('readonly'=>true)); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modKunjungan, 'umur', array('readonly' => true, 'placeholder' => 'Umur')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modKunjungan, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modKunjungan, 'jeniskelamin', array('readonly' => true, 'placeholder' => 'Jenis Kelamin')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php
                        if (!empty($modKunjungan->photopasien)) {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . $modKunjungann, 'Foto pasien', array('width' => 120));
                        } else {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRekamedik',
    'options' => array(
        'title' => 'Kunjungan Pasien ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'resizable' => false,
        'width' => 900,

        'modal' => true,
    ),
));


if ($this->init_modul == 'RI') {
    $modDataPasien = new RIInfopasienmasukkamarV();
    $get = isset($_GET['RIInfopasienmasukkamarV']) ? $_GET['RIInfopasienmasukkamarV'] : '';
} elseif ($this->init_modul == 'RJ') {

    $modDataPasien = new RJInfokunjunganrjV();
    $get = isset($_GET['RJInfokunjunganrjV']) ? $_GET['RJInfokunjunganrjV'] : '';
} elseif ($this->init_modul == 'RD') {
    $modDataPasien = new RDInfokunjunganrdV;
    $get = isset($_GET['RDInfokunjunganrdV']) ? $_GET['RDInfokunjunganrdV'] : '';
} elseif ($this->init_modul == 'PS') {
    $modDataPasien = new PSInfokunjunganpersalinanV;
    $get = isset($_GET['PSInfokunjunganpersalinanV']) ? $_GET['PSInfokunjunganpersalinanV'] : '';
} elseif ($this->init_modul == 'HD') {
    $modDataPasien = new HDInfoKunjunganRDV;
    $get = isset($_GET['HDInfoKunjunganRDV']) ? $_GET['PSInfokunjunganpersalinanV'] : '';
} else {
    $modDataPasien = new InfopasienpengunjungV();
    $get = isset($_GET['InfopasienpengunjungV']) ? $_GET['InfopasienpengunjungV'] : '';
}

$modDataPasien->unsetAttributes();
$modDataPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($get)) {
    $format = new MyFormatter();
    $modDataPasien->attributes = $get;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjrekamedik-alkes-m-grid',
    'dataProvider' => $modDataPasien->searchDialogEresep(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                        isiDataPasien_fungsi(\"$data->no_rekam_medik\", \"$data->pendaftaran_id\");
                                        $(\"#dialogRekamedik\").dialog(\"close\");
                                        return false;
                                    "))',
        ),

        array(
            'name' => 'tgl_pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            /*'filter'=>$this->widget('MyDateTimePicker',array(
                    'model'=>$modDataPasien,
                    'attribute'=>'tgl_pendaftaran',
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT
                    ),
                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3'),
                    ),true
                    ),
                     * 
                     */
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        array(
            'header' => 'No. Pendaftaran',
            'name' => 'no_pendaftaran',
            'value' => '$data->no_pendaftaran',
            'filter' => ''
        ),
        array(
            'header' => 'No. Rekam Medik',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
            'filter' => Chtml::activeTextField($modDataPasien, 'no_rekam_medik', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'filter' => Chtml::activeTextField($modDataPasien, 'nama_pasien', array('class' => 'hurufs-only'))
        ),
        //  'alamat_pasien',
        //'penjamin_nama',
        array(
            'name' => 'penjamin_nama',
            'header' => 'Penjamin',
            'value' => '$data->penjamin_nama',
            'filter'   => CHtml::dropDownList('RIInfokunjunganriV[penjamin_nama]', $modDataPasien->penjamin_nama, CHtml::listData(PenjaminpasienM::model()->findAll("penjamin_aktif = TRUE ORDER BY penjamin_nama ASC"), 'penjamin_nama', 'penjamin_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($modDataPasien, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        'jeniskasuspenyakit_nama',

        array(
            'name' => 'statusperiksa',
            'type' => 'raw',
            'value' => function ($data) {
                return Params::getWrStatusPeriksa($data->statusperiksa);
            },
            //'filter' => false,
            // 'filter' => CHtml::listData(RJInfokunjunganrjV::model()->findAll(),'statusperiksa', 'statusperiksa'),
            'filter' => CHtml::activeDropDownList(
                $modDataPasien,
                'statusperiksa',
                LookupM::getItems('statusperiksa'),
                array('empty' => '-- Pilih --')
            ), //'options' => array('SEDANG PERIKSA'=>array('selected'=>true)))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});

            jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'}));
                $(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHuruOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
        }',
));

$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>

<script type="text/javascript">
    function isiDataPasien(data) {
        $('#InfokunjunganriV_tgl_pendaftaran').val(data.tgl_pendaftaran);
        $('#InfokunjunganriV_no_pendaftaran').val(data.no_pendaftaran);
        $('#InfokunjunganriV_umur').val(data.umur);
        $('#InfokunjunganriV_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
        $('#InfokunjunganriV_instalasi_nama').val(data.instalasi_nama);
        $('#InfokunjunganriV_ruangan_nama').val(data.ruangan_nama);
        $('#InfokunjunganriV_pendaftaran_id').val(data.pendaftaran_id);
        $('#InfokunjunganriV_pasien_id').val(data.pasien_id);

        $('#InfokunjunganriV_jeniskelamin').val(data.jeniskelamin);
        $('#InfokunjunganriV_nama_pasien').val(data.nama_pasien);
        $('#InfokunjunganriV_nama_bin').val(data.nama_bin);

        $("#iter").change();

    }

    function isiDataPasien_fungsi(params, pendaftaran_id) {
        $.post("<?php echo $this->createUrl('loadDataPasien'); ?>", {
                pendaftaran_id: pendaftaran_id
            },
            function(data) {
                $('#InfokunjunganriV_tgl_pendaftaran').val(data.tgl_pendaftaran);
                $('#InfokunjunganriV_no_pendaftaran').val(data.no_pendaftaran);
                $('#InfokunjunganriV_pendaftaran_id').val(data.pendaftaran_id);
                $('#InfokunjunganriV_umur').val(data.umur);
                $('#InfokunjunganriV_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
                $('#InfokunjunganriV_instalasi_nama').val(data.instalasi_nama);
                $('#InfokunjunganriV_ruangan_nama').val(data.ruangan_nama);
                $('#InfokunjunganriV_pendaftaran_id').val(data.pendaftaran_id);
                $('#InfokunjunganriV_pasien_id').val(data.pasien_id);
                $('#InfokunjunganriV_kelaspelayanan_nama').val(data.kelaspelayanan_nama);
                $('#InfokunjunganriV_carabayar_nama').val(data.carabayar_nama);
                $('#InfokunjunganriV_penjamin_nama').val(data.penjamin_nama);

                $('#InfokunjunganriV_jeniskelamin').val(data.jeniskelamin);
                $('#InfokunjunganriV_nama_pasien').val(data.nama_pasien);
                $('#InfokunjunganriV_nama_bin').val(data.nama_bin);
                $('#InfokunjunganriV_no_rekam_medik').val(data.no_rekam_medik);
                $('#dokterpenerima').val(data.dokterpenerima);
                $('#InfokunjunganriV_pegawai_id').val(data.dpjp1);
                $('#dpjp2').val(data.dpjp2);
                $('#dpjp3').val(data.dpjp3);
                $('#kamarruangan_nokamar').val(data.kamarruangan_nokamar + " " + data.kamarruangan_nobed);
                $('#diagnosa').val(data.diagnosa);

                $("#tampung_gambar > tbody").html('');

                $("#list-rujukankeluar").html(data.riwayat);

                //if (setScanFormat != null) {
                //  setScanFormat(data);
                //}
            }, "json");

    }

    function setDataPasien() {
        var no_rekam_medik = $('#InfokunjunganriV_no_rekam_medik').val();
        var pendaftaran_id = $('#InfokunjunganriV_pendaftaran_id').val();
        var pegawai_id = $('#RJPembebasantarifT_pegawai_id').val();

        if (no_rekam_medik != '' || pendaftaran_id != '') {
            $.post('<?php echo Yii::app()->createUrl('rawatInap/PembebasanTarifRI/loadTindakanKomponenPasien'); ?>', {
                pendaftaran_id: pendaftaran_id,
                pegawai_id: pegawai_id
            }, function(data) {
                $('#divTarifPasien').html(data.tabelPembebasanTarif);
                $("#tblTindakanPasien .integer").maskMoney({
                    "symbol": "",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ".",
                    "thousands": ",",
                    "precision": 0
                });
                $("#tblTindakanPasien .integer").each(function() {
                    this.value = formatNumber(this.value)
                });
            }, 'json');
        } else {
            myAlert('Silakan pilih pasien terlebih dahulu!');
            $('#RJPembebasantarifT_pegawai_nama').val('');
            $('#RJPembebasantarifT_pegawai_id').val('');
        }
    }
</script>
<script>
    $(document).ready(function() {
        document.getElementById("fokus").focus();
        document.getElementById("ResepturT_pegawai_nama").placeholder = "Nama Dokter";

    });
</script>