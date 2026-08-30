<?php
$this->breadcrumbs = array(
    'tingkatrisiko Ms' => array('index'),
    $model->pejabatpengadaan_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Pejabat Pengadaan</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="span6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'label' => 'Periode',
                            'value' => !empty($model->periodeanggaran_id)?$model->periodeanggaran->anggaran_nama:null,
                        ),
                        array(
                            'label' => 'Jabatan',
                            'value' => $model->jabatan_pengadaan,
                        ),
                        array(
                            'label' => 'Nama Pegawai',
                            'value' => $model->pegawai->namaLengkap,
                        ),
                         array(
                            'label' => 'No SK',
                            'value' => $model->no_sk,
                        ),
                         array(
                            'label' => 'Tanggal SK',
                            'value' => MyFormatter::formatDateTimeForUser($model->tgl_sk),
                        ),
                        array(
                            'label' => 'File SK',
                            'type' => 'raw',
                            'value' => CHtml::link("<u>".$model->file_sk."</u>",$this->createUrl('unduhDok',array('id'=>$model->pejabatpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;', 'target'=>'_BLANK'))
                        ),
                        array(
                            'label' => 'Kode Dokumen',
                            'value' => $model->kode_dokumen,
                        ),
                    ),
                ));
                ?>
            </div>
            <div class="span6">
                <table id="table-insiden-detail" class="table table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <td colspan="2"><b>Bidang/Bagian/Instalasi</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($model->pejabatpengadaan_id)){                                                                                        
                                $cekDetail = PejabatpengadaandetM::model()->findAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));
                                foreach($cekDetail as $i => $det){                                                                                               
                                    echo $this->renderPartial('_rowDetail',array('modDet'=>$det, 'i'=>$i));
                                }                                                                                       
                            }
                        ?>
                    </tbody>
                </table>
                <table id="table-insiden-detail" class="table table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <td colspan="2"><b>Unit Kerja</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($model->pejabatpengadaan_id)){                                                                                        
                                $cekDetail = PejabatpengadaanunitM::model()->findAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));
                                foreach($cekDetail as $i => $det){                                                                                               
                                    echo $this->renderPartial('_rowDetailUnit',array('modDet'=>$det, 'i'=>$i));
                                }                                                                                       
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->pejabatpengadaan_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pejabat Pengadaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php $this->widget('UserTips', array('type' => 'view')); ?>
            </div>
        </div>
    </div>
</div>
