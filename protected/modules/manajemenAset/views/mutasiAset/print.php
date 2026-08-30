<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - menampilkan detail data
* RSST-1620
*/

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>3));  
?>

<table class="table noborder">
    <tr>
        <td><b>Tanggal Mutasi</b></td>
        <td><?php echo MyFormatter::formatDateTimeForUser($model->tglmutasiaset); ?></td>
        <td>&nbsp;</td>
        <td><b>Nomor Mutasi</b></td>
        <td><?php echo $model->nomutasiaset; ?></td>
    </tr>
    <tr>
        <td><b>Unit Kerja Asal</b></td>
        <td>
            <?php 
                // digunakan untuk meload data unit kerja asal berdasarkan ruangannya (jika ada lebih dari 1, akan ditampilkan semua)
                $cri = new CDbCriteria();
                $cri->join = " JOIN unitkerja_m u ON u.unitkerja_id = t.unitkerja_id ";
                $cri->addCondition(" t.ruangan_id = '".$model->ruanganasal_id."' AND u.unitkerja_aktif = TRUE ");
                $unit = UnitkerjaruanganM::model()->findAll($cri);
                
                if (!empty($unit)){
                    if (count($unit)>1){
                        echo '<ul>';
                        foreach($unit as $u){
                            echo '<li>'.$u->unitkerja->namaunitkerja.'</li>';
                        }
                        echo '</ul>';
                    }else{
                        foreach($unit as $u){
                            echo $u->unitkerja->namaunitkerja;
                        }
                    }
                }
                
            ?>
        </td>
        <td>&nbsp;</td>
        <td><b>Uni Kerja Tujuan</b></td>
        <td>
            <?php 
                // digunakan untuk meload data unit kerja tujuan berdasarkan ruangannya (jika ada lebih dari 1, akan ditampilkan semua)
                $cri = new CDbCriteria();
                $cri->join = " JOIN unitkerja_m u ON u.unitkerja_id = t.unitkerja_id ";
                $cri->addCondition(" t.ruangan_id = '".$model->ruangantujuan_id."' AND u.unitkerja_aktif = TRUE ");
                $unit = UnitkerjaruanganM::model()->findAll($cri);
                
                if (!empty($unit)){
                    if (count($unit)>1){
                        echo '<ul>';
                        foreach($unit as $u){
                            echo '<li>'.$u->unitkerja->namaunitkerja.'</li>';
                        }
                        echo '</ul>';
                    }else{
                        foreach($unit as $u){
                            echo $u->unitkerja->namaunitkerja;
                        }
                    }
                }
            ?>
        </td>
    </tr>
    <tr>
        <td><b>Ruangan Asal</b></td>
        <td><?php echo $model->ruanganasal->ruangan_nama; ?></td>
        <td>&nbsp;</td>
        <td><b>Ruangan Tujuan</b></td>
        <td><?php echo $model->ruangantujuan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td width="20%"><b>Pegawai Menyerahkan</b></td>
        <td><?php echo (!empty($model->pegmenyerahkan_id))?$model->pegmenyerahkan->namaLengkap:null; ?></td>
        <td>&nbsp;</td>
        <td width="20%"><b>Pegawai Penerima</b></td>
        <td><?php echo (!empty($model->pegpenerima_id))?$model->pegpenerima->namaLengkap:null; ?></td>
    </tr>
</table>


<table class="table border">
    <tr>
        <th>No</th>
        <th>Nama Aset</th>
        <th>Nomor Aset</th>
        <th>Keadaan</th>
        <th>Keterangan</th>
    </tr>
    <?php 
        if (!empty($detail)){
            $i = 1;
            foreach ($detail as $det){
                $mutasiaset = MutasiasetperalatanT::model()->findByAttributes(array('mutasiaset_id'=>$det->mutasiaset_id));
    ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $det->invperalatan_namabrg; ?></td>
        <td><?php echo $det->invperalatan_kode; ?></td>
        <td><?php 
            if(!empty($mutasiaset)){
                echo $mutasiaset->mutasi_keadaan;
            }else{
                echo ' ';
            }
            //echo $det->mutasi_keadaan; 
         ?></td>
        <td>
            <?php 
            if(!empty($mutasiaset)){
                echo $mutasiaset->ket_mutasi;
            }else{
                echo ' ';
            }
            //echo $det->ket_mutasi; 
         ?></td>
    </tr>
    <?php
            $i++;
            }
        }
    ?>
</table>


