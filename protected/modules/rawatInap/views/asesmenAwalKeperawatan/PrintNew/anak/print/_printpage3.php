<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
?>
<table width="100%">
  <tr>
    <td class="borderclass padding5">
      <?php
        $htmlPengkajianRisikoJatuh = "";
        if ($model->jenisresikojatuh == 'dewasa') {
            $htmlPengkajianRisikoJatuh = "Skrinning Resiko Jatuh Dewasa (Morse Falls Scale)";
        } else if ($model->jenisresikojatuh == 'anak') {
            $htmlPengkajianRisikoJatuh = "Skrinning Resiko Jatuh Anak (Humpty Dumpty)";
        } else if ($model->jenisresikojatuh == 'lansia') {
            $htmlPengkajianRisikoJatuh = "Skrinning Resiko Lansia (Sidney Scoring)";
        }
        echo $htmlPengkajianRisikoJatuh;
      ?>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <?php if($model->jenisresikojatuh == 'dewasa'){ ?>
        <table class="tableBorder" style="width: 100%">
          <thead>
              <tr>
                  <th style="width: 10px">No</th>
                  <th>Risiko</th>
                  <th style="width: 250px">Penilaian</th>
                  <th style="width: 50px">Skor</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>1</td>
                  <td>Riwayat Jatuh, Apakah pasien pernah jatuh dalam 3 bulan terakhir</td>
                  <td>
                      <?php echo  $model->riwayatjatuh_penilaian; ?>
                  </td>
                  <td><?php echo $model->riwayatjatuh_skor; ?></td>
              </tr>
               <tr>
                  <td>2</td>
                  <td>Diagnosa Sekunder, Apakah pasien memiliki lebih dari satu penyakit?</td>
                  <td>
                      <?php echo  $model->diagnosismedis_penilaian; ?>
                  </td>
                  <td><?php echo $model->diagnosismedis_skor; ?></td>
              </tr>
               <tr>
                  <td>3</td>
                  <td>Alat Bantu Jalan</td>
                  <td>
                      <?php echo $model->alatbantujalan_penilaian; ?>
                  </td>
                  <td><?php echo $model->alatbantujalan_skor; ?></td>
              </tr>
               <tr>
                  <td>4</td>
                  <td>Terapi Intrevena, Apakah saat ini pasien terpasang infustd</td>
                  <td>
                      <?php echo  $model->memakaiterapiheparin_penilaian; ?>
                  </td>
                  <td><?php echo $model->memakaiterapiheparin_skor; ?></td>
              </tr>
               <tr>
                  <td>5</td>
                  <td>Cara Berjalan/ Berpindah</td>
                  <td>
                      <?php echo  $model->caraberjalan_penilaian; ?>
                  </td>
                  <td><?php echo $model->caraberjalan_skor; ?></td>
              </tr>
               <tr>
                  <td>6</td>
                  <td>Status Mental</td>
                  <td>
                      <?php echo  $model->statusmental_penilaian; ?>
                  </td>
                  <td><?php echo $model->statusmental_skor; ?></td>
              </tr>
              <tr>
                  <td colspan="3">Total Skor</td>
                  <td> <?php echo $model->resikojatuh_skor; ?> </td>
              </tr>
              <tr>
                  <td colspan="2">Pasien termasuk kategori risiko jatuh : </td>
                  <td colspan="2"> <?php echo $model->resikojatuh_keterangan; ?> </td>
              </tr>
          </tbody>
        </table>
      <?php }else if($model->jenisresikojatuh == 'anak'){ ?>
        <table class="tableBorder" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Risiko</th>
                    <th style="width: 250px">Penilaian</th>
                    <th style="width: 50px">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Usia</td>
                    <td>
                        <?php echo  $model->usia_anak; ?>
                    </td>
                    <td><?php echo $model->skor_usia_anak; ?></td>
                </tr>
                 <tr>
                    <td>2</td>
                    <td>Jenis Kelamin</td>
                    <td>
                        <?php echo  $model->jeniskelamin_anak; ?>
                    </td>
                    <td><?php echo $model->skor_jeniskelamin_anak; ?></td>
                </tr>
                 <tr>
                    <td>3</td>
                    <td>Diagnose</td>
                    <td>
                        <?php echo  $model->diagnosa_asessment_anak; ?>
                    </td>
                    <td><?php echo $model->skor_diagnosa_anak; ?></td>
                </tr>
                 <tr>
                    <td>4</td>
                    <td>Gangguan Kognitif</td>
                    <td>
                        <?php echo  $model->gangguan_kognitif_anak; ?>
                    </td>
                    <td><?php echo $model->skor_gangguan_kognitif_anak; ?></td>
                </tr>
                 <tr>
                    <td>5</td>
                    <td>Faktor Lingkungan</td>
                    <td>
                        <?php echo  $model->faktor_lingkungan_anak; ?>
                    </td>
                    <td><?php echo $model->skor_faktor_lingkungan_anak; ?></td>
                </tr>
                 <tr>
                    <td>6</td>
                    <td>Respon Terhadap: Pembedahan, sedasi, anestesi</td>
                    <td>
                        <?php echo  $model->responterhadap_pembedahan_anak; ?>
                    </td>
                    <td><?php echo $model->skor_responterhadap_pembedahan_anak; ?></td>
                </tr>
                 <tr>
                    <td>6</td>
                    <td>Penggunaan Medikamentosa</td>
                    <td>
                        <?php echo  $model->penggunaan_medikamentosa; ?>
                    </td>
                    <td><?php echo $model->skor_medikamentosa_anak; ?></td>
                </tr>
                <tr>
                    <td colspan="3">Total Skor</td>
                    <td> <?php echo $model->jumlah_skor_anak; ?> </td>
                </tr>
                <tr>
                    <td colspan="2">Pasien termasuk kategori risiko jatuh : </td>
                    <td colspan="2"> <?php echo $model->keterangan_resiko_jatuh_anak; ?> </td>
                </tr>
            </tbody>
        </table>
      <?php }else if($model->jenisresikojatuh == 'lansia'){ ?>
        <table class="tableBorder" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th style="width: 200px">Parameter</th>
                    <th>Skrining</th>
                    <th style="width: 80px">Jawaban</th>
                    <th colspan="2" style="width: 50px">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2">1</td>
                    <td rowspan="2">Riwayat jatuh</td>
                    <td>Apakah pasien datang kerumah sakit karena jatuh?</td>
                    <td>
                        <?php echo (($model->resiko_jatuh_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                    <td rowspan="2"><?php echo $model->skor_resiko_jatuh_lansia; ?></td>
                </tr>
                <tr>
                    <td>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan</td>
                    <td>
                        <?php echo  (($model->resiko_jatuh_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                </tr>
                 <tr>
                    <td rowspan="3">2</td>
                    <td rowspan="3">Status Mental</td>
                    <td>Apakah pasien delirium? (tidak membuat keputusan, pola piker tidak terorganisir, gangguan daya ingat)</td>
                    <td>
                        <?php echo (($model->status_mental_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                    <td rowspan="3"><?php echo $model->skor_status_mental_lansia; ?></td>
                </tr>
                 <tr>
                    <td>Apakah pasien disorientasi? (salah menyebut waktu, tempat atau orang)</td>
                    <td>
                        <?php echo (($model->status_mental_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                </tr>
                 <tr>
                    <td>Apakah pasien mengalami agitasi? (ketakutan, kecemasan, gelisah)</td>
                    <td>
                        <?php echo (($model->status_mental_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                </tr>
                 <tr>
                    <td rowspan="3">3</td>
                    <td rowspan="3">Penglihatan</td>
                    <td>Apakah pasien memakai kaca mata?</td>
                    <td>
                        <?php echo (($model->penglihatan_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                    <td rowspan="3"><?php echo $model->skor_penglihatan_lansia; ?></td>
                </tr>
                 <tr>
                    <td>Apakah pasien mengeluhkan penglihatan buram?</td>
                    <td>
                        <?php echo (($model->penglihatan_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Apakah pasien mengalami glaucoma, katarak, degenerasi macula?</td>
                    <td>
                        <?php echo (($model->penglihatan_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Kebiasaan berkemih</td>
                    <td>Apakah terdapat perubahan prilaku berkemih? (frekuensi, urgensi, inkotenensia, nokturia)</td>
                    <td>
                      <?php echo (($model->kebiasaan_berkemih_lansia==true)?"Ya":"Tidak"); ?>
                    </td>
                    <td><?php echo $model->skor_berkemih_lansia; ?></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Transfer (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
                    <td colspan="2">
                        <?php echo  $model->transfer_mobilitas_lansia; ?>
                    </td>
                    <td rowspan="2"><?php echo $model->skor_transfer_mobilitas_lansia; ?></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Mobilitas</td>
                    <td colspan="2">
                        <?php echo  $model->mobilitas_lansia; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Total Skor</td>
                    <td> <?php echo $model->jumlah_skor_lansia; ?> </td>
                </tr>
                <tr>
                    <td colspan="2">Pasien termasuk kategori risiko jatuh : </td>
                    <td colspan="2"> <?php echo $model->keterangan_skor_lansia; ?> </td>
                </tr>
            </tbody>
        </table>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table class="tableBorder" style="width: 100%">
          <thead>
              <tr>
                  <th colspan="4">DOKUMEN KEPERAWATAN</th>
              </tr>
              <tr>
                  <td>MASALAH KEPERAWATAN</td>
                  <td>RENCANA KEPERAWATAN</td>
                  <td>TINDAKAN KEPERAWATAN</td>
                  <td>EVALUASI KEPERAWATAN</td>
              </tr>
          </thead>
          <tbody>
              <?php
              $first = true;
              foreach ($arrMasalahKeperawatan as $item) :
                  ?>
                  <tr>
                      <td>
                          <?php
                          // echo '<pre>';
                          // print_r($item['masalah']);
                          // exit();
                          foreach ($item['masalah'] as $iM=> $masalah) {
                            if($iM > 0){
                              echo '<br/>';
                            }
                            echo '<span class="'.(($masalah['isCheck']==true)?'fa fa-check-square-o':'fa fa-square-o').'"></span> '.(!empty($masalah['keteranganCheck'])? $masalah['keteranganCheck'] : $masalah['masalahkeperawatan_nama']);
                          }
                          ?>
                      </td>
                      <td>
                          <?php
                          foreach ($item['rencana'] as $iR => $rencana) {
                            if($iR > 0){
                              echo '<br/>';
                            }
                            echo '<span class="'.(($rencana['isCheck']==true)?'fa fa-check-square-o':'fa fa-square-o').'"></span> '.(!empty($rencana['keteranganCheck'])? $rencana['keteranganCheck'] : $rencana['rencanakeperawatan_nama']);
                          }
                          ?>
                      </td>
                      <td>
                          <?php
                          foreach ($item['tindakan'] as $iT => $tindakan) {
                            if($iT > 0){
                              echo '<br/>';
                            }
                            echo '<span class="'.(($tindakan['isCheck']==true)?'fa fa-check-square-o':'fa fa-square-o').'"></span> '.(!empty($tindakan['keteranganCheck'])? $tindakan['keteranganCheck'] : $tindakan['tindakankeperawatan_nama']);
                          }
                          ?>
                      </td>
                      <?php
                      if ($first):
                          $first = false;
                          ?>
                          <td rowspan="<?php echo count((array)$arrMasalahKeperawatan); ?>" class="row_soap" valign="top">
                              <b>Subjective</b><br/>
                              <?php echo $modAsesmenpasinIgd->evaluasiaskep_subjektif; ?>
                              <hr/>
                              <b>Objective</b>
                              <?php echo $modAsesmenpasinIgd->evaluasiaskep_objektif; ?>
                              <hr/>
                              <b>Assessment</b>
                              <?php echo $modAsesmenpasinIgd->evaluasiaskep_assessment; ?>
                              <hr/>
                              <b>Planning</b>
                              <?php echo $modAsesmenpasinIgd->evaluasiaskep_planning; ?>
                          </td>
                      <?php endif; ?>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      OBSERVASI TANDA VITAL
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table width="100%">
        <tr>
          <td>
            <center><h3>Grafik Observasi Tanda Vital IGD</h3></center>
            <canvas id="chart_obs">
            </canvas>
            <center><b>Jam Observasi</b></center>
          </td>
        </tr>
        <tr>
          <td>
            <center><h3>Tabel observasi IGD</h3></center>
            <br/>
            <?php
            $modList = new ObservasipasienigdT();
            $modList->unsetAttributes();
            $modList->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $prov = $modList->printSeach();
            $prov->sort->defaultOrder = "pemeriksaanke";
            $prov->sort = false;

            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'observasi-grid',
                'dataProvider' => $prov,
                'template' => "{items}",
                'itemsCssClass' => 'tableBorder',
                'columns' => array(
                    array(
                        'header'=>'Pemeriksaan Ke-',
                        'type'=>'raw',
                        'value'=>'$data->pemeriksaanke',
                    ),
                      array(
                        'header'=>'Petugas Pengkaji',
                        'type'=>'raw',
                        'value'=>'$data->petugaspengkaji->namaLengkap',
                    ),
                      array(
                        'header'=>'Jam Observasi',
                        'type'=>'raw',
                        'value'=>'$data->observasijam',
                    ),
                    array(
                        'header'=>'Tekanan Darah (mmHg)',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return $data->td_systolic."/".$data->td_dyastolic;
                        }
                    ),
                     array(
                        'header'=>'Nadi (x /menit)',
                        'type'=>'raw',
                        'value'=>'$data->detaknadi',
                    ),
                    array(
                        'header'=>'Pernapasan (x /menit)',
                        'type'=>'raw',
                        'value'=>'$data->pernapasan',
                    ),
                    array(
                        'header'=>'Suhu (&#176 C)',
                        'type'=>'raw',
                        'value'=>'$data->suhubadan',
                    ),
                    array(
                        'header'=>'Nyeri',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return $data->score_skalanyeri.":".$data->keteranganskala_nyeri;
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
            ));
            ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      Observasi Komprehensif
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
    <table width="100%">
      <tr>
        <td width="50%" valign='top' class="textcenter borderclass">MASUK/INTAKE</td>
        <td width="50%" valign='top' class="textcenter borderclass">KELUAR/OUTPUT</td>
      </tr>
      <tr>
        <td width="50%" valign='top' class="borderclass">
          <table width="100%" class="tableBorder">
            <thead>
              <tr>
                <th class="textcenter">Tanggal</th>
                <th class="textcenter">Jam</th>
                <th class="textcenter">Jenis Cairan</th>
                <th class="textcenter">No. Botol</th>
                <th class="textcenter">IV</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(count((array)$obvKompherensif) > 0){
                  foreach ($obvKompherensif as $obvKomp) {
                    ?>
                    <tr>
                      <td><?php echo MyFormatter::formatDateTimeForUser($obvKomp->tanggal_pengisian); ?></td>
                      <td><?php echo $obvKomp->jam_pengisian; ?></td>
                      <td><?php echo $obvKomp->jeniscairan; ?></td>
                      <td><?php echo $obvKomp->nobotol; ?></td>
                      <td><?php echo $obvKomp->iv; ?></td>
                    </tr>
                    <?php
                  }
                }
               ?>
            </tbody>
          </table>
        </td>
        <td width="50%" valign='top' class="borderclass">
          <table width="100%" class="tableBorder">
            <thead>
              <tr>
                <th class="textcenter">Oral/NGT</th>
                <th class="textcenter">Drain</th>
                <th class="textcenter">NGT</th>
                <th class="textcenter">Urine</th>
                <th class="textcenter">BAB</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(count((array)$obvKompherensif) > 0){
                  foreach ($obvKompherensif as $obvKompKeluar) {
                    ?>
                    <tr>
                      <td><?php echo $obvKompKeluar->jenispemakaian; ?></td>
                      <td><?php echo $obvKompKeluar->drain; ?></td>
                      <td><?php echo $obvKompKeluar->ngt; ?></td>
                      <td><?php echo $obvKompKeluar->urine; ?></td>
                      <td><?php echo $obvKompKeluar->bab; ?></td>
                    </tr>
                    <?php
                  }
                }
               ?>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      STATUS PASIEN KELUAR IGD
    </td>
  </tr>
  <tr>
    <td class="borderclass padding5">
      <table class="tableBorder" width="100%">
        <thead>
          <tr>
            <th width="200px">Status</th>
            <th width="100px">Tanggal</th>
            <th width="100px">Jam</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>MRS</td>
            <td><?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($modPendaftaran->tgl_pendaftaran)))); ?></td>
            <td><?php echo date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($modPendaftaran->tgl_pendaftaran))); ?></td>
            <td>
              Di Ruangan : <?php echo (isset($modPasienAdmisi)?$modPasienAdmisi->ruangan->ruangan_nama : $modPendaftaran->ruangan->ruangan_nama); ?>
            </td>
          </tr>
          <tr>
            <td>Pulang Sembuh</td>
            <td>
              <?php
                if(!empty($modPasienPulang)){
                  if($modPasienPulang->carakeluar_id = 1 && $modPasienPulang->kondisi_id = 1){
                      echo (!empty($modPasienPulang->tglpasienpulang)? MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang)))): "");
                  }
                }
                ?>
            </td>
            <td><?php
            if(!empty($modPasienPulang)){
              if($modPasienPulang->carakeluar_id = 1 && $modPasienPulang->kondisi_id = 1){
                  echo (!empty($modPasienPulang->tglpasienpulang) ? date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang))) : "");
              }
            }
            ?></td>
            <td>
              <?php
                if(!empty($modPasienPulang)){
                  // if($modPasienPulang->carakeluar_id = 1 && $modPasienPulang->kondisi_id = 1){
                  ?>
                  <span class="<?php echo (($modPasienPulang->iskie==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> KIE
                  <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->isobatpulang==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Obat Pulang
                  <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->isfotorontgen==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Foto Rontgen
                  <br/>
                  <span class="<?php echo (($modPasienPulang->islaboratorium==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Laboratorium
                  <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->iskontrol==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Kontrol Poliklinik
                  <?php
                  // }
                }
                ?>
            </td>
          </tr>
          <tr>
            <td>Pulang Atas Permintaan</td>
            <td>
              <?php
                if(!empty($modPasienPulang)){
                  if($modPasienPulang->carakeluar_id = 8){
                      echo (!empty($modPasienPulang->tglpasienpulang)? MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang)))): "");
                  }
                }
                ?>
            </td>
            <td><?php
            if(!empty($modPasienPulang)){
              if($modPasienPulang->carakeluar_id = 8){
                  echo (!empty($modPasienPulang->tglpasienpulang) ? date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang))) : "");
              }
            }
            ?></td>
            <td>
              <?php
                if(!empty($modPasienPulang)){
                  // if($modPasienPulang->carakeluar_id = 8){
                  ?>
                  <span class="<?php echo (($modPasienPulang->iskieaps==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> KIE
                  <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->ispernyataan_aps==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tandatangan Pernyataan Pulang atas Permintaan Sendiri
                  <?php
                  // }
                }
                ?>
            </td>
          </tr>
          <tr>
            <td>Melarikan Diri</td>
            <td>
              <?php
                if(!empty($modPasienPulang)){
                  if($modPasienPulang->carakeluar_id = 7){
                      echo (!empty($modPasienPulang->tglpasienpulang)? MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang)))): "");
                  }
                }
                ?>
            </td>
            <td><?php
            if(!empty($modPasienPulang)){
              if($modPasienPulang->carakeluar_id = 7){
                  echo (!empty($modPasienPulang->tglpasienpulang) ? date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang))) : "");
              }
            }
            ?></td>
            <td>
              <table width="100%" class="tablefont">
                <tr>
                  <td valign="top" width="150px" style="border: none;">Dinyatakan Meninggal :</td>
                  <td style="border: none;">
                    <?php
                      if(!empty($modPasienPulang)){
                        // if($modPasienPulang->carakeluar_id = 7){
                        ?>
                        <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->islaporsatpam==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lapor Satpam
                        <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->islapormod==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lapor MOD
                        <br/>
                        <span class="<?php echo (($modPasienPulang->islaporsupervisi==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lapor Supervisi
                        <span style="padding-left: 10px" class="<?php echo (($modPasienPulang->islaporhumas==true)?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Lapor Humas
                        <?php
                        // }
                      }
                      ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>Dirujuk</td>
            <td>
              <?php
                if(!empty($modPasienPulang)){
                  if($modPasienPulang->carakeluar_id = 2){
                      echo (!empty($modPasienPulang->tglpasienpulang)? MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang)))): "");
                  }
                }
                ?>
            </td>
            <td><?php
            if(!empty($modPasienPulang)){
              if($modPasienPulang->carakeluar_id = 2){
                  echo (!empty($modPasienPulang->tglpasienpulang) ? date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($modPasienPulang->tglpasienpulang))) : "");
              }
            }
            ?></td>
            <td>
              Ke RS : <?php
              $pasienRujukKeluar = PasiendirujukkeluarT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id));
              echo (isset($pasienRujukKeluar)?$pasienRujukKeluar->rujukankeluar->rujukankeluar_nama : "") ?>
            </td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</table>
