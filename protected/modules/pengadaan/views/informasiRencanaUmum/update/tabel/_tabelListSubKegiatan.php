<table class="table table-condensed table-bordered table-striped" id="tabel-subkegiatan-list">
    <thead>
        <th>Program</th>
        <th>Kegiatan</th>
        <th>Sub Kegiatan</th>        
    </thead>
    <tbody>
        <?php        
            $pro = PengadaanprogramT::model()->findAllByAttributes(array('rencanaumumpengadaan_id'=>$model->rencanaumumpengadaan_id));                                             
            if (!empty($pro)){
                foreach($pro as $det){
                    $det->subprogramkerja_nama = $det->subprogramkerja->subprogramkerja_nama;
                    $det->programkerja_nama = $det->programkerja->programkerja_nama;
                    $det->subkegiatanprogram_nama = $det->subkegiatanprogram->subkegiatanprogram_nama;
                    echo $this->renderPartial($this->path_view_ubah.'row/_rowSubKegiatan',array('model'=>$det, 'tipe'=>'new'), true);                                
                }
            }
            
        ?>
    </tbody>
</table>