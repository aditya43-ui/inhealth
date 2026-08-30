

        <?php
        // var_dump(  $moddaftartindakan);
        $jumlah = date('d', strtotime($variable['tanggaljadwal']));
        
//        for ($x = 1; $x <= ceil($jumlahHari / count(CustomFunction::getNamaHari())); $x++) {
//            echo '<tr>';
        
            $str_line = array();
        
        
            // foreach (CustomFunction::getNamaHari() as $key => $value) {
                $str_sub = "";
                $is_ada = false;
                $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun . '-' . $bulan . '-' . $jumlah), 'full', null);
                $tanggal = explode(',', $tgl);
//                if ($jumlah > $jumlahHari) {
//                    echo '<td class="disabled"></td>';
//                } else {
                    $jumlah2 = (($jumlah < 10) ? "" : "").$jumlah;
//                    if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))) {
                        // print_r($variable['is_kontrol']);die;
                        if($variable['pasien_id'] && $variable['is_kontrol'] == 1){

                            $data = BuatjanjipoliT::model()->findByAttributes([
                                    'pasien_id' => $variable['pasien_id']

                            ],array('order'=>'pendaftaran_id DESC'));
                            
                            
                            $cr = new CDbCriteria;
                            $cr->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                            if (!empty($data)) {
                                $cr->compare('pegawai_id', $data->pegawai_id);
                            }
                            $cr->compare('ruangan_id', $variable['id']);
                            $cr->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                            $cr->order = 'dokterprioritas asc, jadwaldokter_buka ASC';
                            
                            
                            $jadwal = JadwaltindakandokterV::model()->findAll($cr);
                        
                        }else{
                            
                            $cr = new CDbCriteria;
                            $cr->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                            // $cr->compare('pegawai_id', $data->pegawai_id);
                            // $cr->join = 'tindakandokter_m ON t.'
                            $cr->compare('ruangan_id', $variable['id']);
                            $cr->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                            $cr->order = 'dokterprioritas asc, jadwaldokter_buka ASC';
                            
                            $jadwal = JadwaltindakandokterV::model()->findAll($cr);
                            
                            
                            //$jadwal = JadwaltindakandokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and ruangan_id = ? ORDER BY dokterprioritas asc, jadwaldokter_buka ASC', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, $variable['id']));

                        }

                        //pembading
                        $crj = new CDbCriteria;
                        $crj->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                        // $cr->compare('pegawai_id', $data->pegawai_id);
                        // $cr->join = 'tindakandokter_m ON t.'
                        $crj->compare('ruangan_id', $variable['id']);
                        $crj->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                        $crj->order = 'jadwaldokter_tutup desc';
                        $jadwaltutup = JadwaltindakandokterV::model()->find($crj);


                        //buka


                        $crb = new CDbCriteria;
                        $crb->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                        // $cr->compare('pegawai_id', $data->pegawai_id);
                        // $cr->join = 'tindakandokter_m ON t.'
                        $crb->compare('ruangan_id', $variable['id']);
                        $crb->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                        $crb->order = 'jadwaldokter_tutup asc';
                        $jadwalbuka = JadwaltindakandokterV::model()->find($crb);

                        // var_dump($jadwalcompare->jadwaldokter_tutup);die;
                        //

