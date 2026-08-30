<style>
    
    .ruler {
        position: relative;
        height: 40px;
        border-top: 1px solid black;
        width: calc(100% - 20px);
        margin-left: 10px;
    }
    
    .ruler .piece {
        position: absolute;
        width: 50px;
        text-align: center;
    }
    
    .ruler .pos_0 {
        left: calc((0% - 25px));
    }
    .ruler .pos_1 {
        left: calc(10% - 25px);
    }
    .ruler .pos_2 {
        left: calc(20% - 25px);
    }
    .ruler .pos_3 {
        left: calc(30% - 25px);
    }
    .ruler .pos_4 {
        left: calc(40% - 25px);
    }
    .ruler .pos_5 {
        left: calc(50% - 25px);
    }
    .ruler .pos_6 {
        left: calc(60% - 25px);
    }
    .ruler .pos_7 {
        left: calc(70% - 25px);
    }
    .ruler .pos_8 {
        left: calc(80% - 25px);
    }
    .ruler .pos_9 {
        left: calc(90% - 25px);
    }
    .ruler .pos_10 {
        left: calc(100% - 25px);
    }
    
    .ruler2 {
        height: 50px;
    }
    
    .ruler2 .pos_b {
        float: right;
        text-align: center;
    }
    .ruler2 .pos_a {
        float: left;
        text-align: center;
    }
    
</style>
<div class="panel panel-success form_skoring form_vas">
    <div class="panel-heading">
        <div class="panel-title">Visual Analog Scale (VAS)</div>
    </div>
    <div class="panel-body">
        <input type="range" id="skor_vas" min="0" max="10" onchange="setSkorVas();" value="<?php echo empty($model->skalanyeri) ? 0 : $model->skalanyeri; ?>" disabled>
        <div class="ruler">
            <label class="piece pos_0">0</label>
            <label class="piece pos_1">1</label>
            <label class="piece pos_2">2</label>
            <label class="piece pos_3">3</label>
            <label class="piece pos_4">4</label>
            <label class="piece pos_5">5</label>
            <label class="piece pos_6">6</label>
            <label class="piece pos_7">7</label>
            <label class="piece pos_8">8</label>
            <label class="piece pos_9">9</label>
            <label class="piece pos_10">10</label>
        </div>
        <div class="ruler2">
            <label class="pos_a">Tidak<br/>Nyeri</label>
            <label class="pos_b">Nyeri<br/>Maksimal</label>
        </div>
        <div class="control-group">
            <label class="control-label">Skor VAS</label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'skalanyeri', array('class' => 'span1 skalanyeri_vas', 'readonly' => true, 'style' => 'text-align:right;')) ?>
                <label>mm</label>
                <?php echo CHtml::activeTextField($model, 'keterangan_skalanyeri', array('class' => 'keterangan_skalanyeri_vas span3', 'readonly' => true, 'style' => 'text-align:left;')) ?>
            </div>
        </div>
    </div>
</div>

<script>
    
    function setSkorVas() {
        var skor = $("#skor_vas").val();
        var keterangan = "";
        
        if (skor < 1) {
            keterangan = "Tidak Nyeri";
        } else if (skor < 3) {
            keterangan = "Nyeri Ringan";
        } else if (skor < 7) {
            keterangan = "Nyeri Sedang";
        } else if (skor < 9) {
            keterangan = "Nyeri Berat";
        } else {
            keterangan = "Nyeri Sangat Berat";
        }
        
        
        
        $(".skalanyeri_vas").val(skor);
        $(".keterangan_skalanyeri_vas").val(keterangan);
    }
    
    $(document).ready(function() {
        setSkorVas();
    });
    
</script>