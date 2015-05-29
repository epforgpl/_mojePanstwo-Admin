<?php
echo $this->Html->script('Analyzers.highcharts');
echo $this->Html->script('Analyzers.highcharts-more');
echo $this->Html->script('Analyzers.refresher');
echo $this->Html->css('Analyzers./Analyzer/view');


$data = json_decode($analyzer['AnalyzerExecution']['data'], true);


$dict = array(
    'org_status' => array(
        'title' => 'Status Organizacji',
        '0' => 'W kolejce do pobrania',
        '1' => 'Aktualnie pobierane',
        '2' => 'Pobrane - OK',

    ),
    'org_status_anl' => array(
        'title' => 'Status Organizacji - Analiza',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '3' => 'Przetworzone - OK',
    ),
    'org_status_anl_intro' => array(
        'title' => 'Status Organizacji - Analiza Intro',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzane',
        '3' => 'OK',
        '4' => 'Brak danych',
        '5' => 'Błąd numeru KRS',
        '6' => 'Błąd danych z działu 0',
        '7' => 'Błąd danych z działu 1',
    ),
    'org_status_anl_addr' => array(
        'title' => 'Status Organizacji - Analiza Adres',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzane',
        '3' => 'OK',
        '5' => 'Błąd',
    ),
    'org_status_xml' => array(
        'title' => 'Status Organizacji - XML',
        '0' => 'Nieprzetwarzane',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzane',
        '3' => 'OK',
        '4' => 'Brak PDF\\\'a',
        '5' => 'Błąd konwersji do XML',
        '6' => 'Brak daty lub działów',
    ),

    'msig_wydania' => array(
        'title' => 'MSIG - Data ostatniego wydania'
    ),

    'msig_con' => array(
        'title' => 'MSIG - Konwersja do tekstu',
        '0' => 'W kolejce do konwertowania',
        '1' => 'Aktualnie konwertowany',
        '2' => 'OK',
        '3' => 'Problem z typem dokumentu',
        '4' => 'Problem z treścią dokumentu',
    ),
    'msig_con_last_err' => array(
        'title' => 'MSIG - Konwersja do tekstu - Ostatni Błąd',
        '3' => 'Problem z typem dokumentu',
        '4' => 'Problem z treścią dokumentu',
    ),
    'msig_con_last_corr' => array(
        'title' => 'MSIG - Konwersja do tekstu - Ostatni Poprawny',
        '2' => 'OK',
    ),

    'msig_proc' => array(
        'title' => 'MSIG - Przetwarzanie spisu treści',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd',
    ),
    'msig_proc_last_err' => array(
        'title' => 'MSIG - Przetwarzanie spisu treści - Ostatni Błąd',
        '4' => 'Błąd',
    ),
    'msig_proc_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie spisu treści - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'msig_proc_d' => array(
        'title' => 'MSIG - Przetwarzanie działów',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd numeracji stron',
        '5' => 'Błąd nazwy działu',
        '6' => 'Brak pliku wejściowego',
        '7' => 'Błąd konwersji pliku wyjściowego',
        '8' => 'Błąd przesyłu na chmurę',
    ),
    'msig_proc_d_last_err' => array(
        'title' => 'MSIG - Przetwarzanie działów - Ostatni Błąd',
        '4' => 'Błąd numeracji stron',
        '5' => 'Błąd nazwy działu',
        '6' => 'Brak pliku wejściowego',
        '7' => 'Błąd konwersji pliku wyjściowego',
        '8' => 'Błąd przesyłu na chmurę',
    ),
    'msig_proc_d_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie działów - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'msig_proc_d_krs' => array(
        'title' => 'MSIG - Przetwarzanie działów KRS',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd nieobsługiwany typ',
        '5' => 'Błąd brak danych',
    ),
    'msig_proc_d_krs_last_err' => array(
        'title' => 'MSIG - Przetwarzanie działów KRS - Ostatni Błąd',
        '4' => 'Błąd nieobsługiwany typ',
        '5' => 'Błąd brak danych',
    ),
    'msig_proc_d_krs_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie działów KRS - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'msig_next_proc_d_krs' => array(
        'title' => 'MSIG - Przetwarzanie wpisów kolejnych',
        '0' => 'Nieprzetwarzany',
        '1' => 'W kolejce do przetwarzania',
        '2' => 'Aktualnie przetwarzany',
        '3' => 'OK',
        '4' => 'Błąd brak pliku',
        '5' => 'Błąd niepoprawny format treści',
        '6' => 'Błąd brak treści',
    ),
    'msig_next_proc_d_krs_last_err' => array(
        'title' => 'MSIG - Przetwarzanie wpisów kolejnych - Ostatni Błąd',
        '4' => 'Błąd brak pliku',
        '5' => 'Błąd niepoprawny format treści',
        '6' => 'Błąd brak treści',
    ),
    'msig_next_proc_d_krs_last_corr' => array(
        'title' => 'MSIG - Przetwarzanie wpisów kolejnych - Ostatni Poprawny',
        '3' => 'OK'
    ),

    'krs_pos_chg' => array(
        'title' => 'KRS - Przetwarzanie zmian',
        '3' => 'OK',
        '4' => 'Błąd',
    ),
    'krs_pos_chg_last_err' => array(
        'title' => 'KRS - Przetwarzanie zmian - Ostatni Błąd',
        '4' => 'Błąd',
    ),
    'krs_pos_chg_last_corr' => array(
        'title' => 'KRS - Przetwarzanie zmian - Ostatni Poprawny',
        '3' => 'OK',
    ),

    'krs_new' => array(
        'title' => 'KRS - Pobieranie nowych wpisów',
        '-1' => 'Nieprzetwarzane',
        '0' => 'W kolejce do przetwarzania',
        '1' => 'Aktualnie przetwarzane',
        '2' => 'OK',
        '3' => 'OK, brak wyników',
        '4' => 'Błąd nieznany',
        '5' => 'Błąd inny',
        '6' => 'Błąd przesyłu na chmurę',

    ),
    'krs_new_last_err' => array(
        'title' => 'KRS - Pobieranie nowych wpisów - Ostatni Błąd',
        '4' => 'Błąd nieznany',
        '5' => 'Błąd inny',
        '6' => 'Błąd przesyłu na chmurę',
    ),
    'krs_new_last_corr' => array(
        'title' => 'KRS - Pobieranie nowych wpisów - Ostatni Poprawny',
        '2' => 'OK',
        '3' => 'OK, brak wyników',
    ),

    'krs_downloads' => array(
        'title' => 'KRS - Pobrania ze strony'
    ),
);

