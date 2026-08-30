<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Monitoring Transfusi Darah</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">Jenis Waktu Monitoring</th>
                    <th rowspan="2">Tanggal Monitoring</th>
                    <th rowspan="2">Jam Monitoring</th>
                    <th rowspan="2">Jenis Darah</th>
                    <th rowspan="2">No. Kantong</th>
                    <th rowspan="2">Isi</th>
                    <th colspan="4">TTV</th>
                    <th rowspan="2">Nama Perawat/ Bidan</th>
                    <th rowspan="2">Reaksi<br>-/+ (Sebutkan)</th>
                    <th rowspan="2">Ubah</th>
                    <th rowspan="2">Hapus</th>
                </tr>
                <tr>
                    <th>TD<br>(mmHg)</th>
                    <th>Nadi<br>(x/menit)</th>
                    <th>RR<br>(x/menit)</th>
                    <th>Suhu<br>(&deg;C)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat as $item): ?>
                <tr>
                    <td><?php echo $item->monitoring_jeniswaktu; ?></td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($item->monitoring_tanggal); ?></td>
                    <td><?php echo $item->monitoring_jam; ?></td>
                    <td><?php 
                        $stok = StokkantongdarahT::model()->findByPk($item->stokkantongdarah_id);
                        if (!empty($stok)) {
                            $jenis = JeniskantongdarahM::model()->findByPk($stok->jeniskantongdarah_id);
                            
                            if (!empty($jenis)) {
                                echo $jenis->nama_jenis;
                            }
                            
                            $komponen = KomponendarahM::model()->findByPk($stok->komponendarah_id);
                            
                            if (!empty($komponen)) {
                                echo "<br>".$komponen->namaKomponenLengkap;
                            }
                            
                            echo "<br>".$stok->golongan_darah." ".$stok->rhesus;
                            
                        }
                    ?></td>
                    <td><?php echo $item->no_kantongdarah; ?></td>
                    <td><?php echo $item->isi_kantongdarah; ?></td>
                    <td><?php echo $item->ttv_tdsystolic." / ".$item->ttv_tddiastolic; ?></td>
                    <td><?php echo $item->ttv_nadi; ?></td>
                    <td><?php echo $item->ttv_respirasi; ?></td>
                    <td><?php echo $item->ttv_suhutubuh; ?></td>
                    <td><?php echo empty($item->petugasmonitoring) ? "-" : $item->petugasmonitoring->namaLengkap; ?></td>
                    <td>
                        <?php echo $item->reaksi_transfusi; ?>
                        <?php
                        if (!empty($item->reaksidetail_transfusi)) {
                            echo "<br>".$item->reaksidetail_transfusi;
                        }
                        
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('create', array(
                            'pendaftaran_id'=>$item->pendaftaran_id, 'pasienmasukpenunjang_id'=>$item->pasienmasukpenunjang_id, 'id'=>$item->monitoringtransfusidarah_id
                        )), array(
                            'rel'=>'tooltip',
                            'title'=>'Ubah data Monitoring',
                        )); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                            'onclick'=>'hapusMonitoring(this, '.$item->monitoringtransfusidarah_id.'); return false;',
                            'rel'=>'tooltip',
                            'title'=>'Hapus data Monitoring',
                        )); ?>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    
$urlPrint= $this->createUrl('print', array('pendaftaran_id'=>$model->pendaftaran_id));
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);   
        
        
        ?>
    </div>
</div>

<script>
    
    
    
    function hapusMonitoring(obj, id) {
        myConfirm("Anda yakin untuk menghapus data monitoring ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $(obj).parents("tr").remove();
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            
            }
        });
    }
    
</script>