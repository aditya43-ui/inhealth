<?php
    $print = !empty($print)?$print:0;
    $profil = ProfilrumahsakitM::model()->find();
    $namars = !empty($profil)?$profil->nama_rumahsakit:'';
    $catatan = "Catatan penting : ACC TINDAKAN CEK LAB DPL RP. 150.000, SUDAH DIJELASKAN MENGENAI BIAYA TIDAK RAPAT BERUBAH PENJAMIN SAMPAI AKHIR PERAWATAN TETAP MENJADI PASIEN TUNAI";
?>
<style>
    .belumLunas{
        position: absolute;
        bottom: 30;
        top:230px;
        left: 55%;
        background-color:rgba(0, 0, 0, 0);
        
    }
</style>
<table width = "35%" class="belumLunas">
    <tr>
        <!-- <td> -->
            <!-- <div style="padding:20px 20px; border:1px solid; border-color: black;transform: rotate(0deg); text-align: left;"> -->
                <!-- <h1 style="font-size:60px; font-weight:bold; color:red;"></h1> -->
                <!-- <p>Catatan penting : ACC TINDAKAN CEK LAB<br>DPL RP. 150.000, SUDAH<br>DIJELASKAN MENGENAI BIAYA TIDAK RAPAT<br>BERUBAH PENJAMIN SAMPAI AKHIR<br>PERAWATAN TETAP MENJADI PASIEN TUNAI</p> -->
                <!-- <td><?// ($print)?$model->catatanpenting:$form->textArea($model,'catatanpenting',['rows'=>7, 'readonly'=>false]) ?></td> -->
            <!-- </div>
        </td> -->
        <?php if($print){?>
            <td>
                <div style="padding:20px 20px; border:1px solid; border-color: black;transform: rotate(0deg); text-align: left;">
                    <p><?= "Catatan Penting: <br>".$model->catatanpenting?></p>
                </div>
            </td>
        <?php }else{?>
            <td><?= $form->textArea($model,'catatanpenting',['value'=>$catatan, 'rows'=>7, 'readonly'=>false, 'placeholder' => 'Catatan Penting Akad Ijarah']) ?></td>
        <?php }?>
    </tr>
    
</table>
<table class="w-100 prinout no-grid" style="text-align: center;">
    <tr>
        <th align="center" style="text-align:center;"><b>AKAD PERJANJIAN IJARAH</b></th>
    </tr>
    <tr>
        <th align="center" style="text-align:center;"><b>Bismillahirohmanirohim</b></th>
    </tr>
    <tr>
        <th align="center" style="text-align:center;"><b>PERSETUJUAN RAWAT [One Day Care (ODC) & Rawat Inap]</b></th>
    </tr>
    <tr>
        <th align="center" style="text-align:center;"><b><i>Harus dibaca dengan baik oleh pasien/ keluarganya, sebelum ditandatangani dan meninggalkan pendaftaran pasien rawat inap untuk mempergunakan kamar rawat inap atas persetujuan yang secara sadar dilakukannya</i></b></th>
    </tr>
