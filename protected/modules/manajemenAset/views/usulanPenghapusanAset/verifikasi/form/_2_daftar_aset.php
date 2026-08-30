<div class="overflow-x">
    <table class="form-utama table table-bordered table-condensed table-striped" id="tabel-daftar-aset">        
        <thead>
            <tr>
                <th align="center">Nama Aset</th>
                <th align="center">Kode Aset</th>
                <th align="center">Merk</th>
                <th align="center">Tanggal Perolehan</th>
                <th align="center">Kondisi</th>
                <th align="center">Alasan</th>
                <th align="center">Disetujui</th>
                <th align="center">Catatan</th>                       
            </tr>
        </thead>
        <tbody class='form-body'>
            <?php                
                foreach($modDet as $i => $det){
                    $inv = $det->invperalatan;
                    $det->invperalatan_namabrg = $inv->invperalatan_namabrg;
                    $det->invperalatan_kode = $inv->invperalatan_kode;
                    $det->invperalatan_merk = $inv->invperalatan_merk;
                    $det->invperalatan_keadaan = $inv->invperalatan_keadaan;
                    $det->tanggal_perolehan = !empty($inv->tanggal_perolehan)?MyFormatter::formatDateTimeForUser($inv->tanggal_perolehan,'long'):'';
                    
                    echo $this->renderPartial($this->path_view.'verifikasi/row/_daftar_aset',['model'=>$det,'i'=>$i], true);
                }                
            ?>
        </tbody>
    </table>
</div>