<style>
    .num {
        text-align: right !important;
    }

    .table tfoot td {
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Jenis Kelamin
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_kelamin as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-kelamin" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Masa Kerja
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Masa Kerja</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_masa as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-masa-kerja" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Jabatan
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Jabatan</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_jabatan as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-jabatan" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Agama
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Agama</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_agama as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-agama" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Status Perkawinan</div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Status Perkawinan</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_ptkp as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-ptkp" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Kategori Pegawai
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Kategori Pegawai</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_kategori as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-kategori" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pendidikan
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Pendidikan</th>
                            <th width="100">Jumlah Pegawai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_pendidikan as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-pendidikan" style="height: 300px; text-align: center;">
                    <span class="chart"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Pegawai
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Pegawai</th>
                            <th width="100">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($data_pegawai as $label => $value) :
                            $total += $value;
                        ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td class="num"><?php echo $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Jumlah</td>
                            <td class="num"><?php echo $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-body">
                <div id="chart-pegawai" class="morrischart" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    <?php
    $kelamin_js = array();
    foreach ($data_kelamin as $label => $value) {
        $kelamin_js[] = array(
            'jenis_kelamin' => $label,
            'value' => $value,
        );
    }

    $masa_js = array();
    foreach ($data_masa as $label => $value) {
        $masa_js[] = array(
            'masa_kerja' => $label,
            'value' => $value,
        );
    }

    $jabatan_js = array();
    foreach ($data_jabatan as $label => $value) {
        $jabatan_js[] = array(
            'jabatan' => $label,
            'value' => $value,
        );
    }

    $agama_js = array();
    foreach ($data_agama as $label => $value) {
        $agama_js[] = array(
            'agama' => $label,
            'value' => $value,
        );
    }

    $ptkp_js = array();
    foreach ($data_ptkp as $label => $value) {
        $ptkp_js[] = array(
            'ptkp' => $label,
            'value' => $value,
        );
    }

    $kategori_js = array();
    foreach ($data_kategori as $label => $value) {
        $kategori_js[] = array(
            'kategori' => $label,
            'value' => $value,
        );
    }

    $pendidikan_js = array();
    foreach ($data_pendidikan as $label => $value) {
        $pendidikan_js[] = array(
            'pendidikan' => $label,
            'value' => $value,
        );
    }

    $pegawai_js = array();
    foreach ($data_pegawai as $label => $value) {
        $pegawai_js[] = array(
            'pegawai' => $label,
            'value' => $value,
        );
    }

    ?>

    $(document).ready(function() {
        Morris.Bar({
            element: 'chart-kelamin',
            data: <?php echo CJSON::encode($kelamin_js); ?>,
            xkey: 'jenis_kelamin',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 9,
        });
        Morris.Bar({
            element: 'chart-masa-kerja',
            data: <?php echo CJSON::encode($masa_js); ?>,
            xkey: 'masa_kerja',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 9,
        });
        Morris.Bar({
            element: 'chart-jabatan',
            data: <?php echo CJSON::encode($jabatan_js); ?>,
            xkey: 'jabatan',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 8,
        });
        Morris.Bar({
            element: 'chart-agama',
            data: <?php echo CJSON::encode($agama_js); ?>,
            xkey: 'agama',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 9,
        });
        Morris.Bar({
            element: 'chart-ptkp',
            data: <?php echo CJSON::encode($ptkp_js); ?>,
            xkey: 'ptkp',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 9,
        });
        Morris.Bar({
            element: 'chart-kategori',
            data: <?php echo CJSON::encode($kategori_js); ?>,
            xkey: 'kategori',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 9,
        });
        Morris.Bar({
            element: 'chart-pegawai',
            data: <?php echo CJSON::encode($pegawai_js); ?>,
            xkey: 'pegawai',
            ykeys: ['value'],
            labels: ['Jumlah Pegawai'],
            parseTime: false,
            lineColors: [getRandomColor()],
            gridTextSize: 9,
        });

        // pie pendidikan
        var pie_val = <?php echo CJSON::encode(array_values($data_pendidikan)); ?>;
        var pie_tooltips = <?php echo CJSON::encode(array_keys($data_pendidikan)); ?>;
        $("#chart-pendidikan").sparkline(pie_val, {
            type: 'pie',
            tooltipFormat: '{{offset:offset}} ({{percent.0}}%)',
            tooltipValueLookups: {
                'offset': pie_tooltips,
            },
            barColor: getRandomColor(),
            height: '280px',
            barWidth: 10,
            barSpacing: 2
        });

    });

    function getRandomColor() {
        var flat_colors = [
            '#16a085', '#27ae60',
            '#2980b9', '#8e44ad',
            '#2c3e50', '#f39c12',
            '#d35400', '#c0392b',
            '#bdc3c7', '#7f8c8d',
            '#1abc9c', '#2ecc71',
            '#3498db', '#9b59b6',
            '#34495e', '#f1c40f',
            '#e67e22', '#e74c3c',
        ];
        var index = Math.floor((Math.random() * 10));
        var color = flat_colors[index];
        return color;
    }
</script>