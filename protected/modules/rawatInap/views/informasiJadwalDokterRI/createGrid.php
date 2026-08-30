<legend class="rim">Tabel Jadwal Dokter Rawat Inap</legend>
<table class="table table-striped table-bordered table-condensed" border="1">
    <thead>
        <tr>
            <?php 
            foreach (CustomFunction::getNamaHari() as $key => $value) {
                echo '<th>'.$value.'</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
            
            <?php 
                $jumlah = 1;
                for($x = 1;$x<=ceil($jumlahHari/count(CustomFunction::getNamaHari()));$x++){
                    echo '<tr>';
                    foreach (CustomFunction::getNamaHari() as $key => $value) {
                        $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun.'-'.$bulan.'-'.$jumlah),'full',null);
                        $tanggal = explode(',',$tgl);
                        if ($jumlah > $jumlahHari){
                                echo '<td class="disabled"></td>';
                        }else{
                            if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))){
                                $jadwal = JadwaldokterM::model()->findAll('(jadwaldokter_tgl between ? and ?) and instalasi_id =?',array($tahun.'-'.$bulan.'-'.$jumlah, $tahun.'-'.$bulan.'-'.$jumlah, Params::INSTALASI_ID_RI));
                                echo '<td>'.$tgl;
                                $ruangan = array();
                                foreach ($jadwal as $counter => $row) {
                                    $ruangan[$row->ruangan->ruangan_nama][$counter] = $row->attributes;
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['nama_pegawai'] = $row->pegawai->nama_pegawai;
                                    $ruangan[$row->ruangan->ruangan_nama]['active'] = ($row->ruangan_id == $variable['ruangan_id']) ? 'active' : '';
                                }
                                foreach ($ruangan as $counter => $row) {
                                    echo '<div class="box1 '.$row['active'].'">'.$counter.'<ul>';
                                    foreach ($row as $counterDokter=>$dokter) {
                                        if (is_integer($counterDokter)){
                                            echo '<li class="pegawai_id_'.$dokter['pegawai_id'].' '.((($dokter['pegawai_id'] == $variable['pegawai_id']) ? 'active' : '')).'">
                                                <a href="" onclick="updateJadwal('.$dokter['jadwaldokter_id'].'); return false;">'.$dokter['nama_pegawai'].' ('.substr($dokter['jadwaldokter_mulai'],0,2).' - '.substr($dokter['jadwaldokter_tutup'],0,2).')</a>
                                                    </li>';
                                        }
                                    }
                                    echo '</ul></div>';
                                }
                                echo '</td>';
                                $jumlah++;
                            }
                            else{
                                echo '<td class="disabled"></td>';
                            }
                        }
                        
                    }
                    if ($x == ($jumlahHari/count(CustomFunction::getNamaHari()))){
                        if ($jumlah <= $jumlahHari){
                            $x--;
                        }
                    }
                    echo '</tr>';
                }
            ?>
        
    </tbody>
</table>