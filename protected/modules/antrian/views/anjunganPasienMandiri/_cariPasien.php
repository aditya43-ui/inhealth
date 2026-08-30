<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Cari Data Pasien
        </div>
    </div>
    <div class="panel-body" id="panel_form_cari_pasien">
        <div class="control-group">
            <label class="control-label">No. Rekam Medis</label>
            <div class="controls">
                <?php echo CHtml::textField('cari_no_rekam_medik', '', array(
                    'class'=>'span3',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Lahir</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'name' => 'cari_tanggal_lahir',
                    'value' => '',
                    'mode' => 'date',
                    'options' => array(
                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'autocomplete' => 'off', 'style' => '', 'placeholder' => '00/00/0000', 'class' => 'form-control dtPicker2 datemask span3', 'onblur' => 'setUmur(this.value);' . (!empty($modPasien->cekinap) ? 'setRawatGabung();' : ''), 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
                'class'=>'btn btn-success', 'onclick'=>'cariPasien();', 'id'=>'btn_cari_pasien'
            )); ?>
        </div>
    </div>
</div>
<br/>
<div class="row-fluid" style="text-align: center">
    <?php echo CHtml::htmlButton("<i class='entypo-home'></i>Kembali ke Halaman Awal", array(
        'class'=>'btn btn-info', 'onclick'=>"kembaliKeHalamanAwal();"
    )); ?>
</div>



<script>
    function cariPasien() {
        var no_rm = $("#cari_no_rekam_medik").val();
        var tgl = $("#cari_tanggal_lahir").val();

        $("#panel_form_cari_pasien").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('GetDataPasien'); ?>', {no_rm: no_rm, tgl: tgl}, function(data) {
            
            if (data.kosong) {
                myAlert("Pasien Tidak Ditemukan");
                $("#panel_form_cari_pasien").removeClass("animation-loading");
                return false;
            }
            
            if (data.lebih) {
                myAlert("No. RM digunakan untuk hitungan otomatis. Pilih antara 000001 - 347499");
                $("#panel_form_cari_pasien").removeClass("animation-loading");
                $("#no_rekam_medik_baru").val("");
                return false;
            }

            <?php // if ($this->id == "pendaftaranRawatInap"): ?>

            if (data.adaInap) {
                myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang dirawat inap di " + data.listDaftar.ruangan.ruangan_nama + ".");
                $("#panel_form_cari_pasien").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                setPasienBaru();
                isSetLama = false;
                return false;
            }
            if (data.tindakLanjut) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                    Hari ini menunggu tindak lanjut ke rawat inap di " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#panel_form_cari_pasien").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
            if (data.adaDaftar) {
                myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang di instalasi " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + " dengan status pemeriksan '"
                + data.listDaftar.statusperiksa + "'.");
                $("#panel_form_cari_pasien").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modPasien,'nama_pasien');?>").val("");
                setPasienBaru();
                isSetLama = false;
                return false;
            }

            <?php //    endif; ?>

            if(data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF?>"){
				$("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                $(".input_no_rekam_medik").val(data.no_rekam_medik);
                $(".input_pasien_id").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPasien,"jenisidentitas");?>").val(data.jenisidentitas);
                $("#<?php echo CHtml::activeId($modPasien,"no_jamkespa");?>").val(data.no_jamkespa);
                $("#<?php echo CHtml::activeId($modPasien,"no_identitas_pasien");?>").val(data.no_identitas_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"namadepan");?>").val(data.namadepan);
                $("#<?php echo CHtml::activeId($modPasien,"nama_pasien");?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"nama_bin");?>").val(data.nama_bin);
                $("#<?php echo CHtml::activeId($modPasien,"tempat_lahir");?>").val(data.tempat_lahir);
                $("#<?php echo CHtml::activeId($modPasien,"nama_ayah");?>").val(data.nama_ayah);
                $("#<?php echo CHtml::activeId($modPasien,"nama_ibu");?>").val(data.nama_ibu);
                $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.tanggal_lahir);
                $("#<?php echo CHtml::activeId($modPasien,"kelompokumur_id");?>").val(data.kelompokumur_id);
                $("#<?php echo CHtml::activeId($modPasien,"statusperkawinan");?>").val(data.statusperkawinan);
                $("#<?php echo CHtml::activeId($modPasien,"golongandarah");?>").val(data.golongandarah);
                $("#<?php echo CHtml::activeId($modPasien,"rhesus");?>").val(data.rhesus);
                $("#<?php echo CHtml::activeId($modPasien,"alamat_pasien");?>").val(data.alamat_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"rt");?>").val(data.rt);
                $("#<?php echo CHtml::activeId($modPasien,"rw");?>").val(data.rw);
                $("#<?php echo CHtml::activeId($modPasien,"no_telepon_pasien");?>").val(data.no_telepon_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"no_mobile_pasien");?>").val(data.no_mobile_pasien);
                $("#<?php echo CHtml::activeId($modPasien,"suku_id");?>").val(data.suku_id);
                $("#<?php echo CHtml::activeId($modPasien,"alamatemail");?>").val(data.alamatemail);
                $("#<?php echo CHtml::activeId($modPasien,"anakke");?>").val(data.anakke);
                $("#<?php echo CHtml::activeId($modPasien,"jumlah_bersaudara");?>").val(data.jumlah_bersaudara);
                $("#<?php echo CHtml::activeId($modPasien,"pendidikan_id");?>").val(data.pendidikan_id);
                $("#<?php echo CHtml::activeId($modPasien,"pekerjaan_id");?>").val(data.pekerjaan_id);
                $("#<?php echo CHtml::activeId($modPasien,"agama");?>").val(data.agama);
                $("#<?php echo CHtml::activeId($modPasien,"warga_negara");?>").val(data.warga_negara);
                $("#<?php echo CHtml::activeId($modPasien,"is_ambilfoto");?>").val(0);

                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                if(data.photopasien != null && data.photopasien != ""){ //set photo
                    $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }

                setJenisKelaminPasien(data.jeniskelamin);
                setRhesusPasien(data.rhesus);
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                setUmur(data.tanggal_lahir);

                $(".input_lama").show();
                setFormPanel("form_pasien");

                

            }else{
                if(confirm("Apakah anda akan menggunakan No. Rekam Medik Non-Aktif ?")){
                    $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modPasien,'pasien_id');?>").val(data.pasien_id);
                }
            }
            $("#panel_form_cari_pasien").removeClass("animation-loading");
        }, 'json');
    }
</script>

