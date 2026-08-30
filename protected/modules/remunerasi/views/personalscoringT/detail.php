<legend class="rim2">Personal Scoring Detail</legend>
<fieldset class="form-horizontal">
    <table class="table">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php // echo $form->textFieldRow($modPegawai,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('NIP','nip',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->nomorindukpegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->nama_pegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tempat lahir pegawai','',array('class'=>'control-label')) ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->tempatlahir_pegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. lahir pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->tgl_lahirpegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis kelamin','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->jeniskelamin,'') ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Status perkawinan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->statusperkawinan,''); ?></div>
                </div>
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Jabatan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->jabatan_id) ? CHtml::label($model->pegawai->jabatan->jabatan_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pangkat','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->pangkat_id) ? CHtml::label($model->pegawai->pangkat->pangkat_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pendidikan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->pendidikan_id) ? CHtml::label($model->pegawai->pendidikan->pendidikan_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Gaji pokok','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->gajipokok,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kategori pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->kategoripegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kategori pegawai asal','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->kategoripegawaiasal,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kelompok pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->kelompokpegawai_id) ? CHtml::label($model->pegawai->kelompokpegawai->kelompokpegawai_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Alamat pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->alamat_pegawai,''); ?></div>
                </div>
            </td>
            <td>
                <?php 
                    if(!empty($modPegawai->photopegawai)){
                        echo CHtml::image(Params::urlPegawaiTumbsDirectory().'kecil_'.$model->pegawai->photopegawai, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPegawaiDirectory().'no_photo.jpeg', 'Photo Pegawai', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </td>
        </tr>
    </table>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. penilaian','',array('class'=>'control-label')); ?>
            <div class="controls"><?php echo CHtml::label($model->tglscoring,''); ?></div>
        </div>
        <div class="control-group">
             <?php echo CHtml::label('Periode scoring','',array('class'=>'control-label')); ?>
            <div class="controls"><?php echo CHtml::label($model->periodescoring,''); ?></div>
        </div>
        <div class="control-label">
            <?php echo CHtml::label('Sampai dengan','',array('class'=>'control-label')); ?>
            <div class="controls"><?php echo CHtml::label($model->sampaidengan,''); ?></div>
        </div>
</fieldset>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kelompok</th>
            <th>Objek</th>
            <th>Index</th>
            <th>Bobot</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
<?php
    $modScoringdetail = ScoringdetailT::model()->findAllByAttributes(array('personalscoring_id'=>$model->personalscoring_id));
    $i=1;
    foreach ($modScoringdetail as $scoring)
    {
        $tr = '<tr>';
            $tr .= '<td>'.$i.'</td>';
            $tr .= '<td>'.$scoring->kelrem->kelrem_nama.'</td>';
            $tr .= '<td>'.$scoring->indexing->indexing_nama.'</td>';
            $tr .= '<td>'.$scoring->indexing->indexing_nilai.'</td>';
            $tr .= '<td>'.$scoring->ratebobot_personal.'</td>';
            $tr .= '<td>'.$scoring->score_personal.'</td>';
        $tr .= '</tr>';
        $i++;
        echo $tr;
    }
?>
    </tbody>
</table>