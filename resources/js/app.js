window.axios = require('axios')
import anychart from 'anychart';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const fixedEncodeURIComponent = str => encodeURIComponent(str).replace(/[!'()*]/g, c => `%${c.charCodeAt(0).toString(16)}`);

const buildQuery = (params, parent = null) => {
    let query = Object.keys(params).map((key) => {
        const paramValue = params[key];
        if (paramValue !== undefined && paramValue !== null) {
            if (typeof paramValue === 'object') {
                const parentValue = parent ? `${parent}[${key}]` : key;
                return buildQuery(paramValue, parentValue);
            }
            if (parent) {
                return `${parent}[${Number.isInteger(+key) ? '' : key}]=${fixedEncodeURIComponent(paramValue)}`;
            }
            return `${key}=${fixedEncodeURIComponent(paramValue)}`;
        }
    })
        .filter(p => !!p)
        .join('&');

    if (query && !parent) {
        query = `?${query}`;
    }

    return query;
};

document.getElementById('companySymbol')
    .addEventListener('click', () => {
        const input = {
            symbol: document.getElementsByName('symbol')[0].value,
            email: document.getElementsByName('email')[0].value,
            start_date: document.getElementsByName('start_date')[0].value,
            end_date: document.getElementsByName('end_date')[0].value,
        }

        const result = document.getElementById('result')

        axios.get(`/show${buildQuery(input)}`)
            .then(function (response) {
                result.textContent = `${ input.symbol }`
                result.classList.remove('hidden')

                var table = document.createElement('table');
                table.setAttribute('id','datatable')
                var tr = document.createElement('tr');
                var array = ['Date', 'Open', 'High', 'Low', 'Close', 'Volume'];

                for (var j = 0; j < array.length; j++) {
                    var th = document.createElement('th');
                    var text = document.createTextNode(array[j]);
                    th.appendChild(text);
                    tr.appendChild(th);
                }
                table.appendChild(tr);

                for (var i = 0; i < response.data.filtered_data.length; i++) {
                    var tr = document.createElement('tr');

                    var td1 = document.createElement('td');
                    var td2 = document.createElement('td');
                    var td3 = document.createElement('td');
                    var td4 = document.createElement('td');
                    var td5 = document.createElement('td');
                    var td6 = document.createElement('td');

                    var text1 = document.createTextNode(response.data.filtered_data[i].date);
                    var text2 = document.createTextNode(response.data.filtered_data[i].open.toFixed(2));
                    var text3 = document.createTextNode(response.data.filtered_data[i].high.toFixed(2));
                    var text4 = document.createTextNode(response.data.filtered_data[i].low.toFixed(2));
                    var text5 = document.createTextNode(response.data.filtered_data[i].close.toFixed(2));
                    var text6 = document.createTextNode(response.data.filtered_data[i].volume);

                    td1.appendChild(text1);
                    td2.appendChild(text2);
                    td3.appendChild(text3);
                    td4.appendChild(text4);
                    td5.appendChild(text5);
                    td6.appendChild(text6);

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    tr.appendChild(td5);
                    tr.appendChild(td6);

                    table.appendChild(tr);
                }
                document.body.appendChild(table);

                anychart.onDocumentReady(function () {
                        var table, mapping, chart;

                        table = anychart.data.table();

                        const filteredData = response.data.filtered_data;
                        const chartData = filteredData.map(function(item){
                            return Object.values(item);
                        });

                        table.addData(chartData);

                        // mapping the data
                        mapping = table.mapAs();
                        mapping.addField('x', 0, 'date');
                        mapping.addField('open', 1, 'first');
                        mapping.addField('high', 2, 'max');
                        mapping.addField('low', 3, 'min');
                        mapping.addField('close', 4, 'last');
                        mapping.addField('value', 4, 'last');

                        // defining the chart type
                        chart = anychart.stock();

                        // set the series type
                        chart.plot(0).ohlc(mapping).name(`${ input.symbol }`);

                        // setting the chart title
                        chart.title('Stocks Graphic');

                        // display the chart
                        chart.container('container');
                        chart.draw();
                        }
                    );
            })
            .catch(function (err) {
                result.textContent = 'Failed to show'

                result.classList.remove('hidden')

                console.warn(err)
            })
    })
