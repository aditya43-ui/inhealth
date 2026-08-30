<div class="panel panel-success form_skoring form_nips">
    <div class="panel-heading">
        <div class="panel-title">Neonatal Infant Pain Score</div>
    </div>
    <div class="panel-body">
        <?php
        
        $ekspresi = array(
            'nips_ekspresiwajah' => 'Ekspresi Wajah',
            'nips_tangis' => 'Tangis',
            'nips_polanafas' => 'Pola Nafas',
            'nips_ekstremitasatas' => 'Ekstremitas Atas',
            'nips_ekstremitasbawah' => 'Ekstremitas Bawah',
            'nips_statuskesadaran' => 'Status Kesadaran',
        );
        
        ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="200">Parameter</th>
                    <th>Penilaian</th>
                    <th width="100">Skor</th>
                </tr>
            </thead>
            <tbody id="tab_nips">
                <?php foreach ($ekspresi as $val => $label) {
                    
                    if (!$model->isNewRecord) {
                        $det = PengkajiannyeriskalanipsT::model()->findByAttributes(array(
                            'pengkajiannyeri_id' => $model->pengkajiannyeri_id,
                            'parameter' => $val,
                        ));
                        
                        if (empty($det)) {
                            $det = new PengkajiannyeriskalanipsT;
                            $det->parameter = $val;
                        }
                    } else {
                        $det = new PengkajiannyeriskalanipsT;
                        $det->parameter = $val;
                    }
                    
                    $lookup = LookupM::model()->findAllByAttributes(array(
                        'lookup_type'=>$val,
                    ), array(
                        'order'=>'lookup_urutan asc',
                    ));
                    
                    $list_penilaian = CHtml::listData($lookup, 'lookup_name', 'lookup_name');
                    $option_list = array();
                    
                    foreach ($lookup as $item) {
                        $option_list[$item->lookup_name] = array(
                            'data-nilai'=>$item->lookup_value,
                        );
                    }
                    
                ?>    
                    
                <tr> 
                    <td><?php echo $label; ?></td>
                    <td><?php echo $det->nips_penilaian; //$form->dropDownList($det, '[nips]['.$val.']nips_penilaian', $list_penilaian, array('class'=>'nilai_nips input_nilai', 'options'=>$option_list)); ?></td>
                    <td><?php echo $det->nips_skor; //$form->textField($det, '[nips]['.$val.']nips_skor', array('class'=>'span1 skor_nips input_skor', 'readonly'=>true, 'style'=>'text-align: right')); ?></td>
                </tr>
                    
                <?php } ?>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total Skor</td>
                    <td><?php echo $model->skalanyeri; //CHtml::activeTextField($model, 'skalanyeri', array('class' => 'span1 total_skor_nips', 'readonly' => true, 'style' => 'text-align:right;')) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Kriteria Skor Nyeri</td>
                    <td><?php echo $model->keterangan_skalanyeri; //CHtml::activeTextField($model, 'keterangan_skalanyeri', array('class' => 'keterangan_skor_nips span3', 'readonly' => true, 'style' => 'text-align:left;')) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    
    function cekSkoringNIPS() {
        var total_skor = 0;
        var keterangan = "";
        $("#tab_nips tr").each(function() {
            var skor = $(this).find(".nilai_nips :selected").data('nilai');
            
            if (skor == null || skor == "") {
                skor = 0;
            } 
            
            $(this).find(".skor_nips").val(skor);
            total_skor += skor;
        });
        
        if (total_skor == 0) {
            keterangan = "Tidak Nyeri";
        } else if (total_skor <= 2) {
            keterangan = "Nyeri Ringan";
        } else if (total_skor <= 4) {
            keterangan = "Nyeri Sedang";
        } else {
            keterangan = "Nyeri Berat";
        }
        
        $(".total_skor_nips").val(total_skor);
        $(".keterangan_skor_nips").val(keterangan);
    }
    
    $(document).ready(function() {
        $("#tab_nips .nilai_nips").change(cekSkoringNIPS);
        cekSkoringNIPS();
    });
    
</script>