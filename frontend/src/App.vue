<template>
  <div class="min-h-screen bg-slate-50 text-teal-ink flex flex-col font-sans antialiased">
    
    <!-- Navbar -->
    <Navbar 
      :currency="currency"
      :exchange-rate="exchangeRate"
      :active-nav="activeNav"
      :lang="lang"
      :t="t"
      @nav="handleNav"
      @toggle-currency="toggleCurrency"
      @set-currency="c => currency = c"
      @set-lang="setLang"
      @open-price-check="openPriceCheck"
      @open-ferry="openFerryGuide"
      @open-ai="openAiItinerary"
      @open-booking="openBookingModal(null)"
    />

    <!-- Main Content Body -->
    <main class="flex-1">
      
      <!-- Hero Section -->
      <HeroSection 
        v-model:selected-category="selectedCategory"
        v-model:selected-terminal="selectedTerminal"
        v-model:selected-country="selectedCountry"
        :t="t"
        @search="scrollToMedical"
      />

      <!-- Trending & Viral Batam Destinations Carousel -->
      <TrendingCarousel 
        @open-ferry="showFerryModal = true"
        @open-ai="showAiModal = true"
        @open-booking="openBookingModal(null)"
        @scroll-to-listings="scrollToMedical"
      />

      <!-- Medical & Tourism Listings -->
      <div id="listings-section">
        <MedicalListings 
          :places="places"
          :currency="currency"
          :exchange-rate="exchangeRate"
          :selected-category="selectedCategory"
          :selected-terminal="selectedTerminal"
          :selected-country="selectedCountry"
          :t="t"
          @update:selected-country="c => selectedCountry = c"
          @set-currency="c => currency = c"
          @select-map="handleSelectMap"
          @book="openBookingModal"
        />
      </div>

      <!-- Map Explorer (PostGIS Spatial Visualizer) -->
      <div id="map-section">
        <MapView 
          :places="places"
          :selected-place="selectedMapPlace"
          :t="t"
        />
      </div>

      <!-- Verified Cross-Border Testimonials & Rating System (Singapore Visitors) -->
      <TestimonialsSection 
        :currency="currency"
        :exchange-rate="exchangeRate"
        :places="places"
        :t="t"
      />

      <!-- Features & Why Batam Section -->
      <section class="py-16 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-ocean">{{ t?.feat_tag || 'Pengalaman Lintas Batas (SG ⇄ Batam)' }}</span>
            <h2 class="text-3xl font-extrabold text-teal-ink mt-1.5">{{ t?.feat_title || 'Mengapa Wisatawan Singapura Memilih Batam?' }}</h2>
            <p class="text-sm text-slate-600 mt-2">{{ t?.feat_desc || 'Kombinasi sempurna antara hemat biaya medis, kemudahan transportasi kapal feri, dan kualitas pelayanan standar internasional.' }}</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-7 rounded-3xl border border-sky-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all">
              <div class="w-13 h-13 rounded-2xl bg-sky-100 text-teal-ocean flex items-center justify-center text-3xl font-bold mb-5 shadow-sm">
                🏥
              </div>
              <h3 class="text-lg font-bold text-teal-ink mb-2">{{ t?.feat_1_title || 'Fasilitas RS Berstandar Internasional' }}</h3>
              <p class="text-xs text-slate-600 leading-relaxed">
                {{ t?.feat_1_desc || 'Rumah sakit ternama di Batam seperti RS Awal Bros & RS Budi Kemuliaan didukung dokter spesialis berpengalaman dan peralatan diagnostik mutakhir.' }}
              </p>
            </div>

            <div class="bg-white p-7 rounded-3xl border border-emerald-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all">
              <div class="w-13 h-13 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold mb-5 shadow-sm">
                💰
              </div>
              <h3 class="text-lg font-bold text-teal-ink mb-2">{{ t?.feat_2_title || 'Transparansi Biaya SGD / IDR' }}</h3>
              <p class="text-xs text-slate-600 leading-relaxed">
                {{ t?.feat_2_desc || 'Dapatkan perbandingan harga langsung dengan estimasi biaya di Singapura tanpa biaya tersembunyi berkat konverter kurs real-time.' }}
              </p>
            </div>

            <div class="bg-white p-7 rounded-3xl border border-amber-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all">
              <div class="w-13 h-13 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-3xl font-bold mb-5 shadow-sm">
                🚕
              </div>
              <h3 class="text-lg font-bold text-teal-ink mb-2">{{ t?.feat_3_title || 'Penjemputan VIP di Pelabuhan' }}</h3>
              <p class="text-xs text-slate-600 leading-relaxed">
                {{ t?.feat_3_desc || 'Layanan antar-jemput privat dari pelabuhan feri (Harbour Bay, Batam Centre, Sekupang, Nongsa) langsung ke lokasi klinik atau resort.' }}
              </p>
            </div>
          </div>
        </div>
      </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
        <div class="flex items-center space-x-2">
          <span class="font-extrabold text-teal-ink text-sm">BatamPulse</span>
          <span>© 2026 — Platform Lomba Turis Development (SG ⇄ Batam)</span>
        </div>
        <div class="flex items-center space-x-4">
          <span class="text-emerald-700 font-mono font-bold bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Vue 3 • Laravel 11 • PostgreSQL PostGIS</span>
        </div>
      </div>
    </footer>

    <!-- Modals -->
    <PriceCheckModal 
      :show="showPriceCheckModal"
      :exchange-rate="exchangeRate"
      :default-tab="priceCheckTab"
      @close="closePriceCheck"
    />

    <AiItineraryModal 
      :show="showAiModal" 
      @close="closeAiItinerary" 
      @book-all="openBookingModal(null)"
    />

    <FerryGuideModal 
      :show="showFerryModal" 
      @close="closeFerryGuide" 
    />

    <BookingModal 
      :show="showBookingModal" 
      :selected-place="selectedBookingPlace"
      :currency="currency"
      :exchange-rate="exchangeRate"
      @close="showBookingModal = false" 
    />

  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { translations } from './locales/translations.js'
