<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view untuk mengenerate detail kelahiran bayi per bayi
* RSST-1672
*/
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<style>
    .tab_header {
        width: 100%;
    }
    
    .tab_header th, .tab_header td {
        padding: 3px;
        vertical-align: top;
    }
    
</style>

<table class="tab_header">
    <tr>
        <th nowrap>Tanggal Lahir</th>
        <td width="100%">: <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modKelahiran->tgllahirbayi))." ".$modKelahiran->jamlahir); ?></td>
        <td>&nbsp;</td>
        <th>Kelainan Bayi</th>
        <td nowrap>: <?php echo $modKelahiran->kelainanbayi; ?></td>
    </tr>
    <tr>
        <th>Nama</th>
        <td>: <?php echo $modKelahiran->namabayi; ?></td>
        <td>&nbsp;</td>
        <th>Warna Kulit</th>
        <td nowrap>: <?php echo $modKelahiran->warnakulit; ?></td>
    </tr>
    <tr>
        <th nowrap>Jenis Kelamin</th>
        <td>: <?php echo $modKelahiran->jeniskelamin; ?></td>
        <td>&nbsp;</td>
        <th nowrap>Denyut Jantung</th>
        <td nowrap>: <?php echo $modKelahiran->denyutjantung; ?></td>
    </tr>
    <tr>
        <th>Berat Badan</th>
        <td>: <?php echo $modKelahiran->bb_gram; ?> gram</td>
        <td>&nbsp;</td>
        <th>Aktifitas Otot</th>
        <td nowrap>: <?php echo $modKelahiran->aktivitasotot; ?></td>
    </tr>
    <tr>
        <th>Tinggi Badan</th>
        <td>: <?php echo $modKelahiran->tb_cm; ?> cm</td>
        <td>&nbsp;</td>
        <th nowrap>Respon Refleks</th>
        <td nowrap>: <?php echo $modKelahiran->responrefleks; ?></td>
    </tr>
     <tr>        
        <th nowrap>Lahir Tunggal</th>
        <td>: <?php echo !empty($modKelahiran->islahirtunggal)?'Tunggal':'Kembar ('.$modKelahiran->lahirkembar.')'; ?></td>
        <td>&nbsp;</td>
        <th>Pernapasan</th>
        <td nowrap>: <?php echo $modKelahiran->pernapasan; ?></td>
    </tr>
    <tr>       
        <?php if ($modKelahiran->islahirtunggal == false){ ?>
        <th nowrap>Jumlah Kembar</th>
        <td>: <?php echo $modKelahiran->jmlkembar; ?></td>
        <td>&nbsp;</td>
        <th>Interpretasi</th>
        <td nowrap>: <?php echo $modKelahiran->interpretasi; ?></td>
        <?php }else{ ?>
            
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <th>Interpretasi</th>
        <?php } ?>
    </tr>
    <tr>       
        <?php if ($modKelahiran->islahirtunggal == false){ ?>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <th nowrap>Catatan Bayi</th>
        <td nowrap>: <?php echo $modKelahiran->catatan_bayi; ?></td>
        <?php }else{ ?>
            
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <th nowrap>Catatan Bayi</th>
        <td nowrap>: <?php echo $modKelahiran->catatan_bayi; ?></td>
        <?php } ?>
    </tr>
</table>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>     
<?php $i = 1; ?>
<br>
        <?php foreach($modApghar as $row){ ?>
            
<label>Menit Ke-<?php echo $row['menitke']; ?></label>
<table class="table border">
    <thead>
        <tr>
            <!--<th>ID</th>-->
            <th width="250">Kriteria</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        
        
        <?php $i = 1; ?>
        <?php foreach($row['det'] as $row2){ ?>
            <tr>
                <!--<td><?php //echo $i; ?></td>-->
                <td><?php echo $row2['kriteria']; ?></td>
                <?php $nilai = 'nilai_'.$row2['nilai_apgar'];?>
                <td><?php echo $row2[$nilai]; ?></td>
                
  
                <?php $i++; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<br>
<?php } ?>

<?php echo CHtml::htmlButton('<i class="entypo-print"></i> Print Formulir Identifikasi Bayi', array(
    'class'=>'btn btn-info',
    'onclick'=>'printFormulirBayi('.$modKelahiran->kelahiranbayi_id.');'
))." ".CHtml::htmlButton('<i class="entypo-pencil"></i> Surat Keterangan Lahir', array(
    'class' => 'btn btn-danger',
    'onclick'=>'setSuratKeteranganLahir('.$modKelahiran->kelahiranbayi_id.');'
)); ?>

<br>
<br>
<script>
function printFormulirBayi(kelahiranbayi_id)
{
   window.open('<?php echo $this->createUrl('FormuliIdentitasBayiCapJari'); ?>&kelahiranbayi_id='+kelahiranbayi_id,'printwin','left=100,top=100,width=1000,height=1000');    
}
function setSuratKeteranganLahir(kelahiranbayi_id)
{
   window.location.href = '<?php echo Yii::app()->createUrl('/persalinan/SuratKeteranganLahirPS/cetakSuratKelarihan'); ?>&kelahiranbayi_id='+kelahiranbayi_id;    
}
</script>