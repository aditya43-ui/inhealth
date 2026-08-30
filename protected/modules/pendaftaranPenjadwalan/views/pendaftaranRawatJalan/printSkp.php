<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>     
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;          

    }

    td.header
    {
        padding-left:30px;
    }

    td
    {
        font-size: 9pt !important;
    }
</style>
<table width="100%" border="0" style = "text-align:left;" >
    <thead>
        <tr>
            <th colspan="8" align='center' style="font-weight:bold;"><font style="font-size:17px;"><?php echo $judul_print; ?></font><br><br></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="header">1. Tanggal SKP</td>
            <td>:</td>
            <td><?php echo date("d/m/Y", strtotime($modSkp->tglskp)); ?></td>
            <td>&nbsp;</td>
            <td>No. Bukti SKP</td>
            <td>:</td>
            <td colspan="2"><?php echo $modSkp->noskp; ?></td>                    
        </tr>
        <tr>
            <td class = "header">2. Nomor Rujukan</td>
            <td>:</td>
            <td><?php echo $modSkp->norujukan; ?></td>
            <td>&nbsp;</td>
            <td>Nama Pasien / Peserta</td>
            <td>:</td>
            <td colspan="2"><?php echo !empty($modAsuransi->namapemilikasuransi) ? $modAsuransi->namapemilikasuransi : '' ?></td>
        </tr>
        <tr>
            <td class = "header">3. Tanggal Rujukan</td>
            <td>:</td>
            <td><?php echo date("d/m/Y", strtotime($modSkp->tglrujukan)); ?></td>
            <td>&nbsp;</td>
            <td>Nomor Kartu Jamkesda</td>
            <td>:</td>
            <td colspan="2"><?php echo !empty($modAsuransi->nokartuasuransi) ? $modAsuransi->nokartuasuransi : '' ?></td>
        </tr>
        <tr>
            <td class = "header">4. Asal Rujukan / Kode PPK</td>
            <td>:</td>
            <td><?php echo $modRujukan->rujukandari->namaperujuk ?></td>
            <td>&nbsp;</td>
            <td>No. RM</td>
            <td>:</td>
            <td colspan="2"><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td class = "header">5. Diagnosa Puskesmas</td>
            <td>:</td>
            <td><?php echo $modRujukan->diagnosa_rujukan; ?></td>
            <td>&nbsp;</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td colspan="2"><?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td class = "header">6. Identitas Kunjungan</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
            <td>&nbsp;</td>
            <td>Tgl. Lahir</td>
            <td>:</td>
            <td colspan="2"><?php echo date("d/m/Y", strtotime($modPasien->tanggal_lahir)); ?></td>
        </tr>
        <tr>
            <td class = "header">7. Asal Peserta</td>
            <td>:</td>
            <td> <?php echo $modPasien->kabupaten->kabupaten_nama; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3" style="text-align: center">
                Petugas Verifikasi
                <br><br><br>
                ( ................................................ )
            </td>
        </tr>
        <tr>
            <td colspan="8" style="padding-top: 10px; border-bottom: 1px solid #000000"></td>
        </tr>
        <tr>
            <td style="vertical-align:top; padding-top: 10px;" class="header">8. Tujuan Rujukan</td>
            <td style="vertical-align:top; padding-top: 10px;">:</td>
            <td style="vertical-align:top; padding-top: 10px;">Poli : ..................................................</td>
            <td style="vertical-align:top; padding-top: 10px;">Diagnosa RS</td>
            <td style="vertical-align:top; padding-top: 10px;">: ........................................</td>
            <td style="vertical-align:top; padding-top: 10px;"></td>
            <td style="vertical-align:top; padding-top: 10px;">ICD 10 : ................</td>
            <td style="vertical-align:top; padding-top: 10px; text-align:center">Dokter <br><br></td>
        </tr>
        <tr>
            <td class="header"></td>
            <td></td>
            <td></td>
            <td>Tindakan</td>
            <td>: ........................................</</</td>
            <td></td>
            <td>ICD 9-CM :  .......... </td>
            <td style="text-align:center">( ........................ )</td>
        </tr>
        <tr>
            <td class="header"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center">Nama Terang <br><br></td>
        </tr>
        <tr>
            <td style="vertical-align:top;" class="header">9. Rujukan Intern Ke</td>
            <td style="vertical-align:top;">:</td>
            <td style="vertical-align:top;">Poli : ..................................................</td>
            <td style="vertical-align:top;">Diagnosa RS</td>
            <td style="vertical-align:top;">: ........................................</td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">ICD 10 : ................</</td>
            <td style="vertical-align:top; text-align:center">Dokter <br><br></td>
        </tr>
        <tr>
            <td class="header"></td>
            <td></td>
            <td></td>
            <td>Tindakan</td>
            <td>: ........................................</</</td>
            <td></td>
            <td>ICD 9-CM :  .......... </td>
            <td style="text-align:center">( ........................ )</td>
        </tr>
        <tr>
            <td class="header"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center">Nama Terang <br><br></td>
        </tr>
        <tr>
            <td style="vertical-align:top;" class="header"></td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">Poli : ..................................................</</td>
            <td style="vertical-align:top;">Diagnosa RS</td>
            <td style="vertical-align:top;">: ........................................</</td>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top;">ICD 10 : ................</</td>
            <td style="vertical-align:top; text-align:center">Dokter <br><br></td>
        </tr>
        <tr>
            <td class="header"></td>
            <td></td>
            <td></td>
            <td>Tindakan</td>
            <td>: ........................................</</</td>
            <td></td>
            <td>ICD 9-CM :  .......... </td>
            <td style="text-align:center">( ........................ )</td>
        </tr>
        <tr>
            <td class="header"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center">Nama Terang <br><br></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center">
                Pelayanan diatas telah diterima 
                <br> 
                Pasien / Keluarga Pasien
                <br><br><br>
                ( .................................... )<br>
                Nama Terang
            </td>
            <td colspan="2" style="text-align: center">
                &nbsp; 
                <br> 
                Coders
                <br><br><br>
                ( .................................... )<br>
                Nama Terang
            </td>
        </tr>
    </tbody>
</table>
