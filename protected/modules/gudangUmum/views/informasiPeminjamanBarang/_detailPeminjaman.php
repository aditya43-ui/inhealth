<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel panel-heading">
            <div class="panel-title"> <b> Peminjaman </b> </div>
        </div>
        <div class="panel-body">
                <div class="control-group">		
                <?php echo CHtml::label("Tanggal Peminjaman<span class='required'>*</span>",'tglpengajuan_cuti', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="input-append">
                        <?php
                             echo $form->textField($model,'peminjamanbrg_tanggal',array('readonly'=>true,'class'=>'span3'))
                        ?>
                    </div>
                </div>
            </div>

            <div class="control-group">        
                <?php echo CHtml::label("Nama Peminjam <span class='required'>*<span>",'',array('class' => 'control-label')); ?>
                <div class="controls">            
                    <?php 
                        $model->pegpeminjam_nama = $model->pegpeminjam->nama_pegawai;
                        $model->nip = $model->pegpeminjam->nomorindukpegawai;
                        $peg = PegawaiM::model()->findByPk($model->pegpeminjam_id);
                        $model->jabatan_nama = $peg->jabatan->jabatan_nama;
                        $model->namaunitkerja = !empty($peg->unitkerja_id) ?  $peg->unitkerja->namaunitkerja : " ";
                        echo $form->textField($model,'pegpeminjam_nama',array('class'=>'span3', 'readonly'=>true,));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">NIP</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeTextField($model,'nip',array('class'=>'span3', 'readonly' => true));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Jabatan</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeTextField($model,'jabatan_nama',array('class'=>'span3', 'readonly' => true));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Unit Kerja</label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeTextField($model,'namaunitkerja',array('class'=>'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
               <div class="control-group">
                <label class="control-label">Nomor Peminjaman<span class="required">*</span></label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeTextField($model,'peminjamanbrg_nomor',array('readonly' => true, 'class'=>'span4'));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tanggal Peminjaman<span class="required">*</span></label>
                <div class="controls">
                    <?php
                        $model->tanggal_awal = MyFormatter::formatDateTimeForUser($model->tanggal_awal);
                        $model->tanggal_akhir = MyFormatter::formatDateTimeForUser($model->tanggal_akhir);
                        echo CHtml::activeTextField($model,'tanggal_awal',array('readonly' => true, 'class'=>'span2'));
                    ?>
                </div>
                <div class="controls">
                    <label>s/d</label>
                </div>
                <div class="controls">
                    <?php
                        echo CHtml::activeTextField($model,'tanggal_akhir',array('readonly' => true, 'class'=>'span2'));
                    ?>
                </div>
            </div>

            <div class="control-group">        
                <?php echo CHtml::label("Ruangan Peminjam<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php 
                        echo $form->textField($model->ruangan,'ruangan_nama',array('readonly'=>true,));
                    ?>
                </div>
            </div>    

            <div class="control-group">        
                <?php echo CHtml::label("Keperluan<span class='required'>*<span>",'',array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php 
                      echo CHtml::activeTextArea($model, 'peminjamanbrg_keperluan',array('class'=>'span3', 'readonly' => true));
                    ?>
                </div>
    </div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel panel-heading">
            <div class="panel-title"> <b> Pengembalian</b> </div>
        </div>
        <div class="panel-body">
            <div class="control-group">        
                <?php echo CHtml::label("Pegawai Mengembalikan <span class='required'>*<span>",'',array('class' => 'control-label')); ?>
                <div class="controls">            
                    <?php 
                        $pg = PegawaiM::model()->findByPk($model->pegpengembali_id);
                        $model->pengembali = !empty($model->pegpengembali_id) ? $pg->nama_pegawai: " ";
                        $model->pengembalian_tanggal = !empty($model->pengembalian_tanggal) ? MyFormatter::formatDateTimeForUser($model->pengembalian_tanggal):" ";
                        $model->pengembalian_catatan = !empty($model->pengembalian_catatan) ? $model->pengembalian_catatan : " "; 
                        echo $form->textField($model,'pengembali',array('class'=>'span3', 'readonly'=>true,));
                    ?>
                </div>
            </div>
            <div class="control-group">        
                <?php echo CHtml::label("Tanggal Pengembalian <span class='required'>*<span>",'',array('class' => 'control-label')); ?>
                <div class="controls">            
                    <?php
                        echo $form->textField($model,'pengembalian_tanggal',array('class'=>'span3', 'readonly'=>true,));
                    ?>
                </div>
            </div>
            <div class="control-group">        
                <?php echo CHtml::label("Keterangan <span class='required'>*<span>",'',array('class' => 'control-label')); ?>
                <div class="controls">            
                    <?php
                        echo $form->textArea($model,'pengembalian_catatan',array('class'=>'span3', 'readonly'=>true,));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>