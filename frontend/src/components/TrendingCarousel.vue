<template>
  <section class="py-14 bg-gradient-to-b from-white via-sky-50/50 to-slate-100 relative overflow-hidden border-b border-slate-200">
    <!-- Background subtle ambient circles -->
    <div class="absolute -top-24 right-10 w-96 h-96 bg-sky-200/50 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 left-10 w-96 h-96 bg-emerald-100/60 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Section Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-900 text-white text-xs font-extrabold uppercase tracking-wider mb-2.5 shadow-sm border border-teal-700">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
            Spot & Destinasi Favorit Batam
          </div>
          <h2 class="text-2xl sm:text-3xl font-black text-teal-ink tracking-tight">
            Eksplorasi Destinasi Trending & Viral di Batam
          </h2>
          <p class="text-sm text-slate-700 mt-1 max-w-2xl font-medium">
            Pilihan liburan akhir pekan & layanan medis terbaik hanya 45 menit perjalanan kapal feri dari Singapura.
          </p>
        </div>

        <!-- Navigation Buttons (Prominent Solid Colored) -->
        <div class="flex items-center gap-2.5 mt-4 md:mt-0">
          <button 
            @click="prevSlide" 
            class="w-12 h-12 rounded-full bg-teal-700 hover:bg-teal-800 text-white border-2 border-teal-500 shadow-lg shadow-teal-700/30 flex items-center justify-center text-xl font-black transition-all active:scale-90 cursor-pointer"
            title="Slide Sebelumnya"
          >
            ←
          </button>
          <button 
            @click="nextSlide" 
            class="w-12 h-12 rounded-full bg-teal-700 hover:bg-teal-800 text-white border-2 border-teal-500 shadow-lg shadow-teal-700/30 flex items-center justify-center text-xl font-black transition-all active:scale-90 cursor-pointer"
            title="Slide Berikutnya"
          >
            →
          </button>
        </div>
      </div>

      <!-- Main Carousel Card -->
      <div 
        class="relative rounded-3xl overflow-hidden shadow-2xl border-2 border-sky-200 bg-white group cursor-pointer"
        @mouseenter="pauseAutoSlide"
        @mouseleave="resumeAutoSlide"
      >
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[400px] sm:min-h-[460px]">
          
          <!-- Image Banner (7 Cols) -->
          <div class="lg:col-span-7 relative overflow-hidden bg-slate-900 min-h-[280px] sm:min-h-[360px] lg:min-h-full">
            <transition name="fade" mode="out-in">
              <img 
                :key="currentSlide.image"
                :src="currentSlide.image" 
                :alt="currentSlide.title" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
              />
            </transition>
            
            <!-- Dark gradient overlay for text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-slate-950/50"></div>
            
            <!-- Top Badges on Image (High-Contrast Dark Glass Badges) -->
            <div class="absolute top-4 left-4 flex flex-wrap gap-2.5 z-10">
              <span class="px-3.5 py-1.5 rounded-xl text-xs font-black shadow-xl bg-slate-950/90 text-emerald-400 border border-white/20 backdrop-blur-md">
                {{ currentSlide.highlight }}
              </span>
              <span class="px-3.5 py-1.5 rounded-xl bg-teal-950/95 text-teal-100 text-xs font-bold backdrop-blur-md shadow-xl border border-teal-500/40">
                📍 {{ currentSlide.location }}
              </span>
            </div>

            <!-- Slide Tag Overlay on Image (Mobile & Tablet) -->
            <div class="absolute bottom-4 left-4 right-4 lg:hidden bg-slate-950/90 backdrop-blur-md p-4 rounded-2xl border border-white/20 text-white shadow-xl">
              <span class="text-xs font-black uppercase tracking-wider text-teal-300">{{ currentSlide.category }}</span>
              <h3 class="text-base font-black text-white mt-0.5 leading-snug">{{ currentSlide.title }}</h3>
            </div>
          </div>

          <!-- Description & Details (5 Cols) -->
          <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between bg-gradient-to-br from-white via-sky-50/40 to-slate-50 border-l border-slate-200">
            <div>
              <div class="flex items-center justify-between mb-3.5">
                <span class="px-3 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider bg-teal-100 text-teal-900 border border-teal-300">
                  {{ currentSlide.category }}
                </span>
                <span class="text-xs font-mono font-black text-teal-900 bg-sky-100 px-2.5 py-1 rounded-lg border border-sky-200">
                  0{{ currentIndex + 1 }} / 0{{ slides.length }}
                </span>
              </div>

              <h3 class="text-xl sm:text-2xl font-black text-teal-ink leading-tight mb-3">
                {{ currentSlide.title }}
              </h3>

              <p class="text-sm text-slate-700 font-medium leading-relaxed mb-6">
                {{ currentSlide.desc }}
              </p>

              <!-- Highlights Bullet Points -->
              <div class="space-y-2.5 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <div 
                  v-for="(point, idx) in currentSlide.perks" 
                  :key="idx"
                  class="flex items-center gap-2.5 text-xs text-slate-800 font-bold"
                >
                  <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black text-[10px] shadow-sm">✓</span>
                  <span>{{ point }}</span>
                </div>
              </div>
            </div>

            <!-- Bottom Price & CTA Area -->
            <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
              <div>
                <p class="text-[11px] text-slate-500 uppercase tracking-wider font-bold">Estimasi Biaya</p>
                <p class="text-xl font-black text-teal-800">
                  {{ currentSlide.priceLabel }}
                </p>
              </div>

              <!-- Colorful Vibrant Solid CTA Button (Lihat Paket Resort / Reservasi / dll) -->
              <button 
                @click="handleSlideAction(currentSlide)"
                class="px-7 py-3.5 rounded-2xl text-white font-black text-xs shadow-xl flex items-center justify-center gap-2.5 active:scale-95 transition-all border-2 border-white/40 cursor-pointer bg-gradient-to-r"
                :class="currentSlide.btnGradient"
                style="color: #ffffff !important;"
              >
                <span class="text-base">{{ currentSlide.btnIcon }}</span>
                <span class="tracking-wider uppercase font-black">{{ currentSlide.actionText }}</span>
                <span class="text-sm">➔</span>
              </button>
            </div>

          </div>

        </div>

        <!-- Carousel Indicators (Dots) -->
        <div class="bg-slate-100 px-6 py-3 border-t border-slate-200 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <button 
              v-for="(_, idx) in slides" 
              :key="idx"
              @click="goToSlide(idx)"
              class="h-3 rounded-full transition-all duration-300 cursor-pointer"
              :class="currentIndex === idx ? 'w-9 bg-teal-700' : 'w-3 bg-slate-300 hover:bg-slate-400'"
              :title="`Slide ${idx + 1}`"
            ></button>
          </div>

          <div class="text-[11px] text-slate-700 font-black flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Auto-slide aktif • Arahkan kursor untuk menjeda
          </div>
        </div>

      </div>

      <!-- Quick Category Pills (Clearly distinct colored cards) -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 mt-6">
        <div 
          v-for="(cat, idx) in quickCategories" 
          :key="idx"
          @click="goToSlide(cat.slideIndex)"
          class="p-3.5 rounded-2xl border-2 transition-all cursor-pointer flex items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5"
          :class="cat.cardBg"
        >
          <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl shadow-sm" :class="cat.iconBg">
            {{ cat.icon }}
          </div>
          <div>
            <h4 class="text-xs font-black text-teal-ink">{{ cat.title }}</h4>
            <p class="text-[11px] text-slate-600 font-medium">{{ cat.subtitle }}</p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const emit = defineEmits(['open-ferry', 'open-ai', 'open-booking', 'scroll-to-listings'])

