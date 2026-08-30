<table width="100%">
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        ANAMNESA
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px">Keluhan Utama</td>
                            <td width="5px">:</td>
                            <td><?php echo trim($model->keluhanutama); ?></td>
                        </tr>
                        <tr>
                            <td width="150px">Keluhan Tambahan</td>
                            <td width="5px">:</td>
                            <td><?php echo trim($model->keluhantambahan); ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="220px">Riwayat Keluhan Penyakit saat ini</td>
                          <td width="5px">:</td>
                          <td><?php echo trim($model->riwayatperjalanan_penyakitpasien); ?></td>
                      </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        RIWAYAT ALERGI
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px" valign="top">Alergi</td>
                            <td width="5px" valign="top">:</td>
                            <td>
                              <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ada
                              <br/>
                              <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Ada'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Ada
                              <br/>
                              <span class="<?php echo ((!empty($model->statusalergipasien) && ($model->statusalergipasien=='Tidak Tahu'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak Tahu</td>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td colspan="2">Bila Ada: </td>
                        </tr>
                        <tr>
                            <td width="180px">Riwayat Alergi Obat</td>
                            <td>: <?php echo $model->riwayatalergiobat; ?></td>
                        </tr>
                        <tr>
                            <td>Riwayat Alergi Makanan</td>
                            <td>: <?php echo $model->riwayatalergimakanan; ?></td>
                        </tr>
                        <tr>
                            <td>Riwayat Alergi Lainnya</td>
                            <td>: <?php echo $model->riwayatalergilainnya; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        RIWAYAT OPERASI, RIWAYAT TRANSFUSI, RIWAYAT PENYAKIT DALAM KELUARGA DAN RIWAYAT PENYAKIT TERDAHULU
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px" valign="top">Riwayat Operasi</td>
                            <td width="5px" valign="top">:</td>
                            <td>
                              <span class="<?php echo ((!empty($model->riwayatpembedahan_status) && ($model->riwayatpembedahan_status=='Tidak Pernah'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Tidak
                              <br/>
                              <span class="<?php echo ((!empty($model->riwayatpembedahan_status) && ($model->riwayatpembedahan_status=='Pernah'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Ya
                              , jenis dan kapan : <?php echo $model->riwayatpembedahan_keterangan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="150px" valign="top">Riwayat Transfusi</td>
                            <td width="5px" valign="top">:</td>
                            <td>
                              <!-- riwayattransfusi_status -->
                              <span class="fa fa-square-o"></span> Tidak
                              <br/>
                              <span class="fa fa-square-o"></span> Ya
                              <br/>
                              Reaksi Transfusi :
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px" valign="top">Riwayat Penyakit dalam Keluarga</td>
                          <td width="5px" valign="top">:</td>
                          <td><?php echo trim($model->riwayatpenyakitkeluarga); ?></td>
                      </tr>
                      <tr>
                          <td width="150px" valign="top">Riwayat Penyakit terdahulu</td>
                          <td width="5px" valign="top">:</td>
                          <td><?php echo trim($model->riwayatpenyakitterdahulu); ?></td>
                      </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        KEADAAN UMUM
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="150px">Keadaan Umum</td>
                          <td width="5px">:</td>
                          <td><?php echo $model->kondisiumum; ?></td>
                      </tr>
                        <tr>
                            <td valign="top">Kesadaran</td>
                            <td valign="top">:</td>
                            <td>
                                <table width="100%" class="tablefont">
                                    <tr>
                                        <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Compos Mentis'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Compos Mentis</td>
                                    </tr>
                                    <tr>
                                        <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Delirium'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Delirium</td>
                                    </tr>
                                    <tr>
                                        <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Somnolen'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Somnolen</td>
                                    </tr>
                                    <tr>
                                        <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Sopor'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Sopor</td>
                                    </tr>
                                    <tr>
                                        <td><span class="<?php echo ((!empty($model->kesadaranpasien) && ($model->kesadaranpasien=='Koma'))?'fa fa-check-square-o':'fa fa-square-o'); ?>"></span> Koma</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Tekanan Darah</td>
                            <td>:</td>
                            <td><?php echo $model->tekanandarah; ?> mmHg</td>
                        </tr>
                        <tr>
                            <td>Nadi</td>
                            <td>:</td>
                            <td><?php echo $model->detaknadi; ?> /Menit</td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                      <tr>
                          <td width="200px">Suhu</td>
                          <td width="5px">:</td>
                          <td><?php echo (!empty($model->suhutubuh)?number_format($model->suhutubuh,2):"-"); ?> &#176; Celcius</td>
                      </tr>
                      <tr>
                          <td>Pernapasan</td>
                          <td>:</td>
                          <td>
                              <?php echo (!empty($model->pernapasan)?number_format($model->pernapasan,2):"-"); ?> /Menit
                          </td>
                      </tr>
                      <tr>
                          <td>Detak Jantung</td>
                          <td>:</td>
                          <td><?php echo $model->denyutjantung; ?></td>
                      </tr>
                        <tr>
                            <td>Kelainan pada Bag. Tubuh</td>
                            <td>:</td>
                            <td><?php echo $model->kelainanpadabagtubuh; ?></td>
                        </tr>
                        <tr>
                            <td>Reflek Cahaya</td>
                            <td>:</td>
                            <td> <?php echo $model->tandavital_reflekcahaya; ?></td>
                        </tr>
                        <tr>
                            <td>SpO2</td>
                            <td>:</td>
                            <td> <?php echo $model->tandavital_spo2; ?> %</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        PEMERIKSAAN FISIK
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%" class="tablefont">
            <tr>
                <td width="200px">Kulit</td>
                <td width="10px">:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_kulit; ?></td>
            </tr>
            <tr>
                <td>Penglihatan</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_penglihatan; ?></td>
            </tr>
            <tr>
                <td>Pendengaran</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_pendengaran; ?></td>
            </tr>
            <tr>
                <td>Mulut, Sendi Rahang  dan Gigi</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_mulutrahang_gigi; ?></td>
            </tr>
            <tr>
                <td>Leher</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_leher; ?></td>
            </tr>
            <tr>
                <td colspan="3"><u>Dada</u></td>
            </tr>
            <tr>
                <td valign="top">Jantung</td>
                <td valign="top">:</td>
                <td>
                  Inspeksi : <?php echo $modAskepgeriatriT->periksafisik_jantung_inspeksi; ?><br/>
                  Palpasi : <?php echo $modAskepgeriatriT->periksafisik_jantung_palpasi; ?><br/>
                  Perkusi : <?php echo $modAskepgeriatriT->periksafisik_jantung_perkusi; ?><br/>
                  Auskultasi : <?php echo $modAskepgeriatriT->periksafisik_jantung_auskultasi; ?>
                </td>
            </tr>
            <tr>
                <td valign="top">Paru</td>
                <td valign="top">:</td>
                <td>
                  Inspeksi : <?php echo $modAskepgeriatriT->periksafisik_paru_inspeksi; ?><br/>
                  Palpasi : <?php echo $modAskepgeriatriT->periksafisik_paru_palpasi; ?><br/>
                  Perkusi : <?php echo $modAskepgeriatriT->periksafisik_paru_perkusi; ?><br/>
                  Auskultasi : <?php echo $modAskepgeriatriT->periksafisik_paru_auskultasi; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><u>Abdomen</u></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top"></td>
                <td>
                  Inspeksi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_inspeksi; ?><br/>
                  Palpasi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_palpasi; ?><br/>
                  Perkusi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_perkusi; ?><br/>
                  Auskultasi : <?php echo $modAskepgeriatriT->periksafisik_abdomen_auskultasi; ?>
                </td>
            </tr>
            <tr>
                <td>Muskuloskeletal</td>
                <td>:</td>
                <td><?php echo $modAskepgeriatriT->periksafisik_muskuloskeletal; ?></td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        PEMERIKSAAN PENUNJANG
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table class="tableBorder" width="100%">
          <thead>
              <tr>
                  <th style="width: 150px">Jenis Penunjang</th>
                  <th>Jenis Pemeriksaan/<br/>Nama Pemeriksaan</th>
                  <th style="width: 150px">Hasil</th>
              </tr>
          </thead>
          <tbody>
              <?php
                $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruanganasal_id'=>$modPendaftaran->ruangan_id),array('condition'=>'ruangan_id in (53,56)'));

                if(count((array)$modPasienMasukPenunjang) > 0){
                  foreach($modPasienMasukPenunjang as $dataPenunjang){
                    $jnspemeriksaanLab = "";
                    $pemeriksaanLab = "";
                    $hslLab = "";

                    if($dataPenunjang->ruangan_id == 53){
                      $criteriaLab = new CDbCriteria();
                      $criteriaLab->select = "jnspmlab.jenispemeriksaanlab_id, jnspmlab.jenispemeriksaanlab_nama, pmlab.pemeriksaanlab_nama, detlab.hasilpemeriksaan, detlab.hasilpemeriksaan_satuan";
                      $criteriaLab->join = "JOIN detailhasilpemeriksaanlab_t detlab on detlab.hasilpemeriksaanlab_id = t.hasilpemeriksaanlab_id
                      JOIN pemeriksaanlab_m pmlab on pmlab.pemeriksaanlab_id = detlab.pemeriksaanlab_id
                      JOIN jenispemeriksaanlab_m jnspmlab on jnspmlab.jenispemeriksaanlab_id = pmlab.jenispemeriksaanlab_id";
                      $criteriaLab->addCondition('t.pasienmasukpenunjang_id = '.$dataPenunjang->pasienmasukpenunjang_id);//.$dataPenunjang->pasienmasukpenunjang_id
                      $modHasilLab = HasilpemeriksaanlabT::model()->findAll($criteriaLab);

                      if(count((array)$modHasilLab)>0){
                        $hasilpemeriksaanLab = array();
                        foreach($modHasilLab as $o=> $detailLab){
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanlab_id]=array('jenispemeriksaan_nama'=>$detailLab->jenispemeriksaanlab_nama,'detail'=>array());
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanlab_id]['detail'][]=array('pemeriksaan_nama'=>$detailLab->pemeriksaanlab_nama);
                          if($o > 0){
                            $hslLab .= "<br/>";
                          }
                          $hslLab .= $detailLab->hasilpemeriksaan." ".$detailLab->hasilpemeriksaan_satuan;
                        }

                        if(count((array)$hasilpemeriksaanLab) > 0){
                          foreach($hasilpemeriksaanLab as $i => $hsLab){
                            $pemeriksaanLab = "";
                            if($i > 0){
                                $jnspemeriksaanLab .= "<br/>";
                            }
                            $jnspemeriksaanLab .= $hsLab['jenispemeriksaan_nama'];

                            if(count((array)$hsLab['detail'])>0){
                              $nourut = 1;
                              foreach($hsLab['detail'] as $j => $detailLabHs){
                                if($j > 0){
                                    $pemeriksaanLab .= "<br/>";
                                }
                                $pemeriksaanLab .= $nourut.'. '.$detailLabHs['pemeriksaan_nama'];
                                $nourut++;
                              }
                            }
                          }
                        }
                      }
                    }else if($dataPenunjang->ruangan_id == 56){
                      $criteriaLab = new CDbCriteria();
                      $criteriaLab->select = "jnspmlab.jenispemeriksaanrad_id, jnspmlab.jenispemeriksaanrad_nama, pmlab.pemeriksaanrad_nama, t.hasilexpertise, t.kesan_hasilrad, t.kesimpulan_hasilrad";
                      $criteriaLab->join = "JOIN pemeriksaanrad_m pmlab on pmlab.pemeriksaanrad_id = t.pemeriksaanrad_id
                      JOIN jenispemeriksaanrad_m jnspmlab on jnspmlab.jenispemeriksaanrad_id = pmlab.jenispemeriksaanrad_id";
                      $criteriaLab->addCondition('t.pasienmasukpenunjang_id = '.$dataPenunjang->pasienmasukpenunjang_id);
                      $modHasilLab = HasilpemeriksaanradT::model()->findAll($criteriaLab);

                      if(count((array)$modHasilLab)>0){
                        $hasilpemeriksaanLab = array();
                        foreach($modHasilLab as $o=> $detailLab){
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanrad_id]=array('jenispemeriksaanrad_nama'=>$detailLab->jenispemeriksaanrad_nama,'detail'=>array());
                          $hasilpemeriksaanLab[$detailLab->jenispemeriksaanrad_id]['detail'][]=array('pemeriksaan_nama'=>$detailLab->pemeriksaanrad_nama);
                          if($o > 0){
                            $hslLab .= "<br/>";
                          }
                          $hslLab .= 'Pemeriksaan dari Hasil Expertise : '.$detailLab->hasilexpertise."<br/> Kesan Hasil Radiologi : ".$detailLab->kesan_hasilrad."<br/> Kesimpulan : ".$detailLab->kesimpulan_hasilrad;
                        }

                        if(count((array)$hasilpemeriksaanLab) > 0){
                          foreach($hasilpemeriksaanLab as $i => $hsLab){
                            $pemeriksaanLab = "";
                            if($i > 0){
                                $jnspemeriksaanLab .= "<br/>";
                            }
                            $jnspemeriksaanLab .= $hsLab['jenispemeriksaanrad_nama'];

                            if(count((array)$hsLab['detail'])>0){
                              $nourut = 1;
                              foreach($hsLab['detail'] as $j => $detailLabHs){
                                if($j > 0){
                                    $pemeriksaanLab .= "<br/>";
                                }
                                $pemeriksaanLab .= $nourut.'. '.$detailLabHs['pemeriksaan_nama'];
                                $nourut++;
                              }
                            }
                          }
                        }
                      }
                    }
                    ?>
                    <tr>
                      <td>
                        <?php
                          $jenispenunjang = "";
                          if($dataPenunjang->ruangan_id == 53){
                            $jenispenunjang = "LABORATORIUM";
                          }else if($dataPenunjang->ruangan_id == 56){
                            $jenispenunjang = "RADIOLOGI";
                          }
                          echo $jenispenunjang;
                         ?>
                      </td>
                      <td>
                        <?php
                          echo $jnspemeriksaanLab.'/<br/>'.$pemeriksaanLab;
                         ?>
                      </td>
                      <td>
                        <?php
                          echo $hslLab;
                         ?>
                      </td>

                    </tr>
                    <?php
                  }
                }
               ?>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="textbold padding5 borderclass">
        KONSEP DIRI DAN KOGNITIF
      </td>
    </tr>
    <tr>
      <td colspan="2" class="padding5 borderclass">
        <table width="100%" class="tablefont">
            <tr>
                <td width="250px">Pengetahuan tentang penyakit saat ini</td>
                <td width="10px">:</td>
                <td>
                  <?php
                    $look_penyakitsekarang = LookupM::model()->findAllByAttributes(array('lookup_type'=>'pengetahuanttg_penyakitsekarang'),array('order'=>'lookup_urutan ASC'));

                    if(count((array)$look_penyakitsekarang) > 0){
                      $html_penyakitsekarang = "";

                      foreach ($look_penyakitsekarang as $i => $look) {
                        $isCheck = false;
                        $style = "";
                        if($i > 0){
                          $style = "style='padding-left: 10px;'";
                        }
                        if($look->lookup_value == $modAskepgeriatriT->pengetahuanttg_penyakitsaatini){
                          $isCheck = true;
                        }
                        $html_penyakitsekarang .= "<span ".$style." class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                      }
                    }
                //echo $html_penyakitsekarang; ?>
                </td>
            </tr>
            <tr>
                <td>Perawatan/ tindakan yang dilakukan</td>
                <td>:</td>
                <td>
                  <?php
                    $look_perawatan = array(0=>'Mengerti',1=>'Tidak Mengerti');

                    if(count((array)$look_perawatan) > 0){
                      $html_perawatan = "";

                      foreach ($look_perawatan as $i => $look) {
                        $isCheck = false;
                        $style = "";
                        if($i > 0){
                          $style = "style='padding-left: 10px;'";
                        }
                        if($look == $modAskepgeriatriT->pengetahuanttg_perawatan){
                          $isCheck = true;
                        }
                        $html_perawatan .= "<span ".$style." class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look;
                      }
                    }
                    echo $html_perawatan; ?>
                </td>
            </tr>
            <tr>
                <td>apakah ada perasaan</td>
                <td>:</td>
                <td>
                  <?php
                    $look_perasaan = LookupM::model()->findAllByAttributes(array('lookup_type'=>'geriatri_memilikiperasaan'),array('order'=>'lookup_urutan ASC'));

                    if(count((array)$look_perasaan) > 0){
                      $html_perasaan = "";

                      foreach ($look_perasaan as $i => $look) {
                        $isCheck = false;
                        $style = "";
                        if($i > 0){
                          $style = "style='padding-left: 10px;'";
                        }
                        if(!empty($modAskepgeriatriT->perasaanyg_dirasakan)){
                          $oriArrPerasaan = json_decode($modAskepgeriatriT->perasaanyg_dirasakan);

                          foreach($oriArrPerasaan as $oriPerasaan){
                            if($look->lookup_value == $oriPerasaan){
                                $isCheck= true;
                            }
                          }
                        }
                        $html_perasaan .= "<span ".$style." class='".(($isCheck==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look->lookup_name;
                      }
                      echo $html_perasaan;
                    }
                  ?>
                </td>
            </tr>
        </table>
      </td>
    </tr>
</table>
