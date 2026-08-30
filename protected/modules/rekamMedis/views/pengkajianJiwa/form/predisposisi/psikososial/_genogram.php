<label>c. Genogram</label>


<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-options">
            <a href="javascript:void(0);"><label>Tools : </label></a>
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk membuat garis pada bidang gambar" href="javascript:void(0);" id="tool-pencil"><i class="glyphicon glyphicon-pencil"></i></a>
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menghapus pada bidang gambar" href="javascript:void(0);" id="tool-eraser"><i class="glyphicon glyphicon-trash"></i></a>
            <a class="nohref">||</a>
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 1" href="javascript:void(0);" class='tool' id="sizeTool-1" style="border: 1px solid;">
                <svg width="10" height="10" version="1.1" data-reactid=".1.$1.0.0">
                <circle cx="5" cy="5" r="0.5" data-reactid=".1.$1.0.0.0"></circle>
                </svg>
            </a>
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 5" href="javascript:void(0);" class='tool' id="sizeTool-2" style="border: 1px solid;">
                <svg width="10" height="10" version="1.1" data-reactid=".1.$5.0.0">
                <circle cx="5" cy="5" r="2.5" data-reactid=".1.$5.0.0.0"></circle>
                </svg>
            </a>
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 10" href="javascript:void(0);" class='tool' id="sizeTool-3" style="border: 1px solid;">
                <svg width="10" height="10" version="1.1" data-reactid=".1.$10.0.0">
                <circle cx="5" cy="5" r="3.5" data-reactid=".1.$10.0.0.0"></circle>
                </svg>
            </a>
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 15" href="javascript:void(0);" class='tool' id="sizeTool-4" style="border: 1px solid;">
                <svg width="10" height="10" version="1.1" data-reactid=".1.$15.0.0">
                <circle cx="5" cy="5" r="4.5" data-reactid=".1.$15.0.0.0"></circle>
                </svg>
            </a>
            <a class="nohover"><label>||</label></a>
            <!--<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>-->
            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengembalikan perubahan bidang gambar ke awal" href="javascript:void(0);" id="clear-lc" data-rel="reload"><i class="glyphicon glyphicon-refresh"></i></a>

        </div>
    </div>
    <div class="panel-body">
        <div class="literally core" style="width: 500px; height: 400px"></div>
        <div class="controls">

        </div>
    </div>
</div>
<?php echo $form->hiddenField($model, 'genogram_gambar', array('id'=>'genogram_gambar')); ?>



<div class="control-group">
    <?php echo $form->labelEx($model, 'genogram_penjelasan', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'genogram_penjelasan', 'toolbar' => 'mini', 'height' => '100px')) ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <div id="panel_diagnosa_genogram">
            <?php
            echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][genogram]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                        'isaktif' => true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'genogram',
                        ), array('order' => 'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null));
            ?>
        </div>
        <?php
        echo CHtml::htmlButton('+ Tambah Diagnosa', array(
            'class' => 'btn btn-success', 'onclick' => "dialogTambahDiagnosa('panel_diagnosa_genogram', 'diagnosa_gangguan', 'genogram');"
        ));
        ?>
    </div>
</div>

<script>

    var lc;
    function ini_lc() {
        //lc = LC.init(

        //  document.getElementsByClassName('literally')[0],
        //{
        //  imageURLPrefix: 'js/literallycanvas/img',
        // tools: [
        //   LC.tools.Pencil, 
        // LC.tools.Eraser
        // ],     
        // defaultStrokeWidth: 1
        // }
        //);


        lc = LC.init(document.getElementsByClassName('literally core')[0],
                {
                    imageSize: {
                        width: 500, height: 400
                    },
                    defaultStrokeWidth: 1,
                    imageURLPrefix: 'js/literallycanvas/img'
                            /*backgroundShapes: [        
                             LC.createShape(
                             'Text', {
                             x: 10, y: 30, text: "R1",
                             font: "12px Helvetica"
                             })
                             ]*/

                }
        );

        lc.backgroundCanvas.width = lc.canvas.width = 500;
        lc.backgroundCanvas.height = lc.canvas.height = 400;
        lc.backgroundCanvas.style.width = lc.canvas.style.width = "500px";
        lc.backgroundCanvas.style.height = lc.canvas.style.height = "400px";

        

        $("#clear-lc").click(function () {
            lc.clear();
        });

        $("#open-image").click(function () {
            window.open(lc.getImage({
                scale: 1, margin: {top: 10, right: 10, bottom: 10, left: 10}
            }).toDataURL());
        });

        var tools = [
            {
                name: 'pencil',
                el: document.getElementById('tool-pencil'),
                tool: new LC.tools.Pencil(lc)
            },
            {
                name: 'eraser',
                el: document.getElementById('tool-eraser'),
                tool: new LC.tools.Eraser(lc)
            },
        ];

        var strokeWidths = [
            {
                name: 1,
                el: document.getElementById('sizeTool-1'),
                size: 1
            }, {
                name: 5,
                el: document.getElementById('sizeTool-2'),
                size: 5
            }, {
                name: 10,
                el: document.getElementById('sizeTool-3'),
                size: 10
            }, {
                name: 15,
                el: document.getElementById('sizeTool-4'),
                size: 15
            }
        ];

        setCurrentByName = function (ary, val) {
            ary.forEach(function (i) {
                $(i.el).toggleClass('current', (i.name == val));
            });
        };

        findByName = function (ary, val) {
            var vals;
            vals = ary.filter(function (v) {
                return v.name == val;
            });
            if (vals.length == 0)
                return null;
            else
                return vals[0];
        };

        // Wire tools
        tools.forEach(function (t) {
            $(t.el).click(function () {
                var sw;

                lc.setTool(t.tool);
                setCurrentByName(tools, t.name);
                setCurrentByName(strokeWidths, t.tool.strokeWidth);
                $('#tools-sizes').toggleClass('disabled', (t.name == 'text'));
            });
        });
        setCurrentByName(tools, tools[0].name);

        // Wire Stroke Widths
        // NOTE: This will not work until the stroke width PR is merged...
        strokeWidths.forEach(function (sw) {
            $(sw.el).click(function () {
                lc.trigger('setStrokeWidth', sw.size);
                setCurrentByName(strokeWidths, sw.name);
            })
        })
        setCurrentByName(strokeWidths, strokeWidths[0].name);
    }
    
    

    $(document).ready(function () {


        setTimeout(function () {
            ini_lc();
            lc.loadSnapshot(JSON.parse($("#genogram_gambar").val()));
        }, 1000);





    });
    
    function beforeSubmitGenogram() {
    
        // convert gambar ke SVG
        var svgString = lc.getSVGString();
        var snapshot = lc.getSnapshot();
        
        snapshot.svgout = svgString;
        
        

        $("#genogram_gambar").val(JSON.stringify(snapshot));

    }

</script>