//                        echo '<td><b>' . $tgl . '</b>';
                        $ruangan = array();

                        foreach ($jadwal as $counter => $row) {
                            $ru = null;
                            if (isset($variable['id'])) {

                                if ($row->ruangan_id == $variable['id']) {
                                    $ru = $row->ruangan_id;
                                }
                            }
                            $ruangan[0][$counter] = $row->attributes;
                            //$ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
                            $ruangan[0][$counter]['nama_pegawai'] = $row->nama_pegawai;
                            $ruangan[0][$counter]['pegawai_id'] = $row->pegawai_id;
//                            $ruangan[0]['active'] = ($row->ruangan_id == $ru) ? 'active' : '';
//                            $ruangan[0]['jadwaldokter_id'] =$row->jadwaldokter_id;
                        }
                        
                        foreach ($ruangan as $counter => $row) {
                            $time = '';
                            $str_sub .=  '<div class="box1 active" ><table class="table table-striped table-bordered table-condensed" >';
                            $is_terisi = false;
                            $prioritas = false;
                            
                            // var_dump($row);
                            
                            foreach ($row as $counterDokter => $dokter) {
                                
                                
                                if (is_integer($counterDokter)) {
                                    // p(json_encode($dokter));

                                    $jadwalDokter = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($dokter['jadwaldokter_tgl'])));

                                    if ($jadwalDokter == date("Y-m-d")) {

                                        
                                        $peg_dok = null;
                                        if (isset($variable['pegawai_id'])) {
                                            foreach ($variable['pegawai_id'] as $dok) {
                                                if ($dokter['pegawai_id'] == $dok) {
                                                    $peg_dok = $dok;
                                                }
                                            }
                                        }
                                        
                                        // var_dump($dokter);die;
                                        if ($dokter['jumlah_tindakan'] >= $dokter['maksbuatjanji']) {
                                            continue;
                                        }
                                        
                                        //update old
                                        // $date_buka = new DateTime($dokter['jadwaldokter_mulai']);
                                        // $date_buka2 = new DateTime($dokter['jadwaldokter_mulai']);
                                        // $date_tutup = new DateTime($dokter['jadwaldokter_tutup']);
                                        
                                        // list($hours, $minutes, $seconds) = sscanf($dokter['waktutindakan'], '%d:%d:%d');
                                        // $interval = new DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds));
                                        // $interval_jam = new DatePeriod($date_buka, new DateInterval("PT1H"), $date_tutup);
                                        
                                        // $date_buka2->add($interval);
                                        //update new

                                         $cr = new CDbCriteria;
                                        $cr->select = 't.tgljadwal, daftartindakan_m.waktutindakan';
                                        $cr->join = 'JOIN janjipolitindakan_t ON t.buatjanjipoli_id = janjipolitindakan_t.buatjanjipoli_id
                                                    JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = janjipolitindakan_t.daftartindakan_id';
                                        $cr->addCondition('t.pegawai_id ='.$dokter['pegawai_id']);
                                        $cr->compare('t.tgljadwal::date ', $jadwalDokter);
                                        $modJanjiPoli = BuatjanjipoliT::model()->findAll($cr);

                                        $jadwals = [];
                                        if(count($modJanjiPoli) > 0){
                                            foreach ($modJanjiPoli as $value) {

                                                $e = new DateTime('00:00');
                                                $jadwal = new DateTime(date('H:i:s',strtotime($value->tgljadwal)));
                                                $waktu = new DateTime($value->waktutindakan);
                                                $f = clone $e;
                                                $e->add($f->diff($jadwal));
                                                $e->add($f->diff($waktu));
                                                
                                                $interval1 = $f->diff($e)->format("%H:%I");
                                                $jadwals[]= $interval1;
                                            }
                                        }
                                       
                                        $date_buka = new DateTime($jadwalbuka->jadwaldokter_mulai);
                                        $date_tutup = new DateTime($jadwaltutup->jadwaldokter_tutup);
                                          list($hours, $minutes, $seconds) = sscanf($dokter['waktutindakan'], '%d:%d:%d');
                                        $interval = new DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds));
                                        $interval_jam = new DatePeriod($date_buka, new DateInterval("PT20M"), $date_tutup);
                                                $cr_janji_jam = new CDbCriteria;
                                        $cr_janji_jam->compare('pegawai_id', $dokter['pegawai_id']);
                                        $cr_janji_jam->addCondition("tgljadwal::date = '".$jadwalDokter."'::date");
                                        $cr_janji_jam->addCondition("tgljadwal::time between '".$date_buka->format('H:i:s')."'::time and '".$date_tutup->format('H:i:s')."'::time");

                                        $data_janji = BuatjanjipoliT::model()->findAll($cr_janji_jam);
                                        if ($date_buka > $date_tutup) {
                                            continue;
                                        }
                                        // var_dump($jadwals);die;
                                        foreach ($data_janji as $v) {
                                            // var_dump($v);die;
                                        }
                                        $res_jam = [];
                                         if (count($jadwals) > 0) {
                                            
                                            foreach ($jadwals as $key) {
                                                $res_jam[] = [
                                                    'waktu'=>$key,
                                                    'terisi'=>0,
                                                ];
                                            }
                                        }
                                        foreach ($interval_jam as $item_interval) {
                                            $res_jam[] = [
                                                'waktu'=>$item_interval->format('H:i'),
                                                'terisi'=>0,
                                            ];
                                        }
                                        $res_jam[] = [
                                            'waktu'=>$date_tutup->format('H:i'),
                                            'terisi'=>0,
                                        ];
                                        $res_jam = array_unique($res_jam, SORT_REGULAR);
                                        asort($res_jam);

                                        $unique_array = [];
                                        foreach($res_jam as $element) {
                                        $hash = $element['waktu'];
                                        $unique_array[$hash] = $element;
                                        }
                                        $res_jam = array_values($unique_array);

                                        $s=[];
                                        foreach($res_jam as $y){
                                            foreach($jadwals as $j){
                                                // var_dump($j);die;
                                                if($j == $y['waktu']){
                                                    $y['terisi'] = 1;
                                                    $s[]=$y['waktu'];
                                                }
                                            }
                                            // var_dump($y['waktu']);die;
                                        }
                                        // var_dump($x);die;
                                        // var_dump($s);die;
                                
                                        
                                        foreach ($data_janji as $item_janji) {
                    
                                            $waktu_janji = date('H:i', strtotime($item_janji->tgljadwal));

                                            $tindakan = JanjipolitindakanT::model()->findAllByAttributes(['buatjanjipoli_id'=>$item_janji->buatjanjipoli_id]);

                                            $total_waktu = 0;
                                            foreach ($tindakan as $item_tindakan) {
                                                $master = DaftartindakanM::model()->findByPk($item_tindakan->daftartindakan_id);

                                                list($th, $tm, $ts) = sscanf($master->waktutindakan, '%d:%d:%d');

                                                $total_waktu += ($th * 60) + $tm;

                                            }
                                            $total_waktu = ceil($total_waktu / 20);
                                            // var_dump($total_waktu);die;

                                            // if ($total_waktu > 0) {
                                            //     $total_waktu = 1;
                                            // }
                                             $res_jam = array_unique($res_jam,SORT_REGULAR);
                                            asort($res_jam);

                                            // $times=[];
                                            // foreach($s as $f){
                                            //     $times = create_time_range($waktu_janji, $f['waktu']);
                                            // }
                                            // var_dump($times);die;


                                            foreach ($res_jam as $idx=>$item_jam) {
                                               
                                                if ($waktu_janji == $item_jam["waktu"]) {
                                                    for ($idx_waktu = 0; $idx_waktu < $total_waktu; $idx_waktu++) {
                                                        // var_dump($idx_waktu);die;
                                                       
                                                        if (isset($res_jam[$idx + $idx_waktu]['terisi'])) {
                                                            $res_jam[$idx + $idx_waktu]['terisi'] = 1;
                                                        }

                                                    }
                                                }
                                            }
                                        }
                                        // in
                                        // var_dump($res_jam);die;
                                        if (count($res_jam) == 0) {
                                            continue;
                                        }
                                        
                                        $sisa = 0;
                                        foreach ($res_jam as $idx => $item_jam) {
                                            if ($item_jam['terisi'] != 1) {
                                                $sisa++;
                                            }
                                        }
                                        
                                        if ($sisa == 0) {
                                            continue;
                                        }
                                        
                                    
                                        
                                        
                                        $time = $date_buka->format('H:i') ? $date_buka->format('H:i') :  substr($dokter['jadwaldokter_tutup'], 0, 5);
                                        $tgl_booking = MyFormatter::formatDateTimeForUser($tahun . '-' . $bulan . '-' . $jumlah2);
                                        // var_dump($tahun);
                                        // var_dump($bulan);
                                        // var_dump($jumlah2);die;
                                        $ruangan_id = $dokter['ruangan_id'];

                                        if (count($res_jam) > 0) {
                                            $str_sub .=  '<tr><td>';
                                              $cnt = 0;
                                            $bt = 0;
                                            foreach ($res_jam as $idx => $item_jam) {

                                                // var_dump($item_jam['waktu']);die;
                                                $crx = new CDbCriteria;
                                                $crx->select = 'DISTINCT jadwaldokter_id AS dtime';
                                                $crx->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                                                $crx->addCondition('jadwaldokter_mulai <='. "'".$item_jam['waktu']."'");
                                                $crx->addCondition('jadwaldokter_tutup >='. "'".$item_jam['waktu']."'");
                                                $crx->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                                                // $crx->order = 'dokterprioritas asc, jadwaldokter_buka ASC';
                                                
                                                // echo "<pre>";
                                                // print_r($crx);
                                                // exit;
                                                $jadwalHitung = JadwaltindakandokterV::model()->findAll($crx);
                                                
                                               
                                                // var_dump(count($jadwalHitung));die;
                                                $crjanji = new CDbCriteria;
                                                $crjanji->addBetweenCondition('tgljadwal::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                                                $crjanji->addCondition('jambooking <='. "'".$item_jam['waktu']."'");
                                                $crjanji->addCondition('estimasi_jam_selesai >='. "'".$item_jam['waktu']."'");
                                                $crjanji->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                                                // $crjanji->order = 'dokterprioritas asc, jadwaldokter_buka ASC';
                                                
                                                $janjiHitung = BuatjanjipoliT::model()->findAll($crjanji);


                                                if(count($janjiHitung) < count($jadwalHitung)){
                                                    $item_jam['terisi'] = 0;
                                                }

                                                // $crbooking = new CDbCriteria;
                                                // $crbooking->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                                                // $crbooking->addCondition('jadwaldokter_mulai <='. $item_jam['waktu']);
                                                // $crbooking->addCondition('jadwaldokter_mulai >='. $item_jam['waktu']);
                                                // $crbooking->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                                                // // $crx->order = 'dokterprioritas asc, jadwaldokter_buka ASC';
                                                
                                                
                                                // $jadwalHitung = JadwaltindakandokterV::model()->findAll($crbooking);

                                                if ($item_jam['terisi'] == 1) {
                                                    $str_sub .=  '<button class="btn" style="color:white;font-size:10pt;background-color:grey; border: none; margin: 2px; padding: 5px; width:100px;" disabled="true" >' . '' . $item_jam['waktu']. '</button>';

                                                } else {
                                                    $str_sub .=  '<button class="btn btnall" type="button" id="btn-'.$bt.'" style="color:white;font-size:10pt;background-color:#c12b90; border: none; margin: 2px; padding: 5px; width:100px;" onClick="pilihdokter('.$dokter['jadwaldokter_id'].',\''.$item_jam['waktu'].'\'); setJamBooking(\''.$item_jam['waktu'].'\', \''.$tgl_booking.'\', '.$ruangan_id.');setButton('.$bt.')" >' . '' . $item_jam['waktu']. '</button>';
                                                }

                                                $bt++;

//                                                if ($cnt % 3 == 2) {
//                                                    $str_sub .=  '<br/>';
//                                                }

                                                // $cnt++;

                                                // var_dump($item_jam); die;
                                            }


                                            $str_sub .=  '</td></tr>';
                                            
                                            $is_ada = true;
                                        }
                                        
                                        break;
                                        
                                    }
                                }
                                
                            }
                            $str_sub .=  '</table></div>';
                        }
                        // echo '</t>';
