<style type="text/css">
    .classtable tr td{
        color: black;
    }
    
    .text-center{
        text-align: center !important;
    }
</style>
<table width="100%" class="classtable">
    <tr>
        <td width="150px">Instalasi / Ruangan</td>
        <td>
            : <?php
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
        <td width="150px">Tanggal / Jam</td>
        <td>
            : <?php echo MyFormatter::formatDateTimeForUser($model->tanggalpengkajian); ?>
        </td>
    </tr>
    <tr>
        <td width="150px">Petugas Pengkajian</td>
        <td>
            : <?php echo (isset($model->petugaspengkaji)? $model->petugaspengkaji->namaLengkap: ""); ?>
        </td>
    </tr>
</table>
<br />
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Hasil Pengkajian</div>
    </div>
    <div class="panel-body">
        <div class="table-responsive" style="overflow-x:auto;">
            <div class='block-tabel'>
                <center>
                <table class="items table table-bordered" id="tblchoise_moews" style="width: 80% !important;">
                    <thead>
                        <tr>
                            <th class="text-center" width="250px">Parameter</th>  
                            <th class="text-center">Penilaian</th>
                            <th class="text-center" width="150px">Skor</th>
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
                            <tr class="trSkorEws">
                                <td class="font-bold">Pernapasan (kali/ per menit)</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="trSkorEws">
                               <td class="font-bold">Saturasi Oksigen</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="trSkorEws">
                               <td class="font-bold">Penggunaan Alat Bantu</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr class="trSkorEws">
                               <td class="font-bold">Suhu (&#176 C)</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr class="trSkorEws">
                               <td class="font-bold">Denyut Jantung</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[4])?$hasilpenilaian[4]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[4])?$skornilai[4]:0; ?></td>
                           </tr>
                           <tr class="trSkorEws">
                               <td class="font-bold">Tekanan Darah Sistolik</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[5])?$hasilpenilaian[5]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[5])?$skornilai[5]:0; ?></td>
                           </tr>
                           <tr class="trSkorEws">
                               <td class="font-bold">Kesadaran</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[6])?$hasilpenilaian[6]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[6])?$skornilai[6]:0; ?></td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold">Total Skor</td>
                               <td class="text-center"><?php echo $model->total_skor; ?> </td>
                           </tr>
                            <tr>
                                <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap National Early Warning System (NEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold">Klasifikasi</td>
                               <td colspan="2"><?php echo $model->klasifikasi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Respon Klinis</td>
                               <td colspan="2"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Tindakan</td>
                               <td colspan="2"><?php echo $model->tindakan; ?> </td>
                           </tr>
                            <?php
                            }else if($model->jenisews == 'pews'){
                            ?>
                            <tr class="trSkorPews">
                                <td class="font-bold">Perilaku</td>
                              <td> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="trSkorPews">
                               <td class="font-bold">Kardiovaskular</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="trSkorPews">
                               <td class="font-bold">Respirasi</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr>
                                <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                                    2 Skor Tambahan (Kondisional)
                                </th>
                           </tr>
                           <tr class="trSkorPews">
                               <td class="font-bold">1/4 jam nebulasi (terus menerus) atau muntah persisten setelah operasi</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold">Total Skor</td>
                               <td class="text-center"><?php echo $model->total_skor; ?> </td>
                           </tr>
                            <tr>
                                <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap Pediatric Early Warning System (PEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold">Monitoring</td>
                               <td colspan="2"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Petugas</td>
                               <td colspan="2"><?php echo $model->monitoring_petugas; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Tindakan</td>
                               <td colspan="2"><?php echo $model->tindakan; ?> </td>
                           </tr>        
                            <?php
                            }else if($model->jenisews == 'newborn ews'){
                            ?>
                            <tr class="trSkorNews">
                                <td class="font-bold">Suhu (&#176 C)</td>
                              <td> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="trSkorNews">
                               <td class="font-bold">Pernapasan</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="trSkorNews">
                               <td class="font-bold">Grunting (Mendengkur)</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr class="trSkorNews">
                               <td class="font-bold">Nadi</td>
                              <td> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr class="trSkorNews">
                               <td class="font-bold">Warna (SpO2)*</td>
                              <td> 
                                   <?php echo isset($hasilpenilaian[4])?$hasilpenilaian[4]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[4])?$skornilai[4]:0; ?></td>
                           </tr>
                           <tr class="trSkorNews">
                               <td class="font-bold">Glukosa < 2,6 mmols</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[5])?$hasilpenilaian[5]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[5])?$skornilai[5]:0; ?></td>
                           </tr>
                           <tr class="trSkorNews">
                               <td class="font-bold">Neuologi</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[6])?$hasilpenilaian[6]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[6])?$skornilai[6]:0; ?></td>
                           </tr>
                           <tr>
                               <td colspan="2" rowspan="3" class="font-bold" valign="middle">Skor</td>
                               <td><div style="float:right;">Hijau : <?php echo $model->total_skor_hijau; ?></div></td>
                           </tr>
                           <tr>
                               <td><div style="float:right;">Kuning : <?php echo $model->total_skor_kuning; ?></div></td>
                           </tr>
                            <tr>
                               <td><div style="float:right;">Merah : <?php echo $model->total_skor_merah; ?></div></td>
                           </tr>
                            <tr>
                                <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap Modified Obstetric Early Warning System (MOEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold">Warna / Nilai EWS</td>
                               <td colspan="2"><?php echo $model->total_skor; ?>  </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Monnitoring Frekuensi</td>
                               <td colspan="2"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Asuhan yang Diberikan</td>
                               <td colspan="2"><?php echo $model->tindakan; ?> </td>
                           </tr>    
                            <?php
                            }else if($model->jenisews == 'moews'){
                            ?>
                            <tr class="trSkorMoews">
                                <td class="font-bold">Respirasi</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[0])?$hasilpenilaian[0]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[0])?$skornilai[0]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Saturasi O2</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[1])?$hasilpenilaian[1]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[1])?$skornilai[1]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Penggunaan O2</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[2])?$hasilpenilaian[2]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[2])?$skornilai[2]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Suhu (&#176 C)</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[3])?$hasilpenilaian[3]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[3])?$skornilai[3]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Tekanan Darah Sistolik</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[4])?$hasilpenilaian[4]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[4])?$skornilai[4]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Tekanan Darah Diastolik</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[5])?$hasilpenilaian[5]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[5])?$skornilai[5]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Nadi</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[6])?$hasilpenilaian[6]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[6])?$skornilai[6]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Tingkat Kesadaran</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[7])?$hasilpenilaian[7]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[7])?$skornilai[7]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Nyeri</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[8])?$hasilpenilaian[8]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[8])?$skornilai[8]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Pengeluaran / Lochea</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[9])?$hasilpenilaian[9]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[9])?$skornilai[9]:0; ?></td>
                           </tr>
                           <tr class="trSkorMoews">
                               <td class="font-bold">Protein Urin</td>
                               <td> 
                                   <?php echo isset($hasilpenilaian[10])?$hasilpenilaian[10]:""; ?> 
                               </td>      
                               <td class="text-center"><?php echo isset($skornilai[10])?$skornilai[10]:0; ?></td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold">Total Skor</td>
                               <td class="text-center"><?php echo $model->total_skor; ?> </td>
                           </tr>
                           <tr>
                               <td colspan="2" class="font-bold">Keterangan Skor</td>
                               <td class="text-center"><?php echo $model->klasifikasi; ?> </td>
                           </tr>
                            <tr>
                                <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                                    Respon Klinis Terhadap Modified Obstetric Early Warning System (MOEWS)
                                </th>
                           </tr>
                           <tr>
                               <td class="font-bold">Monitoring Frekuensi</td>
                               <td colspan="2"><?php echo $model->monitoring_frekuensi; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Petugas</td>
                               <td colspan="2"><?php echo $model->monitoring_petugas; ?> </td>
                           </tr>
                           <tr>
                               <td class="font-bold">Tindakan</td>
                               <td colspan="2"><?php echo $model->tindakan; ?> </td>
                           </tr>   
                            <?php
                            }
                         ?>
                     </tbody>
                </table>
                    </center>
            </div>
        </div>
    </div>
</div>

