<?php
/**
* - digunakan untuk menampilkan detail promosi pegawai
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>

<table class='table' style="border:none;">
    <tr>
        <td style="border:none;">
            <b> Tanggal SK</b>
        </td>
        <td style="border:none;">
            : <?php echo $model->prom_tglsk; ?>
        </td>
        <td style="border:none;">
            &nbsp;
        </td>
        <td style="border:none;">
            <b> Tanggal TMT SK</b>
        </td>
        <td style="border:none;">
            : <?php echo $model->prom_tmtsk; ?>
        </td>
    </tr>   
    <tr>
        <td style="border:none;">
            <b> No SK</b>
        </td>
        <td style="border:none;">
            : <?php echo $model->prom_nosk; ?>
        </td>
    </tr>   
    <tr>
        <td style="border:none;">
             <b>Nama Pegawai</b>
        </td>
        <td style="border:none;">
            : <?php echo $model->pegawai->namaLengkap; ?>
        </td>
                 
    </tr>   
    
</table>

<table id="tableObatAlkes" class="table border">
    <thead>    
        <tr>            
            <th>&nbsp;</th>            
            <th>Lama</th>
            <th>Baru</th>        
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b>Golongan</b></td>            
            <td><?php echo $model->prom_golongan_lama ?></td>
            <td><?php echo $model->prom_golongan_baru ?></td>
        </tr>
        <tr>
            <td><b>Jabatan</b></td>            
            <td><?php echo $model->prom_jabatan_lama ?></td>
            <td><?php echo $model->prom_jabatan_baru ?></td>
        </tr>
        <tr>
            <td><b>Pangkat</b></td>            
            <td><?php echo $model->prom_pangkat_lama ?></td>
            <td><?php echo $model->prom_pangkat_baru ?></td>
        </tr>
        <tr>
            <td><b>Unit Kerja</b></td>            
            <td><?php echo $model->prom_unitkerja ?></td>
            <td><?php echo $model->prom_lokasikerja_baru.'<br>'.$model->prom_unitkerja_baru ?></td>
        </tr>
    </tbody>      
</table>

<table class="table" style="text-align:center;">    
        <tr>
            <td width="30%" style="border:none;">

            </td>
            <td style="text-align: center;border:1px solid #000;">
                <b><?php echo empty($model->prom_status)?"DALAM PROSES":$model->prom_status;  ?></b>
            </td>
            <td width="30%" style="border:none;">

            </td>
        </tr>    
        <?php if (!empty($model->prom_status)){ ?>
        <tr>
            <td style="border:none;">
                &nbsp;
            </td>
            <td style="text-align: left;border:none;">                
                <b>Alasan : </b><br><?php echo $model->prom_alasan ?>
            </td>
            <td style="border:none;">
                &nbsp;
            </td>
        </tr> 
        <?php } ?>
</table>

<table class="table" style="text-align: center;">
    <tr>
        <td style="border:none;text-align: center;">
            Mengetahui
        </td>
        <td width = "60%" style="border:none;">
            &nbsp;
        </td>
        <td style="border:none;text-align: center;">
            Menyetujui
        </td>
    </tr>    
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border:none;border-top: 1px solid;text-align: center;">
            <?php echo $model->prom_mengetahui_nama ?>
        </td>
        <td style="border:none;">
            &nbsp;
        </td>
        <td style="border:none;border-top: 1px solid;text-align: center;">
            <?php echo $model->prom_pimpinan_nama ?>
        </td>
    </tr>
</table>