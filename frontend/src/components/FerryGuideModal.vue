<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
    <div class="bg-white w-full max-w-4xl rounded-3xl p-6 sm:p-7 border-2 border-slate-300 shadow-2xl relative max-h-[92vh] overflow-y-auto">
      
      <button 
        @click="$emit('close')" 
        class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-200 text-slate-800 hover:bg-slate-300 flex items-center justify-center text-sm font-black z-10 transition-colors border border-slate-400 cursor-pointer shadow-sm"
      >
        ✕
      </button>

      <!-- Header & Real-time Live Badge -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b-2 border-slate-200 pb-4">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-sky-100 text-teal-ocean flex items-center justify-center text-2xl font-black border-2 border-sky-300 shadow-sm">
            🚢
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-xl font-black text-teal-ink">Jadwal Keberangkatan Feri Real-Time</h3>
              <span class="flex h-2.5 w-2.5 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-600"></span>
              </span>
            </div>
            <p class="text-xs text-slate-600 font-medium">Rute Singapura (HarbourFront / Tanah Merah) ↔ Batam (Harbour Bay / Batam Centre / Nongsa / Sekupang)</p>
          </div>
        </div>

        <div class="flex items-center space-x-2 bg-teal-900 text-white px-4 py-2 rounded-xl border border-teal-700 shadow-sm">
          <span class="text-xs text-teal-200 font-medium">Waktu Real-Time:</span>
          <span class="text-xs font-mono font-black text-emerald-400">{{ currentTimeString }}</span>
        </div>
      </div>

      <!-- Route Selector Filter Tabs -->
      <div class="flex flex-wrap gap-2.5 mb-6">
        <button 
          v-for="tab in routeTabs" 
          :key="tab.id"
          @click="activeRoute = tab.id"
          :class="activeRoute === tab.id ? 'bg-sky-100 text-sky-950 border-2 border-sky-400 font-black shadow-sm' : 'bg-slate-100 text-slate-800 font-bold hover:bg-slate-200 border-2 border-slate-300'"
          class="px-4 py-2 rounded-xl text-xs transition-all cursor-pointer"
        >
          {{ tab.label }}
        </button>
      </div>

      <!-- Active Route Real-Time Schedules Grid -->
      <div class="space-y-3.5 mb-6">
        <div 
          v-for="(trip, idx) in activeSchedules" 
          :key="idx"
          class="p-4 rounded-2xl bg-white border-2 border-slate-200 hover:border-teal-400 hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4"
        >
          <!-- Trip Operator & Route Info -->
          <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-sky-100 text-teal-ocean border-2 border-sky-200 flex items-center justify-center text-2xl shadow-sm">
              🚢
            </div>
            <div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-black text-teal-ink">{{ trip.operator }}</span>
                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase border" :class="trip.badgeColor">
                  {{ trip.tag }}
                </span>
              </div>
              <p class="text-xs text-slate-600 font-medium mt-0.5">Rute: {{ trip.route }}</p>
            </div>
          </div>

          <!-- Times: Departure -> Arrival -->
          <div class="flex items-center gap-6 font-mono">
            <div>
              <p class="text-[10px] text-slate-500 uppercase font-black font-sans">Berangkat (SGT)</p>
              <p class="text-base font-black text-teal-ocean">{{ trip.departureTime }}</p>
            </div>
            <div class="text-center">
              <span class="text-xs text-slate-600 font-bold font-sans">⏱️ {{ trip.duration }}m</span>
              <div class="w-16 h-1 bg-slate-300 rounded my-1"></div>
            </div>
            <div>
              <p class="text-[10px] text-slate-500 uppercase font-black font-sans">Estimasi Tiba (WIB)</p>
              <p class="text-base font-black text-emerald-700">{{ trip.arrivalTime }}</p>
            </div>
          </div>

          <!-- Live Trip Status Badge & Countdown -->
          <div class="text-right">
            <span class="px-3 py-1.5 rounded-xl text-xs font-black font-mono inline-flex items-center gap-1.5 shadow-sm border" :class="trip.statusClass">
              <span v-if="trip.status === 'BOARDING'" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              {{ trip.statusText }}
            </span>
            <p v-if="trip.countdown" class="text-[11px] text-amber-800 font-black font-mono mt-1">⏳ {{ trip.countdown }}</p>
          </div>
        </div>
      </div>

      <!-- Immigration & Customs Travel Guide -->
      <div class="p-4 rounded-2xl bg-sky-50 border-2 border-sky-200">
        <h4 class="text-xs font-black text-teal-900 uppercase tracking-wider mb-2">📋 Catatan Imigrasi & e-VoA Masuk Batam</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs text-slate-800 font-medium">
          <div class="flex items-start gap-2">
            <span>✅</span>
            <span><strong>WNA Singapore</strong>: Free Visa Wisata 30 Hari (Tanpa Biaya Visa).</span>
          </div>
          <div class="flex items-start gap-2">
            <span>🛂</span>
            <span><strong>Paspor Non-ASEAN</strong>: e-VoA online (Rp 500.000 / ~S$ 36) bayar di pelabuhan.</span>
          </div>
          <div class="flex items-start gap-2">
            <span>📱</span>
            <span><strong>e-CD (Customs Declaration)</strong>: Pengisian deklarasi bea cukai online gratis sebelum mendarat.</span>
          </div>
          <div class="flex items-start gap-2">
            <span>⏰</span>
            <span><strong>Perbedaan Waktu</strong>: Batam 1 Jam Lebih Lambat dari Singapore (SGT = WIB + 1 Jam).</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

