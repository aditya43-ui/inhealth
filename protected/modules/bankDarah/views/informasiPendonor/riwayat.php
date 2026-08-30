<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pendaftaranDonorDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>
<style>        
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }

    #data-seleksi  .span2, #tandavital .span2{
        width:99px !important; 
    }
    .form-horizontal .controls{
        margin-top: 7px;
        color: #1f3b56 !important;
        width: 250px !important
    }
</style>
<br>
<div class="panel panel-dark">
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">  
                <div class="control-group ">
                    <?php echo CHtml::label('No. Donor', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo ': ' . $modPendonor->no_pendonor ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Donor Darah', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo ': ' . $modPendonor->nama_lengkap ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Jenis Kelamin', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo ': ' . $modPendonor->jenis_kelamin ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Tempat / Tgl Lahir', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo!empty($modPendonor->tempat_lahir) ? ': ' . $modPendonor->tempat_lahir . ' / ' : ': - / '; ?>
                        <?php echo date('d ', strtotime($modPendonor->tgllahir)) . MyFormatter::getMonthId(date('m', strtotime($modPendonor->tgllahir))) . date(' Y', strtotime($modPendonor->tgllahir)); ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Umur', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $biday = new DateTime($modPendonor->tgllahir);
                        $today = new DateTime();

                        $diff = $today->diff($biday);
                        echo ': ' . $diff->y . ' Tahun';
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('Alamat', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo ': ' . $modPendonor->alamat_lengkap ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Pekerjaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $cekPekerjaan = PekerjaanpendonorM::model()->findByPk($modPendonor->pekerjaan_id);
                        echo!empty($cekPekerjaan) ? ': ' . $cekPekerjaan->pekerjaanpendonor_nama : ': -';
                        ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Berat / Tinggi Badan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo!empty($modPendonor->beratbadan_kg) ? ': ' . $modPendonor->beratbadan_kg . ' / ' : ': - / '; ?>
                        <?php echo!empty($modPendonor->tinggibadan_cm) ? $modPendonor->tinggibadan_cm : ' - '; ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Golongan Darah', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo ': ' . $modPendonor->gol_darah ?>
                    </div>
                </div>  
                <div class="control-group ">
                    <?php echo CHtml::label('Rhesus', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo ': ' . $modPendonor->rhesus ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>No. Formulir</th>
            <th>Tgl. Donasi</th>
            <th>Lokasi Rekrutmen</th>
            <th>Seleksi Donor Darah</th>
            <th>Penyadapan Darah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $modRiwayat = DaftardonasiT::model()->findAllByAttributes(array('pendonor_id' => $modPendonor->pendonor_id));
        foreach ($modRiwayat as $value) {
            $cekRuangan = RuanganM::model()->findByPk($value->ruangan_rekruitmen_id);
            $cekSeleksi = SeleksipendonorT::model()->findByAttributes(array('daftardonasi_id' => $value->daftardonasi_id));
            $cekObservasi = ObservasipendonorT::model()->findByAttributes(array('pendonor_id' => $modPendonor->pendonor_id, 'daftardonasi_id' => $value->daftardonasi_id));
            ?>
            <tr>
                <td>
                    <?php echo isset($value->no_formulir) ? $value->no_formulir : "-"; ?>
                </td>
                <td>
                    <?php echo date('d ', strtotime($value->waktu_pendaftaran)) . MyFormatter::getMonthId(date('m', strtotime($value->waktu_pendaftaran))) . date(' Y', strtotime($value->waktu_pendaftaran)); ?>
                </td>
                <td>
                    <?php echo isset($cekRuangan) ? $cekRuangan->ruangan_nama : '-'; ?>
                </td>
                <td>
                    <?php echo isset($cekSeleksi) ? $cekSeleksi->status_pendonor : "-"; ?>
                </td>
                <td>
                    <?php
                    if (!empty($cekSeleksi)) {
                        if ($cekSeleksi->status_pendonor == 'DITOLAK') {
                            $observasi = "-";
                        } elseif ($cekSeleksi->status_pendonor == 'DITERIMA' && $value->status == 'SELEKSI') {
                            if (!empty($cekSeleksi->detaknadi)) {
                                if (!empty($cekKantong)) {
                                    $observasi = '-';
                                } else {
                                    $observasi = "-";
                                }
                            } else {
                                $observasi = "-";
                            }
                        } elseif ($cekSeleksi->status_pendonor == 'DITERIMA' && $value->status == 'OBSERVASI') {
                            if (!empty($cekObservasi)) {
                                if ($cekObservasi->is_batalpenyadapan == true) {
                                    $observasi = 'Gagal Sadap';
                                } else {
                                    $observasi = 'Berhasil Sadap';
                                }
                            } else {
                                $observasi = '-';
                            }
                        } elseif ($cekSeleksi->status_pendonor == 'DITERIMA' && $value->status == 'SELESAI') {
                            if (empty($cekObservasi)) {
                                $observasi = '-';
                            } else {
                                $observasi = 'Berhasil Sadap';
                            }
                        }
                    } elseif (empty($cekSeleksi)) {
                        $observasi = "-";
                    }
                    echo $observasi;
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>