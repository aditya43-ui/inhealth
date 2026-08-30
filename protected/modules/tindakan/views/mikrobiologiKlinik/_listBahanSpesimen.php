<?php
/**
 * mengenerate daftar spesimen mikrobiologi klinik
 * 
 * @author Aida Rahmawati <aidarahmawati@.co.id>
 */
if (!empty($bahan_gen)) {
    foreach ($bahan_gen as $gen) {
        $ceklist = false;
        ?>
        <div class="col-sm-4">
            <div class="boxtindakan">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><h6><?php echo $gen['samplelab_namalainnya']; ?></h6></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        foreach ($gen['det'] as $g => $bhn) {
                            if (!empty($bhn['samplelab_id'])) {
                                $samplelab_id = $bhn['samplelab_id'];
                                if ($gen['samplelab_namalainnya'] == Params::BAHAN_SPESIMEN_JENIS_PUS) {
                                    echo CHtml::hiddenField("KirimspesimenlabT[" . $bhn['samplelab_id'] . "][samplelab_id]", $samplelab_id);
                                    echo '<label class="checkbox inline">' . CHtml::checkBox("KirimspesimenlabT[" . $bhn['samplelab_id'] . "][cekList]", $ceklist, array('onclick' => "inputBahan(this," . $bhn['lokasi'] . ");", 'value' => $bhn['samplelab_id'], 'id' => 'samplelab_id'));
                                    echo "<span>" . $bhn['samplelab_nama'] . "</span></label><br/>";
                                    echo CHtml::textField("KirimspesimenlabT[" . $bhn['samplelab_id'] . "][lokasi]", $ceklist, array("class" => "span3", "onkeyup" => "return $(this).focusNextInputField(event);", "placeholder" => "Lokasi " . $bhn['samplelab_nama'])) . "<br>";
                                } else {
                                    echo CHtml::hiddenField("KirimspesimenlabT[" . $bhn['samplelab_id'] . "][samplelab_id]", $samplelab_id);
                                    echo '<label class="checkbox inline">' . CHtml::checkBox("KirimspesimenlabT[" . $bhn['samplelab_id'] . "][cekList]", $ceklist, array('onclick' => "inputBahan(this," . $bhn['lokasi'] . ");", 'value' => $bhn['samplelab_id'], 'id' => 'samplelab_id'));
                                    echo CHtml::hiddenField("KirimspesimenlabT[" . $bhn['samplelab_id'] . "][lokasi]", $ceklist, array("class" => "span3", "onkeyup" => "return $(this).focusNextInputField(event);", "placeholder" => "Lokasi " . $bhn['samplelab_nama'])) . "<br>";
                                    echo "<span>" . $bhn['samplelab_nama'] . "</span></label><br/>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
