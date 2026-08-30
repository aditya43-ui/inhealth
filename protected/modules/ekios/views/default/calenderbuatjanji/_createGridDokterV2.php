
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
                                $jadwal = JadwaldokterV::model()->findAll('(jadwaldokter_tgl between ? and ?) and pegawai_id = ? ORDER BY jadwaldokter_buka ASC',array($tahun.'-'.$bulan.'-'.$jumlah, $tahun.'-'.$bulan.'-'.$jumlah, $variable['id']));
                                echo '<td><b>'.$tgl.'</b>';
                                $ruangan = array();
								
                                foreach ($jadwal as $counter => $row) {
									$ru = null;
									if (isset($variable['id'])){
										
											if ($row->pegawai_id == $variable['id']){
												$ru = $row->pegawai_id ;
											}
										
									}
                                    $ruangan[$row->ruangan->ruangan_nama][$counter] = $row->attributes;
                                    //$ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['nama_pegawai'] = $row->pegawai->namaLengkap;
									$ruangan[$row->ruangan->ruangan_nama][$counter]['pegawai_id'] = $row->pegawai_id;
                                    $ruangan[$row->ruangan->ruangan_nama]['active'] = ($row->ruangan_id == $ru) ? 'active' : '';
                                }
                                foreach ($ruangan as $counter => $row) {
                                    echo '<div class="box1 '.$row['active'].'"><table class="table table-striped table-bordered table-condensed">';
                                    foreach ($row as $counterDokter=>$dokter) {
                                        if (is_integer($counterDokter)){
											$peg_dok = null;
											if (isset($variable['pegawai_id'])){
												foreach ($variable['pegawai_id'] as $dok){
													if ($dokter['pegawai_id'] == $dok){
														$peg_dok = $dok;
													}
												}
											}
											
											//var_dump($variable);
											echo	"<tr><td colspan='3'>  ".$counter."</td></tr>";
											echo	"<tr>"
											.		"	<td>".($counterDokter+1)."</td> "
											.		"	<td>".$dokter['nama_pegawai']."</td> "
											//.		"	<td>".LaporankunjunganbydokterV::model()->getJumlahPasien($variable['id'],$tahun.'-'.$bulan.'-'.$jumlah,$dokter['jadwaldokter_buka'],$dokter['jadwaldokter_tutup'],$dokter['pegawai_id'])." pasien</td>"
											.		"</tr>";
											echo	"<tr>"
											.		"	<td colspan='3'>".''.substr($dokter['jadwaldokter_buka'],0,5).' - '.substr($dokter['jadwaldokter_tutup'],0,5)."</td>"
											.		"</tr>";
                                                  
                                        }
                                    }
                                    echo '</table></div>';
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
