<style>
    .tab_nyeri_bayi th, .tab_nyeri_bayi td {
        border: 1px solid black !important;
        padding: 5px;
    }
    
    .tab_nyeri_bayi th {
        font-weight: bold;
    }
    
    .tab_nyeri_bayi {
        border: 1px solid black !important;
        width: 100%;
    }
</style>

<?php

$nyeri_bayi_field = array(
    array(
        'name'=>'Ekpresi Wajah',
        'lookup'=>'skalanyeribayi_ekspresiwajah',
        'prematur'=>false,
    ),
    array(
        'name'=>'Menangis',
        'lookup'=>'skalanyeribayi_menangis',
        'prematur'=>false,
    ),
    array(
        'name'=>'Pola Bernafas',
        'lookup'=>'skalanyeribayi_polabernafas',
        'prematur'=>false,
    ),
    array(
        'name'=>'Lengan',
        'lookup'=>'skalanyeribayi_lengan',
        'prematur'=>false,
    ),
    array(
        'name'=>'Kaki',
        'lookup'=>'skalanyeribayi_kaki',
        'prematur'=>false,
    ),
    array(
        'name'=>'Keadaan Rangsang',
        'lookup'=>'skalanyeribayi_keadaanrangsang',
        'prematur'=>false,
    ),
    array(
        'name'=>'Heart Rate',
        'lookup'=>'skalanyeribayiprematur_hearthrate',
        'prematur'=>true,
    ),
    array(
        'name'=>'Saturasi Oksigen',
        'lookup'=>'skalanyeribayiprematur_so2',
        'prematur'=>true,
    ),
);

$modNyeriBayiForm = new AsesmentnyeribayidetT;

?>

<div class="panel panel-success panel_nyeri_bayi">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo $form->radioButton($model, 'is_bayiprematur', array(
                'value'=>0,
                'class'=>'cb_is_bayiprematur',
                'onclick'=>'setCeklisNyeriBayi();',
            )); ?> 
            Asesmen Nyeri Bayi Normal
        </div>
    </div>
    <div class="panel-body">
        <table class="tab_nyeri_bayi">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Penilaian</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nyeri_bayi_field as $item): 
                    if ($item['prematur']) {
                        continue;
                    }
                    
                    $modNyeriBayiForm = AsesmentnyeribayidetT::model()->findByAttributes(array(
                        'asesmentnyeri_id'=>$model->asesmentnyeri_id,
                        'parameter'=>$item['name'],
                    ));
                    
                    if (empty($modNyeriBayiForm)) {
                        $modNyeriBayiForm = new AsesmentnyeribayidetT;
                    }
                    
                    ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php 
                    
                    $list_row = LookupM::getItemsUrutan($item['lookup']);
                    $list_dat = array();
                    $list_option = array();
                    
                    foreach ($list_row as $value=>$label) {
                        $list_dat[$label] = $label;
                        $list_option[$label] = array(
                            'data-nilai'=>$value,
                        );
                    }
                    
                    echo $form->dropDownList($modNyeriBayiForm, '['.$item['name'].']penilaian', $list_dat, array(
                        //'empty'=>'-- Pilih --',
                        'class'=>'sl_penilaian',
                        'options'=>$list_option,
                        'onchange'=>'setNilaiBayi();',
                    )); ?></td>
                    <td><?php echo $form->textField($modNyeriBayiForm, '['.$item['name'].']skor', array(
                        'readonly'=>true, 'class'=>'span1 skor', 'style'=>'text-align: right;'
                    )); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total Skor</td>
                    <td width="100">
                        <?php echo $form->textField($model, 'score_skalanyeri', array('readonly'=>true, 'class'=>'span1 total_skor', 'style'=>'text-align: right;')); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Keterangan
                        <div class="pull-right">
                        <?php echo $form->textField($model, 'keteranganskala_nyeri', array('class'=>'span3 keterangan_skor', 'readonly'=>true)); ?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="panel panel-success panel_nyeri_bayi">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo $form->radioButton($model, 'is_bayiprematur', array(
                'value'=>1,
                'class'=>'cb_is_bayiprematur',
                'onclick'=>'setCeklisNyeriBayi();',
            )); ?> 
            Asesmen Nyeri Bayi Prematur
        </div>
    </div>
    <div class="panel-body">
        <table class="tab_nyeri_bayi">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Penilaian</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nyeri_bayi_field as $item):
                    
                    $modNyeriBayiForm = AsesmentnyeribayidetT::model()->findByAttributes(array(
                        'asesmentnyeri_id'=>$model->asesmentnyeri_id,
                        'parameter'=>$item['name'],
                    ));
                    
                    if (empty($modNyeriBayiForm)) {
                        $modNyeriBayiForm = new AsesmentnyeribayidetT;
                    }
                    
                    ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php 
                    
                    $list_row = LookupM::getItemsUrutan($item['lookup']);
                    $list_dat = array();
                    $list_option = array();
                    
                    foreach ($list_row as $value=>$label) {
                        $list_dat[$label] = $label;
                        $list_option[$label] = array(
                            'data-nilai'=>$value,
                        );
                    }
                    
                    echo $form->dropDownList($modNyeriBayiForm, '['.$item['name'].']penilaian', $list_dat, array(
                        //'empty'=>'-- Pilih --',
                        'class'=>'sl_penilaian',
                        'options'=>$list_option,
                        'onchange'=>'setNilaiBayi();',
                    )); ?></td>
                    <td><?php echo $form->textField($modNyeriBayiForm, '['.$item['name'].']skor', array(
                        'readonly'=>true, 'class'=>'span1 skor', 'style'=>'text-align: right;'
                    )); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total Skor</td>
                    <td width="100">
                        <?php echo $form->textField($model, 'score_skalanyeri', array('readonly'=>true, 'class'=>'span1 total_skor', 'style'=>'text-align: right;')); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Keterangan
                        <div class="pull-right">
                        <?php echo $form->textField($model, 'keteranganskala_nyeri', array('class'=>'span3 keterangan_skor', 'readonly'=>true)); ?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        setCeklisNyeriBayi();
        setNilaiBayi();
        
        $('#status-nyeri input[type="radio"]').on('click', setCeklisNyeriBayi);
    });
    
    function setCeklisNyeriBayi() {
        
        var is_nyeri = $('#status-nyeri input[type="radio"]:checked').val();
        $(".cb_is_bayiprematur").each(function() {
            var panel_body = $(this).parents(".panel_nyeri_bayi").find(".panel-body");
            
            
            if (!$(this).is(":checked") || is_nyeri == 0) {
                panel_body.hide().find(":input").prop("disabled", true);
            } else {
                panel_body.show().find(":input").prop("disabled", false);
            }
        });
    }
    
    function setNilaiBayi() {
        $(".tab_nyeri_bayi").each(function() {
            var tab = $(this);
            var total = 0;
            var keterangan = "";
            
            $(tab).find("tbody tr").each(function() {
                var skor = $(this).find(".sl_penilaian :selected").data('nilai');
                total += skor;
                $(this).find(".skor").val(skor);
            });
            
            if (total > 4) {
                keterangan = "Nyeri Berat";
            } else if (total > 2) {
                keterangan = "Nyeri Sedang";
            } else if (total > 0) {
                keterangan = "Nyeri Ringan";
            } else {
                keterangan = "Tidak Nyeri";
            }
            
            $(tab).find(".total_skor").val(total);
            $(tab).find(".keterangan_skor").val(keterangan);
        });
    }
    
</script>