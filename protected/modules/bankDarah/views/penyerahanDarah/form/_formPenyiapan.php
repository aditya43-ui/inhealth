<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Nomor Kantong Darah</th>
            <th>Petugas Lab Referal</th>
            <th>Tgl. Referal</th>
            <th>Petugas Pelabelan</th>
            <th>Tgl. Pelabelan</th>
        </tr>
    </thead>
    <tbody id="tab_penyiapan">
        <?php 
        
        
        
        foreach ($penyiapan as $row => $model): 
            $item = UjikompatibilitasT::model()->findByPk($model->ujikompatibilitas_id);
            $submodel = PenyiapandarahT::model()->findByAttributes(array(
                'ujikompatibilitas_id'=>$item->ujikompatibilitas_id
            ));
            $stok = StokkantongdarahT::model()->findByPk($item->stokkantongdarah_id);
            $jenis = JeniskantongdarahM::model()->findByPk($stok->jeniskantongdarah_id);
            
            
            $model->tgl_referal = MyFormatter::formatDateTimeForUser($model->tgl_referal);
            $model->tglpelabelan = MyFormatter::formatDateTimeForUser($model->tglpelabelan);
            $model->tglpenyiapandarah = MyFormatter::formatDateTimeForUser($model->tglpenyiapandarah);

            $pegReferal = PegawaiM::model()->findByPk($model->peg_referal_id);
            $pegPelabelan = PegawaiM::model()->findByPk($model->peg_pelabelan);
            $pegTerima = PegawaiM::model()->findByPk($model->peg_penerimapermintaan_id);

            if (!empty($pegReferal)) {
                $model->peg_referal_nama = $pegReferal->nama_pegawai;
            }

            if (!empty($pegPelabelan)) {
                $model->peg_pelabelan_nama = $pegPelabelan->nama_pegawai;
            }

            if (!empty($pegTerima)) {
                $model->peg_penerimapermintaan_nama = $pegTerima->nama_pegawai;
            }
        ?>
        <tr>
            <td><?php echo $item->nomorbarcode; ?></td>
            <td><?php echo $model->peg_referal_nama; ?></td>
            <td><?php echo $model->tgl_referal; ?></td>
            <td><?php echo $model->peg_pelabelan_nama; ?></td>
            <td><?php echo $model->tglpelabelan; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php

if (empty($model)) {
    $model = new PenyiapandarahT;
}

?>
<div class="col-sm-6">
    <div class="control-group">
        <?php 
        echo CHtml::activeLabel($model, 'tglpenyiapandarah', array('class' => 'control-label')) ?>
        
        <div class="controls">
            <?php
            echo CHtml::textField('tglpenyiapandarah', $model->tglpenyiapandarah, array(
                'readonly'=>true
            )); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::activeLabel($model, 'peg_penerimapermintaan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('peg_penerimapermintaan_nama', $model->peg_penerimapermintaan_nama, array(
                'readonly'=>true,
            )); ?>
        </div>
    </div>
</div>
<div class="clear"></div>

