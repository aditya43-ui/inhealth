<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
?>
<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <th align="center" style="text-align:center;"><span style="font-size: 15pt"><b>PERYATAAN PERSETUJUAN MEMBUKA RAHASIA KEDOKTERAN</b></span></th>
    </tr>    
</table>
<br/>

<table class="w-100 prinout no-grid" >
    <tr>
        <td colspan="5">Saya pasien atau atau Wali pasien, yang bertanda tangan dibawah ini :</td>
    </tr>    
    <tr>
        <td colspan="2">&nbsp;</td>
        <td width="15%">Nama Pasien</td>
        <td width="1%">:</td>
        <td><?= $model->pasien_nama . '('.$model->kamarruangan_nokamar.')'. '&nbsp;&nbsp;&nbsp;('.$model->pasien_jeniskelamin.')'?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>Tgl Lahir</td>
        <td>:</td>
        <td><?= $model->pasien_tanggal_lahir.', &nbsp;&nbsp;&nbsp; Umur : '.$model->umur ?></td>
        <td rowspan="5"></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>Tanggal Masuk RS</td>
        <td>:</td>
        <td><?= $model->pasien_tglmasukrs ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>Dokter Penanggung Jawab</td>
        <td>:</td>
        <td><?= $model->dokterpenanggungjawab ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>No Rekam Medis</td>
        <td>:</td>
        <td><?= $model->pasien_no_rekam_medik ?></td>
    </tr>    
    <tr>
        <td colspan="5">Menyatakan bahwa sesuai Kewajiban Simpan Rahasia Kedokteran dan mengacu pada Peraturan Menteri Kesehatan Republik Indonesia Nomor <b>269/KEMENKES/PER/III/2008</b>, saya menyetujui pemberian penjelasan yang terkait kondisi medis kepada</td>
    </tr>    
    <tr>
        <td width="1%" rowspan="5" style="vertical-align: top">&nbsp;</td>
        <td width="1%" rowspan="5" style="vertical-align: top">a.</td>
        <td>Nama</td>
        <td>:</td>
        <td><b><?= ($print)?$model->tandatangan_nama:$form->textField($model,'tandatangan_nama',[]) ?></b></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>No Telp / HP</td>
        <td>:</td>
        <td><b><?= (($print)?$model->tandatangan_telepon:$form->textField($model,'tandatangan_telepon',[])) ?></b></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Hubungan dengan Pasien</td>
        <td>:</td>
        <td><?= (($print)?$model->tandatangan_hubungan:$form->textField($model,'tandatangan_hubungan',[])) ?></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td width="10" rowspan="5" style="vertical-align: top">&nbsp;</td>
        <td width="10" rowspan="5" style="vertical-align: top">b.</td>
        <td>Nama</td>
        <td>:</td>
        <td style="border-bottom: 1px solid #333;"></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>No Telp / HP</td>
        <td>:</td>
        <td style="border-bottom: 1px solid #333;"></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Hubungan dengan Pasien</td>
        <td>:</td>
        <td style="border-bottom: 1px solid #333;"></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>      
    <tr>
        <td width="10" rowspan="5" style="vertical-align: top">&nbsp;</td>
        <td width="10" rowspan="5" style="vertical-align: top">c.</td>
        <td colspan="3">Penanggung Jawab biaya, jaminan, asuransi : <?= $model->penjamin_nama ?></td>       
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Nama contact person</td>
        <td>:</td>
        <td><?= (($print)?$model->penanggung_jawab_biaya_nama:$form->textField($model,'penanggung_jawab_biaya_nama',[])) ?></td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td>Telp</td>
        <td>:</td>
        <td><?= (($print)?$model->penanggung_jawab_biaya_telepon:$form->textField($model,'penanggung_jawab_biaya_telepon',[])) ?></td>
    </tr>
    <tr>
        <td colspan="5">Kebutuhan Privasi yang diminta pasien selama perawatan :</td>
    </tr>
    <tr>
        <td colspan="5" height="100px">
            <?= (($print)?$model->privasi:$form->textArea($model,'privasi',['rows'=>10,'style'=>'width:100%;'])) ?>
        </td>
    </tr>
    <tr>
        <td colspan="5">Demikian pernyataan ini dibuat dengan penuh kesadaran dan tanpa paksaan :</td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center"><?= $profil->propinsi->propinsi_nama.', Jam '.date('d-m-Y') ?></td>        
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td></td>
        <td align="center">Pembuat Pernyataan,</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td class="pihakpertama"></td>
        <td class="pihakkedua">(<?= $model->pasien_nama ?>)</td>
        <td>&nbsp;</td>
    </tr>        
    <tr>
        <td colspan="4" style="text-align: left;"><b><i>MKP 1.2 EP 2&3 / Akreditrasi SNARS edisi 1.1</i></b></td>                
    </tr>
</table>













