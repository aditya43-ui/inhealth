<?php

class InformasiKamarController extends MyAuthController
{
    public function actionIndex()
    {
        $this->pageTitle = Yii::app()->name . " - Kamar Rawat Inap";
        $model = RIInformasikamarinapV::model()->findAll('instalasi_id = ' . Yii::app()->user->getState('instalasi_id') . ' AND  kamarruangan_aktif = true order by ruangan_nama ASC, kelaspelayanan_nama ASC, kamarruangan_nokamar ASC, kamarruangan_nobed ASC');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax'])) && (isset($_POST['ruangan']))) {
            $ruangan = $_POST['ruangan'];
            $model = RIInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =" . $ruangan . " and " : "") . 'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);

            echo json_encode($row);
            Yii::app()->end();
        }

        $this->render('index', array(
            'model' => $model,
            'row' => $row
        )); /*
                $modKamarRuangan = new RIKamarRuanganM;
                $trInformasiHarga='';
                $jumlahTempatTidur=0;
                $dataTempatTidur=array();
                $fotoKamar='';
                $formKasur='';
                $noKamar='';
                $kelasPelayanan='';
                $idKelasPelayanan='';
                $sqlKelas='';
                $sqlKamar='';
                $fotoTampil='';
                
                $idRuangan=Yii::app()->user->getState('ruangan_id');
                $modRuangan=RIRuanganM::model()->findByPk($idRuangan);
                
                if(isset ($_POST['RIKamarRuanganM']['kelaspelayanan_id'])){
                    $idKelasPelayanan=$_POST['RIKamarRuanganM']['kelaspelayanan_id'];
                }
                
                if(isset ($_POST['RIKamarRuanganM']['kamarruangan_nokamar'])){
                    $noKamar=$_POST['RIKamarRuanganM']['kamarruangan_nokamar'];
                }
                
                if($idKelasPelayanan!=''){
                    $sqlKelas=" AND kelaspelayanan_id=".$idKelasPelayanan."";
                }
                
                if($noKamar!=''){
                    $sqlKamar=" AND kamarruangan_nokamar='".$noKamar."'";
                }
                if (isset ($_POST['RIKamarRuanganM'])) {
                 
                    $sqlKamar="SELECT DISTINCT(kamarruangan_nokamar),kelaspelayanan_id,ruangan_id
                               FROM kamarruangan_m
                               WHERE ruangan_id=".$idRuangan."".$sqlKelas."".$sqlKamar."
                               ORDER BY kamarruangan_nokamar ASC";
                    
                    $dataNoKamar= Yii::app()->db->createCommand($sqlKamar)->query();
                      
                    foreach ($dataNoKamar AS $tampilDataNoKamar):
                        $trInformasiHarga='';
                        $trTotal='';
                        $idKelasPelayanan=$tampilDataNoKamar['kelaspelayanan_id'];
                        $noKomar=$tampilDataNoKamar['kamarruangan_nokamar'];
                        $idRuangan=$tampilDataNoKamar['ruangan_id'];
//==============================Awal Mencari Tarif Kamar    
                        $sql="SELECT 
                              tariftindakan_m.daftartindakan_id, 
                              daftartindakan_m.daftartindakan_nama, 
                              daftartindakan_m.daftartindakan_akomodasi, 
                              komponentarif_m.komponentarif_nama, 
                              kamarruangan_m.kamarruangan_nokamar,
                              kamarruangan_m.kelaspelayanan_id,
                              tariftindakan_m.harga_tariftindakan,
                              komponentarif_m.komponentarif_id,
                              kamarruangan_m.kamarruangan_jmlbed,
                              kamarruangan_m.kamarruangan_image
                            FROM 
                              public.daftartindakan_m, 
                              public.tindakanruangan_m, 
                              public.tariftindakan_m, 
                              public.komponentarif_m, 
                              public.kamarruangan_m
                            WHERE 
                              tindakanruangan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id AND
                              tindakanruangan_m.ruangan_id = kamarruangan_m.ruangan_id AND
                              tariftindakan_m.daftartindakan_id = daftartindakan_m.daftartindakan_id AND
                              komponentarif_m.komponentarif_id = tariftindakan_m.komponentarif_id AND
                              daftartindakan_m.daftartindakan_akomodasi=TRUE AND
                              kamarruangan_m.kelaspelayanan_id=".$idKelasPelayanan." AND
                              kamarruangan_m.kamarruangan_nokamar='".$noKomar."' AND   
                              kamarruangan_m.ruangan_id=".$idRuangan."    
                              GROUP BY kamarruangan_m.kelaspelayanan_id,kamarruangan_m.kamarruangan_nokamar,
                                       komponentarif_m.komponentarif_nama,daftartindakan_m.daftartindakan_akomodasi,
                                       daftartindakan_m.daftartindakan_nama, komponentarif_m.komponentarif_id,
                                       tariftindakan_m.daftartindakan_id,daftartindakan_m.daftartindakan_id,
                                       harga_tariftindakan,kamarruangan_jmlbed,kamarruangan_m.kamarruangan_image
                              ORDER BY komponentarif_m.komponentarif_id ASC";
                        $dataTarif= Yii::app()->db->createCommand($sql)->query();
                        foreach($dataTarif AS $tampiltarif):
                            if($tampiltarif['komponentarif_id']!=Params::KOMPONENTARIF_ID_TOTAL){
                            $trInformasiHarga .="<tr>
                                                    <td width=\"200px\">".$tampiltarif['komponentarif_nama']."</td>
                                                    <td>".$tampiltarif['harga_tariftindakan']."</td>    
                                                  </tr>";
                            }else{
                                 $trTotal .="<tr>
                                                    <td>".$tampiltarif['komponentarif_nama']."</td>
                                                    <td>".$tampiltarif['harga_tariftindakan']."</td>    
                                                  </tr>";
                            }
                        $fotoKamar=$tampiltarif['kamarruangan_image'];    
                        $jumlahTempatTidur= $tampiltarif['kamarruangan_jmlbed'];
                        $kelasPelayanan=  RIKelasPelayananM::model()->findBYPk($tampiltarif['kelaspelayanan_id'])->kelaspelayanan_nama;
                        $noKamar=$tampiltarif['kamarruangan_nokamar'];
                        if($fotoKamar!=''){
                            $fotoTampil=$fotoKamar;
                        }else{
                             $fotoTampil='no_photo.jpeg';
                        }
                            
                        endforeach;
                        $trInformasiHarga ='<table>'.$trInformasiHarga.$trTotal.'</table>';
                        
                        $dataTempatTidur=RIKamarRuanganM::model()->findAll('ruangan_id='.$idRuangan.' 
                                                                    AND kelaspelayanan_id='.$idKelasPelayanan.'
                                                                    AND kamarruangan_nokamar=\''.$noKomar.'\' 
                                                                    ORDER BY kamarruangan_nobed ASC');
                
                
                     $col = 3;
                     $cnt =0;
                     $batas   = 999999999;
                     $formKasur .='<div class="boxInformasi">
                                    <fieldset>
                                    <legend>Data No. Kamar :'.$tampilDataNoKamar['kamarruangan_nokamar'].'</legend>
                                      <table align="center" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td colspan='.$col.'>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <fieldset>
                                                            <legend>Informasi Harga</legend>
                                                            '.$trInformasiHarga.'
                                                        </fieldset>
                                                   </td>
                                                   <td>
                                                        <fieldset>
                                                            <legend>Informasi Kamar</legend>
                                                            Jumlah Tempat Tidur :'.$jumlahTempatTidur.'<br/>
                                                            Kelas Pelayanan :'.$kelasPelayanan.'<br/>
    
                                                        </fieldset>
                                                   </td>
                                                   <td>
                                                        <fieldset>
                                                            <legend>Foto Kamar</legend>
                                                        <img src="'.Params::urlKamarRuanganTumbsDirectory().'kecil_'.$fotoTampil.'">
                                                          </fieldset>  
                                                    </td>
                                               </tr>
                                            </table>   
                                        </td>
                                     </tr>   
                                        ';
                     foreach ($dataTempatTidur as $tampilTempatTidur) :
                           if ($cnt >= $col) 
                            {
                               $formKasur .='<tr>';
                               $cnt = 0;
                            }
                            $cnt++;

                            if($tampilTempatTidur['kamarruangan_status'] == false){//Jika Terisi
                                $modMasukKamar=  RIMasukKamarT::model()->find('kamarruangan_id='.$tampilTempatTidur['kamarruangan_id'].' AND
                                                                               tglkeluarkamar isNUll AND
                                                                               jamkeluarkamar isNULL ORDER BY
                                                                               tglmasukkamar DESC');

                               if(isset($modMasukKamar->pasienadmisi_id)){
                                    $modPasienAdmisi= RIPasienAdmisiT::model()->findByPk($modMasukKamar->pasienadmisi_id);
                                    $modPasien=RIPasienM::model()->findByPk($modPasienAdmisi->pasien_id);
                                    $modPendaftaran=RIPendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
                               }
                                $formKasur .='<td>
                                            <div class="boxrepeat ranjangIsi">
                                                <table cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>NO RM : <b>'.(isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "").'</b><br/>
                                                        No. Pendaftaran : <b>'.(isset($modPendaftaran->no_pendaftaran) ? $modPendaftaran->no_pendaftaran : "").'</b><br/>
                                                        No. Kasur :<b>'.(isset($tampilTempatTidur['kamarruangan_nobed']) ? $tampilTempatTidur['kamarruangan_nobed'] : "").'</b><br/>
                                                        Nama : <b>'.(isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : "").'</b><br/>
                                                        Status : <b>Terisi<b><br/>
                                                        Jenis Kelamin : <b>'.(isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : "").'</b></td>
                                                    </tr>
                                                </table>    
                                            </div>                
                                         </td>';
                            }else{
                            
                                $formKasur .='<td>
                                            <div class="boxrepeat ranjangKosong">
                                            No. Kasur : 
                                                '.$tampilTempatTidur['kamarruangan_nobed'].'<br/>'.
                                                    CHtml::htmlButton(Yii::t('mds','{icon} Kosong',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                            array('class' => 'btn btn-default', 'type'=>'button','id'=>'btn_simpan')).'
                                            <br/><br/><br/><br/><br/>
                                            </div>                
                                         </td>';
                            }
                        endforeach;

                        $formKasur .='</tr></table>
                            </fieldset>
                            </div>
                           <hr style="color: #00F"> '; 
                    endforeach;
//==============================Akhir Mencari Tarif Kamar   

                }

                $this->render('index',array('modKamarRuangan'=>$modKamarRuangan,
                                            'modRuangan'=>$modRuangan,
                                            'trInformasiHarga'=>$trInformasiHarga,
                                            'jumlahTempatTidur'=>$jumlahTempatTidur,
                                            'dataTempatTidur'=>$dataTempatTidur,
                                            'formKasur'=>$formKasur,
                                            'fotoKamar'=>$fotoKamar,
                                            'idRuangan'=>$idRuangan,
                                            'noKamar'=>$noKamar,
                                            'kelasPelayanan'=>$kelasPelayanan));*/
    }

    protected function renderKamarRuangan($model)
    {
        $result = '';
        $tempRuangan = '';
        $list1 = array();
        $jml = 0;
        foreach ($model as $i => $row) {
            if ($row->ruangan_id != $tempRuangan) {
                $tempJumlah = 0;
                $list1[$row->ruangan_id]['name'] = $row->ruangan_nama;
                $list1[$row->ruangan_id]['ruangan_id'] = $row->ruangan_id;
                $list1[$row->ruangan_id]['kelaspelayanan_id'] = $row->kelaspelayanan_id;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_nama;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
                $tempJumlah = $row->kamarruangan_jmlbed;
                $tempRuangan = $row->ruangan_id;
            } else {
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                if ($row->kamarruangan_jmlbed >= $tempJumlah) {
                    $jml = $row->kamarruangan_jmlbed;
                    $tempJumlah = $row->kamarruangan_jmlbed;
                }
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['jml'] = $jml;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
            }
        }

        // echo '<pre>'; var_dump($list1); die;

        //                echo "<pre>";
        foreach ($list1 as $i => $v) {

            $result .= '<div class="contentKamar">';
            $ruangan = RuanganM::model()->findByPk($v['ruangan_id']);
            $tarifumum = RIInformasikamarinapV::model()->getTarif($v['kelaspelayanan_id'], $v['ruangan_id'], 1);
            $tarifbpjs = RIInformasikamarinapV::model()->getTarif($v['kelaspelayanan_id'], $v['ruangan_id'], 3);
            $tarifjamkespa = RIInformasikamarinapV::model()->getTarif($v['kelaspelayanan_id'], $v['ruangan_id'], 4);

            $dataRuangan = '';

            if (!empty($ruangan)) {
                if (file_exists(Params::pathKamarRuanganDirectory() . !empty($ruangan->ruangan_image) ? $ruangan->ruangan_image : 'no_photo.jpeg')) {

                    $file_exist = $ruangan->ruangan_image;
                } else {
                    $file_exist = 'no_photo.jpeg';
                }

                $dataRuangan .= '<table width=\'300\'>';
                $dataRuangan .= '<tr><td rowspan=2><img src=\'' . Yii::app()->baseUrl . '/data/images/kamarruangan/' . $file_exist . '\' class=\'image_ruangan\'></td><td>Fasilitas</td><td>' . ((!empty($ruangan->ruangan_fasilitas)) ? $ruangan->ruangan_fasilitas : " - ") . '</td></tr>';
                $dataRuangan .= '<tr><td>Lokasi</td><td>' . ((!empty($ruangan->ruangan_lokasi)) ? $ruangan->ruangan_lokasi : " - ") . '</td></tr>';
                $dataRuangan .= '<tr><td>Jumlah Bed</td><td>{$jmlbed}</td></tr>';
                $dataRuangan .= '<tr><td>Jumlah Terisi</td><td>{$jmlterisi}</td></tr>';
                $dataRuangan .= '<tr><td>Jumlah Dibooking</td><td>{$jmlbooked}</td></tr>';
                $dataRuangan .= '<tr><td><b>Tarif</b></td></tr>';
                if (count((array)$tarifbpjs) > 0) :
                    $dataRuangan .= '<tr><td><b>Tarif Bpjs</b></td></tr>';
                    foreach ($tarifbpjs as $tarifbpjs) :
                        $dataRuangan .= '<tr><td>' . $tarifbpjs->daftartindakan_nama . '</td><td style=\'text-align:center;\'>Rp' . number_format($tarifbpjs->harga_tariftindakan, 0, '', '.') . '</td></tr>';
                    endforeach;
                endif;
                if (count((array)$tarifjamkespa) > 0) :
                    $dataRuangan .= '<tr><td><b>Tarif Jamkespa</b></td></tr>';
                    foreach ($tarifjamkespa as $tarifjamkespa) :
                        $dataRuangan .= '<tr><td>' . $tarifjamkespa->daftartindakan_nama . '</td><td style=\'text-align:center;\'>Rp' . number_format($tarifjamkespa->harga_tariftindakan, 0, '', '.') . '</td></tr>';
                    endforeach;
                endif;
                if (count((array)$tarifumum) > 0) :
                    $dataRuangan .= '<tr><td><b>Tarif Umum</b></td></tr>';
                    foreach ($tarifumum as $tarifumum) :
                        $dataRuangan .= '<tr><td>' . $tarifumum->daftartindakan_nama . '</td><td style=\'text-align:center;\'>Rp' . number_format($tarifumum->harga_tariftindakan, 0, '', '.') . '</td></tr>';
                    endforeach;
                endif;

                $dataRuangan .= '</table>';
            }
            foreach ($v['kamar'] as $j => $w) {
                $jml_kasur = 0;
                $jml_terisi = 0;
                $jml_booked = 0;
                foreach ($w['kamar'] as $t => $bed) {
                    $jml_kasur += count((array)$bed['bed']);
                    foreach ($bed['bed'] as $d => $e) {
                        $kamar = MasukkamarT::model()->find('kamarruangan_id = ' . $e['id'] . ' order by tglmasukkamar desc');
                        if (!empty($kamar)) {
                            $jml_terisi += 1;
                        }
                        $booking = BookingkamarT::model()->find('kamarruangan_id = ' . $e['id'] . ' AND statuskonfirmasi = \'SUDAH KONFIRMASI\'');
                        if (!empty($booking)) {
                            $jml_booked += 1;
                        }
                    }
                }
                $vars = array(
                    '{$jmlbed}' => $jml_kasur,
                    '{$jmlterisi}' => $jml_terisi,
                    '{$jmlbooked}' => $jml_booked,
                );
                $result .= '<div class="pintu"></div><h3 class="popover-title"><img src=\'' . Yii::app()->baseUrl . '/images/blue-home-icon.png\' style=\'height:30px;\'/>' . $v['name'] . ' - ' . $w['kelaspelayanan'] . ' - ' . $w['jml'] . '<a href="" class="pull-right poping" data-content="' . strtr($dataRuangan, $vars) . '" onclick="return false;" style = "padding-left:200px;"><img src=\'' . Yii::app()->baseUrl . '/images/fasilitas.png\' style=\'height:30px;\'/>Detail</a></h3>
                                <ul>';

                foreach ($w['kamar'] as $x => $y) {
                    $result .= '<li class="bed" style="width:1950px;">
                                    <div class="popover-inner" style="width: 1950px;">
                                        <h6 class="popover-title">' . $y['name'] . '</h3>
                                        <div class="popover-content" style="width: 1945px;">';
                                        $result .= '<div class="row row-fluid" style="width: 100%;">';
                    foreach ($y['bed'] as $a => $b) {
                        $kamar = MasukkamarT::model()->find('kamarruangan_id = ' . $b['id'] . ' order by tglmasukkamar desc');
                        $booking = BookingkamarT::model()->find('kamarruangan_id = ' . $b['id'] . ' AND statuskonfirmasi = \'SUDAH KONFIRMASI\'');
                        if (isset($booking)) {
                            $booked = 1;
                        } else {
                            $booked = 0;
                        }

                        $dataPasien = '';
                        $jeniskelamin = isset($kamar->admisi->pasien->jeniskelamin) ? $kamar->admisi->pasien->jeniskelamin : '';
                        $rencanapulang = $kamar->admisi->rencanapulang ?? null;
                        if (!empty($kamar)) {

                            $admisi = $kamar->admisi;
                            $pasien = is_numeric($admisi->pasien_id) ? PasienM::model()->findByPk($admisi->pasien_id) : null;

                            $no_rm = !empty($pasien->attributes) ? $pasien->attributes['no_rekam_medik'] . "" : null;
                            $nama = !empty($pasien->attributes) ? $pasien->attributes['nama_pasien'] . "" : null;
                            $jk = !empty($pasien->attributes) ? $pasien->attributes['jeniskelamin'] . "" : null;

                            // var_dump($no_rm); die;

                            $dataPasien .= '<table>';
                            $dataPasien .= '<tr><td>No. RM </td><td>: ' . $no_rm . '</td></tr>';
                            $dataPasien .= '<tr><td>Nama </td><td>: ' . $nama . '</td></tr>';
                            $dataPasien .= '<tr><td>Jenis Kelamin </td><td>: ' . $jk . '</td></tr>';
                            $dataPasien .= '</table>';
                            //                                            $dataPasien .='<p><label class=\'control-label\'>Nama :</label> '.$kamar->admisi->pasien->nama_pasien.'</p>';
                            //                                            $dataPasien .='<p><label class=\'control-label\'>Jenis Kelamin :</label> '.$kamar->admisi->pasien->jeniskelamin.'</p>';
                            // echo "<h3>" .  .  "</h3>";

                                                        // var_dump($dataPasien); die;


                        }


                        
                        $status_rencana = empty($rencanapulang) ? "isi" : "hijau";
                        
                        if ($booked == 0) {
                            if ($v['ruangan_id'] == Params::RUANGAN_ID_ANAK) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'anak-kosong' : 'anak-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            elseif ($v['ruangan_id'] == Params::RUANGAN_ID_PRIA) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'pria-kosong' : 'pria-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            elseif ($v['ruangan_id'] == Params::RUANGAN_ID_WANITA) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'wanita-kosong' : 'wanita-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            elseif ($v['ruangan_id'] == Params::RUANGAN_ID_ICU) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'icu-kosong' : 'icu-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            elseif ($v['ruangan_id'] == Params::RUANGAN_ID_PERINATOLOGI) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'perina-kosong' : 'perina-isi') . '.png\'/>&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            elseif ($v['ruangan_id'] == Params::RUANGAN_ID_BERSALIN) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'wanita-kosong' : 'wanita-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            elseif ($v['ruangan_id'] == Params::RUANGAN_ID_BEDAH) :
                                $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'bedah-kosong' : 'bedah-isi') . '.png\'/>&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                            else :
                                if ($jeniskelamin == 'LAKI-LAKI') :
                                    $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'pria-kosong' : 'pria-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                                elseif ($jeniskelamin == 'PEREMPUAN') :
                                    $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'pria-kosong' : 'wanita-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                                else :
                                    $result .= '<span class=""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Pasien Kosong' : $dataPasien) . '" onclick="return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\'' . Yii::app()->baseUrl . '/images/icon_kamar/' . (($b['status']) ?  'pria-kosong' : 'wanita-'.$status_rencana) . '.png\'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>' . $b['no'] . '</a></span>';
                                endif;
                            endif;
                        } else {
                            $result .= 'spanv class""><a style="text-align:left;"  href="" class="btn ' . (($b['status']) ? 'btn-default' : 'btn-primary') . '" rel="popover" data-content="' . (($b['status']) ? 'Sudah dibooking' : $dataPasien) . '" onclick="return false"><img src=\'' . Yii::app()->baseUrl . '/images/' . 'RanjangRumahSakit3' . '.png\'/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $b['no'] . '</a></span>';
                        }


                    }
                    echo '</div>';
                    // for($d=1;$d<=($w['jml'] - (count((array)$y['bed'])));$d++){

                    //  $result .='<p><a href="" class="btn btn-info" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/delete.png\'/>Kosong</a></p>';
                    // }
                    $result .= '</div>
                                    </div>
                                </li>';
                }
                $result .= '</ul>';
            }

            $result .= '</div>';
        }

        //            exit();
        return $result;
    }

    /*
	* Mencari kamarruangan berdasarkan ruangan berdasarkan Kelaspelayanan_id di tabel kelas Ruangan M
	* and open the template in the editor.
	*/
    public function actionGetRuanganNoKamarRuangan($encode = false, $namaModel = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idKelasPelayanan = $_POST["$namaModel"]['kelaspelayanan_id'];
            $noKamar = KamarruanganM::model()->findAll('kelaspelayanan_id=' . $idKelasPelayanan . '');

            $noKamar = CHtml::listData($noKamar, 'kamarruangan_nokamar', 'kamarruangan_nokamar');

            if (empty($noKamar)) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
            } else {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
                foreach ($noKamar as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
        }
        Yii::app()->end();
    }
}
