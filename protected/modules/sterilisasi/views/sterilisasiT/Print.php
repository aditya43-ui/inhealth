
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
             
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judul_print));
                 ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
  <fieldset>
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Sterilisasi</td>
            <td>:</td>
            <td><?php echo $modSterilisasi->sterilisasi_no; ?></td>
        </tr>
        <tr>
            <td>Tanggal Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modSterilisasi->sterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($modSterilisasi->sterilisasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Sterilisasi</td>
            <td>:</td>
            <td><?php echo (isset($modSterilisasi->pegsterilisasi->NamaLengkap) ? $modSterilisasi->pegsterilisasi->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $modSterilisasi->sterilisasi_ket; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>Ruangan Asal</th>
				<th>No. Penerimaan</th>
				<th>Nama Peralatan dan Linen</th>
				<th>Jumlah</th>
				<th>Keterangan</th>
				<th>Jenis Sterilisasi</th>
				<th>Alat Sterilisasi</th>
				<th>Bahan yang Digunakan</th>
				<th>Kemasan yang Digunakan</th>
				<th>Waktu Kedaluwarsa</th>
			</tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modSterilisasiDetail) > 0){
                foreach($modSterilisasiDetail AS $i=>$modDetail){ 
                   $modPeralatanSterilisasi = PeralatansterilisasiM::model()->findByPk($modDetail->peralatansterilisasi_id);
                   // var_dump($modDetail->attributes); die;
                    ?>
            <tr>
                <td><?php echo $i+1; ?></td>
	         <td><?php echo (!empty($modDetail->penerimaansterilisasi->ruangan_id) ? $modDetail->penerimaansterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->penerimaansterilisasi->penerimaansterilisasi_no) ? $modDetail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($modDetail->peralatansterilisasi_id) ? $modPeralatanSterilisasi->peralatansterilisasi_nama : ""); ?></td>
                <td><?php echo (!empty($modDetail->sterilisasidetail_jml) ? $modDetail->sterilisasidetail_jml : 0); ?></td>
                <td><?php echo (!empty($modDetail->sterilisasidetail_ket) ? $modDetail->sterilisasidetail_ket : 0); ?></td>
                <td><?php echo (!empty($modDetail->jenissterilisasi_id) ? $modDetail->jenissterilisasi->jenissterilisasi_nama : 0); ?></td>
                <td><?php 
                $barang = BarangM::model()->findByPk($modDetail->barang_id);
                if (!empty($barang)) {
                    echo $barang->barang_nama;
                } else {
                    echo "-";
                }
                ?></td>
                <td>
					<ol type="1">
					<?php 
						$modSterilisasiBahan = STSterilisasibahanT::model()->findAllByAttributes(array('sterilisasidetail_id'=>$modDetail->sterilisasidetail_id));
						if(count((array)$modSterilisasiBahan) > 0){
							foreach($modSterilisasiBahan as $a=>$bahan){ ?>
						<li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
					<?php } ?>
					<?php } ?>
						</ol>
				</td>
                <td><?php echo $modDetail->kemasanygdigunakan; ?></td>
                <td><?php echo isset($modDetail->waktukadaluarsa) ? MyFormatter::formatDateTimeForUser($modDetail->waktukadaluarsa) : ""; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>	
</fieldset>
<table width="80%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($modSterilisasi->pegsterilisasi->NamaLengkap) ? $modSterilisasi->pegsterilisasi->NamaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($modSterilisasi->pegmengetahui->NamaLengkap) ? $modSterilisasi->pegmengetahui->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
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
