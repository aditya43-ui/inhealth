<legend class="rim2">Jadwal <b>Hemodialisa</b></legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'jadwal-hd-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAAsalRujukanM_asalrujukan_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); 

?>
<table>
    <tr>
        <td><b>Nama Pasien</b></td>
        <td><b>:</b></td>
        <td><b>
            <?php
                echo $modPasien->nama_pasien;
            ?></b>
        </td>
    </tr>
    <tr>
        <td><b>No Rekam Medik</b></td>
        <td><b>:</b></td>
        <td><b>
            <?php
                echo $modPasien->no_rekam_medik;
            ?></b>
        </td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td width="10%"><?php echo CHtml::label('Bulan','Bulan',array('class'=>"")) ?></td>
        <td>
            <?php 
                $bln = strtoupper(date("F", mktime(0, 0, 0, $modJadwalHD->bulan_daftar, 10)));
                $thn = date('Y', strtotime($modJadwalHD->tahun_daftar));
                $tgl = $bln." ".$thn;
                $modJadwalHD->bulan_daftar = $tgl;
            ?>
            <?php echo $form->dropDownList($modJadwalHD,'bulan_daftar',CHtml::listData($modJadwalHD->getBulan($modPasien->pasien_id), 'bulan', 'bulan'),array('empty'=>'-Pilih-','class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'cariJadwal()'));?>
        </td>
    </tr>
</table>

<?php
$this->endWidget(); 
?>
<h6>Tabel Jadwal <b>Hemodialisa</b></h6>
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
				$tahun = $modJadwalHD->tahun_daftar;
				$bulan = date('m', strtotime($modJadwalHD->bulan_daftar));
				$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                if(count($modJadwal)){
                    $tanggalDiJadwal = $modJadwal;
                }else{
                    $tanggalDiJadwal = array();
                }
                
                for($x = 1;$x<=ceil($jumlahHari/6);$x++){
                    echo '<tr>';
                    foreach (CustomFunction::getNamaHari() as $key => $value) {
                        $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun.'-'.$bulan.'-'.$jumlah),'full',null);
                        $tanggal = explode(',',$tgl);
                        if ($jumlah > $jumlahHari){
                                echo '<td class="disabled"></td>';
                        }else{
                            if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))){
								$tglnow = MyFormatter::formatDateTimeForDb($tanggal[1]);
                                
                                if(count($tanggalDiJadwal)){
                                    $ada = 0;
                                    $tgl_temp = "";
                                    foreach ($tanggalDiJadwal as $key=>$value){
                                        if($value['jadwalhemodialisa_tgl_ke']==$tglnow && $value['jadwalhemodialisa_tgl_ke']!=$tgl_temp){
                                            $ada = 1;
                                            $tgl_temp = $tglnow;
                                            if($value['pendaftaran_id']!=null){
                                                echo '<td style="padding:2px 0px 50px 2px;background:#00FFFF ">';
                                            }else if($value['gantijadwalhd_id']!=null){
                                                echo '<td style="padding:2px 0px 50px 2px;background:#FFA500 ">';
                                            }else if($value['bataljadwalhd_id']!=null){
                                                echo '<td style="padding:2px 0px 50px 2px;background:#F08080 ">';
                                            }else{
                                                echo '<td style="padding:2px 0px 50px 2px;background:#58FA82 ">';
                                            }
                                        }
//                                        if($tgl_temp==$tglnow && $ada!=0){
//                                            $shift = ShiftM::model()->findByPk($value['shift_id']);
//                                            echo $shift->shift_nama; 
//                                        }
                                    }
                                    if($ada==0){
                                        echo '<td style="padding:2px 0px 50px 2px;">';
                                    }
                                }else{
                                    echo '<td style="padding:2px 0px 50px 2px;">';
                                }
//								
//								echo $tgl;
								echo $tanggal[1];
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
<span style="background: #58FA82">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span>Belum Didaftarkan</span>&nbsp;&nbsp;
<span style="background: #00FFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span>Sudah Daftar</span>&nbsp;&nbsp;
<span style="background: #F08080">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span>Batal Jadwal</span>&nbsp;&nbsp;
<span style="background: #FFA500">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span>Ubah Jadwal</span>

<script>
    function cariJadwal(){
        $('#jadwal-hd-form').submit();
    }
</script>