//                        $jumlah++;
//                    } else {
//                        echo '<td class="disabled"></td>';
//                    }
//                }
                //<span onlclick="test('.$time.')"></span>
                        
                $str_line[] = array(
                    'str'=>$str_sub,
                    'ada'=>$is_ada,
                );        
                        
                        
            //}
//            if ($x == ($jumlahHari / count(CustomFunction::getNamaHari()))) {
//                if ($jumlah <= $jumlahHari) {
//                    $x--;
//                }
//            }
//            echo '</tr>';
//        }
            
            
          foreach ($str_line as $item) {
              if ($item['ada']) {
                  echo $item['str'];
              }
          }
            
          function create_time_range($start, $end, $interval = '20 mins', $format = '24') {
            $startTime = strtotime($start); 
            $endTime   = strtotime($end);
            $returnTimeFormat = ($format == '12')?'h:i A':'H:i';
        
            $current   = time(); 
            $addTime   = strtotime('+'.$interval, $current); 
            $diff      = $addTime - $current;
        
            $times = array(); 
            while ($startTime < $endTime) { 
                $times[] = date($returnTimeFormat, $startTime); 
                $startTime += $diff; 
            } 
            $times[] = date($returnTimeFormat, $startTime); 
            return $times; 
        }   
            
        ?>

