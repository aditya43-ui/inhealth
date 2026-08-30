<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Jadwal Kunjungan Rehab Medis
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group" style="display: <?php echo (!empty($listJadwalKunjungan)) ? 'none' : 'block' ?>">
            <?php echo CHtml::label('Lama Terapi Kunjungan', 'lamaterapi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textfield('lamaterapi', '', array('placeholder' => 'Lama Terapi Kunjungan', 'class' => 'span3',)) ?>
                <?php echo CHtml::label('Kali Kunjungan', '') ?>
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} ', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-primary', 'onClick' => 'generateJadwal()', 'rel' => 'tooltip', 'data-title' => 'Klik untuk membuat jadwal kunjungan')
                ); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Detail <b>Jadwal Kunjungan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-condensed" id="tblDetailjadwal">
                    <tr>
                        <th>No. Urut</th>
                        <th>Tgl. Jadwal Kunjungan</th>
                        <th>Jenis - Tindakan</th>
                        <!-- <th>Paramedis</th>
                        <th>Dokter</th> -->
                        <!-- <th>Shift</th> -->
                        <th>Bed</th>
                        <th>Slot Bed</th>
                        <?php if (!empty($listJadwalKunjungan)) { ?>
                            <th>Status Terapi</th>
                        <?php } ?>
                    </tr>
                    <?php
                    if (!empty($listJadwalKunjungan)) {
                        foreach ($listJadwalKunjungan as $jadwalKunjungan) {
                    ?>
                            <tr>
                                <td><?php echo $jadwalKunjungan->nourutjadwal ?></td>
                                <td><?php echo $jadwalKunjungan->jadwalrehabmedis_hari  . ' - ' . MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($jadwalKunjungan->jadwalrehabmedis_tgl_ke))) /*$jadwalKunjungan->tgljadwalrm*/ ?></td>
                                <?php // $tindakans = HasilpemeriksaanrmT::model()->findAllByAttributes(array('jadwalkunjunganrm_id'=>$jadwalKunjungan->jadwalkunjunganrm_id)); 
                                ?>
                                <?php
                                $modHasil = HasilpemeriksaanrmT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienPenunjang->pasienmasukpenunjang_id));
                                //                $tindakans = HasilpemeriksaanrmT::model()->findAllByAttributes(array('jadwalrehabmedis_id'=>$jadwalKunjungan->jadwalrehabmedis_id)); 
                                ?>
                                <!--foreach ($modHasil as $i=>$hasilPeriksa) {-->
                                <td>
                                    <?php
                                    foreach ($modHasil as $tindakan) {
                                        $t = TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakan->tindakanrm_id);
                                        echo $t->jenistindakanrm->jenistindakanrm_nama . ' - ';
                                        echo $t->tindakanrm_nama . '</br>';
                                    }
                                    ?>
                                </td>
                                <!-- <td>
                                    <?php //echo (!empty($jadwalKunjungan->paramedis1_id)) ?  ParamedisV::model()->findByAttributes(array('pegawai_id' => $jadwalKunjungan->paramedis1_id))->nama_pegawai . ' dan ' : '-' ?>
                                    <?php //echo (!empty($jadwalKunjungan->paramedis2_id)) ?  ParamedisV::model()->findByAttributes(array('pegawai_id' => $jadwalKunjungan->paramedis2_id))->nama_pegawai : '-' ?>
                                </td> -->
                                <!-- <td>
                                    <?php
                                    $dokterM = (!empty($jadwalKunjungan->pegawai_id)) ? DokterV::model()->findByAttributes(array('pegawai_id' => $jadwalKunjungan->pegawai_id)) : null;
                                    $namaPegawai = "-";
                                    if (isset($dokterM)) {
                                        $namaPegawai = $dokterM->nama_pegawai;
                                    }

                                    //echo $namaPegawai ?>
                                </td> -->
                                <td>
                                    <?php
                                    // $slotBedM  = SlotbedM::model()->findAll();
                                    $slotBedM = (!empty($jadwalKunjungan->slotbed_id)) ? SlotbedM::model()->findByAttributes(array('slotbed_id' => $jadwalKunjungan->slotbed_id)) : null;
                                    $nobed = "-";
                                    if (isset($slotBedM)) {
                                        $nobed = $slotBedM->slotbed_noslot;
                                    }

                                    echo $nobed 
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // $slotBedM  = SlotbedM::model()->findAll();
                                    $slotM = (!empty($jadwalKunjungan->slotbed_id)) ? SlotbedM::model()->findByAttributes(array('slotbed_id' => $jadwalKunjungan->slotbed_id)) : null;
                                    $noslot = "-";
                                    if (isset($slotM)) {
                                        $noslot = date('H:i', strtotime($jadwalKunjungan->jadwalrehabmedis_tgl_ke));
                                    }

                                    echo $noslot 
                                    ?>
                                </td>
                                <!-- <td>
                                    <?php //echo ($jadwalKunjungan->shift_id) ? ShiftM::model()->findByPk($jadwalKunjungan->shift_id)->shift_nama : '' ?>
                                </td> -->
                                <td>
                                    <?php echo ($jadwalKunjungan->statusterapi) ? 'Sudah' : 'Belum' ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="tglPatokan" style="display: none">
    <?php $this->widget('MyDateTimePicker', array(
        'name' => 'tes',
        'value' => '',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
    )); ?>
