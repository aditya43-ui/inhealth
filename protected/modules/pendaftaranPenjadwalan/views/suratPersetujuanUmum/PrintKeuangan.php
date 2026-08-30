<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    .fa{
        font-size: 16pt;
    }

    .tab_header {
        width: 100%;
    }
    
    .tab_header td {
        border: 1px solid black;
        line-height: 32px;
        padding-left: 5px;
        vertical-align: top;
    }
    
    .tab_header .head_cell {
        font-weight: bold;
    }
    
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    .coret {
        text-decoration: line-through;
    }
    
    p {
        text-align: justify;
    }
    
</style>

<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();

echo $this->renderPartial($this->path_view.'_header', array('modProfilRs'=>$modProfilRs)); 
?>
<h3 style="text-align: center; font-weight: bold">PERSETUJUAN PERSYARATAN KEUANGAN RAWAT INAP</h3>
<h4 style="text-align: center; font-weight: bold">PASIEN ATAU PENANGGUNG JAWAB/PENJAMIN PASIEN DIMINTA MEMBACA, MEMAHAMI DAN MENGISI INFORMASI BERIKUT</h4>

<br/>
<p>
    I. DATA PENANGGUNG JAWAB/ PENJAMIN PASIEN :
</p>
<div style="padding-left: 20px">
    <table style="width: 100%; border: none;">
        <tr>
            <td width="200px">Nama</td>
            <td>
               : <?php echo $model->tandatangan_nama; ?>
            </td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>
               : <?php echo $model->penanggungjawab_pekerjaan; ?>
            </td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td>: <?php echo $model->tandatangan_alamat; ?></td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td>: <?php echo $model->tandatangan_telepon; ?></td>
        </tr>
        <tr>
            <td>No KTP/SIM</td>
            <td>: <?php echo $model->penanggungjawab_noktp; ?></td>
        </tr>
        <tr>
            <td>Hubungan dengan pasien</td>
            <td>: <?php echo $model->tandatangan_hubungan; ?></td>
        </tr>
    </table>
</div>
<br/>
<p>
   II. DATA PASIEN RAWAT INAP
</p>
<div style="padding-left: 20px">
    <table style="width: 100%; border: none;">
        <tr>
            <td width="200px">Nama</td>
            <td colspan="2">: 
                <?php echo $model->pasien_nama; ?>
            </td>
            <td style="text-align: right">
                <span class="<?php echo (($model->pasien_jeniskelamin==Params::JENIS_KELAMIN_LAKI_LAKI) ? "coret" : ""); ?>">L</span> / <span class="<?php echo (($model->pasien_jeniskelamin==Params::JENIS_KELAMIN_PEREMPUAN) ? "coret" : ""); ?>">P</span> 
            </td>
        </tr>
        <tr>
            <td>No. Rekam Medis</td>
            <td colspan="3">: <?php echo $model->pasien_no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Ruangan Perawatan</td>
            <td>: 
                <?php echo $modAdmisi->ruangan->ruangan_nama; ?>
            </td>
            <td>Kelas</td>
            <td>: 
                <?php echo $modAdmisi->kelaspelayanan->kelaspelayanan_nama; ?>
            </td>
        </tr>
        <tr>
            <td>Tempat/ Tanggal Lahir</td>
            <td> : 
                <?php echo $modPasien->tempat_lahir.' '.$model->pasien_tanggal_lahir; ?>
            </td>
            <td>Umur</td>
            <td>: 
                <?php echo $modPendaftaran->umur; ?>
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td colspan="3">: <?php echo $model->pasien_alamat; ?></td>
        </tr>
    </table>
</div>
<br/>
<p>III. PERATURAN/KETENTUAN TERKAIT KEUANGAN</p>
<div style="padding-left: 20px">
<?php
    $peraturan = array();
    if(!empty($model->peraturankeuangan)){
        $peraturans = json_decode($model->peraturankeuangan);

        if(!empty($peraturans)){
            foreach($peraturans as $item){
                $peraturan[$item] = true;
            }
        }
    }
