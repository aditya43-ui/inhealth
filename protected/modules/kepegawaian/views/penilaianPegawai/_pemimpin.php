<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
  echo "<br><br>";
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Atasan Penilai berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
?>
<table class="table noborder">
    <tr>
        <td><b>Nama</b></td>
        <td><b>:</b></td>
        <td><?php echo $modPenilaianPegawai->pegawai->namaLengkap ?></td>
        <td>&nbsp;</td>
        <td><b>Status</b></td>
        <td><b>:</b></td>
        <td><?php echo $modPenilaianPegawai->pegawai->kategoripegawai; //echo $modPenilaianPegawai->pegawai->namaLengkap  ?></td>
    </tr>
    <tr>
        <td><b>Unit</b></td>
        <td><b>:</b></td>
        <td><?php
            echo!empty($modPenilaianPegawai->pegawai->unitkerja_id) ? $modPenilaianPegawai->pegawai->unitkerja->namaunitkerja : '-';
            ?></td>
        <td>&nbsp;</td>
        <td><b>Periode Penilaian</b></td>
        <td><b>:</b></td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modPenilaianPegawai->periodepenilaian) . ' s/d ' . MyFormatter::formatDateTimeForUser($modPenilaianPegawai->sampaidengan) ?></td>
    </tr>
    <tr>
        <td><b>Jabatan</b></td>
        <td><b>:</b></td>
        <td><?php echo!empty($modPenilaianPegawai->pegawai->jabatan_id) ? $modPenilaianPegawai->pegawai->jabatan->jabatan_nama : '-' ?></td>
        <td>&nbsp;</td>		
    </tr>
</table>
<br><br>

<?php
$table = $generateTable;
$a = 1;
$d = 0;
$jmlAspekPenilaian = array();
foreach ($table as $dt) {
    ?>   

    <ol style="list-style-type: upper-alpha;font-weight: bold;margin: 0;padding: 0;" start="<?php echo $a ?>">
        <li><b><?php echo $dt['jenispenilaian'] ?></b></li>
    </ol>
    <table class="table border" width="100%" id="">                         
        <tr>
            <th>NO</th>
            <th>ASPEK PENILAIAN</th>
            <th width="10%">NILAI</th>
            <th width="15%">NAMA NILAI</th>
            <th>KETERANGAN</th>
        </tr>

        <?php
        $b = 1;
        $grandTotal = 0;
        $grandRata = 0;
        $grandAspek = 0;
        $data[$dt['jenispenilaian_id']] = 0;
        foreach ($dt['kompetensi'] as $dt2) {
            ?>
            <tr>
                <td>
                    <ol style="padding: 0;margin: 0;" start="<?php echo $b; ?>">
                        <li>&nbsp;</li>
                    </ol>                                            
                </td>
                <td colspan="4"><?php echo $dt2['kompetensi_nama']; ?></td>

            </tr>
        <?php
        $c = 1;
        $subTotal = 0;
        $subRata = 0;
        $countIndikator = 0;
        $subAspek = 0;

        foreach ($dt2['indikator'] as $dt3) {
            $subTotal = $subTotal + $dt3['nilai'];
//            $subRata = number_format($subTotal / count((array)$dt2['indikator']), 2); //RSPMC-686
            $countIndikator = $countIndikator + $dt3['bobotnilai_indikator'];
            $subRata = number_format($subTotal / $countIndikator, 2);
            
            ?>
                <tr id="<?php echo $dt['jenispenilaian_id'] . '-' . $dt2['kompetensi_id'] . '-' . $c; ?>">
                    <td></td>
                    <td>
                        <ol style="list-style-type: lower-alpha;padding: 0;margin: 0;" start="<?php echo $c; ?>">
                            <li><?php echo $dt3['indikatorperilaku_nama']; ?></li>
                        </ol>                                            
                    </td>
                    <td style="text-align:right;">
                        <?php echo $dt3['nilai'] ?>
                    </td>
                    <td>
                        <?php echo $dt3['namanilai'] ?>
                    </td>
                    <td>                                        
                        <?php echo $dt3['keterangan'] ?>
                    </td>
                </tr>
                        <?php
                        $c++;
                        $d++;
                    }
                    $grandRata = number_format($grandRata + $subRata, 2);
                    $grandTotal = $grandTotal + $subTotal;
                    $subAspek = $subRata * ($dt['bobot_penilaian'] / 100);
                    array_push($jmlAspekPenilaian, $subAspek);
                    ?>
            <tr>
                <td colspan="2" style="text-align:right;"><b>Sub Jumlah</b></td>
                <td style="text-align:right;"><?php echo $subTotal; ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;"><b>Rata - Rata <?php echo $b ?></b></td>
                <td style="text-align:right;"><?php echo number_format($subRata, 2); ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;"><b>Nilai Aspek <?php echo $b ?></b></td>
                <td style="text-align:right;"><?php echo number_format($subAspek, 2); ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php
        $b++;
    }

    if (count((array)$dt['kompetensi']) > 1) {
        ?>                
            <tr>
                <td colspan="2" style="text-align:right;"><b>Total Jumlah</b></td>
                <td style="text-align:right;"><?php echo $grandTotal; //CHtml::textField("totalJumlah".$dt['jenispenilaian_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;')) ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;"><b> Total Rata - Rata</b></td>
                <td style="text-align:right;"><?php echo number_format($grandRata / count((array)$dt['kompetensi']), 2); //CHtml::textField("totalRataRata".$dt['jenispenilaian_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;'))  ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
    <?php } ?>
    </table>
    <p>&nbsp;</p>
        <?php
        $data[$dt['jenispenilaian_id']] = number_format($grandRata / count((array)$dt['kompetensi']), 2);
        $a++;
    }
    ?>

