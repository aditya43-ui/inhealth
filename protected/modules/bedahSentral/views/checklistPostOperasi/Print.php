<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

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
    .bordernonetopclass {
        border-top: none !important;
    }
    .bordernonerightclass {
        border-right: none !important;
    }
    .bordernoneleftclass {
        border-left: none !important;
    }

    .padding5{
        padding: 5px;
    }

    header, footer {
        height: 30px;
    }

    .tablefont td{
        color: black;
        padding: 5px;
    }

    .fa{
        font-size: 12pt;
    }
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }

    .textbold {
        font-weight: bold;
    }
    .textcenter {
        text-align: center;
    }

    .textright {
        text-align: right;
    }

    .tableBorder th, .tableBorder td {
        border:1px solid #000;
        padding: 10px;
    }

    .headertext{
      padding-bottom: 10px !important;
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<div style="padding: 5px;">
  <div class="textright textbold headertext">FRM/22/RSBM</div>
  <?php echo $this->renderPartial($this->path_view."_headerPrint", array(
       'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran, 'model'=>$model
   ), true); ?>

  <table width="100%">
    <tr>
      <td colspan="2" class="padding5 borderclass bordernonetopclass">
          Ruangan : <?php echo $model->ruanganasal->ruangan_nama; ?>
      </td>
    </tr>
    <tr>
      <td width="50%" class="padding5 borderclass bordernonetopclass">
          Diagnosa Utama : <?php echo $model->diagnosa_utama; ?>
      </td>
      <td width="50%" class="padding5 borderclass bordernonetopclass">
          Diagnosa Tambahan : <?php echo $model->diagnosa_tambahan; ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass textcenter">
          POST OPERASI
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
          <table class="tableBorder" width="100%">
            <thead>
              <tr>
                <th rowspan="2" class="textcenter" width="50px">No</th>
                <th rowspan="2" class="textcenter" colspan="3">Hal-hal yang dioperkan oleh petugas ruangan</th>
                <th colspan="2" class="textcenter">Perawat Ruangan</th>
                <th colspan="2" class="textcenter">Perawat Kamar Operasi</th>
                <th rowspan="2" class="textcenter">Ket.</th>
              </tr>
              <tr>
                <th class="textcenter" width="80px">Ya</th>
                <th class="textcenter" width="80px">Tidak</th>
                <th class="textcenter" width="80px">Ya</th>
                <th class="textcenter" width="80px">Tidak</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $dataLevel = array();
                $modPrepostOperasi = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>null,'jenischecklist'=>'Post Operasi'),array('order'=>'urutan ASC'));

                if(count($modPrepostOperasi) > 0){
                  $noUrut = 0;
                  foreach($modPrepostOperasi as $dataParentOp){
                    $noUrut += 1;
                    $rowspan = 0;

                    $modPrepostOperasiChild = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$dataParentOp->prepostoperasidesk_id,'jenischecklist'=>'Post Operasi'),array('order'=>'urutan ASC'));
                    if(count($modPrepostOperasiChild)>0){
                      foreach($modPrepostOperasiChild as $j => $dataChild){
                        $rowspan2 = 0;
                        $colspan2 = 2;
                        
                        $modPrepostOperasiChildStep3 = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$dataChild->prepostoperasidesk_id,'jenischecklist'=>'Post Operasi'),array('order'=>'urutan ASC'));
                        
                        if(count($modPrepostOperasiChildStep3)>0){
                          $colspan = 0;
                          $colspan2 = 0;
                          foreach($modPrepostOperasiChildStep3 as $j => $dataChild3){
                            $rowspan += 1;
                            $rowspan2 += 1;
                          } 
                        }else{
                          $rowspan += 1;
                          $colspan = 0;

                        }
                        $dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['colspan'] =  $colspan2;
                        $dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['rowspan'] =  $rowspan2;
                      } 
                    }else{
                      $colspan = 3;
                    }
                    
                    $dataLevel[$dataParentOp->prepostoperasidesk_id]['nama'] =  $dataParentOp->nama_prepostoperasidesk;
                    $dataLevel[$dataParentOp->prepostoperasidesk_id]['rowspan'] =  $rowspan;
                    $dataLevel[$dataParentOp->prepostoperasidesk_id]['colspan'] =  $colspan;

                  }
                }
                
                  $colspanparent = array();
                  if(count($modPrepostOperasi) > 0){
                    $noUrut = 0;
                    foreach($modPrepostOperasi as $dataParentOp){
                      $modPrepostOperasiChild = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$dataParentOp->prepostoperasidesk_id,'jenischecklist'=>'Post Operasi'),array('order'=>'urutan ASC'));
                      $noUrut += 1;

                      $status_pengisian_parent_ruangan = "";
                      $status_pengisian_parent_op = "";
                      $keterangan_parent_ru = "";
                      $keterangan_parent_op = "";

                      if(count($modDetail) > 0){
                        foreach ($modDetail as $oriDet_parent) {
                          if($oriDet_parent->prepostoperasidesk_id == $dataParentOp->prepostoperasidesk_id){
                            if(!empty($oriDet_parent->checklist_diisioleh)){
                              if($oriDet_parent->checklist_diisioleh == 'petugasruangan_asal'){
                                  $status_pengisian_parent_ruangan = $oriDet->status_pengisian;
                                  $keterangan_parent_ru =$oriDet_parent->keterangan;
                              }else if($oriDet_parent->checklist_diisioleh == 'petugasruangan_tujuan'){
                                $status_pengisian_parent_op = $oriDet->status_pengisian;
                                $keterangan_parent_op =$oriDet_parent->keterangan;
                              }
                            }
                          }
                        }
                      }

                      ?>
                      <tr>
                        <td valign="top" rowspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id]['rowspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id]['rowspan']: ""); ?>"><?php echo $noUrut; ?></td>
                        <td colspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id]['colspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id]['colspan']: ""); ?>"  valign="top" rowspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id]['rowspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id]['rowspan']: ""); ?>"><?php echo $dataParentOp->nama_prepostoperasidesk; ?></td>

                        <?php
                          if(count($modPrepostOperasiChild)>0){

                            foreach($modPrepostOperasiChild as $j => $dataChild){
                              $status_pengisian_ruangan = "";
                              $status_pengisian_op = "";
                              $keterangan_ru = "";
                              $keterangan_op = "";

                              if(count($modDetail) > 0){
                                foreach ($modDetail as  $oriDet) {
                                  if($oriDet->prepostoperasidesk_id == $dataChild->prepostoperasidesk_id){
                                    if(!empty($oriDet->checklist_diisioleh)){
                                      if($oriDet->checklist_diisioleh == 'petugasruangan_asal'){
                                          $status_pengisian_ruangan = $oriDet->status_pengisian;
                                          $keterangan_ru =$oriDet->keterangan;
                                      }else if($oriDet->checklist_diisioleh == 'petugasruangan_tujuan'){
                                        $status_pengisian_op = $oriDet->status_pengisian;
                                        $keterangan_op =$oriDet->keterangan;
                                      }
                                    }
                                  }
                                }
                              }
                              $modPrepostOperasiChildStep3 = PrepostoperasideskM::model()->findAllByAttributes(array('status'=>true,'parent_id'=>$dataChild->prepostoperasidesk_id,'jenischecklist'=>'Post Operasi'),array('order'=>'urutan ASC'));
                              
                              // echo '== '.$dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['colspan'];
                              ?>
                              <?php if($j == 0){?>
                                <td colspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['colspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['colspan']: ""); ?>" rowspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['rowspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['rowspan']: ""); ?>"><?php echo $dataChild->nama_prepostoperasidesk; ?></td>
                                <?php
                                if (count($modPrepostOperasiChildStep3) > 0){
                                  foreach($modPrepostOperasiChildStep3 as $k => $dataChildStep3){
                                    $status_pengisian_ruanganstep3 = "";
                                    $status_pengisian_opstep3 = "";
                                    $keteranganstep3_ru = "";
                                    $keteranganstep3_op = "";

                                    if(count($modDetail) > 0){
                                      foreach ($modDetail as  $oriDet) {
                                        if($oriDet->prepostoperasidesk_id == $dataChildStep3->prepostoperasidesk_id){
                                          if(!empty($oriDet->checklist_diisioleh)){
                                            if($oriDet->checklist_diisioleh == 'petugasruangan_asal'){
                                                $status_pengisian_ruanganstep3 = $oriDet->status_pengisian;
                                                $keteranganstep3_ru =$oriDet->keterangan;
                                            }else if($oriDet->checklist_diisioleh == 'petugasruangan_tujuan'){
                                              $status_pengisian_opstep3 = $oriDet->status_pengisian;
                                              $keteranganstep3_op =$oriDet->keterangan;
                                            }
                                          }
                                        }
                                      }
                                    }

                                    if($k == 0){ ?>
                                      <td><?php echo $dataChildStep3->nama_prepostoperasidesk; ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td valign="top"><?php echo "Perawatan Ruangan: ".$keteranganstep3_ru.'<br/> Perawatan Kamar Operasi : '.$keteranganstep3_op; ?></td>
                                  <?php }else{ ?>
                                      <tr>
                                        <td valign="top"><?php echo $dataChildStep3->nama_prepostoperasidesk; ?></td>
                                        <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                        <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                        <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                        <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                        <td valign="top"><?php echo "Perawatan Ruangan: ".$keteranganstep3_ru.'<br/> Perawatan Kamar Operasi : '.$keteranganstep3_op; ?></td>
                                      </tr>
                                    <?php
                                    }
                                  }
                                }else{
                                  ?>
                                  <td class="textcenter"><?php echo ((!empty($status_pengisian_ruangan) && $status_pengisian_ruangan == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                  <td class="textcenter"><?php echo ((!empty($status_pengisian_ruangan) && $status_pengisian_ruangan == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                  <td class="textcenter"><?php echo ((!empty($status_pengisian_op) && $status_pengisian_op == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                  <td class="textcenter"><?php echo ((!empty($status_pengisian_op) && $status_pengisian_op == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                  <td valign="top"><?php echo "Perawatan Ruangan: ".$keterangan_ru.'<br/> Perawatan Kamar Operasi : '.$keterangan_op; ?></td>
                                </tr>
                                  <?php
                                }
                                 ?>

                            <?php }else{ ?>
                                <tr>
                                    <td colspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['colspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['colspan']: ""); ?>" rowspan="<?php echo (!empty($dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['rowspan']) ? $dataLevel[$dataParentOp->prepostoperasidesk_id][$dataChild->prepostoperasidesk_id]['rowspan']: ""); ?>"><?php echo $dataChild->nama_prepostoperasidesk; ?></td>
                                    <?php
                                    if (count($modPrepostOperasiChildStep3) > 0){
                                      foreach($modPrepostOperasiChildStep3 as $k => $dataChildStep3){
                                        $status_pengisian_ruanganstep3 = "";
                                        $status_pengisian_opstep3 = "";
                                        $keteranganstep3_ru = "";
                                        $keteranganstep3_op = "";

                                        if(count($modDetail) > 0){
                                          foreach ($modDetail as  $oriDet) {
                                            if($oriDet->prepostoperasidesk_id == $dataChildStep3->prepostoperasidesk_id){
                                              if(!empty($oriDet->checklist_diisioleh)){
                                                if($oriDet->checklist_diisioleh == 'petugasruangan_asal'){
                                                    $status_pengisian_ruanganstep3 = $oriDet->status_pengisian;
                                                    $keteranganstep3_ru =$oriDet->keterangan;
                                                }else if($oriDet->checklist_diisioleh == 'petugasruangan_tujuan'){
                                                  $status_pengisian_opstep3 = $oriDet->status_pengisian;
                                                  $keteranganstep3_op =$oriDet->keterangan;
                                                }
                                              }
                                            }
                                          }
                                        }

                                        if($k == 0){ ?>
                                          <td><?php echo $dataChildStep3->nama_prepostoperasidesk; ?></td>
                                          <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                          <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                          <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                          <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                          <td valign="top"><?php echo "Perawatan Ruangan: ".$keteranganstep3_ru.'<br/> Perawatan Kamar Operasi : '.$keteranganstep3_op; ?></td>
                                      <?php }else{ ?>
                                          <tr>
                                            <td valign="top"><?php echo $dataChildStep3->nama_prepostoperasidesk; ?></td>
                                            <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                            <td class="textcenter"><?php echo ((!empty($status_pengisian_ruanganstep3) && $status_pengisian_ruanganstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                            <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                            <td class="textcenter"><?php echo ((!empty($status_pengisian_opstep3) && $status_pengisian_opstep3 == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                            <td valign="top"><?php echo "Perawatan Ruangan: ".$keteranganstep3_ru.'<br/> Perawatan Kamar Operasi : '.$keteranganstep3_op; ?></td>
                                          </tr>
                                        <?php
                                        }
                                      }
                                    }else{
                                      ?>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_ruangan) && $status_pengisian_ruangan == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_ruangan) && $status_pengisian_ruangan == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_op) && $status_pengisian_op == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td class="textcenter"><?php echo ((!empty($status_pengisian_op) && $status_pengisian_op == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                      <td valign="top"><?php echo "Perawatan Ruangan: ".$keterangan_ru.'<br/> Perawatan Kamar Operasi : '.$keterangan_op; ?></td>
                                    </tr>
                                      <?php
                                    }
                                     ?>
                                </tr>
                            <?php
                                }
                            }
                          }else{
                            ?>
                                <td valign="top" class="textcenter"><?php echo ((!empty($status_pengisian_parent_ruangan) && $status_pengisian_parent_ruangan == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                <td valign="top" class="textcenter"><?php echo ((!empty($status_pengisian_parent_ruangan) && $status_pengisian_parent_ruangan == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                <td valign="top" class="textcenter"><?php echo ((!empty($status_pengisian_parent_op) && $status_pengisian_parent_op == 'Ya') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                <td valign="top" class="textcenter"><?php echo ((!empty($status_pengisian_parent_op) && $status_pengisian_parent_op == 'Tidak') ? "<i class='fa fa-check'></i>": ""); ?></td>
                                <td valign="top"><?php echo "Perawatan Ruangan: ".$keterangan_parent_ru.'<br/> Perawatan Kamar Operasi : '.$keterangan_parent_op; ?></td>
                            </tr>
                            <?php
                          }
                    }
                  }
               ?>

              
            </tbody>
          </table>
      </td>
    </tr>
    <tr>
      <td width="50%" class="padding5 borderclass bordernonetopclass bordernonerightclass">
          <center>
            Petugas Ruangan<br/>
            <?php echo $model->ruanganasal->ruangan_nama; ?>
            <br/><br/><br/><br/>

            <?php echo $model->petugasPengisi->namaLengkap; ?><br/>
            <?php echo MyFormatter::formatDateTimeForUser($model->tanggal_penginputan); ?>
          </center>
      </td>
      <td width="50%" class="padding5 borderclass bordernonetopclass bordernoneleftclass">
        <center>
          Petugas Ruangan<br/>
          <?php echo $model->ruangantujuan->ruangan_nama; ?>
          <br/><br/><br/><br/>

          <?php
          $peg = PegawaiM::model()->findByPk($model->petugaspengisi_ruangantujuan);
          echo (!empty($peg)? $peg->namaLengkap: null); ?><br/>
          <?php echo (!empty($model->tglpengisian_ruangantujuan)? MyFormatter::formatDateTimeForUser($model->tglpengisian_ruangantujuan): ""); ?>
        </center>
      </td>
    </tr>
  </table>

</div>
