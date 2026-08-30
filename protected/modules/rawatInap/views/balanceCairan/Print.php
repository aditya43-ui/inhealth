<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }

    p {
        text-align: justify;
    }

    .tab_custom th, .tab_custom td {
        border: 1px solid black;
        padding: 5px;
    }

    .text-center{
        text-align: center !important;
    }
    .padding10 {
        padding: 10px;
    }
    .padding5 {
        padding: 5px;
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
    .bordertopnoneclass {
        border-top: none !important;
    }

    .bordernoneclass {
        border: none !important;
    }
</style>
<?php
$modelAll = BalancecairanT::model()->findAllByAttributes(array('pasienadmisi_id'=>$modAdmisi->pasienadmisi_id),array('condition'=>"tanggal_pencatatan::date = '".MyFormatter::formatDateTimeForDb($model->tanggal_pencatatan)."'"));
$rwcaramasuk = array();
$rwcarakeluar = array();
$rwOksigen = array();
$rwOksigenKet = "";
$rwOksigenSatuan = "";
$rwDiet = array();
$rwDietKet = "";
$rwDietSatuan = "";
$rowProgramInfus = array();
$modPerhitunganBalance = PerhitunganbalancecairanT::model()->findByAttributes(array('pasienadmisi_id'=>$modAdmisi->pasienadmisi_id),array('condition'=>"balancecairan_tanggal::date = '".MyFormatter::formatDateTimeForDb($model->tanggal_pencatatan)."'"));
$keterangan = "";

if(empty($modPerhitunganBalance)){
  $modPerhitunganBalance = new PerhitunganbalancecairanT();
}



if(!empty($modelAll)){
  $i=0;
  foreach($modelAll as $dataBalance){
    $caramasuk = BalancecairanmasukT::model()->findAllByAttributes(array('balancecairan_id'=>$dataBalance->balancecairan_id));
    
    if(!empty($dataBalance->tindakan_pasien)){
      if($i > 0){
        $keterangan .= "<br/>"; 
      }
      $keterangan .= "- ". $dataBalance->tindakan_pasien; 
      $i++;
    }
   
    if(!empty($caramasuk)){
      $look_caramasuk = LookupM::model()->findAllByAttributes(array('lookup_type'=>'cairanmasuk'));
      
        if(!empty($look_caramasuk)){
          foreach($look_caramasuk as $look){
            $jumlahP = 0;
          $jumlahS = 0;
          $jumlahM = 0;
          $jumlah = 0;
            foreach($caramasuk as $dataCaramasuk){
              if($dataCaramasuk->waktu_pemberian == 'Pagi'){
                $jumlahP += $dataCaramasuk->jumlah;
              }else if($dataCaramasuk->waktu_pemberian == 'Siang'){
                $jumlahS += $dataCaramasuk->jumlah;
              }else if($dataCaramasuk->waktu_pemberian == 'Malam'){
                $jumlahM += $dataCaramasuk->jumlah;
              }  
               if($look->lookup_value == $dataCaramasuk->nama_cairan) {
                $rwcaramasuk[$dataCaramasuk->nama_cairan] = array(
                    'p'=>$jumlahP,
                    's'=>$jumlahS,
                    'm'=>$jumlahM,
                    'jumlah'=>($jumlahP + $jumlahS + $jumlahM),
                    'satuan'=>$dataCaramasuk->satuan_jumlah,
                    'statuspenggunaan'=>$dataCaramasuk->statuspenggunaan,
                    'keterangan'=>$dataCaramasuk->keterangan,
                    'waktu_pemasangan'=>(!empty($dataCaramasuk->waktu_pemasangan)? MyFormatter::formatDateTimeForUser($dataCaramasuk->waktu_pemasangan):"")
                );
               }
            }
          }
        }
      
    }

    $carakeluar = BalancecairankeluarT::model()->findAllByAttributes(array('balancecairan_id'=>$dataBalance->balancecairan_id));
    
    if(!empty($carakeluar)){
      $look_carakeluar = LookupM::model()->findAllByAttributes(array('lookup_type'=>'cairankeluar'));
      
        if(!empty($look_carakeluar)){
          foreach($look_carakeluar as $look){
            $jumlahP = 0;
            $jumlahS = 0;
            $jumlahM = 0;
            $jumlah = 0;

            foreach($carakeluar as $dataCarakeluar){
              if($dataCarakeluar->waktu_pemberian == 'Pagi'){
                $jumlahP += $dataCarakeluar->jumlah;
              }else if($dataCarakeluar->waktu_pemberian == 'Siang'){
                $jumlahS += $dataCarakeluar->jumlah;
              }else if($dataCarakeluar->waktu_pemberian == 'Malam'){
                $jumlahM += $dataCarakeluar->jumlah;
              }  
               if($look->lookup_value == $dataCarakeluar->nama_cairan) {
                $rwcarakeluar[$dataCarakeluar->nama_cairan] = array(
                    'p'=>$jumlahP,
                    's'=>$jumlahS,
                    'm'=>$jumlahM,
                    'jumlah'=>($jumlahP + $jumlahS + $jumlahM),
                    'satuan'=>$dataCarakeluar->satuan_jumlah,
                    'statuspenggunaan'=>$dataCarakeluar->statuspenggunaan,
                    'keterangan'=>$dataCarakeluar->keterangan,
                    'waktu_pemasangan'=>(!empty($dataCarakeluar->waktu_pemasangan)? MyFormatter::formatDateTimeForUser($dataCarakeluar->waktu_pemasangan):"")
                );
               }
            }
          }
        }
      
    }

    $Oksigen = BalancecairanoksigenT::model()->findAllByAttributes(array('balancecairan_id'=>$dataBalance->balancecairan_id));
      if(!empty($Oksigen)){

        foreach($Oksigen as $i=> $crkI){
          $jml = 0;

          if($i > 0){
            $rwOksigenKet .= ", ";
          }
          $rwOksigenKet .= $crkI->list_oksigen;

          foreach($Oksigen as $j=> $crkJ){
              if($crkI->waktu_pemberian == $crkJ->waktu_pemberian){
                if(!empty($crkI->satuan_jumlah)){
                  $rwOksigenSatuan = $crkI->satuan_jumlah;
                }
                $jml += $crkJ->jumlah;
                $rwOksigen[$crkJ->waktu_pemberian] = $jml;

              }
          }
        }
      }

      $Diet = BalancecairandietT::model()->findAllByAttributes(array('balancecairan_id'=>$dataBalance->balancecairan_id));

      if(!empty($Diet) > 0){

        foreach($Diet as $i=> $crkI){
          
          $jml = 0;

          if($i > 0){
            $rwDietKet .= ", ";
          }
          $rwDietKet .= $crkI->keterangan;

          foreach($Diet as $j=> $crkJ){
              if($crkI->waktu_pemberian == $crkJ->waktu_pemberian){
                if(!empty($crkI->satuan_jumlah)){
                  $rwDietSatuan = $crkI->satuan_jumlah;
                }
                $jml += $crkJ->jumlah;
                $rwDiet[$crkJ->waktu_pemberian] = $jml;

              }
          }
        }
      }

      $programinfus = PrograminfusT::model()->findAllByAttributes(array('balancecairan_id'=>$dataBalance->balancecairan_id));   
      
      if(!empty($programinfus)){
        foreach ($programinfus as $dataInfus){
          $rowProgramInfus[] = array('nama_program'=>$dataInfus->nama_program, 
            'waktu'=>(!empty($dataInfus->waktu)?MyFormatter::formatDateTimeForUser($dataInfus->waktu):""),
            'jenis'=>$dataInfus->jenis,
            'jumlah'=>$dataInfus->jumlah,
            'tetes'=>$dataInfus->tetes,
            'keterangan'=>$dataInfus->keterangan
          );
        }
      }
  }
}
?>

<div style="text-align: right; padding: 5px; font-weight: bold">FRM/09/RSBM</div> 
<?php echo $this->renderPartial($this->path_view . '_headerPrint', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model)); ?>
<table width="100%">
  <tr>
    <td class="borderclass padding5 bordertopnoneclass">Tanggal Monitoring : <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_pencatatan); ?></td>
  </tr>
  <tr>
    <td class="borderclass padding5">TANDA VITAL</td>
  </tr>
