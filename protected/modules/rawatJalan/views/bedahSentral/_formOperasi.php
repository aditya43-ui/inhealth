<table style="width: 100%; border: none; margin-top: 17px;">
    <tr>
        <td>
            <div id="formOperasi">
                <?php foreach ($modKegiatanOperasi as $i => $kegiatanOperasi) {
                    $ceklist = false;
                ?>
                    <div class="boxtindakan" style="margin-bottom: 17px;">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo $kegiatanOperasi->kegiatanoperasi_nama; ?></div>
                            </div>
                            <div class="panel-body">
                                <?php foreach ($modOperasi as $j => $operasi) {
                                    if ($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                                        echo '<label class="checkbox inline">' . CHtml::checkBox("operasi[]", $ceklist, array(
                                            'value' => $operasi->operasi_id,
                                            'onclick' => "inputOperasi(this);"
                                        ));
                                        echo "<span>" . $operasi->operasi_nama . "</span></label><br>";
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>

<script>
    $('#formOperasi').tile({
        widths: [198]
    });
</script>