defineProps({ show: Boolean })
defineEmits(['close'])

const activeRoute = ref('harbour-bay')
const now = ref(new Date())
let timer = null

const currentTimeString = computed(() => {
  return now.value.toLocaleTimeString('en-US', { hour12: false }) + ' SGT'
})

const routeTabs = [
  { id: 'harbour-bay', label: 'HarbourFront ➔ Harbour Bay' },
  { id: 'batam-centre', label: 'HarbourFront ➔ Batam Centre' },
  { id: 'nongsa', label: 'Tanah Merah ➔ Nongsa Pura' },
  { id: 'sekupang', label: 'HarbourFront ➔ Sekupang' }
]

const baseSchedules = {
  'harbour-bay': [
    { operator: 'Horizon Fast Ferry', route: 'HarbourFront ➔ Harbour Bay', dep: '08:00', duration: 45, tag: 'Terdekat Nagoya', badgeColor: 'bg-emerald-100 text-emerald-900 border-emerald-300' },
    { operator: 'Horizon Fast Ferry', route: 'HarbourFront ➔ Harbour Bay', dep: '09:30', duration: 45, tag: 'Terdekat Nagoya', badgeColor: 'bg-emerald-100 text-emerald-900 border-emerald-300' },
    { operator: 'Horizon Fast Ferry', route: 'HarbourFront ➔ Harbour Bay', dep: '11:15', duration: 45, tag: 'Terdekat Nagoya', badgeColor: 'bg-emerald-100 text-emerald-900 border-emerald-300' },
    { operator: 'Horizon Fast Ferry', route: 'HarbourFront ➔ Harbour Bay', dep: '14:00', duration: 45, tag: 'Terdekat Nagoya', badgeColor: 'bg-emerald-100 text-emerald-900 border-emerald-300' },
    { operator: 'Horizon Fast Ferry', route: 'HarbourFront ➔ Harbour Bay', dep: '16:30', duration: 45, tag: 'Terdekat Nagoya', badgeColor: 'bg-emerald-100 text-emerald-900 border-emerald-300' },
    { operator: 'Horizon Fast Ferry', route: 'HarbourFront ➔ Harbour Bay', dep: '19:00', duration: 45, tag: 'Terdekat Nagoya', badgeColor: 'bg-emerald-100 text-emerald-900 border-emerald-300' }
  ],
  'batam-centre': [
    { operator: 'BatamFast', route: 'HarbourFront ➔ Batam Centre', dep: '07:40', duration: 60, tag: 'Terdekat RS Awal Bros', badgeColor: 'bg-sky-100 text-sky-900 border-sky-300' },
    { operator: 'Majestic Fast Ferry', route: 'HarbourFront ➔ Batam Centre', dep: '08:45', duration: 60, tag: 'Terdekat RS Awal Bros', badgeColor: 'bg-sky-100 text-sky-900 border-sky-300' },
    { operator: 'Sindo Ferry', route: 'HarbourFront ➔ Batam Centre', dep: '10:20', duration: 60, tag: 'Terdekat RS Awal Bros', badgeColor: 'bg-sky-100 text-sky-900 border-sky-300' },
    { operator: 'BatamFast', route: 'HarbourFront ➔ Batam Centre', dep: '12:50', duration: 60, tag: 'Terdekat RS Awal Bros', badgeColor: 'bg-sky-100 text-sky-900 border-sky-300' },
    { operator: 'Majestic Fast Ferry', route: 'HarbourFront ➔ Batam Centre', dep: '15:20', duration: 60, tag: 'Terdekat RS Awal Bros', badgeColor: 'bg-sky-100 text-sky-900 border-sky-300' },
    { operator: 'BatamFast', route: 'HarbourFront ➔ Batam Centre', dep: '18:10', duration: 60, tag: 'Terdekat RS Awal Bros', badgeColor: 'bg-sky-100 text-sky-900 border-sky-300' }
  ],
  'nongsa': [
    { operator: 'BatamFast', route: 'Tanah Merah ➔ Nongsa Pura', dep: '08:00', duration: 45, tag: 'Kawasan Luxury Golf', badgeColor: 'bg-purple-100 text-purple-900 border-purple-300' },
    { operator: 'BatamFast', route: 'Tanah Merah ➔ Nongsa Pura', dep: '12:00', duration: 45, tag: 'Kawasan Luxury Golf', badgeColor: 'bg-purple-100 text-purple-900 border-purple-300' },
    { operator: 'BatamFast', route: 'Tanah Merah ➔ Nongsa Pura', dep: '15:30', duration: 45, tag: 'Kawasan Luxury Golf', badgeColor: 'bg-purple-100 text-purple-900 border-purple-300' },
    { operator: 'BatamFast', route: 'Tanah Merah ➔ Nongsa Pura', dep: '18:20', duration: 45, tag: 'Kawasan Luxury Golf', badgeColor: 'bg-purple-100 text-purple-900 border-purple-300' }
  ],
  'sekupang': [
    { operator: 'Majestic Fast Ferry', route: 'HarbourFront ➔ Sekupang', dep: '08:40', duration: 45, tag: 'Kawasan Barat', badgeColor: 'bg-amber-100 text-amber-900 border-amber-300' },
    { operator: 'Sindo Ferry', route: 'HarbourFront ➔ Sekupang', dep: '11:20', duration: 45, tag: 'Kawasan Barat', badgeColor: 'bg-amber-100 text-amber-900 border-amber-300' },
    { operator: 'Majestic Fast Ferry', route: 'HarbourFront ➔ Sekupang', dep: '14:10', duration: 45, tag: 'Kawasan Barat', badgeColor: 'bg-amber-100 text-amber-900 border-amber-300' },
    { operator: 'Sindo Ferry', route: 'HarbourFront ➔ Sekupang', dep: '17:30', duration: 45, tag: 'Kawasan Barat', badgeColor: 'bg-amber-100 text-amber-900 border-amber-300' }
  ]
}

