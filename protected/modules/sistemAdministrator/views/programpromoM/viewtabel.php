<style>
    .card-image img{
        width:100%; 
        border-top-left-radius:5px;
        border-top-right-radius:5px;
        height:200px;
    }
    .card-image {
        background-color: #a3a3a3;
        border-top-left-radius:5px;
        border-top-right-radius:5px;
    }

    .card-wrapper{
        margin:5px;  border: 1px solid #c6c6c6; height:300px;

        border-radius:5px;
        border-radius:5px;
        position:relative;
        background: url("data/images/informasi/promo.svg");
        background-repeat: no-repeat;
        background-size: 100%;
        border-top-left-radius:15px;
        border-top-right-radius:15px;
    }
    .lihatlengkap{
        position:absolute;
        bottom:0;
        left:0;
        width:100%;
        padding:15px;
    }
    .card-konten{
        padding:15px;
        font-size:14pt;
        background-color: rgba(255, 255, 255, 0.8);
    }
    .card-kepala{
        weight:bold;
        font-size:16pt;
       background-color: rgba(195, 33, 150, 0.95);
        text-align:center;
        height:150px;
        color:white;
       border-top-left-radius:15px;
        border-top-right-radius:15px;
        border-bottom: 5px solid #a8157e;
      
    }
    .card-isi{
        
        font-size:10pt;
        color:black;
    }
</style>





    <div class="col-sm-12 col-md-3 ">
                    <div class="card-wrapper ">
                       
                        <div class="card-content">
                             
                            <div class="card-kepala">
                               
                                    <div class="num" style="padding-top:10px;font-size:24pt">
                                        <?php
                                        $stringCut = strip_tags($data->namaprogrampromo);
                                        
                                        echo $stringCut;
                                       
                                        ?> 
                                        <br>
                                        <div style="font-size:12pt">
                                            <?php
                                        $stringCut = strip_tags($data->keterangan);
                                        $panjang = strlen($stringCut);
                                        if (strlen($stringCut) > 15) {
                                            $stringCut = substr($stringCut, 0, 15);
                                            //$string = substr($stringCut, 0, strrpos($stringCut, ' '));
                                        }
                                        echo $stringCut;
                                        if ($panjang > 15) {
                                            echo "..";
                                        }
                                        ?> 
                                        </div>
                                    </div>
                                 <div class="num" style="padding-top:35px;">
                                        

                                    </div>
                                </div>
                            <div class="card-konten">
                                
                                <div class="card-isi">
                                  
                                    <div class="num">
                                          <?= (str_word_count("$data->deskripsi") > 20 ? substr("$data->deskripsi",0,100)."[..]" : "$data->deskripsi") ?>
                                    </div>   
                                </div>
                                <div class="lihatlengkap" >
                                   
                                    <?php  echo CHtml::link("<button class = 'btn btn btn-success ' style = 'width:100%; background-color:#840b62;border-color:#840b62;'>Baca Selengkapnya</button>",Yii::app()->controller->createUrl("/sistemAdministrator/programpromoM/keterangan",array("programpromo_id"=>$data->programpromo_id)),
                                //  array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialogs').dialog('open');}",
                                array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"frameDetail", "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");", "rel"=>"tooltip",'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
                              //  array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Implementasi Asuhan Keperawatan", "onclick"=>"window.parent.$(\'#dialogDetailsTarif\').dialog(\'open\')")),
                                      'rel'=>'tooltip','title'=>'Klik untuk lihat '.$data->getAttributeLabel('deskripsi'))) ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>  


