<!--
Data dibawah masih belum valid dikarenakan data di tabel penyusutanaset_v belum ada dan belum ada format yang ditentukan
-->
<?php if(isset($modPemakaianbarang)){ ?>
<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('nopemakaianbrg')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->nopemakaianbrg); ?>
            <br />
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('tglpemakaianbrg')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->tglpemakaianbrg); ?>
             <br/>
        </td>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('ruangan_id')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->ruangan->ruangan_nama); ?>
            <br />
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('untukkeperluan')); ?>:</b>
            <?php echo CHtml::encode($modPemakaianbarang->untukkeperluan); ?>
            <br />
        </td>
    </tr>   
</table>
<?php  } ?>
<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No. Urut</th>
        <th>Barang</th>
        <th>Jml Pakai</th>
        <th>Satuan</th>
        <th>Catatan</th>
    </thead>
    <tbody>
    <?php
	if(isset($modDetailPemakaian)){
        $no=1;
        foreach($modDetailPemakaian AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $detail->barang->barang_nama; ?></td>
                <td><?php echo $detail->jmlpakai; ?></td>
                <td><?php echo $detail->satuanpakai; ?></td>
                <td><?php echo $detail->catatanbrg; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;  
	}
    ?>
    </tbody>
</table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
?>
<script type="text/javascript">
function print(caraPrint)
{
var id = <?php echo $_GET['id']; ?>;
var url = '<?php echo $this->createUrl("Print"); ?>';
    window.open(url+"&pemakaianbarang_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>