<template>
  <section class="hero-tropical-bg py-14 lg:py-18 border-b border-sky-200">
    <!-- Subtle Floating Cloud & Wave Accents -->
    <div class="absolute top-10 left-10 w-72 h-32 bg-white/40 rounded-full blur-2xl animate-cloud pointer-events-none"></div>
    <div class="absolute bottom-4 right-10 w-96 h-40 bg-sky-200/40 rounded-full blur-3xl animate-wave pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Top Pill Badge -->
      <div class="flex justify-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-900 text-white shadow-md border border-teal-700 mb-6">
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
          <span class="text-xs font-extrabold tracking-wide">{{ t?.hero_badge || 'Hanya 45 Menit Naik Kapal Feri dari Singapura' }}</span>
        </div>
      </div>

      <!-- Main Headline -->
      <div class="text-center max-w-4xl mx-auto">
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-teal-ink tracking-tight leading-tight">
          {{ t?.hero_title_1 || 'Pusat Wisata Medis, Spa & Getaway' }} <br class="hidden sm:inline"/>
          <span class="gradient-text">{{ t?.hero_title_2 || 'Hemat Hingga 70% di Batam' }}</span>
        </h1>

        <p class="mt-4 text-base sm:text-lg text-slate-700 max-w-2xl mx-auto font-medium">
          {{ t?.hero_desc || 'Dapatkan pemeriksaan kesehatan lengkap, perawatan gigi & estetika, spa tradisional, hingga kejuaraan golf 18-hole dengan transparansi harga kurs live SGD/IDR dan layanan antar-jemput privat dari pelabuhan feri.' }}
        </p>
      </div>

      <!-- Hero Visual Banner Showcase -->
      <div class="mt-8 max-w-4xl mx-auto relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900">
        <div class="relative h-60 sm:h-72 lg:h-80 bg-slate-900 overflow-hidden">
          <img 
            src="/images/hero-ferry.jpg" 
            alt="Kapal Feri Lintas Batas SG Batam" 
            class="w-full h-full object-cover"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-slate-900/20"></div>
          
          <div class="absolute bottom-4 left-4 sm:bottom-6 sm:left-6 right-4 sm:right-auto max-w-xl bg-slate-950/85 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-white/20 shadow-2xl">
            <span class="inline-block px-3 py-1 rounded-md bg-teal-500 text-slate-950 text-xs font-black uppercase tracking-wider mb-1.5 shadow-sm">
              🚢 Akses Cepat Singapura ⇄ Batam
            </span>
            <h3 class="text-lg sm:text-2xl font-black text-white leading-snug drop-shadow-md">
              Perjalanan Nyaman dari HarbourFront & Tanah Merah SG
            </h3>
            <p class="text-xs sm:text-sm text-slate-200 mt-1 font-medium drop-shadow">
              Terminal Harbour Bay, Batam Centre, Nongsa Pura, dan Sekupang siap menyambut Anda.
            </p>
          </div>

          <div class="absolute top-4 right-4 hidden sm:flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-xl bg-slate-950/85 text-emerald-400 text-xs font-black shadow-xl border border-white/20 backdrop-blur-md">
              ✨ 60+ Trip Feri Harian
            </span>
          </div>
        </div>
      </div>

      <!-- Search & Filter Bar -->
      <div class="mt-8 max-w-4xl mx-auto bg-white p-5 sm:p-6 rounded-2xl shadow-xl border-2 border-sky-200">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          
          <!-- Category Selector -->
          <div class="text-left">
            <label class="block text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">
              {{ t?.label_select_cat || 'Kategori Layanan' }}
            </label>
            <select 
              :value="selectedCategory" 
              @change="$emit('update:selectedCategory', $event.target.value)"
              class="w-full bg-slate-50 border-2 border-slate-300 hover:border-teal-500 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm"
            >
              <option value="all">{{ t?.cat_all || 'Semua Kategori (Medis, Spa, Golf)' }}</option>
              <option value="medical">🩺 {{ t?.cat_medical || 'Rumah Sakit & Checkup' }}</option>
              <option value="dental">🦷 {{ t?.cat_dental || 'Perawatan Gigi (Dental)' }}</option>
              <option value="spa">💆‍♀️ {{ t?.cat_spa || 'Wellness & Spa' }}</option>
              <option value="golf">⛳ {{ t?.cat_golf || 'Resort & Golf Course' }}</option>
              <option value="culinary">🦀 Seafood & Culinary</option>
            </select>
          </div>

          <!-- Ferry Terminal Proximity -->
          <div class="text-left">
            <label class="block text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">
              {{ t?.label_select_port || 'Pilihan Pelabuhan Feri' }}
            </label>
            <select 
              :value="selectedTerminal" 
              @change="$emit('update:selectedTerminal', $event.target.value)"
              class="w-full bg-slate-50 border-2 border-slate-300 hover:border-teal-500 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm"
            >
              <option value="all">{{ t?.all_ports || 'Semua Terminal Terdekat' }}</option>
              <option value="harbourfront-sg">🇸🇬 HarbourFront Terminal (SG)</option>
              <option value="tanah-merah-sg">🇸🇬 Tanah Merah Terminal (SG)</option>
              <option value="harbour-bay">🇮🇩 Harbour Bay (Nagoya/Downtown)</option>
              <option value="batam-centre">🇮🇩 Batam Centre (Pusat Kota)</option>
              <option value="sekupang">🇮🇩 Sekupang Terminal</option>
              <option value="nongsa">🇮🇩 Nongsa Pura (Resort Area)</option>
            </select>
          </div>

          <!-- Search Action Button -->
          <div class="flex items-end">
            <button 
              @click="$emit('search')"
              class="w-full bg-gradient-to-r from-sky-500 via-teal-600 to-emerald-600 hover:from-sky-600 hover:via-teal-700 hover:to-emerald-700 text-white font-black py-3 px-5 rounded-xl text-sm transition-all flex items-center justify-center gap-2.5 shadow-xl shadow-teal-700/30 hover:shadow-teal-700/50 active:scale-95 border-2 border-teal-300 cursor-pointer group"
            >
              <span class="text-base group-hover:scale-110 transition-transform">🔍</span>
              <span class="tracking-wide uppercase text-xs sm:text-sm font-black">{{ t?.btn_search || 'Cari Destinasi' }}</span>
            </button>
          </div>

        </div>
      </div>

      <!-- Quick Stats Metrics -->
      <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
        <div class="bg-white p-4 rounded-2xl text-center border-2 border-sky-100 shadow-md hover:border-teal-300 transition-all">
          <p class="text-2xl sm:text-3xl font-black text-teal-ocean">70%</p>
          <p class="text-xs font-bold text-slate-700 mt-0.5">{{ t?.metric_batam || 'Estimasi Hemat vs Singapura' }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl text-center border-2 border-emerald-100 shadow-md hover:border-emerald-300 transition-all">
          <p class="text-2xl sm:text-3xl font-black text-emerald-600">45 Min</p>
          <p class="text-xs font-bold text-slate-700 mt-0.5">{{ t?.metric_ferry || 'Perjalanan Kapal Feri' }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl text-center border-2 border-amber-100 shadow-md hover:border-amber-300 transition-all">
          <p class="text-2xl sm:text-3xl font-black text-amber-600">50+</p>
          <p class="text-xs font-bold text-slate-700 mt-0.5">{{ t?.metric_dest || 'Mitra Medis & Spa Terverifikasi' }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl text-center border-2 border-purple-100 shadow-md hover:border-purple-300 transition-all">
          <p class="text-2xl sm:text-3xl font-black text-purple-600">4.9 ★</p>
          <p class="text-xs font-bold text-slate-700 mt-0.5">{{ t?.metric_complete_sub || 'Rating Kepuasan Wisatawan' }}</p>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
defineProps({
  selectedCategory: { type: String, default: 'all' },
  selectedTerminal: { type: String, default: 'all' },
  selectedCountry: { type: String, default: 'all' },
  t: { type: Object, default: () => ({}) }
})

defineEmits(['update:selectedCategory', 'update:selectedTerminal', 'update:selectedCountry', 'search'])
</script>