<br/>
<table width="100%">
  <tr>
      <td style="width:50%; text-align: left;" colspan="2">

      </td>
      <td style="width:50%; text-align: left;" colspan="2" >
        <center>
            Singaraja, <?php echo date('d', strtotime($model->tgl_assesmen_awal)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($model->tgl_assesmen_awal))) . ' ' . date('Y', strtotime($model->tgl_assesmen_awal)) . ' ' . date('H:i:s', strtotime($model->tgl_assesmen_awal)) . " WITA"; ?>
            <br><br><br><br><br><br>
            <?php echo $model->paramedis_nama; ?>
        </center>
      </td>
  </tr>
</table>

<?php
$det = ObservasipasienigdT::model()->findAllByAttributes(array(
    'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
        ), array(
    'order' => 'pemeriksaanke'
        ));


$date1 = new DateTime('2000-01-01 00:00');
$date2 = new DateTime('2000-01-01 23:59');


$label = array();

$det_arr = array();
foreach ($det as $item) {
    $det_arr[date('H:i', strtotime($item->observasijam))] = $item;
}


$val_nadi = array();
$val_sistol = array();
$val_diastol = array();

$val_nadi2 = array();
$val_sistol2 = array();
$val_diastol2 = array();

$val_nadi3 = array();
$val_sistol3 = array();
$val_diastol3 = array();