</table>
<table width="100%" class="tab_custom">
  <thead>
    <tr>
      <th class="text-center bordertopnoneclass" width="30px">No.</th>
      <th class="text-center bordertopnoneclass" width="150px">Waktu Tindakan</th>
      <th class="text-center bordertopnoneclass" width="150px">Temperatur &#176; C</th>
      <th class="text-center bordertopnoneclass" width="150px">Tekanan Darah <br/>(mmHg)</th>
      <th class="text-center bordertopnoneclass" width="150px">Nadi/ Pulse <br/>(x/menit)</th>
      <th class="text-center bordertopnoneclass" width="150px">Pernapasan <br/>(x/menit)</th>
      <th class="text-center bordertopnoneclass">Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $no = 0; 
      $grafikTandavital = GrafiktandavitalT::model()->findAllByAttributes(array('pasienadmisi_id'=>$modAdmisi->pasienadmisi_id,'tgl_monitoring'=>$model->tanggal_pencatatan));

      if(!empty($grafikTandavital)){
        foreach($grafikTandavital as $dataTandaVital){
          $no += 1;
          ?>
            <tr>
              <td class="text-center"> <?php echo $no; ?></td>
              <td> <?php echo $dataTandaVital->jam_monitoring; ?></td>
              <td> <?php echo $dataTandaVital->suhu; ?></td>
              <td> <?php echo $dataTandaVital->td_systolic .'/ '.$dataTandaVital->td_dyastolic; ?></td>
              <td> <?php echo $dataTandaVital->nadi; ?></td>
              <td> <?php echo $dataTandaVital->pernapasan; ?></td>
              <td> <?php echo $dataTandaVital->keterangan; ?></td>
            </tr>
          <?php 
        }
      }else{
        echo '<tr><td colspan="7">Data Tidak Ditemukan</td></tr>';
      }
    ?>
  </tbody>
