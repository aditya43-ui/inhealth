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
                    <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPendaftaran,
                            'attribute' => 'no_pendaftaran',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('autocompletePasien') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                                     $(this).val("");
                                                     return false;
                                                 }',
                                'select' => 'js:function( event, ui ) {
                                                    loadPasien(ui.item);
                                                    return false;
                                                }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialog_pasien'),
                            'htmlOptions' => array(
                                'placeholder' => 'No. Pendaftaran', 'class' => 'all-caps', 'rel' => 'tooltip', 'title' => 'No. pendaftaran / klik icon untuk mencari data kunjungan',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'dokter_pemeriksa', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'dokter_pemeriksa', array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'cara bayar', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'carabayar_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'penjamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'penjamin_nama', array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadPasien(data) {
        $("#RJPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
        $("#RJPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
        $("#RJPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
        $("#RJPendaftaranT_umur").val(data.umur);
        $("#RJPendaftaranT_kelaspelayanan_id").val(data.kelaspelayanan_id);
        $("#RJPendaftaranT_carabayar_id").val(data.carabayar_id);
        $("#RJPendaftaranT_penjamin_id").val(data.penjamin_id);
        $("#RJPendaftaranT_dokter_pemeriksa").val(data.dokter_pemeriksa);
        $("#RJPendaftaranT_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
        $("#RJPasienM_no_rekam_medik").val(data.no_rekam_medik);
        $("#RJPasienM_nama_pasien").val(data.nama_pasien);
        $("#RJPasienM_jeniskelamin").val(data.jeniskelamin);
        $("#RJPendaftaranT_carabayar_nama").val(data.carabayar_nama);
        $("#RJPendaftaranT_penjamin_nama").val(data.penjamin_nama);

        $("#tblListSurveilans tbody").html(data.riwayat);
    }
</script>