<table>
    <tr>
        <th><u>Keterangan Nilai</u></th>
    </tr>	
<?php
$j = 1;
$forNilai = $ketNilai;
foreach ($ketNilai as $nl) {
    ?>	
        <tr>
            <td><?php echo $nl->kolomrating_namalevel; ?></td>
            <td> : &nbsp;&nbsp;</td>
            <td>
    <?php
    if ($j == count((array)$ketNilai)) {
        echo 'Kurang dari ' . ($nl->kolomrating_nilaiakhir + 1);
        echo CHtml::hiddenField("ketNilai-" . $j, '', array('min' => $nl->kolomrating_nilaiawal, 'max' => $nl->kolomrating_nilaiakhir, 'keterangan' => $nl->kolomrating_namalevel));
    } else {
        echo $nl->kolomrating_nilaiawal;
        ?> - <?php
                    echo $nl->kolomrating_nilaiakhir;
                    echo CHtml::hiddenField("ketNilai-" . $j, '', array('min' => $nl->kolomrating_nilaiawal, 'max' => $nl->kolomrating_nilaiakhir, 'keterangan' => $nl->kolomrating_namalevel));
                }
                ?>
            </td>
        </tr>
    <?php
    $j++;
}
?>
</table>
<p>&nbsp;</p>
<b><h6 style="color:#333;">Total Nilai</h6></b>
<table class="table border" width="100%" id="">
    <tr>
        <th>NO</th>
        <th>Aspek Penilaian</th>
        <th style="text-align: center;" width="10%">Jumlah</th>
        <th style="text-align: center;" width="10%">Nama Nilai</th>
        <th>Keterangan</th>
    </tr>
