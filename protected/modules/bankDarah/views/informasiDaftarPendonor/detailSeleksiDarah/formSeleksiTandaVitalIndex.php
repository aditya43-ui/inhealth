<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'seleksidonordarahtandavital-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '',
        ));
?>
<style>
    .ubahinline > div > .radio{
        display: inline-block;
        padding-right:10px;
    }
</style>
<div class="panel-body">
    <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
    <?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly' => true)); ?>


    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title"><span class='judul'>Seleksi Donor Darah</span></div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <?php
                if ($model->is_gagalseleksi == true) {
                    ?>
                    <span class="span12" style="text-align: center" id="label_status"><h3>Tidak Lolos Seleksi</h3></span>
                    <?php
                }
                ?>
                <div class="span12">
                    <?php
                    echo $form->radioButtonListInlineRow($model, 'jenisdonor', LookupM::getItems('jenisdonor'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 seleksi', 'readonly' => true, 'disabled' => true));
                    ?>
                    <div class="control-group">
                        <?php echo CHtml::label("Tekanan Darah", 'tekanandarah', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'td_systolic', array('placeholder' => 'systolic', 'class' => 'span2 numbers-only seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);", "maxlength" => 3, 'readonly' => true)); ?>
                            &nbsp;&nbsp;&nbsp;<label>/</label>&nbsp;&nbsp;&nbsp;
                            <?php echo $form->textField($model, 'td_diastoliic', array('placeholder' => 'diastolic', 'class' => 'span2 numbers-only seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);", "maxlength" => 3, 'readonly' => true)); ?>
                            &nbsp;&nbsp;&nbsp;<label>mmHg</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Kadar Hemoglobin", 'kadar_hb', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'kadar_hb', array('placeholder' => 'hb', 'class' => 'span4 float seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);", "maxlength" => 3, 'readonly' => true)); ?>
                            &nbsp;&nbsp;&nbsp;<label>g/dl</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Suhu Tubuh", 'suhu_tubuh', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'suhu_tubuh', array('placeholder' => 'suhu', 'class' => 'span4  float seleksi', 'onkeyup' => "return $(this).focusNextInputField(event);", "maxlength" => 3, 'readonly' => true)); ?>
                            &nbsp;&nbsp;&nbsp;<label>&#8451;</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Detak Nadi", 'detaknadi', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'detaknadi', array('placeholder' => 'nadi', 'class' => 'span4 numbers-only seleksi required', 'onkeyup' => "return $(this).focusNextInputField(event);", "maxlength" => 3, 'readonly' => true)); ?>
                            &nbsp;&nbsp;&nbsp;<label>x/mnt</label>
                        </div>
                    </div>
                    <div class="control-group ubahinline" >      
                        <label class="control-label required">Gol Darah</label>
                        <div class="controls">
                            <?php echo $form->radioButtonList($model, 'gol_darah', array("A" => "A", "B" => "B", "O" => "O", "AB" => "AB"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'disabled' => true)); ?>
                        </div>
                    </div>

                    <div class="control-group ubahinline" >  
                        <label class="control-label required">Rhesus</label>
                        <div class="controls">
                            <?php echo $form->radioButtonList($model, 'rhesus', array("Positif" => "Positif", "Negatif" => "Negatif"), array('onkeyup' => "return $(this).focusNextInputField(event)", 'disabled' => true)); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="panel panel-success panel-shadow">
        &nbsp;<?php echo $form->checkBox($model, 'is_gagalseleksi', array('disabled' => true, 'onclick' => 'gagalSeleksi(this)', 'data-toggle' => 'tooltip', 'title' => 'Klik jika pendonor gagal seleksi')); ?> <label>Cek jika pendonor darah ditolak atau gagal</label>
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
                                    &nbsp;<?php echo $form->checkBox($model, 'hb_rendah', array('disabled' => true, 'class' => 'gagal')); ?> <label>HB <</label>
                                </td>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'medis_lain', array('disabled' => true, 'class' => 'gagal', 'onclick' => 'cekLain2(this)')); ?> <label>Medis Lain :</label>
                                </td>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'medis_hb_17', array('disabled' => true, 'class' => 'lain2 gagal')); ?> <label>HB > 17</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'hb_rendah', array('disabled' => true, 'class' => 'gagal')); ?> <label>BB <</label>
                                </td>
                                <td></td>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'medis_tk_tinggi', array('disabled' => true, 'class' => 'lain2 gagal')); ?> <label>Tek. Darah ></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'perilakuberesiko', array('disabled' => true, 'class' => 'gagal')); ?> <label>Perilaku Beresiko</label>
                                </td>
                                <td></td>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'medis_td_rendah', array('disabled' => true, 'class' => 'lain2 gagal')); ?> <label>Tek. Darah <</label>
                                </td>           
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'riwberpergian', array('disabled' => true, 'class' => 'gagal')); ?> <label>Riwayat Bepergian</label>
                                </td>
                                <td></td>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'medis_bb_lebih', array('disabled' => true, 'class' => 'lain2 gagal')); ?> <label>BB >></label>
                                </td>   
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'lain_lain', array('disabled' => true, 'class' => 'gagal')); ?> <label>Lain-lain</label>
                                </td>
                                <td></td>
                                <td>
                                    &nbsp;<?php echo $form->checkBox($model, 'medis_vaksin', array('disabled' => true, 'class' => 'lain2 gagal')); ?> <label>Vaksin</label>
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
                            <?php echo CHtml::activeLabel($model, 'catatan_dokter', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextArea($model, 'catatan_dokter', array('readonly' => true, 'class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="panel-body overflow-x" >    
        <table>
            <tr>
                <td>
                    <?php echo CHtml::label("Tanggal Seleksi &nbsp;&nbsp;", 'detaknadi', array('class' => 'control-label')); ?>
                </td>
                <td>
                    <input readonly="readonly" class="span3" value="<?php echo $model->tglseleksidonor ?>" type="text">
                </td>
                <td>
                    <?php echo CHtml::label("Nama DPJP &nbsp;&nbsp;", 'dokter_id', array('class' => 'control-label')); ?>
                </td>
                <td>
                    <?php
                    $nama_dokter = '-';
                    if (!empty($model->dpjpkuesioner_id)) {
                        $dokter = PegawaiM::model()->findByAttributes(array('pegawai_id' => $model->dpjpkuesioner_id));
                        if (!empty($dokter)) {
                            $nama_dokter = $dokter->namaLengkap;
                        }
                    }
                    ?>
                    <input readonly="readonly" class="span3" value="<?php echo $nama_dokter ?>" type="text">
                </td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <?php echo CHtml::label("Nama Petugas &nbsp;&nbsp;", 'petugaskuesioner_id', array('class' => 'control-label')); ?>
                </td>
                <td>
                    <?php
                    $nama_pegawai = '-';
                    if (!empty($model->petugaskuesioner_id)) {
                        $pegawai = PegawaiM::model()->findByAttributes(array('pegawai_id' => $model->petugaskuesioner_id));
                        if (!empty($pegawai)) {
                            $nama_pegawai = $pegawai->namaLengkap;
                        }
                    }
                    ?>
                    <input readonly="readonly" class="span3" value="<?php echo $nama_pegawai ?>" type="text">
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>

</div>


<?php $this->endWidget(); ?>