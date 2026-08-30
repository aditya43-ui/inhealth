<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-condensed">
            <thead>
            <th>No.Pendaftaran</th>
            <th>Tanggal Pemeriksaan</th>
            <th>Ruangan</th>
            <th>Nama Pemeriksaan</th>
            <th>Hasil Expertise</th>
            <th>Kesan</th>
            <th>Kesimpulan</th>
            <th>DPJTM</th>
            <?php if(Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_USG_GRIU && Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_XRAY_GRIU){ ?>
            <th>PPDS</th>
            <?php } ?>
            <th>Cetak</th>
            </thead>
            <tbody>
                <?php
                $cek = HasilpemeriksaanradR::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'pasien_id' => $_GET['pasien_id'], 'pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id']));
                foreach ($cek as $value) {
                    $modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $value->pasienmasukpenunjang_id));
                    $cekRuangan = RuanganM::model()->findByPk($value->create_ruangan);
                    $cekPPDS = PpdsM::model()->findByPk($modPasienMasukPenunjang->ppds_id);
                    $cekDPJTM = PegawaiM::model()->findByPk($modPasienMasukPenunjang->pegawai_id);
                    $pendaftaran = PendaftaranT::model()->findByPk($modPasienMasukPenunjang->pendaftaran_id);
                    $cekPemeriksaan = PemeriksaanradM::model()->findByPk($value->pemeriksaanrad_id);
                    ?>
                    <tr>
                        <td><?php echo $pendaftaran->no_pendaftaran; ?></td>
                        <td><?php echo $value->tglpengambilanhasilrad; ?></td>
                        <td><?php echo $cekRuangan->ruangan_nama; ?></td>
                        <td><?php echo $cekPemeriksaan->pemeriksaanrad_nama; ?></td>
                        <td><?php echo $value->hasilexpertise; ?></td>
                        <td><?php echo $value->kesan_hasilrad; ?></td>
                        <td><?php echo $value->kesimpulan_hasilrad; ?></td>
                        <td><?php echo!empty($cekDPJTM) ? $cekDPJTM->namaLengkap : ''; ?></td>
                        <?php if(Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_USG_GRIU && Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_XRAY_GRIU){ ?>
                        <td><?php echo!empty($cekPPDS) ? $cekPPDS->ppds_nama : ''; ?></td>
                        <?php } ?>
                        <td>
                            <?php
                            $criRadioligi = new CDbCriteria();
                            $criRadioligi->addCondition("pendaftaran_id = :pendaftaran_id AND pasienmasukpenunjang_id = :pasienmasukpenunjang_id AND riwayathasilpemeriksaanrad_id = :riwayathasilpemeriksaanrad_id");
                            $criRadioligi->params[':pendaftaran_id'] = $_GET['pendaftaran_id'];
                            $criRadioligi->params[':pasienmasukpenunjang_id'] = $_GET['pasienmasukpenunjang_id'];
                            $criRadioligi->params[':riwayathasilpemeriksaanrad_id'] = $value->riwayathasilpemeriksaanrad_id;
                            $modpemeriksaanRad = HasilpemeriksaanradR::model()->find($criRadioligi);

                            if (!empty($modpemeriksaanRad) || !empty($modpemeriksaanRad->tglverifikasi_dpjp)) {
                                ?>
                                <div style="text-align: center; font-size: 11pt;">
                                <?php echo CHtml::link("<i class='" . MyIcon::getIcons('cetak') . "'></i> Cetak", 'javascript:;', array('rel' => 'tooltip', 'title' => 'Klik button/ikon ini, jika anda ingin mencetak hasil pemeriksaan ini ', 'data-html' => true, 'onclick' => 'printPemeriksaanRadiologi(' . $value->riwayathasilpemeriksaanrad_id . ',\'PRINT\')', 'class' => 'btn btn-info', 'style' => 'color:#fff !important;')); ?>
                                </div>
                                <?php } else {
                                ?>
                                <div style="text-align: center; font-size: 11pt;"> 
                                    <?php
                                    echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-print"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-info', 'style' => 'color:#fff !important;',
                                        'onclick' => 'myAlert("Hasil Expertise Perlu Verifikasi DPJTM"); return false;'));
                                    ?>
                                </div>    
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>