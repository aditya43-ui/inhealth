<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script>

    var form_jenisdiagnosa = null;
    var form_checkbox_diagnosa = null;
    
    function dialogTambahDiagnosa(panel_checkbox_diagnosa, jenisdiagnosa, kelompokdiagnosa) {
        form_jenisdiagnosa = jenisdiagnosa;
        form_checkbox_diagnosa = panel_checkbox_diagnosa;
        $("#form_tambah_diagnosa .jenisdiagnosa").val(jenisdiagnosa);
        $("#form_tambah_diagnosa .kelompokdiagnosa").val(kelompokdiagnosa);
        $("#dialogTambahDiagnosa").dialog("open");
    }
    
    function simpanTambahDiagnosa(jenisdiagnosa) {
            $.post('<?php echo $this->createUrl('simpanTambahDiagnosa'); ?>', $("#form_tambah_diagnosa").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialogTambahDiagnosa").dialog("close");
                $("#form_tambah_diagnosa .diagnosakesehatanjiwa_nama").val("");
                myAlert("Diagnosa berhasil Ditambah");
                $("#" + form_checkbox_diagnosa).html(data.html);
            } else {
                myAlert("Diagnosa gagal Ditambah");
            }
        }, 'json');
    }


    $(document).ready(function() {
        $('#pengkajian-jiwa-form #rootwizardPengkajian').bootstrapWizard({
            tabClass: "",
            onTabShow: function ($tab, $navigation, index)
            {
                setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
                
                $(".btn_nxt").hide();
                if (index == 12) {
                    $(".submit").show();
                    
                } else {
                    $(".next").show();
                    
                }
                
            },
            onPrevious: function (tab, navigation, old_index, new_index) {
                var postdata = $('#pengkajian-jiwa-form');
                var isSimpan = simpanDataForm(postdata, old_index);

                return isSimpan;
            },
            onNext: function (tab, navigation, old_index, new_index) {
                var postdata = $('#pengkajian-jiwa-form');
                var isSimpan = simpanDataForm(postdata, old_index);
                
                //console.log(navigation);

                return isSimpan;
                // return true;
            },
            onTabClick: function (tab, navigation, old_index, new_index) {
                var postdata = $('#pengkajian-jiwa-form');
                var isSimpan = simpanDataForm(postdata, old_index);

                console.log("TAB", tab);
                console.log("NAV", navigation);
                console.log("OLD IDX", old_index);
                console.log("NEW IDX", new_index);
                
                return isSimpan;
            }
        });
        
        $(".submit").on("click", function() {
            $("#pengkajian-jiwa-form").submit();
        });
        
    });

    
    var is_submit = false;
    function simpanDataForm(postdata, index) {
        
        // return true;
        beforeSubmitGenogram();
        
        if (is_submit) {
            return false;
        };
        
        $("#rootwizardPengkajian .tab-content").addClass("animation-loading");
        is_submit = true;
        
        
        $.post('<?php echo $this->createUrl('ajaxSubmitPengkajianJiwa'); ?>', $("#pengkajian-jiwa-form").serialize(), function(data) {
            
            if (data.ok == 1) {
                $(".askepkesehatanjiwa_id").val(data.id);
                $("#alert_info").html(data.msg);
            } else {
                $("#alert_info").html(data.msg);
            }
        
            $("#rootwizardPengkajian .tab-content").removeClass("animation-loading");
            is_submit = false;
            
            
            
        }, 'json');
        
        //console.log(postdata);
        //console.log("INDEX", index);
        
        return true;
    }


</script>