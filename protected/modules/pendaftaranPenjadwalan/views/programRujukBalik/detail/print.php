<style>
    table.grid th, table.grid td {
        border: 1px solid;   
        
    } 
    
    table{    
        border-collapse: collapse;
        table-layout: fixed;
        margin-bottom: 10px;
    }
</style>
<?php
$format = new MyFormatter;

echo $this->renderPartial('_headerPrint');

if ($model->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
    $jns = 'Laki - Laki / <strike>Perempuan</strike>';
}else{
    $jns = '<strike>Laki - Laki</strike>/ Perempuan';
}

?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="middle" colspan="3">
            <h3><b><?php echo $judulLaporan ?></b></h3>
        </td>
    </tr>
</table>
<br />

<label style="padding:10px;">Bersama ini kami kirimkan pasien Program Rujuk Balik dengan data sebagai berikut :</label>
<br />
<table width="100%" style="margin-left:20px;margin-right:20px;">
    <tr>
        <td>Nama</td>
        <td width="2%">:</td>
        <td><?= $model->nama_pasien ?></td>
        <td width="10%"></td>
        <td><?= $jns ?></td>
    </tr>
    <tr>
        <td>No Rekam Medis</td>
        <td>:</td>
        <td><?= $model->no_rekam_medik ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?= $model->tanggal_lahir ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No Kartu Peserta</td>
        <td>:</td>
        <td><?= $model->nokartuasuransi ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No SEP</td>
        <td>:</td>
        <td><?= $model->nosep ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= $model->alamat_pasien ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td><?= $model->alamatemail ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No Telepon</td>
        <td>:</td>
        <td><?= $model->no_mobile_pasien ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Faskes Tujuan</td>
        <td>:</td>
        <td><?= $model->ruangan_nama ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No SRB</td>
        <td>:</td>
        <td><?= $model->nosrb ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tanggal SRB</td>
        <td>:</td>
        <td><?= $model->tglsrb ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Program PRB</td>
        <td>:</td>
        <td><?= $model->programprb_nama. ' - '.$model->programprb_kode ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Saran</td>
        <td>:</td>
        <td><?= $model->saran ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td><?= $model->saran ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Obat Generik PRB</td>
        <td>:</td>
        <td><?= $model->saran ?></td>
        <td></td>
        <td></td>
    </tr>
</table>

<table width="100%" class="grid" style="margin:30px;">
    <tr>
        <th>Nama/Kode Obat PRB</th>
        <th>Signa</th>
        <th>Cara Penggunaan Obat</th>
        <th>Jumlah</th>
    </tr>
    <?php
            foreach($modObat as $key => $det){
    ?>
    <tr>
        <td><?= $det->obatprb_bpjskode.' - '.$det->obatprb_bpjsnama ?></td>
        <td style="text-align:center;"><?= $det->signa ?></td>
        <td><?= $det->carapenggunaanobat ?></td>
        <td style="text-align:center;"><?= $det->qty_obat ?> pcs</td>
    </tr>
    <?php
            }
        ?>
</table>
<label style="padding-left:10px;padding-right:10px;">Mohon perawatan selanjutnya, atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih</label>
<br/>
<br/>
<br/>
<table width="100%"> 
    
    <tr>
        <td width="70%">&nbsp;</td>
        <td width="30%" style="text-align: center;">Dokter DPJP</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
     <tr>
        <td ></td>
        <td style="text-align: center;"><?= $model->gelardepan.' '.$model->nama_pegawai.', '.$model->gelarbelakang_nama ?></td>
    </tr>
           
</table>

