
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
                               // $jadwal = BuatjanjipoliT::model()->findAll('(tglbuatjanji between ? and ?) and ruangan_id =?',array($tahun.'-'.$bulan.'-'.$jumlah, $tahun.'-'.$bulan.'-'.$jumlah, $variable['id']));
								$cri = new CDbCriteria();
								$cri->select = " dokter_id, date(tgl_pendaftaran) as tgl_pendaftaran, ruangan_id ";
								$cri->addBetweenCondition('date(tgl_pendaftaran)', $tahun.'-'.$bulan.'-'.$jumlah, $tahun.'-'.$bulan.'-'.$jumlah);
								$cri->addCondition(" dokter_id = ".(isset($variable['id'])?$variable['id']:0)." ");
								$cri->addCondition(" buatjanjipoli_id IS NOT NULL ");
								$cri->group = " dokter_id, date(tgl_pendaftaran), ruangan_id ";
								$jadwal = LaporankunjunganbydokterV::model()->findAll($cri);
																
                                echo '<td>'.$tgl;
                                $ruangan = array();
								
                                foreach ($jadwal as $counter => $row) {
									$ru = null;
									if (isset($variable['ruangan_id'])){
										foreach ($variable['ruangan_id'] as $r){
											if ($row->dokter_id == $r){
												$ru = $r;
											}
										}
									}			
																		
                                    $ruangan[$row->ruangan_id][$counter] = $row->attributes;                                    
                                    $ruangan[$row->ruangan_id][$counter]['nama_pegawai'] = $row->namaLengkap;									
									$ruangan[$row->ruangan_id][$counter]['jumlahpasien'] = $row->getjumlahPasien($row->ruangan_id,$row->tgl_pendaftaran,$row->dokter_id);
									$ruangan[$row->ruangan_id][$counter]['ruangan_nama'] = $row->namaRuangan;
                                    $ruangan[$row->ruangan_id]['active'] = ($row->dokter_id == $ru) ? 'active' : '';
                                }
                                foreach ($ruangan as $counterr => $row) {
                                    echo '<div class="box1 '.$row['active'].'"><table style="width: 100%; border: none;">';
                                    foreach ($row as $counterDokter=>$dokter) {
										
                                        if (is_integer($counterDokter)){											
											echo "<tr><td colspan='3'>".$dokter['ruangan_nama']."</td></tr>";
											echo	"<tr style='border-bottom:1px solid #333 !important;'>"
											.		"	<td width='5%'>".($counterDokter+1)."</td>"
											.		"	<td>".$dokter['nama_pegawai']."</td>"
											.		"	<td width='15%'>".$dokter['jumlahpasien']." pasien</td>"
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
