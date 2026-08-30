<?php 
/**
 * perbaikan pada cetak laporan penanda tangan
 * RSST-3065
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 * 
 */
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
$this->renderPartial('laporanrekappengaduan/_table', array('model'=>$model));
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
        
	$direktur = PegawaiM::model()->findByAttributes(array('jabatan_id'=> Params::JABATAN_ID_DIREKTUR)); // nama jabatan "Direktur"
	$ka_Pengembangan = PegawaiM::model()->findByAttributes(array('jabatan_id'=>  Params::JABATAN_ID_PENGEMBANG)); //nama jabatan "Ka. bid Pengembangan" 
	$seksi_Pengaduan = PegawaiM::model()->findByAttributes(array('jabatan_id'=> Params::JABATAN_ID_PENGADUAN)); // nama jabatan "Ka. Sub. Bag. Umum & Kepegawaian"
        $rs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); // nama jabatan "Direktur"
?>
<table class="table-condensed" style="width:100%">
    <tr>
        <td align="center" width="30%">
            <p style="text-align: center; font-weight: bold;">
                Mengetahui,<br>
				Direktur <?php echo $rs->nama_rumahsakit ?>,
             <br>
             <br>
             <br>
             <br>
             <br>
             <u><?php echo isset ($direktur) ?$direktur->getNamaLengkap() :'tidak ada'; ?></u>
             <br>
              NIP. <?php echo isset ($direktur) ?$direktur->nomorindukpegawai:'tidak ada'; ?>
            </p>
        </td>
        <td align="center" width="30%">
            <p style="text-align: center; font-weight: bold;">
                <br>
				Kepala Bidang Pengembangan,
             <br>
             <br>
             <br>
             <br>
             <br>
              <u><?php echo isset ($ka_Pengembangan) ?$ka_Pengembangan->getNamaLengkap() :'tidak ada'; ?></u>
             <br>
              NIP. <?php echo isset ($ka_Pengembangan) ?$ka_Pengembangan->nomorindukpegawai :'tidak ada'; ?>
             <u><?php // echo $ka_Pengembangan->getNamaLengkap(); ?></u>
            
           
            </p>
        </td>
        <td align="center">
            <p style="text-align: center; font-weight: bold;">
				Surabaya, <?php echo MyFormatter::formatDateTimeId(date('Y-m-d')); ?>
				<br>
				Kepala Seksi Pengaduan,
             <br>
             <br>
             <br>
             <br>
             <br>
              <u><?php echo isset ($seksi_Pengaduan) ?$seksi_Pengaduan->getNamaLengkap() :'tidak ada'; ?></u>
             <br>
              NIP. <?php echo isset ($seksi_Pengaduan) ?$seksi_Pengaduan->nomorindukpegawai :'tidak ada'; ?>
             <u><?php // echo $seksi_Pengaduan->getNamaLengkap(); ?></u>
             
             
            </p>
        </td>
    </tr>
</table>
<?php
}
?>