?>
<table>
    <tr>
        <td width="2%" valign="top">
            A.
        </td>
        <td width="90%">
            Perhitungan kamar perawatan dihitung mulai pukul 12.00 WIB s/d 12.00 keesokan harinya. Namun jika pasien masuk kedalam kamar perawatan masuk lebih dari 6 jam, maka pada hari yang sama tepat pukul 12.00 WIB pasien akan dihitung 1 (satu) hari penuh.
        </td>
        <td style="text-align: center" valign="top">
            <span class="<?php echo ((!empty($peraturan['A']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            B.
        </td>
        <td>
            Jika pasien pulang lebih dari 6 jam dari pukul 12.00 WIB maka pasien akan dikenakan tambahan biaya kamar 1 hari, kecuali jika ada penundaan jadwal perawatan medis yang disebabkan oleh pihak rumah sakit............
        </td>
        <td valign="top" style="text-align: center">
            <span class="<?php echo ((!empty($peraturan['B']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            C.
        </td>
        <td>
            Pindah ruangan tidak diperkenankan dilakukan pada hari yang sama harus menunggu 24 jam dihitung dari hari masuk ruang perawatan pertama kali. (kurang dari 24 jam, kamar tetap di tarif full)....................................... 
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['C']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            D.
        </td>
        <td>
            Pasien diperkenankan masuk ke ruang rawat inap sesuai instruksi Dokter dan diwajibkan membayar deposit 5x harga tarif sewa kamar sesuai ketentuan kelas perawatan yang dipilih pada saat pendaftaran dalam jangka waktu 1x24 jam. 
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['D']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            E.
        </td>
        <td>
            Khusus ruang intensif dewasa dan anak (HCU/ICU/PICU/NICU) baik ruang standar maupun isolasi diwajibkan membayar deposit awal sebesar 10x harga sewa kamar sesuai ketentuan kelas perawatan yang dipilih pada saat pendaftaran dalam jangka waktu 1x24 jam. 
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['E']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            F.
        </td>
        <td>
            Apabila dalam perawatan ada tindakan operasi yang telah disetujui oleh pasien/ penanggung jawab pasien, maka wajib membayar deposit tambahan sebesar 50% dari yang tercantum dalam formulir perkiraan biaya tindakan/ operasi yang telah disetujui.  
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['F']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            G.
        </td>
        <td>
            Apabila biaya layanan rawat inap sudah 80% dari jumlah deposit awal, maka <?php echo $modProfilRs->nama_rumahsakit ?> berhak melakukan penagihan deposit tambahan sebesar 3x harga sewa kamar per 2 hari untuk biaya perawatan kepada pasien / penanggung jawab pasien. 
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['G']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            H.
        </td>
        <td>
            Apabila pasien tidak dapat memenuhi ketentuan deposit dan melebihi jangka waktu toleransi pembayaran , maka pihak <?php echo $modProfilRs->nama_rumahsakit ?> berhak untuk memberikan obat-obatan, pemeriksaan atau tindakan medis dengan pembayaran terlebih dahulu oleh pasien / penanggung jawab pasien, terkecuali dalam keadaan kegawat daruratan medis.
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['H']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            I.
        </td>
        <td>
            Pasien asuransi bersedia membayar selisih yang tidak dijamin oleh pihak asuransi. 
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['I']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            J.
        </td>
        <td>
            Pasien ODS yang akan dirujuk ke rawat inap, seluruh biaya tindakan akan mengikuti tarif biaya kelas rawat inap yang ditempati.
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['J']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            K.
        </td>
        <td>
            Biaya administrasi rawat inap adalah 2,5% dari total biaya perawatan pasien umum dan 7,5% untuk pasien asuransi dan perusahaan.  
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['K']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            L.
        </td>
        <td>
            Pasien bersedia mengganti semua barang atau peralatan milik <?php echo $modProfilRs->nama_rumahsakit ?> yang rusak/pecah/hilang oleh pasien atau keluarga pasien.
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['L']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td valign="top">
            M.
        </td>
        <td>
            Penanggung jawab dan/atau penjamin pasien yang bertanda tangan dibawah ini berkewajiban dan menyanggupi pembayaran seluruh tagihan perawatan yang tercetak dibilling tagihan sesuai ketentuan yang berlaku dan melunasi seluruh biaya sebelum keluar dan apabila kami tidak dapat melaksanakan pembayaran dengan baik, kami bersedia menerima sanksi yang berlaku. 
        </td>
        <td valign="top" style="text-align: center">
        <span class="<?php echo ((!empty($peraturan['M']))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span>
        </td>
    </tr>
</table>
</div>
<br/>
<p>
    Dengan ditandatanginya formulir ini maka penanggung jawab dan/ atau penjamin pasien secara sadar dan tanpa paksaan menyatakan semua data yang diisi adalah benar dan dimengerti, menerima serta bersedia untuk mematuhi seluruh peraturan/ketentuan diatas juga bertanggung jawab dan bersedia untuk dihubungi oleh pihak <?php echo $modProfilRs->nama_rumahsakit ?> untuk segala sesuatu yang berkaitan dengan biaya pengobatan pasien tersebut di atas.
</p>
<br?>


<table style="width: 100%; border: none;">
    <tr>
        <td colspan="2" class="td_date"> 
            <?php echo $modProfilRs->kabupaten->kabupaten_nama.', '.date('d',strtotime($model->tgl_persetujuan)).' '.Myformatter::getMonthId(date('m',strtotime($model->tgl_persetujuan))).' '.date('Y',strtotime($model->tgl_persetujuan)); ?>, 
		</td>
    </tr>
    <tr>
        <td style="text-align: center;" width="50%">
        Penanggung jawab dan/atau penjamin pasien
            <br>
            <br>
            <br>
            <br>
            <br>
			(<?php echo $model->penanggungjawab_pasien; ?>)
            
        </td>
        <td width="200" style="text-align: center;" width="50%">
        Petugas Pendaftaran
            <br>
            <br>
            <br>
            <br>
            <br>
			(<?php  echo $model->petugas_admisi; ?>)
            
        </td>
    </tr>
</table>
<br><br><br><br><br>
<table width="100%">
    <tr>
        <td width="35%">Lembar Putih: Status Pasien</td>
        <td width="30%">Lembar Merah: Pendafaran</td>
        <td width="35%">Lembar Kuning: Pasien</td>
    </tr>
</table>
