<?php 
/**
 * digunakan untuk pembuatan interface beranda penelitian kesehatan
 * menampilkan dalam bentuk tile 
 * RSST-2633
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<div class="col-md-12" style="padding-left:0;padding-right:0px">

    <div class="tile-stats tile-orange">
        <div class="icon"><i class="entypo-shuffle"></i></div>
        <div class="col-sm-6">
            <div id="tile2" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo "0" ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
        </div>
        <div class="col-sm-6">

            <h4 style="color: white"><b>Total </b><br>Transaction</h4>
        </div>

    </div>

</div>
<div class="col-md-12" style="padding-left:0;padding-right:0px">
    <div class="tile-stats tile-aqua">
        <div class="icon"><i class="entypo-mail"></i></div>
        <div class="col-sm-6">
            <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?php echo "0" ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
        </div>
        <div class="col-sm-6">
            <h4 style="color: white"><b>Total </b><br>SMS</h4>
        </div>
    </div>
</div>

