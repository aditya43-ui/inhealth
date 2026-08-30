
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
                       
   <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Pengajuan Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modPengajuan->pengajuansterlilisasi_tgl) ? $format->formatDateTimeId($modPengajuan->pengajuansterlilisasi_tgl) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Pengajuan Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modPengajuan->pengajuansterlilisasi_no) ? $modPengajuan->pengajuansterlilisasi_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPengajuan->ruangan->ruangan_nama) ? $modPengajuan->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPengajuan->keterangan_pengperawatanlinen) ? $modPengajuan->keterangan_pengperawatanlinen : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" class="table border" style='margin-left:auto; margin-right:auto;'>
        <thead >
            <th>Nama Peralatan dan Linen</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </thead>
		<tbody>
        <?php 
			$total = 0;
			foreach ($modPengajuanDetail as $i=>$modLinen){ 
			$total = $total+$modLinen->pengajuansterlilisasidet_jml; 
        ?>
            <tr>
                <td>
				<?php 
					/*if(!empty($modLinen->linen_id)){
						echo $modLinen->linen->namalinen; 
					}
					else{
						echo $modLinen->barang->barang_nama; 
					}*/
                                echo $modLinen->peralatansterilisasi->peralatansterilisasi_nama;
				?>
				</td>
                <td><?php echo $modLinen->pengajuansterlilisasidet_jml; ?></td>
                <td><?php echo $modLinen->pengajuansterlilisasidet_ket; ?></td>
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
                        <div>Mengajukan<br></div>
                        <div style="margin-top:60px;font-weight: bold;">(<?php echo isset($modPengajuan->pegpengajuan_id) ? $modPengajuan->pegawaiMengajukan->NamaLengkap : ""; ?>)</div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;font-weight: bold;">(<?php echo isset($modPengajuan->pegmengetahui_id) ? $modPengajuan->pegawaiMengetahui->namaLengkap : ""; ?>)</div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
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
