<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Petunjuk Penentuan Risk Register </strong></div>
    </div>
    <div class="panel-body">
        <br>
        <div>
            <?php 
            $path = Params::pathPetunjukTransaksiDirectory() . $modPetunjuk->petunjuktransaksi_image;
            if (file_exists($path)) {
                $pdf = Params::urlPetunjukTransaksiDirectory() . $modPetunjuk->petunjuktransaksi_image;
            }else{
                $pdf = "";
            }
            ?>
            <iframe src="<?= $pdf ?>" style="width:100%;height:700px;"></iframe>
        </div>
    </div>
</div>