
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
if(!$modPemesananDetail){
    echo "Data tidak ditemukan."; exit;
}

$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
    <table width="74%"  style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Pengajuan Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->pesanperlinensteril_tgl) ? $format->formatDateTimeId($modPemesanan->pesanperlinensteril_tgl) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Pengajuan Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->pesanperlinensteril_no) ? $modPemesanan->pesanperlinensteril_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->ruangan->ruangan_nama) ? $modPemesanan->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->pesanperlinensteril_ket) ? $modPemesanan->pesanperlinensteril_ket : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" class="border" style='margin-left:auto; margin-right:auto;'>
        <thead >
            <th>Nama Peralatan dan Linen</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </thead>
		<tbody>
        <?php 
			$total = 0;
			foreach ($modPemesananDetail as $i=>$modLinen){ 
			$total = $total+$modLinen->pesanperlinensterildet_jml; 
        ?>
            <tr>
                <td><?php echo $modLinen->barang->barang_nama; ?></td>
                <td><?php echo $modLinen->pesanperlinensterildet_jml; ?></td>
                <td><?php echo $modLinen->pesanperlinensterildet_ket; ?></td>
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
                        <div>Memesan<br></div>
                        <div style="margin-top:60px;"><?php echo $modPemesanan->pegawaiMemesan->nama_pegawai; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $modPemesanan->pegawaiMengetahui->nama_pegawai; ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>

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
