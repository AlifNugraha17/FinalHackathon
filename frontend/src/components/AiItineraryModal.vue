<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
    <div class="bg-white w-full max-w-2xl rounded-3xl p-6 sm:p-7 border-2 border-slate-300 shadow-2xl relative max-h-[90vh] overflow-y-auto">
      
      <!-- Close Button -->
      <button 
        @click="$emit('close')" 
        class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-200 text-slate-800 hover:bg-slate-300 flex items-center justify-center text-sm font-black transition-colors border border-slate-400 cursor-pointer shadow-sm"
      >
        ✕
      </button>

      <!-- Modal Title -->
      <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-2xl font-black border-2 border-amber-300 shadow-sm">
          ✨
        </div>
        <div>
          <h3 class="text-xl font-black text-teal-ink">AI Itinerary Generator Lintas Batas</h3>
          <p class="text-xs text-slate-600 font-medium">Rencanakan trip medis & liburan weekend dari Singapura ke Batam secara otomatis</p>
        </div>
      </div>

      <!-- Generator Options -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div>
          <label class="block text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Durasi Perjalanan</label>
          <select v-model="duration" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm">
            <option value="1day">1 Day Getaway (Pagi Datang, Sore Pulang)</option>
            <option value="2d1n">2D1N Weekend Trip (Menginap Resort/Hotel)</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Fokus Utama Trip</label>
          <select v-model="tripType" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm">
            <option value="medical-seafood">🩺 Medical Checkup + Seafood Feast</option>
            <option value="dental-shopping">🦷 Perawatan Gigi + Shopping Nagoya</option>
            <option value="golf-spa">⛳ Golf 18-Hole + Luxury Spa</option>
          </select>
        </div>
      </div>

      <button 
        @click="generateItinerary"
        :disabled="loading"
        class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-amber-600 to-teal-ocean hover:from-amber-700 hover:to-teal-700 text-white font-black text-sm transition-all flex items-center justify-center gap-2 shadow-xl shadow-amber-600/30 active:scale-95 mb-6 border border-amber-500 cursor-pointer"
      >
        <span v-if="loading" class="animate-spin">🌀</span>
        <span v-else>🚀 Buat Rencana Trip Otomatis</span>
      </button>

      <!-- Generated Timeline Results -->
      <div v-if="generatedItinerary.length > 0" class="mt-6 pt-6 border-t-2 border-slate-200">
        <h4 class="text-xs font-black text-teal-ocean uppercase tracking-wider mb-4">Rekomendasi Rute & Jadwal Trip</h4>
        
        <div class="space-y-3.5">
          <div 
            v-for="(step, idx) in generatedItinerary" 
            :key="idx"
            class="flex items-start gap-4 p-4 rounded-2xl bg-sky-50 border-2 border-sky-200 shadow-sm"
          >
            <span class="px-3 py-1.5 rounded-xl bg-teal-900 text-white text-xs font-mono font-black whitespace-nowrap shadow-sm border border-teal-700">
              {{ step.time }}
            </span>
            <div class="flex-1">
              <h5 class="text-sm font-black text-teal-ink">{{ step.title }}</h5>
              <p class="text-xs text-slate-700 font-medium mt-0.5">{{ step.description }}</p>
              <div class="mt-2 flex items-center gap-3 text-xs text-slate-700 font-bold">
                <span>📍 {{ step.location }}</span>
                <span>•</span>
                <span class="text-emerald-800 font-black">Est: S$ {{ step.costSgd }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 p-4 rounded-2xl bg-emerald-50 border-2 border-emerald-300 flex items-center justify-between shadow-sm">
          <div>
            <p class="text-xs text-emerald-900 font-black">Total Estimasi Hemat Trip Ini</p>
            <p class="text-lg font-black text-emerald-800">Hemat S$ 850+ vs Layanan SG</p>
          </div>
          <button @click="$emit('book-all')" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition-all shadow-md active:scale-95 border border-emerald-500 cursor-pointer">
            Pesan Paket Ini
          </button>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  show: Boolean
})

