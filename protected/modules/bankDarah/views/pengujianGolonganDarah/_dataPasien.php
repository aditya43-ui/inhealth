<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai view detail nama pendonor
 * RSST-1471
 */
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?php
            if (!isset($_GET['permintaandarah_id']) && !isset($_GET['permintaandarah_id'])) {
            ?>
                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pasien_id', array());
                        echo $form->hiddenField($model, 'pendaftaran_id');
                        echo $form->hiddenField($model, 'permintaandarah_id');

                        echo CHtml::hiddenField('pasien_id');
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPendaftaran,
                            'attribute' => 'no_pendaftaran',
                            //'name'=>'no_pendaftaran',
                            'source' => 'js: function(request, response) {
                                                         $.ajax({
                                                             url: "' . $this->createUrl('AutocompletePendaftaran') . '",
                                                             dataType: "json",
                                                             data: {
                                                                 no_pendaftaran: request.term,
                                                             },
                                                             success: function (data) {
                                                                     response(data);
                                                             }
                                                         })
                                                      }',
                            'options' => array(
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                                       $(this).val( "");
                                                       return false;
                                                   }',
                                'select' => 'js:function( event, ui ) {
                                                      $(this).val( ui.item.pendaftaran_id);
                                                      $("#' . CHtml::activeId($modPendaftaran, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);
                                                      return false;
                                                  }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKunjungan'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Pendaftaran', 'class' => 'all-caps', 'rel' => 'tooltip', 'title' => 'No. Pendaftaran',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <?php echo $form->textFieldRow($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
            <?php
            }
            ?>
            <?php echo $form->textFieldRow($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>

            <div class="control-group">
                <label class="control-label">Ruangan</label>
                <div class="controls">
                    <?php echo $form->textField($modKirim, 'ruangan_nama', array('readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Kelas Pelayanan</label>
                <div class="controls">
                    <?php echo $form->textField(!empty($modPendaftaran->kelaspelayanan) ? $modPendaftaran->kelaspelayanan : $modPendaftaran, 'kelaspelayanan_nama', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Diagnosis</label>
                <div class="controls">
                    <?php echo $form->textField($modKirim, 'diagnosa_nama', array('readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Penjamin</label>
                <div class="controls">
                    <?php echo $form->textField(!empty($modPendaftaran->penjamin) ? $modPendaftaran->penjamin : $modPendaftaran, 'penjamin_nama', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dokter Yang Menanangani</label>
                <div class="controls">
                    <?php echo $form->textField($modKunjungan, 'nama_pegawai', array('readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label for="" class="control-label">no. Formulir</label>
                <div class="controls">
                    <?php echo $form->textField($modKunjungan, 'labregno_lis', array('readonly' => true)); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPasien, 'no_rekam_medik', array('readonly' => true)); ?>
            <?php echo $form->textFieldRow($modPasien, 'nama_pasien', array('readonly' => true)); ?>
            <div class="control-group">
                <label for="" class="control-label">Jenis Permintaan</label>
                <div class="controls">
                    <?php echo $form->textField($modKunjungan, 'jeniskantongdarah_singkatan', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Jumlah Permintaan</label>
                <div class="controls">
                    <?php echo $form->textField($modKunjungan, 'jumlahpermintaan', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Jumlah Dilayani</label>
                <div class="controls">
                    <?php echo $form->textField($modKunjungan, 'jumlahdilayani', array('readonly' => true)); ?>
                </div>
            </div>

            <div class="control-group hide">
                <label class="control-label">Golongan Darah/ Rhesus</label>
                <div class="controls">
                    <?php echo $form->textField($modPasien, 'golongandarah', array('readonly' => true)); ?>
                </div>
            </div>

            
        </div>
    </div>
</div>