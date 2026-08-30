<div class="panel panel-default" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Pelaporan insiden bulan ini
        </div>
        <div class="panel-options">
            <ul class="nav nav-tabs">
                <li class=""><a href="#area-chart" data-toggle="tab">Area</a></li>
                <li class="active"><a href="#line-chart" data-toggle="tab">Garis</a></li>
                <li class=""><a href="#donut-chart" data-toggle="tab">Donout</a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane" id="area-chart">
                <canvas id="tigagrafik-area"></canvas>
            </div>
            <div class="tab-pane active" id="line-chart">
                <canvas id="tigagrafik-line"></canvas>
            </div>
            <div class="tab-pane " id="donut-chart">
                <canvas id="tigagrafik-doughnut"></canvas>
            </div>
        </div>
    </div>
</div>