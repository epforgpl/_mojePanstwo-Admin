/**
 * Created by tomekdrazewski on 02/06/15.
 */
$(document).ready(function () {

    var url = window.location.href;
    url = url + '.json';


    function pageReload() {
        $.getJSON(url, function (data) {
            obj = data.analyzer.AnalyzerExecution['data'];

            obj = JSON.parse(obj);

            var nazwy = {};
            var wartosci = {};
            $.each(obj.nazwy, function (key, value) {
                var id = value.api_datasets.id;
                var name = value.api_datasets.name;
                var base_alias = value.api_datasets.base_alias;
                nazwy[base_alias] = {"name": name, "id": id};
            });
            $.each(obj.wartosci, function (key, value) {
                var id = value.objects.dataset;
                var a = value.objects.a;
                var count = value[0].count;




                //if(id='kody_pocztowe') {
                    if (!wartosci[id]) {
                        wartosci[id] = {};
                    }
                    wartosci[id][a] = count;
               // }
            });
            $.each(wartosci, function (key, value){
                    var serie = '{"series":[';
                    $.each(value, function (key1, val1) {

                        name = dict[key1];
                        count = val1;
                        if (name.indexOf('OK') != -1) {
                            serie += '{ "name" : "' + name + '", "data" : [' + parseInt(count) + '], "color" : "#90ed7d" },';

                        } else if (name.indexOf('Nieprzetwarzane') != -1 || name.indexOf('Nieprzetwarzany') !== -1) {
                            serie += '';
                        }
                        else {
                            serie += '{ "name" : "' + name + '", "data" : [' + parseInt(count) + ']},';
                        }
                    });

                    serie = serie.substring(0, serie.length - 1);
                    serie += ']}';
                    var dane = JSON.parse(serie);

                    console.log(key);
                    console.log(nazwy[key]);
                    var options = {
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
                        series: [{}]
                    };
                    if(key in nazwy){
                        options.title.text = nazwy[key]['name'];
                    }else{
                        options.title.text = key;
                    }
                    options.series = dane.series;
                    options.chart.renderTo = "" + key + "";
                    var chart = new Highcharts.Chart(options);

            });
        });
    }

    pageReload();
    setTimeout(function () {
            pageReload();
        }
        , 60 * 1000);
});