const activeSchedules = computed(() => {
  const currentMinutes = now.value.getHours() * 60 + now.value.getMinutes()

  return (baseSchedules[activeRoute.value] || []).map(item => {
    const [h, m] = item.dep.split(':').map(Number)
    const depMinutes = h * 60 + m
    
    // Arrival time in WIB (SGT - 1hr + duration)
    const arrTotalMinutes = (depMinutes - 60 + item.duration + 1440) % 1440
    const arrH = Math.floor(arrTotalMinutes / 60).toString().padStart(2, '0')
    const arrM = (arrTotalMinutes % 60).toString().padStart(2, '0')
    const arrivalTimeStr = `${arrH}:${arrM}`

    let status = 'SCHEDULED'
    let statusText = '⚪ SCHEDULED'
    let statusClass = 'bg-slate-100 text-slate-800 border-slate-300'
    let countdown = null

    const diff = depMinutes - currentMinutes

    if (diff > 0 && diff <= 30) {
      status = 'BOARDING'
      statusText = '🟢 BOARDING NOW'
      statusClass = 'bg-emerald-100 text-emerald-900 border-emerald-400 font-black'
      countdown = `Keberangkatan dalam ${diff} menit`
    } else if (diff > 30 && diff <= 120) {
      status = 'UPCOMING'
      statusText = '🟡 UPCOMING'
      statusClass = 'bg-amber-100 text-amber-900 border-amber-400 font-bold'
      const hrs = Math.floor(diff / 60)
      const mins = diff % 60
      countdown = hrs > 0 ? `Dalam ${hrs}j ${mins}m` : `Dalam ${mins}m`
    } else if (diff <= 0 && diff >= -item.duration) {
      status = 'TRANSIT'
      statusText = '🔵 IN TRANSIT'
      statusClass = 'bg-sky-100 text-sky-900 border-sky-400 font-bold'
      countdown = `Estimasi tiba dalam ${item.duration + diff}m`
    } else if (diff < -item.duration) {
      status = 'DEPARTED'
      statusText = '⚪ DEPARTED'
      statusClass = 'bg-slate-100 text-slate-500 border-slate-300'
    }

    return {
      ...item,
      departureTime: item.dep + ' SGT',
      arrivalTime: arrivalTimeStr + ' WIB',
      status,
      statusText,
      statusClass,
      countdown
    }
  })
})

onMounted(() => {
  timer = setInterval(() => {
    now.value = new Date()
  }, 1000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})
</script>
