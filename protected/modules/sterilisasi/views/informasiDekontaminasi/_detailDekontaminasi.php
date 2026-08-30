<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<fieldset>
    <table class="items table table-striped table-condensed">
        <tr>
            <td>No. Dekontaminasi</td>
            <td>:</td>
            <td><?php echo isset($model->dekontaminasi_no) ? $model->dekontaminasi_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Dekontaminasi</td>
            <td>:</td>
            <td><?php echo isset($model->dekontaminasi_tgl) ? MyFormatter::formatDateTimeForUser($model->dekontaminasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Dekontaminasi</td>
            <td>:</td>
            <td><?php echo (isset($model->pegpetugas->NamaLengkap) ? $model->pegpetugas->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->dekontaminasi_ket) ? $model->dekontaminasi_ket : ""; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Penerimaan Sterilisasi</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Lama Dekontaminasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
				$disabled = false;
                foreach($modDetail AS $i=>$detail){ 
                    
                    $terima_det = PenerimaansterilisasidetT::model()->findByPk($detail->penerimaansterilisasidet_id);
                    $terima = new PenerimaansterilisasiT;
                    $alat = new PeralatansterilisasiM;
                    
                    if (!empty($terima_det)) {
                        $terima = PenerimaansterilisasiT::model()->findByPk($terima_det->penerimaansterilisasi_id);
                        $alat = PeralatansterilisasiM::model()->findByPk($terima_det->peralatansterilisasi_id);
                    }
                    
                    ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($terima) ? $terima->penerimaansterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo $alat->peralatansterilisasi_nama; ?></td>
                <td><?php echo (!empty($detail->dekontaminasidetail_jml) ? $detail->dekontaminasidetail_jml : ""); ?></td>
                <td><?php echo (!empty($detail->dekontaminasidetail_lama) ? $detail->dekontaminasidetail_lama : ""); ?></td>
            </tr>
            <?php    }
            }else{ $disabled = true; 
            ?>
			<tr>
				<td colspan="6">Data tidak ditemukan</td>
			</tr>
			<?php } ?>
        </tbody>
    </table>
</fieldset>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PDF\')')); 
?>
<script type="text/javascript">
function print(caraPrint)
{
    var dekontaminasi_id = '<?php echo isset($_GET['dekontaminasi_id']) ? $_GET['dekontaminasi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printDetail'); ?>&dekontaminasi_id='+dekontaminasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>