while ($date1 <= $date2) {
    $time = $date1->format("H:i");
    $label[] = $time;

    $item = empty($det_arr[$time]) ? null : $det_arr[$time];


    $cocok = !empty($item);

    $val_nadi[] = ($cocok) ? $item->detaknadi : null;
    $val_pernapasan[] = ($cocok) ? $item->pernapasan : null;
    $val_suhu[] = ($cocok) ? $item->suhubadan : null;
    $val_diastolik[] = ($cocok) ? $item->td_dyastolic : null;
    $val_systolic[] = ($cocok) ? $item->td_systolic : null;


    $date1->add(new DateInterval("PT1M"));
}
?>

<script type="text/javascript">

    $(document).ready(function () {
        generateGrafik();
    });
    function generateGrafik() {

        var obs = $("#chart_obs");
        var lineChart = new Chart(obs, {
            type: 'line',
            data: {
                labels: <?php echo CJSON::encode($label); ?>,
                datasets: [
                    // Pre Operatif
                    {
                        label: 'Nadi',
                        lineTension: 0,
                        display: false,
                        data: <?php echo CJSON::encode($val_nadi); ?>,
                        backgroundColor: 'red',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'red',
                        fill: false,
                        borderColor: "red",
                    },
                    {
                        label: 'Pernapasan',
                        lineTension: 0,
                        display: false,
                        data: <?php echo CJSON::encode($val_pernapasan); ?>,
                        backgroundColor: 'blue',
                        pointStyle: 'cross',
                        rotation: 180,
                        pointRadius: 7,
                        pointBorderColor: 'blue',
                        fill: false,
                        borderColor: "blue",
                    },
                    {
                        label: 'Suhu',
                        lineTension: 0,
                        display: false,
                        data: <?php echo CJSON::encode($val_suhu); ?>,
                        backgroundColor: 'green',
                        pointStyle: 'crossRot',
                        pointRadius: 7,
                        pointBorderColor: 'green',
                        fill: false,
                        borderColor: "green",
                    },
                    {
                        label: 'Diastolik',
                        lineTension: 0,
                        display: false,
                        data: <?php echo CJSON::encode($val_diastolik); ?>,
                        backgroundColor: 'black',
                        pointStyle: 'triangle',
                        pointRadius: 5,
                        pointBorderColor: 'black',
                        fill: false,
                        borderColor: "black",
                    },
                    {
                        label: 'Sistolik',
                        lineTension: 0,
                        display: false,
                        data: <?php echo CJSON::encode($val_systolic); ?>,
                        backgroundColor: 'black',
                        pointStyle: 'triangle',
                        rotation: 90,
                        pointRotation: 90,
                        pointRadius: 7,
                        pointBorderColor: 'black',
                        fill: false,
                        borderColor: "black",
                    },
                ]
            },
            options: {
                spanGaps: true,
                bezierCurve: false,
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        usePointStyle: true,
                    },
                },
                scales: {
                    xAxes: [{

                            type: "time",
                            time: {
                                parser: "HH:mm",
                                unit: 'minute',
                                unitStepSize: 15,
                                displayFormats: {
                                    'hour': 'HH:mm',
                                    'minute': 'HH:mm',
                                },
                                //tooltipFormat: 'HH:mm'
                            },
                            ticks: {
                                callback: function(value, index, values) {

                                    var arr_val = value.substring(3);

                                    if (arr_val == "00") {
                                        return value;
                                    } else {
                                        return "";
                                    }


                                }
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                min: 0,
                                max: 220,
                                stepSize: 20
                            },
                        }],
                },
            }
        });
    }
</script>
