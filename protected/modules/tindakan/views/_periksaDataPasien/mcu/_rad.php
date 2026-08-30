
<?php // if (isset($caraPrint)){ ?>
<style>
    th {
        border: 1px solid;        
        background-color: transparent;
    }
    .grid td{
        border: 1px solid;
        background-color: transparent;
    }
    th{
        text-align: center;
        font-size: 11pt;
    }
    table{
        width: 100%;
    }
    .title td{
        font-size: 12pt;
        text-align: center;
        font-weight: bold;
        padding: 5px;
        background: #309C5C;
    }
</style>

<div style="font-family:arial;font-size:10pt;">
    <b>
    <?php
        //echo $masukpenunjang->no_rekam_medik . '/' . $masukpenunjang->ruanganasal_nama . '/' . $masukpenunjang->kelaspelayanan_nama;
    ?>
    </b>
</div>
<br>

<table border="1" class="table table-bordered datatable">
        <tr>
        <th>No.</th>
        <th>Jenis Pemeriksaan</th>
        <th>Nama Pemeriksaan</th>
        <th>Hasil Expertise</th>
        <th>Kesimpulan</th>

    </tr>
        <?php 
        $row=1;
        foreach($detailHasil as $i=>$detail): 
            
        ?>
        <tr>
          
            <td><?php echo $row?></td>
            <td><?php echo $detail->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama   ?></td>
            <td><?php echo $detail->pemeriksaanrad->pemeriksaanrad_nama   ?></td>
            <td><?php echo $detail->hasilexpertise  ?></td>
            <td><?php echo $detail->kesimpulan_hasilrad?></td>
        </tr>
        <?php 
        $row++;
        endforeach; ?>
    </table>

<?php /*
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" width="50%">&nbsp;</td>
        <td align="center">PEMERIKSA</td>
    </tr>
    <tr>
        <td align="left">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            Printed By : <?=$masukpenunjang->getNamaPegawai(Yii::app()->user->getState('pegawai_id'))?> <?=date('d/m/Y H:i:s')?>
        </td>
        <td align="center">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>            
            <?=$masukpenunjang->getNamaLengkapDokter($masukpenunjang->pegawai_id)?>
        </td>
    </tr>
</table>
    <?php
    if($caraPrint != 'PRINT'){
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\');')); 
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-remove icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
    }
    ?>
<?php
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
function print(caraPrint)
{
    if(caraPrint == 'PRINT'){
    var jumlah = ${i};
    jumlah++;
    var i = 0;
        for(var i=0;i < jumlah;i++){
            var konfirm = confirm("Apakah Anda Akan Mencetak Pemeriksaan Ke-"+(i+1)+" dari "+jumlah+" pemeriksaan ?");
            if(konfirm)
                window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint,"",'location=_new, width=1024px');
        }
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
?>
 * 
 */?>
