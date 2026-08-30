
<?php 
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerLaporan', array('judulLaporan'=>$data['judulLaporan']));      
}
?>
<?php
echo "
        <style>
		
			body {
				color: black;
			}

            .border th, .border td {
                border:1px solid black !important;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
?>

<table width="100%" style='margin-left:auto; margin-right:auto;' class="data-pasien">
    <tr>
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></b></label>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
       
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?></b></label>
        </td>
        <td>
            : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </td>
    </tr>
    <tr>
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></b></label>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
       
        <td class="left">
             <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?></b></label>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr>
    <tr>
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?></b></label>
        </td>
        
        <td>
            : <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
     
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('kelas_pelayanan')); ?></b></label>
            
        </td>
        
        <td>
            : <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr>
    <tr>
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('carabayar_id')); ?></b></label>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?>
        </td>
        
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('diagnosa')); ?></b></label>
        </td>
        <td>
            :  <?php if (!empty($modPendaftaran->diagnosa)){ ?>
                    <ul>
                            <?php foreach ($modPendaftaran->diagnosa as $row){
                                echo '<li>'.$row->diagnosa->diagnosa_nama.'</li>';
                            } ?>
                    </ul>
              <?php } else { echo ' - '; }?>
        </td>
    </tr>
    <tr>
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('penjamin_id')); ?></b></label>
        </td>
        <td>
            : <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
        </td>
       
        <td class="left">
            <label class='control-label'><b><?php echo CHtml::encode($modPenunjang->getAttributeLabel('no_masukpenunjang')); ?></b></label>
        </td>
        <td>
            : <?php echo CHtml::encode($modPenunjang->no_masukpenunjang); ?>
        </td>
    </tr>
    
    </table>
<p>&nbsp;</p>
<?php echo CHtml::css('td.textright{text-align:right;}'); ?>
<table class='border table'>
  
        <tr>
            <th>
                Keterangan
            </th>
            <th>
                Kategori Pemeriksaan (Dokter)<br/>Pemeriksaan
            </th>
            <th>
                Tarif Satuan
            </th>
            <th>
                Jumlah
            </th>
            <th>
                Tarif Cyto
            </th>
            <th>
                Keringanan
            </th>
            <th>
                Sub Total
            </th> 
            <th>
                Status Bayar
            </th> 
        </tr>
 
        <?php 
        $ruangan = array();
        $total = 0;
        $subsidiAsuransi = 0;
        $subsidiPemerintah = 0;
        $subsidiRumahSakit = 0;
        $iurBiaya = 0;
        foreach ($modRincian as $i=>$row){
            $rowspan = count(RinciantagihanpasienV::model()->findAll('ruangan_id = '.$row->ruangan_id.' and pendaftaran_id = '.$row->pendaftaran_id));
            if (!in_array($row->ruangan_id, $ruangan)){
                $ruangan[] = $row->ruangan_id;
                $ruanganTd = '<td rowspan="'.$rowspan.'" style="vertical-align:middle;text-align:center;">'.$row->ruangan_nama.'</td>';
            }
            else{
                $ruanganTd = '';
            }
            $p = PegawaiM::model()->findByPk($row->pegawai_id);
            echo '<tr>
                    '.$ruanganTd.'
                    <td>'.$row->kategoritindakan_nama.' ('.$p->namaLengkap.')<br/>'.$row->daftartindakan_nama.'
                    </td>
                    <td class="textright">'.number_format($row->tarif_satuan, 0,',','.').'
                    </td>
                    <td>'.$row->qty_tindakan.'
                    </td>
                    <td class="textright">'.number_format($row->tarifcyto_tindakan, 0,',','.').'
                    </td>
                    <td>'.$row->discount_tindakan.'
                    </td>
                    <td class="textright">'.number_format($row->subTotal, 0,',','.').'
                    </td>
                    <td>'.((empty($row->tindakansudahbayar_id)) ? "BELUM LUNAS" : "LUNAS").'
                    </td>
                   </tr>';
            $total += $row->subTotal;
            $subsidiAsuransi +=$row->subsidiasuransi_tindakan;
            $subsidiPemerintah += $row->subsidipemerintah_tindakan;
            $subsidiRumahSakit += $row->subsisidirumahsakit_tindakan;
            $iurBiaya += $row->iurbiaya_tindakan;
        }
        ?>
   
        <tr>
            <td colspan="6"><div class='pull-right'>Total Tagihan</div></td>
            <td class="textright"><?php echo number_format($total, 0,',','.'); ?></td>
            <td></td>
        </tr>
		
        <?php /*<tr>
            <td colspan="6"><div class='pull-right'>Subsidi Asuransi</div></td>
            <td class="textright"><?php echo number_format($subsidiAsuransi, 0,',','.'); ?></td>
            <td></td>
        </tr>
        <!-- <tr>
            <td colspan="6"><div class='pull-right'>Subsidi Pemerintah</div></td>
            <td class="textright"><?php echo number_format($subsidiPemerintah, 0,',','.'); ?></td>
            <td></td>
        </tr> -->
        <tr>
            <td colspan="6"><div class='pull-right'>Subsidi Rumah Sakit</div></td>
            <td class="textright"><?php echo number_format($subsidiRumahSakit, 0,',','.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"><div class='pull-right'>Iur Biaya</div></td>
            <td class="textright"><?php echo number_format($iurBiaya, 0,',','.'); ?></td>
            <td></td>
        </tr>
		 * 
		 */ ?>
   
</table>
    <?php

//$this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
//	'id'=>'rjrinciantagihanpasien-v-grid',
//        'enableSorting'=>false,
//	'rowProvider'=>$modRincian->searchrowRincian(),
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        'mergeColumns' => array('ruangan_nama'),
//        
//	'columns'=>array(
//            array(
//                'name'=>'ruangan_nama',
//                'value'=>'$row->ruangan_nama',
//                'footer'=>false, 
//            ),
//            'tarif_satuan',
//            'qty_tindakan',
//            'tarifcyto_tindakan',
//            array(
//                'name'=>'discount_tindakan',
//                'value'=>'$row->discount_tindakan',
//               'footer'=>false, 
//                ),
//            array(
//                'name'=>'subTotal',
//                'value'=>'$row->subTotal',
////                'footer'=>$modRincian->totals(),
//                ),
//            
//        ),
//    
//    )); 
?>

<?php if (isset($caraPrint)) { ?>
<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">
            
                <label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>
            
        </td>
    </tr>
</table>
<?php } else { 

echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
