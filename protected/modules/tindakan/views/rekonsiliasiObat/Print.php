<?php
if (isset($caraPrint)){
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="REKONSILIASI OBAT-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');
	}
}
 ?>
<style type="text/css">
  @page {
  size: A4;
  margin: 0;
  }
  @media print {
    html, body {
      width: 210mm;
      height: 297mm;
    }

    body {
        color: black;
        font-size: 8pt !important;
    }
  }

  html{
    font-size: 11pt !important;
    color: black;
  }

  body{
      color: black !important;
      margin: 0;
      padding: 0;
      font-size: 11pt !important;
  }

  table{
    font-size: 11pt !important;
    color: black;
  }

    label{
        color: black !important;
    }

    .fa{
        font-size: 12pt;
    }

    p {
        text-align: justify;
    }

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .textbold {
        font-weight: bold !important;
    }
    .textcenter {
        text-align: center !important;
    }

    .textright {
        text-align: right !important;
    }

    .padding10 {
        padding: 10px !important;
    }
    .padding5 {
        padding: 5px;
    }

    .table-bordercustom th, .table-bordercustom td {
        border:1px solid #000;
        padding: 10px;
    }

    .tablepadding th, .tablepadding td{
        padding: 5px;
    }

    .table-bordercustom th{
        text-align: center;
    }

</style>
<?php
  $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
 ?>
<div class="textbold padding10">
  FRM/88 Rev 01/RSBM
</div>
<?php echo $this->renderPartial($this->path_view."_headerPrint", array(
     'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran
 ), true); ?>
<br/>
<table width="100%">
  <tr>
    <td class="padding5 borderclass">A. Daftar Obat Yang Menyebabkan Alergi</td>
  </tr>
  <tr>
    <td class="padding10 borderclass">
      <table width="100%" class="table-bordercustom">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Petugas Pengisi</th>
            <th>Nama Obat</th>
            <th>Keparahan Reaksi Obat</th>
            <th>Bentuk Reaksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(count($modRekonAlergi)>0){
              $no = 1;
              foreach ($modRekonAlergi as $dataRekAlergi) {
                ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($dataRekAlergi->tanggal_pengisian); ?></td>
                    <td><?php echo $dataRekAlergi->petugas->namaLengkap; ?></td>
                    <td><?php echo $dataRekAlergi->nama_obat; ?></td>
                    <td><?php echo $dataRekAlergi->reaksialergi; ?></td>
                    <td><?php echo $dataRekAlergi->bentukreaksi; ?></td>
                  </tr>
                <?php
                $no++;
              }
            }
           ?>
        </tbody>
      </table>
    </td>
  </tr>
