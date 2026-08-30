<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    p {
        text-align: justify;
    }
    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
    
    .tab_header {
        width: 100%;
    }

    .tab_header td {
        vertical-align: top;
    }
    
     .tab_oa {
        width: 100%;
        border-collapse: collapse;
    }

    .tab_oa th, .tab_oa td {
        border: 1px solid black;
        padding: 2px;
    }

    .tab_layout td {
        vertical-align: top;
    }
    
     .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
    
    .text-center{
        text-align: center !important;
    }
</style>
<?php
$pasienAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
?>
<div class="panel panel-success" style="width:70%">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <table class="tab_header">
            <tr>
                <td width="50%">
                    <table class="tab_header">
                        <tr>
                            <td width="200px">Tgl. Pendaftaran</td>
                            <td>
                                : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>No Pendaftaran</td>
                            <td>
                                : <?php echo $modPendaftaran->no_pendaftaran; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td>
                                : <?php echo $modPendaftaran->umur; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kasus Penyakit</td>
                            <td>
                                : <?php echo (isset($modPendaftaran->jeniskasuspenyakit)? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : ""); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Dokter DPJP</td>
                            <td>
                                : <?php
                                    $pegawalDpjp = (isset($pasienAdmisi)? (isset($pasienAdmisi->dokpenerima)? $pasienAdmisi->dokpenerima->namaLengkap : ""):"");
                                echo $pegawalDpjp; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table class="tab_header">
                        <tr>
                            <td width="200px">No. RM</td>
                            <td>
                                : <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>
                                : <?php echo $modPendaftaran->pasien->namaLengkapPasien; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>
                                : <?php echo $modPendaftaran->pasien->jeniskelamin; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Instalasi/ Ruangan</td>
                            <td>
                                : <?php 
                                    $instalasinama = $modPendaftaran->instalasi->instalasi_nama;
                                    $ruangannama = $modPendaftaran->ruangan->ruangan_nama;
                                    
                                    if(isset($pasienAdmisi)){
                                         $instalasinama = $pasienAdmisi->ruangan->instalasi->instalasi_nama;
                                        $ruangannama = $pasienAdmisi->ruangan->ruangan_nama;
                                    }
                                    
                                echo $instalasinama.'/ '.$ruangannama; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin/ Penjamin</td>
                            <td>
                                : <?php 
                                    $carabayar = $modPendaftaran->carabayar->carabayar_nama;
                                    $penjamin = $modPendaftaran->penjamin->penjamin_nama;
                                    
                                    if(isset($pasienAdmisi)){
                                        $carabayar = $pasienAdmisi->carabayar->carabayar_nama;
                                        $penjamin = $pasienAdmisi->penjamin->penjamin_nama;
                                    }
                                    
                                echo $carabayar.'/ '.$penjamin; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>                   	
    </div>
