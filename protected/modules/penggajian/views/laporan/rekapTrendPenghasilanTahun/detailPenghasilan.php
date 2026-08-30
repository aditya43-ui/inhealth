<style>
    body {
        color: black;
    }
    
    .tab_detail {
        width: 100%;
        border-collapse: collapse;
    }
    
    .tab_detail th {
        font-weight: bold;
        text-align: center;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 3px;
    }
    
    .tab_detail tfoot td {
        font-weight: bold;
    }
    
    .num {
        text-align: right;
    }
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultLaporanNew',array('judulLaporan'=>"REKAP TREND PENGHASILAN SETAHUN - ".date('Y'), 'colspan'=>15));   
$modelpegawai = PegawaiM::model()->findByPk($pegawai_id);
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="50px"><b> NIP </b> </td>
                    <td>: <?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?></td>
                    <td width="100px" nowrap><b>Periode Gaji</b></td>
                    <td nowrap>: 
                        <?php
                            echo date('Y');
                        ?>
                    </td>
                </tr>
				<tr>
					<td><b> Nama </b> </td>
                    <td>: 
						<?php
                            echo CHtml::encode($modelpegawai->namaLengkap);
                        ?>
					</td>
                </tr>
            </table>            
        </td>
    </tr>
</table><br>
<table class="tab_detail">
    <thead>
        <tr>
            <th>No. </th>
            <th>Keterangan</th>
            <th>Januari</th>
            <th>Febuari</th>
            <th>Maret</th>
            <th>April</th>
            <th>Mei</th>
            <th>Juni</th>
            <th>Juli</th>
            <th>Agustus</th>
            <th>September</th>
            <th>Oktober</th>
            <th>November</th>
            <th>Desember</th>
            <th>total</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $komponengajis = KomponengajiM::model()->findAllByAttributes(array('komponengaji_aktif'=>true));
            $no = 1;
            $totalJan = 0;
            $totalFeb = 0;
            $totalMar = 0;
            $totalApr = 0;
            $totalMei = 0;
            $totalJun = 0;
            $totalJul = 0;
            $totalAgu = 0;
            $totalSep = 0;
            $totalOkt = 0;
            $totalNov = 0;
            $totalDes = 0;
            $totalAll = 0;
            
            foreach ($komponengajis as $komp){
                $totalSub = 0;
                $jumlahJanuari = 0;
                $jumlahFeb = 0;
                $jumlahMei = 0;
                $jumlahMart = 0;
                $jumlahApr = 0;
                $jumlahJun = 0;
                $jumlahJul = 0;
                $jumlahAgu = 0;
                $jumlahSep = 0;
                $jumlahOkt = 0;
                $jumlahNov = 0;
                $jumlahDes = 0;
                 
                $criteriaCDb = new CDbCriteria();
                $criteriaCDb->select = "sum(case when t.periodegaji = '".$periodegaji."-01-01' then pgkom.jumlah else 0 end ) as sumjumlahjan, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-02-01' then pgkom.jumlah else 0 end ) as sumjumlahfeb, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-03-01' then pgkom.jumlah else 0 end ) as sumjumlahmar, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-04-01' then pgkom.jumlah else 0 end ) as sumjumlahapr, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-05-01' then pgkom.jumlah else 0 end ) as sumjumlahmei, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-06-01' then pgkom.jumlah else 0 end ) as sumjumlahjun, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-07-01' then pgkom.jumlah else 0 end ) as sumjumlahjul, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-08-01' then pgkom.jumlah else 0 end ) as sumjumlahagu, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-09-01' then pgkom.jumlah else 0 end ) as sumjumlahsep, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-10-01' then pgkom.jumlah else 0 end ) as sumjumlahokt, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-11-01' then pgkom.jumlah else 0 end ) as sumjumlahnov, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-12-01' then pgkom.jumlah else 0 end ) as sumjumlahdes ";
                $criteriaCDb->join = "JOIN penggajiankomp_t pgkom ON pgkom.penggajianpeg_id = t.penggajianpeg_id ";
                $criteriaCDb->addCondition('t.pegawai_id = '. $pegawai_id);
                $criteriaCDb->addCondition('pgkom.komponengaji_id = '. $komp->komponengaji_id);
                
                $gajiPeg = PenggajianpegT::model()->findAll($criteriaCDb);
                
                foreach ($gajiPeg as $dataKompPeg){
                    $jumlahJanuari += $dataKompPeg->sumjumlahjan;
                    $jumlahFeb += $dataKompPeg->sumjumlahfeb;
                    $jumlahMart += $dataKompPeg->sumjumlahmar;
                    $jumlahApr += $dataKompPeg->sumjumlahapr;
                    $jumlahMei += $dataKompPeg->sumjumlahmei;
                    $jumlahJun += $dataKompPeg->sumjumlahjun;
                    $jumlahJul += $dataKompPeg->sumjumlahjul;
                    $jumlahAgu += $dataKompPeg->sumjumlahagu;
                    $jumlahSep += $dataKompPeg->sumjumlahsep;
                    $jumlahOkt += $dataKompPeg->sumjumlahokt;
                    $jumlahNov += $dataKompPeg->sumjumlahnov;
                    $jumlahDes += $dataKompPeg->sumjumlahdes;
                }
             
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $komp->komponengaji_nama; ?></td>
            <td class="num">
                <?php
                    $totalSub += $jumlahJanuari;
                    echo number_format($jumlahJanuari,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahFeb;
                    echo number_format($jumlahFeb,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahMart;
                    echo number_format($jumlahMart,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahApr;
                    echo number_format($jumlahApr,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahMei;
                    echo number_format($jumlahMei,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahJun;
                    echo number_format($jumlahJun,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahJul;
                    echo number_format($jumlahJul,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                
                    $totalSub += $jumlahAgu;
                    echo number_format($jumlahAgu,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahSep;
                    echo number_format($jumlahSep,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahOkt;
                    echo number_format($jumlahOkt,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahNov;
                    echo number_format($jumlahNov,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    $totalSub += $jumlahDes;
                    echo number_format($jumlahDes,0,"",".");
                ?>
            </td>
            <td class="num">
                <?php
                    echo number_format($totalSub,0,"",".");
                ?>
            </td>
        </tr>
        <?php
            $totalJan += $jumlahJanuari;
            $totalFeb += $jumlahFeb;
            $totalMar += $jumlahMart;
            $totalApr += $jumlahApr;
            $totalMei += $jumlahMei;
            $totalJun += $jumlahJun;
            $totalJul += $jumlahJul;
            $totalAgu += $jumlahAgu;
            $totalSep += $jumlahSep;
            $totalOkt += $jumlahOkt;
            $totalNov += $jumlahNov;
            $totalDes += $jumlahDes;
            $totalAll += $totalSub;
                } ?>
        <tr>
            <td><?php echo count((array)$komponengajis)+1; ?></td>
            <td>PPh 21 Seluruh Penghasilan</td>
            <?php
            $totalSub = 0;
                $jumlahJanuari = 0;
                $jumlahFeb = 0;
                $jumlahMei = 0;
                $jumlahMart = 0;
                $jumlahApr = 0;
                $jumlahJun = 0;
                $jumlahJul = 0;
                $jumlahAgu = 0;
                $jumlahSep = 0;
                $jumlahOkt = 0;
                $jumlahNov = 0;
                $jumlahDes = 0;
                 
                $criteriaCDb = new CDbCriteria();
                $criteriaCDb->select = "sum(case when t.periodegaji = '".$periodegaji."-01-01' then t.pph21perbulan else 0 end ) as sumjumlahjan, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-02-01' then t.pph21perbulan else 0 end ) as sumjumlahfeb, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-03-01' then t.pph21perbulan else 0 end ) as sumjumlahmar, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-04-01' then t.pph21perbulan else 0 end ) as sumjumlahapr, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-05-01' then t.pph21perbulan else 0 end ) as sumjumlahmei, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-06-01' then t.pph21perbulan else 0 end ) as sumjumlahjun, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-07-01' then t.pph21perbulan else 0 end ) as sumjumlahjul, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-08-01' then t.pph21perbulan else 0 end ) as sumjumlahagu, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-09-01' then t.pph21perbulan else 0 end ) as sumjumlahsep, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-10-01' then t.pph21perbulan else 0 end ) as sumjumlahokt, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-11-01' then t.pph21perbulan else 0 end ) as sumjumlahnov, "
                        . "sum(case when t.periodegaji = '".$periodegaji."-12-01' then t.pph21perbulan else 0 end ) as sumjumlahdes ";
                $criteriaCDb->addCondition('t.pegawai_id = '. $pegawai_id);
                $criteriaCDb->addCondition("date_part('year',t.periodegaji) = '".$periodegaji."'");
                
                $gajiPegPPh = PenggajianpegT::model()->findAll($criteriaCDb);
                
                foreach ($gajiPegPPh as $dataKompPeg){
                    $jumlahJanuari += $dataKompPeg->sumjumlahjan;
                    $jumlahFeb += $dataKompPeg->sumjumlahfeb;
                    $jumlahMart += $dataKompPeg->sumjumlahmar;
                    $jumlahApr += $dataKompPeg->sumjumlahapr;
                    $jumlahMei += $dataKompPeg->sumjumlahmei;
                    $jumlahJun += $dataKompPeg->sumjumlahjun;
                    $jumlahJul += $dataKompPeg->sumjumlahjul;
                    $jumlahAgu += $dataKompPeg->sumjumlahagu;
                    $jumlahSep += $dataKompPeg->sumjumlahsep;
                    $jumlahOkt += $dataKompPeg->sumjumlahokt;
                    $jumlahNov += $dataKompPeg->sumjumlahnov;
                    $jumlahDes += $dataKompPeg->sumjumlahdes;
                }
                $totalSub += ($jumlahJanuari+$jumlahFeb+$jumlahMart+$jumlahApr+$jumlahMei+$jumlahJun+$jumlahJul+$jumlahAgu+$jumlahSep+$jumlahOkt+$jumlahNov+$jumlahDes);
            $totalJan += $jumlahJanuari;
            $totalFeb += $jumlahFeb;
            $totalMar += $jumlahMart;
            $totalApr += $jumlahApr;
            $totalMei += $jumlahMei;
            $totalJun += $jumlahJun;
            $totalJul += $jumlahJul;
            $totalAgu += $jumlahAgu;
            $totalSep += $jumlahSep;
            $totalOkt += $jumlahOkt;
            $totalNov += $jumlahNov;
            $totalDes += $jumlahDes;
            $totalAll += $totalSub;
        ?>
            
            <td class="num"><?php echo number_format($jumlahJanuari,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahFeb,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahMart,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahApr,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahMei,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahJun,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahJul,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahAgu,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahSep,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahOkt,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahNov,0,"","."); ?></td>
            <td class="num"><?php echo number_format($jumlahDes,0,"","."); ?></td>
            <td class="num"><?php echo number_format($totalSub,0,"","."); ?></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" class="num">Total</td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalJan); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalFeb); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalMar); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalApr); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalMei); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalJun); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalJul); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalAgu); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalSep); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalOkt); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalNov); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalDes); ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalAll); ?></td>
        </tr>
    </tbody>
</table>
<br>
<?php 
if(!isset($_GET['caraPrint'])){
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('detailRekapPenghasilan',array('pegawai_id'=>$pegawai_id, 'periodegaji'=>$periodegaji));
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
    }else{
        if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="REKAP TREND PENGHASILAN SETAHUN-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    }
    ?>