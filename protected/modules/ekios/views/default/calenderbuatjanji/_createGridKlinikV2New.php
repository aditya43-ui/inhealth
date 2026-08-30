<h5><?= MyFormatter::formatDateTimeForDb($data['tanggaljadwal']); ?></h5>
<table class="table table-striped table-bordered table-condensed" border="1" style="background-color:#fbfadf">
    <?php
          $tgl = MyFormatter::formatDateTimeForDb($data['tanggaljadwal']);
    ?>
    <thead>
        <?php
            $row = 1;

            for ($i = 00; $i <= 05; $i++){
                for ($j = 00; $j <= 30; $j+=30){
                    $jadwal = JadwaldokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and  pegawai_id = '.$data->pegawai_id.' and  ruangan_id = ? ORDER BY dokterprioritas asc, jadwaldokter_buka ASC', array($tahun . '-' . $bulan . '-' . $jumlah, $tahun . '-' . $bulan . '-' . $jumlah, $variable['id']));

                    echo '<th>'.$i.':'.$j.'</th>';
                }
            }


            
        ?>
    </thead>
    <tbody>
       <?php

            echo '<tr>';
            echo '<td><b>' . $tgl . '</b>';
            $ruangan = array();

            foreach ($jadwal as $counter => $row) {
                $ru = null;
                if (isset($variable['id'])) {

                    if ($row->ruangan_id == $variable['id']) {
                        $ru = $row->ruangan_id;
                    }
                }
                $ruangan[$row->ruangan_nama][$counter] = $row->attributes;
                //$ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
                $ruangan[$row->ruangan_nama][$counter]['nama_pegawai'] = $row->nama_pegawai;
                $ruangan[$row->ruangan_nama][$counter]['pegawai_id'] = $row->pegawai_id;
                $ruangan[$row->ruangan_nama]['active'] = ($row->ruangan_id == $ru) ? 'active' : '';
                $ruangan[$row->ruangan_nama]['jadwaldokter_id'] =$row->jadwaldokter_id;
            }
            
            foreach ($ruangan as $counter => $row) {
                $time = '';
                echo '<div class="box1 ' . $row['active'] . '" ><a href="#" onclick="pilihdokter('.$row['jadwaldokter_id'].','.$time.');"><table class="table table-striped table-bordered table-condensed" >';
                $is_terisi = false;
                $prioritas = false;
                foreach ($row as $counterDokter => $dokter) {
                    
                    
                    if (is_integer($counterDokter)) {
                        // p(json_encode($dokter));
                        
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
                                        $tindakan = TindakanpelayananT::findOne([
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
                        
                        if (MyFormatter::formatDateTimeForDb($dokter['jadwaldokter_tgl']) > date("Y-m-d")) {

                            $date_buka = new DateTime($dokter['jadwaldokter_mulai']);
                            $date_tutup = new DateTime($dokter['jadwaldokter_tutup']);
                            
                            list($hours, $minutes, $seconds) = sscanf($dokter['waktutindakan'], '%d:%d:%d');
                            $interval = new DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds));
                            
                            $date_buka->add($interval);
                            
                            if ($date_buka > $date_tutup) {
                                continue;
                            }
                            
                            $time = $date_buka->format('H:i') ? $date_buka->format('H:i') :  substr($dokter['jadwaldokter_tutup'], 0, 5);
                        //  '.$time.'
                            echo '<tr>' 
                            . '<td style="color:white;font-size:10pt;background-color:#c12b90" onClick=setJamBooking("'.$time.'")>' . '' . $date_buka->format('H:i') . '<br> Sampai <br>' . substr($dokter['jadwaldokter_tutup'], 0, 5) . '</td>'
                            . '</tr>';
                        }
                    }
                }
                echo '</table></a></div>';
            }
            echo '</tr>';
        ?>
    </tbody>
</table>