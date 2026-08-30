<style>
    .card-red {
        width: 20rem;
        background-color: #952323;
        padding: 10px 25px;
        color: white !important;
        position: relative;
    }

    .card-green {
        width: 20rem;
        background-color: #5D9C59;
        padding: 10px 25px;
        color: white !important;
        position: relative;
    }

    .card-body h3,
    h6 {
        color: white !important;
    }

    .centered-icon {
        position: absolute;
        top: 20%;
        /* transform: translateY(-50%); */
        right: 0;
        margin-right: 10px;
        font-size: 50px;
    }

    .grid-container {
        display: grid;
        column-gap: 50px;
        row-gap: 50px;
        grid-template-columns: 33% 33% 33%;
        background-color: #053B50;
        padding: 20px;
    }

    .title-dashboard h3 {
        color: black;
    }

    .title-dashboard {
        background-color: #176B87;
        padding: 10px;
    }

    .background {
        background-color: #053B50;
    }

    body {
        background-color: #053B50;
    }
</style>

<body>
    <div class="background">
        <div class="title-dashboard">
            <h3>Dashboard Koneksi Server BPJS Vclaim Bridging</h3>
            <p>BaseUrl: <?php echo $modKonfig->bpjs_host ?></p>
        </div>
        <div class="grid-container">
            <?php
            $bpjs = new BpjsVklaim;
            $modApiBpjs = ApibpjsK::model()->findAll("resposnse_time is not null and keterangan = 'vclaim'");
            $arr_url_bpjs = array_keys($bpjs->server_new);
            foreach ($modApiBpjs as $items) {
                $name_api = array_search($items->api, $bpjs->server_new);
                $timeout_time = $modKonfig->apitransactiontimeout * 100;
                if ($items->resposnse_time < $timeout_time) {
                    $is_terhubung = "Terhubung";
                    $class_terhubung = "card-green";
                    $icon_terhubung = "fa fa-check-circle";
                } else {
                    $is_terhubung = "Terputus";
                    $class_terhubung = "card-red";
                    $icon_terhubung = "fa fa-times-circle-o";
                }
            ?>
                <div class="card <?php echo $class_terhubung; ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $is_terhubung ?></h3>
                        <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $name_api ?> </h6>
                        <p class="card-text">Response Time: <?php echo ceil($items->resposnse_time) ?>ms</p>
                        <div class="centered-icon">
                            <i class="<?php echo $icon_terhubung; ?>" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            <?php }  ?>
        </div><br>
    </div>

    <div class="background">
        <div class="title-dashboard">
            <h3>Dashboard Koneksi Server BPJS Antrol</h3>
            <p>BaseUrl: <?php echo $modKonfig->bpjs_host ?></p>
        </div>
        <div class="grid-container">
            <?php
            $bpjs = new AntrianOnlineBpjs;
            $modApiBpjs = ApibpjsK::model()->findAll("resposnse_time is not null and keterangan = 'antrol'");
            $arr_url_bpjs = array_keys($bpjs->server_new);
            foreach ($modApiBpjs as $items) {
                $name_api = array_search($items->api, $bpjs->server_new);
                $timeout_time = $modKonfig->apitransactiontimeout * 100;
                if ($items->resposnse_time < $timeout_time) {
                    $is_terhubung = "Terhubung";
                    $class_terhubung = "card-green";
                    $icon_terhubung = "fa fa-check-circle";
                } else {
                    $is_terhubung = "Terputus";
                    $class_terhubung = "card-red";
                    $icon_terhubung = "fa fa-times-circle-o";
                }
            ?>
                <div class="card <?php echo $class_terhubung; ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $is_terhubung ?></h3>
                        <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $name_api ?> </h6>
                        <p class="card-text">Response Time: <?php echo ceil($items->resposnse_time) ?>ms</p>
                        <div class="centered-icon">
                            <i class="<?php echo $icon_terhubung; ?>" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            <?php }  ?>
        </div><br>
    </div>
</body>

<script>
    setTimeout(function() {
        location.reload();
    }, 15000);
</script>