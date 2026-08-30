<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Rencana Kontrol & Surat Perintah Rawat Inap</b></div>
    </div>
    <div class="panel-body">

        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#searchLaporan').submit(function(){
            $.fn.yiiGridView.update('list-rencana-kontrol-grid', {
                    data: $(this).serialize()
            });
            return false;
        });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="icon-white icon-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Data Rencana Kontrol & SPRI</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
            </div>
        </div>       
    </div>
</div>

<script>
    const cekData = () => {
        const message = $(".message-bpjs").data('message');
        
        if (message != ''){            
            myAlert(message,"Perhatian!");
        }
    }
</script>