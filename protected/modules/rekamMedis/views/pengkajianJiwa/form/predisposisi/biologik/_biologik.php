<?php

$modKel = new DaftarkeluargaGangguangjiwaT();

?>

<?php echo $form->textAreaRow($model, 'riwayatpenyakit_sebelumnya'); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'isadakeluarga_gangguanjiwa', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        echo $form->radioButtonList($model, 'isadakeluarga_gangguanjiwa', array('Tidak' => 'Tidak', 'Ya' => 'Ya'), array(
            'uncheckValue' => null, 'class' => 'isadakeluarga_gangguanjiwa'
        ));
        ?>

        <div class="panel panel-default" style="width: 100%;">
            <div class="panel-body">
                <div id="form_keluarga_gangguanjiwa">
                    <?php
                    echo $form->dropDownListRow($modKel, 'hubungankeluarga', LookupM::getItemsUrutan('hubungankeluarga'), array(
                        'empty' => '-- Pilih --', 'class'=>'hubungankeluarga'
                    ));
                    ?>
                    <?php echo $form->textAreaRow($modKel, 'gejala', array('row' => 3, 'class'=>'gejala')); ?>
                    <?php echo $form->textAreaRow($modKel, 'riwayatpengobatan', array('row' => 3, 'class'=>'riwayatpengobatan')); ?>
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php echo CHtml::htmlButton('+', array('class' => 'btn btn-success', 'onclick' => 'tambahKeluargaJiwa();')); ?>
                        </div>
                    </div>
                </div>
                <br/>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Hubungan Keluarga</th>
                            <th>Gejala</th>
                            <th>Riwayat Pengobatan</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tab_keluargajiwa">
                        <?php
                        if (!$model->isNewRecord) {
                            $det = DaftarkeluargaGangguangjiwaT::model()->findAllByAttributes(array(
                                'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
                            ));
                        } else {
                            $det = array();
                        }
                        
                        foreach ($det as $idx => $item) {
                            echo $this->renderPartial($this->path_view . "form.predisposisi.biologik._rowKeluargaJiwa", array(
                                'mod' => $item, 'i' => "K_".$idx, 'no' => $idx + 1,
                            ), true);
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    
    var kel_idx = 0;
    
    function tambahKeluargaJiwa() {
        var hubungan = $("#form_keluarga_gangguanjiwa .hubungankeluarga").val();
        var gejala = $("#form_keluarga_gangguanjiwa .gejala").val();
        var riwayatpengobatan = $("#form_keluarga_gangguanjiwa .riwayatpengobatan").val();
        
        $.post('<?php echo $this->createUrl('tambahKeluargaJiwa'); ?>', {
            hubungan: hubungan,
            gejala: gejala,
            riwayatpengobatan: riwayatpengobatan,
            idx: kel_idx
        }, function(data) {
            
            if (data.ok == 1) {
                $("#tab_keluargajiwa").append(data.html);
                kel_idx++;
                resetNomorRowKeluargaJiwa();
                $("#form_keluarga_gangguanjiwa textarea, #form_keluarga_gangguanjiwa select").val("");
            } else {
                myAlert(data.msg);
            }
            
        }, 'json');
    }
    
    function hapusKeluargaJiwa(obj) {
        $(obj).parents("tr").remove();
        resetNomorRowKeluargaJiwa();
    }
    
    function resetNomorRowKeluargaJiwa() {
        var cnt = 1;
        $("#tab_keluargajiwa tr").each(function() {
            $(this).find(".nomor").html(cnt++);
        });
    }
    
    function cekCeklisKeluarhaJiwa() {
        var nilai = $(".isadakeluarga_gangguanjiwa:checked").val();
        
        if (nilai == "Ya") {
            $("#form_keluarga_gangguanjiwa :input").attr("disabled", false);
        } else {
            $("#form_keluarga_gangguanjiwa :input").attr("disabled", true);
            $("#tab_keluargajiwa").empty();
        }
    }
    
    $(document).ready(function() {
        $(".isadakeluarga_gangguanjiwa").on("click", cekCeklisKeluarhaJiwa);
        cekCeklisKeluarhaJiwa();
    });
    
    
</script>