</div>

<script>

    var instalasi_id = <?php echo Yii::app()->user->getState('instalasi_id'); ?>;
    var kelaspelayanan_id = <?php echo $modPasienPenunjang->kelaspelayanan_id; ?>;
    var pasien_id = <?php echo $modPasienPenunjang->pasien_id; ?>;

    function generateJadwal() {
        var lamaTerapi = $('#lamaterapi').val();
        var pasienmasukpenunjang_id = <?php echo $id; ?>

        if (lamaTerapi == '') {
            myAlert('Anda Belum Memilih Lama Terapi Kunjungan');
            $('#lamaterapi').addClass('error').focus();
        } else {
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('loadFormJadwalKunjunganAwal') ?>',
                'data': {
                    pasienmasukpenunjang_id: pasienmasukpenunjang_id,
                    lamaTerapi: lamaTerapi
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.pesan == '') {
                        $('#tblDetailjadwal tr:not(:first)').remove();
                        $('#tblDetailjadwal').append(data.form);
                        jQuery('.dtPicker3').datepicker(jQuery.extend({
                                showMonthAfterYear: false
                            },
                            jQuery.datepicker.regional['id'], {
                                'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                                'changeYear': true,
                                'changeMonth': true
                            })).change(function() { reloadListBed(this); });
                    } else {
                        myAlert(data.pesan);
                        return false;
                    }
                },
                'cache': false
            });
        }
    }

    function reloadListBed(obj) {
        var row = $(obj).parents("tr");
        var tgl = row.find(".tgljadwalrm").val();

        row.find(".slotbed").html('<option value="">-- Pilih --</option>');

        $.post('<?php echo $this->createUrl('reloadListBed'); ?>', {
            tgl: tgl,
            kelaspelayanan_id: kelaspelayanan_id,
            instalasi_id: instalasi_id
        }, function(data) {
            row.find(".nobed").html(data);
        });

    }

    function cekSlotTersedia(obj) {
        var row = $(obj).parents("tr");
        var tgl = row.find(".tgljadwalrm").val();
        var bed = row.find(".nobed").val();

        $.post('<?php echo $this->createUrl('reloadSlotBed'); ?>', {
            tgl: tgl,
            kelaspelayanan_id: kelaspelayanan_id,
            instalasi_id: instalasi_id,
            bed: bed
        }, function(data) {
            row.find(".slotbed").html(data);
        });
    }

    function cekValidasiSlotBed(obj) {
        var sel = $(obj).find(":selected");

        if (sel.data('terisi') == 1) {
            $(obj).val("");
            myAlert("Slot sudah terisi.");
        }
    }
</script>