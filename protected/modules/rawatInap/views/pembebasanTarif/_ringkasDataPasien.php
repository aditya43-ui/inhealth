<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset>
    <table style="width: 100%; border: none;">
        <tr>
            <td>

                <table style="width: 100%; border: none;">
                    <tr>
                        <td><?php echo CHtml::label('No. Pendaftaran <span class="required">*</span>', 'no_pendaftaran', array('class' => 'control-label required')); ?></td>
                        <td>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'RIPendaftaranT[no_pendaftaran]',
                                'value' => $modPendaftaran->no_pendaftaran,
                                'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . Yii::app()->createUrl('rawatDarurat/PembebasanTarif/daftarPasienTindakanRuangan') . '",
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
                                    'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                return false;
                            }',
                                    'select' => 'js:function( event, ui ) {                                                
                                isiDataPasien_fungsi(ui.item.value, ui.item.pendaftaran_id)
                                return false;
                            }',
                                ),
                                'htmlOptions' => array('placeholder' => 'No. Pendaftaran', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'maxlength' => 6),
                                'tombolDialog' => array('idDialog' => 'dialogRekamedik', 'idTombol' => 'tombolDialogRekamedik'),
                            ));
                            ?>

                            <?php // echo CHtml::textField('RJPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); 
                            ?>
                        </td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly' => true, 'class' => 'span3',)); ?></td>

                        <!--<td>
            <label  style="padding-left:40px;">No. Rekam Medik  <span class="no_rek">*</span></label>
            </td>-->
                        <!--<td>-->
                        <?php
                        //                    $this->widget('MyJuiAutoComplete', array(
                        //                        'name'=>'RJPasienM[no_rekam_medik]',
                        //                        'value'=>$modPasien->no_rekam_medik,
                        //                        'source'=>'js: function(request, response) {
                        //                            $.ajax({
                        //                                url: "'.Yii::app()->createUrl('rawatJalan/PembebasanTarif/daftarPasienTindakanRuangan').'",
                        //                                dataType: "json",
                        //                                data: {
                        //                                    term: request.term,
                        //                                },
                        //                                success: function (data) {
                        //                                    response(data);
                        //                                }
                        //                            })
                        //                        }',
                        //                        'options'=>array(
                        //                            'showAnim'=>'fold',
                        //                            'minLength' => 2,
                        //                            'focus'=> 'js:function( event, ui ) {
                        //                                $(this).val(ui.item.value);
                        //                                return false;
                        //                            }',
                        //                            'select'=>'js:function( event, ui ) {                                                
                        //                                isiDataPasien_fungsi(ui.item.value, ui.item.pendaftaran_id)
                        //                                return false;
                        //                            }',
                        //                        ),
                        //                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'numbers-only col-sm-6 required','maxlength' => 6),
                        //                        'tombolDialog'=>array('idDialog'=>'dialogRekamedik','idTombol'=>'tombolDialogRekamedik'),
                        //                    )); 
                        ?>
                        <!--</td>-->
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3',)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly' => true, 'class' => 'span3',)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPendaftaranT[umur]', $modPendaftaran->umur, array('readonly' => true, 'class' => 'span3',)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true, 'class' => 'span3',)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPendaftaranT[jeniskasuspenyakit_nama]', isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : '', array('readonly' => true, 'class' => 'span3',)); ?></td>

                        <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::textField('RIPasienM[nama_bin]', $modPasien->nama_bin, array('readonly' => true, 'class' => 'span3',)); ?></td>
                    </tr>

                    <?php echo CHtml::hiddenField('RIPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('RIPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array('readonly' => true, 'class' => 'span3',)); ?>

        </tr>
    </table>
    </td>
    <td>
        <?php
        if (!empty($modPasien->photopasien)) {
            echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
        } else {
            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
        }
        ?>
    </td>
    </tr>
    </table>
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRekamedik',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'width' => 870,

        'modal' => true,
    ),
));

$criteria = new CDbCriteria();
// $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
$criteria->order = 'tgl_pendaftaran DESC';
$models = RIInfopasienmasukkamarV::model()->findAll($criteria);
$dataProvider = new CActiveDataProvider('InfokunjunganrdV', array(
    'criteria' => $criteria,
));

$modDataPasien = new RIInfopasienmasukkamarV('searchPasienPembebasanTarif');

$modDataPasien->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
//$modDataPasien->tgl_pendaftaran = date('Y-m-d');
//$modDataPasien->unsetAttributes();
if (isset($_GET['RIInfopasienmasukkamarV'])) {
    $modDataPasien->attributes = $_GET['RIInfopasienmasukkamarV'];
    $format = new MyFormatter();
    //$modDataPasien->tgl_pendaftaran  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
    //$modDataPasien->statusperiksa  = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];
    //    $modDataPasien->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
    // $modDataPasien->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
    // $modDataPasien->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
}

