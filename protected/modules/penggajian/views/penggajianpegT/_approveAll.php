<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>"", 'deskripsi'=>"", 'colspan'=>10));
 
$sukses = null;

if(isset($suksesForm)){
    if($suksesForm==true){
	$sukses = $suksesForm;
    }
}

if($sukses > 0){
    if(isset($type_approve)){
        if($type_approve == 'menyetujui'){
            Yii::app()->user->setFlash('success',"Status Menyetujui berhasil disimpan!");
        }else{
            Yii::app()->user->setFlash('success',"Status Mengetahui berhasil disimpan!");
        }
    }
	
}
$this->widget('bootstrap.widgets.BootAlert'); 
$namaMengetahui="";
$tgl_mengatahui="";
$id_mengatahui="";
$namaMengetahuipt="";
$tgl_mengatahuipt="";
$id_mengatahuipt="";
$namaMenyetujui="";
$tgl_menyetujui="";
$id_menyetujui="";
$id=array();
$totalTerima = 0;
$totalBersih = 0;
?>

        <table id="tableObatAlkes" class="table border" bgcolor='white'>
            <thead>
                <th>No.</th>
                 <th>Pegawai</th>
                <th>Periode</th>
                <th>Tgl. Pengajuan</th>
                 <th>No. Pengajuan</th>
                 <th>Penerimaan Bersih</th>
                 <th>Total Terima</th>
            </thead>
             <tbody>
                 <?php
                    
                    if(count((array)$model)>0){
                        $no = 1;
                        
                        $namaMengetahui = $model[0]->mengetahui;
                        $tgl_mengatahui = $model[0]->tgl_mengetahui;
                        $id_mengatahui = $model[0]->mengetahui_id;
                        
                        $namaMengetahuipt = $model[0]->mengetahuipt;
                        $tgl_mengatahuipt = $model[0]->tgl_mengetahuipt;
                        $id_mengatahuipt = $model[0]->mengetahuipt_id;
                        
                        $namaMenyetujui = $model[0]->menyetujui;
                        $tgl_menyetujui = $model[0]->tgl_menyetujui;
                        $id_menyetujui = $model[0]->menyetujui_id;
                        
                                                
                        foreach ($model as $data){
                            $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                            $id[] = $data->penggajianpeg_id;
                             $totalTerima += $data->totalterima;
                        $totalBersih += $data->penerimaanbersih;
                    ?>
                 
                        <tr bgcolor='white'>
                            <td bgcolor='white'><?php echo $no++; ?></td>
                            <td bgcolor='white'><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
                            <td bgcolor='white'><?php echo MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->periodegaji))); ?></td>
                            <td bgcolor='white'><?php echo MyFormatter::formatDateTimeForUser($data->tglpenggajian); ?></td>
                            <td bgcolor='white'><?php echo $data->nopenggajian; ?></td>
                            <td bgcolor='white' style="text-align: right"><?php echo number_format($data->penerimaanbersih,0,"","."); ?></td>
                            <td bgcolor='white' style="text-align: right"><?php echo number_format($data->totalterima,0,"","."); ?></td>
                        </tr>
                     <?php   
                     }
                    }else{
                     ?>
                 <tr bgcolor='white' colspan="6">
                     <td>Tidak Ditemukan</td>
                 </tr>
                     <?php    
                    }
                 ?>
                 
             </tbody>
             <tfoot>
                <tr>
                    <th style="text-align: right" colspan="5">
                            Total
                    </th>
                    <th style="text-align: right">
                        <?php echo CHtml::encode(number_format($totalBersih,0,"",".")); ?>
                    </th>
                    <th style="text-align: right">
                         <?php echo CHtml::encode(number_format($totalTerima,0,"",".")); ?>
                    </th>
                </tr>
            </tfoot>
        </table>