const currentIndex = ref(0)
let timer = null

const slides = [
  {
    title: "Aesthetic Seaside Cafe & Sunset Lounge",
    category: "Cafe Viral & Sunset",
    location: "Harbour Bay & Batam Kota",
    image: "/images/viral-cafe.jpg",
    desc: "Cafe estetik dengan konsep santorini bernuansa putih-biru di tepi waterfront. Nikmati iced latte, tropical mocktail, dan pemandangan sunset memukau ke arah kapal feri yang melintas menuju Singapura.",
    highlight: "🔥 Viral di TikTok & Reels",
    priceLabel: "S$ 6 - 15 (~Rp 80rb)",
    actionType: "booking",
    actionText: "Reservasi & Info",
    btnIcon: "☕",
    btnGradient: "from-sky-600 via-blue-600 to-indigo-700 hover:from-sky-700 hover:to-indigo-800 shadow-blue-600/30",
    perks: [
      "Spot sunset pemandangan laut lepas terbaik",
      "Pilihan pastry artisan & specialty coffee",
      "Hanya 5 menit jalan kaki dari Harbour Bay Ferry"
    ]
  },
  {
    title: "Beach Club & Resort Pasir Putih Nongsa",
    category: "Pantai & Relaksasi",
    location: "Kawasan Wisata Nongsa Coast",
    image: "/images/viral-beach.jpg",
    desc: "Hamparan pasir putih bersih, air laut jernih toska, dan daybed nyaman di bawah payung tropis. Bersantai di beach club dengan panorama gedung pencakar langit Singapura dari kejauhan.",
    highlight: "🌴 Hidden Gem Pantai",
    priceLabel: "S$ 25 - 60 (~Rp 350rb)",
    actionType: "booking",
    actionText: "Lihat Paket Resort",
    btnIcon: "🌴",
    btnGradient: "from-emerald-600 via-teal-600 to-green-700 hover:from-emerald-700 hover:to-green-800 shadow-emerald-600/30",
    perks: [
      "Private beach dengan watersports seru",
      "Suasana tenang & eksklusif kelas internasional",
      "Dekat terminal feri Nongsa Pura"
    ]
  },
  {
    title: "Pelayaran Kapal Feri Cepat SG ⇄ Batam",
    category: "Transportasi Feri 45 Menit",
    location: "HarbourFront & Tanah Merah (SG)",
    image: "/images/hero-ferry.jpg",
    desc: "Layanan kapal feri modern harian berkecepatan tinggi dengan AC kabin sejuk, VIP lounge, dan jadwal berangkat setiap 30-60 menit sepanjang hari.",
    highlight: "🚢 Transit Cepat 45 Menit",
    priceLabel: "Mulai S$ 35 (Return ticket)",
    actionType: "ferry",
    actionText: "Cek Jadwal Feri",
    btnIcon: "🚢",
    btnGradient: "from-amber-600 via-orange-600 to-amber-700 hover:from-amber-700 hover:to-orange-800 shadow-amber-600/30",
    perks: [
      "Jadwal fleksibel BatamFast, Majestic & Horizon",
      "Bebas Visa 30 hari untuk paspor Singapura",
      "Dukungan bagasi dan check-in cepat"
    ]
  },
  {
    title: "RS Awal Bros Batam — Executive Health Screening",
    category: "Wisata Medis Berstandar Global",
    location: "Batam Centre (Pusat Kota)",
    image: "https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=1200&q=80",
    desc: "Paket medical checkup eksekutif komprehensif, pemeriksaan laboratorium lengkap, USG, EKG, dan konsultasi dokter spesialis dengan penghematan biaya hingga 70% dibanding Singapura.",
    highlight: "🏥 Hemat Hingga 70%",
    priceLabel: "S$ 280 (SG Est: S$ 880)",
    actionType: "booking",
    actionText: "Janji Dokter VIP",
    btnIcon: "🩺",
    btnGradient: "from-teal-600 via-cyan-700 to-teal-800 hover:from-teal-700 hover:to-cyan-800 shadow-teal-600/30",
    perks: [
      "Hasil pemeriksaan keluar pada hari yang sama",
      "Dokter spesialis lulusan universitas ternama",
      "Layanan antar-jemput privat dari pelabuhan"
    ]
  }
]

