<table width="100%">
    <tr>
        <td style="font-size:12px;">RUMAH SAKIT UMUM DAERAH DR. SOETOMO</td>
    </tr>
    <tr>
        <td style="font-size:12px;">Jl. Mayjen Prof. Dr. Moestopo No.6-8, Surabaya</td>
    </tr>
</table>
<br>
<br>
<div>
    <TABLE ALIGN="CENTER">
        <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT SIZE=3>INSTALASI TRANSFUSI DARAH</FONT></B>
            </TD>
        </TR>
        <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE>
                <B><FONT SIZE=3>BUKTI TERIMA PERMINTAAN DARAH</FONT></B>
            </TD>
        </TR>
    </TABLE>
    <table width="100%">
        <tr>
            <td COLSPAN=2 HEIGHT=1 style="border-bottom: 1px solid #000000"><span style="color:transparent"></span></td>
        </tr>
    </table>
</div>
<p align="justify">
<table width="100%" style="margin:0px 50px 0px 80px;">
    <tr>
        <td style="font-size:12px; width: 31%">No. Formulir</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo $model->no_formulir; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Tgl. Permintaan</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo date('d ', strtotime($model->tglpermintaan)) . MyFormatter::getMonthId(date('m', strtotime($model->tglpermintaan))) . date(' Y', strtotime($model->tglpermintaan)) . date(' H:i:s', strtotime($model->tglpermintaan)); ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">No. Registrasi</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">No. Permintaan</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo $model->no_permintaandarah; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Tgl. Reg / No. RM</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo date('d ', strtotime($modPendaftaran->tgl_pendaftaran)) . MyFormatter::getMonthId(date('m', strtotime($modPendaftaran->tgl_pendaftaran))) . date(' Y', strtotime($modPendaftaran->tgl_pendaftaran)) . date(' H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)) . ' / ' . $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Nama Pasien</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Tgl. Lahir</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo date('d ', strtotime($modPasien->tanggal_lahir)) . MyFormatter::getMonthId(date('m', strtotime($modPasien->tanggal_lahir))) . date(' Y', strtotime($modPasien->tanggal_lahir)); ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Instalasi / Ruangan Asal</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo $modPendaftaran->instalasi->instalasi_nama . ' / ' . $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Status</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px"><?php echo $model->jenispermintaan; ?></td>
    </tr>
    <tr>
        <td style="font-size:12px; width: 31%">Petugas</td>
        <td style="font-size:12px">:</td>
        <td style="font-size:12px">
            <?php
            $cekPetugas = PegawaiM::model()->findByPk($model->pegpemesan_id);
            echo!empty($model->pegpemesan_id) ? $cekPetugas->namaLengkap : '';
            ?>
        </td>
    </tr>
</table>
</p>
<br>
<p style="font-size:12px;">Detail Permintaan</p>
<table style="border: 1px solid #000000" width="100%">
    <thead>
        <tr>
            <th style="font-size:12px;" style="border: 1px solid #000000" >No.</th>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Jenis Komponen Darah</th>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($modDetail as $value) {
            $cekKomponen = KomponendarahM::model()->findByAttributes(array('singkatan_komp' => $value->singkatan_komp));
            ?>
            <tr>
                <td style="font-size:12px;" style="border: 1px solid #000000" > &nbsp;&nbsp;<?php echo $no++; ?></td>
                <td style="font-size:12px;" style="border: 1px solid #000000" > &nbsp;&nbsp;<?php echo $cekKomponen->namakomponendrh . ' (' . $value->singkatan_komp . ')'; ?></td>
                <td style="font-size:12px;" style="border: 1px solid #000000" > &nbsp;&nbsp;<?php echo $value->jml_kantong; ?></td>
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
<table style="border: 1px solid #000000" width="100%">
    <thead>
        <tr>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Tgl dan Jam</th>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Jenis Darah</th>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Jumlah Darah</th>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Nama Dokter / Perawat</th>
            <th style="font-size:12px;" style="border: 1px solid #000000" >Tanda Tangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size:12px;" style="border: 1px solid #000000" > <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
            <td style="font-size:12px;" style="border: 1px solid #000000" > <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
            <td style="font-size:12px;" style="border: 1px solid #000000" > <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
            <td style="font-size:12px;" style="border: 1px solid #000000" > <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
            <td style="font-size:12px;" style="border: 1px solid #000000" > <br><br><br><br><br><br><br><br> <br><br><br><br><br></td>
        </tr>
    </tbody>
</table>