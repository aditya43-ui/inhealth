<style>
    .tablejadwal tbody tr td.jd{
        height: 76px;
        font-size:10pt;
    }
    .tablejadwal tbody tr td.aktif:hover{
        background: none repeat scroll 0 0 #FCE8AB;
    }
    .tablejadwal tbody tr td.present{
        cursor: pointer;
    }
    .tablejadwal tbody tr td.disabled{
        background-color: #FEE;
        cursor: not-allowed;
    }
    .tablejadwal tbody tr td .box1{        
        border: 1px solid #ccc;
        margin:2px 2px 5px 2px;
        padding:5px 5px 0px 5px;
        border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
        -moz-border-radius:3px;
    }
    .tablejadwal tbody tr td .box1.active{        
        border:1px solid red;
    }
    
    .tablejadwal tbody tr td .box1 ul li.active a{
        color:red;
    }
</style>

<div class="block-kioskmodule" id="jadwaldokter" name="jadwaldokter">
	<?php $bulan = date('n'); $namaBulan = $format->getMonthId($bulan); ?>
	
        <legend class="rim">JADWAL DOKTER BULAN <?php echo strtoupper($namaBulan) ?></legend>

	<table class="tablejadwal table-striped table-bordered table-condensed" border="1" width="100%">
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
	            	$bulan = date('m');
	            	$tahun = date('Y');
	            	$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
	                $jumlah = 1;
	                for($x = 1;$x<=ceil($jumlahHari/count(CustomFunction::getNamaHari()));$x++){
	                    echo '<tr>';
	                    foreach (CustomFunction::getNamaHari() as $key => $value) {
	                        $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun.'-'.$bulan.'-'.$jumlah),'full',null);
	                        $tanggal = explode(',',$tgl);
	                        if ($jumlah > $jumlahHari){
	                                echo '<td class="jd disabled"></td>';
	                        }else{
	                            if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))){
	                                $jadwal = JadwaldokterM::model()->findAll('(jadwaldokter_tgl between ? and ?) ',array($tahun.'-'.$bulan.'-'.$jumlah, $tahun.'-'.$bulan.'-'.$jumlah));
	                                
	                                $ruangan = array();
									$data = null;
	                                foreach ($jadwal as $counter => $row) {
                                            
                                                                        $ru = null;
									if (isset($variable['ruangan_id'])){
										foreach ($variable['ruangan_id'] as $r){
											if ($row->ruangan_id == $r){
												$ru = $r;
											}
										}
									}
                                            
	                                    $ruangan[$row->ruangan->ruangan_nama][$counter] = $row->attributes;
	                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['instalasi_nama'] = $row->instalasi->instalasi_nama;
	                                    $ruangan[$row->ruangan->ruangan_nama][$counter]['nama_pegawai'] = $row->pegawai->nama_pegawai;
	                                    $ruangan[$row->ruangan->ruangan_nama]['active'] = ($row->ruangan_id == $ru) ? 'active' : '';
		                                $data = $row->instalasi->instalasi_nama;
	                                }
	                                if($data==null || $data==""){
	                                	echo '<td class="jd aktif">'.$tgl;
	                                }else{
	                                	echo '<td class="jd aktif present">';
	                                
	                                $i = 1;	
	                                foreach ($ruangan as $counter => $row) {
	                                	//printf($ruangan);
	                                   // echo '<div class="box1 '.$row['active'].'">';
	                                  if($i==1){
	                                    echo $tgl;
                                            echo '<div class="box1 '.$row['active'].'">'.$counter.'<ul>';
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
                                            echo '<li class="pegawai_id_'.$dokter['pegawai_id'].' '.((($dokter['pegawai_id'] == $peg_dok) ? 'active' : '')).'">
                                                <a href="">'.$dokter['nama_pegawai'].' ('.substr($dokter['jadwaldokter_mulai'],0,2).' - '.substr($dokter['jadwaldokter_tutup'],0,2).')</a>
                                                    </li>';
                                        }
                                    }
                                    echo '</ul></div>';
                                            
	                                  }
	                                  $i++;
	                                    // foreach ($row as $counterDokter=>$dokter) {
	                                    //     if (is_integer($counterDokter)){
	                                    //         echo '<li class="pegawai_id_'.$dokter['pegawai_id'].' '.((($dokter['pegawai_id'] == $variable['pegawai_id']) ? 'active' : '')).'">
	                                    //             <a href="" onclick="updateJadwal('.$dokter['jadwaldokter_id'].'); return false;">'.$dokter['nama_pegawai'].' ('.substr($dokter['jadwaldokter_mulai'],0,2).' - '.substr($dokter['jadwaldokter_tutup'],0,2).')</a>
	                                    //                 </li>';
	                                    //     }
	                                    // }
	                                    //echo '</div>';

			                            // var_dump($row);
			                            // exit;
	                                }
	                                echo '</td>';
	                                }
	                                
	                                $jumlah++;
	                            }
	                            else{
	                                echo '<td class="jd disabled"></td>';
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

</div>	
<?php
// Dialog buat lihat menampilkan detail asuransi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogViewJadwalDokter',
    'options'=>array(
        'title'=>'View Data Jadwal Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>600,
        'minHeight'=>400,
        'resizable'=>false
    ),
));
?>
<iframe src="" name="iframeViewJadwalDokter" width="100%" height="300" >

</iframe>
<?php $this->endWidget(); ?>