<style>
    .size-anchor-a,
    .size-anchor-b {
        display: inline;
    }

    .num {
        line-height: 38px;
    }
</style>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-red container-anchor-a">
        <div class="icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="num size-anchor-a"><?php echo isset($dataKolom[1]) ? number_format($dataKolom[1], 0, ' ', '.') : 0; ?></div>
        <h3>Penerimaan Umum</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-green container-anchor-b">
        <div class="icon">
            <i class="fas fa-coins"></i>
        </div>
        <div class="num size-anchor-b"><?php echo isset($dataKolom[2]) ? number_format($dataKolom[2], 0, ' ', '.') : 0; ?></div>
        <h3>Pengeluaran Umum</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-aqua">
        <div class="icon">
            <span class="fa-stack">
                <i class="fas fa-ban fa-stack-2x"></i>
                <i class="fas fa-boxes fa-stack-1x"></i>
            </span>
        </div>
        <div class="num"><?php echo isset($dataKolom[3]) ? $dataKolom[3] : 0; ?></div>
        <h3>Batal Pengeluaran Umum</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<div class="col-md-3 col-sm-6 col-sm-12">
    <div class="tile-stats tile-blue">
        <div class="icon">
            <span class="fa-stack">
                <i class="fas fa-ban fa-stack-2x"></i>
                <i class="fas fa-dolly-flatbed fa-stack-1x"></i>
            </span>
        </div>
        <div class="num"><?php echo isset($dataKolom[4]) ? $dataKolom[4] : 0; ?></div>
        <h3>Batal Bayar Supplier</h3>
        <p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
    </div>
</div>

<script>
    let lebara = $('.size-anchor-a').width();
    let lebarb = $('.size-anchor-b').width();
    let containera = $('.container-anchor-a').width();
    let containerb = $('.container-anchor-b').width();
    let standar = 38;

    $(window).resize(function() {
        if (lebara > (containera - 40)) {
            lebara = lebara / 12;
            $('.size-anchor-a').css("font-size", lebara);
        } else {
            $('.size-anchor-a').css("font-size", standar + "px");
        }

        if (lebarb > (containerb - 40)) {
            lebarb = lebarb / 12;
            $('.size-anchor-b').css("font-size", lebarb);
        } else {
            $('.size-anchor-b').css("font-size", standar + "px");
        }
    });
</script>