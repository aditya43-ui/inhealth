<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">

        <table style="width: 100%;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly' => true)); ?></td>

                <td>
                    <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); 
                    ?>
                    <label class="control-label" for="noRekamMedik">No. Rekam Medik</label>
                </td>
                <td>
                    <?php echo CHtml::textField('FAPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly' => true)); ?>
                    <?php
                    //                    $this->widget('MyJuiAutoComplete', array(
                    //                                    'name'=>'FAPasienM[no_rekam_medik]',
                    //                                    'value'=>$modPasien->no_rekam_medik,
                    //                                    'source'=>'js: function(request, response) {
                    //                                                   $.ajax({
                    //                                                       url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasien').'",
                    //                                                       dataType: "json",
                    //                                                       data: {
                    //                                                           term: request.term,
                    //                                                       },
                    //                                                       success: function (data) {
                    //                                                               response(data);
                    //                                                       }
                    //                                                   })
                    //                                                }',
                    //                                     'options'=>array(
                    //                                           'showAnim'=>'fold',
                    //                                           'minLength' => 2,
                    //                                           'focus'=> 'js:function( event, ui ) {
                    //                                                $(this).val(ui.item.value);
                    //                                                return false;
                    //                                            }',
                    //                                           'select'=>'js:function( event, ui ) {
                    //                                                isiDataPasien(ui.item);
                    //                                                loadPembayaran(ui.item.pendaftaran_id);
                    //                                                return false;
                    //                                            }',
                    //                                    ),
                    //                                )); 
                    ?>
                </td>
                <td rowspan="5">
                    <?php
                    if (!empty($modPasien->photopasien)) {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPendaftaranT[umur]', $modPendaftaran->umur, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPendaftaranT[jeniskasuspenyakit_nama]', (isset($modPendaftaran->jeniskasuspenyakit) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : ""), array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPasienM[nama_bin]', $modPasien->nama_bin, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id', array('class' => 'control-label')); ?></td>
                <td>
                    <?php echo CHtml::textField('FAPendaftaranT[instalasi_nama]', (isset($modPendaftaran->instalasi) ? $modPendaftaran->instalasi->instalasi_nama : ""), array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('FAPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('FAPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('FAPendaftaranT[ruangan_nama]', (isset($modPendaftaran->ruangan) ? $modPendaftaran->ruangan->ruangan_nama : ""), array('readonly' => true)); ?></td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
    function isiDataPasien(data) {
        $('#FAPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
        $('#FAPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
        $('#FAPendaftaranT_umur').val(data.umur);
        $('#FAPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
        $('#FAPendaftaranT_instalasi_nama').val(data.namainstalasi);
        $('#FAPendaftaranT_ruangan_nama').val(data.namaruangan);
        $('#FAPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#FAPendaftaranT_pasien_id').val(data.pasien_id);

        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_nama_pasien').val(data.namapasien);
        $('#FAPasienM_nama_bin').val(data.namabin);
    }

    function loadPembayaran(pendaftaran_id) {
        $.post('<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/loadPembayaran'); ?>', {
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            $('#tblBayarTind tbody').html(data.formBayarTindakan);
            $('#tblBayarOA tbody').html(data.formBayarOa);
            $('#TandabuktibayarT_jmlpembayaran').val(data.jmlpembayaran);
            $('#totTagihan').val(data.tottagihan);

            $('#TandabuktibayarT_jmlpembulatan').val(data.jmlpembulatan);
            $('#TandabuktibayarT_uangditerima').val(data.uangditerima);
            $('#TandabuktibayarT_uangkembalian').val(data.uangkembalian);
            $('#TandabuktibayarT_biayamaterai').val(data.biayamaterai);
            $('#TandabuktibayarT_biayaadministrasi').val(data.biayaadministrasi);
            $('#TandabuktibayarT_darinama_bkm').val(data.namapasien);
            $('#TandabuktibayarT_alamat_bkm').val(data.alamatpasien);
        }, 'json');
    }
</script>