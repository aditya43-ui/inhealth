<div class="row"  id="panel-resume">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Pegawai Pengisi', 'pegawaipengisi_id', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($modResume, 'pegawaipengisi_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                ?>
            </div>
        </div>

        <!-- keluhan utama -->
        <div class="control-group">
            <?php echo CHtml::label("Keluhan Utama", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'keluhanutama', ['id' => 'keluhanutama']);
                ?>
            </div>
        </div>
        <div class="control-group">
        </div>

        <!-- riwayat penyakit pasien -->
        <div class="control-group">
            <?php echo CHtml::label("Riwayat Penyakit Pasien", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'riwayatpenyakitterdahulu', ['id' => 'riwayatpenyakitterdahulu']);
                ?>
            </div>
        </div>

        <!-- pemeriksaan penujang -->
        <div class="control-group">
            <?php echo CHtml::label("Pemeriksaan Penunjang", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'pemeriksaanpenunjang', ['id' => 'pemeriksaanpenunjang']);
                ?>
            </div>
        </div>

        <!-- tanda vital -->
        <div class="control-group">
            <?php echo CHtml::label("Tanda Vital", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'tandavital', ['id' => 'tandavital']);
                ?>
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label for="" class="control-label">Diagnosa Masuk</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($modResume, 'diagnosamasuk', ['class' => 'span4', 'readonly' => true]) ?>
            </div>
        </div>

        <!-- riwayat alergi -->
        <div class="control-group">
            <?php echo CHtml::label("Riwayat Alergi", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'riwayatalergi', ['id' => 'riwayatalergi']);
                ?>
            </div>
        </div>
        

        <!-- pemeriksaan fisik dan keadaan umum -->
        <div class="control-group">
            <?php echo CHtml::label("Pemeriksaan Fisik & Keadaan Umum", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'anamnesa', ['id' => 'anamnesa']);
                ?>
            </div>
        </div>
        
        <!-- planing dan terapi / tindakan -->
        <div class="control-group">
            <?php echo CHtml::label("Planning & Terapi/Tindakan", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextArea($modResume, 'planningdanterapi', ['id' => 'planningdanterapi']);
                ?>
            </div>
        </div>


    </div>
</div>

<!-- diagnosa ICD 10 dan 9 -->
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-7">
            <div class="panel-title">
                Diagnosa Keluar
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Kelompok Diagnosis</th>
                        <th>Kode ICD-10</th>
                        <th>Nama ICD-10</th>
                        <th>Nama Lain ICD-10</th>
                        <th>Dasar Diagnosa</th>
                    </thead>
                    <tbody>
                        <?php if(count($riwayatDiagnosaICDX) > 0) : ?>
                        <?php foreach($riwayatDiagnosaICDX as $i => $val) { ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= $val->kelompokdiagnosa->kelompokdiagnosa_nama ?? '' ?></td>
                            <td><?= $val->diagnosa->diagnosa_kode ?? '' ?></td>
                            <td><?= $val->diagnosa->diagnosa_nama ?? '' ?></td>
                            <td><?= $val->diagnosa->diagnosa_namalainnya ?? '' ?></td>
                            <td><?= $val->keterangan ?? '' ?></td>
                        </tr>
                        <?php } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="panel-title">
                Tindakan Medis
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Kode ICD 9</th>
                        <th>Nama ICD 9</th>
                        <th>Nama Lain ICD 9</th>
                        <th>Dasar Tindakan</th>
                    </thead>
                    <tbody>
                        <?php if(count($riwayatDiagnosaICD9) > 0) : ?>
                        <?php foreach($riwayatDiagnosaICD9 as $i => $val) { ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= $val->diagnosatindakan->diagnosaicdix_kode ?? '' ?></td>
                            <td><?= $val->diagnosatindakan->diagnosaicdix_nama ?? '' ?></td>
                            <td><?= $val->diagnosatindakan->diagnosaicdix_namalainnya ?? '' ?></td>
                            <td><?= $val->keterangan ?? '' ?></td>
                        </tr>
                        <?php } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- menentukan cara keluar -->
<?php 
$menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
$is_meninggal = false;

if($menu == 'RI') {
    if(!empty($modResume->pasienadmisi->pasienpulang_id)) {
        if($modResume->pasienadmisi->pasienpulang->carakeluar_id == 4) {
            $is_meninggal = true;
        }
    }
} else {
    if(empty($modResume->pendaftaran->pasienadmisi_id)) {
        if(!empty($modResume->pendaftaran->pasienpulang_id)) {
            if($modResume->pendaftaran->pasienpulang->carakeluar_id == 4) {
                $is_meninggal = true;
            }
        }
    }
}
$modSuratMati = SuratketeranganR::model()->findByAttributes(['pendaftaran_id' => $modResume->pendaftaran_id]);
?>

<!-- diagnosa kematian -->
<!-- Cara keluar meninggal dunia -->
<?php if($is_meninggal):?>
    
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <label for="" class="control-label">Penyebab Kematian : </label>
            <div class="controls">
                <?php 
                    if(!empty($modSuratMati)) {
                        echo CHtml::textArea('sebab', $modSuratMati->penyebabkematian, ['disabled' => true]);
                    }
                    ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="panel-title">
            Tabel Diagnosa <b>Kematian</b>
        </div>
        <table class="table table-striped">
            <thead>
                <th>No</th>
                <th>Kode ICD-10</th>
                <th>Nama ICD-10</th>
                <th>Nama Lain ICD-10</th>
            </thead>
            <tbody>
                <?php if(count($riwayatDiagnosaKematian) > 0) : ?>
                <?php foreach($riwayatDiagnosaKematian as $i => $val) { ?>
                    <?php
                        $diagnosa = DiagnosaM::model()->findByPk($val->diagnosa_id);    
                    ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= $diagnosa->diagnosa_kode ?? '' ?></td>
                    <td><?= $val->diagnosa_nama ?? '' ?></td>
                    <td><?= $diagnosa->diagnosa_namalainnya ?? '' ?></td>
                </tr>
                <?php } ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div><br>
<?php endif;?>


<!-- riwayat obat yang diberikan -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel-title">
            Obat Yang Diberikan
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Nama Obat <br> (List Of Drugs)</th>
                        <th rowspan="2">Jumlah <br> (Quantity)</th>
                        <th rowspan="2">Dosis & Frekuensi <br> (Dose)</th>
                        <th rowspan="2">Cara Pemberian <br> (Method)</th>
                        <th colspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>Selama Perawatan</th>
                        <th>Saat Pulang</th>
                    </tr>

                </thead>
                <tbody>
                    <?php if(count($riwayatObatAlkesPasien) > 0) : ?>
                    <?php foreach($riwayatObatAlkesPasien as $i => $val) { ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= $val->nama_obat ?? '' ?></td>
                        <td><?= $val->qty_jual ?? '' ?></td>
                        <td><?= $val->dosis ?? '' ?></td>
                        <td><?= $val->caraminum ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php } ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>