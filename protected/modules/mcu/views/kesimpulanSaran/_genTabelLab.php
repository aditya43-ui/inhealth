<?php
/**
 * digunakan untuk tabel pemeriksaan detail lab, jika ditemukan master detailnya
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
            foreach ($data as $dt1) {
                ?>
                <table style="width:100%;border:none;">
                    <tr style="border:none;">
                        <td width="15%" style="padding-top:10px;border:none;vertical-align:top;"><?php echo $dt1['jenispemeriksaanlab_nama']; ?></td>
                        <td style="padding-top:10px;border:none;vertical-align:top;" width="1%">:</td>
                        <td style="vertical-align:top;border:none;">
                        <table style="width:100%;border:none;">	                            
                            <?php
                            foreach ($dt1['pemeriksaanlab'] as $dt2) {

                                $a = 1;
                                $i = 1;
                                $b = 1;
                                foreach ($dt2['kelompokdet'] as $dt3) {
                                    if (count((array)$dt3['nilairujukan']) > 1) {
                                        ?>
                                        <tr style="border:none;">

                                            <td style="border-bottom:white 1px solid !important;border:none;">
                                                <?php
                                                if ($i == 1) {
                                                    echo $dt2['pemeriksaanlab_nama'];
                                                }
                                                ?>
                                            </td>													
                                            <td colspan="3"  style="border:none;"> :
                        <?php echo $dt3['kelompokdet'] . ' :'; ?>
                                            </td>							
                                        </tr>
                        <?php
                    }
                    $j = 1;
                    foreach ($dt3['nilairujukan'] as $dt4) {
                        if (count((array)$dt2['kelompokdet']) == $b) {
                            if (count((array)$dt3['nilairujukan']) > 1) {
                                if (count((array)$dt3['nilairujukan']) == $j) {
                                    $border = 'border:none;';
                                } else {
                                    $border = 'border:none;';
                                }
                            } else {
                                $border = 'border:none;';
                            }
                        } else {
                            $border = 'border:none;';
                        }
                        $border = 'border:none;';
                        ?>
                                        <tr>

                                            <td style="<?php echo $border; ?>" width="15%">
                                                <?php
                                                if ($i == 1) {

                                                    echo $dt2['pemeriksaanlab_nama'];
                                                } else {

                                                }
                        ?>
                                            </td>					
                                            <td width="1%"  style="border:none;">
                                                <?php
                                                    if ($i == 1) {
                                                        echo ':';
                                                    } else {

                                                    }
                                                ?>
                                            </td>
                                            <td width="20%"  style="border:none;">								
                                                <?php
                                                if (count((array)$dt3['nilairujukan']) > 1) {
                                                    echo '<ul><li>' . $dt4['namapemeriksaandet'] . '</li><ul>';
                                                } else {
                                                    echo '# '.$dt4['namapemeriksaandet'];
                                                }
                                                ?>
                                            </td>
                                            <td width="1%"  style="border:none;">:</td>                                            
                                            <td style="border:none;">
                                                <?php echo $dt4['nilairujukan']; ?>
                                            </td>
                                        </tr>

                        <?php
                        $i++;
                        $j++;
                    }

                    $b++;
                }
            }
            ?>
                        </table>	
                </td>
                    </tr>
                </table>
                    <?php
                }
                ?>     
      