</table>
<br/>
<table width="100%" class="tab_custom">
  <tr>
    <td class="text-center" colspan="2">CAIRAN MASUK</td>
    <td class="text-center" width="100px">P</td>
    <td class="text-center" width="100px">S</td>
    <td class="text-center" width="100px">M</td>
    <td class="text-center" width="100px">Jumlah</td>
    <td class="text-center">Keterangan</td>
  </tr>
  <?php 
    $noUrMasuk = 0;
    $look_caramasuk = LookupM::model()->findAllByAttributes(array('lookup_type'=>'cairanmasuk'),array('order'=>'lookup_urutan asc'));
      
    if(!empty($look_caramasuk)){
      foreach($look_caramasuk as $look){
        $noUrMasuk += 1;
          ?>
          <tr>
              <td width="40px" class="text-center"> <?php echo $noUrMasuk; ?></td>
              <td  width="200px"> <?php echo $look->lookup_value; ?></td>
              <td> <?php echo (!empty($rwcaramasuk[$look->lookup_value]) ? $rwcaramasuk[$look->lookup_value]['p'] .' '.$rwcaramasuk[$look->lookup_value]['satuan']:""); ?></td>
              <td> <?php echo (!empty($rwcaramasuk[$look->lookup_value]) ? $rwcaramasuk[$look->lookup_value]['s'].' '.$rwcaramasuk[$look->lookup_value]['satuan']:""); ?></td>
              <td> <?php echo (!empty($rwcaramasuk[$look->lookup_value]) ? $rwcaramasuk[$look->lookup_value]['m'].' '.$rwcaramasuk[$look->lookup_value]['satuan']:""); ?></td>
              <td> <?php echo (!empty($rwcaramasuk[$look->lookup_value]) ? $rwcaramasuk[$look->lookup_value]['jumlah'].' '.$rwcaramasuk[$look->lookup_value]['satuan']:""); ?></td>
              <td>
                 <table width="100%" cellspacing="0" cellpadding="0">
                   <tr>
                     <td width="50%" class="bordernoneclass">
                       Pasang 
                     </td>
                     <td class="bordernoneclass">
                       Lepas
                     </td>
                   </tr>
                   <tr>
                     <td class="bordernoneclass">
                       Pukul: <?php echo ((!empty($rwcaramasuk[$look->lookup_value]) && $rwcaramasuk[$look->lookup_value]['statuspenggunaan'] == true && $rwcaramasuk[$look->lookup_value]['keterangan'] == 'Pasang') ? $rwcaramasuk[$look->lookup_value]['waktu_pemasangan'] : "") ?>
                     </td>
                     <td class="bordernoneclass">
                     Pukul: <?php echo ((!empty($rwcaramasuk[$look->lookup_value]) && $rwcaramasuk[$look->lookup_value]['statuspenggunaan'] == true && $rwcaramasuk[$look->lookup_value]['keterangan'] == 'Lepas') ? $rwcaramasuk[$look->lookup_value]['waktu_pemasangan'] : "") ?>
                     </td>
                   </tr>
                 </table>
              </td>
            </tr>
          <?php 
      }
    }

  ?>
  <tr>
    <td class="text-center" colspan="2">CAIRAN KELUAR</td>
    <td class="text-center" width="100px">P</td>
    <td class="text-center" width="100px">S</td>
    <td class="text-center" width="100px">M</td>
    <td class="text-center" width="100px">Jumlah</td>
    <td class="text-center">Keterangan</td>
  </tr>
  <?php 
    $noUrKeluar = 0;
    $look_carakeluar = LookupM::model()->findAllByAttributes(array('lookup_type'=>'cairankeluar'),array('order'=>'lookup_urutan asc'));
      
    if(!empty($look_carakeluar)){
      foreach($look_carakeluar as $look){
        $noUrKeluar += 1;
          ?>
          <tr>
              <td width="40px" class="text-center"> <?php echo $noUrKeluar; ?></td>
              <td  width="200px"> <?php echo $look->lookup_value; ?></td>
              <td> <?php echo (!empty($rwcarakeluar[$look->lookup_value]) ? $rwcarakeluar[$look->lookup_value]['p'] .' '.$rwcarakeluar[$look->lookup_value]['satuan']:""); ?></td>
              <td> <?php echo (!empty($rwcarakeluar[$look->lookup_value]) ? $rwcarakeluar[$look->lookup_value]['s'].' '.$rwcarakeluar[$look->lookup_value]['satuan']:""); ?></td>
              <td> <?php echo (!empty($rwcarakeluar[$look->lookup_value]) ? $rwcarakeluar[$look->lookup_value]['m'].' '.$rwcarakeluar[$look->lookup_value]['satuan']:""); ?></td>
              <td> <?php echo (!empty($rwcarakeluar[$look->lookup_value]) ? $rwcarakeluar[$look->lookup_value]['jumlah'].' '.$rwcarakeluar[$look->lookup_value]['satuan']:""); ?></td>
              <td>
                <?php
                  if($look->lookup_value == 'IWL'){
                    echo '';
                  }else if($look->lookup_value == 'Muntah' || $look->lookup_value == 'Defekasi'){
                    echo (!empty($rwcarakeluar[$look->lookup_value]) ? $rwcarakeluar[$look->lookup_value]['keterangan']:"");
                  }else{
                    ?>
                      <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" class="bordernoneclass">
                            Pasang 
                          </td>
                          <td class="bordernoneclass">
                            Lepas
                          </td>
                        </tr>
                        <tr>
                          <td class="bordernoneclass">
                            Pukul: <?php echo ((!empty($rwcarakeluar[$look->lookup_value]) && $rwcarakeluar[$look->lookup_value]['statuspenggunaan'] == true && $rwcarakeluar[$look->lookup_value]['keterangan'] == 'Pasang') ? $rwcarakeluar[$look->lookup_value]['waktu_pemasangan'] : "") ?>
                          </td>
                          <td class="bordernoneclass">
                          Pukul: <?php echo ((!empty($rwcarakeluar[$look->lookup_value]) && $rwcarakeluar[$look->lookup_value]['statuspenggunaan'] == true && $rwcarakeluar[$look->lookup_value]['keterangan'] == 'Lepas') ? $rwcarakeluar[$look->lookup_value]['waktu_pemasangan'] : "") ?>
                          </td>
                        </tr>
                      </table>
                    <?php
                  }
                ?>
                 
              </td>
            </tr>
          <?php 
      }
    }
  
  ?>
  <tr>
    <td class="text-center padding5 borderclass bordertopnoneclass" colspan="2">OKSIGEN</td>
    <td class="padding5 borderclass"><?php echo (isset($rwOksigen['Pagi'])?$rwOksigen['Pagi'].' '.$rwOksigenSatuan:0); ?></td>
    <td class="padding5 borderclass"><?php echo (isset($rwOksigen['Siang'])?$rwOksigen['Siang'].' '.$rwOksigenSatuan:0); ?></td>
    <td class="padding5 borderclass"><?php echo (isset($rwOksigen['Malam'])?$rwOksigen['Malam'].' '.$rwOksigenSatuan:0); ?></td>
    <td class="padding5 borderclass"><?php echo (isset($rwOksigen['Pagi'])?$rwOksigen['Pagi']:0) + (isset($rwOksigen['Siang'])?$rwOksigen['Siang']:0) + (isset($rwOksigen['Malam'])?$rwOksigen['Malam']:0) .' '.$rwOksigenSatuan; ?></td>
    <td class="padding5 borderclass bordertopnoneclass"><?php echo $rwOksigenKet; ?></td>
  </tr>
  <tr>
    <td class="text-center padding5 borderclass bordertopnoneclass" colspan="2">DIET</td>
    <td class="padding5 borderclass"><?php echo (isset($rwDiet['Pagi'])?$rwDiet['Pagi'] .' '.$rwDietSatuan:0); ?></td>
    <td class="padding5 borderclass"><?php echo (isset($rwDiet['Siang'])?$rwDiet['Siang'] .' '.$rwDietSatuan:0); ?></td>
    <td class="padding5 borderclass"><?php echo (isset($rwDiet['Malam'])?$rwDiet['Malam'] .' '.$rwDietSatuan:0); ?></td>
    <td class="padding5 borderclass"><?php echo (isset($rwDiet['Pagi'])?$rwDiet['Pagi']:0) + (isset($rwDiet['Siang'])?$rwDiet['Siang']:0) + (isset($rwDiet['Malam'])?$rwDiet['Malam']:0) .' '.$rwDietSatuan; ?></td>
    <td class="padding5 borderclass bordertopnoneclass"><?php echo $rwDietKet; ?></td>
  </tr>
