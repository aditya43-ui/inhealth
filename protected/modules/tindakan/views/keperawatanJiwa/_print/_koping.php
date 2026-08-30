<table class='form_predispo' style="width: 100%">
    <tr>
        <td width="10"></td>
        <td colspan="2">

            <table style="width: 100%; border: none;">
                <thead>
                    <tr>
                        <th width="50%"><b>Adaptif</b></th>
                        <th><b>Maladaptif</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            if (is_array($model->mekanismekoping_adaptif)) {
                                echo "<ul>";
                                foreach($model->mekanismekoping_adaptif as $item) {
                                    echo "<li>".$item.($item == "Lainnya" ? ", ".$model->mekanismekoping_adaptif_lainnya : "")."</li>";
                                }
                                echo "</ul>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($model->mekanismekoping_maladaptif)) {
                                echo "<ul>";
                                foreach($model->mekanismekoping_maladaptif as $item) {
                                    echo "<li>".$item.($item == "Lainnya" ? ", ".$model->mekanismekoping_maladaptif_lainnya : "")."</li>";
                                }
                                echo "</ul>";
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>

        </td>
    </tr>
    <tr>
        <td></td>
        <td width="200"><b>Masalah Keperawatan</b></td>
        <td>
            <?php echo $model->mekanismekoping_masalahkeperawatan; ?>
        </td>
    </tr>
</table>
