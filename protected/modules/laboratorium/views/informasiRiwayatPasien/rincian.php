
<?php 
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
}
?>
<?php
echo CHtml::css('.control-label{
    float:left; 
    text-align: right; 
    width:140px;
    font-size:12px;
    color:black;
    padding-right:10px;
    }
    .data-pasien td.right{
        width:140px;
        text-align: right; 
    }
');
?>
<table width="100%" style='margin-left:auto; margin-right:auto;' class="data-pasien">
  <tr>  
    <td class="right">
        <label class='control-label'><?php echo CHtml::encode($modPasien->getAttributeLabel('nama_pasien')); ?>:</label>
    </td>
    <td>
        <?php echo CHtml::encode($modPasien->namadepan.$modPasien->nama_pasien); ?>
    </td>
    <td width="5%">
    </td>
    <td class="right">
        <label class='control-label'><?php echo CHtml::encode($modPasien->getAttributeLabel('no_rekam_medik')); ?>:</label>
    </td>
    <td>
        <?php echo CHtml::encode($modPasien->no_rekam_medik); ?>
    </td>
  </tr>  
  <tr>
    <td class="right">
        <label class='control-label'><?php echo CHtml::encode($modPasien->getAttributeLabel('tanggal_lahir')); ?>:</label>
    </td>
    <td>
        <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir)); ?>
    </td>
    <td width="5%">
    </td>
    <td class="right">
        <label class='control-label'><?php echo CHtml::encode($modPasien->getAttributeLabel('alamat_pasien')); ?>:</label>
    </td>
    <td>
        <?php echo CHtml::encode($modPasien->alamat_pasien); ?>
    </td>    
  </tr>
</table>
<?php echo CHtml::css('td.textright{text-align:right;}'); ?>
<table class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>
                No. Registrasi Lab
            </th>
            <th>
                Tgl. Pemeriksaan
            </th>
            <th>
                Nama Pemeriksaan
            </th>
            <th>
                Hasil Pemeriksaan
            </th>
            <th>
                Nilai Rujukan
            </th>
            
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($modHasilPemeriksaan as $key => $detail) {
            $hasilpemeriksaanlab_id = $detail['hasilpemeriksaanlab_id'];
            $pasienmasukpenunjang_id = $detail['pasienmasukpenunjang_id'];

            $modDetailPemeriksaan = LBDetailHasilPemeriksaanLabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $hasilpemeriksaanlab_id));
            $modNoPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id'=> $pasienmasukpenunjang_id));
            foreach ($modDetailPemeriksaan as $key => $datadetail) {
                // echo $datadetail['nilairujukan'];
    ?>
        <tr>
            <td><?php echo $modNoPenunjang['no_masukpenunjang'] ?></td>
            <td><?php echo MyFormatter::formatDateTimeForUser($detail['tglhasilpemeriksaanlab']); ?></td>
            <td><?php echo $datadetail->pemeriksaanlab->daftartindakan->daftartindakan_nama ?></td>
            <td><?php echo $datadetail['hasilpemeriksaan'] ?></td>
            <td><?php echo $datadetail->nilairujukan ?></td>
        </tr>
    <?php
            }
        }
    ?>
    </tbody>
    
</table>
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

echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$pasien_id = $detail->pasien_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pasien_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
