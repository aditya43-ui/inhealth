<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',
        array(
            'judulLaporan'=>$data['judulLaporan'],
            'periode'=>$data['periode']
        )
    );
?>
<?php 
$this->renderPartial('laporanrekapsayhello/_table', array('model'=>$model));
?>
<br>
<br>
<?php
if($caraPrint=='EXCEL')
{
?>

<?php
}
else {
	$direktur = PegawaiM::model()->findByAttributes(array('jabatan_id'=> 1)); // nama jabatan "Direktur"
	$ka_Pengembangan = PegawaiM::model()->findByAttributes(array('jabatan_id'=> 53)); //nama jabatan "Ka. bid Pengembangan" 
	$seksi_Pengaduan = PegawaiM::model()->findByAttributes(array('jabatan_id'=> 7)); // nama jabatan "Ka. Sub. Bag. Umum & Kepegawaian"
?>
<table class="table-condensed" style="width:100%">
    <tr>
        <td align="center" width="30%">
            <p style="text-align: center; font-weight: bold;">
                Mengetahui,<br>
				Direktur RSUD Dr.R.Soedarsono Kota Pasuruan,
             <br>
             <br>
             <br>
             <br>
             <br>
             <u><?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?></u>
             <br>
              NIP. <?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?>
             <u><?php // echo $direktur->getNamaLengkap(); ?></u>
             <br>
              NIP. <?php // echo $direktur->nomorindukpegawai; ?>
            </p>
        </td>
        <td align="center" width="30%">
            <p style="text-align: center; font-weight: bold;">
                <br>
				Kepala Bidang Pengembangan dan Pengaduan,
             <br>
             <br>
             <br>
             <br>
             <br>
             <u><?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?></u>
             <br>
              NIP. <?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?>
             <u><?php // echo $ka_Pengembangan->getNamaLengkap(); ?></u>
             <br>
              NIP. <?php // echo $ka_Pengembangan->nomorindukpegawai; ?>
            </p>
        </td>
        <td align="center">
            <p style="text-align: center; font-weight: bold;">
				<br>
				Kepala Seksi Pengaduan,
             <br>
             <br>
             <br>
             <br>
             <br>
              <u><?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?></u>
             <br>
              NIP. <?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?>
             <!--<u><?php // echo $seksi_Pengaduan->getNamaLengkap(); ?></u>-->
             <br>
              NIP. <?php // echo $seksi_Pengaduan->nomorindukpegawai; ?>
            </p>
        </td>
    </tr>
</table>
<?php
}
?>