<?php
$ceklist = false;
?>
<div class="col-xs-4">
    <div class="boxtindakan" style="">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $modtindakan->kelompoktindakan_nama; ?></div>
            </div>
            <div class="panel-body">
                <?php
                foreach ($modDaftarTindakan as $j => $DaftarTindakan) {
                    if ($modtindakan->kelompoktindakan_id == $DaftarTindakan->kelompoktindakan_id) {
                        echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                            'value' => $DaftarTindakan->daftartindakan_id,
                            'onclick' => "inputperiksa(this);"
                        ));
                        echo "<span>" . $DaftarTindakan->daftartindakan_nama . "</span></label><br/>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>