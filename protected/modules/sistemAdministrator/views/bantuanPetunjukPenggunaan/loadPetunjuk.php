<?php if(!empty($models)){
    $arrPetunjuk = array(); 
    foreach($models as $dataPetunjuk){
        $arrPetunjuk[$dataPetunjuk->modul_id]['modul_nama'] = $dataPetunjuk->modul_nama;
        $arrPetunjuk[$dataPetunjuk->modul_id]['modul_id'] = $dataPetunjuk->modul_id;
        $arrPetunjuk[$dataPetunjuk->modul_id]['petunjukpenggunaan_deskripsi'] = $dataPetunjuk->petunjukpenggunaan_deskripsi;
        $arrPetunjuk[$dataPetunjuk->modul_id]['detail'][$dataPetunjuk->menu_id] = array('menu'=>$dataPetunjuk->menu_nama,'menu_id'=>$dataPetunjuk->menu_id,'detail_petunjuk'=>array());

        $modPetunjukDetail = PetunjukpenggunaandetailM::model()->findAllByAttributes(array('petunjukpenggunaan_id'=>$dataPetunjuk->petunjukpenggunaan_id));
        if(!empty($modPetunjukDetail)){
            foreach($modPetunjukDetail as $detailPetunjuk){
                $arrPetunjuk[$dataPetunjuk->modul_id]['detail'][$dataPetunjuk->menu_id]['detail_petunjuk'][] =  array('image_petunjuk'=>$detailPetunjuk->petunjukpenggunaandetail_image);
            }
        }

    }
    // echo '<pre>';
    // print_r($arrPetunjuk);
    // exit();
    
    ?>

    <style>
        .main-else{
            margin: 10px 80px;
        }
    </style>
        <div class="row">
            <?php 
            $mod = Yii::app()->user->getState('modul_id') ;
            // echo CJSON::encode($models);
                if($mod == 1){ ?>
                    <div class="col-sm-3">
                        <!-- SIDEBAR -->
                        <div class="menu_sidebar">
                            
                            <ul id="main-menu">
                                <?php 
                                // echo CJSON::encode($arrPetunjuk);
                                $mod = Yii::app()->user->getState('modul_id') ;
                                // echo CJSON::encode($mod);
                                
                                    foreach($arrPetunjuk as $bantuanModul){
                                        if($mod == 1){ 
                                            ?>
                                            <li class="menuLi" id="menuLi_<?php echo $bantuanModul['modul_id']; ?>"><a href="javascript:void(0);" id_modul="<?php echo $bantuanModul['modul_id']; ?>" onclick='setMenuKlik(this);'> <?php echo $bantuanModul['modul_nama']; ?> <i id="menuIcon_<?php echo $bantuanModul['modul_id']; ?>" class="entypo-right-open"></i></a> </li>
                                        <?php
                                        }
                                        ?>
                                            
                                        <?php
                                    }
                                ?>
                                
                            </ul>
                        </div>
                        
                    </div>
                    <!-- MAIN -->
                    <div class="col-sm-9 menubantuan-content">
                    <?php 
                        foreach($arrPetunjuk as $bantuanModul){
                            ?>
                                <div class="content_bantuan" id="content_bantuan_<?php echo $bantuanModul['modul_id']; ?>">
                                <h2>Petunjuk Penggunaan</h2>
                                <br/>
                                <?php echo $bantuanModul['petunjukpenggunaan_deskripsi'] ?>    
                                <br/>
                                <hr />
                                    <?php 
                                    $ind = 0;
                                        foreach($bantuanModul['detail'] as $detailMenu){
                                            if($ind > 0){
                                                echo '<br/>';
                                            }
                                            $ind += 1;
                                            ?>
                                            <div style="cursor: pointer; padding-top: 10px; padding-bottom: 10px; text-decoration: underline;" class="menu_<?php echo $bantuanModul['modul_id']; ?>" id="menu_<?php echo $bantuanModul['modul_id']; ?>_<?php echo $detailMenu['menu_id']; ?>" id_menu="<?php echo $detailMenu['menu_id']; ?>" id_modul="<?php echo $bantuanModul['modul_id']; ?>" onclick="setPetunjukKlik(this)"> 
                                                <?php echo $detailMenu['menu']; ?>    
                                            </div>
                                            <div class="menucontent_<?php echo $bantuanModul['modul_id']; ?>" id="menucontent_<?php echo $bantuanModul['modul_id']; ?>_<?php echo $detailMenu['menu_id']; ?>" >
                                                <?php 
                                                $indImg = 0;
                                                    foreach($detailMenu['detail_petunjuk'] as $detailImg){
                                                        if($indImg > 0){
                                                            echo '<br/>';
                                                        }
                                                        $indImg++;
                                                        if(!empty($detailImg['image_petunjuk']) && file_exists(Params::pathPetunjukPenggunaanDirectory().$detailImg['image_petunjuk'])){
                                                            echo '<img src="'.Params::urlPetunjukPenggunaanDirectory().$detailImg['image_petunjuk'].'" style="max-width: 700px; max-height: 500px" />';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                                
                                            <?php
                                        }
                                    ?>
                                </div>
                            <?php
                        }
                    ?>           
                </div>
               <?php }else { ?>
                <!-- <div class="container"> -->
                    <div class="main-else menubantuan-content">
                        <?php 
                            foreach($arrPetunjuk as $bantuanModul){
                                ?>
                                    <div class="content_bantuan" id="content_bantuan_<?php echo $bantuanModul['modul_id']; ?>">
                                    <h2>Petunjuk Penggunaan</h2>
                                    <br/>
                                    <?php echo $bantuanModul['petunjukpenggunaan_deskripsi'] ?>    
                                    <br/>
                                    <hr />
                                        <?php 
                                        $ind = 0;
                                            foreach($bantuanModul['detail'] as $detailMenu){
                                                if($ind > 0){
                                                    echo '<br/>';
                                                }
                                                $ind += 1;
                                                ?>
                                                <div style="cursor: pointer; padding-top: 10px; padding-bottom: 10px; text-decoration: underline;" class="menu_<?php echo $bantuanModul['modul_id']; ?>" id="menu_<?php echo $bantuanModul['modul_id']; ?>_<?php echo $detailMenu['menu_id']; ?>" id_menu="<?php echo $detailMenu['menu_id']; ?>" id_modul="<?php echo $bantuanModul['modul_id']; ?>" onclick="setPetunjukKlik(this)"> 
                                                    <?php echo $detailMenu['menu']; ?>    
                                                </div>
                                                <div class="menucontent_<?php echo $bantuanModul['modul_id']; ?>" id="menucontent_<?php echo $bantuanModul['modul_id']; ?>_<?php echo $detailMenu['menu_id']; ?>" >
                                                    <?php 
                                                    $indImg = 0;
                                                        foreach($detailMenu['detail_petunjuk'] as $detailImg){
                                                            if($indImg > 0){
                                                                echo '<br/>';
                                                            }
                                                            $indImg++;
                                                            if(!empty($detailImg['image_petunjuk']) && file_exists(Params::pathPetunjukPenggunaanDirectory().$detailImg['image_petunjuk'])){
                                                                echo '<img src="'.Params::urlPetunjukPenggunaanDirectory().$detailImg['image_petunjuk'].'" style="max-width: 700px; max-height: 500px" />';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                    
                                                <?php
                                            }
                                        ?>
                                    </div>
                                <?php
                            }
                        ?>           
                    </div>
                <!-- </div> -->
            <?php
                }
            ?>

          </div> 
    <?php 
}else{
    echo 'Data Pencarian Bantuan Petunjuk Penggunaan Tidak Ditemukan!!';
} ?>