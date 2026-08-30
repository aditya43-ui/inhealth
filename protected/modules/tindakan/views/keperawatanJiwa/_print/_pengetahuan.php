
                <?php 
                if (is_array($model->pengetahuankurang)) {
                    echo "<ul>";
                    foreach($model->pengetahuankurang as $item) {
                        echo "<li>".$item.($item == "Lainnya" ? ", ".$model->pengetahuankurang_lainnya : "")."</li>";
                    }
                    echo "</ul>";
                } ?>

<b>Masalah Keperawatan</b><br>
<?php echo $model->pengetahuankurang_masalahkeperawatan; ?>