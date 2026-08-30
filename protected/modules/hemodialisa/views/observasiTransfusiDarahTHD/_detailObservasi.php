<?php
$this->breadcrumbs = array(
    'Observasi Transfusi Darah HD',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'observasitransfusidarahhd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
//        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Observasi Transfusi Darah</div>
    </div>
    <div class="panel-body">
                <div class="span12 overflow-x">
                    <table class="table table-striped" id="tbl-observasitransfusi" style="width: 100%">
                        <tr>
                            <th>No. Kantong Darah</th>
                            <th>Tgl. Observasi</th>
                            <th>Jam Observasi</th>
                            <th>Reaksi Transfusi</th>
                            <th>Keluhan</th>
                            <th>Kesadaran</th>
                            <th>Tek. Darah (mmHg)</th>
                            <th>Nadi</th>
                            <th>Suhu(&#8451;)</th>
                            <th>Pernapasan</th>
                            <th>Lainnya (warna dan produksi urin)</th>
                            <th>Petugas Observasi</th>
                            <th></th>
                        </tr>
                        <tbody>
                            <?php if(count($modLoad) > 0) : ?>
                            <?php foreach ($modLoad as $key => $row) :
                                $model = ObservasiTransfusiDarahT::model()->findByPk($row['observasi_transfusi_darah_id']);
                                ?>
                                <tr class="tr-observasitransfusi" baris="<?= $key; ?>">
                                    <td>
                                        <?= CHtml::activeHiddenField($model, '[' . $key . ']kantong_transfusi_darah_det_id', array('readonly' => true, 'class' => 'span2', 'value'=>$row->kantong_transfusi_darah_det_id)); ?>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']no_kantongdarah', array('readonly' => true, 'class' => 'span2', 'value'=>$row->no_kantongdarah)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']tanggal_observasi', array('readonly' => true, 'class' => '', 'style' => 'width: 80px;', 'value'=>$row->tanggal_observasi)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']jam_observasi', array('readonly' => true, 'class' => '', 'style' => 'width: 80px;', 'value'=>$row->jam_observasi)); ?>
                                    </td>
                                    <td>
                                        <?php
                                            $reaksi = ReaksiTransfusiT::model()->findAll('observasi_transfusi_darah_id = '.$row->observasi_transfusi_darah_id);
                                            $str = "";
                                            if(!empty($reaksi)){
                                                foreach($reaksi as $no=>$value){
                                                    $str .= $value->nama_reaksi_transfusi.'-';
                                                }
                                            }
                                            
                                            if($str != ''){
                                                $str = substr($str, 0, -1);
                                            }
                                        ?>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']reaksi_transfusi', array('readonly' => true, 'class' => '', 'style' => 'width: 80px;', 'value'=>$str)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']keluhan', array('readonly' => true, 'class' => 'span2', 'value'=>$row->keluhan)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']kesadaran', array('readonly' => true, 'class' => 'span2', 'value'=>$row->kesadaran)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']tensi_sistolik', array('readonly' => true, 'class' => 'span1', 'value'=>$row->tensi_sistolik)); ?> /
                                        <?= CHtml::activeTextField($model, '[' . $key . ']tensi_diatolik', array('readonly' => true, 'class' => 'span1', 'value'=>$row->tensi_diatolik)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']nadi', array('readonly' => true, 'class' => 'span1', 'value'=>$row->nadi)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']suhu', array('readonly' => true, 'class' => 'span1', 'value'=>$row->suhu)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']pernapasan', array('readonly' => true, 'class' => 'span1', 'value'=>$row->pernapasan)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']lainnya', array('readonly' => true, 'class' => 'span2', 'value'=>$row->lainnya)); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::activeHiddenField($model, '[' . $key . ']petugas_observasi_id', array('readonly' => true, 'class' => 'span1', 'value'=>$row->petugas_observasi_id)); ?>
                                        <?php
                                            $nama = "";
                                            if(!empty($row->petugas_observasi_id)){
                                                $pegawai = PegawaiM::model()->findByPk($row->petugas_observasi_id);
                                                $nama = $pegawai->nama_pegawai;
                                            }
                                        ?>
                                        <?= CHtml::activeTextField($model, '[' . $key . ']petugas_observasi_nama', array('readonly' => true, 'class' => 'span3', 'value'=>$nama)); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
