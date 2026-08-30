<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Water Treatment Plant Quality Control</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
            <a data-rel="reload" href="#"  onclick="refreshTable();"><i class="entypo-arrows-ccw"></i></a>
        </div>
    </div>
    <div class="panel-body with-table table-responsive form-horizontal">
        <br/>
        <div class="control-group">
            <label class="control-label" style="padding:5px;width:50px;">Tanggal</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $dataTable,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class' => 'span3 tgl_awal',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?> 
            </div>
            <div class="controls">
                <?= CHtml::button("Cari", ['class' => 'btn btn-info', 'onclick' => 'refreshTable();']) ?>
            </div>
        </div>
        <div class="clear"></div>
        <?= $this->renderPartial('grid/_water_treatment', ['dataTable' => $dataTable]) ?>
    </div>
</div>

<script type="text/javascript">
    function refreshTable() {
        $.fn.yiiGridView.update('table-grid', {
            data: {
                'HDCustomModel[tgl_awal]': $(".tgl_awal").val()
            }
        });
    }
</script>