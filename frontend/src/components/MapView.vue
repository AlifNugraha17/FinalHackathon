<template>
  <section class="py-14 bg-white border-t border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-100 text-sky-800 text-xs font-bold uppercase tracking-wider mb-2">
            <span>🗺️</span>
            <span>{{ t?.map_tag || 'Peta Spasial Lintas Batas' }}</span>
          </div>
          <h2 class="text-2xl font-extrabold text-teal-ink">{{ t?.map_title || 'Eksplorasi Jarak & Lokasi Terminal Feri Batam' }}</h2>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5">{{ t?.map_desc || 'Visualisasi interaktif posisi pelabuhan feri ke lokasi klinik medis, resort, dan pusat belanja.' }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-700 bg-slate-50 px-3.5 py-2 rounded-xl border border-slate-200">
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> <strong>{{ t?.map_terminal || 'Terminal Feri' }}</strong></span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> <strong>{{ t?.map_hospital || 'Medis & Dental' }}</strong></span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> <strong>{{ t?.map_tourism || 'Wisata' }}</strong></span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> <strong>{{ t?.map_resort || 'Resort & Spa' }}</strong></span>
          
          <button 
            @click="resetMapView"
            class="ml-2 px-2.5 py-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 text-[11px] font-bold transition-all cursor-pointer"
            title="Reset map view to Singapore & Batam centre"
          >
            {{ t?.map_reset || 'Reset Peta' }}
          </button>
        </div>
      </div>

      <!-- Map Container -->
      <div class="bg-white rounded-3xl p-3 border-2 border-sky-100 shadow-xl overflow-hidden relative">
        <div id="leaflet-map" class="w-full h-[500px] rounded-2xl bg-slate-100 z-10"></div>
        
        <!-- Loading State Indicator -->
        <div v-if="mapLoading" class="absolute inset-0 bg-white/80 backdrop-blur-xs flex flex-col items-center justify-center z-20">
          <div class="w-8 h-8 border-3 border-teal-600 border-t-transparent rounded-full animate-spin"></div>
          <span class="text-xs font-bold text-slate-700 mt-3">{{ t?.map_loading || 'Memuat Peta Spasial...' }}</span>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'

const props = defineProps({
  places: { type: Array, required: true },
  selectedPlace: { type: Object, default: null },
  t: { type: Object, default: () => ({}) }
})

const mapLoading = ref(true)
let map = null
let markers = []

const crossBorderCenter = [1.2200, 103.9500]

const getMarkerColor = (category) => {
  switch (category) {
    case 'medical':
    case 'dental':
      return '#10b981' // Emerald
    case 'tourism':
    case 'culinary':
      return '#f59e0b' // Amber
    case 'spa':
    case 'golf':
      return '#a855f7' // Purple
    case 'terminal':
      return '#0284c7' // Sky
    default:
      return '#06b6d4'
  }
}

const ensureLeafletLoaded = () => {
  return new Promise((resolve) => {
    if (typeof window.L !== 'undefined') {
      return resolve(window.L)
    }

    // Ensure Leaflet CSS
    if (!document.getElementById('leaflet-css')) {
      const link = document.createElement('link')
      link.id = 'leaflet-css'
      link.rel = 'stylesheet'
      link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'
      document.head.appendChild(link)
    }

    // Ensure Leaflet JS
    if (!document.getElementById('leaflet-js')) {
      const script = document.createElement('script')
      script.id = 'leaflet-js'
      script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'
      script.onload = () => resolve(window.L)
      document.body.appendChild(script)
    } else {
      const checkInterval = setInterval(() => {
        if (typeof window.L !== 'undefined') {
          clearInterval(checkInterval)
          resolve(window.L)
        }
      }, 50)
    }
  })
}

