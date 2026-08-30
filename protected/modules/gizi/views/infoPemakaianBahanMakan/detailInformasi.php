<style>
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }
    
    .table{
        box-shadow:none;
    }
        

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerRincian'); ?>
<table class='table' >
    <tr>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('no_pemakaianbhnmkn')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->no_pemakaianbhnmkn); ?>
        </td>
        <td>&nbsp;</td>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('ruanganpemakaibhnmkn')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode(isset($model->ruanganpemakaibhnmkn)?$model->ruangans->ruangan_nama:""); ?>
        </td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($model->getAttributeLabel('tglpemakaianbhnmkn')); ?></b>
        </td>
        <td>
            : <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($model->tglpemakaianbhnmkn)); ?>
        </td>
        <td>&nbsp;</td>
        <td>            
            <b><?php echo CHtml::encode($model->getAttributeLabel('untukkeperluan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->untukkeperluan); ?>            
        </td>
    </tr>    
             
</table>

<table id="tableObatAlkes" class="table border">
    <thead>
        <th>No. Urut</th>
        <th>Bahan Makanan</th>
        <th>Jumlah Pakai</th>
    </thead>
    <tbody>
    <?php
        $no=1;
        if(count((array)$modelDetail) > 0){
            foreach($modelDetail AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo isset($detail->bahanmakanan_id)?$detail->bahanmakanan->namabahanmakanan:""; ?></td>
                <td><?php echo $detail->jmlpemakaianbhnmkn; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;
        }else{
           ?>
            <tr>
                <td colspan="3">Data tidak ditemukan.</td>
            </tr>
            <?php
        }
             
    ?>
    </tbody>
</table>
<table class="table" width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" style="text-align:center;">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo isset($model->pegmengetahui_id)?$model->pegmengetahuis->namaLengkap:""; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
?>
<script type="text/javascript">
function print(caraPrint)
{
var id = <?php echo $_GET['id']; ?>;
var url = '<?php echo $this->createUrl("Print"); ?>';
    window.open(url+"&pemakaianbhnmkn_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>