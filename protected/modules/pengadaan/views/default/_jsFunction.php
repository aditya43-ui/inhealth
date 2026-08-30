<script type="text/javascript">
    function generateGrafik(id, tipe, getdata, jenis, legend) {

        var dtset = getdata;
        var display_tick_xaxes = true;
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        var var_tooltip = {
//            mode: 'index',
            intersect: false,
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataLabel = data.datasets[tooltipItem.datasetIndex].label;
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString();
                    var out = ' : ' + toCurrency(value, 2); // ditambahkan total data 
                    if (Chart.helpers.isArray(dataLabel)) {
                        dataLabel = dataLabel.slice();
                        dataLabel[0] += out;
                    } else {
                        dataLabel += out;
                    }
                    return dataLabel;
                }
            }
        };

        if (tipe == 'pie') {
            display_tick_xaxes = false;
            display_tick_yaxes = false;
            var_tooltip = {

            }
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
                                    var vr = toCurrency(args.value, 2);
                                    return vr;
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
                                    beginAtZero: true,
                                    callback: function (value, index, values) {
                                        if (parseInt(value) >= 1000) {
                                            return '' + toCurrency(value, 2);
                                        } else {
                                            return '' + value;
                                        }
                                    }
                                }
                            }]
                    },
                    tooltips: var_tooltip,
                }
            });
        }, 300);
    }
    
    function generateGrafikPengadaan(id, tipe, getdata, jenis, legend) {

        var dtset = getdata;
        var display_tick_xaxes = true;
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        var var_tooltip = {
//            mode: 'index',
            intersect: false,
            callbacks: {
                label: function (tooltipItem, data) {
                    var dataLabel = data.datasets[tooltipItem.datasetIndex].label;
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString(); // value dari variabel data 
                    var total = data.datasets[tooltipItem.datasetIndex].total[tooltipItem.index].toLocaleString(); // total data dari variabel total 
                    var out = ' : ' + toCurrency(value, 2) + ' (' + total+')'; // ditambahkan total data 
                    if (Chart.helpers.isArray(dataLabel)) {
                        dataLabel = dataLabel.slice();
                        dataLabel[0] += out;
                    } else {
                        dataLabel += out;
                    }
                    return dataLabel;
                }
            }
        };

        if (tipe == 'pie') {
            display_tick_xaxes = false;
            display_tick_yaxes = false;
            var_tooltip = {

            }
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
                                    var vr = toCurrency(args.value, 2);
                                    return vr;
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
                                    beginAtZero: true,
                                    callback: function (value, index, values) {
                                        if (parseInt(value) >= 1000) {
                                            return '' + toCurrency(value, 2);
                                        } else {
                                            return '' + value;
                                        }
                                    }
                                }
                            }]
                    },
                    tooltips: var_tooltip,
                }
            });
        }, 300);
    }

    function reset() {
        $("#tigagrafik-batang").parents('.up').html("<canvas id='tigagrafik-batang'></canvas>");
        $("#tigagrafik-garis").parents('.up').html("<canvas id='tigagrafik-garis'></canvas>");
        $("#grafikpengadaan-batang").parents('.up').html("<canvas id='grafikpengadaan-batang'></canvas>");
        $("#duagrafik-pie").parents('.up').html("<canvas id='duagrafik-pie'></canvas>");
        $("#duagrafik-pie-2").parents('.up').html("<canvas id='duagrafik-pie-2'></canvas>");
    }

    function setIndikator() {

        reset();
        var periode = $('#ADBeranda_periodeanggaran_id').val();
        var pejabat = $('#ADBeranda_pejabatpengadaan_id').val();
        var sumberbiaya = $('#ADBeranda_sumberbiaya').val();
        var pegawaikpa_id = $('#ADBeranda_pegawaikpa_id').val();
        var pptk_id = $('#ADBeranda_pptk_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cariData'); ?>',
            data: {
                'periode': periode,
                'pejabat': pejabat,
                pptk_id, pegawaikpa_id, sumberbiaya
            },
            dataType: "json",
            success: function (data) {
                $("#tile1").html(data.count.rup_penyedia);
                $("#tile2").html(data.count.spk_penyedia);
                $("#tile3").html(data.count.nota_pptk);
                $("#tile4").html(data.count.rup_swakelola);
                $("#tile5").html(data.count.nota_swakelola);

                generateGrafik($("#tigagrafik-batang"), 'bar', data.load.grafik.tiga_grafik.bar, 'line');
                generateGrafik($("#duagrafik-pie"), 'pie', data.load.grafik.pie);
                generateGrafik($("#duagrafik-pie-2"), 'pie', data.load.grafik.pie2);
                generateGrafikPengadaan($("#grafikpengadaan-batang"), 'bar', data.load.grafik.grafik_pengadaan.bar, 'line'); // generate-nya dibeadakan karena ada total setelah value
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    $(document).ready(function () {
        setIndikator();
    });

    /* format curentcy*/
    function formatMoney(number, places, symbol, thousand, decimal) {
        number = number || 0;
        places = !isNaN(places = Math.abs(places)) ? places : 0;
        symbol = symbol !== undefined ? symbol : "";
        thousand = thousand || ".";
        decimal = decimal || ",";
        var negative = number < 0 ? "-" : "",
                i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
                j = (j = i.length) > 3 ? j % 3 : 0;
        return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
    }

    function toCurrency(number, decimal) {
        money = formatMoney(number, decimal);
        return money;
    }
</script>