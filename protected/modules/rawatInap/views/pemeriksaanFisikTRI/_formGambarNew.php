<?php
                $i = 1;
                $gbrTubuh = $modGambarTubuh->AllDataGambarAnatomi;
                $css = '';
                foreach ($gbrTubuh as $tbh) {
                    if ($modPasien->jeniskelamin != $tbh->jeniskelamin) {
                        continue;
                    }
                    if ($i == 1) {
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
                            
                            <!-- <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" data-id="<?php echo $tbh->gambartubuh_id ?>" /> -->

                            <img data-id="<?php echo $tbh->gambartubuh_id; ?>" img-no="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                            <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                        </div>
                    <?php
                     } else {

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
                        <!-- <div align="center" id="imgtag<?php //echo $tbh->gambartubuh_id ?>">
                            
                            <img img-no="<?php //echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $i ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                            <div id="tagbox<?php //echo $tbh->gambartubuh_id ?>"></div>
                        </div> -->
                        <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                        
                            <img data-id="<?php echo $tbh->gambartubuh_id; ?>" img-no="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                            <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                        </div>
                <?php
                    }

                    $i++;
                }
            Yii::app()->clientScript->registerCss('anatomi', $css);
?>