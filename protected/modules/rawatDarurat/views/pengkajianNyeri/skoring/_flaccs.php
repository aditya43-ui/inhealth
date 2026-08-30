<?php
$dataFlaCcs = array();
$cekFlaCcs = array();

$criFla = new CDbCriteria();
$criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
$criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
$criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
$modNyeriFlaCcs = SkalanyeriflaccsM::model()->findAll($criFla);

$getFlaCcs = array();

if (!$model->isNewRecord) {
    $getFlaCcs = PengkajiannyeriskalaflaccsT::model()->findAllByAttributes(array('pengkajiannyeri_id' => $model->pengkajiannyeri_id));
}



if (count($getFlaCcs) > 0)
    foreach ($getFlaCcs as $det) {
        $cekFlaCcs["$det->skalanyeriflaccs_id"] = $det->skalanyeriflaccs_id;
    }


$modFlaCcs = new PengkajiannyeriskalaflaccsT;

foreach ($modNyeriFlaCcs as $dtF) {
    $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
    $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
        'id' => $dtF->skalanyeriflaccs_id,
        'keterangan' => $dtF->skalanyeriflaccs_desc,
        'value' => isset($cekFlaCcs["$dtF->skalanyeriflaccs_id"]) ? $dtF->skalanyeriflaccs_id : null,
    );
}

//var_dump($dataFlaCcs); die;
?>

<div class="panel panel-success form_skoring form_flaccs">
    <div class="panel-heading">
        <div class="panel-title">SKALA NYERI FLACCS <a href="#" onclick="return false;" rel="tooltip" title="Klik pada Deskripsi Skor setiap Kriteria untuk menentukan skor setiap kriteria"><i class="entypo-info-circled"></i></a></div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-consensed" style="color: #333;">
            <tr>
                <th style="text-align:center;">KATEGORI</th>
                <th style="text-align:center;" colspan="3">PARAMETER</th>
            </tr>
            <tr>
                <th></th>
                <th style="text-align:center;">0</th>
                <th style="text-align:center;">1</th>
                <th style="text-align:center;">2</th>
                <th style="text-align:center;">Skor</th>
            </tr>
            <?php
            foreach ($dataFlaCcs as $det) {
                ?>
                <tr>
                    <td><b><?php echo $det['kategori']; ?></b></td>
                    <td>
                        <?php
                        foreach ($det[0] as $var0) {
                            $modFlaCcs->ispilih = $var0['value'];
                            $modFlaCcs->skalanyeriflaccs_id = $var0['id'];
                            echo '<label class="checkbox inline" id="skalanyeriflaccs_id_' . $var0["id"] . '">' . $form->CheckBox($modFlaCcs, '[' . $var0["id"] . ']ispilih', array('value' => $var0['id'],
                                'onclick' => "return false;", "class"=>'pilih_flaccs', 'data-kategori'=>$det['kategori'], 'data-skor'=>0, 'disabled'=>true));
                            echo $form->hiddenField($modFlaCcs, '[' . $var0["id"] . ']skalanyeriflaccs_id');
                            echo '<span  style="color:#333;font-size:12px;">' . $var0['keterangan'] . '</span>';
                            echo '</label><br/>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($det[1] as $var0) {
                            $modFlaCcs->ispilih = $var0['value'];
                            $modFlaCcs->skalanyeriflaccs_id = $var0['id'];
                            echo '<label class="checkbox inline" id="skalanyeriflaccs_id_' . $var0["id"] . '">' . $form->CheckBox($modFlaCcs, '[' . $var0["id"] . ']ispilih', array('value' => $var0['id'],
                                'onclick' => "return false;", "class"=>'pilih_flaccs', 'data-kategori'=>$det['kategori'], 'data-skor'=>1, 'disabled'=>true));
                            echo $form->hiddenField($modFlaCcs, '[' . $var0["id"] . ']skalanyeriflaccs_id');
                            echo '<span  style="color:#333;font-size:12px;">' . $var0['keterangan'] . '</span>';
                            echo '</label><br/>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($det[2] as $var0) {
                            $modFlaCcs->ispilih = $var0['value'];
                            $modFlaCcs->skalanyeriflaccs_id = $var0['id'];
                            echo '<label class="checkbox inline" id="skalanyeriflaccs_id_' . $var0["id"] . '">' . $form->CheckBox($modFlaCcs, '[' . $var0["id"] . ']ispilih', array('value' => $var0['id'],
                                'onclick' => "return false;", "class"=>'pilih_flaccs', 'data-kategori'=>$det['kategori'], 'data-skor'=>2, 'disabled'=>true));
                            echo $form->hiddenField($modFlaCcs, '[' . $var0["id"] . ']skalanyeriflaccs_id');
                            echo '<span style="color:#333;font-size:12px;">' . $var0['keterangan'] . '</span>';
                            echo '</label><br/>';
                        }
                        ?>
                    </td>
                    <td class="flaccs_nilai_skor"></td>
                </tr>
                <?php
            }
            ?>
                <tr>
                    <td colspan="4">TOTAL SKOR</td><td class="html_flaccs_total"></td>
                </tr>
                <tr>
                    <td colspan="4">KETERANGAN SKOR NYERI</td><td class="html_flaccs_keterangan"></td>
                </tr>
            <tr>
                <td colspan="5" style="text-align: center;">
                    <strong>SKOR</strong> 
                    <span id="skalanyerirange_0" min="0" max="0"><strong>0</strong> : Tidak nyeri</span> &nbsp; &nbsp; &nbsp; &nbsp;
                    <span id="skalanyerirange_1_3"  min="1" max="3"><strong>1-3</strong> : Nyeri ringan</span> &nbsp; &nbsp; &nbsp; &nbsp;
                    <span id="skalanyerirange_4_6"  min="4" max="6"><strong>4-6</strong> : Nyeri sedang</span> &nbsp; &nbsp; &nbsp; &nbsp;
                    <span id="skalanyerirange_7_10"  min="7" max="10"><strong>7-10</strong> : Nyeri hebat</span> &nbsp; &nbsp; &nbsp; &nbsp;
                </td>
            </tr>
        </table>
        <?php echo $form->hiddenField($model, 'skalanyeri', array('class'=>'flaccs_total_skor')); ?>
        <?php echo $form->hiddenField($model, 'keterangan_skalanyeri', array('class'=>'flaccs_keterangan')); ?>
    </div>