$jsdict=json_encode($dict);
?>
<script>
    var dict=<?php echo $jsdict; ?>;
</script>
<?php

foreach ($data as $key => $val) {

    if (strpos($key, 'err') !== false ){

        $keys = array_keys($data[$key][0]);
        $keys2 = array_keys($data[$key][0][$keys[0]]);

        echo "<div id='$key' class='col-sm-3 label-danger text-white'>" . $dict[$key][$data[$key][0][$keys[0]][$keys2[0]]] . ': ' . $this->Time->timeAgoInWords($data[$key][0][$keys[0]][$keys2[1]]) . '</div><BR>';

    }elseif (strpos($key, 'corr') !== false) {

        $keys = array_keys($data[$key][0]);
        $keys2 = array_keys($data[$key][0][$keys[0]]);

        echo "<div id='$key' class='col-sm-3 label-success text-white'>" . $dict[$key][$data[$key][0][$keys[0]][$keys2[0]]] . ': ' . $this->Time->timeAgoInWords($data[$key][0][$keys[0]][$keys2[1]]) . '</div><BR>';

    } elseif (strpos($key, 'wydania') !== false) {

        echo "<div id='$key' class='col-sm-3 label-info text-white'>Najnowsze pobrane: " . $this->Time->timeAgoInWords($data[$key][0][$key]['data']) . '</div>';

    } elseif (strpos($key, 'downloads') !== false) {
        echo "
                <div>
                    <div class='col-sm-4' id='krs_downloads_day'></div>
                    <div class='col-sm-4' id='krs_downloads_hour'></div>
                    <div class='col-sm-4' id='krs_downloads_minute'></div>
                </div>";
        ?>
        <script>
            $(document).ready(function () {
                $('#krs_downloads_day').highcharts({

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },

                    credits: {
                        enabled: false
                    },

                    title: {
                        text: 'KRS Pobrania Dzień'
                    },

                    pane: {
                        startAngle: -150,
                        endAngle: 150,
                        background: [{
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#FFF'],
                                    [1, '#333']
                                ]
                            },
                            borderWidth: 0,
                            outerRadius: '109%'
                        }, {
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#333'],
                                    [1, '#FFF']
                                ]
                            },
                            borderWidth: 1,
                            outerRadius: '107%'
                        }, {
                            // default background
                        }, {
                            backgroundColor: '#DDD',
                            borderWidth: 0,
                            outerRadius: '105%',
                            innerRadius: '103%'
                        }]
                    },

                    // the value axis
                    yAxis: {
                        min: 0,
                        max: 250,

                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',

                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },
                        title: {
                            text: 'pobrań/dzień'
                        },
                        plotBands: [{
                            from: 0,
                            to: 150,
                            color: '#55BF3B' // green
                        }, {
                            from: 150,
                            to: 200,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 200,
                            to: 250,
                            color: '#DF5353' // red
                        }]
                    },

                    series: [{
                        name: 'Dzień',
                        data: [<?php echo $data['krs_downloads']['downloadD']; ?>],
                        tooltip: {
                            valueSuffix: ' pobrań'
                        }
                    }]

                });
                $('#krs_downloads_hour').highcharts({

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },

                    credits: {
                        enabled: false
                    },

                    title: {
                        text: 'KRS Pobrania Godzina'
                    },

                    pane: {
                        startAngle: -150,
                        endAngle: 150,
                        background: [{
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#FFF'],
                                    [1, '#333']
                                ]
                            },
                            borderWidth: 0,
                            outerRadius: '109%'
                        }, {
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#333'],
                                    [1, '#FFF']
                                ]
                            },
                            borderWidth: 1,
                            outerRadius: '107%'
                        }, {
                            // default background
                        }, {
                            backgroundColor: '#DDD',
                            borderWidth: 0,
                            outerRadius: '105%',
                            innerRadius: '103%'
                        }]
                    },

                    // the value axis
                    yAxis: {
                        min: 0,
                        max: 100,

                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',

                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },
                        title: {
                            text: 'pobrań/godzinę'
                        },
                        plotBands: [{
                            from: 0,
                            to: 60,
                            color: '#55BF3B' // green
                        }, {
                            from: 60,
                            to: 80,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 80,
                            to: 100,
                            color: '#DF5353' // red
                        }]
                    },

                    series: [{
                        name: 'Godzina',
                        data: [<?php echo $data['krs_downloads']['downloadH']; ?>],
                        tooltip: {
                            valueSuffix: ' pobrań'
                        }
                    }]

                });
                $('#krs_downloads_minute').highcharts({

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },

                    credits: {
                        enabled: false,
                    },

                    title: {
                        text: 'KRS Pobrania Minuta'
                    },

                    pane: {
                        startAngle: -150,
                        endAngle: 150,
                        background: [{
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#FFF'],
                                    [1, '#333']
                                ]
                            },
                            borderWidth: 0,
                            outerRadius: '109%'
                        }, {
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#333'],
                                    [1, '#FFF']
                                ]
                            },
                            borderWidth: 1,
                            outerRadius: '107%'
                        }, {
                            // default background
                        }, {
                            backgroundColor: '#DDD',
                            borderWidth: 0,
                            outerRadius: '105%',
                            innerRadius: '103%'
                        }]
                    },

                    // the value axis
                    yAxis: {
                        min: 0,
                        max: 15,

                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',

                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },
                        title: {
                            text: 'pobrań/minutę'
                        },
                        plotBands: [{
                            from: 0,
                            to: 8,
                            color: '#55BF3B' // green
                        }, {
                            from: 8,
                            to: 12,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 12,
                            to: 15,
                            color: '#DF5353' // red
                        }]
                    },

                    series: [{
                        name: 'Minuta',
                        data: [<?php echo $data['krs_downloads']['downloadM']; ?>],
                        tooltip: {
                            valueSuffix: ' pobrań'
                        }
                    }]

                });
            });
        </script>
    <?php
    } else {
        echo "<div class='col-sm-12'><hr></div><div class='col-sm-9'><div id='$key'></div></div>";
        ?>

        <script>
            $(document).ready(function () {
                $(function () {
                    $('#<?php echo $key;?>').highcharts({
                        chart: {
                            type: 'bar',
                            height: 250,
                        },
                        colors: ['#7cb5ec', '#434348', '#f7a35c', '#8085e9',
                            '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: '<?php echo $dict[$key]['title']; ?>'
                        },
                        xAxis: {
                            categories: [' ']

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Liczba rejestrów'
                            }
                        },
                        legend: {
                            reversed: true
                        },
                        plotOptions: {
                            series: {
                                stacking: 'normal'
                            }
                        },
                        tooltip: {
                            headerFormat: '',
                            pointFormat: '{series.name}: {point.y}'
                        },
                        series: [
                        <?php
                        foreach ($val as $key1 => $val1) {
                            foreach ($val1 as $key2 => $val2) {
                                if (isset($val2['count'])) {
                                    $count = $val2['count'];
                                } else {
                                    $status = $val2['status'];
                                    if (isset($dict[$key][$status])){
                                    $name = $dict[$key][$status];
                                    }else{
                                    $name = 'Nieznany Błąd';
                                    }
                                }
                            }
                                $name.= " ($status)";
                            if(strpos($name,'OK')!==false){
                                echo "{
                                        name: '$name',
                                        data: [$count],
                                        color: '#90ed7d'
                                    },";
                                    }elseif(strpos($name, 'Nieprzetwarzane')!==false || strpos($name, 'Nieprzetwarzany')!==false){
                                    echo "";
                            }else{
                                echo "{
                                    name: '$name',
                                    data: [$count]
                                    },";
                            }
                        }
                        ?>
                    ]
                });
            });
            })
            ;
        </script>
    <?php
    }
}
?>