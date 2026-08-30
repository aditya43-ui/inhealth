<div class="col-sm-12">    
    <div id="form-lanjutan">
        <div class="control-group">        
            <?php echo CHtml::label("Program",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php 
                    echo CHtml::activeHiddenField($model, 'programkerja_id', array('readonly' => true));
                    echo CHtml::activeTextField($model, 'programkerja_nama', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required')); 
                ?>
            </div>
        </div>

        <div class="control-group">        
            <?php echo CHtml::label("Kegiatan",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php 
                    echo CHtml::activeHiddenField($model, 'subprogram_id', array('readonly' => true));
                    echo CHtml::activeTextField($model, 'subprogramkerja_nama', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required'));
                ?>
            </div>
        </div>
        
        <div class="control-group">        
            <?php echo CHtml::label("Sub Kegiatan",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php                     
                    echo CHtml::activeTextField($model, 'subkegiatanprogram_nama', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required'));
                ?>
            </div>
        </div>

        <div class="control-group">        
            <?php echo CHtml::label("Nama Pekerjaan",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <?php echo CHtml::activeTextField($model, 'nama_pekerjaan', array('style'=>'width:100% !important;','readonly' => true, 'class' => 'span3 required')) ?>
            </div>
        </div>
        
        <div class="control-group">        
            <?php echo CHtml::label("Kode Rekening",'',array('class' => 'control-label')); ?>
            <div class="controls" style="width:77%">            
                <div id="sumberdana">
                    <?php
                    $tblSumberdana = "";
                    $modPengadaanSumberDana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $modRencana->rencanaumumpengadaan_id));
                    if(count($modPengadaanSumberDana)){
                        $tblSumberdana .= "<table class='table table-condensed table-bordered table-striped'>";
                        $tblSumberdana .= "
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Sumber Dana</th>
                                    <th>Nilai Pagu</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                        foreach ($modPengadaanSumberDana as $key => $value) {
                            $kegiatan_kode = '';
                            $kegiatan_nama = '';
                            if (!empty($value->mappingrekeninganggaran_id)) {
                                $modProgram = MappingrekeninganggaranM::model()->findByPk($value->mappingrekeninganggaran_id);
                                $kegiatan_kode = $modProgram->kodeanggaran;
                                $kegiatan_nama = $modProgram->nama_rekeninganggaran5;
                            }
                            $tblSumberdana .= "<tr>";
                            $tblSumberdana .= "<td>".$kegiatan_kode."</td>";
                            $tblSumberdana .= "<td>".$kegiatan_nama."</td>";
                            $tblSumberdana .= "<td>".$value->asal_dana."</td>";
                            $tblSumberdana .= "<td style='text-align: right'>".number_format($value->pagu,2)."</td>";
                            $tblSumberdana .= "</tr>";
                        }
                        $tblSumberdana .= "</tbody></table>";
                    }
                    echo $tblSumberdana;
                    ?>
                </div>
            </div>
        </div>

        <div class="control-group">        
            <?php echo CHtml::label("Pagu dari DPA",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php echo CHtml::activeTextField($modPersiapan, 'dpa_pagu', array('readonly' => true, 'class' => 'integer2 required')) ?>
            </div>
        </div>
        <div class="control-group">        
            <?php echo CHtml::label("Kode SIRUP ",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php echo CHtml::activeTextField($modPersiapan, 'kode_sirup', array('readonly' => true, 'class' => '')) ?>
            </div>
        </div>  
    </div>
    
    <?php
        if($modRencana->rencanaumumpengadaan_kategori == 'Penyedia'){
    ?>
    <div id="form-penyedia">
        <div class="control-group">        
            <?php echo CHtml::label("Jenis Pengadaan",'',array('class' => 'control-label')); ?>
            <div class="controls">    
                <?php echo CHtml::activeTextField($model, 'daftarjenispengadaan', array('readonly' => true, 'class' => '')) ?>
            </div>
        </div>
        
        <div class="control-group">        
            <?php echo CHtml::label("Metode Pengadaan",'',array('class' => 'control-label')); ?>
            <div class="controls">            
                <?php 
                    echo CHtml::activeTextField($model, 'metodepengadaan_nama',  array( 'class' => '','readonly'=>true)); 
                    
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Pemanfaatan Barang/Jasa</label>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pemanfaatanbarang_tglawal',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pemanfaatanbarang_tglakhir',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
        </div>                
        <div class="control-group">
            <label class="control-label">Pelaksanaan <span id="judul-tanggal">Pekerjaan</span></label>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pelaksanaankontrak_tglawal',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pelaksanaankontrak_tglakhir',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Pelaksanaan Pemilihan Penyedia</label>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pemilihanpenyedia_tglawal',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pemilihanpenyedia_tglakhir',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
        </div> 
        
    </div>                    
    <?php
        }else if($modRencana->rencanaumumpengadaan_kategori == 'Swakelola'){
    ?>
    <div id="form-swakelola" >
        <div class="control-group">        
            <?php echo CHtml::label("Tipe Swakelola",'',array('class' => 'control-label')); ?>
            <div class="controls">        
                <?php 
                    echo CHtml::activeTextField($model,'swakelola_tipe',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
        </div>                                
    </div>   
    
    <div id="form-tanggalkontrak">
        <div class="control-group">
            <label class="control-label">Pelaksanaan <span id="judul-tanggal">Pekerjaan</span></label>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pelaksanaankontrak_tglawal',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
            <div class="controls">
                <label>/</label>
            </div>
            <div class="controls">
                <?php 
                    echo CHtml::activeTextField($model,'pelaksanaankontrak_tglakhir',array('readonly' => true,'class'=>'span3'));
                ?>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</div>