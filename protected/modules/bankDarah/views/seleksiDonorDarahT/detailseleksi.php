<?php 
/**
 * -Digunakan untuk menampilkan detail seleksi
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1534
 */

    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'seleksidonordarah-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'',
)); ?>

    <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Detail Seleksi Donor Darah</strong></div>
        </div>
        <div class="panel-body">
            
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Data Pendonor</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-pendonor">
                        <div class="row-fluid">
                            <div class = "col-sm-6">
                            <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly'=>true)); ?>
                            <?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly'=>true)); ?>
                            <div class="control-group">
                                <?php echo CHtml::label("No. Formulir", 'no_formulir', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modDaftarDonasi, 'no_formulir', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("No. Identitas Pendonor", 'no_identitas', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'no_identitas', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Nama Pendonor", 'nama_lengkap', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'nama_lengkap', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Tanggal Lahir", 'tgllahir', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'tgllahir', array('readonly'=>true,'class'=>'span3')); ?>
                                    <label class="icon-calendar"></label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::textField('tgllahir',(!empty($modPendonor->tgllahir))? CustomFunction::hitungUmur($modPendonor->tgllahir) : "-",array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Jenis Kelamin", 'jenis_kelamin', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'jenis_kelamin', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Alamat Lengkap", 'alamat_lengkap', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextArea($modPendonor, 'alamat_lengkap', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                        </div>
                        <div class = "col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label("Berat Badan", 'beratbadan_kg', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'beratbadan_kg', array('readonly'=>true,'class'=>'span3')); ?>
                                    &nbsp;<label>Kg</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Tinggi Badan", 'tinggibadan_cm', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'tinggibadan_cm', array('readonly'=>true,'class'=>'span3')); ?>
                                    &nbsp;<label>Cm</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("No Telepon Aktif", 'notelp_pendonor', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'notelp_pendonor', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("No Mobile Aktif", 'nomobile_pendonor', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'nomobile_pendonor', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Pekerjaan", 'pekerjaan_id', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $cekPekerjaanpendonor = PekerjaanpendonorM::model()->findByPk($modPendonor->pekerjaan_id);
                                    if (!empty($cekPekerjaanpendonor)) {
                                        $namapekerjaan = $cekPekerjaanpendonor->pekerjaanpendonor_nama;
                                    } else {
                                        $namapekerjaan = '';
                                    }
                                    echo CHtml::textField('pekerjaan_id', $namapekerjaan, array('readonly' => true, 'class' => 'span3'));
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Status", 'statusperkawinan', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'statusperkawinan', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Golongan Darah", 'gol_darah', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'gol_darah', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Rhesus", 'rhesus', array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeTextField($modPendonor, 'rhesus', array('readonly'=>true,'class'=>'span3')); ?>
                                </div>
                            </div>
                        </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Kuesioner Donor Darah</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-kuesioner">
                        <div class="row-fluid">
                            <div class="span12">
                            <table class="table table-bordered table-condensed table-striped" id="tabel_kuesioner">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Jawab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    if(count($modKuesioner) > 0) {
                                          $no = 1;
                                    foreach($modKuesioner as $data) {
                                    $modPertanyaan = KuesionerdonorM::model()->findByPk($data->kuesionerdonor_id);                                   
                                    echo '<tr>';
                                    echo '<td><label>'.$no.'</label></td>';
                                    echo '<td><label>'.$modPertanyaan->kuesioner_desc.'</label></td>';
                                    echo '<td>'.CHtml::radioButtonList('', ($data->ceklist ==  1)? '1' : '0', array('1'=>'YA', '0' => 'TIDAK'), array('disabled' => true,'labelOptions'=>array('style'=>'display:inline','readonly'=>true))).'</td>';
                                    echo '</tr>';
                                    $no++;
                                    }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Seleksi Donor Darah</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-seleksi">
                        <div class="row-fluid">
                            <span class="span12" style="text-align: center" id="label_status"></span>
                            <div class="span12">
                                <?php
                                echo $form->radioButtonListInlineRow($model, 'jenisdonor', LookupM::getItems('jenisdonor'), array('onkeyup' => "return $(this).focusNextInputField(event)",'class'=>'span1', 'disabled' => true, ));
                                ?>
                                <div class="control-group">
                                    <?php echo CHtml::label("Tekanan Darah <span class='required'>*</span>", 'tekanandarah', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'td_systolic', array('readonly'=>true,'placeholder' => 'systolic', 'class' => 'span2 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        &nbsp;&nbsp;&nbsp;<label>/</label>&nbsp;&nbsp;&nbsp;
                                        <?php echo $form->textField($model, 'td_diastoliic', array('readonly'=>true,'placeholder' => 'diastolic', 'class' => 'span2 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        &nbsp;&nbsp;&nbsp;<label>mmHg</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Kadar Hemoglobin <span class='required'>*</span>", 'kadar_hb', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'kadar_hb', array('readonly'=>true,'placeholder' => 'hb', 'class' => 'span4 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        &nbsp;&nbsp;&nbsp;<label>g/dl</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Suhu Tubuh <span class='required'>*</span>", 'suhu_tubuh', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'suhu_tubuh', array('readonly'=>true,'placeholder' => 'suhu', 'class' => 'span4 float required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        &nbsp;&nbsp;&nbsp;<label>C</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Detak Nadi <span class='required'>*</span>", 'detaknadi', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'detaknadi', array('readonly'=>true,'placeholder' => 'nadi', 'class' => 'span4 numbers-only required', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        &nbsp;&nbsp;&nbsp;<label>x/mnt</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                &nbsp;<?php echo $form->checkBox($model,'is_gagalseleksi',array('disabled'=>true,'onclick'=>'gagalSeleksi(this)','data-toggle' => 'tooltip', 'title' => 'Klik jika pendonor gagal seleksi')); ?> <label>Cek jika pendonor darah ditolak atau gagal</label>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Alasan Ditolak/ Gagal Seleksi</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-gagalseleksi">
                        <div class="row-fluid">
                            <div class="span12">
                            <table width="100%">
                                <tr>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'hb_rendah',array('disabled'=>true,'class'=>'gagal')); ?> <label>HB <</label>
                                    </td>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'medis_lain',array('disabled'=>true,'class'=>'gagal','onclick'=>'cekLain2(this)')); ?> <label>Medis Lain :</label>
                                    </td>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'medis_hb_17',array('disabled'=>true,'class'=>'lain2 gagal')); ?> <label>HB > 17</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'hb_rendah',array('disabled'=>true,'class'=>'gagal')); ?> <label>BB <</label>
                                    </td>
                                    <td></td>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'medis_tk_tinggi',array('disabled'=>true,'class'=>'lain2 gagal')); ?> <label>Tek. Darah ></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'perilakuberesiko',array('disabled'=>true,'class'=>'gagal')); ?> <label>Perilaku Beresiko</label>
                                    </td>
                                    <td></td>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'medis_td_rendah',array('disabled'=>true,'class'=>'lain2 gagal')); ?> <label>Tek. Darah <</label>
                                    </td>           
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'riwberpergian',array('disabled'=>true,'class'=>'gagal')); ?> <label>Riwayat Bepergian</label>
                                    </td>
                                    <td></td>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'medis_bb_lebih',array('disabled'=>true,'class'=>'lain2 gagal')); ?> <label>BB >></label>
                                    </td>   
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'lain_lain',array('disabled'=>true,'class'=>'gagal')); ?> <label>Lain-lain</label>
                                    </td>
                                    <td></td>
                                    <td>
                                        &nbsp;<?php echo $form->checkBox($model,'medis_vaksin',array('disabled'=>true,'class'=>'lain2 gagal')); ?> <label>Vaksin</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Catatan Dokter</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-gagalseleksi">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model, 'catatan_dokter', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo CHtml::activeTextArea($model, 'catatan_dokter', array('readonly'=>true,'class'=>'span4')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tanggal Seleksi <span class='required'>*</span>", 'detaknadi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglseleksidonor',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        'disabled'=>true,
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3 span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Nama Petugas <span class='required'>*</span>", 'petugas_id', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php
                                $nama_pegawai = PegawairuanganV::model()->findByAttributes(array('pegawai_id'=>$model->petugas_id));
                                ?>
                                <input readonly="readonly" class="span3" value="<?php echo $nama_pegawai->nama_pegawai ?>" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label("Nama Dokter <span class='required'>*</span>", 'dokter_id', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php
                                $nama_pegawai = PegawairuanganV::model()->findByAttributes(array('pegawai_id'=>$model->dokter_id));
                                ?>
                                <input readonly="readonly" class="span3" value="<?php echo $nama_pegawai->nama_pegawai ?>" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                

<?php $this->endWidget(); ?>

