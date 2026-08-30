<table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div id="formPeriksaRad">
                        <?php
                        $jenisPeriksa = '';
                        foreach ($modPeriksaRad as $i => $pemeriksaan) {
                            $ceklist = false;
                            // if ($pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_aktif == false) continue;
                            if ($jenisPeriksa != $pemeriksaan->jenispemeriksaanrad_nama) {
                                echo ($jenisPeriksa != '') ? "</div></div></div></div>" : "";
                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad_nama;
                                echo "<div class='ganti col-sm-3'>";
                                echo "<div class='boxtindakan' style='margin-top: 10px;'>";
                                
                                echo "<div class='panel panel-success'>";
                                echo "<div class='panel-heading'>"
                                    .    "  <div class='panel-title'><i class='glyphicon glyphicon-file'></i> " . $pemeriksaan->jenispemeriksaanrad_nama . "</div>";
                                echo "</div>";
                                echo "<div class='panel-body'  style=''>";
                                //echo "<h6>".$pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama."</h6>";
                                echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                    'value' => $pemeriksaan->pemeriksaanrad_id,
                                    'onclick' => "inputperiksa(this);"
                                ));
                                $pemeriksaanrad_kode = '';
                                if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                    $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                                }
                                echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - ' . $pemeriksaanrad_kode ."</span></label><br>";
                            } else {
                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad_nama;
                                echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanRad[]", $ceklist, array(
                                    'value' => $pemeriksaan->pemeriksaanrad_id,
                                    'onclick' => "inputperiksa(this);"
                                ));
                                $pemeriksaanrad_kode = '';
                                if(!empty($pemeriksaan->pemeriksaanrad_kode)) {
                                    $pemeriksaanrad_kode = $pemeriksaan->pemeriksaanrad_kode;
                                }
                                echo "<span>" . $pemeriksaan->pemeriksaanrad_nama . ' - ' . $pemeriksaanrad_kode ."</span></label><br>";
                            }
                        }
                        echo "</div></div></div></div></div>";
                        ?>
                    </div>
                </td>
            </tr>
</table>