import axios from 'axios';
import { MapboxGeocoder } from '@mapbox/mapbox-gl-geocoder';
// Import Mapbox GL JS
import mapboxgl from 'mapbox-gl';



window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
