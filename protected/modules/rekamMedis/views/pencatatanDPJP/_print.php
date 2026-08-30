<style>
    body {
        color: black;
    }

    .borderclass {
        border: 1px solid black;
    }
</style>
<?php 
    $this->widget('bootstrap.widgets.BootAlert');

    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
    $konfig = KonfigsystemK::model()->find();

    $titleDetail = "RM. 018";
    $header = "FORM PENCATATAN";
    $header2 = "DOKTER PENANGGUNGJAWAB PELAYANAN (PDJP)";
?>
<div style="padding: 20px">
    <div>
        <div class="pull-right"><?php echo $titleDetail; ?></div>
        <br>
            <?php echo $this->renderPartial($this->path_view.'_header', array('pendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'header' => $header, 'header2' => $header2)); ?>
        <br>
        <div class="panel-body">
            <div class="row-fluid">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align: center;" rowspan="2">Diagnosa</th>
                            <th style="text-align: center;" colspan="3">DPJP</th>
                            <th style="text-align: center;" colspan="3">DPJP Utama</th>
                            <th style="text-align: center;" rowspan="2">Keterangan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">Tanggal Mulai</th>
                            <th style="text-align: center;">Tanggal Berakhir</th>
                            <th style="text-align: center;">Nama</th>
                            <th style="text-align: center;">Tanggal Mulai</th>
                            <th style="text-align: center;">Tanggal Berakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                foreach ($modPencatatanDet as $key => $res) {
                            ?>
                            <tr>
                                <th>
                                    <?php
                                        echo $res->diagnosa->diagnosa_nama; 
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        echo $res->dpjp->namaLengkap;
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        echo MyFormatter::formatDateTimeForUser($res->tglmulai_dpjp);
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        echo MyFormatter::formatDateTimeForUser($res->tglberakhir_dpjp);
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        if(!empty($res->pasienadmisi_id)){
                                            $pas = PasienadmisiT::model()->findByPk($res->pasienadmisi_id);

                                            echo $pas->pegawai->namaLengkap;
                                        } else {
                                            $pen = PendaftaranT::model()->findByPk($res->pendaftaran_id);

                                            echo $pen->pegawai->namaLengkap;
                                        }
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        echo MyFormatter::formatDateTimeForUser($res->tglmulai_dpjputama);
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        echo MyFormatter::formatDateTimeForUser($res->tglberakhir_dpjputama);
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        echo $res->keterangan
                                    ?>
                                </th>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </table>
            </div>
        </div>
    </div>
</div>