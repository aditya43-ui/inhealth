
<table class="table table-striped table-bordered table-condensed" border="1" style="background-color:#fbfadf">
    <thead>
        <tr>
            <?php
            foreach (CustomFunction::getNamaHari() as $key => $value) {
                echo '<th>' . $value . '</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        
        <?php
        // var_dump(  $moddaftartindakan);
        $jumlah = 1;
        
        for ($x = 1; $x <= ceil($jumlahHari / count(CustomFunction::getNamaHari())); $x++) {
            echo '<tr>';
            foreach (CustomFunction::getNamaHari() as $key => $value) {
                $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun . '-' . $bulan . '-' . $jumlah), 'full', null);
                $tanggal = explode(',', $tgl);
                if ($jumlah > $jumlahHari) {
                    echo '<td class="disabled"></td>';
                } else {
                    $jumlah2 = (($jumlah < 10) ? "0" : "").$jumlah;
                    if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))) {
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
                            
                            
                            $jadwal = JadwaldokterV::model()->findAll($cr);
                            
//                            $jadwal = JadwaldokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and  pegawai_id = '.$data->pegawai_id.' and  ruangan_id = ? ORDER BY dokterprioritas asc, jadwaldokter_buka ASC', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, $variable['id']));

                            // pegawai_id = '.$pendaftaran->pegawai_id.' and);
                            // $pendaftaran = PendaftaranT::model()->findByAttributes([
                            //     'pasien_id' => $variable['pasien_id']
                            // ],array('order'=>'pendaftaran_id DESC'));
                            // pegawai_id = '.$pendaftaran->pegawai_id.' and
//                         }else{
//                             $jadwal = JadwaldokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and ruangan_id = ? ORDER BY dokterprioritas asc, jadwaldokter_buka ASC', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, $variable['id']));
                            // $jadwal = JadwaldokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and  ruangan_id = ? ORDER BY dokterprioritas asc, jadwaldokter_buka ASC', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, $variable['id']));
                        
                        }else{
                            
                            $cr = new CDbCriteria;
                            $cr->addBetweenCondition('jadwaldokter_tgl::date', $tahun . '-' . $bulan . '-' . $jumlah2, $tahun . '-' . $bulan . '-' . $jumlah2);
                            // $cr->compare('pegawai_id', $data->pegawai_id);
                            $cr->compare('ruangan_id', $variable['id']);
                            $cr->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                            $cr->order = 'dokterprioritas asc, jadwaldokter_buka ASC';
                            
                            $jadwal = JadwaldokterV::model()->findAll($cr);
                            
                            
                            //$jadwal = JadwaldokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and ruangan_id = ? ORDER BY dokterprioritas asc, jadwaldokter_buka ASC', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, $variable['id']));

                        }

                        echo '<td><b>' . $tgl . '</b>';
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
                            echo '<div class="box1 active" ><table class="table table-striped table-bordered table-condensed" >';
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
                                        
                                        
                                        $date_buka = new DateTime($dokter['jadwaldokter_mulai']);
                                        $date_buka2 = new DateTime($dokter['jadwaldokter_mulai']);
                                        $date_tutup = new DateTime($dokter['jadwaldokter_tutup']);
                                        
                                        list($hours, $minutes, $seconds) = sscanf($dokter['waktutindakan'], '%d:%d:%d');
                                        $interval = new DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds));
                                        $interval_jam = new DatePeriod($date_buka, new DateInterval("PT1H"), $date_tutup);
                                        
                                        $date_buka2->add($interval);
                                        
                                        if ($date_buka > $date_tutup) {
                                            continue;
                                        }
                                        
                                        
                                        $res_jam = [];
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
                                        
                                        
                                        $cr_janji_jam = new CDbCriteria;
                                        $cr_janji_jam->compare('pegawai_id', $dokter['pegawai_id']);
                                        $cr_janji_jam->addCondition("tgljadwal::date = '".$jadwalDokter."'::date");
                                        $cr_janji_jam->addCondition("tgljadwal::time between '".$date_buka->format('H:i:s')."'::time and '".$date_tutup->format('H:i:s')."'::time");

                                        $data_janji = BuatjanjipoliT::model()->findAll($cr_janji_jam);
                                        
                                        foreach ($data_janji as $item_janji) {
                    
                                            $waktu_janji = date('H:i', strtotime($item_janji->tgljadwal));

                                            $tindakan = JanjipolitindakanT::model()->findAllByAttributes(['buatjanjipoli_id'=>$item_janji->buatjanjipoli_id]);

                                            $total_waktu = 0;
                                            foreach ($tindakan as $item_tindakan) {
                                                $master = DaftartindakanM::model()->findByPk($item_tindakan->daftartindakan_id);

                                                list($th, $tm, $ts) = sscanf($master->waktutindakan, '%d:%d:%d');

                                                $total_waktu += ($th * 60) + $tm;

                                            }

                                            $total_waktu = ceil($total_waktu / 60);
                                            
                                            if ($total_waktu == 0) {
                                                $total_waktu = 1;
                                            }


                                            foreach ($res_jam as $idx=>$item_jam) {
                                                if ($waktu_janji == $item_jam["waktu"]) {
                                                    for ($idx_waktu = 0; $idx_waktu < $total_waktu; $idx_waktu++) {
                                                        if (isset($res_jam[$idx + $idx_waktu]['terisi'])) {
                                                            $res_jam[$idx + $idx_waktu]['terisi'] = 1;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        
                                        
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
                                        
                                        
                                        /*
                                        if ($dokter['dokterprioritas'] == "Dokter Prioritas") {
                                            $prioritas = true;
                                        } else {
                                            if ($prioritas) {

                                                $is_pernah = false;
                                                if (!empty($variable['pasien_id'])) {

                                                    $daftar = DaftartindakanM::model()->findAllByAttributes(array(
                                                        'kelompoktindakan_id'=>Params::DEFAULT_KELOMPOKTINDAKAN_ORTHO
                                                    ));

                                                    foreach ($daftar as $list) {
                                                        $tindakan = TindakanpelayananT::model()->findByAttributes([
                                                            'dokterpemeriksa1_id'=>$dokter['pegawai_id'],
                                                            'pasien_id'=>$variable['pasien_id'],
                                                            'daftartindakan_id'=>$list->daftartindakan_id,
                                                        ]);

                                                        if (!empty($tindakan)) {
                                                            $is_pernah = true;
                                                        }
                                                    }
                                                }


                                                if (!$is_pernah) {
                                                    break;
                                                }


                                            }
                                        }
                                         * 
                                         */
                                        
                                        
                                        $time = $date_buka->format('H:i') ? $date_buka->format('H:i') :  substr($dokter['jadwaldokter_tutup'], 0, 5);
                                        $tgl_booking = MyFormatter::formatDateTimeForUser($tahun . '-' . $bulan . '-' . $jumlah2);
                                        $ruangan_id = $dokter['ruangan_id'];

                                        if (count($res_jam) > 0) {
                                            echo '<tr><td>';

                                            $cnt = 0;
                                            foreach ($res_jam as $idx => $item_jam) {

                                                if ($item_jam['terisi'] == 1) {
                                                    echo '<button class="btn" style="color:white;font-size:10pt;background-color:grey; border: none; margin: 2px; padding: 2px;" disabled="true" >' . '' . $item_jam['waktu']. '</button>';

                                                } else {
                                                    echo '<button class="btn" style="color:white;font-size:10pt;background-color:#c12b90; border: none; margin: 2px; padding: 2px;" onClick="pilihdokter('.$dokter['jadwaldokter_id'].',\''.$item_jam['waktu'].'\'); setJamBooking(\''.$item_jam['waktu'].'\', \''.$tgl_booking.'\', '.$ruangan_id.');" >' . '' . $item_jam['waktu']. '</button>';
                                                }

                                                if ($cnt % 3 == 2) {
                                                    echo '<br/>';
                                                }

                                                $cnt++;

                                                // var_dump($item_jam); die;
                                            }

                                            echo '</td></tr>';
                                        }
                                        
                                        break;
                                        
                                    //  '.$time.'
//                                        echo '<tr>' 
//                                        . '<td style="color:white;font-size:10pt;background-color:#c12b90" onClick="setJamBooking(\''.$time.'\', \''.$tgl_booking.'\', '.$ruangan_id.');" >' . '' . $date_buka2->format('H:i') . '<br> Sampai <br>' . substr($dokter['jadwaldokter_tutup'], 0, 5) . '</td>'
//                                        . '</tr>';
                                    }
                                }
                                
                            }
                            echo '</table></div>';
                        }
                        // echo '</t>';
                        $jumlah++;
                    } else {
                        echo '<td class="disabled"></td>';
                    }
                }
                //<span onlclick="test('.$time.')"></span>
            }
            if ($x == ($jumlahHari / count(CustomFunction::getNamaHari()))) {
                if ($jumlah <= $jumlahHari) {
                    $x--;
                }
            }
            echo '</tr>';
        }
        ?>

    </tbody>
</table>
