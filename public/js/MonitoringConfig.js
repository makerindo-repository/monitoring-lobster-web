class Config {

    constructor() {
        // Leaflet Map
        this.map = {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors. Tiles layer by <a href="https://www.google.com/maps">Google</a>',
            tile: 'http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',
            subdomains: ['mt0','mt1','mt2','mt3'],
        };
    }

}