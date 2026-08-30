<style>
#tbl-det tr,
#tbl-det td {
    border: 1px solid black;
}

.inner {
    margin: 15px;
}

.in-inner {
    margin-bottom: 0;
}

#tbl-det-in tr,
#tbl-det-in td {
    line-height: 50px;
    border: 0px;
}

.longgar tr,
.longgar td {
    line-height: 35px;
}

.inner table {
    border: 0px;
}
</style>

<table width="95%" style="margin: 10px;" id="tbl-det">
    <tr>
        <td rowspan="2">
            <div class="inner">
                Order Pemeriksaan Patologi Anatomi
            </div>
        </td>
        <td rowspan="2" style="width: 50%;">
            <div class="inner">
                <table style="width: 100%; border: 1px solid white;" id="tbl-det-in">
                    <tr style="line-height: 100px;">
                        <td>
                            Nama: <?= $modPasien->nama_pasien ?></td>
                    </tr>
                    <tr>
                        <td>Alamat: <?= $modPasien->alamat_pasien ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin: <?= $modPasien->jeniskelamin ?></td>
                    </tr>
                </table>

            </div>
        </td>
        <td style="width: 30%;">
            <div class="inner">
                No. RM :
            </div>
        </td>
    </tr>
    <tr>
        <td rowspan="">
            <div class="inner">
                <div class="in-inner">Tgl. Lahir:</div><br>
                <div class="in-inner">Ruangan:</div><br>
                <div class="in-inner">Kelas:</div><br>
            </div>
        </td>
    </tr>
    <tr>
        <td rowspan="">
            <div class="inner">
                Diagnosis Medis
            </div>
        </td>
        <td></td>
        <td></td>
    </tr>
</table>
<table style="width: 95%; margin: 20px;" class="longgar">
    <tr>
        <td style="width: 25%;">
            Dokter DPJP
        </td>
        <td>
            <?= $model->pegawai->namaLengkap ?>
        </td>
    </tr>
    <tr>
        <td>
            PPDS
        </td>
        <td>
            <?= $model->ppds->ppds_nama ?>
        </td>
    </tr>
    <tr>
        <td>
            No. Kontak PPDS+DPJP
        </td>
        <td>
            <?= $model->nokontakppds ?>
        </td>
    </tr>
    <tr>
        <td>
            Bahan
        </td>
        <td>
            <?php
				$bhn = [];
				if($model->isbiopsi == true) {
					array_push($bhn, 'Biopsi');
				}

				if($model->isoperasi == true) {
					array_push($bhn, 'Operasi');
				}

				if($model->iskerokan == true) {
					array_push($bhn, 'Kerokan');
				}

				if($model->issitologi == true) {
					array_push($bhn, 'Sitologi');
				}

				if($model->isfnab == true) {
					array_push($bhn, 'FNAB');
				}
			
			?>
            <?= !empty($bhn) ? implode(' / ', $bhn) : "-" ?>
        </td>
    </tr>
    <tr>
        <td>
            Lokalisasi
        </td>
        <td>
            <?= $model->lokalisasi ?>
        </td>
    </tr>
    <tr>
        <td>
            Diagnosa Klinik
        </td>
        <td>
            <?= $model->diagnosaklinik ?>
        </td>
    </tr>
    <tr>
        <td>
            Stadium T
        </td>
        <td>
            <?= $model->stadiumt ?>
        </td>
    </tr>
    <tr>
        <td>
            Stadium N
        </td>
        <td>
            <?= $model->stadiumn ?>
        </td>
    </tr>
    <tr>
        <td>
            Stadium M
        </td>
        <td>
            <?= $model->stadiumm ?>
        </td>
    </tr>
    <tr>
        <td>
            Keterangan Klinik
        </td>
        <td>
            <?= $model->ketklinik ?>
        </td>
    </tr>
    <tr>
        <td>
            Riwayat Dulu
        </td>
        <td>
            <?= $model->riwayatdulu ?>
        </td>
    </tr>
</table>
<table style="width: 95%; margin: 20px;" class="longgar">
    <tr>
        <td style="width: 60%;">
            1. Ada pemeriksaan PA sebelumnya? (Ya/Tidak)
        </td>
        <td>
            <?= $model->ispasebelumnyaya == true ? "Ya" : "Tidak" ?>
        </td>
    </tr>
	<tr>
        <td style="width: 60%;">
            2. Bila ya dengan cara (Klinik/RO/Path. Klinik/Operasi/Nekropsi)
        </td>
        <td>
			<?php
				$cara = '';
				if($model->iscaraklinik == true) {
					$cara = 'Klinik';
				}
				
				if($model->iscararo == true) {
					$cara = 'RO';
				}

				if($model->iscarapk == true) {
					$cara = 'Path. Klinik';
				}

				if($model->isoperasi == true) {
					$cara = 'Operasi';
				}

				if($model->iscaranekrosi == true) {
					$cara = 'Nekrosi';
				}
			?>
            <?= $cara ?>
        </td>
    </tr>
	<tr>
        <td>
            Riwayat Sekarang
        </td>
        <td>
            <?= $model->riwayatsebelumnya ?>
        </td>
    </tr>
	<tr>
        <td>
            Pemeriksaan Penunjang
        </td>
        <td>
            <?= $model->pemeriksaanpenunjang ?>
        </td>
    </tr>
	<tr>
        <td>
            Keterangan PA Sebelumnya
        </td>
        <td>
            <?= $model->ketpasebelumnya ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
function printHD() {
    // window.open('<?php // echo $this->createUrl('printHemodialisa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'periksahd_id'=>$modHemodialisa->periksahd_id)); ?>','printwin','left=100,top=100,width=640,height=480');
}
</script>