import Navbar from './components/Navbar.vue'
import HeroSection from './components/HeroSection.vue'
import TrendingCarousel from './components/TrendingCarousel.vue'
import MedicalListings from './components/MedicalListings.vue'
import MapView from './components/MapView.vue'
import PriceCheckModal from './components/PriceCheckModal.vue'
import AiItineraryModal from './components/AiItineraryModal.vue'
import FerryGuideModal from './components/FerryGuideModal.vue'
import BookingModal from './components/BookingModal.vue'
import TestimonialsSection from './components/TestimonialsSection.vue'

// Language State
const lang = ref(localStorage.getItem('bp_lang') || 'id')
const t = computed(() => translations[lang.value] || translations.id)
const setLang = (newLang) => {
  lang.value = newLang
  localStorage.setItem('bp_lang', newLang)
}

// State
const currency = ref('SGD')
const exchangeRate = ref(13920) // Current 2026 baseline rate
const activeNav = ref('home')
const selectedCategory = ref('all')
const selectedTerminal = ref('all')
const selectedCountry = ref('all')
const showPriceCheckModal = ref(false)
const priceCheckTab = ref('CALCULATOR')
const showAiModal = ref(false)
const showFerryModal = ref(false)
const showBookingModal = ref(false)
const selectedBookingPlace = ref(null)
const selectedMapPlace = ref(null)

