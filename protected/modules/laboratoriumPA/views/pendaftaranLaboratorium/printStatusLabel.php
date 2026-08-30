<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    body{
        width: 10cm;
        height: 11cm;
    }
    th, td, div{
        font-family:Times New Roman;
        font-size: 9.7pt;
        line-height: 12px;
    }
    
</style>
<?php
	//var_dump($query);die();
	$row="";
	foreach($query as $data):
		$row.="
        <tr>
            <td width='130'>No. Rekam Medik</td>
            <td>:</td>
            <td><strong>".$data['no_rekam_medik']."</strong></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td>".$data['nama_pasien']."</td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td>".$data['no_pendaftaran']."</td>
        </tr>
        <tr>
            <td>No. Sampel</td>
            <td>:</td>
            <td>".$data['no_pengambilansample']."</td>
        </tr>
        <tr>
            <td>Tanggal Pengembalian Sampel</td>
            <td>:</td>
            <td>".date("d F Y",strtotime($data['tglpengambilansample']))."</td>
        </tr>
		";
	endforeach;
?>
<div class="labelPrint">
    <table class="border">
       <?php 
			if($row){
				echo $row;
			}else{
				echo"<strong>Maaf Data Label Tidak Ditemukan</strong>					
				";
			}	   
	   ;?>
    </table>
</div>

