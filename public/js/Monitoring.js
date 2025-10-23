class Monitor {

    constructor(lat, lng) {
        // numeric state
        this.defaultZoom = 14;
        this.defaultMaxZoom = 20;

        // config
        this.config = new Config;

        // objects
        this.map = '';
        this.charts = [];
        this.data = [];
        this.treshold = [];
        this.dataTable = [];
        this.dataTableClass = null;

        this.lat = lat;
        this.lng = lng;

        this.initMap();
    }

    init(data, treshold, dataTable) {
        this.data = data;
        this.treshold = treshold;
        this.dataTable = dataTable;

        // this.initChart();
        this.initTemperatureHumidity();
        this.initDataTable();
    }

     initMap() {
        if (!this.map) {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let latlng = urlParams.get('latlng');

            if (latlng) {
                this.map = L.map('map', {
                    layers: [
                        L.tileLayer(this.config.map.tile, {
                            attribution: this.config.map.attribution,
                            subdomains: this.config.map.subdomains,
                            maxZoom: this.defaultMaxZoom,
                        })
                    ]
                }).setView(latlng.split(','), this.defaultZoom);

                let [lat, lng] = latlng.split(',');
                L.marker([lat, lng]).addTo(this.map);

            } else {
                console.error('Parameter "latlng" tidak ditemukan dalam URL.');
            }
        }
    }


    initChart() {
        this.data = this.data.reverse();

        const [phData, phTreshold]           = [this.data.map(d => [d.ph, d.created_at]), this.treshold.find(d => d.variable == 'ph')];
        const [codData, codTreshold]         = [this.data.map(d => [d.cod, d.created_at]), this.treshold.find(d => d.variable == 'cod')];
        const [nitratData, nitratTreshold] = [this.data.map(d => [d.nitrat, d.created_at]), this.treshold.find(d => d.variable == 'nitrat')];
        const [tssData, tssTreshold]         = [this.data.map(d => [d.tss, d.created_at]), this.treshold.find(d => d.variable == 'tss')];
        const [debitData, debitTreshold]     = [this.data.map(d => [d.debit_air, d.created_at]), this.treshold.find(d => d.variable == 'debit_air')];
        const [oxygenData, oxygenTreshold]     = [this.data.map(d => [d.dissolver_oxygen, d.created_at]), this.treshold.find(d => d.variable == 'disolver_oxygen')];
        const [turbidityData, turbidityTreshold]     = [this.data.map(d => [d.turbidity, d.created_at]), this.treshold.find(d => d.variable == 'turbidity')];
        const [salinityData, salinityTreshold]     = [this.data.map(d => [d.salinity, d.created_at]), this.treshold.find(d => d.variable == 'salinity')];
        const [tdsData, tdsTreshold]     = [this.data.map(d => [d.tds, d.created_at]), this.treshold.find(d => d.variable == 'tds')];
        const [orpData, orpTreshold]     = [this.data.map(d => [d.orp, d.created_at]), this.treshold.find(d => d.variable == 'orp')];

        this.charts = [
            new phAir(phData, phTreshold),
            new CodSensor(codData, codTreshold),
            new NitratSensor(nitratData, nitratTreshold),
            new TssSensor(tssData, tssTreshold),
            new ArusAir(debitData, debitTreshold),
            new DissolvedOxygen(oxygenData, oxygenTreshold),
            new TurbiditySensor(turbidityData, turbidityTreshold),
            new SalinitySensor(salinityData, salinityTreshold),
            new TdsSensor(tdsData, tdsTreshold),
            new OrpSensor(orpData, orpTreshold),
        ];
    }


    initTemperatureHumidity() {
        const latestData = this.data.sort((a,b) => b.id - a.id)[0];

        this.setValue("#iot-humidity", latestData.humidity_node ?? 0);
        this.setValue("#edge-humidity", latestData.humidity_edge || 0);
        this.setValue("#iot-temperature", latestData.temperature_node || 0);
        this.setValue("#edge-temperature", latestData.temperature_edge || 0);
    }

    update(dataset) {
        let {data, created_at} = dataset;
        data.created_at = created_at;

        this.charts[0].update(data.ph, created_at);
        this.charts[1].update(data.cod, created_at);
        this.charts[2].update(data.nitrat, created_at);
        this.charts[3].update(data.tss, created_at);
        this.charts[4].update(data.debit_air, created_at);
        this.charts[5].update(data.disolver_oxygen, created_at);
        this.charts[6].update(data.turbidity, created_at);
        this.charts[7].update(data.salinity, created_at);
        this.charts[8].update(data.tds, created_at);
        this.charts[9].update(data.orp, created_at);

        this.setValue('#iot-temperature', data.temperature_node);
        this.setValue('#edge-temperature', data.temperature_edge);

        this.dataTable.unshift(data);
        if (this.dataTable.length == 21) {
            this.dataTable.shift();
        }

        this.dataTableClass.destroy();
        this.generateDataTable(this.dataTable);
    }

    initDataTable() {
        this.generateDataTable(this.dataTable);
    }

    initDataTableClass() {
        this.dataTableClass = new simpleDatatables.DataTable("#raw", {
            searchable: false,
	        fixedHeight: true,
        });
    }

    setValue(el, value) {
        document.querySelector(el).innerHTML = value;
    }

    generateDataTable(data) {
        // console.log(data)
        let raw = '';
        data.forEach(v => {
            let bDate = new Date(v.created_at);
            let bTime = `${bDate.getHours()}:${((bDate.getMinutes() < 10 ? '0' : '') + bDate.getMinutes())}`;
            raw += `
            <tr>
            <td align="center">${bTime} WIB</td>
            <td align="center">${parseFloat(v.temperature_node).toFixed(0)} <small>°C</small></td>
            <td align="center">${parseFloat(v.humidity_node).toFixed(0)} <small>%</small></td>
            <td align="center">${parseFloat(v.dissolver_oxygen).toFixed(2)} <small>ppm</small></td>
            <td align="center">
                ${v.turbidity === 0 ? 'NaN' : `${v.turbidity} <small>NTU</small>`}
            </td>
            <td align="center">
                ${v.salinity === 0 ? 'NaN' : `${v.salinity} <small>PSU</small>`}
            </td>
            <td align="center">
                ${v.cod === 0 ? 'NaN' : `${v.cod} <small>mg/L</small>`}
            </td>
            <td align="center"><small>pH</small> ${parseFloat(v.ph).toFixed(2)}</td>
            <td align="center">${parseFloat(v.orp).toFixed(2)} <small>ppm</small></td>
            <td align="center">
                ${v.tds === 0 ? 'NaN' : `${v.tds} <small>ppm</small>`}
            </td>
            <td align="center">${parseFloat(v.nitrat).toFixed(2)} <small>ppm</small></td>
            <td align="center">${parseFloat(v.temperature_air).toFixed(0)} <small>°C</small></td>
            <td align="center">
                ${v.tss === 0 ? 'NaN' : `${v.tss} <small>mg/L</small>`}
            </td>
            <td align="center">
                ${v.debit_air === 0 ? 'NaN' : `${v.debit_air} <small>m³/s</small>`}
            </td>
            <td align="center">${parseFloat(v.water_level_cm).toFixed(0)} <small>cm</small></td>
            <td align="center">
            <span class="badge rounded-pill ${v.status_pompa == 1 ? 'bg-success' : 'bg-danger'}">
                ${v.status_pompa == 1 ? 'Hidup' : 'Mati'}
            </span>
        </td>
        </tr>
            `;
        });
        document.querySelector('#raw tbody').innerHTML = raw;
        // this.initDataTableClass();
    }

}
