<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Mutasi Pegawai
        </div>
        <div class="panel-options">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#batang-chart" onclick="cari(this)" id="cari_batang" data-toggle="tab">Batang</a></li>
                <li class=""><a href="#garis-chart" onclick="cari(this)" id="cari_garis" data-toggle="tab">Garis</a></li>
                <li class=""><a href=".pie-chart" onclick="cari(this)" id="cari_pie" data-toggle="tab">Pie</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active up" id="batang-chart">
                <canvas id="batang"></canvas>
            </div>
            <div class="tab-pane up" id="garis-chart">
                <canvas id="garis"></canvas>
            </div>
            <div class="tab-pane pie-chart">
                <?= Chtml::dropDownList('unit_kerja', '', $unit, ['prompt' => 'All Unit', 'class' => 'span4'])  ?>
            </div>
            <div class="tab-pane up col-md-12 pie-chart" id="pie-chart">
                <canvas id="pie"></canvas>
            </div>
        </div>
    </div>
</div>