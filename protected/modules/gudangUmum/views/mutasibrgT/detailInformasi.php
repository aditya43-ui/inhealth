<style>
    body {
        color: black;
    }
    
    .table {
        border-collapse: collapse;
        border: none;
        box-shadow: none;
    }
    
    .det th {
        font-weight: bold;
    }
    
    .det th, .det td {
        background-color: white;
        color: black;
        border: 1px solid black;
        padding: 3px;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			<div class="judulcontent"> <?php echo $judulLaporan  ?> </div>
                        <table class='table'>
    <tr>
        <td>No. Mutasi</td><td>:</td><td><?php echo CHtml::encode($modMutasi->nomutasibrg); ?></td>
        <td>Tgl. Mutasi</td><td>:</td><td><?php echo CHtml::encode($modMutasi->tglmutasibrg); ?></td>
    </tr>
    <tr>
        <td>Ruangan Rujuan</td><td>:</td><td><?php echo CHtml::encode($modMutasi->ruangantujuan->ruangan_nama); ?></td>
        <td>Create Time</td><td>:</td><td><?php echo CHtml::encode($modMutasi->create_time); ?></td>
    </tr> 
</table>

<table id="tableObatAlkes" class="det" width="100%">
    <thead>
        <th>No.Urut</th>
        <th>Tipe Barang</th>
        <th>Kode Barang</th>
        <th hidden>Golongan</th>
        <th hidden>Kelompok</th>
        <th hidden>Sub Kelompok</th>
        <th hidden>Sub Sub Kelompok</th>
        <th>Nama Barang</th>
        <th>Jumlah Mutasi</th>
        <th>Ukuran<br>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailMutasi AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $modBarang->barang_type; ?></td>
                <td><?php echo $modBarang->barang_kode; ?></td>
                <?php /*
                <td><?php echo isset($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:'-';  ?></td>
                <td><?php echo isset($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:'-'; ?></td>
                <td><?php echo isset($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:'-'; ?></td>
                <td><?php echo isset($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:'-'; ?></td>
                 * 
                 */ ?>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td style="text-align: right;"><?php echo $detail->qty_mutasi." ".$detail->satuanbrg; ?></td>
                <td><?php echo $modBarang->barang_ukuran; ?><br><?php echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
        $no++;
        endforeach;
    ?>
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table style="width: 100%; border: none;">
				<tr>
					<td width="35%" align="center">
						<div>Mengetahui,
                                               
						<div style="margin-top:60px;"><?php echo isset($modMutasi->pegmengetahui_id) ? $modMutasi->pegawaimengetahui->NamaLengkap : "" ?></div>
					</td>
					<td width="30%" align="center">
                        <div>Penyetujui,
                                               
						<div style="margin-top:60px;"><?php
                            if (empty($modMutasi->pegmenyetujui_id) && $modMutasi->ruangantujuan_id == Yii::app()->user->getState('ruangan_id')) {
                                echo CHtml::htmlButton('<i class="entypo-check"></i> Disetujui', array(
                                    'class'=>'btn btn-info',
                                    'onclick'=>'confirmMutasi();'
                                ));
                            } else {
                                echo isset($modMutasi->pegmenyetujui_id) ? $modMutasi->pegawaimenyetujui->NamaLengkap : "";
                            }
                        ?></div>
					</td>
					<td width="35%" align="center">
						<div>Pengirim<br></div>
						<div style="margin-top:60px;"><?php echo isset($modMutasi->pegpengirim_id) ? $modMutasi->pegawaipengirim->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
  
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
  
</div>
<?php if(isset($caraPrint)){
    
}else{ ?>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printMutasi&id='.$modMutasi->mutasibrg_id);
        $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php } ?>

<script>
function confirmMutasi() {
    myConfirm("Anda yakin untuk menyetujui mutasi ini?", "Peringatan Penyetujuan", function(r) {
        if (r == true) {
            $.post('<?php echo $this->createUrl('penyetujuanMutasi'); ?>', <?php echo CJSON::encode(array('id'=>$modMutasi->mutasibrg_id)); ?>, function(data) {
                if (data.ok == 1) {
                    myAlert(data.msg);
                    location.reload();
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}
</script><br>

