
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Master Paket Obat</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Paket Obat' => array('admin'),
                    $model->paketobat_id,
                );
                
                
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <div class="row-fluid">
                    <div class="col-sm-12">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                            'data' => $model,
                            'attributes' => array(
                                'paketobat_id',
                                array(
                                    'label'=>'Dokter',
                                    'type'=>'raw',
                                    'value'=>!empty($model->dokter_id)?$model->pegawai->namaLengkap:'',
                                ),
                                'nama_paket',                                
                            ),
                        ));
                        ?>
                    </div>
                    <div class="col-sm-12">
                        <table class="items table table-bordered table-striped table-condensed" id="table-obat">
                            <thead>
                                <th>No</th>
                                <th>Obat Alkes</th>
                                <th>Pemakaian</th>
                                <th>Satuan Kecil</th>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach($modDetail as $detail){
                                ?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php 
                                        
                                        echo !empty($detail->obatalkes_id)?$detail->obatalkes->obatalkes_nama:null;
                                    ?></td>
                                    <td><?php echo $detail->jumlah;?></td>
                                    <td>
                                        <?php
                                            echo !empty($detail->satuankecil_id)?$detail->satuankecil->satuankecil_nama:null;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Master Paket Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                        <?php $this->widget('UserTips', array('type' => 'view')); ?>
                    </div>
                </div>
            </div>
        </div>
    