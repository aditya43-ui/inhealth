<?php 
$visibility = (isset($_GET['pasienadmisi_id']))  ? '' : 'hidden';
$required = (isset($_GET['pasienadmisi_id']))  ? 'required' : '';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group ">
            <?php echo CHtml::label('Pegawai Pengisi <span class="required">*</span>', 'pegawaipengisi_id', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php //echo $form->dropDownList($modResume,'pegawaipengisi_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = '.Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'NamaLengkap'),array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);")); 
                echo $form->hiddenField($modResume, 'pegawaipengisi_id');
                echo $form->textField($modResume, 'pegawaipengisi_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                ?>
            </div>
        </div>
        <div class="control-group" <?= $visibility ?>>
            <label for="" class="control-label">Cara Keluar <span class="required">*</span></label>
            <div class="controls">
                <?php 
                    if($modResume->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
                        $disabled = true;
                        echo $form->hiddenField($modResume, 'carakeluar_id');
                        echo $form->hiddenField($modResume, 'kondisikeluar_id');
                    } else {
                        $disabled = false;
                    }
                ?>
                <?php echo $form->dropDownList(
                    $modResume,
                    'carakeluar_id',
                    CHtml::listData($modResume->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'),
                    array(
                        'class' => 'span3 carakeluar_id ' . $required, 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setKondisiKeluar(this);', 'disabled' => $disabled
                    )
                ); ?>

            </div>
        </div>
        <div class="control-group" <?= $visibility ?>>
            <?php echo CHtml::label('Kondisi Pulang <span class="required">*</span>', 'kondisikeluar_id', array('class' => 'control-label')) ?>
            
            <div class="controls">
                <?php echo $form->dropDownList(
                    $modResume,
                    'kondisikeluar_id',
                    CHtml::listData($modResume->getKondisikeluarItems($modResume->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'),
                    array('class' => 'span3 kondisikeluar_id ' . $required, 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'disabled' => $disabled)
                ); ?>
                <?php echo $form->error($modResume, 'kondisikeluar_id'); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <!-- keluhan utama -->
        <div class="control-group">
            <?php echo CHtml::label("Keluhan Utama", '', array('class' => 'control-label', 'style' => 'width: 70px')); ?>
        </div>
        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'keluhanutama', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <!-- riwayat penyakit pasien -->
        <div class="control-group">
            <?php echo CHtml::label("Riwayat Penyakit Pasien", '', array('class' => 'control-label', 'style' => 'width: 110px')); ?>
        </div>
        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'riwayatpenyakitterdahulu', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <!-- pemeriksaan penujang -->
        <div class="control-group">
            <?php echo CHtml::label("Pemeriksaan Penunjang", '', array('class' => 'control-label', 'style' => 'width: 250px')); ?>
        </div>
        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'pemeriksaanpenunjang', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>


        <div class="control-group">
            <?php echo CHtml::label("Tanda Vital", '', array('class' => 'control-label', 'style' => 'width: 70px')); ?>
        </div>

        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'tandavital', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>


    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label for="" class="control-label">Diagnosa Masuk</label>
            <div class="controls">
                <?php echo $form->textField($modResume, 'diagnosamasuk', ['class' => 'span4', 'readonly' => true]) ?>
            </div>
        </div>
        <!-- riwayat alergi -->
        <div class="control-group">
            <?php echo CHtml::label("Riwayat Alergi", '', array('class' => 'control-label', 'style' => 'width: 400px')); ?>
        </div>
        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'riwayatalergi', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <!-- pemeriksaan fisik dan keadaan umum -->
        <div class="control-group">
            <?php echo CHtml::label("Pemeriksaan Fisik & Keadaan Umum", '', array('class' => 'control-label', 'style' => 'width: 70px')); ?>
        </div>
        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'anamnesa', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <!-- planing dan terapi / tindakan -->
        <div class="control-group">
            <?php echo CHtml::label("Planning & Terapi/Tindakan", '', array('class' => 'control-label', 'style' => 'width: 130px')); ?>
        </div>
        <div class="control-group">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'planningdanterapi', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>



        <!-- dari sini sampai ke bawah adalah kolom2 yang di hide  -->
        <div class="control-group hide">
            <?php echo CHtml::label("Tindakan bedah yang pernah dilakukan", '', array('class' => 'control-label', 'style' => 'width: 110px')); ?>
        </div>
        <div class="control-group hide">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'riwayatbedah', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <div class="control-group hide">
            <?php echo CHtml::label("Riwayat Pengobatan", '', array('class' => 'control-label', 'style' => 'width: 100px')); ?>
        </div>
        <div class="control-group hide">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'riwayatobat', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <div class="control-group hide">
            <?php echo CHtml::label("Anjuran", '', array('class' => 'control-label', 'style' => 'width: 70px')); ?>
        </div>
        <div class="control-group hide">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'anjuran', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <div class="control-group hide">
            <?php echo CHtml::label("Diagnosa", '', array('class' => 'control-label', 'style' => 'width: 160px')); ?>
        </div>
        <div class="control-group hide">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'diagnosa_akhir', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>

        <div class="control-group hide">
            <?php echo CHtml::label("Terapi yang sedang berjalan", '', array('class' => 'control-label')); ?>
        </div>
        <div class="control-group hide">
            <div class="controls" style="width: 90%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modResume, 'attribute' => 'terapiyangberjalan', 'toolbar' => 'mini', 'height' => '150px')) ?>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Diagnosa Keluar</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="table-diagnosakeluar">
                        <thead>
                            <th>No.</th>
                            <th>Kelompok Diagnosis</th>
                            <th>Kode ICD-10</th>
                            <th>Nama ICD-10</th>
                            <th>Nama Lain ICD-10</th>
                            <th>Dasar Diagnosa</th>
                            <th>Pilih</th>
                        </thead>
                        <tbody>
                            <?php if(count($riwayatDiagnosaICDX) > 0) : ?>
                            <?php foreach($riwayatDiagnosaICDX as $i => $val) { ?>
                            <tr>
                                <td>
                                    <?= $i+1 ?>

                                    <?php 
                                        $modMorbi = ResumemedisMorbiditasR::model()->findByAttributes(['pasienmorbiditas_id' => $val->pasienmorbiditas_id]);
                                        $selected = 0;
                                        if(!empty($modMorbi)) {
                                            $selected = 1;
                                        }

                                        echo CHtml::hiddenField('DiagnosaKeluar[' . $i . '][selected]', $selected, ['class' => 'selectedDiagnosa span1']);
                                        echo CHtml::hiddenField('DiagnosaKeluar[' . $i . '][pasienmorbiditas_id]', $val->pasienmorbiditas_id, ['class' => 'span1 pasienmorbiditas_id']);
                                        echo CHtml::hiddenField('DiagnosaKeluar[' . $i . '][kelompokdiganosa_id]', $val->kelompokdiagnosa_id, ['class' => 'span1 kelompokdiganosa_id']);
                                    ?>
                                </td>
                                <td><?= $val->kelompokdiagnosa->kelompokdiagnosa_nama ?? '' ?></td>
                                <td><?= $val->diagnosa->diagnosa_kode ?? '' ?></td>
                                <td><?= $val->diagnosa->diagnosa_nama ?? '' ?></td>
                                <td><?= $val->diagnosa->diagnosa_namalainnya ?? '' ?></td>
                                <td><?= $val->ket_diagnosa ?? '' ?></td>
                                <td>
                                    <?= CHtml::Link('<i class="icon-form-check"></i>', "javascript:void(0)", array(
                                            "class" => "btn-small",
                                            "id" => "selectDiagnosa",
                                            'onclick' => 'pilihDiagnosaKeluar(this)'
                                        ));
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Tindakan Medis</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="table-diagnosatindakan">
                        <thead>
                            <th>No.</th>
                            <th>Kode ICD 9</th>
                            <th>Nama ICD 9</th>
                            <th>Nama Lain ICD 9</th>
                            <th>Dasar Tindakan</th>
                            <th>Pilih</th>
                        </thead>
                        <tbody>
                            <?php if(count($riwayatDiagnosaICD9) > 0) : ?>
                            <?php foreach($riwayatDiagnosaICD9 as $i => $val) { ?>
                            <tr>
                                <td>
                                    <?= $i+1 ?>
                                    <?php 
                                        $modIcd9Resume = ResumemedisIcd9R::model()->findByAttributes(['pasienicd9cm_id' => $val->pasienicd9cm_id]);
                                        $selectedTindakan = 0;
                                        if(!empty($modIcd9Resume)) {
                                            $selectedTindakan = 1;
                                        }
                                        echo CHtml::hiddenField('DiagnosaTindakan[' . $i . '][selected]', $selectedTindakan, ['class' => 'selectedDiagnosaTindakan span1']);
                                        echo CHtml::hiddenField('DiagnosaTindakan[' . $i . '][pasienicd9cm_id]', $val->pasienicd9cm_id, ['class' => 'span1 pasienicd9cm_id']);
                                    ?>
                                </td>
                                <td><?= $val->diagnosatindakan->diagnosaicdix_kode ?? '' ?></td>
                                <td><?= $val->diagnosatindakan->diagnosaicdix_nama ?? '' ?></td>
                                <td><?= $val->diagnosatindakan->diagnosaicdix_namalainnya ?? '' ?></td>
                                <td><?= $val->keterangan ?? '' ?></td>
                                <td>
                                    <?= 
                                        CHtml::Link('<i class="icon-form-check"></i>', "javascript:void(0)", array(
                                            "class" => "btn-small",
                                            "id" => "selectDiagnosaTindakan",
                                            'onclick' => 'pilihDiagnosaTindakan(this)'
                                        ));
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($modResume->pendaftaran->pasienpulang_id)):?>
 <!-- Cara keluar meninggal dunia -->
<?php if($modResume->pendaftaran->pasienpulang->carakeluar_id == 4):?>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Tabel Diagnosa <b>Kematian</b></div>
            </div>
            <div class="panel-body">
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
        </div>   
    </div>
</div>
<?php endif;?>
<?php endif;?>
<br>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Obat Yang Diberikan</div>
            </div>
            <div class="panel-body">
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
                                <td><?= $val->obatalkes->obatalkes_nama ?? '' ?></td>
                                <td><?= $val->qty_jual ?? '' ?></td>
                                <td><?= $val->qty_jual ?? '' ?> <?= $val->satuansediaan ?? '' ?></td>
                                <td><?= $val->etiket ?></td>
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
    </div>
</div>