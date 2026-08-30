<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 6pt !important;
/*        font-weight: bold;*/
    }
    body{
        width:61mm;
    }
	.content{
		-webkit-transform: rotate(-90deg);
		-moz-transform: rotate(-90deg);
		-o-transform: rotate(-90deg);
		-ms-transform: rotate(0deg);
		transform: rotate(0deg);
		color:#000000;
		height: 60mm;
		width: 70mm;
		margin: 6px 0px 30px 5px;
		position:relative;
    }

	@media print{
		.barcode-label{
			margin-top:-20px;
			z-index: 1;
			text-align: center;
			letter-spacing: 10px;
		}
		td, th{
			font-size: 6pt !important;
		}
		body{
			width:61mm;
		}

		.content{
			-webkit-transform: rotate(-90deg);
			-moz-transform: rotate(-90deg);
			-o-transform: rotate(-90deg);
			-ms-transform: rotate(0deg);
			transform: rotate(0deg);
			color:#000000;
			height: 6cm;
			width: 7cm;
		    margin: 0px 0px 30px 5px;
			position:relative;
            margin-top: 1%;
		}
	}   
	@page {
    	margin-top: 1%;
	}

    .tab_etiket {
        border-collapse: collapse;
        margin-right: 5px;
    }

    .tab_etiket td {
        font-size: 5pt;
        vertical-align: top;
        padding-left: 2px;
        padding-right: 4px;
    }
</style>
 <?php

 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);



 foreach ($modPenjualanDetail as $i=>$modObat){
        ?>
<?php

$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);
$jumlah = $modObat->qty_oa;

if (!empty($modReseptur)) {

    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
        'reseptur_id'=>$modReseptur->reseptur_id,
    ));

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
    }

}

$format = new MyFormatter;
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewEtiket'); ?>

</div>
<div class="content">
	<table width='100%'>
		<tr>
			<td style='line-height:0.10'>
			<span>----------------------------------------------------------------------</span> </td>
		</tr>
	</table>
<table width="100%" class="tab_etiket">
    <?php if (in_array($modPenjualan->jenispenjualan, array(Params::JENISPENJUALAN_KARYAWAN, Params::JENISPENJUALAN_DOKTER))): ?>
    <tr>
        <td width="45">NIP Penerima</td>
        <td width="5">:</td>
        <td><?php

        $nip = "-";
        $nama_pegawai = "-";

        if (!empty($modPenjualan->pasienpegawai_id)) {
            $peg = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
            if (!empty($peg)) {
                $nip = $peg->nomorindukpegawai;
                $nama_pegawai = $peg->namaLengkap;
            }
        }
        echo $nip;

        ?>
        </td>
        <td width="45">Tanggal</td>
        <td>:</td>
        <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->tglpelayanan)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
    </tr>
    <tr>
        <td>Pegawai Penerima</td>
        <td width="5">:</td>
        <td><?php echo $nama_pegawai;  ?></td>
        <td rowspan="4">Kelas Terapi</td>
        <td rowspan="4">:</td>
        <td rowspan="4"><?php
        $therapi = TherapiobatM::model()->findByPk($modObat->therapiobat_id);
        if (!empty($therapi)) {
            echo $therapi->therapiobat_nama;
        } else {
            echo "-";
        }

        ?></td>
    </tr>
    <tr>
        <td>Dokter Resep</td>
        <td>:</td>
        <td><?php echo empty($dokter) ? "-" : $dokter->namaLengkap; ?></td>
    </tr>
    <?php else: ?>


    <tr>
        <td width="45">No. RM</td>
        <td width="5">:</td>
        <td><?php echo $modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>;
        <td width="45">Tanggal</td>
        <td>:</td>
        <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->tglpelayanan)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
    </tr>
    <tr>

        <td>Dokter DPJP</td>
        <td>:</td>
        <td><?php echo empty($dokter) ? "-" : $dokter->namaLengkap; ?></td>
        <td rowspan="4">Kelas Terapi</td>
        <td rowspan="4">:</td>
        <td rowspan="4"><?php
        $therapi = TherapiobatM::model()->findByPk($modObat->therapiobat_id);
        if (!empty($therapi)) {
            echo $therapi->therapiobat_nama;
        }

        ?></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td width="5">:</td>
        <td><?php echo $modObat->pendaftaran->ruangan->ruangan_nama;  ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td colspan="3"><?php echo $modObat->penjualanresep->pasien->nama_pasien;  ?></td>
    </tr>
    <tr>
        <td>Usia</td>
        <td>:</td>
        <td colspan="3"><?php echo $modObat->pendaftaran->umur;  ?></td>
    </tr>
    <?php endif; ?>
<!--
	 <tr>
             <td><?php // echo $modObat->penjualanresep->pasien->nama_pasien.' - '.$modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>
	 </tr>-->
</table>
<table width="100%" style="text-align:center; margin-top: 5px;" class="tab_etiket">
	 <tr>
             <td><?php echo $modObat->obatalkes->obatalkes_nama." - (".$modObat->qty_oa.")";  ?></td>
	 </tr>
	 <tr>
             <td><?php echo $modObat->signa_oa;  ?></td>
	 </tr>
	 <tr>
             <td><?php echo $penggunaan;  ?></td>
	 </tr>
     <tr>
         <td align="center"> <?php echo (!empty($modObat->etiket) ? $modObat->etiket :""); ?> </td>
     </tr>
     <tr>
        <td align="center" style="font-family: Helvetica Neue;"><i>Semoga Lekas Sembuh</i></td>
     </tr>
</table>

</div>
 <?php } ?>
