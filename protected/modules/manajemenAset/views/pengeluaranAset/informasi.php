<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link        http://172.9.1.15/simpp/docs/
 * untuk menampilkan informasi mutasi aset
 * untuk menampilkan informasi pengeluaran aset
 * RSST-1620
 * RSST-1639
 */
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripengeluaranaset-form').submit(function(){
            $.fn.yiiGridView.update('informasi-mutasi-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengeluaran Aset</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . 'informasi/_search', array('model' => $model)); ?>
        <?php echo $this->renderPartial('informasi/table', array('model' => $model)) ?>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pengeluaran Aset',
        'autoOpen' => false,
        'minWidth' => 900,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    function ubahStatus(st, mutasiaset_id) {
        myConfirm("Apakah Anda yakin ingin mengubah status mutasi ini menjadi <b>" + st + "</b>", "Perhatian !", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('ubahStatus'); ?>',
                    data: {
                        st: st,
                        mutasiaset_id: mutasiaset_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == 1) {
                            $.fn.yiiGridView.update('informasi-mutasi-grid');
                        } else {
                            myAlert(data.pesan)
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>