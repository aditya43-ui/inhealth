<div class="body">
    <div class="flex-1 pt-2 pb-2 text-center fs-12 byclick hover active" data-id-form="form-model-antrian">
        <b>1. Jenis Antrian</b>
    </div>
    <div class="flex-2 pt-2 pb-2 text-center fs-12 byclick hover" data-id-form="form-poliklinik">
        <b>2. Poliklinik</b>
    </div> 
    <div class="flex-1 pt-2 pb-2 text-center fs-12 byclick hover" data-id-form="form-jenis-kunjungan">
        <b>3. Jenis Kunjungan</b>
    </div>    
    <div class="flex-1 pt-2 pb-2 text-center fs-12 byclick hover" data-id-form="form-dokter">
        <b>4. Dokter</b>
    </div>       
</div>
<div class="body-1">
    <div class="flex-1-100 pt-2 pb-2 flex form-pilihan" id="form-model-antrian">        
        <?= $this->renderPartial('daftarPasien/form/_jenisAntrian',['jenisAntrian'=>$jenisAntrian], true) ?>        
    </div>
    
    <div class="flex-1-100 pt-2 pb-2 flex form-pilihan hide" id="form-poliklinik">        
        <?= $this->renderPartial('daftarPasien/form/_poliklinik',['polilinik'=>$polilinik], true) ?>        
    </div>
    
    <div class="flex-1-100 flex form-pilihan hide" id="form-jenis-kunjungan">        
        <div class="flex-1-100 pt-2 pb-2 flex" data-jenis-kunjungan="default">
            <?= $this->renderPartial('daftarPasien/form/_jenisKunjungan',['jenisKunjungan'=>$jenisKunjungan], true) ?>        
        </div>
        
        <div class="flex-1-100 pt-2 pb-2 flex form-horizontal text-center" data-jenis-kunjungan="reservasi">
            <?= $this->renderPartial('daftarPasien/form/_jenisKunjunganReservasi',[], true) ?>        
        </div>
        <div class="flex-1-100 pt-2 pb-2 flex" data-jenis-kunjungan="fasttrack">
            <?= $this->renderPartial('daftarPasien/form/_jenisKunjunganFasttrack',[], true) ?>        
        </div>
        
    </div>
    
     <div class="flex-1-100 pt-2 pb-2 flex form-pilihan hide" id="form-dokter">        
        <?= $this->renderPartial('daftarPasien/form/_jenisAntrian',['jenisAntrian'=>$jenisAntrian], true) ?>        
    </div>
</div>