<div class="row">
    <?php if(isset($type_approve)){ ?>
        <div class="col-sm-4" style="text-align:center;">
            <?php 
            if($type_approve == 'mengetahuirs'){
                if(isset($suksesForm)){
                    echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                    echo "Mengetahui (RS),";
                }else{
                        echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
    //				if($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')){
                            echo CHtml::link(Yii::t('mds',' Mengetahui (RS)'), 
                            $this->createUrl($this->id.'/index'), 
                            array('class' => 'btn btn-danger',
                                    'onclick'=>'approveAll(); return false;'));  
    //                                }
    //                                else{
    //                                    echo CHtml::link(Yii::t('mds',' Mengetahui (RS)'), 
    //                                    $this->createUrl($this->id.'/index'), 
    //                                    array('class' => 'btn btn-danger',
    //                                            'onclick'=>'myAlert("Maaf, Anda tidak berhak Mengapprove Pegawai Mengetahui Pengajuan Gaji ini?"); return false;'));  
    //                                } 
                }
            }
            else{
                 echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                echo "Mengetahui (RS),";
            }
            ?>
    </div>	
    <div class="control-group">
        ( <?php echo (($type_approve == 'mengetahuirs')?$namaMengetahui:(!empty($tgl_mengatahui)?$namaMengetahui:""));?> )
    </div>	
</div>

<div class="col-sm-4" style="text-align:center;">
            <?php 
            if($type_approve == 'mengetahuipt'){
                if(isset($suksesForm)){
                    echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                    echo "Mengetahui (PT),";
                }else{
                        echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
    //				if($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')){
                            echo CHtml::link(Yii::t('mds',' Mengetahui (PT)'), 
                            $this->createUrl($this->id.'/index'), 
                            array('class' => 'btn btn-danger',
                                    'onclick'=>'approveAll(); return false;'));  
    //                                }
    //                                else{
    //                                    echo CHtml::link(Yii::t('mds',' Mengetahui (RS)'), 
    //                                    $this->createUrl($this->id.'/index'), 
    //                                    array('class' => 'btn btn-danger',
    //                                            'onclick'=>'myAlert("Maaf, Anda tidak berhak Mengapprove Pegawai Mengetahui Pengajuan Gaji ini?"); return false;'));  
    //                                } 
                }
            }
            else{
                 echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                echo "Mengetahui (PT),";
            }
            ?>
    </div>	
    <div class="control-group">
        ( <?php echo (($type_approve == 'mengetahuipt')?$namaMengetahuipt:(!empty($tgl_mengatahuipt)?$namaMengetahuipt:""));?> )
    </div>	
</div>
<div class="col-sm-4" style="text-align:center;">
            <?php 
            if($type_approve == 'menyetujui'){
                if(isset($suksesForm)){
                    echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                    echo "Menyetujui,";
                }else{
                        echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
    //				if($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')){
                            echo CHtml::link(Yii::t('mds',' Menyetujui'), 
                            $this->createUrl($this->id.'/index'), 
                            array('class' => 'btn btn-danger',
                                    'onclick'=>'approveAll(); return false;'));  
    //                                }
    //                                else{
    //                                    echo CHtml::link(Yii::t('mds',' Mengetahui (RS)'), 
    //                                    $this->createUrl($this->id.'/index'), 
    //                                    array('class' => 'btn btn-danger',
    //                                            'onclick'=>'myAlert("Maaf, Anda tidak berhak Mengapprove Pegawai Mengetahui Pengajuan Gaji ini?"); return false;'));  
    //                                } 
                }
            }
            else{
                 echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                echo "Menyetujui,";
            }
            ?>
    </div>	
    <div class="control-group">
        ( <?php echo (($type_approve == 'menyetujui')?$namaMenyetujui:(!empty($tgl_menyetujui)?$namaMenyetujui:""));?> )
    </div>	
</div>
    <?php  } ?>
	
	
</div>

<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printApproveAll',array('id'=>$id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

    ?>

<script>		
function print(caraPrint)
{
    window.open("<?php echo $urlPrint; ?>&type_approve=<?php echo (isset($type_approve)?$type_approve:""); ?>&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function approveAll(){
    <?php 
        $dataApprove = "";
        
        if(isset($type_approve)){
            if($type_approve == 'mengetahuirs'){
                if($id_mengatahui == Yii::app()->user->getState('pegawai_id')){
                    $dataApprove = "berhak";
                }
            }
            if($type_approve == 'mengetahuipt'){
                if($id_mengatahuipt == Yii::app()->user->getState('pegawai_id')){
                    $dataApprove = "berhak";
                }
            }
            if($type_approve == 'menyetujui'){
                if($id_menyetujui == Yii::app()->user->getState('pegawai_id')){
                    $dataApprove = "berhak";
                }
            }
        }
    ?>
    
<?php if(!empty($dataApprove)){ ?>
myConfirm("Apakah Anda yakin?","Perhatian!",function(r) {
		if(r){
$.ajax({
    type:'POST',
    url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveAll',array('id'=>$id,'approve'=>true,'type_approve'=>$type_approve)); ?>',
    dataType: "json",
    success:function(data){
        
        if(data.sukses==1){
            $('#frameMenyetujuiAll').html("");
            $('#frameMenyetujuiAll').html(data.form);
        }else{
            myAlert("Status Mengetahui Gagal disimpan!");
        }
            
    },
    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
});
}
	});
<?php }else{
     echo 'myAlert("Maaf, Anda tidak berhak Mengapprove Pengajuan Gaji ini");';
} ?>
}
</script>