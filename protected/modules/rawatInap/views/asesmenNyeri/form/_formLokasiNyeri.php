<?php

/**
 * - digunakan untuk menginput lokasi nyeri
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 */
?>
<style>
    .groupUkurans {
        display: inline;
    }
</style>
<style>
    .hoveringIcon:hover {
        background-color: #FFA0A2;
        cursor: pointer;
        -webkit-border-radius: 1px;
        -moz-border-radius: 1px;
        -o-border-radius: 1px;
        -border-radius: 1px;
    }

    .taggd:hover {
        cursor: crosshair;
    }

    /*--------------------------*/
    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: center;
    }

    .tagview {
        border: 1px solid #F10303;
        width: 100px;
        height: 100px;
        position: absolute;
        /*display:none;*/
        opacity: 0;
        color: #FFFFFF;
        text-align: center;
    }

    .square {
        display: block;
        height: 79px;
    }

    .person {
        background: #282828;
        border-top: 1px solid #F10303;
    }

    #tagit {
        position: absolute;
        top: 0;
        left: 0;
        width: 300px;
        border: 1px solid #D7C7C7;
    }

    /*			#tagit .box
									{
											border: 1px solid #F10303;
											width: 10px;
											height: 10px;
											float: left;
									}*/
    #tagit .name {
        /*float: left;*/
        background-color: #FFF;
        width: 295px;
        /*height: 92px;*/
        /*padding: 5px;*/
        font-size: 10pt;
        margin: 0 auto;
        margin-bottom: 0 auto;
    }

    #tagit DIV.text {
        margin-bottom: 5px;
    }

    #tagit INPUT[type=text] {
        margin-bottom: 5px;
    }

    #tagit #tagname {
        width: 110px;
    }

    #taglist {
        width: 300px;
        min-height: 200px;
        height: auto !important;
        height: 200px;
        float: left;
        padding: 10px;
        margin-left: 20px;
        color: #000;
    }

    #taglist OL {
        padding: 0 20px;
        float: left;
        cursor: pointer;
    }

    #taglist OL A {}

    #taglist OL A:hover {
        text-decoration: underline;
    }

    .tagtitle {
        font-size: 14px;
        text-align: center;
        width: 100%;
        float: left;
    }
</style>
<div class="col-sm-6">
    <div class="panel">

        <div class="panel-body" style="width:412px !important;">
            <?php
            $i = 1;
            $css = null;
            $gbrTubuh = $modGambarTubuh->AllDataGambarAsesmenNyeri;
            foreach ($gbrTubuh as $tbh) {
                if ($i == 1) {
                    $css = " 
								#imgtag" . $tbh->gambartubuh_id . "
								{
										position: relative;
										min-width: 300px;
										min-height: 300px;
										float: none;
										border: 3px solid #FFF;
										cursor: crosshair;
										text-align: center;
										z-index:10 !important;
								}
								#tagit" . $tbh->gambartubuh_id . "
								{
										position: absolute;
										top: 0;
										left: 0;
										width: 300px;
										border: 1px solid #D7C7C7;
										z-index: 10;
								}
								#tagit" . $tbh->gambartubuh_id . " .name
								{
										/*float: left;*/
										background-color: #FFF;
										width: 295px;
										/*height: 92px;*/
										/*padding: 5px;*/
										font-size: 10pt;
										margin:0 auto;
										margin-bottom: 0 auto;
								}
								#tagit" . $tbh->gambartubuh_id . " DIV.text
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
								{
										width: 110px;
								}";
            ?>
                    <!--<div align="center" id="imgtag">
									<img img-no="" alt="<?php //echo $tbh->gambartubuh_id 
                                                        ?>"  id="myImgId" src="<?php //echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; 
                                                                                ?>" class="taggd"/> 
							<div id="tagbox"></div>
							</div>-->
                    <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                        <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh() . $tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                        <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                    </div>
                <?php
                } else {

                    //if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD ||  Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
                    $css .= " 
                                #imgtag" . $tbh->gambartubuh_id . "
                                {
                                        position: relative;
                                        min-width: 300px;
                                        min-height: 300px;
                                        float: none;
                                        border: 3px solid #FFF;
                                        cursor: crosshair;
                                        text-align: center;
										z-index:10 !important;
                                }
                                #tagit" . $tbh->gambartubuh_id . "
                                {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 300px;
                                        border: 1px solid #D7C7C7;
                                        z-index: 10;
                                }
                                #tagit" . $tbh->gambartubuh_id . " .name
                                {
                                        /*float: left;*/
                                        background-color: #FFF;
                                        width: 295px;
                                        /*height: 92px;*/
                                        /*padding: 5px;*/
                                        font-size: 10pt;
                                        margin:0 auto;
                                        margin-bottom: 0 auto;
                                }
                                #tagit" . $tbh->gambartubuh_id . " DIV.text
                                {
                                        margin-bottom: 5px;
                                }
                                #tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
                                {
                                        margin-bottom: 5px;
                                }
                                #tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
                                {
                                        width: 110px;
                                }";
                ?>
                    <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                        <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $i ?>" src="<?php echo Params::urlPhotoAnatomiTubuh() . $tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                        <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                    </div>
            <?php
                }
                //}
                $i++;
            }
            if (!empty($css)) {
                Yii::app()->clientScript->registerCss('anatomi', $css);
            }
            ?>
            <?php /*
					<div align="center" id="imgtag">
						<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
						<div id="tagbox"></div>
					</div>
                     * 
                     */ ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div class='block-tabel'>
                <table class="table border" id="table-bagtubuh">
                    <thead>
                        <tr>
                            <th width='30'>No.</th>
                            <th>Bagian Tubuh</th>
                            <th>Keterangan</th>
                            <th width='80'>Batal / Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($modPemeriksaanGambar)) {
                            $i = 1;
                            $a = 0;
                            foreach ($modPemeriksaanGambar as $ii => $vv) {
                                $vv->namabagtubuh = $vv->bagiantubuh->namabagtubuh;
                                $vv->kordinat_tubuh_x = number_format($vv->kordinat_tubuh_x, 7);

                                //var_dump($vv->kordinat_tubuh_y);
                                echo $this->renderPartial($this->path_view . "form/_rowDetail", array('modPemeriksaanGbr' => $vv, 'i' => $i, 'a' => $a), true);
                                $i++;
                                $a++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>