
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
        <tr>
             <td>
                <div class="header"><?php
                if($caraPrint != 'EXCEL'){
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judul_print));
                } ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
  <?php
if(!$modPenerimaanDetail){
    echo "Data tidak ditemukan."; exit;
}

$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$modPemesan = PengajuansterlilisasiT::model()->findByPk($modPenerimaan->pengajuansterlilisasi_id);
?>
<body class="kertas">
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Penerimaan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaan->penerimaansterilisasi_tgl) ? $format->formatDateTimeId($modPenerimaan->penerimaansterilisasi_tgl) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Penerimaan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaan->penerimaansterilisasi_no) ? $modPenerimaan->penerimaansterilisasi_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaan->ruangan->ruangan_nama) ? $modPenerimaan->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPenerimaan->penerimaansterilisasi_ket) ? $modPenerimaan->penerimaansterilisasi_ket : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>Nama Peralatan dan Linen</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </thead>
		<tbody class="border">
        <?php 
			$total = 0;
			foreach ($modPenerimaanDetail as $i=>$modLinen){ 
        ?>
            <tr>
                <td><?php echo $modLinen->peralatansterilisasi->peralatansterilisasi_nama; ?></td>
                <td><?php echo $modLinen->penerimaansterilisasidet_jml; ?></td>
                <td><?php echo $modLinen->penerimaansterilisasidet_ket; ?></td>
            </tr>
        <?php } ?>
		</tbody>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Pemesan</div>
                        <div style="margin-top:60px;"><?php echo (!empty($modPemesan) && !empty($modPemesan->pegawaiMengajukan)) ? $modPemesan->pegawaiMengajukan->nama_pegawai : ""; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Penerima</div>
                        <div style="margin-top:60px;"><?php echo !empty($modPenerimaan->pegmenerima_id) ? $modPenerimaan->pegawaiMenerima->nama_pegawai : ""; ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
<br>
<div class="">
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
   
</div>   