// Realistic Data for SG ⇄ Batam Cross-Border Tourism Hub (49 destinations)
const places = ref([
  // ==========================================
  // 🏥 RUMAH SAKIT & PUSAT MEDIS BATAM (INDONESIA)
  // ==========================================
  {
    id: 1,
    name: 'RS Awal Bros Batam — Executive Health Centre',
    category: 'medical',
    categoryLabel: '🏥 RS Swasta Rujukan Utama • Baloi',
    nearestTerminal: 'Batam Centre Terminal (7 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 280,
    savingsPercent: 68,
    rating: 4.9,
    lat: 1.1278,
    lng: 104.0412,
    description: 'Pusat layanan kesehatan medis terkemuka di Batam dengan dokter spesialis lulusan luar negeri, paket EKG, MRI 1.5 Tesla, CT-Scan 128 Slice, dan konsultasi cepat.',
    image: 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 2,
    name: 'RS BP Batam (RS Otorita Batam) — Cardiovascular & Hyperbaric',
    category: 'medical',
    categoryLabel: '🏥 RS BP Batam • Pusat Jantung & Trauma',
    nearestTerminal: 'Sekupang Terminal (4 mins)',
    terminalKey: 'sekupang',
    priceSgd: 220,
    savingsPercent: 72,
    rating: 4.8,
    lat: 1.1215,
    lng: 103.9310,
    description: 'Rumah sakit pemerintah BP Batam berstandar internasional di Sekupang, pusat unggulan kateterisasi jantung (Cath Lab), ruang terapi hiperbarik oksigen, dan trauma centre 24 jam.',
    image: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 3,
    name: 'RS Budi Kemuliaan Batam — International Eye & Vision Centre',
    category: 'medical',
    categoryLabel: '👁️ Spesialis Mata, LASIK & Katarak',
    nearestTerminal: 'Batam Centre Terminal (10 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 240,
    savingsPercent: 65,
    rating: 4.8,
    lat: 1.1350,
    lng: 104.0180,
    description: 'Pusat perawatan mata modern di Batam untuk operasi katarak Phacoemulsifikasi, LASIK presisi, bedah retina, serta poliklinik spesialis penyakit dalam dan hemodialisa.',
    image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 4,
    name: 'RS Santa Elisabeth Batam Kota — Executive Diagnostic Hub',
    category: 'medical',
    categoryLabel: '🏥 RS Santa Elisabeth • Batam Centre',
    nearestTerminal: 'Batam Centre Terminal (5 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 260,
    savingsPercent: 66,
    rating: 4.8,
    lat: 1.1240,
    lng: 104.0510,
    description: 'Rumah sakit swasta modern di kawasan Batam Centre dengan layanan Medical Checkup eksekutif, rawat inap VIP berstandar hotel, pusat kebidanan, dan laboratorium patologi terpadu.',
    image: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 5,
    name: 'RS Santa Elisabeth Blok II Nagoya',
    category: 'medical',
    categoryLabel: '🏥 RS Santa Elisabeth • Nagoya Downtown',
    nearestTerminal: 'Harbour Bay Terminal (4 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 210,
    savingsPercent: 70,
    rating: 4.7,
    lat: 1.1420,
    lng: 104.0125,
    description: 'Rumah sakit terpercaya di pusat kawasan bisnis Nagoya Lubuk Baja. Akses sangat cepat dari Pelabuhan Feri Harbour Bay untuk pemeriksaan medis darurat dan rawat jalan.',
    image: 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 6,
    name: 'RS Harapan Bunda Batam (RSHB) — Orthopaedic & Surgery',
    category: 'medical',
    categoryLabel: '🏥 RS Harapan Bunda • Bedah & Ortopedi',
    nearestTerminal: 'Harbour Bay Terminal (6 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 230,
    savingsPercent: 68,
    rating: 4.8,
    lat: 1.1390,
    lng: 104.0195,
    description: 'Rumah sakit rujukan ternama di kawasan Seraya dengan keunggulan bedah ortopedi tulang & sendi, poliklinik saraf, bedah digestif, dan instalasi gawat darurat 24 jam.',
    image: 'https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 7,
    name: 'RSUD Embung Fatimah Batam — Regional Tertiary Referral',
    category: 'medical',
    categoryLabel: '🏥 RSUD Tipe B Pemko Batam',
    nearestTerminal: 'Sekupang Terminal (15 mins)',
    terminalKey: 'sekupang',
    priceSgd: 150,
    savingsPercent: 78,
    rating: 4.6,
    lat: 1.0550,
    lng: 103.9850,
    description: 'Rumah sakit umum daerah tipe B terbesar milik Pemko Batam di Batu Aji dengan 350+ bed, layanan spesialis lengkap, pusat hemodialisa, dan ruang isolasi bertekanan negatif.',
    image: 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 8,
    name: 'RS Graha Hermine Batam — Endoscopy & General Surgery',
    category: 'medical',
    categoryLabel: '🏥 RS Graha Hermine • Batu Aji',
    nearestTerminal: 'Sekupang Terminal (14 mins)',
    terminalKey: 'sekupang',
    priceSgd: 180,
    savingsPercent: 72,
    rating: 4.7,
    lat: 1.0520,
    lng: 103.9920,
    description: 'Rumah sakit swasta modern melayani Medical Checkup, endoskopi saluran cerna, bedah laparoskopi minimal invasif, poliklinik anak, dan farmasi 24 jam.',
    image: 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 9,
    name: 'RS Soedarsono Darmosoewito (RS Kabil Nongsa)',
    category: 'medical',
    categoryLabel: '🏥 RS Kabil • Kawasan Industri & Nongsa',
    nearestTerminal: 'Nongsa Pura Terminal (12 mins)',
    terminalKey: 'nongsa',
    priceSgd: 170,
    savingsPercent: 72,
    rating: 4.7,
    lat: 1.1180,
    lng: 104.1350,
    description: 'Rumah sakit rujukan terdekat kawasan timur Batam & Nongsa dengan layanan trauma kecelakaan kerja, instalasi radiologi, poliklinik dokter spesialis, dan kamar VIP.',
    image: 'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 10,
    name: 'RS Bhayangkara Batam — Polda Kepri Medical Center',
    category: 'medical',
    categoryLabel: '🏥 RS Bhayangkara • Dekat Bandara & Nongsa',
    nearestTerminal: 'Nongsa Pura Terminal (15 mins)',
    terminalKey: 'nongsa',
    priceSgd: 160,
    savingsPercent: 74,
    rating: 4.7,
    lat: 1.1550,
    lng: 104.0950,
    description: 'Rumah sakit kepolisian modern di Batu Besar Nongsa, melayani masyarakat umum dan wisatawan dengan fasilitas IGD 24 jam, ICU terpadu, dan dokter spesialis bedah.',
    image: 'https://images.unsplash.com/photo-1587745416684-47953f16f02f?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 11,
    name: 'Nagoya Dental Wellness Centre',
    category: 'dental',
    categoryLabel: '🦷 Perawatan & Implan Gigi • Nagoya',
    nearestTerminal: 'Harbour Bay Terminal (5 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 180,
    savingsPercent: 72,
    rating: 4.8,
    lat: 1.1445,
    lng: 104.0112,
    description: 'Spesialis pembersihan karang gigi, veneer estetik porcelain, mahkota gigi (crown), dan pemutihan gigi laser dengan standar kebersihan tertinggi.',
    image: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 12,
    name: 'Batam International Dental & Orthodontic Clinic',
    category: 'dental',
    categoryLabel: '🦷 Klinik Gigi & Behel Transparan',
    nearestTerminal: 'Batam Centre Terminal (6 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 160,
    savingsPercent: 75,
    rating: 4.9,
    lat: 1.1310,
    lng: 104.0450,
    description: 'Klinik ortodonti dan gigi estetik terpadu di Batam Centre: perawatan Invisalign, bleaching gigi US standard, implan titanium, dan dental digital X-Ray panoramik.',
    image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 13,
    name: 'Aesthetic Skin & Laser Clinic Nagoya',
    category: 'medical',
    categoryLabel: '✨ Klinik Estetika & Anti-Aging',
    nearestTerminal: 'Harbour Bay Terminal (6 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 120,
    savingsPercent: 65,
    rating: 4.8,
    lat: 1.1410,
    lng: 104.0150,
    description: 'Perawatan wajah Botox, Filler, Laser Pico, HIFU Facelift, dan Anti-Aging oleh dokter dermatologi bersertifikasi internasional.',
    image: 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=800&q=80'
  },

  // ==========================================
  // 🇸🇬 RUMAH SAKIT UTAMA SINGAPURA (SINGAPORE)
  // ==========================================
  {
    id: 14,
    name: 'Mount Elizabeth Hospital Orchard (Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 SG Tertiary Hospital • Orchard Road',
    nearestTerminal: 'HarbourFront Terminal SG (15 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 880,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3048,
    lng: 103.8354,
    description: 'Rumah sakit swasta paling terkemuka di Asia Tenggara untuk kardiologi lanjutan, transplantasi organ, onkologi, bedah saraf, dan kedokteran presisi.',
    image: 'https://images.unsplash.com/photo-1504813184591-01572f98c85f?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 15,
    name: 'Mount Elizabeth Novena Hospital (Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 SG Novena Medical Hub • Luxury Hospital',
    nearestTerminal: 'HarbourFront Terminal SG (18 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 920,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3210,
    lng: 103.8440,
    description: 'Rumah sakit swasta ultra-modern di Novena dengan fasilitas kamar single privat mewah, bedah robotik Da Vinci Xi, dan 250+ dokter spesialis internasional.',
    image: 'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 16,
    name: 'Gleneagles Hospital (Napier / Tanglin, Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 SG Gleneagles • Gastroenterology & Liver',
    nearestTerminal: 'HarbourFront Terminal SG (12 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 850,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3075,
    lng: 103.8190,
    description: 'Rumah sakit swasta prestisius dekat Botanic Gardens Singapura, pusat rujukan transplantasi hati, bedah digestif, ginekologi, dan pediatri.',
    image: 'https://images.unsplash.com/photo-1533042789716-e9a9c97cf4ee?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 17,
    name: 'Singapore General Hospital (SGH) & Outram Campus',
    category: 'medical',
    categoryLabel: '🇸🇬 World Top Hospital • Outram Park',
    nearestTerminal: 'HarbourFront Terminal SG (8 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 680,
    savingsPercent: 0,
    rating: 5.0,
    lat: 1.2790,
    lng: 103.8340,
    description: 'Rumah sakit tersier akademik terbesar dan tertua di Singapura (dinobatkan Newsweek sebagai salah satu RS terbaik di dunia), mencakup National Heart Centre dan Cancer Centre.',
    image: 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 18,
    name: 'National University Hospital (NUH, Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 SG Academic Hospital • Kent Ridge',
    nearestTerminal: 'HarbourFront Terminal SG (12 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 650,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.2938,
    lng: 103.7830,
    description: 'Pusat medis universitas terkemuka Singapura dengan National University Cancer Institute (NCIS), National University Heart Centre (NUCS), dan pusat transplantasi ginjal & hati.',
    image: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 19,
    name: 'Raffles Hospital (Bugis Downtown, Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 Raffles Medical Group • Bugis',
    nearestTerminal: 'HarbourFront Terminal SG (14 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 790,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3008,
    lng: 103.8582,
    description: 'Rumah sakit swasta terpadu berstandar internasional di pusat kota Bugis Singapura, melayani pasien mancanegara dengan 35+ pusat spesialisasi kedokteran.',
    image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 20,
    name: 'Tan Tock Seng Hospital (TTSH) & NCID (Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 SG Novena HealthCity • Trauma & NCID',
    nearestTerminal: 'HarbourFront Terminal SG (18 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 620,
    savingsPercent: 0,
    rating: 4.8,
    lat: 1.3214,
    lng: 103.8458,
    description: 'Salah satu rumah sakit rujukan tersier publik terbesar Singapura dengan pusat trauma regional, spesialis geriatri, rehabilitasi stroke, dan National Centre for Infectious Diseases.',
    image: 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 21,
    name: 'Parkway East Hospital (Joo Chiat / East Coast SG)',
    category: 'medical',
    categoryLabel: '🇸🇬 SG East Coast Private Hospital',
    nearestTerminal: 'Tanah Merah Terminal SG (10 mins)',
    terminalKey: 'tanah-merah-sg',
    priceSgd: 720,
    savingsPercent: 0,
    rating: 4.8,
    lat: 1.3145,
    lng: 103.9060,
    description: 'Rumah sakit swasta komprehensif di kawasan timur Singapura (dekat Changi) dengan keunggulan bedah THT, ortopedi, kebidanan, pediatri, dan poliklinik 24 jam.',
    image: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 22,
    name: 'KK Women’s and Children’s Hospital (KKH, Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 Pusat Spesialis Ibu & Anak Singapura',
    nearestTerminal: 'HarbourFront Terminal SG (15 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 580,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3105,
    lng: 103.8470,
    description: 'Rumah sakit rujukan tersier khusus wanita, kebidanan, fertilitas IVF, dan kesehatan anak terbesar di Singapura dengan tim dokter sub-spesialis terkemuka.',
    image: 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 23,
    name: 'Farrer Park Hospital & Medical Centre (Singapore)',
    category: 'medical',
    categoryLabel: '🇸🇬 RS Terintegrasi Hotel Bintang 5',
    nearestTerminal: 'HarbourFront Terminal SG (16 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 820,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3120,
    lng: 103.8540,
    description: 'Konsep inovatif rumah sakit modern terintegrasi dengan hotel One Farrer, pusat onkologi canggih, bedah kardiologi, dan suites pemulihan berstandar hotel mewah.',
    image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80'
  },

  // ==========================================
  // 🏖️ WISATA, PANTAI, KAFE HITS & SEAFOOD
  // ==========================================
  {
    id: 24,
    name: 'Mula Cafe & Eatery Batam Centre',
    category: 'tourism',
    categoryLabel: '☕ Kafe Hits Viral & Aesthetic Brunch',
    nearestTerminal: 'Batam Centre Terminal (6 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 14,
    savingsPercent: 65,
    rating: 4.9,
    lat: 1.1325,
    lng: 104.0430,
    description: 'Kafe hits viral bernuansa modern minimalis estetik di Batam Centre. Menyajikan specialty coffee, artisan pasta, croffle lumer, dan signature mocktail.',
    image: 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 25,
    name: 'Pantai Elyora Barelang (Jembatan 6 Batam)',
    category: 'tourism',
    categoryLabel: '🏖️ Surga Pantai Pasir Putih & Laut Toska',
    nearestTerminal: 'Batam Centre Terminal (35 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 15,
    savingsPercent: 80,
    rating: 4.9,
    lat: 0.8120,
    lng: 104.1890,
    description: 'Pantai pasir putih terindah dan terjernih di Batam (Jembatan 6 Barelang) dengan gradasi air laut toska, pohon mangrove estetik, dan spot foto instagramable.',
    image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 26,
    name: 'Malaya Cafe & Kopitiam Toast Nagoya',
    category: 'tourism',
    categoryLabel: '☕ Kopitiam Hits & Authentic Kaya Toast',
    nearestTerminal: 'Harbour Bay Terminal (5 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 8,
    savingsPercent: 70,
    rating: 4.8,
    lat: 1.1430,
    lng: 104.0145,
    description: 'Kopitiam legendaris favorit warga lokal dan turis SG di Nagoya. Terkenal dengan Roti Bakar Kaya Butter lumer, Kopi O mantap, dan Laksa Seafood Batam.',
    image: 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 27,
    name: 'Restoran Seafood Kelong Barelang 168',
    category: 'tourism',
    categoryLabel: '🦀 Wisata Kuliner Seafood di Laut',
    nearestTerminal: 'Batam Centre Terminal (20 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 35,
    savingsPercent: 65,
    rating: 4.8,
    lat: 1.0020,
    lng: 104.0410,
    description: 'Wisata santapan laut segar di atas kelong tradisional Jembatan Barelang: kepiting saus lada hitam, gonggong khas Kepri, dan lobster hidup.',
    image: 'https://images.unsplash.com/photo-1559742811-822873691df8?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 28,
    name: 'Harbour Bay Seafood Waterfront Restaurant',
    category: 'tourism',
    categoryLabel: '🦞 Live Seafood Tepi Dermaga Feri',
    nearestTerminal: 'Harbour Bay Terminal (2 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 40,
    savingsPercent: 60,
    rating: 4.8,
    lat: 1.1565,
    lng: 104.0055,
    description: 'Restoran live seafood tepi laut tepat di samping terminal feri Harbour Bay. Pemandangan kapal feri dan gemerlap lampu malam Singapura.',
    image: 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 29,
    name: 'Pantai Viovio & Sunset Beach Club Barelang',
    category: 'tourism',
    categoryLabel: '🏖️ Wisata Pantai & Sunset Hits',
    nearestTerminal: 'Batam Centre Terminal (25 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 18,
    savingsPercent: 75,
    rating: 4.9,
    lat: 0.9320,
    lng: 104.1480,
    description: 'Destinasi pantai pasir putih hits di Jembatan 5 Barelang dengan ayunan laut estetik, gazebo tebing sunset, dan pertunjukan acoustic live.',
    image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 30,
    name: 'Nongsa Beach & Palm Bay Watersports',
    category: 'tourism',
    categoryLabel: '🌊 Wisata Pantai & Watersports',
    nearestTerminal: 'Nongsa Pura Terminal (6 mins)',
    terminalKey: 'nongsa',
    priceSgd: 30,
    savingsPercent: 70,
    rating: 4.8,
    lat: 1.1890,
    lng: 104.1050,
    description: 'Pantai eksklusif dengan pasir putih landai, wahana Jet Ski, Banana Boat, Wakeboarding, dan pemandangan gedung pencakar langit Singapura.',
    image: 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 31,
    name: 'Anchor Cafe & Roastery Batam Centre',
    category: 'tourism',
    categoryLabel: '☕ Kafe Hits & Specialty Roastery',
    nearestTerminal: 'Batam Centre Terminal (8 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 12,
    savingsPercent: 65,
    rating: 4.9,
    lat: 1.1290,
    lng: 104.0380,
    description: 'Kafe roastery kopi artisan terpopuler di Batam dengan biji kopi pilihan Indonesia, American Southern breakfast, freshly baked pies, dan suasana estetik.',
    image: 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 32,
    name: 'Level Up Floating Bar & Sunset Lounge Harbour Bay',
    category: 'tourism',
    categoryLabel: '🍸 Kafe & Lounge Terapung Hits',
    nearestTerminal: 'Harbour Bay Terminal (3 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 22,
    savingsPercent: 68,
    rating: 4.8,
    lat: 1.1570,
    lng: 104.0048,
    description: 'Spot nongkrong terapung tepi laut paling hits di Harbour Bay Downtown dengan mocktail/cocktail spesial, live DJ sunset, dan suasana romantis.',
    image: 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 33,
    name: 'One Batam Mall & Sky Garden Promenade',
    category: 'tourism',
    categoryLabel: '🛍️ Lifestyle Hub & Rooftop Garden',
    nearestTerminal: 'Batam Centre Terminal (5 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 20,
    savingsPercent: 60,
    rating: 4.8,
    lat: 1.1298,
    lng: 104.0485,
    description: 'Pusat perbelanjaan dan rekreasi modern terbesar di Batam dengan area outdoor Sky Garden, aneka kafe hits, bioskop IMAX, dan spot belanja internasional.',
    image: 'https://images.unsplash.com/photo-1519567241046-7f570eee3ce6?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 34,
    name: 'De’Sands Cafe & Bar Santorini Style Batam',
    category: 'tourism',
    categoryLabel: '🏛️ Kafe Hits Nuansa Santorini Yunani',
    nearestTerminal: 'Batam Centre Terminal (10 mins)',
    terminalKey: 'batam-centre',
    priceSgd: 15,
    savingsPercent: 70,
    rating: 4.7,
    lat: 1.1380,
    lng: 104.0320,
    description: 'Kafe bergaya arsitektur kubah biru putih Santorini Yunani yang super instagramable dengan rooftop sunset view dan aneka dessert fusion.',
    image: 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 35,
    name: 'Coach Play Singapore Shophouse & Cafe (Keong Saik SG)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Viral Pastel Shophouse Cafe',
    nearestTerminal: 'HarbourFront Terminal SG (10 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 24,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.2805,
    lng: 103.8415,
    description: 'Konsep shophouse 3 lantai pertama di dunia dari Coach dengan kafe bernuansa retro New York, signature American desserts, milkshake, dan spot foto viral.',
    image: 'https://images.unsplash.com/photo-1521017432531-fbd92d768814?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 36,
    name: 'PS.Cafe at Harding Road (Dempsey Hill Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Iconic Lush Greenery Cafe',
    nearestTerminal: 'HarbourFront Terminal SG (14 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 36,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3032,
    lng: 103.8080,
    description: 'Kafe paling legendaris di Dempsey Hill tersembunyi di tengah hutan tropis rindang dengan dinding kaca raksasa, Truffle Shoestring Fries ikonik, dan kue sticky date pudding.',
    image: 'https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 37,
    name: 'Chye Seng Huat Hardware Cafe (Jalan Besar SG)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Artisan Coffee Roastery & Bar',
    nearestTerminal: 'HarbourFront Terminal SG (15 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 18,
    savingsPercent: 0,
    rating: 4.8,
    lat: 1.3118,
    lng: 103.8601,
    description: 'Kafe spesialis artisan coffee berkonsep bekas gedung bengkel perkakas hardware dengan 360° circular coffee bar dan outdoor courtyard yang artistik.',
    image: 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 38,
    name: 'Merlion Park & Marina Bay Waterfront (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG World Landmark & Skyline Walk',
    nearestTerminal: 'HarbourFront Terminal SG (10 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 15,
    savingsPercent: 0,
    rating: 5.0,
    lat: 1.2868,
    lng: 103.8545,
    description: 'Landmark nomor 1 Singapura dengan patung Merlion ikonik menghadap Marina Bay, gemerlap lampu malam Spectra Light & Water Show, dan waterfront cafe promenade.',
    image: 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 39,
    name: 'Sentosa Skyline Luge & Cable Car Experience (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Adventure Rides & Cable Car',
    nearestTerminal: 'HarbourFront Terminal SG (5 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 35,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.2540,
    lng: 103.8180,
    description: 'Wahana meluncur seru 4 lintasan sirkuit gravitasi menuruni bukit tropis Sentosa serta pemandangan spektakuler Selat Singapura dari Singapore Cable Car.',
    image: 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 40,
    name: 'Marina Bay Sands SkyPark & Observation Lounge (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG SkyPark 360° & Rooftop Hits',
    nearestTerminal: 'HarbourFront Terminal SG (10 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 38,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.2834,
    lng: 103.8607,
    description: 'Destinasi wisata ikonik dunia di lantai 57 Marina Bay Sands dengan panorama cakrawala Singapura 360 derajat dan spot sunset spektakuler.',
    image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 41,
    name: 'Tanjong Beach Club & Siloso Beach Sentosa (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Sentosa Beach Club & Daybed',
    nearestTerminal: 'HarbourFront Terminal SG (8 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 65,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.2460,
    lng: 103.8260,
    description: 'Klub pantai tropis terpopuler di Pulau Sentosa Singapura dengan kolam renang infinity tepi pantai, daybed mewah, burger artisan, dan sunset cocktail.',
    image: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 42,
    name: 'Haji Lane & Arab Street Artisan Coffee Spots (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Trendsetter Indie Cafe & Murals',
    nearestTerminal: 'HarbourFront Terminal SG (15 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 16,
    savingsPercent: 0,
    rating: 4.8,
    lat: 1.3005,
    lng: 103.8590,
    description: 'Gang seni paling trendi di Singapura penuh mural warna-warni, kafe spesialis cold brew, boutique unik, dan live music malam hari.',
    image: 'https://images.unsplash.com/photo-1534430480872-3498386e7856?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 43,
    name: 'Jewel Changi Rain Vortex & Canopy Park (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG World Iconic Indoor Waterfall',
    nearestTerminal: 'Tanah Merah Terminal SG (12 mins)',
    terminalKey: 'tanah-merah-sg',
    priceSgd: 25,
    savingsPercent: 0,
    rating: 5.0,
    lat: 1.3602,
    lng: 103.9898,
    description: 'Air terjun indoor tertinggi di dunia (HSBC Rain Vortex setinggi 40m) dikelilingi hutan kanopi tropis Shiseido Forest Valley.',
    image: 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 44,
    name: 'Atlas Bar & Grand Lounge Bugis (Singapore)',
    category: 'tourism',
    categoryLabel: '🇸🇬 SG Art Deco World Top 50 Lounge',
    nearestTerminal: 'HarbourFront Terminal SG (15 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 48,
    savingsPercent: 0,
    rating: 4.9,
    lat: 1.3001,
    lng: 103.8576,
    description: 'Lounge bergaya Art Deco Eropa di gedung Parkview Square (Gotham Building) dengan koleksi gin tower termegah di Asia dan paket afternoon tea mewah.',
    image: 'https://images.unsplash.com/photo-1572116469696-31de0f17cc34?auto=format&fit=crop&w=800&q=80'
  },

  // ==========================================
  // 💆‍♀️ WELLNESS, SPA & ⛳ GOLF RESORTS
  // ==========================================
  {
    id: 45,
    name: 'Royal Heritage Spa & Wellness Resort',
    category: 'spa',
    categoryLabel: '💆‍♀️ Holistic Spa & Aromatherapy',
    nearestTerminal: 'Harbour Bay Terminal (8 mins)',
    terminalKey: 'harbour-bay',
    priceSgd: 45,
    savingsPercent: 70,
    rating: 4.9,
    lat: 1.1512,
    lng: 104.0090,
    description: 'Pijat tradisional Nusantara, scrub rempah herbal, dan terapi pijat batu hangat selama 120 menit untuk relaksasi tubuh pasca-rutinitas kerja.',
    image: 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 46,
    name: 'Batam View Oceanfront Beach Spa Nongsa',
    category: 'spa',
    categoryLabel: '🌴 Oceanfront Sea Spa & Resort',
    nearestTerminal: 'Nongsa Pura Terminal (8 mins)',
    terminalKey: 'nongsa',
    priceSgd: 55,
    savingsPercent: 68,
    rating: 4.9,
    lat: 1.1880,
    lng: 104.1150,
    description: 'Terapi spa relaksasi tepi laut dengan pemandangan Selat Singapura, scrub kelapa murni, mandi rempah, dan privat infinity pool.',
    image: 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 47,
    name: 'Palm Springs Golf & Beach Resort Nongsa',
    category: 'golf',
    categoryLabel: '⛳ 18-Hole Championship Golf',
    nearestTerminal: 'Nongsa Pura Terminal (10 mins)',
    terminalKey: 'nongsa',
    priceSgd: 130,
    savingsPercent: 60,
    rating: 4.9,
    lat: 1.1920,
    lng: 104.1080,
    description: 'Lapangan golf bertaraf internasional dengan pemandangan Selat Singapura, lengkap dengan caddie profesional dan fasilitas clubhouse mewah.',
    image: 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 48,
    name: 'Southlinks Country Club & Resort Batam',
    category: 'golf',
    categoryLabel: '⛳ 18-Hole Championship Golf • Sekupang',
    nearestTerminal: 'Sekupang Terminal (12 mins)',
    terminalKey: 'sekupang',
    priceSgd: 110,
    savingsPercent: 62,
    rating: 4.8,
    lat: 1.1080,
    lng: 103.9850,
    description: 'Lapangan golf perbukitan hijau dengan pemandangan danau alami, night golfing, driving range, dan vila resort keluarga.',
    image: 'https://images.unsplash.com/photo-1592919505780-303950717480?auto=format&fit=crop&w=800&q=80'
  },
  {
    id: 49,
    name: 'Sentosa Golf Club & Serapong Championship Course (Singapore)',
    category: 'golf',
    categoryLabel: '🇸🇬 SG World Top 100 Golf • Sentosa',
    nearestTerminal: 'HarbourFront Terminal SG (5 mins)',
    terminalKey: 'harbourfront-sg',
    priceSgd: 420,
    savingsPercent: 0,
    rating: 5.0,
    lat: 1.2480,
    lng: 103.8290,
    description: 'Salah satu lapangan golf terbaik di dunia tuan rumah SMBC Singapore Open dengan pemandangan megah waterfront & skyline Singapura.',
    image: 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&w=800&q=80'
  }
])