</div>

<script>
    
    function pilihNyeriFlaCcsIni(obj) {

        var nilai = $(obj).val();
        
        var nilai_skor = $(obj).data('skor');
        var kategori = $(obj).data('kategori');
        $(obj).prop("checked", true);
        $(obj).parents("tr").find(".flaccs_nilai_skor").html(nilai_skor);
        
        $(obj).parents("tr").find(".pilih_flaccs").each(function() {
            if($(this).data('kategori') == kategori){
                if ($(this).val() == nilai) {
                    $(this).attr("checked", true);
                }else{
                    $(this).prop("checked", false);
                }
            }
            
        });
        
        getTotalNilai();
    }
    
    function getTotalNilai() {
        var total = 0;
        
        $(".flaccs_nilai_skor").each(function() {
            total += parseInt($(this).html());
        });
        
        var keterangan = "";
        if (total == 0) {
            keterangan = "Tidak Nyeri";
        } else if (total <= 3) {
            keterangan = "Nyeri Ringan";
        } else if (total <= 6) {
            keterangan = "Nyeri Sedang";
        } else {
            keterangan = "Nyeri Hebat";
        }
        
        $(".flaccs_total_skor").val(total);
        $(".flaccs_keterangan").val(keterangan);
        
        $(".html_flaccs_total").html(total);
        $(".html_flaccs_keterangan").html(keterangan);
    }
    
    $(document).ready(function() {
        $(".pilih_flaccs").each(function() {
            var obj = this;
            $(this).parents("td").on('click', function() {
                pilihNyeriFlaCcsIni(obj);
            });
        });
        
        $(".pilih_flaccs:checked").each(function() {
            pilihNyeriFlaCcsIni(this);
        });
    });
    
</script>


