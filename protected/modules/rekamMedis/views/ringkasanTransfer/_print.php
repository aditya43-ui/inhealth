<style>
    body {
        color: black;
    }

    .borderclass {
        border: 1px solid black;
    }
    table {
        margin-bottom: 0 !important;
    }
    .table-bordered {
        border-collapse: collapse;
    }
    .isiatas1{
        width: 120px;
        margin: 5px 0;
    }        
    .isiatas2{
        text-align: justify;
        text-justify: inter-word;
        margin: 5px 0;
    } 
</style>
<?php 
    $this->widget('bootstrap.widgets.BootAlert');

    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
    $konfig = KonfigsystemK::model()->find();

    $titleDetail = "RM. 009";
    $header = "RINGKASAN TRANSFER PASIEN INTRA RUMAH SAKIT";
?>
<div style="padding: 20px">
    <div>
        <?php echo $this->renderPartial($this->path_view.'_header', array('pendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'header' => $header, 'titleDetail' => $titleDetail)); ?>
        <div class="panel-body">
            <div class="row-fluid">
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Tgl. MRS</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo date('d', strtotime($modelTransfer->tgl_transfer)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($modelTransfer->tgl_transfer))) . ' ' . date('Y', strtotime($modelTransfer->tgl_transfer)); ?>, Jam : <?php echo date('H : i : s', strtotime($modelTransfer->tgl_transfer)) ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Tgl. Transfer</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo date('d', strtotime($modelTransfer->tgl_transfer)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($modelTransfer->tgl_transfer))) . ' ' . date('Y', strtotime($modelTransfer->tgl_transfer)); ?>, Jam : <?php echo date('H : i : s', strtotime($modelTransfer->tgl_transfer)) ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Dari Ruang</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Ke Ruang</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php ?></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Dokter yang merawat</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->dokter_nama; ?></div>
                                </div>
                            </td>
                            <td rowspan="3">
                                <div style="display: flex">
                                    <div class="isiatas1">Nama Petugas Pendamping</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->pendamping1_nama; ?></div>
                                </div>
                                <?php if(!empty($modelTransfer->pendamping2_nama)){ ?>
                                <div style="display: flex">
                                    <div class="isiatas1">Nama Petugas Pendamping 2</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->pendamping2_nama; ?></div>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Indikasi MRS</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->indikasimrs ?></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Alasan transfer</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->alasantransfer ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Derajat Pasien</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->derajatpasien ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Cara Transfer</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->caratransfer ?></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                KONDISI PASIEN SAAT DITRANSFER
                                <div style="display: flex">
                                    <div class="isiatas1">Diagnosa</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diagnosa ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Anamnesa</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->ditransfer_anamnesa ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Kesadaran</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->ditransfer_kesadaran ?></div>
                                </div>
                            </td>
                            <td>
                                Tanda-tanda Vital :
                                <div style="display: flex">
                                    <div class="isiatas1">TD</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->ditransfer_sistolik ?> / <?php echo $modelTransfer->ditransfer_diastolik ?> mmHg</div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Nadi</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->ditransfer_nadi ?> x/mnt</div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Suhu</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->ditransfer_suhu ?> &#176;C</div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Pernafasan</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->ditransfer_pernapasan ?> x/mnt</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td colspan="5" style="text-align: center"><b>OBAT YANG TELAH DIBERIKAN</b></td>
                        </tr>
                        <tr>
                            <td>Nama Obat</td>
                            <td>Dosis</td>
                            <td>Cara Pemberian</td>
                            <td>Jadwal Pemberian</td>
                            <td>Pemberian Terakhir</td>
                        </tr>
                        <?php 
                            $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
                            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                            $modPencatatan = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                            if (!empty($modPencatatan)) { 
                        ?>
                            <?php
                                $pendaftaran_id = $_GET['pendaftaran_id'];
                                foreach($modPencatatan as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo $val->obatalkes->obatalkes_nama ?></td>
                                <td><?php echo $val->kekuatan_oa ?> <?php echo $val->satuankekuatan_oa ?></td>
                                <td><?php echo $val->ket_penggunaan ?></td>
                                <td><?php echo $val->signa_oa ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                KONDISI PASIEN SAAT DITERIMA
                                <div style="display: flex">
                                    <div class="isiatas1">Anamnesa</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diterima_anamnesa ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Kesadaran</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diterima_kesadaran ?></div>
                                </div>
                            </td>
                            <td>
                                Tanda-tanda Vital :
                                <div style="display: flex">
                                    <div class="isiatas1">TD</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diterima_sistolik ?> / <?php echo $modelTransfer->diterima_diastolik ?> mmHg</div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Nadi</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diterima_nadi ?> x/mnt</div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Suhu</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diterima_suhu ?> &#176;C</div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Pernafasan</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->diterima_pernapasan ?> x/mnt</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Berkas yang diberikan</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Foto Rontgen : <?php if($modelTransfer->is_berkasfotorontgen == true){ echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">USG : <?php if($modelTransfer->is_berkasusg == true){ echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Hasil Laboratorium : <?php if($modelTransfer->is_berkashasillab == true){ echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Lain-lain : <?php echo !empty($modelTransfer->berkaslainlain) ? $modelTransfer->berkaslainlain : '-'; ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Alat bantu yang terpasang</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Infus/Transfusi Darah : <?php if($modelTransfer->is_alatbantuinfus == true) { echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Kateter Urine : <?php if($modelTransfer->is_alatbantukateter == true) { echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">NGT : <?php if($modelTransfer->is_alatbantungt == true) { echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Drain : <?php if($modelTransfer->is_alatbantudrain == true) { echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Oksigen : <?php if($modelTransfer->is_alatbantuoksigen == true) { echo '&#10003;'; } else { echo '-'; } ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Keterangan Oksigen: <?php echo !empty($modelTransfer->alatbantuoksigen_ket) ? $modelTransfer->alatbantuoksigen_ket : '-'; ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1"></div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;">Lain-lain : <?php echo !empty($modelTransfer->alabantulainlain) ? $modelTransfer->alabantulainlain : '-'; ?></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex">
                                    <div class="isiatas1">Pemeriksaan Diagnostik yang sudah dilakukan</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->pemeriksaandiagnostik ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Tindakan Terapeutik yang sudah dilakukan</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->tndakanterapeutik ?></div>
                                </div>
                                <div style="display: flex">
                                    <div class="isiatas1">Rencana tindakan yang akan dilakukan</div>
                                    <div class="isiatas2"> : </div> 
                                    <div class="isiatas2" style="margin-left: 5px;"><?php echo $modelTransfer->rencanatindakan ?></div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="items table table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td style="text-align: center">
                                Petugas yang menerima
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                (<?php echo $modelTransfer->petugaspenerima_nama ?>)
                            </td>
                            <td style="text-align: center">
                                Petugas pendamping
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                (<?php echo $modelTransfer->pendamping1_nama ?>)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>