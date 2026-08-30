<?php if(!empty($models)){
    $arrFaq = array(); 
    foreach($models as $dataFaq){
        $arrFaq[$dataFaq->modul_id]['modul_nama'] = $dataFaq->modul_nama;
        $arrFaq[$dataFaq->modul_id]['modul_id'] = $dataFaq->modul_id;
        $arrFaq[$dataFaq->modul_id]['detail'][] = array('pertanyaan'=>$dataFaq->faq_pertanyaan,'jawaban'=>$dataFaq->faq_jawaban);
    }
    
    ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="menuFaq">
                    <ul id="main-menu">
                        <?php 
                            foreach($arrFaq as $faqModul){
                                ?>
                                    <li class="menuLi" id="menuLi_<?php echo $faqModul['modul_id']; ?>"><a href="javascript:void(0);" id_modul="<?php echo $faqModul['modul_id']; ?>" onclick='setMenuKlik(this);'> <?php echo $faqModul['modul_nama']; ?> <i id="menuIcon_<?php echo $faqModul['modul_id']; ?>" class="entypo-right-open"></i></a> </li>
                                <?php
                            }
                        ?>
                        
                    </ul>
                </div>
                
            </div>
            <div class="col-sm-9 menuFaq-content">
            <?php 
                foreach($arrFaq as $faqModul){
                    ?>
                        <div class="content_faq" id="content_faq_<?php echo $faqModul['modul_id']; ?>">
                            <?php 
                            $ind = 0;
                                foreach($faqModul['detail'] as $i=> $detail){
                                    if($ind > 0){
                                        echo '<br/>';
                                    }
                                    $ind += 1;

                                    ?>
                                        <p style="font-weight: bold; text-decoration: underline"><?php echo $detail['pertanyaan']; ?></p>
                                        <?php echo $detail['jawaban']; ?>
                                    <?php
                                }
                            ?>
                        </div>
                    <?php
                }
            ?>           
            </div>

          </div> 
    <?php 
}else{
    echo 'Data Pencarian Faq Tidak Ditemukan!!';
} ?>