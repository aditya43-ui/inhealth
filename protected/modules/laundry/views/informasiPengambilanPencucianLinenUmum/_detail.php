<style>
	body {
		color: black;
	}
	
	.tab-detail th {
		font-weight: bold;
	}
	
	.tab-detail td, .tab-detail th {
		border: 1px solid black;
		padding: 3px;
	}
</style>

<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pengambilan', '', array('class' => 'control-label')); echo " :";?>
            <?php echo isset($model->tglpengambilan) ? $format->formatDateTimeId($model->tglpengambilan) : "-";  ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Pengambilan', '', array('class' => 'control-label')); echo " :"; ?>
            <?php echo isset($model->nopengambilan) ? $model->nopengambilan : "-";  ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pengambil', '', array('class' => 'control-label')); echo " :"; ?>
            <?php echo isset($model->namapengambil) ? $model->namapengambil : "-";  ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Berat', 'ruangan_id', array('class' => 'control-label')); echo " :"; ?>
            <?php echo isset($model->berat) ? number_format($model->berat,2,',','.') : "-";  ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); echo " :"; ?>
        </div>
    </div>
</div>	
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="tab-detail">
        <thead class="border">
            <th>Nama Linen</th>
            <th>Jenis Perawatan</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </thead>
        <?php 
            foreach ($modDetail as $i=>$modLinen){ 
        ?>
            <tr>
                <td><?php echo $modLinen->linen->namalinen; ?></td>
                <td><?php echo $modLinen->jumlah; ?></td>
                <td><?php echo $modLinen->satuan; ?></td>
                <td><?php echo $modLinen->keterangan; ?></td>
            </tr>
        <?php } ?>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengajukan<br></div>
                        <div style="margin-top:60px;"><?php echo $model->namapengirim; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $model->namapengambil; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/PengajuanPerawatanT/Print');
?>
<script type="text/javascript">
function print(caraPrint)
{
    var ambilpencucianlinenumum_id = '<?php echo isset($model->ambilpencucianlinenumum_id) ? $model->ambilpencucianlinenumum_id : null; ?>';
    window.open('<?php echo $url; ?>&ambilpencucianlinenumum_id='+ambilpencucianlinenumum_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>