$statusperiksa =  LookupM::getItems('statusperiksa');
unset($statusperiksa[Params::STATUSPERIKSA_SUDAH_PULANG]);
unset($statusperiksa[Params::STATUSPERIKSA_BATAL_PERIKSA]);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rirekamedik-alkes-m-grid',
    'dataProvider' => $modDataPasien->searchPasienPembebasanTarif(),
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
                                        isiDataPasien_fungsi(\"$data->no_pendaftaran\", \"$data->pendaftaran_id\");
                                        $(\"#dialogRekamedik\").dialog(\"close\");
                                        return false;
                                    "))',
        ),

        //'ruangan_id',
        //'tgl_pendaftaran',
        array(
            'name' => 'tgl_pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            /* 'filter'=>$this->widget('MyDateTimePicker',array(
                    'model'=>$modDataPasien,
                    'attribute'=>'tgl_pendaftaran',
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT
                    ),
                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3'),
                    ),true
                    ),*/
            'filter' => false,
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        array(
            'header' => 'No. Pendaftaran',
            'name' => 'no_pendaftaran',
            'value' => '$data->no_pendaftaran',
            'filter' => Chtml::activeTextField($modDataPasien, 'no_pendaftaran', array('class' => 'angkahuruf-only'))
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
            'filter'   => CHtml::dropDownList('RJInfokunjunganrjV[penjamin_nama]', $modDataPasien->penjamin_nama, CHtml::listData(PenjaminpasienM::model()->findAll("penjamin_aktif = TRUE ORDER BY penjamin_nama ASC"), 'penjamin_nama', 'penjamin_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($modDataPasien, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'name' => 'jeniskasuspenyakit_nama',
            'filter' => CHtml::activeTextField($modDataPasien, 'jeniskasuspenyakit_nama', array('class' => 'custom-only'))
        ),
        array(
            'name' => 'statusperiksa',
            'type' => 'raw',
            'value' => '$data->statusperiksa',
            //'filter' => false,
            // 'filter' => CHtml::listData(RJInfokunjunganrjV::model()->findAll(),'statusperiksa', 'statusperiksa'),
            'filter' => CHtml::activeDropDownList(
                $modDataPasien,
                'statusperiksa',
                $statusperiksa,
                array('empty' => '-- Pilih --', 'disabled' => TRUE)
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
			$(".custom-only").keyup(function() {
                setCustomOnly(this);
            });
        }',
));

$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>

<script type="text/javascript">
    function isiDataPasien(data) {
        $('#RIPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
        $('#RIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
        $('#RIPendaftaranT_umur').val(data.umur);
        $('#RIPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
        $('#RIPendaftaranT_instalasi_nama').val(data.instalasi_nama);
        $('#RIPendaftaranT_ruangan_nama').val(data.ruangan_nama);
        $('#RIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#RIPendaftaranT_pasien_id').val(data.pasien_id);

        $('#RIPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#RIPasienM_nama_pasien').val(data.nama_pasien);
        $('#RIPasienM_nama_bin').val(data.nama_bin);

        $.post('<?php echo Yii::app()->createUrl('rawatInap/PembebasanTarif/loadTindakanKomponenPasien'); ?>', {
            pendaftaran_id: data.pendaftaran_id
        }, function(data) {
            //$('#tblTindakanPasien tbody').html(data.formTindakanKomponen);
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

    }

    function isiDataPasien_fungsi(params, pendaftaran_id) {
        $.post("<?php echo Yii::app()->createUrl('rawatInap/PembebasanTarif/loadDataPasien'); ?>", {
                pendaftaran_id: pendaftaran_id
            },
            function(data) {
                if (data != null) {
                    $('#RIPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
                    $('#RIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                    $('#RIPendaftaranT_umur').val(data.umur);
                    $('#RIPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
                    $('#RIPendaftaranT_instalasi_nama').val(data.instalasi_nama);
                    $('#RIPendaftaranT_ruangan_nama').val(data.ruangan_nama);
                    $('#RIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                    $('#RIPendaftaranT_pasien_id').val(data.pasien_id);

                    $('#RIPasienM_jeniskelamin').val(data.jeniskelamin);
                    $('#RIPasienM_nama_pasien').val(data.nama_pasien);
                    $('#RIPasienM_nama_bin').val(data.nama_bin);
                    $('#RIPasienM_no_rekam_medik').val(data.no_rekam_medik);

                    $('#RIPembebasantarifT_pegawai_nama').val(data.dokter_nama);
                    $('#RIPembebasantarifT_pegawai_id').val(data.dokter_id);
                    var datapeg = "";

                    if (data.doktertindakan_id.length > 0) {
                        for (var i = 0; i < data.doktertindakan_id.length; i++) {
                            if (i > 0) {
                                datapeg += "&";
                            }
                            datapeg += "RIDokterV[pegawai_id][]=" + data.doktertindakan_id[i];
                        }
                    }

                    $.fn.yiiGridView.update('ridokterpembebasan-v-grid', {
                        data: datapeg
                    });

                    $.post('<?php echo Yii::app()->createUrl('rawatInap/PembebasanTarif/loadTindakanKomponenPasien'); ?>', {
                        pendaftaran_id: pendaftaran_id,
                        pegawai_id: data.dokter_id
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
                }
            }, "json");
    }

    function setDataPasien() {
        var no_rekam_medik = $('#RIPasienM_no_rekam_medik').val();
        var pendaftaran_id = $('#RIPendaftaranT_pendaftaran_id').val();
        var pegawai_id = $('#RIPembebasantarifT_pegawai_id').val();

        if (no_rekam_medik != '' || pendaftaran_id != '') {
            $.post('<?php echo Yii::app()->createUrl('rawatInap/PembebasanTarif/loadTindakanKomponenPasien'); ?>', {
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
            $('#RIPembebasantarifT_pegawai_nama').val('');
            $('#RIPembebasantarifT_pegawai_id').val('');
        }
    }
</script>