<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jsPDF/jspdf.min.js', CClientScript::POS_END);
?>
<script type="text/javascript">
    function generateGrafik(id, tipe, getdata, jenis, legend) {

        var dtset = getdata;
        var display_tick_xaxes = true;
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;

        if (tipe == 'pie') {
            display_tick_xaxes = false;
            display_tick_yaxes = false;
        }

        if (jenis == 'stacked') {
            stacked_yaxes = true;
        }

        if (legend == 'off') {
            legend_display = false;
        }

        setTimeout(function () {
            var grafikTiga = new Chart(id, {
                type: tipe,
                data: dtset,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: ''
                    },
                    legend: {
                        display: legend_display,
                        position: 'right'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        labels: {
                            render: function (args) {
                                if (tipe == 'pie') {
                                    return args.label + '\n' + args.percentage + '%';
                                } else {
                                    return args.value;
                                }
                            },
                            fontColor: '#333',
                            fontStyle: 'bold',
                        }
                    },
                    scales: {
                        xAxes: [{
                                ticks: {
                                    display: display_tick_xaxes
                                },
                                stacked: stacked_yaxes,
                            }],
                        yAxes: [{
                                display: display_tick_yaxes,
                                stacked: stacked_yaxes,
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    stepSize: 20,
                                    fontSize: 15,
                                }
                            }]
                    },
                }
            });
        }, 300);

    }

    function reset() {
        $("#grafik-pie-caramasuk").parents('.up').html("<canvas id='grafik-pie-caramasuk'></canvas>");
        $("#grafik-garis-caramasuk").parents('.up').html("<canvas id='grafik-garis-caramasuk'></canvas>");
    }

    function setIndikator() {
        reset();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cariData'); ?>',
            data: {
                tgl_awal: $("#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>").val(),
                tgl_akhir: $("#<?php echo CHtml::activeId($model, 'tgl_akhir'); ?>").val(),
                instalasi_id: $("#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>").val()
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#tile1").html(data.tile.rawat_inap);
                    $("#tile2").html(data.tile.rawat_jalan);
                    $("#tile3").html(data.tile.rawat_darurat);                    generateGrafik($("#grafik-pie-caramasuk"), 'pie', data.grafik.grafik_pie);
                    generateGrafik($("#grafik-garis-caramasuk"), 'line', data.grafik.grafik_garis.line);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function print(caraPrint) {
        var doc = new jsPDF('landscape');

        if (caraPrint == 'garis') {
            var canvas = document.querySelector('#grafik-garis-caramasuk');
            doc.text("Grafik Rawat Inap Berdasarkan Cara Masuk", 150, 10, {align: 'center'});
        } else {
            var canvas = document.querySelector('#grafik-pie-caramasuk');
            doc.text("Grafik Prosentase Rawat Inap Berdasarkan Cara Masuk", 150, 10, {align: 'center'});
        }
        //creates image
        var canvasImg = canvas.toDataURL("image/png", 1.0);
        doc.setFontSize(20);

        doc.addImage(canvasImg, 'PNG', 10, 10, 280, 150);
        doc.output("dataurlnewwindow");
        //doc.save('Grafik Laporan TAT.pdf');   
    }

    function printSemua() {
        var doc = new jsPDF('landscape');

        var canvas1 = document.querySelector('#grafik-garis-caramasuk');
        doc.text("Grafik Rawat Inap Berdasarkan Cara Masuk", 150, 10, {align: 'center'});
        var canvasImg1 = canvas1.toDataURL("image/png", 1.0);
        doc.addImage(canvasImg1, 'PNG', 10, 10, 280, 150);

        doc.addPage();

        var canvas2 = document.querySelector('#grafik-pie-caramasuk');
        doc.text("Grafik Prosentase Rawat Inap Berdasarkan Cara Masuk", 150, 10, {align: 'center'});
        var canvasImg2 = canvas2.toDataURL("image/png", 1.0);
        doc.addImage(canvasImg2, 'PNG', 10, 10, 280, 150);
        //creates image

        doc.setFontSize(20);
//        doc.output("dataurlnewwindow");
        doc.save('Grafik Rawat Inap Berdasarkan Cara Masuk.pdf');
    }


    $(document).ready(function () {
        setTimeout(function () {
            setIndikator();
        }, 500);
    });
</script>