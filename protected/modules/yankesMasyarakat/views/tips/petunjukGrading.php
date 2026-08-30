<?php
if (!empty($modPetunjuk))
{
    $path = Params::pathPetunjukTransaksiDirectory() . $modPetunjuk->petunjuktransaksi_image;
    if (file_exists($path))
    {
        $pdf = Params::urlPetunjukTransaksiDirectory() . $modPetunjuk->petunjuktransaksi_image;
    }
    else
    {
        $pdf = "";
    }
}
else
{
    $pdf = "";
}
?>
<iframe src="<?= $pdf ?>" style="width:100%;height:750px;"></iframe>