const currentSlide = computed(() => slides[currentIndex.value])

const quickCategories = [
  { title: "Cafe & Sunset", subtitle: "Spot viral Harbour Bay", icon: "☕", iconBg: "bg-sky-200 text-sky-800", cardBg: "bg-sky-50 border-sky-300 hover:border-teal-600", slideIndex: 0 },
  { title: "Pantai Nongsa", subtitle: "Beach club & resort", icon: "🌴", iconBg: "bg-emerald-200 text-emerald-800", cardBg: "bg-emerald-50 border-emerald-300 hover:border-emerald-600", slideIndex: 1 },
  { title: "Jadwal Feri", subtitle: "45 min SG ke Batam", icon: "🚢", iconBg: "bg-amber-200 text-amber-800", cardBg: "bg-amber-50 border-amber-300 hover:border-amber-600", slideIndex: 2 },
  { title: "Wisata Medis", subtitle: "Hemat s/d 70%", icon: "🩺", iconBg: "bg-teal-200 text-teal-800", cardBg: "bg-teal-50 border-teal-300 hover:border-teal-600", slideIndex: 3 },
]

const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % slides.length
}

const prevSlide = () => {
  currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length
}

const goToSlide = (idx) => {
  currentIndex.value = idx
}

const handleSlideAction = (slide) => {
  if (slide.actionType === 'ferry') {
    emit('open-ferry')
  } else if (slide.actionType === 'booking') {
    emit('open-booking', null)
  } else {
    emit('scroll-to-listings')
  }
}

const startAutoSlide = () => {
  timer = setInterval(nextSlide, 4800)
}

const pauseAutoSlide = () => {
  if (timer) clearInterval(timer)
}

const resumeAutoSlide = () => {
  pauseAutoSlide()
  startAutoSlide()
}

onMounted(() => {
  startAutoSlide()
})

onUnmounted(() => {
  pauseAutoSlide()
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
