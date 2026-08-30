<table class="table table-condensed table-bordered table-striped" id="tabel-subkegiatan-list">
    <thead>
        <th>Program</th>
        <th>Kegiatan</th>
        <th>Sub Kegiatan</th>
        <th>Aksi</th>
    </thead>
    <tbody>
        <?php        
       
            if ($paket == 'nonpaket'){   
                
                echo $this->renderPartial('row/_rowSubKegiatan',array('model'=>$model, 'tipe'=>'new'), true);                                
            }
        ?>
    </tbody>
</table>