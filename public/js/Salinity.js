class SalinitySensor{
    constructor(data, treshold){
        this.elem = '#Salinity';
        this.elData = data.map(d => d[0]);
        this.treshold = treshold;
        this.categories = data.map(d => {
            let dt = new Date(d[1]);
            return `${dt.getHours()}:${((dt.getMinutes() < 10 ? '0' : '') + dt.getMinutes())}`;
        })

        if (this.elData.length < 1)
            this.elData = [0, 0, 0, 0, 0];
        if (this.categories.length < 1)
            this.categories = ['-', '-', '-', '-', '-'];
        this.options = {
            chart: {
            id: 'area-datetime',
            type: 'area',
            height: 200,
            toolbar: {
                show: false
            },
            zoom: {
              autoScaleYaxis: true
            }
          },
          annotations: {
            yaxis: [{
                y: parseFloat(this.treshold.value_max),
                opacity: 0.8,
                borderColor: '#FF4560',
                label: {
                    borderColor: '#00E396',
                    style: {
                        color: '#fff',
                        background: '#FF4560',
                    },
                    text: `Threshold : ${this.treshold.value_max} PSU`,
                }
            }],
            xaxis: [{
              x: this.categories,
              borderColor: '#999',
              yAxisIndex: 0,
              label: {
                show: true,
                text: 'Rally',
                style: {
                  color: "#fff",
                  background: '#775DD0'
                }
              }
            }]
          },
          dataLabels: {
            enabled: false
          },
          series: [
            {
                name: 'Salinity',
                data: this.elData
            }
        ],
          markers: {
            size: 0,
            style: 'hollow',
          },
          xaxis: {
            categories: this.categories
        },
        yaxis: {
            min: this.treshold.value_min,
            max: Math.max(...this.elData),
            tickAmount: 4,
            decimalsInFloat: 1,
            labels: {
                formatter: (text) => `${parseFloat(text).toFixed(2)} PSU`
            },
        },
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.7,
              opacityTo: 0.9,
              stops: [0, 100]
            }
          },
        };
        this.chart = '';
        this.init();
    }

    init() {
        if (!this.chart) {
            this.chart = new ApexCharts(document.querySelector(this.elem), this.options);
            this.chart.render();
        }
    }
    update(value, created_at) {
        this.elData.push(value);
        if (this.elData.length === 6) this.elData.shift();

        const date = new Date(created_at);
        const time = `${date.getHours()}:${((date.getMinutes() < 10 ? '0' : '') + date.getMinutes())}`;

        this.categories.push(time);
        if (this.categories.length === 6) this.categories.shift();

        this.chart.updateOptions({
            xaxis: {
                categories: this.categories
            },
            series: [
                {
                    data: this.elData
                }
            ],
            yaxis: {
                min: 0,
                max: Math.max(...this.elData),
                tickAmount: 4,
                decimalsInFloat: 1,
                labels: {
                    formatter: (text) => `${parseFloat(text).toFixed(2)} mg/L`
                },
            },
        });
    }
}