// Actions
const toggleCurrency = () => {
  currency.value = currency.value === 'SGD' ? 'IDR' : 'SGD'
}

const openPriceCheck = (tab = 'CALCULATOR') => {
  activeNav.value = 'price-check'
  priceCheckTab.value = tab
  showPriceCheckModal.value = true
}

const closePriceCheck = () => {
  showPriceCheckModal.value = false
  if (activeNav.value === 'price-check') activeNav.value = 'home'
}

const openFerryGuide = () => {
  activeNav.value = 'ferry'
  showFerryModal.value = true
}

const closeFerryGuide = () => {
  showFerryModal.value = false
  if (activeNav.value === 'ferry') activeNav.value = 'home'
}

const openAiItinerary = () => {
  activeNav.value = 'ai'
  showAiModal.value = true
}

const closeAiItinerary = () => {
  showAiModal.value = false
  if (activeNav.value === 'ai') activeNav.value = 'home'
}

const handleNav = (target) => {
  activeNav.value = target
  selectedCountry.value = 'all'
  selectedTerminal.value = 'all'
  if (target === 'medical') {
    selectedCategory.value = 'medical'
    scrollToMedical()
  } else if (target === 'tourism') {
    selectedCategory.value = 'tourism'
    scrollToMedical()
  } else if (target === 'resorts') {
    selectedCategory.value = 'golf'
    scrollToMedical()
  } else if (target === 'reviews') {
    const el = document.getElementById('testimonials-section')
    if (el) el.scrollIntoView({ behavior: 'smooth' })
  } else {
    selectedCategory.value = 'all'
    activeNav.value = 'home'
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

const scrollToMedical = () => {
  const el = document.getElementById('listings-section')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

const handleSelectMap = (place) => {
  selectedMapPlace.value = place
  const el = document.getElementById('map-section')
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

const openBookingModal = (place) => {
  selectedBookingPlace.value = place
  showBookingModal.value = true
}

// Real-Time Exchange Rate Fetcher
let rateInterval = null

const fetchLiveExchangeRate = async () => {
  try {
    const res = await fetch('https://open.er-api.com/v6/latest/SGD')
    if (res.ok) {
      const data = await res.json()
      if (data && data.rates && data.rates.IDR) {
        exchangeRate.value = Math.round(data.rates.IDR)
        return
      }
    }
  } catch (err) {
    console.warn('Real-time rate API fetch note:', err)
  }

  // Fallback to backend API
  try {
    const backendRes = await fetch('/api/exchange-rate')
    if (backendRes.ok) {
      const bData = await backendRes.json()
      if (bData && bData.rate) {
        exchangeRate.value = Math.round(bData.rate)
      }
    }
  } catch (err) {
    // Ignore fallback errors
  }
}

const fetchPlacesFromBackend = async () => {
  try {
    const res = await fetch('/api/places')
    if (res.ok) {
      const result = await res.json()
      if (result && result.data && result.data.length > 0) {
        const apiPlaces = result.data.map(item => ({
          id: item.id,
          name: item.name,
          category: item.category?.slug || 'medical',
          categoryLabel: item.category ? `🏥 ${item.category.name}` : '🩺 Medical & Tourism',
          nearestTerminal: item.ferry_terminal ? `${item.ferry_terminal.name}` : 'Batam Ferry Terminal',
          terminalKey: item.ferry_terminal?.slug || 'batam-centre',
          priceSgd: item.price_sgd || 100,
          savingsPercent: item.savings_percent || 50,
          rating: item.rating || 4.8,
          lat: item.latitude,
          lng: item.longitude,
          description: item.description,
          image: item.image_url || 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=600&q=80'
        }))

        const existingIds = new Set(apiPlaces.map(p => p.id))
        const remainingFallback = places.value.filter(p => !existingIds.has(p.id))
        places.value = [...apiPlaces, ...remainingFallback]
      }
    }
  } catch (err) {
    console.warn('Backend places fetch note:', err)
  }
}

onMounted(() => {
  fetchPlacesFromBackend()
  fetchLiveExchangeRate()
  rateInterval = setInterval(fetchLiveExchangeRate, 60000)
})

onUnmounted(() => {
  if (rateInterval) clearInterval(rateInterval)
})
</script>
