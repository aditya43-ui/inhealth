<fieldset>
    <table class="items table table-striped table-bordered table-condensed">
        <tr>
            <td>No. penerimaan</td>
            <td>:</td>
            <td><?php echo isset($model->terimaperlinensteril_no) ? $model->terimaperlinensteril_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal penerimaan</td>
            <td>:</td>
            <td><?php echo isset($model->terimaperlinensteril_tgl) ? MyFormatter::formatDateTimeForUser($model->terimaperlinensteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai penerimaan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMenerima->NamaLengkap) ? $model->pegawaiMenerima->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->terimaperlinensteril_ket) ? $model->terimaperlinensteril_ket : ""; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
				$disabled = false;
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->penerimaansterilisasi->ruangan_id) ? $detail->penerimaansterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang->barang_id) ? $detail->barang->barang_id : ""); ?></td>
                <td><?php echo (!empty($detail->terimaperlinensterildet_jml) ? $detail->terimaperlinensterildet_jml : ""); ?></td>
                <td><?php echo (!empty($detail->terimaperlinensterildet_ket) ? $detail->terimaperlinensterildet_ket : ""); ?></td>
            </tr>
            <?php    }
            }else{ $disabled = false;
            ?>
			<tr>
				<td colspan="5">Data tidak ditemukan.</td>
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
    var terimaperlinensteril_id = '<?php echo isset($_GET['terimaperlinensteril_id']) ? $_GET['terimaperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printDetail'); ?>&terimaperlinensteril_id='+terimaperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>