</table>
 <br/>
 <table width="100%">
   <tr>
     <td class="padding5 borderclass">B. Daftar Obat Sebelum Admisi (Obat yang dikomsumsi dirumah, termasuk yang diresepkan, vitamin, suplemen dll)</td>
   </tr>
   <tr>
     <td class="padding10 borderclass">
       <table width="100%" class="table-bordercustom">
         <thead>
           <tr>
             <th>No</th>
             <th>Tanggal</th>
             <th>Dari</th>
             <th>Ke</th>
             <th>Petugas Pengisi</th>
             <th>Nama Obat</th>
             <th>Dosis</th>
             <th>Frekuensi</th>
             <th>Cara Pemberian</th>
             <th>Waktu Pemberian Terakhir</th>
             <th>Jumlah</th>
             <th>Tindak Lanjut</th>
             <th>Keterangan</th>
           </tr>
         </thead>
         <tbody>
           <?php
             if(count($modRekonAdmisi)>0){
               $no = 1;
               foreach ($modRekonAdmisi as $dataRekAdmisi) {
                 $petugas = PegawaiM::model()->findByPk($dataRekAdmisi->petugas_id);
                 ?>
                   <tr>
                     <td><?php echo $no; ?></td>
                     <td><?php echo MyFormatter::formatDateTimeForUser($dataRekAdmisi->tanggal_pengisian); ?></td>
                     <td><?php echo $dataRekAdmisi->rujukansebelumnya; ?></td>
                     <td><?php echo $dataRekAdmisi->rujukanke; ?></td>
                     <td><?php echo $petugas->namaLengkap; ?></td>
                     <td><?php echo $dataRekAdmisi->nama_obat; ?></td>
                     <td><?php echo $dataRekAdmisi->dosis; ?></td>
                     <td><?php echo $dataRekAdmisi->frekuensi; ?></td>
                     <td><?php echo $dataRekAdmisi->cara_pemberian; ?></td>
                     <td><?php echo $dataRekAdmisi->waktu_pemberian; ?></td>
                     <td><?php echo $dataRekAdmisi->jumlah_obat; ?></td>
                     <td><?php echo $dataRekAdmisi->tindaklanjut; ?></td>
                     <td><?php echo $dataRekAdmisi->keterangan; ?></td>
                   </tr>
                 <?php
                 $no++;
               }
             }
            ?>
         </tbody>
       </table>
     </td>
   </tr>
 </table>
 <br/>
 <table width="100%">
   <tr>
     <td class="padding5 borderclass">C. Daftar Obat Saat Transfer</td>
   </tr>
   <tr>
     <td class="padding10 borderclass">
       <table width="100%" class="table-bordercustom">
         <thead>
           <tr>
             <th>No</th>
             <th>Tanggal</th>
             <th>Dari</th>
             <th>Ke</th>
             <th>Petugas Pengisi</th>
             <th>Nama Obat</th>
             <th>Dosis</th>
             <th>Frekuensi</th>
             <th>Cara Pemberian</th>
             <th>Waktu Pemberian Terakhir</th>
             <th>Jumlah</th>
             <th>Tindak Lanjut</th>
             <th>Keterangan</th>
           </tr>
         </thead>
         <tbody>
           <?php
             if(count($modRekonTransfer)>0){
               $no = 1;
               foreach ($modRekonTransfer as $dataRekTransfer) {
                 $petugas = PegawaiM::model()->findByPk($dataRekTransfer->petugas_id);
                 ?>
                   <tr>
                     <td><?php echo $no; ?></td>
                     <td><?php echo MyFormatter::formatDateTimeForUser($dataRekTransfer->tanggal_pengisian); ?></td>
                     <td><?php echo $dataRekTransfer->rujukansebelumnya; ?></td>
                     <td><?php echo $dataRekTransfer->rujukanke; ?></td>
                     <td><?php echo $petugas->namaLengkap; ?></td>
                     <td><?php echo $dataRekTransfer->nama_obat; ?></td>
                     <td><?php echo $dataRekTransfer->dosis; ?></td>
                     <td><?php echo $dataRekTransfer->frekuensi; ?></td>
                     <td><?php echo $dataRekTransfer->cara_pemberian; ?></td>
                     <td><?php echo $dataRekTransfer->waktu_pemberian; ?></td>
                     <td><?php echo $dataRekTransfer->jumlah_obat; ?></td>
                     <td><?php echo $dataRekTransfer->tindaklanjut; ?></td>
                     <td><?php echo $dataRekTransfer->keterangan; ?></td>
                   </tr>
                 <?php
                 $no++;
               }
             }
            ?>
         </tbody>
       </table>
     </td>
   </tr>
 </table>
 <br/>
 <table width="100%">
   <tr>
     <td class="padding5 borderclass">D. Daftar Obat saat Discharge</td>
   </tr>
   <tr>
     <td class="padding10 borderclass">
       <table width="100%" class="table-bordercustom">
         <thead>
           <tr>
             <th>No</th>
             <th>Tanggal</th>
             <th>Dari</th>
             <th>Ke</th>
             <th>Petugas Pengisi</th>
             <th>Nama Obat</th>
             <th>Dosis</th>
             <th>Frekuensi</th>
             <th>Cara Pemberian</th>
             <th>Waktu Pemberian Terakhir</th>
             <th>Jumlah</th>
             <th>Tindak Lanjut</th>
             <th>Keterangan</th>
           </tr>
         </thead>
         <tbody>
           <?php
             if(count($modRekonDischarge)>0){
               $no = 1;
               foreach ($modRekonDischarge as $dataRekDischarge) {
                 $petugas = PegawaiM::model()->findByPk($dataRekDischarge->petugas_id);
                 ?>
                   <tr>
                     <td><?php echo $no; ?></td>
                     <td><?php echo MyFormatter::formatDateTimeForUser($dataRekDischarge->tanggal_pengisian); ?></td>
                     <td><?php echo $dataRekDischarge->rujukansebelumnya; ?></td>
                     <td><?php echo $dataRekDischarge->rujukanke; ?></td>
                     <td><?php echo $petugas->namaLengkap; ?></td>
                     <td><?php echo $dataRekDischarge->nama_obat; ?></td>
                     <td><?php echo $dataRekDischarge->dosis; ?></td>
                     <td><?php echo $dataRekDischarge->frekuensi; ?></td>
                     <td><?php echo $dataRekDischarge->cara_pemberian; ?></td>
                     <td><?php echo $dataRekDischarge->waktu_pemberian; ?></td>
                     <td><?php echo $dataRekDischarge->jumlah_obat; ?></td>
                     <td><?php echo $dataRekDischarge->tindaklanjut; ?></td>
                     <td><?php echo $dataRekDischarge->keterangan; ?></td>
                   </tr>
                 <?php
                 $no++;
               }
             }
            ?>
         </tbody>
       </table>
     </td>
   </tr>
 </table>
 <br/>
 <?php
	$namaPasienKeluarga = $modPasien->namadepan.' '.$modPasien->nama_pasien;

	if(Yii::app()->user->getState("instalasi_id") != Params::INSTALASI_ID_RI){
		$penanggungjwb = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
		$namaPasienKeluarga = (!empty($penanggungjwb)? $penanggungjwb->nama_pj : $namaPasienKeluarga);
	}

  ?>
 <div style="padding: 0px 20px">
   <table width="100%" class="table-bordercustom">
     <tr>
       <td width="25%"></td>
       <td width="25%" class="textcenter">Sebelum Admisi</td>
       <td width="25%" class="textcenter">Saat Transfer</td>
       <td width="25%" class="textcenter">Saat Discharge</td>
     </tr>
     <tr>
       <td valign="middle">
         Apoteker yang melakukan rekonsiliasi obat
       </td>
       <td>
         <center>
           <br/><br/><br/><br/>
           <?php
           $pegawaiAdmisi = "";
           $tglpengisiAdmisi = "";
            $modRekonAdmisiTerakhir = RekonobatadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id),array('order'=>'create_time DESC'));
            if(isset($modRekonAdmisiTerakhir) && !empty($modRekonAdmisiTerakhir)){
              $pegawaiAdmisi = $modRekonAdmisiTerakhir->petugas->namaLengkap;
              $tglpengisiAdmisi = MyFormatter::formatDateTimeForUser($modRekonAdmisiTerakhir->tanggal_pengisian);
            }
            echo $pegawaiAdmisi.'<br/>'.$tglpengisiAdmisi;
            ?>
        <center>
       </td>
       <td>
         <center>
           <br/><br/><br/><br/>
           <?php
           $pegawaiTransfer = "";
           $tglpengisiTransfer = "";
            $modRekonTransferTerakhir = RekonobattransferT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id),array('order'=>'create_time DESC'));
            if(isset($modRekonTransferTerakhir) && !empty($modRekonTransferTerakhir)){
              $pegawaiTransfer = $modRekonTransferTerakhir->petugas->namaLengkap;
              $tglpengisiTransfer = MyFormatter::formatDateTimeForUser($modRekonTransferTerakhir->tanggal_pengisian);
            }
            echo $pegawaiTransfer.'<br/>'.$tglpengisiTransfer;
            ?>
        <center>
       </td>
       <td>
         <center>
           <br/><br/><br/><br/>
           <?php
           $pegawaiDisc = "";
           $tglpengisiDisc = "";
            $modRekonDiscTerakhir = RekonobatdischargeT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id),array('order'=>'create_time DESC'));
            if(isset($modRekonDiscTerakhir) && !empty($modRekonDiscTerakhir)){
              $pegawaiDisc = $modRekonDiscTerakhir->petugas->namaLengkap;
              $tglpengisiDisc = MyFormatter::formatDateTimeForUser($modRekonDiscTerakhir->tanggal_pengisian);
            }
            echo $pegawaiDisc.'<br/>'.$tglpengisiDisc;
            ?>
        <center>
       </td>
     </tr>
     <tr>
       <td valign="middle">
         Pasien/ Keluarga Pasien
       </td>
       <td>
         <center>
           <br/><br/><br/><br/>
           <?php
            echo $namaPasienKeluarga;
            ?>
        <center>
       </td>
       <td>
         <center>
           <br/><br/><br/><br/>
           <?php
           echo $namaPasienKeluarga;
            ?>
        <center>
       </td>
       <td>
         <center>
           <br/><br/><br/><br/>
           <?php
           echo $namaPasienKeluarga;
            ?>
        <center>
       </td>
     </tr>
   </table>
 </div>
