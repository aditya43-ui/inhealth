<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Saldo Awal</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Saldo Awal',
        );
        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('aksaldoawal-t-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $a = 0;
        // foreach ($rekening1 as $key => $jml) {
        //     if ($key == 0) {
        //         $debit1[$key]         = $jml['debit'];
        //         $kredit1[$key]         = $jml['kredit'];
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //     } else {
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //         $a += $jmlrekening[$key - 1];
        //         $debit1[$a]         = $jml['debit'];
        //         $kredit1[$a]         = $jml['kredit'];
        //     }
        // }
        // $a = 0;
        // foreach ($rekening2 as $key => $jml) {
        //     if ($key == 0) {
        //         $debit2[$key]         = $jml['debit'];
        //         $kredit2[$key]         = $jml['kredit'];
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //     } else {
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //         $a += $jmlrekening[$key - 1];
        //         $debit2[$a]         = $jml['debit'];
        //         $kredit2[$a]         = $jml['kredit'];
        //     }
        // }
        // $a = 0;
        // foreach ($rekening3 as $key => $jml) {
        //     if ($key == 0) {
        //         $debit3[$key]         = $jml['debit'];
        //         $kredit3[$key]         = $jml['kredit'];
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //     } else {
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //         $a += $jmlrekening[$key - 1];
        //         $debit3[$a]         = $jml['debit'];
        //         $kredit3[$a]         = $jml['kredit'];
        //     }
        // }
        // $a = 0;
        // foreach ($rekening4 as $key => $jml) {
        //     if ($key == 0) {
        //         $debit4[$key]         = $jml['debit'];
        //         $kredit4[$key]         = $jml['kredit'];
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //     } else {
        //         $jmlrekening[$key]        = $jml['jmlrekening'];
        //         $a += $jmlrekening[$key - 1];
        //         $debit4[$a]         = $jml['debit'];
        //         $kredit4[$a]         = $jml['kredit'];
        //     }
        // }
        ?>
        <?php $this->renderPartial('_search', array('model' => $model)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Saldo Awal</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="tableLaporan">
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th id="tableLaporan_c0">
                                Nama Rekening
                            </th>
                            <th id="tableLaporan_c0">
                                Debit
                            </th>
                            <th id="tableLaporan_c0">
                                Kredit
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $spasi = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
                        $namarekening1[-1] = '';
                        $namarekening2[-1] = '';
                        $namarekening3[-1] = '';
                        $namarekening4[-1] = '';
                        $namarekening5[-1] = '';
                        $i = 0;
                        foreach ($rekening5 as $key => $value1) {
                            $namarekening1[$key] = $value1['nmrekening1'];
                            if ($namarekening1[$key - 1] != $namarekening1[$key] or in_array($i, $debit1)) {
                                echo "<tr>";
                                echo "<td><b>" . $value1['nmrekening1'] . "</b></td>";
                                echo "<td>" . (isset($debit1[$i]) ? number_format($debit1[$i]) : "") . "</td>";
                                echo "<td>" . (isset($kredit1[$i]) ? number_format($kredit1[$i]) : "") . "</td>";
                                echo "</tr>";
                            }
                            $namarekening2[$key] = $value1['nmrekening2'];
                            if ($namarekening2[$key - 1] != $namarekening2[$key] or in_array($i, $debit2)) {
                                echo "<tr>";
                                echo "<td>" . $spasi . $value1['nmrekening2'] . "</td>";
                                echo "<td>" . (isset($debit2[$i]) ? number_format($debit2[$i]) : "") . "</td>";
                                echo "<td>" . (isset($kredit2[$i]) ? number_format($kredit2[$i]) : "") . "</td>";
                                echo "</tr>";
                            }
                            $namarekening3[$key] = $value1['nmrekening3'];
                            if ($namarekening3[$key - 1] != $namarekening3[$key] or in_array($i, $debit3)) {
                                echo "<tr>";
                                echo "<td>" . $spasi . $spasi . $value1['nmrekening3'] . "</td>";
                                echo "<td>" . (isset($debit3[$i]) ? number_format($debit3[$i]) : "") . "</td>";
                                echo "<td>" . (isset($kredit3[$i]) ? number_format($kredit3[$i]) : "") . "</td>";
                                echo "</tr>";
                            }
                            $namarekening4[$key] = $value1['nmrekening4'];
                            if ($namarekening4[$key - 1] != $namarekening4[$key] or in_array($i, $debit4)) {
                                echo "<tr>";
                                echo "<td>" . $spasi . $spasi . $spasi . $value1['nmrekening4'] . "</td>";
                                echo "<td>" . (isset($debit4[$i]) ? number_format($debit4[$i]) : "") . "</td>";
                                echo "<td>" . (isset($kredit4[$i]) ? number_format($kredit4[$i]) : "") . "</td>";
                                echo "</tr>";
                            }
                            $namarekening5[$key] = $value1['nmrekening5'];
                            if ($namarekening5[$key - 1] != $namarekening5[$key]) {
                                echo "<tr>";
                                echo "<td>" . $spasi . $spasi . $spasi . $spasi . $value1['nmrekening5'] . "</td>";
                                echo "<td>" . number_format($value1['debit']) . "</td>";
                                echo "<td>" . number_format($value1['kredit']) . "</td>";
                                echo "</tr>";
                            }
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>