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

    $titleDetail = "RM. 021";
    $header = "CHECK LIST PASIEN PRE OPERASI";
?>
<div style="padding: 20px">
    <div>
        <div class="pull-right"><?php echo $titleDetail; ?></div>
        <br>
            <?php echo $this->renderPartial($this->path_view.'_header', array('pendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'header' => $header)); ?>
        <br>
        <div class="panel-body">
            <div class="row-fluid">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tindakan</th>
                            <th>Ya</th>
                            <th>Tidak</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <th>Memberi penjelasan pada pasien</th>
                            <?php if($modCeklist->is_penjelasanpadapasien == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_penjelasanpadapasien ?></th>
                        </tr>
                        <tr>
                            <th>2</th>
                            <th>Surat persetujuan operasi dan pembiusan</th>
                            <?php if($modCeklist->is_suratpersetujuanoperasi == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_suratpersetujuanoeprasi ?></th>
                        </tr>
                        <tr>
                            <th>3</th>
                            <th>Surat persetujuan biaya</th>
                            <?php if($modCeklist->is_suratpersetujuanbiaya == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_suratpersetujuanbiaya ?></th>
                        </tr>
                        <tr>
                            <th>4</th>
                            <th>Lembar hasil pemeriksaan :</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>- Laboratorium</th>
                            <?php if($modCeklist->is_hasillaboratorium == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_hasillaboratorium ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>- ECG</th>
                            <?php if($modCeklist->is_hasilecg == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_hasilecg ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>- Rontgent</th>
                            <?php if($modCeklist->is_hasilrontgen == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_hasilrontgen ?></th>
                        </tr>
                        <tr>
                            <th>5</th>
                            <th>Alat bantu ( gigi palsu - mata palsu - kaca mata - kaki palsu - tangan palsu ) sudah di lepas</th>
                            <?php if($modCeklist->is_alatbantu == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_alatbantu ?></th>
                        </tr>
                        <tr>
                            <th>6</th>
                            <th>Perhiasan sudah dilepas</th>
                            <?php if($modCeklist->is_perhiasandilepas == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_perhiasandilepas ?></th>
                        </tr>
                        <tr>
                            <th>7</th>
                            <th>Mandi / Kebersihan badan</th>
                            <?php if($modCeklist->is_kebersihanbadan == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_kebersihanbadan ?></th>
                        </tr>
                        <tr>
                            <th>8</th>
                            <th>Puasa</th>
                            <?php if($modCeklist->is_puasa == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th>MMT : <?php echo $modCeklist->ket_puasa ?></th>
                        </tr>
                        <tr>
                            <th>9</th>
                            <th>Cukur daerah sekitar operasi</th>
                            <?php if($modCeklist->is_cukurdaerahoperasi == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_cukurdaerahoeprasi ?></th>
                        </tr>
                        <tr>
                            <th>10</th>
                            <th>Beri savion daerah sekitar operasi</th>
                            <?php if($modCeklist->is_berisavlondaerahoperasi == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_berisavlondaerahoperasi ?></th>
                        </tr>
                        <tr>
                            <th>11</th>
                            <th>Lavement 1</th>
                            <?php if($modCeklist->is_lavement1 == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th>Pukul : <?php echo $modCeklist->ekt_lavement1 ?></th>
                        </tr>
                        <tr>
                            <th>12</th>
                            <th>Lavement 2</th>
                            <?php if($modCeklist->is_lavement2 == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th>Pukul : <?php echo $modCeklist->ket_lavement2 ?></th>
                        </tr>
                        <tr>
                            <th>13</th>
                            <th>Terpasang cairan</th>
                            <?php if($modCeklist->is_terpasangcairan == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th>Cairan ke : <?php echo $modCeklist->ket_terpasangcarian ?></th>
                        </tr>
                        <tr>
                            <th>14</th>
                            <th>Terpasang maagslag</th>
                            <?php if($modCeklist->is_terpasangmaagslag == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_terpasangmaagslag ?></th>
                        </tr>
                        <tr>
                            <th>15</th>
                            <th>Terpasang kateter</th>
                            <?php if($modCeklist->is_terpasangkateter == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_terpasangkateter ?></th>
                        </tr>
                        <tr>
                            <th>16</th>
                            <th>Tanda - Tanda Vital</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Tensi : <?php echo $modCeklist->tensi_sistolik ?> / <?php echo $modCeklist->tensi_diastolik ?> mmHg</th>
                            <?php if($modCeklist->is_tensi_sistolik == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_tensi_sistolik ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Nadi : <?php echo $modCeklist->nadi ?> x/mnt</th>
                            <?php if($modCeklist->is_nadi == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_nadi ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Suhu : <?php echo $modCeklist->suhu ?> &#176;C</th>
                            <?php if($modCeklist->is_suhu == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_suhu ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>RR : <?php echo $modCeklist->rr ?> x/mnt</th>
                            <?php if($modCeklist->is_rr == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_rr ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>BB : <?php echo $modCeklist->bb ?> kg</th>
                            <?php if($modCeklist->is_bb == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_bb ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>TB : <?php echo $modCeklist->tb ?> cm</th>
                            <?php if($modCeklist->is_tb == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_tb ?></th>
                        </tr>
                        <tr>
                            <th>17</th>
                            <th>Lain - lain</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>a. Terapi <br> <?php echo $modCeklist->lainlainterapi ?></th>
                            <?php if($modCeklist->is_lainlainterapi == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_lainlainterapi ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>b. Premedikasi <br> <?php echo $modCeklist->lainlainpremedikasi ?></th>
                            <?php if($modCeklist->is_lainlainpremedikasi == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_lainlainpremedikasi ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>c. Riwayat Pengobatan <br> <?php echo $modCeklist->lainlainriwayatpengobatan ?></th>
                            <?php if($modCeklist->is_lainlainriwayatpengobatan == true){ ?>
                                <th>&#10004;</th>
                                <th></th>
                            <?php } else { ?>
                                <th></th>
                                <th>&#10004;</th>
                            <?php } ?>
                            <th><?php echo $modCeklist->ket_lainlainriwayatpengobatan ?></th>
                        </tr>
                    </tbody>
                </table>

                <table width="100%">
                    <tr>
                        <td width="50%" style="text-align:center;">Petugas Kamar Operasi</td>
                        <td width="50%" style="text-align:center;">Peetugas Rawat Inap</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="min-height:100px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">( <?php echo !empty($modCeklist->petugasok) ? $modCeklist->petugasok->namaLengkap : '-' ?> )</td>
                        <td style="text-align:center;">( <?php echo !empty($modCeklist->pertugasrawatinap) ? $modCeklist->pertugasrawatinap->namaLengkap : '-' ?> )</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>