</table>
<br/>
<table width="100%">
  <tr>
    <td class="borderclass padding5">BALANCE CAIRAN</td>
  </tr>
  <tr>
    <td class="borderclass padding5">
    <table width="100%">
        <tr>
          <td width="50%">
            <table width="100%">
              <tr>
                <td width="120px">Tanggal & Jam Perhitungan</td>
                <td>
                  : <?php echo (!empty($modPerhitunganBalance->balancecairan_tanggal)? MyFormatter::formatDateTimeForUser($modPerhitunganBalance->balancecairan_tanggal):""); ?>
                </td>
              </tr>
              <tr>
                <td>Petugas Pecatat</td>
                <td>
                  : <?php echo (!empty($modPerhitunganBalance->petugaspengisi)? $modPerhitunganBalance->petugaspengisi->namaLengkap:""); ?>
                </td>
              </tr>
              <tr>
                <td>Total Cairan Masuk</td>
                <td>
                  : <?php echo $modPerhitunganBalance->totalcairanmasuk; ?> cc
                </td>
              </tr>
              <tr>
                <td>Total Cairan Keluar</td>
                <td>
                  : <?php echo $modPerhitunganBalance->totalcairankeluar; ?> cc
                </td>
              </tr>
              <tr>
                <td>Total IWL</td>
                <td>
                  : <?php echo $modPerhitunganBalance->totaliwl; ?> cc
                </td>
              </tr>
            </table>
          </td>
          <td valign="top">
          <table width="100%">
              <tr>
                <td width="120px">Balance Cairan Sekarang</td>
                <td>
                  : +<?php echo $modPerhitunganBalance->balancecairan_sekarang; ?> cc
                </td>
              </tr>
              <tr>
                <td>Balance Cairan Sebelumnya</td>
                <td>
                  : -<?php echo $modPerhitunganBalance->balancecairan_sebelumnya; ?> cc
                </td>
              </tr>
              <tr>
                <td>Balance Cairan Komulatif</td>
                <td>
                  : +<?php echo $modPerhitunganBalance->balancecairan_komulatif; ?> cc
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br/>
<table width="100%" class="tab_custom">
  <thead>
    <tr>
      <th class="text-center" width="200px">PROGRAM INFUS</th>
      <th class="text-center" width="100px">Pukul</th>
      <th class="text-center" width="100px">Jenis</th>
      <th class="text-center" width="100px">Jumlah</th>
      <th class="text-center" width="100px">Tetes</th>
      <th class="text-center">Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      if(!empty($rowProgramInfus)){
        foreach($rowProgramInfus as $dataInfus){
          $no += 1;
          ?>
            <tr>
              <td> <?php echo $dataInfus['nama_program']; ?></td>
              <td> <?php echo $dataInfus['waktu']; ?></td>
              <td> <?php echo $dataInfus['jenis']; ?></td>
              <td> <?php echo $dataInfus['jumlah']; ?></td>
              <td> <?php echo $dataInfus['tetes']; ?></td>
              <td> <?php echo $dataInfus['keterangan']; ?></td>
            </tr>
          <?php 
        }
      }else{
        echo '<tr><td colspan="6">Data Tidak Ditemukan</td></tr>';
      }
    ?>
  </tbody>
</table>
<br/>
<table width="100%">
  <tr>
    <td class="borderclass padding5">Tindakan/ Pemeriksaan</td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <?php echo $keterangan; ?>
    </td>
  </tr>
</table>