</table>
<br/>
<table class="w-100 prinout no-grid">
    <tr>
        <td colspan="4">Saya yang bertanda tangan dibawah ini :</td>
    </tr>    
    <tr>
        <td width="20">Nama</td>
        <td width="5">:</td>
        <td><?= ($print)?$model->nama_pj:$form->textField($model,'nama_pj') ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Umur / Kelamin</td>
        <td>:</td>
        <td><?= (($print)?$model->umur_pj:$form->textField($model,'umur_pj')).'/' .(($print)?$model->jeniskelamin_pj:$form->textField($model,'jeniskelamin_pj'))?></td>
        <td rowspan="5"></td>
    </tr>
    <tr>
        <td>Bekerja di</td>
        <td>:</td>
        <td><?= ($print)?$model->pekerjaan_pj:$form->textField($model,'pekerjaan_pj') ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= ($print)?$model->alamat_pj:$form->textArea($model,'alamat_pj',['rows'=>7]) ?></td>
    </tr>
    <tr>
        <td>No. Telp/HP</td>
        <td>:</td>
        <td><?= ($print)?$model->no_telponpj:$form->textField($model,'no_telponpj') ?></td>
    </tr>
    <tr>
        <td>Bukti diri / KTP</td>
        <td>:</td>
        <td><?= (($print)?$model->jenisidentitas_pj:$form->textField($model,'jenisidentitas_pj')).' / '.(($print)?$model->no_identitas:$form->textField($model,'no_identitas')) ?></td>
    </tr>
    <tr>
        <td>Hubungan dg pasien</td>
        <td>:</td>
        <td><?= ($print)?$model->no_telponpj:$form->textField($model,'hubungankeluarga') ?></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4">Dengan ini menyatakan dengan sesunggugnya - telah memberikan :</td>
    </tr>
    <tr>
        <td colspan="4" align="center"><b>PERSETUJUAN</b></td>
    </tr>
    <tr>
        <td colspan="4">Terhadap Ibu saya dengan :</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= ($print)?$model->nama_pasien:$form->textField($model,'nama_pasien',['readonly'=>true]) ?></td>
    </tr>
    <tr>
        <td>Umur / Kelamin</td>
        <td>:</td>
        <td><?= (($print)?$model->umur_pasien:$form->textField($model,'umur_pasien',['readonly'=>true])).' / '.(($print)?$model->jeniskelamin:$form->textField($model,'jeniskelamin',['readonly'=>true])) ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= ($print)?$model->alamat_pasien:$form->textArea($model,'alamat_pasien',['rows'=>7, 'readonly'=>true]) ?></td>
    </tr>
    <tr>
        <td>No. Telp/HP</td>
        <td>:</td>
        <td><?= ($print)?$model->no_telponpj:$form->textField($model,'no_telponpj',['readonly'=>true]) ?></td>
    </tr>
    <tr>
        <td>Bukti Diri / KTP</td>
        <td>:</td>
        <td><?= (($print)?$model->no_identitas_pasien:$form->textField($model,'no_identitas_pasien',['readonly'=>true])).' / '.(($print)?$model->jenisidentitas:$form->textField($model,'jenisidentitas',['readonly'=>true])) ?></td>
    </tr>
    <tr>
        <td>Di rawat di kelas</td>
        <td>:</td>
        <td><?= ($print)?$model->kelaspelayanan_nama:$form->textField($model,'kelaspelayanan_nama',['disabled'=>true]) ?></td>
        <td>Ruang <?= ($print)?$model->kamarruangan_nama:$form->textField($model,'kamarruangan_nama',['disabled'=>true]) ?> <br/></td>
    </tr>
    <tr>
        <td>Tgl. Masuk</td>
        <td>:</td>
        <td><?= ($print)?$model->tgl_masuk:$form->textField($model,'tgl_masuk',['readonly'=>true]) ?></td>
        <td>Dokter yang merawat, <?= ($print)?$model->doktermerawat:$form->textField($model,'doktermerawat',['disabled'=>true]) ?> <br/></td>
    </tr>
    <tr>
        <td>Diagnosa(Sementara)</td>
        <td>:</td>
        <td><?= ($print)?$model->diagnosa_nama:$form->textField($model,'diagnosa_nama',['readonly'=>true]) ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?= ($print)?$model->no_rekam_medik:$form->textField($model,'no_rekam_medik',['readonly'=>true]) ?></td>
    </tr>
    <tr>
        <td>Rencana uang muka</td>
        <td>:</td>
        <td>Rp. <?= ($print)?MyFormatter::formatNumberForPrint($model->rencana_uangmuka):$form->textField($model,'rencana_uangmuka',['class'=>'integer2']) ?></td>
    </tr>
    <tr>
        <td colspan="4">
            Sanggup membayar / menambah uang muka sebesar : Rp. <?= ($print)?MyFormatter::formatNumberForPrint($model->tambah_uangmuka):$form->textField($model,'tambah_uangmuka',['class'=>'integer2']) ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Pada
        </td>
        <td colspan="2">
            <?php 
                if ($print){
                    echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_tambahuangmuka))) ?> hari <?= MyFormatter::getDayUser(date('w', strtotime($model->tgl_tambahuangmuka))) ?> jam <?= date('H:i:s', strtotime($model->tgl_tambahuangmuka)) ;
                }else{
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_tambahuangmuka',
                        'mode' => 'date',
                        'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'yearRange' => "-150:+0",
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'DD MM YYYY', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                ));
                }
                    
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="4">Untuk di rawat Inap / ODC di <?= $namars ?>, serta sanggup untuk :</td>
    </tr>
    <tr>
        <td colspan="4">
            <ol>
                <li>Mematuhi ketentuan-ketentuan serta Tata Tertib yang berlaku di <?= $namars ?>.</li>
                <li>Menyetujui pemeriksaan/tindakan/pengobatan/perawatan untuk mendukung diagnosa atau kesembuhan bagi pasien yang telah dijelaskan dokter/petugas Rumah Sakit;</li>
                <li>Memahami penjelasan yang disampaikan oleh petugas Rumah Sakit tentang tarif kelas perawatan sesuai kelas yang ditempati pasien tersebut diatas;</li>
                <li>Bersedia membayar uang muka/deposit sesuai dengan yang telah ditentukan Rumah Sakit, dalam waktu 1x24 jam setelah pasien dirawat sebesar Rp. <?= MyFormatter::formatNumberForPrint($model->rencana_uangmuka) ?> akan menambah uang muka/deposit apabila deposit tinggal 20% dari biaya tagihan perawatan.</li>
                <li>Apabila tidak memenuhi untuk menambah uang muka/deposit maka saya akan bersedia pasien tersebut diatas dipindahkan ke kelas perawatan yang lebih rendah</li>
                <li>Mengerti dan memahami biaya tarif kamar perawatan belum termasuk biaya obat-obatan, tindakan operasi, pemeriksaan laboratorium, pemeriksaan radiologi & biaya khusus lainnya serta biaya administrasi sebesar 5 % dari total tagihan;</li>
                <li>Akan menyelesaikan jaminan dalam jangka waktu 1x 24 jam setelah pasien masuk ruangan dan bersedia membayar selisih biaya yang ditanggung oleh <?= $model->carabayar_nama ?>. Apabila tidak ada jaminan dari asuransi/perusahaan, maka pasien dinyatakan sebagai pasien umum.**</li>
                <li>Menyetujui Rumah Sakit untuk memberikan resume medis & hasil pemeriksaan atau data yang diperlukan oleh pihak asuransi & perusahaan</li>
                <li>Akan melunasi semua biaya perawatan pada saat pulang/ setelah selesai masa perawatan di Rumah Sakit.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td colspan="4">Demikian pernyataan persetujuan ini saya buat dengan kesadaran tanpa ada paksaan pihak manapun, untuk dipergunakan sebagaimana mestinya.</td>
    </tr>
</table>

<br/>

<table class="w-100 prinout no-grid" style="text-align: center;" width="100%">
    <tr>
        <td width="10">&nbsp;</td>
        <td><?= Yii::app()->user->getState('kabupaten_nama').', '.date('d-m-Y') ?></td>
        <td>&nbsp;</td>
        <td width="10">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Pihak Pertama</td>
        <td>Pihak Kedua</td>
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
        <td class="pihakpertama">(<?= $model->pihakpertama ?>)</td>
        <td class="pihakkedua">(<?= $model->pihakkedua ?>)</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Petugas Pendaftaran Rawat Inap</td>
        <td>Nama jelas penanggung jawab/ pasien *</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>Saksi</td>
        <td>Saksi</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>(___________________)</td>
        <td>(___________________)</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: left;">*) Coret yang tidak perlu</td>        
        <td colspan="2" style="text-align: left;">**) Khusus pasien Asuransi / Peruhsaan Rekanan</td>
    </tr>
</table>













