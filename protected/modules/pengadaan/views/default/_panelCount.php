<?php
/**
 * Panel Count Statistik
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category New Feature RSST-8627
 * 
 */
?>
<hr>
<div class="row">
    <div class="col-md-4">
        <div class="tile-stats tile-red" style="background: #FAA788">
            <div class="icon"><i class="glyphicon glyphicon-list-alt"></i></div>
            <div class="col-md-6">
                <div id="tile1" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['rup_penyedia']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="col-md-6">
                <h4 style="color: white;text-align:right;">RUP Penyedia</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="tile-stats tile-green" style="background: #FB7B83">
            <div class="icon"><i class="glyphicon glyphicon-folder-open"></i></div>
            <div class="col-md-6">
                <div id="tile2" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['spk_penyedia']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="col-md-6">
                <h4 style="color: white;text-align:right;">Kontrak</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="tile-stats tile-blue" style="background: #AAB6FB">
            <div class="icon"><i class="entypo-newspaper"></i></div>
            <div class="col-md-6">
                <div id="tile3" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['nota_pptk']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="col-md-6">
                <h4 style="color: white;text-align:right;">Nota Dinas PPTK Penyedia</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="tile-stats tile-brown" style="background: #6096FD">
            <div class="icon"><i class="glyphicon glyphicon-list-alt"></i></div>
            <div class="col-md-6">
                <div id="tile4" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['rup_swakelola']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="col-md-6">
                <h4 style="color: white;text-align:right;">RUP Swakelola</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="tile-stats tile-aqua" style="background: #2743c2; opacity: 0.9">
            <div class="icon"><i class="entypo-newspaper"></i></div>
            <div class="col-md-6">
                <div id="tile5" style="font-size:6vw" class="num" data-start="0" data-end="<?= $count['nota_swakelola']  ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
            </div>
            <div class="col-md-6">
                <h4 style="color: white;text-align:right;">Nota Dinas PPTK<br>Swakelola</h4>
            </div>
        </div>
    </div>
</div>
<hr>