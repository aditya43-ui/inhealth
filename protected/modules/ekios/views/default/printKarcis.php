<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
   
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
  <table style="width: 60%; border: none;">
    <tr>
        <td align="left" valig="middle" colspan="2">
            <b><?php echo $modProfilRs->nama_rumahsakit; ?><?php //echo $judul_print ?></b>
        </td>
    </tr>
     <tr >
        <td align="left" valig="middle" colspan="2" style="border-bottom-style: dotted;">
			<?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>
        </td>
    </tr>

    <tr>
        <td>No. Antrian</td>
        <td><b>:<?php echo $model->ruangan->ruangan_singkatan; ?>-<?php echo $model->no_antrianjanji; ?></b></td>
    </tr>
    <tr>
        <td>No. Janji Poliklinik</td>
        <td><b>:<?php echo $model->no_buatjanji; ?></b></td>
    </tr>
    <tr>
        <td>Tanggal Janji Poliklinik</td>
        <td><b>:<?php echo MyFormatter::formatDateTimeForUser($model->tgljadwal); ?></b></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td><b>:<?php echo $modPasien->no_rekam_medik; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:<?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:<?php echo $model->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:<?php echo !empty($model->pegawai->gelardepan)?$model->pegawai->gelardepan.' ':''; echo $model->pegawai->nama_pegawai; ?></td>
    </tr>
    <tr>
        <td colspan="2"><i>&nbsp;</i></td>
    </tr>
    <tr>
        <td colspan="2">Pasien Perusahaan silahkan daftar ulang di pendaftaran<br>Pasien Umum silahkan melakukan pembayatan di KIOS<br>Pasien Umum dan BPJS, silahkan daftar ulang di KIOS<br> Diharuskan datang sesuai jam Kedatangan.</td>
    </tr>
    </table>
		</div>		
            </td>
        </tr>
    </tbody>
</table>
<div class="">
</div>
  
