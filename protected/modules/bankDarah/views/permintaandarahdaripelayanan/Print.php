<style type="text/css" media="print">
    @media print
    {
        html{
            width: 8.5in;
            height: 13in;
        }
        body{ 
            padding-top: 100px;
            margin-top: 0in;
            margin-bottom: 0in;
            font-size: 12pt; 
            page-break-inside: avoid;
            line-height: 1.6;
            font-family: "Times New Roman", Times, serif !important;
            font-size:12pt !important;
        }
        @page {
            padding-top: 100px;
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 1in;
            margin-right: 0.4in;
        }
        .page-break { display: block; page-break-before: always; }
    } 
    @media all {
        .page-break { display: none; }
    }

</style>
<?php 
$profil = ProfilrumahsakitM::model()->find(); 
$konfig = KonfigsystemK::model()->find();
?>
<table width="100%">
    <tr>
        <td style="font-size:20px;">RUMAH SAKIT <?php echo strtoupper($profil->nama_rumahsakit); ?></td>
    </tr>
    <tr>
        <td style="font-size:20px;"><?php echo $profil->alamatlokasi_rumahsakit; ?></td>
    </tr>
</table>
<br>
<br>
<div>
    <TABLE ALIGN="CENTER">
        <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT SIZE=5>INSTALASI TRANSFUSI DARAH</FONT></B>
            </TD>
        </TR>
        <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT SIZE=4>BUKTI TERIMA PERMINTAAN DARAH</FONT></B>
            </TD>
        </TR>
    </TABLE>
    <table width="100%">
        <tr>
            <td COLSPAN=2 HEIGHT=2 style="border-bottom: 3px solid #000000"><span style="color:transparent">--</span></td>
        </tr>
    </table>
</div>
<br>
<p align="justify">
<table width="100%" style="margin:0px 50px 0px 80px;">
    <tr>
        <td style="font-size:20px; width: 31%">No. Formulir</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo $model->no_formulir; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Tgl. Permintaan</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo date('d ', strtotime($model->tglpermintaan)) . MyFormatter::getMonthId(date('m', strtotime($model->tglpermintaan))) . date(' Y', strtotime($model->tglpermintaan)) . date(' H:i:s', strtotime($model->tglpermintaan)); ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">No. Registrasi</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">No. Permintaan</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo $model->no_permintaandarah; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Tgl. Reg / No. RM</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo date('d ', strtotime($modPendaftaran->tgl_pendaftaran)) . MyFormatter::getMonthId(date('m', strtotime($modPendaftaran->tgl_pendaftaran))) . date(' Y', strtotime($modPendaftaran->tgl_pendaftaran)) . date(' H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)) . ' / ' . $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Nama Pasien</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Tgl. Lahir</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo date('d ', strtotime($modPasien->tanggal_lahir)) . MyFormatter::getMonthId(date('m', strtotime($modPasien->tanggal_lahir))) . date(' Y', strtotime($modPasien->tanggal_lahir)); ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Instalasi / Ruangan Asal</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo $modPendaftaran->instalasi->instalasi_nama . ' / ' . $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Status</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px"><?php echo $model->jenispermintaan; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px; width: 31%">Petugas</td>
        <td style="font-size:20px">:</td>
        <td style="font-size:20px">
            <?php
            $cekPetugas = PegawaiM::model()->findByPk($model->pegpemesan_id);
            echo!empty($model->pegpemesan_id) ? $cekPetugas->namaLengkap : '';
            ?>
        </td>
    </tr>
</table>
</p>
<br>
<p style="font-size:20px;">Detail Permintaan</p>
<table border="1px solid" width="100%">
    <thead>
    <th style="font-size:20px;">No.</th>
    <th style="font-size:20px;">Jenis Komponen Darah</th>
    <th style="font-size:20px;">Jumlah</th>
</thead>
<tbody>
    <?php
    $no = 1;
    foreach ($modDetail as $value) {
        $cekKomponen = KomponendarahM::model()->findByAttributes(array('singkatan_komp' => $value->singkatan_komp));
        ?>
        <tr>
            <td style="font-size:20px;"> &nbsp;&nbsp;<?php echo $no++; ?></td>
            <td style="font-size:20px;"> &nbsp;&nbsp;<?php echo $cekKomponen->namakomponendrh . ' (' . $value->singkatan_komp . ')'; ?></td>
            <td style="font-size:20px;"> &nbsp;&nbsp;<?php echo $value->jml_kantong; ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
<br>
<br>
<table ALIGN="CENTER">
    <tr>
        <td ALIGN=CENTER VALIGN=MIDDLE>
            <B><FONT SIZE=5>FORMULIR PENGAMBILAN DARAH</FONT></B>
        </td>
    </tr>
</table>
<table border="1px solid" width="100%">
    <thead>
    <th style="font-size:20px;">Tgl dan Jam</th>
    <th style="font-size:20px;">Jenis Darah</th>
    <th style="font-size:20px;">Jumlah Darah</th>
    <th style="font-size:20px;">Nama Dokter / Perawat</th>
    <th style="font-size:20px;">Tanda Tangan</th>
</thead>
<tbody>
    <tr>
        <td style="font-size:20px;"> <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
        <td style="font-size:20px;"> <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
        <td style="font-size:20px;"> <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
        <td style="font-size:20px;"> <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
        <td style="font-size:20px;"> <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
    </tr>
</tbody>
</table>