<script type='text/javascript'>
   
    const setTab = (obj) => {
        
        $(obj).parents("ul").find("li").each(function() {
            $(this).removeClass("active");
        });
        
        $(obj).addClass("active");
        
        const url = $(obj).attr("tab");
        const id = $(obj).attr("id");
        
        generateForm(url, 'setform', id);
    }
    
    const generateForm = (url, jenis = 'setform', id) => {
        const pendaftaran_id = '<?= isset($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:'' ?>';
        const pasienadmisi_id = '<?= isset($_GET['pasienadmisi_id'])?$_GET['pasienadmisi_id']:'' ?>'
        
        if ( (id == 'ulang-rjrd') && jenis == 'simpan'){
            CKEDITOR.instances.masalahpsiko.updateElement();
        }else if ( (id == 'ulang-ri') && jenis == 'simpan'){
            CKEDITOR.instances.kesimpulan.updateElement();
        }
        
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                jenis,
                form:$("#asesmen-ulang-form").serialize(),
                pendaftaran_id,
                pasienadmisi_id,
            },
            dataType: "json",
            success: function(data) {
                $("#form-panel-asesmen-ulang").html(data.html);
                if (jenis == 'simpan'){
                    if (data.sukses == 1){
                        window.parent.Notiflix.Report.Success("Perhatian!","Data berhasil disimpan!","OK");
                    }else{
                        window.parent.Notiflix.Report.Failure("Perhatian!","Data gagal disimpan!","OK");
                    }
                }else{
                    if (data.sukses == 2){
                        window.parent.Notiflix.Report.Failure("Perhatian!",data.pesan,"OK");
                        return false;
                    }
                }
                
                if (id == 'ulang-rjrd' || id == 'ulang-ri'){
                    let idckeditor = 'masalahpsiko';
                    if (id == 'ulang-ri'){
                        idckeditor = 'kesimpulan';
                    }
                    CKEDITOR.replace(idckeditor, {
                        extraPlugins: 'colorbutton,colordialog',
                        toolbarGroups: [
                            {
                                "name": "basicstyles",
                                "groups": ["basicstyles", "align", "spacings", "colors"]
                            },
                            {
                                "name": "paragraph",
                                "groups": ["list", "blocks"]
                            },
                            {
                                "name": "styles",
                                "groups": ["styles"]
                            }
                        ]
                    });
                    
                    if (id == 'ulang-rjrd'){
                        cekSumber();
                    }
                    
                    createGridRiwayat(url);
                                        
                    refreshRiwayat(id,pendaftaran_id);
                }
                $(".btn-simpan").attr("onclick","generateForm('"+url+"','simpan','"+id+"')");
                                                
                setTimeout(function(){
                    var frameObj = window.parent.document.getElementById("frame");               
                    $(frameObj).parent().removeClass("animation-loading");
                    window.parent.resizeIframe(frameObj);
                }, 1000);                               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    const cekSumber = () => {
        const sumber = $(".sumber:checked").val();
        
        $(".sumber_text").addClass('hide');
        if (sumber == 'pasien'){
            $(".sumber_nama_pasien").removeClass("hide");
        }else if (sumber == 'keluarga'){
            $(".sumber_nama_keluarga").removeClass("hide");
        }
    }
    
    const hapus = (id, obj) => {    
        window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    type: 'POST',
                    url: $(obj).attr("data-url"),
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == '1') {                            
                            refreshRiwayat();                                             
                        }else{
                            window.parent.Notiflix.Report.Failure("Data gagal dihapus","Perhatian!","OK");
                        }                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
    
    const createGridRiwayat = (url) => {
        $('#daftar-riwayat-grid').yiiGridView({
            'ajaxUrl':url,
            'ajaxUpdate':['daftar-riwayat-grid'],'ajaxVar':'ajax','pagerClass':'pagination','loadingClass':'animation\x2Dloading','filterClass':'filters','tableClass':'table\x20table\x2Dstriped\x20table\x2Dbordered\x20table\x2Dcondensed','selectableRows':1,'enableHistory':false,'updateSelector':'\x7Bpage\x7D,\x20\x7Bsort\x7D','filterSelector':'\x7Bfilter\x7D','pageVar':'page','afterAjaxUpdate':function(id, data){jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({"placement":"top"});},'replaceUrl':false});
    }
    
    const cetak = (obj) => {   
        window.open($(obj).attr("data-url"),"print-asesmenulang","width=860,height=480");
    }

    const refreshRiwayat = (id, daftarId) => {
        let model = {
                data : {
                    'AsesmenspiritualUlangpasienrajalT[default]':'',
                    'AsesmenspiritualUlangpasienrajalT[pendaftaran_id]':daftarId,
            }
        }
        
        if (id == 'ulang-ri'){
            model = {
                data : {
                    'AsesmenspiritualUlangpasienT[default]':'',
                    'AsesmenspiritualUlangpasienT[pendaftaran_id]':daftarId,
                }
            }
        }
        $.fn.yiiGridView.update('daftar-riwayat-grid', model);   
    }
    
    const rencanaEdukasiLain = (obj) => {
        const field = <?= json_encode('<div class="control-group rencanaedukasiislami_lain"style="padding-left: 20px;">'.
                            CHtml::activeTextField($model, 'rencanaedukasiislami_lain',['class'=>'span8'])
                           .'</div>') ?>;
        const lain = $(".rencanaedukasiislami[value='Lain-lain']").prop("checked");
                
        if ($(obj).attr('value') == 'Lain-lain'){
            if (lain){
                $(".rencanaedukasiislami[value='Lain-lain']").parents(".group-data").append(field);
            }else{
                $(".rencanaedukasiislami_lain").remove();
            }
        }
    }
</script>