const initMap = async () => {
  try {
    const L = await ensureLeafletLoaded()
    const container = document.getElementById('leaflet-map')
    if (!container) return

    if (map) {
      map.remove()
      map = null
      markers = []
    }

    map = L.map('leaflet-map', {
      center: crossBorderCenter,
      zoom: 11,
      minZoom: 9,
      maxZoom: 18,
      zoomControl: true
    })

    // Reliable CartoDB Voyager tiles
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
      subdomains: 'abcd',
      maxZoom: 19
    }).addTo(map)

    // Plot Ferry Terminals
    const terminals = [
      { name: 'HarbourFront International Terminal (SG)', lat: 1.2644, lng: 103.8210, desc: 'Pintu Gerbang Utama Feri Singapura ke Batam' },
      { name: 'Tanah Merah Ferry Terminal (SG)', lat: 1.3142, lng: 103.9882, desc: 'Feri SG ke Nongsa Pura & Batam Centre' },
      { name: 'Harbour Bay Ferry Terminal (Batam)', lat: 1.1558, lng: 104.0041, desc: 'Terminal Feri Pusat Belanja Nagoya & Seafood Waterfront' },
      { name: 'Batam Centre Ferry Terminal', lat: 1.1311, lng: 104.0531, desc: 'Pusat Kota, RS Awal Bros & Megamall' },
      { name: 'Sekupang Ferry Terminal', lat: 1.1189, lng: 103.9238, desc: 'Kawasan Barat Batam & Golf Perbukitan' },
      { name: 'Nongsa Pura Ferry Terminal', lat: 1.1895, lng: 104.1012, desc: 'Kawasan Pantai Pasir Putih & Luxury Resort' }
    ]

    terminals.forEach(t => {
      const ferryMarker = L.circleMarker([t.lat, t.lng], {
        radius: 9,
        fillColor: '#0284c7',
        color: '#ffffff',
        weight: 2,
        opacity: 1,
        fillOpacity: 0.95
      }).addTo(map)
      
      ferryMarker.bindPopup(`
        <div style="font-family: sans-serif; padding: 4px; color: #0f172a; min-width: 190px;">
          <span style="font-size: 10px; font-weight: bold; color: #0284c7; text-transform: uppercase;">Pelabuhan Internasional</span>
          <strong style="display: block; font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px;">🚢 ${t.name}</strong>
          <p style="font-size: 11px; color: #475569; margin-top: 4px; line-height: 1.4;">${t.desc}</p>
        </div>
      `)
    })

    // Plot Destination Places
    props.places.forEach(place => {
      if (place.lat && place.lng && place.category !== 'terminal') {
        const color = getMarkerColor(place.category)
        const marker = L.circleMarker([place.lat, place.lng], {
          radius: 7.5,
          fillColor: color,
          color: '#ffffff',
          weight: 2,
          opacity: 1,
          fillOpacity: 0.9
        }).addTo(map)

        marker.bindPopup(`
          <div style="font-family: sans-serif; padding: 4px; color: #0f172a; min-width: 200px;">
            <span style="font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase;">${place.categoryLabel || place.category}</span>
            <strong style="display: block; font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px;">${place.name}</strong>
            <p style="font-size: 12px; font-weight: 700; color: #059669; margin-top: 4px;">S$ ${place.priceSgd} ${place.savingsPercent > 0 ? `• Hemat ~${place.savingsPercent}%` : ''}</p>
            <p style="font-size: 11px; color: #475569; margin-top: 2px;">📍 ${place.nearestTerminal}</p>
          </div>
        `)
        markers.push({ id: place.id, marker, lat: place.lat, lng: place.lng })
      }
    })

    setTimeout(() => {
      map.invalidateSize()
      mapLoading.value = false
    }, 200)

  } catch (err) {
    console.error('Map init error:', err)
    mapLoading.value = false
  }
}

const resetMapView = () => {
  if (map) {
    map.setView(crossBorderCenter, 11, { animate: true })
  }
}

onMounted(() => {
  initMap()
})

watch(() => props.selectedPlace, (newVal) => {
  if (newVal && map && newVal.lat && newVal.lng) {
    map.setView([newVal.lat, newVal.lng], 14, { animate: true })
    const found = markers.find(m => m.id === newVal.id)
    if (found) {
      found.marker.openPopup()
    }
  }
})
</script>
