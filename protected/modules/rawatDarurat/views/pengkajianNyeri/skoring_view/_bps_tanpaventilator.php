<div class="panel panel-success form_skoring form_bps_tanpaventilator">
    <div class="panel-heading">
        <div class="panel-title">Behavioural Pain Scale (Tanpa Ventilator)</div>
    </div>
    <div class="panel-body">
        <?php
        
        $ekspresi = array(
            'bps_ekspresiwajah' => 'Ekspresi Wajah',
            'bps_ekstremitasatas' => 'Ekstremitas Atas',
            'bps_vokalisasi' => 'Vokalisasi',
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
            <tbody id="tab_bpstv">
                <?php foreach ($ekspresi as $val => $label) {
                    
                    if (!$model->isNewRecord) {
                        $det = PengkajiannyeriskalabpsT::model()->findByAttributes(array(
                            'pengkajiannyeri_id' => $model->pengkajiannyeri_id,
                            'parameter' => $val,
                            'ispakaiventilator' => false,
                        ));
                        
                        if (empty($det)) {
                            $det = new PengkajiannyeriskalabpsT;
                            $det->parameter = $val;
                            $det->ispakaiventilator = false;
                        }
                    } else {
                        $det = new PengkajiannyeriskalabpsT;
                        $det->parameter = $val;
                        $det->ispakaiventilator = false;
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
                    <td><?php echo $det->bps_penilaian; //$form->dropDownList($det, '[bpstv]['.$val.']bps_penilaian', $list_penilaian, array('empty'=>'-- Pilih --', 'class'=>'nilai_bpstv input_nilai', 'options'=>$option_list)); ?></td>
                    <td><?php echo $det->bps_skor; //$form->textField($det, '[bpstv]['.$val.']bps_skor', array('class'=>'span1 skor_bpstv input_skor', 'readonly'=>true, 'style'=>'text-align: right')); ?></td>
                </tr>
                    
                <?php } ?>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Total Skor</td>
                    <td><?php echo $model->skalanyeri; //CHtml::activeTextField($model, 'skalanyeri', array('class' => 'span1 total_skor_bpstv', 'readonly' => true, 'style' => 'text-align:right;')) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Kriteria Skor Nyeri</td>
                    <td><?php echo $model->keterangan_skalanyeri; //CHtml::activeTextField($model, 'keterangan_skalanyeri', array('class' => 'keterangan_skor_bpstv span3', 'readonly' => true, 'style' => 'text-align:left;')) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    
    function cekSkoringBPSTV() {
        var total_skor = 0;
        var keterangan = "";
        $("#tab_bpstv tr").each(function() {
            var skor = $(this).find(".nilai_bpstv :selected").data('nilai');
            
            if (skor == null || skor == "") {
                skor = 0;
            } 
            
            $(this).find(".skor_bpstv").val(skor);
            total_skor += skor;
        });
        
        if (total_skor >= 3 && total_skor <= 5) {
            keterangan = "Tidak Nyeri";
        } else if (total_skor > 5 && total_skor <= 12) {
            keterangan = "Nyeri";
        }
        
        $(".total_skor_bpstv").val(total_skor);
        $(".keterangan_skor_bpstv").val(keterangan);
    }
    
    $(document).ready(function() {
        $("#tab_bpstv .nilai_bpstv").change(cekSkoringBPSTV);
        cekSkoringBPSTV();
    });
    
</script>