</div>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Hasil Pemeriksaan USG</div>
    </div>
    <div class="panel-body" >
        <table class="tab_header">
            <tr>
                <td width="200px">Tanggal & Jam Pemeriksaan</td>
                <td>
                    : <?php echo MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan); ?>
                </td>
            </tr>
            <tr>
                <td>Dokter Pemeriksa</td>
                <td>
                    : <?php echo $model->dokterpemeriksa->namaLengkap; ?>
                </td>
            </tr>
            <tr>
                <td>Jumlah Janin</td>
                <td>
                    : <?php echo $model->jumlahjanin_ket; ?>
                </td>
            </tr>
        </table>
        <br />
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Hasil Pemeriksaan Janin</div>
            </div>
            <div class="panel-body" >
                <div style="overflow: auto">
                    <?php if($model->trimesterkehamilan == 1){ ?>
                        <table class="items table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" style="width:50px">Janin Ke-</th>  
                                    <th class="text-center" rowspan="2" style="width:100px">Kantong Kehamilan</th>
                                    <th class="text-center" rowspan="2" style="width:200px !important">Feta Echo</th>
                                    <th class="text-center" rowspan="2" style="width:100px">Letak Kehamilan</th>
                                    <th class="text-center" rowspan="2" style="width:100px">Pulsasi</th>
                                    <th class="text-center" colspan="4"  style="width:400px">Biometri</th>
                                    <th class="text-center" rowspan="2" style="width:200px">PATOLOGI</th>
                                    <th class="text-center" colspan="4">Kesimpulan</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:100px">GS (Gestational Sac)</th>
                                    <th class="text-center" style="width:100px">CRL (Crown Rump Length)</th>
                                    <th class="text-center" style="width:100px">BPD (Biparietal Diameter)</th>
                                    <th class="text-center" style="width:100px">FL (Femur Length)</th>

                                    <th class="text-center" rowspan="2" style="width:150px">Denyut Jantung Janin (Kali/Menit)</th>
                                    <th class="text-center" rowspan="2" style="width:15px">Gravid (Minggu)</th>
                                    <th class="text-center" rowspan="2" style="width:150px">Taksiran Melahirkan</th>
                                    <th class="text-center" rowspan="2" style="width:200px">Secara Keseluruhan Janin dalam Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($modDetail) >0){
                                        foreach ($modDetail as $detail){
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $detail->janinke; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->kantongkehamilan; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->fetalecho; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->letakkehamilan; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->pulsasi; ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_gs)? MyFormatter::formatNumberForPrint($detail->biometri_gs, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_crl)? MyFormatter::formatNumberForPrint($detail->biometri_crl, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_bpd)? MyFormatter::formatNumberForPrint($detail->biometri_bpd, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_fl)? MyFormatter::formatNumberForPrint($detail->biometri_fl, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo $detail->patologi; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->denyutjantungjanin; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->gravid; ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->taksiranmelahirkan)? MyFormatter::formatDateTimeForUser($detail->taksiranmelahirkan):""); ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->kondisijaninkeseluruhan; ?>
                                            </td>
                                        </tr>

                                        <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    <?php }else{ ?>
                        <table class="items table table-bordered" style="width:2500px !important">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" style="width:50px">Janin Ke-</th>  
                                    <th class="text-center" rowspan="2" style="width:100px">Presentasi</th>
                                    <th class="text-center" rowspan="2" style="width:100px !important;">Bunyi Jantung</th>
                                    <th class="text-center" rowspan="2" style="width:200px !important;">Jenis Kelamin</th>
                                    <th class="text-center" colspan="3">Biometri</th>
                                    <th class="text-center" rowspan="2" style="width:200px">Taksiran Berat Janin (gram)</th>
                                    <th class="text-center" rowspan="2" style="width:200px">Jumlah Air Ketuban</th>
                                    <th class="text-center" rowspan="2" style="width:200px">Insertio Plasenta</th>
                                    <th class="text-center" rowspan="2" style="width:200px">Tali Pusat</th>
                                    <th class="text-center" rowspan="2" style="width:200px">PATOLOGI</th>
                                    <th class="text-center" colspan="4">Kesimpulan</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:100px">AC (Abdominal Cirumferencial)</th>
                                    <th class="text-center" style="width:100px">BPD (Biparietal Diameter)</th>
                                    <th class="text-center" style="width:100px">FL (Femur Length)</th>

                                    <th class="text-center" style="width:150px">Denyut Jantung Janin (Kali/Menit)</th>
                                    <th class="text-center" style="width:15px">Gravid (Minggu)</th>
                                    <th class="text-center" style="width:150px">Taksiran Melahirkan</th>
                                    <th class="text-center" style="width:200px">Secara Keseluruhan Janin dalam Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($modDetail) >0){
                                        foreach ($modDetail as $detail){
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $detail->janinke; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->presentasi_janin; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->bunyijantung; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->jeniskelamin; ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_ac)? MyFormatter::formatNumberForPrint($detail->biometri_ac, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_bpd)? MyFormatter::formatNumberForPrint($detail->biometri_bpd, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->biometri_fl)? MyFormatter::formatNumberForPrint($detail->biometri_fl, 2): 0); ?> cm
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->taksiranberatjanin)? MyFormatter::formatNumberForPrint($detail->taksiranberatjanin, 2): 0); ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->jml_air_ketuban; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->insertio_plasenta; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->talipusat; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->patologi; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->denyutjantungjanin; ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->gravid; ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($detail->taksiranmelahirkan)? MyFormatter::formatDateTimeForUser($detail->taksiranmelahirkan):""); ?>
                                            </td>
                                            <td>
                                                <?php echo $detail->kondisijaninkeseluruhan; ?>
                                            </td>
                                        </tr>

                                        <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


