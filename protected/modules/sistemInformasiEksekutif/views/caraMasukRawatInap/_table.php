<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Jumlah Rawat Inap Berdasarkan Cara Masuk</b>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'penilaian-indikator-m-search',
        ));
        ?>
        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($model, 'instalasi_id', array('class' => 'span3')); ?>
        <?php $this->endWidget(); ?>
        <br>
        <?php
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchTabelPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $model->searchTabel();
            $template = "{summary}\n{items}\n{pager}";
        }
        // format date for value
        if ($model->jns_periode == "bulan") {
            $value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";
        } elseif ($model->jns_periode == "tahun") {
            $value = "date('Y',(strtotime(" . "$" . "data->periode)))";
        } else {
            $value = "MyFormatter::formatDateTimeForUser(date('Y-m-d',(strtotime(" . "$" . "data->periode))))";
        }
        ?>
        <?php
        $this->widget($table, array(
            'id' => 'table-grid',
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Periode',
                    'type' => 'raw',
                    'value' => "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))",
                    'footer' => 'Total',
                ),
                array(
                    'header' => 'Melalui Rawat Darurat',
                    'name' => 'jumlah_rd',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_rd)',
                    'footer' => 'sum(jumlah_rd)',
                ),
                array(
                    'header' => 'Melalui Rawat Jalan',
                    'name' => 'jumlah_rj',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlah_rj)',
                    'footer' => 'sum(jumlah_rj)',
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                        $("table").find("select").each(function(){
                            cekForm(this);
                        })
                    }',
        ));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $js = <<< JSCRIPT
                        function cekForm(obj)
{
    $("#penilaian-indikator-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function printTabel(caraPrint)
{
    window.open("${urlPrint}/"+$('#penilaian-indikator-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Export Tabel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printTabel(\'EXCEL\')')) . "&nbsp&nbsp"
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak Grafik', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'printSemua()')); ?>
    </div>
</div>