<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view untuk mengenerate detail kelahiran bayi per bayi
* RSST-1672
*/
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<table class="table noborder">
    <tr>
        <th>Tanggal Lahir</th>
        <td>: <?php echo MyFormatter::formatDateTimeForUser($modKelahiran->tgllahirbayi); ?></td>
        <td>&nbsp;</td>
        <th>Kelainan Bayi</th>
        <td>: <?php echo $modKelahiran->kelainanbayi; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>Nama</th>
        <td>: <?php echo $modKelahiran->namabayi; ?></td>
        <td>&nbsp;</td>
        <th>Warna Kulit</th>
        <td>: <?php echo $modKelahiran->warnakulit; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>Jenis Kelamin</th>
        <td>: <?php echo $modKelahiran->jeniskelamin; ?></td>
        <td>&nbsp;</td>
        <th>Denyut Jantung</th>
        <td>: <?php echo $modKelahiran->denyutjantung; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>Berat Badan</th>
        <td>: <?php echo $modKelahiran->bb_gram; ?> gram</td>
        <td>&nbsp;</td>
        <th>Aktifitas Otot</th>
        <td>: <?php echo $modKelahiran->aktivitasotot; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>Tinggi Badan</th>
        <td>: <?php echo $modKelahiran->tb_cm; ?> cm</td>
        <td>&nbsp;</td>
        <th>Respon Refleks</th>
        <td>: <?php echo $modKelahiran->responrefleks; ?></td>
        <td>&nbsp;</td>
    </tr>
     <tr>        
        <th>Lahir Tunggal</th>
        <td>: <?php echo !empty($modKelahiran->islahirtunggal)?'Tunggal':'Kembar ('.$modKelahiran->lahirkembar.')'; ?></td>
        <td>&nbsp;</td>
        <th>Pernapasan</th>
        <td>: <?php echo $modKelahiran->pernapasan; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>       
        <?php if ($modKelahiran->islahirtunggal == false){ ?>
        <th>Jumlah Kembar</th>
        <td>: <?php echo $modKelahiran->jmlkembar; ?></td>
        <td>&nbsp;</td>
        <th>Interpretasi</th>
        <td>: <?php echo $modKelahiran->interpretasi; ?></td>
        <td>&nbsp;</td>
        <?php }else{ ?>
            
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <th>Interpretasi</th>
        <td>: <?php echo $modKelahiran->interpretasi; ?></td>
        <td>&nbsp;</td>
        <?php } ?>
    </tr>
    <tr>       
        <?php if ($modKelahiran->islahirtunggal == false){ ?>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <th>Catatan Bayi</th>
        <td>: <?php echo $modKelahiran->catatan_bayi; ?></td>
        <td>&nbsp;</td>
        <?php }else{ ?>
            
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <th>Catatan Bayi</th>
        <td>: <?php echo $modKelahiran->catatan_bayi; ?></td>
        <td>&nbsp;</td>
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
            <th>Kriteria</th>
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