<?php
$no = 1;
$totalSeluruh = 0;
$totalAspekAll = 0;
$keterangan = explode('{{aspek}}', $modPenilaianPegawai->penilaianpegawai_keterangan);
foreach ($table as $jns) {
    $totalSeluruh = number_format($totalSeluruh + $data[$jns['jenispenilaian_id']], 2);
    
    foreach ($forNilai as $sc) {
        $dataJns = number_format($data[$jns['jenispenilaian_id']], 0);
        if (($dataJns >= $sc->kolomrating_nilaiawal) AND ( $dataJns <= $sc->kolomrating_nilaiakhir)) {
            $namaNilai = $sc->kolomrating_uraian;
        }

        if ((ceil($totalSeluruh / count((array)$table)) >= $sc->kolomrating_nilaiawal) AND ( ceil($totalSeluruh / count((array)$table)) <= $sc->kolomrating_nilaiakhir)) {
            $ketNilai = $sc->kolomrating_uraian;
        }
    }
    $totalAspekAll += $jmlAspekPenilaian[$no - 1];
    ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $jns['jenispenilaian']; ?></td>
            <td style="text-align: right;">
                <?php 
//                    echo $data[$jns['jenispenilaian_id']]; 
                echo number_format($jmlAspekPenilaian[$no - 1], 2);
                ?>
            </td>
            <td ><?php echo $namaNilai; ?></td>
            <!--<td ><?php //echo CHtml::textArea("statusKet-".$jns['jenispenilaian_id'], '',array('readonly'=>true,'class'=>'autorow')); ?></td>-->
            <td><?php echo $keterangan[$no - 1]; //echo CHtml::activeTextArea($model, 'penilaianpegawai_keterangan['.($no-1).']',array('class' => 'autogrow'))  ?></td>
        </tr>
    <?php
    $no++;
}

?>	
    <tr>
        <td></td>
        <td style="text-align:right;">Total</td>
        <td style="text-align: right;">
            <?php 
//                echo $totalSeluruh; //echo CHtml::activeTextField($model, 'jumlahpenilaian', array('readonly'=>true, 'style' => 'text-align:right;'));//echo CHtml::textField("grandTotal",'',array('readonly'=>true, 'style' => 'text-align:right;'));  
                 echo number_format($totalAspekAll, 2);
            ?>
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr style="display:none;">
        <td></td>
        <td style="text-align:right;">Rata - rata</td>
        <!--<td><?php //echo //$totalSeluruh//count((array)$table);//echo CHtml::textField("grandAverage",'',array('readonly'=>true, 'style' => 'text-align:right;')); ?></td>-->
        <td style="text-align: right;">
            <?php 
//                echo floor(($totalSeluruh / count((array)$table) * 100)) / 100//echo CHtml::activeTextField($model, 'nilairatapenilaian', array('readonly'=>true, 'style' => 'text-align:right;'));//echo CHtml::textField("grandTotal",'',array('readonly'=>true, 'style' => 'text-align:right;'));  
                echo number_format($totalAspekAll, 2);
            ?>
        </td>
        <td ><?php echo $ketNilai; ?></td>
        <td ><?php //echo CHtml::textArea("statusTotal", '',array('readonly'=>true,'class'=>'autorow')); ?></td>
    </tr>
</table>

<table class="border table">
    <tr>
        <td>
            Rekomendasi dari hasil penilaian : <br>
<?php echo $modPenilaianPegawai->rekomendasi ?>
            <br>
            <br>
            <br>
        </td>
    </tr>
    <tr>
        <td>
            Catatan : <br>
<?php echo $modPenilaianPegawai->catatan; ?>
            <br>
            <br>
            <br>
        </td>
    </tr>
</table>

<div class="row">
	<div class="col-sm-6" style="text-align:center;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Atasan Penilai,";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Atasan Penilai'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('ApprovePemimpin',array('penilaianpegawai_id'=>$modPenilaianPegawai->penilaianpegawai_id,'approve'=>true)).'";} ); return false;'));  
			}
			?>
		</div>	
		<div class="control-group">
			( <?php echo $modPenilaianPegawai->pimpinannama;?> )
		</div>	
	</div>
	<div class="col-sm-6" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			Penilai,
		</div>
		<div class="control-group">
			( <?php echo $modPenilaianPegawai->penilainama;?> )
		</div>
	</div>
</div>

<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printApprovePemimpin',array('penilaianpegawai_id'=>$modPenilaianPegawai->penilaianpegawai_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>