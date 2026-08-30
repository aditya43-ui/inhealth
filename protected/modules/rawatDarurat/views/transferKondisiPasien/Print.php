<style>
    @page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
 
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
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
    
    .padding5{
        padding: 5px;
    }
</style>


<?php 
$this->widget('bootstrap.widgets.BootAlert');

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$modAnamnesa = AnamnesaT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'anamesa_id desc',
));

if (empty($modAnamnesa)) {
    $modAnamnesa = new AnamnesaT;
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();

$titleDetail = "";
$headerEws = "";
$headerEws2 = "";
 if(isset($model)){
    if($model->jenisews == 'ews'){
        $titleDetail = "RM.RI 46a";
        $headerEws = "ASSESMEN EARLY WARNING SCORE (EWS)";
        $headerEws2 = "(National Early Warning System (NEWS) untuk usia > 16th)";
    }else if($model->jenisews == 'pews'){
        $titleDetail = "RM.RI 43a";
        $headerEws = "ASSESMEN PEDIATRIC EARLY WARNING SCORE (PEWS)";
        $headerEws2 = "";
    }else if($model->jenisews == 'newborn ews'){
        $titleDetail = "RM.LL 31a";
        $headerEws = "ASSESMEN NEWBORN EARLY WARNING SCORE";
    }else if($model->jenisews == 'moews'){
        $titleDetail = "RM.RI 45a";
        $headerEws = "FORMULIR MEOWS <i>(Modified Obstetric Early Warning System)</i>";
        $headerEws2 = "Untuk pasien ibu hamil dengan usia kandungan 20 minggu sampai 6 minggu setelah melahirkan";
    }
}
?>
<div class="pull-right"><?php echo $titleDetail; ?></div>
<br>
<?php echo $this->renderPartial($this->path_view.'_headerSuratPrint', array('pendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien)); ?>
<br>
<center>
    <h3><?php echo $headerEws; ?></h3>
    <i><?php echo $headerEws2; ?></i>
</center>
<br>
<table width="100%" class="classtable">
    <tr>
        <td width="150px" style="text-align: right">Instalasi / Ruangan</td>
        <td width="10px">: </td>
        <td> <?php
               $ruanganNama = "";
               $instalasiNama = "";
               
               $ruangan = RuanganM::model()->findByPk($model->create_ruangan_id);
               
               if(isset($ruangan)){
                   $ruanganNama = $ruangan->ruangan_nama;
                   $instalasiNama = (isset($ruangan->instalasi)?$ruangan->instalasi->instalasi_nama : "");
               }
               
               echo $instalasiNama ." / ". $ruanganNama; ?>
        </td>
    </tr>
    <tr>
        <td width="150px"  style="text-align: right">Tanggal / Jam</td>
        <td width="10px">: </td>
        <td>
            <?php echo MyFormatter::formatDateTimeForUser($model->tanggalpengkajian); ?>
        </td>
    </tr>
</table>
<br>
<p><b>PETUNJUK UMUM</b></p>
<table width="100%" class="classtable borderclass">
    <tr>
        <td>
            1. Early Warning System tidak menggatikan klinis yang kompeten.
        </td>
    </tr>
    <tr>
        <td>
            2. Ketika anda khawatir tentang perawatan pasien harus ditingkatkan, perawatan dapat ditingkatkan terlepas dari skor.
        </td>
    </tr>
    <tr>
        <td>
            3. Beberapa pasien mungkin memerlukan pemeriksaan medis segera namun tidak memicu skor tinggi.
        </td>
    </tr>
    <tr>
        <td>
            4. Skor diaktifkan dengan skor 3 dalam waktu satu parameter atau total skor 3.
        </td>
    </tr>
    <tr>
        <td>
            5. Observasi dan pencatatan Early Warning System (EWS) ini dilakukan:
        </td>
    </tr>
    <tr>
        <td style="padding-left: 50px">
            1. Pada saat masuk.
        </td>
    </tr>
    <tr>
        <td style="padding-left: 50px">
            2. Setiap 8 jam (sesuai kebijakan RS).
        </td>
    </tr>
    <tr>
        <td style="padding-left: 50px">
            3. Sesuai Clinical Pathway.
        </td>
    </tr>
    <tr>
        <td style="padding-left: 50px">
            4. Jika pasien mengalami perubahan kondisi.
        </td>
    </tr>
    <tr>
        <td style="padding-left: 50px">
            5. Jika anda tentang perubahan kondisi pasien.
        </td>
    </tr>
</table>
<br>

<table class="borderclass" style="width: 90% !important;">
    <tr>
        <td style="padding: 10px;" class="borderbottomclass"><i><b>Hasil Pengkajian</b></i></td>
    </tr>
     <tr>
        <td style="padding: 10px;" >
        <center>
            <table class="borderclass" style="width: 100% !important;">
        <thead>
            <tr>
                <th class="text-center padding5 borderclass" width="250px">Parameter</th>  
                <th class="text-center borderclass">Penilaian</th>
                <th class="text-center borderclass" width="150px">Skor</th>
           </tr>
         </thead>
         <tbody>
              <?php 
                            $hasilpenilaian = array();
                            $skornilai = array();
                            
                            if(count($modDetail)>0){
                                foreach ($modDetail as $dataDet){
                                    $hasilpenilaian[$dataDet->nourut] = $dataDet->hasipenilaian;
                                    $skornilai[$dataDet->nourut] = $dataDet->skorpenilaian;
                                }
                            }
                            
                            if($model->jenisews == 'ews'){
                            ?>
                            <tr class="">
                                <td class="font-bold borderclass padding5">Pernapasan (kali/ per menit)</td>
                                <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Saturasi Oksigen</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Penggunaan Alat Bantu</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Suhu (&#176 C)</td>
                               <td class="borderclass"> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Denyut Jantung</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[4])?$hasilpenilaian[4]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[4])?$skornilai[4]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Tekanan Darah Sistolik</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[5])?$hasilpenilaian[5]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[5])?$skornilai[5]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Kesadaran</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[6])?$hasilpenilaian[6]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[6])?$skornilai[6]:0; ?></td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold borderclass padding5">Total Skor</td>
                               <td class="text-center borderclass"><?php echo $model->total_skor; ?> </td>
                           </tr>
                            <tr>
                                <th class="borderclass padding5" colspan="3" style="text-align: left; font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap National Early Warning System (NEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Klasifikasi</td>
                               <td colspan="2" class="borderclass padding5"><?php echo $model->klasifikasi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Respon Klinis</td>
                               <td colspan="2" class="borderclass padding5"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Tindakan</td>
                               <td colspan="2" class="borderclass padding5"><?php echo $model->tindakan; ?> </td>
                           </tr>
                            <?php
                            }else if($model->jenisews == 'pews'){
                            ?>
                            <tr class="">
                                <td class="font-bold borderclass padding5">Perilaku</td>
                                <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Kardiovaskular</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center "><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Respirasi</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr>
                               <th class="borderclass padding5" colspan="3" style="text-align: left; font-weight: bold; background-color: #CCCCCC">
                                    2 Skor Tambahan (Kondisional)
                                </th>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">1/4 jam nebulasi (terus menerus) atau muntah persisten setelah operasi</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold borderclass padding5">Total Skor</td>
                               <td class="text-center borderclass"><?php echo $model->total_skor; ?> </td>
                           </tr>
                            <tr>
                                <th class="borderclass padding5" colspan="3" style="text-align: left; font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap Pediatric Early Warning System (PEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Monitoring</td>
                               <td colspan="2" class="borderclass padding5"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Petugas</td>
                               <td colspan="2" class="borderclass padding5"><?php echo $model->monitoring_petugas; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Tindakan</td>
                               <td colspan="2" class="borderclass padding5"><?php echo $model->tindakan; ?> </td>
                           </tr>        
                            <?php
                            }else if($model->jenisews == 'newborn ews'){
                            ?>
                            <tr class="">
                                <td class="font-bold borderclass padding5">Suhu (&#176 C)</td>
                                <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Pernapasan</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass">Grunting (Mendengkur)</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass">Nadi</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass">Warna (SpO2)*</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[4])?$hasilpenilaian[4]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[4])?$skornilai[4]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass">Glukosa < 2,6 mmols</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[5])?$hasilpenilaian[5]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[5])?$skornilai[5]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass">Neuologi</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[6])?$hasilpenilaian[6]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[6])?$skornilai[6]:0; ?></td>
                           </tr>
                           <tr>
                               <td class="borderclass padding5" colspan="2" rowspan="3" class="font-bold" valign="middle">Skor</td>
                               <td class="borderclass padding5"><div style="float:right;">Hijau : <?php echo $model->total_skor_hijau; ?></div></td>
                           </tr>
                           <tr>
                               <td class="borderclass padding5"><div style="float:right;">Kuning : <?php echo $model->total_skor_kuning; ?></div></td>
                           </tr>
                            <tr>
                                <td class="borderclass padding5"><div style="float:right;">Merah : <?php echo $model->total_skor_merah; ?></div></td>
                           </tr>
                            <tr>
                                <th class="borderclass padding5" colspan="3" style="text-align: left; font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap Modified Obstetric Early Warning System (MOEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Warna / Nilai EWS</td>
                               <td class="borderclass padding5" colspan="2"><?php echo $model->total_skor; ?>  </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Monnitoring Frekuensi</td>
                               <td class="borderclass padding5" colspan="2"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Asuhan yang Diberikan</td>
                               <td class="borderclass padding5" colspan="2"><?php echo $model->tindakan; ?> </td>
                           </tr>    
                            <?php
                            }else if($model->jenisews == 'moews'){
                            ?>
                            <tr class="">
                                <td class="font-bold borderclass padding5">Respirasi</td>
                                <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Saturasi O2</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Penggunaan O2</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Suhu (&#176 C)</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Tekanan Darah Sistolik</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[4])?$hasilpenilaian[4]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[4])?$skornilai[4]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Tekanan Darah Diastolik</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[5])?$hasilpenilaian[5]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[5])?$skornilai[5]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Nadi</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[6])?$hasilpenilaian[6]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[6])?$skornilai[6]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Tingkat Kesadaran</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[7])?$hasilpenilaian[7]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[7])?$skornilai[7]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Nyeri</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[8])?$hasilpenilaian[8]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[8])?$skornilai[8]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Pengeluaran / Lochea</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[9])?$hasilpenilaian[9]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[9])?$skornilai[9]:0; ?></td>
                           </tr>
                           <tr class="">
                               <td class="font-bold borderclass padding5">Protein Urin</td>
                               <td class="borderclass padding5"> 
                                   <?php echo isset($hasilpenilaian[10])?$hasilpenilaian[10]:""; ?> 
                               </td>      
                               <td class="text-center borderclass"><?php echo isset($skornilai[10])?$skornilai[10]:0; ?></td>
                           </tr>
                           <tr> 
                               <td colspan="2" class="font-bold padding5">Total Skor</td>
                               <td class="text-center padding5"><?php echo $model->total_skor; ?> </td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold borderclass padding5">Keterangan Skor</td>
                               <td class="text-center borderclass padding5"><?php echo $model->klasifikasi; ?> </td>
                           </tr>
                            <tr>
                                <th class="borderclass padding5" colspan="3" style="text-align: left; font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap Modified Obstetric Early Warning System (MOEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Monitoring Frekuensi</td>
                               <td class="borderclass padding5" colspan="2"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Petugas</td>
                               <td class="borderclass padding5" colspan="2"><?php echo $model->monitoring_petugas; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold borderclass padding5">Tindakan</td>
                               <td class="borderclass padding5" colspan="2"><?php echo $model->tindakan; ?> </td>
                           </tr>   
                            <?php
                            }
                         ?>
         </tbody>
    </table>
</center>
        </td>
    </tr>
</table>

<table width="100%">
	<tr>
            <td style="width:75%; text-align: left;" colspan="2">
            </td>
            <td style="width:25%; text-align: left;" colspan="2" >
                Lubuk Basung, <?php echo date('d').' '.MyFormatter::getMonthId(date('m')).' '.date('Y'); ?>
            </td>
	</tr>
</table>
<table width="100%">
	<tr>
            <td style="width:70%; text-align: left;" colspan="2">
            </td>
            <td style="width:30%; text-align: left;" colspan="2" >
                <center>Petugas Pengkajian
                <br><br><br><br><br><br>
               <?php echo (isset($model->petugaspengkaji)? $model->petugaspengkaji->namaLengkap: ""); ?><br />
                </center>
            </td>
	</tr>
</table>

