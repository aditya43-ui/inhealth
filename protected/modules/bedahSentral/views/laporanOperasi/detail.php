<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    .fa{
        font-size: 12pt;
    }
    body {
        color: black;
    }

    .table-custom th, .table-custom td{
        padding: 10px;
    }


    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }

    .text-center{
        text-align: center !important;
    }
</style>

<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Informasi Bedah</div>
    </div>
    <div class="panel-body">
        <table width="100%" class="table-custom">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" class="table-custom">
                        <tr>
                            <td width="150px">Pilih Tindakan Operasi</td>
                            <td width="5px">:</td>
                            <td><?php echo $model->operasi->operasi_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Operasi</td>
                            <td>:</td>
                            <td>
                            <span class="<?php echo (($model->is_cyto != null && $model->is_cyto==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Cito
                            <span style="padding-left: 20px" class="<?php echo (($model->is_cyto==false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Elektif   
                        </td>
                        </tr>
                        <tr>
                            <td>Golongan Operasi</td>
                            <td>:</td>
                            <td><?php echo $model->golonganoperasi_keterangan; ?></td>
                        </tr>
                        <tr>
                            <td>Dokter Bedah</td>
                            <td>:</td>
                            <td><?php echo (!empty($rencana->dokter1)?$rencana->dokter1->namaLengkap:""); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>:</td>
                            <td><?php echo ""; ?></td>
                        </tr>
                        <tr>
                            <td>Asisten Bedah</td>
                            <td>:</td>
                            <td><?php echo (!empty($rencana->dokter2)?$rencana->dokter2->namaLengkap:""); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>:</td>
                            <td><?php echo ""; ?></td>
                        </tr>
                        <tr>
                            <td>Dokter Anestesi</td>
                            <td>:</td>
                            <td><?php echo (!empty($rencana->dokteranastesi)?$rencana->dokteranastesi->namaLengkap:""); ?></td>
                        </tr>
                        <tr>
                            <td>Perawat Instrumen</td>
                            <td>:</td>
                            <td><?php echo (!empty($rencana->bidan)?$rencana->bidan->namaLengkap:""); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Anestesi</td>
                            <td>:</td>
                            <td>
                            <?php
                                $lookup = LookupM::model()->findAll("lookup_type = 'jenisanestesi'");
                                $html = "";
                                if(!empty($lookup)){
                                foreach($lookup as  $i => $look){
                                    $ischeck =  false;
                                    $stl ="";
                                    if($i > 0){
                                        $stl = "padding-left: 20px;";
                                    }
                                    if(!empty($model->jenis_anestesi) && $model->jenis_anestesi == $look->lookup_value){
                                        $ischeck =  true;
                                    }

                                    $html .= "<span style='".$stl."' class='".(($ischeck==true)?'fa fa-dot-circle-o':'fa fa-circle-o')."'></span> ".$look->lookup_name;
                                }
                                }
                                echo $html;
                            ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="table-custom">
                        <tr>
                            <td width="180px">Tanggal Operasi</td>
                            <td width="5px">:</td>
                            <td><?php echo (!empty($rencana->tglrencanaoperasi)? MyFormatter::formatDateTimeForUser($rencana->tglrencanaoperasi): "");  ?></td>
                        </tr>
                        <tr>
                            <td>Dikirim untuk pemeriksaan</td>
                            <td>:</td>
                            <td>
                                <span class="<?php echo (($model->is_dikirimpemeriksaan != null && $model->is_dikirimpemeriksaan==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Ya
                                <span style="padding-left: 20px" class="<?php echo (($model->is_dikirimpemeriksaan==false)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Tidak   
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>:</td>
                            <td>
                                <span class="<?php echo (($model->is_pa != null && $model->is_pa==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> PA
                                <span style="padding-left: 20px" class="<?php echo (($model->is_vc != null && $model->is_vc==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> VC   
                                <span style="padding-left: 20px" class="<?php echo (($model->is_kultur != null && $model->is_kultur==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Kultur   
                                <span style="padding-left: 20px" class="<?php echo (($model->is_analisa != null && $model->is_analisa==true)?'fa fa-dot-circle-o':'fa fa-circle-o'); ?>"></span> Analisa   
                            </td>
                        </tr>
                        <tr>
                            <td>Jaringan yang di eksisi/insisi</td>
                            <td>:</td>
                            <td><?php echo $model->jaringan; ?></td>
                        </tr>
                        <tr>
                            <td>Drain/ Tampon</td>
                            <td>:</td>
                            <td><?php echo $model->drain; ?></td>
                        </tr>
                        <tr>
                            <td>Alat Implan</td>
                            <td>:</td>
                            <td><?php echo $model->alatimplan; ?></td>
                        </tr>
                        <tr>
                            <td>Perdarahan</td>
                            <td>:</td>
                            <td><?php echo $model->perdarahan; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Diagnosa dan Tindakan</div>
    </div>
    <div class="panel-body">
        <h4>Diagnosa</h4>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Tgl. Diagnosa</th>
                    <th>Kelompok Diagnosa</th>
                    <th>Klasifikasi Diagnosa</th>
                    <th>Kode</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Keterangan <span class="required">*</span></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($pasienmobiditas)){
                    foreach($pasienmobiditas as $pm){
                        ?>
                        <tr>
                            <td><?php echo MyFormatter::formatDateTimeForDb($pm->tglmorbiditas); ?></td>
                            <td><?php echo (!empty($pm->kelompokdiagnosa)?$pm->kelompokdiagnosa->kelompokdiagnosa_nama:""); ?></td>
                            <td><?php echo (!empty($pm->diagnosa)? (!empty($pm->diagnosa->klasifikasidiagnosa)?$pm->diagnosa->klasifikasidiagnosa->klasifikasidiagnosa_nama:"") :""); ?></td>
                            <td><?php echo (!empty($pm->diagnosa)?$pm->diagnosa->diagnosa_kode:""); ?></td>
                            <td><?php echo (!empty($pm->diagnosa)?$pm->diagnosa->diagnosa_nama:""); ?></td>
                            <td><?php echo (!empty($pm->diagnosa)?$pm->diagnosa->diagnosa_namalainnya:""); ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }else{
                    echo '<tr><td colspan="7">Tidak Ditemukan!</td></tr>';
                } ?>
            </tbody>
        </table>
        <br/>

        <h4>Tindakan</h4>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Uraian Tindakan</th>
                    <th>Detail Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($rencanaoperasiList)){
                    foreach($rencanaoperasiList as $rn){
                        ?>
                        <tr>
                            <td><?php echo (!empty($rn->operasi)?$rn->operasi->operasi_nama:""); ?></td>
                            <td><?php echo (!empty($rn->operasi)? (!empty($rn->operasi->daftartindakan)?$rn->operasi->daftartindakan->daftartindakan_nama:"") :""); ?></td>
                        </tr>
                        <?php
                    }
                }else{
                    echo '<tr><td colspan="2">Tidak Ditemukan!</td></tr>';
                } ?> 
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Laporan Operasi</div>
    </div>
    <div class="panel-body">
        <table width="100%" class="table-custom">
            <tr>
                <td width="300px">Persiapan Operasi (Profilaksis, inform consent)</td>
                <td width="5px">:</td>
                <td><?php echo $model->persiapanoperasi; ?></td>
            </tr>
            <tr>
                <td>Posisi Pasien</td>
                <td>:</td>
                <td>
                    <?php echo $model->posisipasien; ?>
                </td>
            </tr>
            <tr>
                <td>Desinfeksi</td>
                <td>:</td>
                <td>
                    <?php echo $model->desinfeksi; ?>
                </td>
            </tr>
            <tr>
                <td>Insisi Kulit dan pembukaan lapangan operasi</td>
                <td>:</td>
                <td>
                    <?php echo $model->insisikulit; ?>
                </td>
            </tr>
            <tr>
                <td>Pendapatan pada eksplorasi</td>
                <td>:</td>
                <td>
                    <?php echo $model->pendapataneksplorasi; ?>
                </td>
            </tr>
            <tr>
                <td>Deskripsi/ uraian operasi</td>
                <td>:</td>
                <td>
                    <?php echo $model->deskripsioeprasi; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
