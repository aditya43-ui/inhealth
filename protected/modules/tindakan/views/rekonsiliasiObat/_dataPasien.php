<?php
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);
$modPendaftaran->no_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) . '' . (!empty($modPendaftaran->no_pendaftaran) ? "/ \n" . $modPendaftaran->no_pendaftaran : "");
$modPendaftaran->ruangan_nama = (!empty($modPendaftaran->pasienadmisi) ? (!empty($modPendaftaran->pasienadmisi->ruangan) ? $modPendaftaran->pasienadmisi->ruangan->ruangan_nama : (!empty($modPendaftaran->ruangan) ? $modPendaftaran->ruangan->ruangan_nama : "")) : (!empty($modPendaftaran->ruangan) ? $modPendaftaran->ruangan->ruangan_nama : ""));
$modPendaftaran->carabayar_nama = (!empty($modPendaftaran->pasienadmisi) ? (!empty($modPendaftaran->pasienadmisi->carabayar) ? $modPendaftaran->pasienadmisi->carabayar->carabayar_nama : (!empty($modPendaftaran->carabayar) ? $modPendaftaran->carabayar->carabayar_nama : "")) : (!empty($modPendaftaran->carabayar) ? $modPendaftaran->carabayar->carabayar_nama : "")) . '' . (!empty($modPendaftaran->pasienadmisi) ? "/ \n" . (!empty($modPendaftaran->pasienadmisi->penjamin) ? $modPendaftaran->pasienadmisi->penjamin->penjamin_nama : (!empty($modPendaftaran->penjamin) ? $modPendaftaran->penjamin->penjamin_nama : "")) : (!empty($modPendaftaran->penjamin) ? "/ \n" . $modPendaftaran->penjamin->penjamin_nama : ""));
?>
<?php
if (!empty($modPasien)) {
?>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data Pasien
            </div>
        </div>
        <div class="panel-body">
            <table width="100%" class="table-condensed">
                <tr>
                    <td>
                        <?php echo CHtml::Label('Nama Pasien', '', array('class' => 'control-label')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::hiddenField('ruanganpendaftaran_id', $modPendaftaran->ruangan_id); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('readonly' => true)); ?>
                        <?php
                        if (isset($_GET['pendaftaran_id']) && !empty($_GET['pendaftaran_id'])) {
                            echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true));
                        } else {
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPasien,
                                'attribute' => 'nama_pasien',
                                'source' => 'js: function(request, response) {
                            $.ajax({
                              url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
                              dataType: "json",
                              data: {
                                nama_pasien: request.term
                              },
                              success: function (data) {
                                response(data);
                              }
                            })
                          }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
                              $(this).val("");
                              return false;
                            }',
                                    'select' => 'js:function( event, ui ) {
                              $(this).val(ui.item.value);
                              $("#' . CHtml::activeId($modPendaftaran, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
                              $("#' . CHtml::activeId($modPasien, 'no_rekam_medik') . '").val(ui.item.no_rekam_medik);
                              $("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").val(ui.item.tanggal_lahir);
                              $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);
                              $("#' . CHtml::activeId($modPasien, 'dokterpemeriksaLengkap') . '").val(ui.item.permintaanpembelian_id);
                              $(".tab_rekonobat").parents("ul").find("li").each(function(){
                                  $(this).removeClass("active");
                              });
                                var frameObj = document.getElementById("frame");
                                $(frameObj).html("");
                                $(frameObj).attr("src","");
                              return false;
                            }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketik Nama Pasien', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik Nama Pasien / klik icon untuk mencari data Pasien',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                        }
                        ?>
                    </td>
                    <?php if (Yii::app()->user->getState("ruangan_id") == 59) { ?>
                        <td><?php echo CHtml::Label('Dokter DPJP', '', array('class' => 'control-label')); ?></td>
                        <td>
                            <?php
                            $namaDokterPemeriksa = "";
                            if (isset($_GET['pendaftaran_id']) && !empty($_GET['pendaftaran_id'])) {
                                if (!empty($modPendaftaran->pasienadmisi_id)) {
                                    $namaDokterPemeriksa = (isset($modPendaftaran->pasienadmisi) ? (isset($modPendaftaran->pasienadmisi->dokpenerima) ? $modPendaftaran->pasienadmisi->dokpenerima->namaLengkap : "") : "");
                                } else {
                                    $namaDokterPemeriksa = (isset($modPendaftaran->dokter) ? $modPendaftaran->dokter->namaLengkap : "");
                                }
                            }
                            echo CHtml::textField('dokterpemeriksaLengkap', $namaDokterPemeriksa, array('readonly' => true)); ?>
                        </td>
                    <?php } else { ?>
                        <td><?php echo CHtml::Label('No RM', '', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>
                        <?php echo CHtml::Label('Tanggal Lahir', '', array('class' => 'control-label')); ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly' => true)); ?></td>
                    <?php if (Yii::app()->user->getState("ruangan_id") == 59) { ?>
                        <td>
                            <?php echo CHtml::Label('Status Periksa', '', array('class' => 'control-label')); ?>
                        </td>
                        <td><?php echo CHtml::activeTextField($modPendaftaran, 'statusperiksa', array('readonly' => true)); ?></td>
                    <?php } else { ?>
                        <td><?php echo CHtml::Label('Dokter DPJP', '', array('class' => 'control-label')); ?></td>
                        <td>
                            <?php
                            $namaDokterPemeriksa = "";
                            if (isset($_GET['pendaftaran_id']) && !empty($_GET['pendaftaran_id'])) {
                                if (!empty($modPendaftaran->pasienadmisi_id)) {
                                    $namaDokterPemeriksa = (isset($modPendaftaran->pasienadmisi) ? (isset($modPendaftaran->pasienadmisi->dokpenerima) ? $modPendaftaran->pasienadmisi->dokpenerima->namaLengkap : "") : "");
                                } else {
                                    $namaDokterPemeriksa = (isset($modPendaftaran->dokter) ? $modPendaftaran->dokter->namaLengkap : "");
                                }
                            }
                            echo CHtml::textField('dokterpemeriksaLengkap', $namaDokterPemeriksa, array('readonly' => true)); ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                    <?php if (Yii::app()->user->getState("ruangan_id") == 59) { ?>
                        <td><?php echo CHtml::label('Ruangan Perawatan Terakhir', '', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPendaftaran, 'ruangan_nama', array('readonly' => true)); ?></td>
                    <?php } ?>
                </tr>
                <?php if (Yii::app()->user->getState("ruangan_id") == 59) { ?>
                    <tr>
                        <td><?php echo CHtml::label('No. RM', '', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                        <td><?php echo CHtml::label('Jenis Penjamin/ Penjamin', '', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextArea($modPendaftaran, 'carabayar_nama', array('readonly' => true)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo CHtml::label('Tgl. Pendaftaran/ No. Pendaftaran', '', array('class' => 'control-label')); ?></td>
                        <td><?php echo CHtml::activeTextArea($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
<?php
$drop_look = LookupM::getItems('statusperiksa');
unset($drop_look[Params::STATUSPERIKSA_BATAL_PERIKSA]);
// unset($drop_look[Params::STATUSPERIKSA_ANTRIAN]);
// unset($drop_look[Params::STATUSPERIKSA_SEDANG_DIRAWATINAP]);
// unset($drop_look[Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO]);
// unset($drop_look[Params::STATUSPERIKSA_SUDAH_DIPERIKSA]);
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogPasien = new RJInfokunjunganrjrdriV('searchDialogPasienRekonsiliasiOA');
$modDialogPasien->unsetAttributes();
if (isset($_GET['RJInfokunjunganrjrdriV'])) {
    $modDialogPasien->attributes = $_GET['RJInfokunjunganrjrdriV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datakunjungan-grid',
    'dataProvider' => $modDialogPasien->searchDialogPasienRekonsiliasiOA(),
    'filter' => $modDialogPasien,
    //'template'=>"{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use ($modPendaftaran, $modPasien) {
                $data->tanggal_lahir = MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $pendaftaran->no_pendaftaran = MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran) . ' / \n' . $pendaftaran->no_pendaftaran;
                $namaDokter = "";
                $pasienadmisiid = "";
                $ruangan = "";
                $carabayar_nama = "";
                if (!empty($pendaftaran->pasienadmisi_id)) {
                    if ($data->instalasi_id == Params::INSTALASI_ID_RI) {
                        $pasienadmisiid = $pendaftaran->pasienadmisi_id;
                    }
                    $ruangan = (isset($pendaftaran->pasienadmisi) ? $pendaftaran->pasienadmisi->ruangan->ruangan_nama : "");
                    $carabayar_nama = (isset($pendaftaran->pasienadmisi) ? $pendaftaran->pasienadmisi->carabayar->carabayar_nama : "") . '/ \n' . (isset($pendaftaran->pasienadmisi) ? $pendaftaran->pasienadmisi->penjamin->penjamin_nama : "");
                    $namaDokter = (isset($pendaftaran->pasienadmisi) ? (isset($pendaftaran->pasienadmisi->dokpenerima) ? $pendaftaran->pasienadmisi->dokpenerima->namaLengkap : "") : "");
                } else {
                    $namaDokter = (isset($pendaftaran->dokter) ? $pendaftaran->dokter->namaLengkap : "");
                    $ruangan = $pendaftaran->ruangan->ruangan_nama;
                    $carabayar_nama = $pendaftaran->carabayar->carabayar_nama . '/ \n' . $pendaftaran->penjamin->penjamin_nama;
                }
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array(
                    "class" => "btn-small",
                    "id" => "selectPasien",
                    "onclick" => '$("#' . CHtml::activeId($modPendaftaran, 'pendaftaran_id') . '").val("' . $data->pendaftaran_id . '");
                                $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val("' . $data->nama_pasien . '");
                                $("#' . CHtml::activeId($modPasien, 'no_rekam_medik') . '").val("' . $data->no_rekam_medik . '");
                                $("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").val("' . $data->tanggal_lahir . '");
                                $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val("' . $data->jeniskelamin . '");
                                $("#' . CHtml::activeId($modPendaftaran, 'no_pendaftaran') . '").val("' . $pendaftaran->no_pendaftaran . '");
                                $("#' . CHtml::activeId($modPendaftaran, 'statusperiksa') . '").val("' . $pendaftaran->statusperiksa . '");
                                $("#' . CHtml::activeId($modPendaftaran, 'ruangan_nama') . '").val("' . $ruangan . '");
                                $("#' . CHtml::activeId($modPendaftaran, 'carabayar_nama') . '").val("' . $carabayar_nama . '");
                                $("#dokterpemeriksaLengkap").val("' . $namaDokter . '");
                                getRiwayatData(' . $data->pendaftaran_id . ');
                                $(".tab_rekonobat").parents("ul").find("li").each(function(){
                                    $(this).removeClass("active");
                                });
                                  var frameObj = document.getElementById("frame");
                                  $(frameObj).html("");
                                  $(frameObj).attr("src","");
                                '
                        . ' $(\'#dialogPasien\').dialog(\'close\');'
                ));
            },
        ),
        array(
            'header' => 'No Pendaftaran',
            'name' => 'no_pendaftaran',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->no_pendaftaran;
            },
        ),
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => false,
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('RJInfokunjunganrjrdriV[jeniskelamin]', $modDialogPasien->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '--Pilih--')),
        ),
        'instalasi_nama',
        'ruangan_nama',
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'filter' =>  CHtml::activeDropDownList($modDialogPasien, 'statusperiksa', $drop_look, array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                return Params::getWrStatusPeriksa($data->statusperiksa);
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
////======= end pendaftaran dialog =============
?>