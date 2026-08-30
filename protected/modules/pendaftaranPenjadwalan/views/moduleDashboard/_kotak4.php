<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/fonts.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/neon.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo-codes.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo-embedded.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/neon-custom.js'); ?>

<style>
	.panel-heading{
		background: none repeat scroll 0 0 #428bca !important;
		color : #eee !important;
	}
</style>

<div class="row">
    <!--Pasien Buat Janji-->
    <div class="col-sm-3 col-xs-6">
        <div class="tile-stats tile-red">
            <div class="icon">
                <i class="entypo-users"></i>
            </div>
            <div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $modBuatJanji; ?>" data-start="0" class="num">0</div>
            <h3>Pasien Buat Janji Poli</h3> <p>Jumlah Pasien yang telah membuat janji.</p>
        </div>
    </div>
    <!--Kunjungan Pasien Hari Ini-->
    <div class="col-sm-3 col-xs-6">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo $modKunjunganToday; ?>" data-start="0" class="num">0</div>
            <h3>Kunjungan Pasien Hari Ini</h3>
            <p><?php echo $tanggal_skg; ?></p>
        </div>
    </div>
    <!--Pasien Baru Hari Ini-->
    <div class="col-sm-3 col-xs-6">
        <div class="tile-stats tile-aqua">
            <div class="icon"><i class="entypo-mail"></i></div>
            <div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $modPasienBaru; ?>" data-start="0" class="num">0</div>
            <h3>Pasien Baru Hari Ini</h3>
            <p>Pasien pengunjung baru <?php echo $tanggal_skg; ?></p>
        </div>
    </div>
    <!--Pasien Lama Hari Ini-->
    <div class="col-sm-3 col-xs-6">
        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-rss"></i></div>
            <div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $modPasienLama; ?>" data-start="0" class="num">0</div>
            <h3>Pasien Lama Hari Ini</h3>
            <p>Pasien pengunjung lama <?php echo $tanggal_skg; ?></p>
        </div>
    </div>
</div>        

<!--Bottom Scripts SCRIPT INI HARUS TETAP BERADA DI BAWAH-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/joinable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/resizeable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-api.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.peity.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.sparkline.min.js"></script>
<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/toastr.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-chat.js"></script>	
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-demo.js"></script>-->
<!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/custom.js"></script>-->
<!--End Bottom Scripts-->