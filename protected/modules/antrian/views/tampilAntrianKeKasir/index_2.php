<style>
    body{
        background-image:url("<?php echo isset($modLayar->layarantrian_latarbelakang)?Params::urlBackgroundAntrian().$modLayar->layarantrian_latarbelakang:''; ?>");
        background-repeat:no-repeat;
        /*width:980px;*/
        color:#000;
    }
	.content {
		margin: 146px 20px 20px 20px;
	}
/*    div{
        font-size: 20px;
        font-weight:bold;
        letter-spacing:2px;
        color: #fff;
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
    }*/
    td{
        text-align: right;
        padding-right: 20px;
    }
    .judul{
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0;
    }
    
    .no-antrian{
  
    }
    .b1{background-color:rgba(39, 62, 29, 0.7);border:1px solid #fff;border-right:none;-webkit-border-radius:5px 0 0 5px;-moz-border-radius:5px 0 0 5px;border-radius:5px 0 0 5px;}
    .b2{background-color:rgba(219, 219, 211, 0.5);border:1px solid #fff;border-left:none;-webkit-border-radius:0 5px 5px 0;-moz-border-radius:0 5px 5px 0;border-radius:0 5px 5px 0;}
    .cont > div{
        color:#fff;
        text-align: center;
        font-size: 46px;
        font-weight: bold;
        text-shadow:
            -2px -2px 0 #000,  
             1px -2px 0 #000,
             -2px 2px 0 #000,
              2px 2px 0 #000;
              margin-bottom: 12px;
    }
    .pasien-deskripsi{
        /*font-size: 70%;*/
        width: <?php echo isset($modLayar->layarantrian_itemwidth)?$modLayar->layarantrian_itemwidth:''; ?>;
        height: 20px;
    }
    /*.statistik{
        color:#fff;
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
        background-color:rgba(0,0,0,0.8);
    }*/
</style>

<div class="row judul"><?php echo isset($modLayar->layarantrian_judul)?$modLayar->layarantrian_judul:''; ?></div>
    <?php 
    if(count((array)$modRuangans) > 0){
        foreach($modRuangans AS $i=>$ruangan){
            if(($i==0)||($i) % 3 == 0){
                echo '<div class="row">';
            }    ?>
            <div id="data-antrian">
                <div class="row cont">
                    <div class="col-sm-6 b1">No. Urut</div>
                    <div class="col-sm-6 no-antrian b2"><?php echo isset($ruangan->ruangan->ruangan_singkatan)?$ruangan->ruangan->ruangan_singkatan:''; ?>-000</div>
                </div>
                <div class="row cont">
                    <div class="col-sm-6 b1">Loket</div>
                    <div class="col-sm-6 loket b2">XXXXX-0</div>
                </div>
                <div class="row cont">
                    <div class="col-sm-6 b1">Nama Pasien</div>
                    <div class="col-sm-6 pasien b2">-</div>
                </div>
                <?php echo CHtml::hiddenField('ruangan', isset($ruangan->ruangan_id)?$ruangan->ruangan_id:'',array('id'=>'ruangan')); ?>
            </div>
            
    <?php
            if(($i+1>0)&&(($i+1) % 3 == 0)){
                echo '</div>';
            }
        }
    } 
    ?>
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'konfig'=>$konfig)); ?>
<div id="suarapanggilan"></div> <!-->