defineEmits(['close', 'book-all'])

const duration = ref('1day')
const tripType = ref('medical-seafood')
const loading = ref(false)
const generatedItinerary = ref([])

const generateItinerary = () => {
  loading.value = true
  setTimeout(() => {
    loading.value = false
    if (tripType.value === 'medical-seafood') {
      generatedItinerary.value = [
        { time: '08:00 AM', title: 'Feri dari HarbourFront SG ke Batam Centre', description: 'Naik kapal BatamFast / Majestic (Durasi 45 menit).', location: 'HarbourFront Terminal', costSgd: 35 },
        { time: '09:15 AM', title: 'Penjemputan VIP ke RS Awal Bros Batam', description: 'Layanan penjemputan gratis menuju pusat pemeriksaan kesehatan.', location: 'Batam Centre Terminal', costSgd: 0 },
        { time: '09:45 AM', title: 'Comprehensive Executive Health Screening', description: 'Pemeriksaan darah lengkap, EKG, USG & konsultasi dokter spesialis.', location: 'RS Awal Bros Batam', costSgd: 280 },
        { time: '01:00 PM', title: 'Makan Siang Seafood Kelong Nagoya', description: 'Kepiting lada hitam, udang galah, dan ikan bakar segar.', location: 'Nagoya Seafood Hub', costSgd: 40 },
        { time: '03:00 PM', title: 'Traditional Balinese Body Massage (2 Jam)', description: 'Relaksasi tubuh total di Royal Spa & Wellness.', location: 'Royal Spa Nagoya', costSgd: 45 },
        { time: '06:30 PM', title: 'Feri Kembali ke Singapura', description: 'Kembali dari Harbour Bay Terminal ke HarbourFront SG.', location: 'Harbour Bay Terminal', costSgd: 35 }
      ]
    } else if (tripType.value === 'dental-shopping') {
      generatedItinerary.value = [
        { time: '08:30 AM', title: 'Feri HarbourFront SG ➔ Harbour Bay Batam', description: 'Naik kapal feri kelas privat.', location: 'Harbour Bay Terminal', costSgd: 35 },
        { time: '09:30 AM', title: 'Perawatan Gigi Scaling & Teeth Whitening', description: 'Pembersihan karang gigi & pemutihan laser di Dental Wellness Nagoya.', location: 'Nagoya Dental Hub', costSgd: 180 },
        { time: '01:00 PM', title: 'Makan Siang & Shopping di Grand Batam Mall', description: 'Belanja produk fashion, gadget, dan kue lapis khas Batam.', location: 'Grand Batam Mall', costSgd: 60 },
        { time: '05:00 PM', title: 'Refleksi Kaki 90 Menit', description: 'Pijat refleksi santai sebelum pulang.', location: 'Nagoya Hill Spa', costSgd: 25 },
        { time: '07:30 PM', title: 'Feri Kembali ke Singapura', description: 'Kepulangan ke HarbourFront SG.', location: 'Harbour Bay Terminal', costSgd: 35 }
      ]
    } else {
      generatedItinerary.value = [
        { time: '07:30 AM', title: 'Feri Tanah Merah SG ➔ Nongsa Pura Batam', description: 'Kapal ekspres khusus ke kawasan resort barat.', location: 'Tanah Merah Terminal', costSgd: 35 },
        { time: '08:40 AM', title: '18-Hole Championship Golf Session', description: 'Tee off di Palm Springs Golf & Beach Resort.', location: 'Palm Springs Golf Nongsa', costSgd: 130 },
        { time: '01:30 PM', title: 'Seafood Buffet Lunch & Resort Spa', description: 'Makan siang mewah di tepi pantai dan pemijatan aromaterapi.', location: 'Nongsa Resort', costSgd: 75 },
        { time: '06:00 PM', title: 'Feri Kembali ke Singapura', description: 'Kembali ke Tanah Merah SG.', location: 'Nongsa Pura Terminal', costSgd: 35 }
      ]
    }
  }, 400)
}
</script>
