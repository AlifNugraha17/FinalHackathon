<template>
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b-2 border-slate-200 shadow-sm">
    <!-- Top Micro Live Status Bar (Single Line) -->
    <div class="bg-gradient-to-r from-sky-800 via-teal-800 to-emerald-800 text-white py-1 px-4 sm:px-6 text-xs font-medium">
      <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 text-[11px] whitespace-nowrap">
        <div class="flex items-center gap-3 overflow-x-auto no-scrollbar">
          <span class="inline-flex items-center gap-1.5 bg-emerald-400/20 px-2 py-0.5 rounded-full text-emerald-100 border border-emerald-400/30 font-mono">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
            <span>Batam Centre: <strong>12m</strong></span>
          </span>
          <span class="text-sky-300 hidden sm:inline">•</span>
          <span class="inline-flex items-center gap-1.5 bg-amber-400/20 px-2 py-0.5 rounded-full text-amber-100 border border-amber-400/30 font-mono">
            <span>HarbourFront: <strong>28m</strong></span>
          </span>
          <span class="text-sky-300 hidden md:inline">•</span>
          <span class="text-sky-100 hidden md:inline">
            Feri Transit: <strong class="text-emerald-300">45 Menit</strong>
          </span>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <button 
            @click="$emit('open-price-check', 'CALCULATOR')" 
            class="text-sky-100 hover:text-white transition-colors cursor-pointer flex items-center gap-1 font-bold"
          >
            <span>{{ t?.rate_label || 'Kurs Real:' }}</span>
            <strong class="text-emerald-300 font-mono">1 SGD = Rp {{ formatNumber(exchangeRate) }}</strong>
          </button>
        </div>
      </div>
    </div>

    <!-- Main Navigation Bar (Clean, Left-Aligned, Perfectly Padded) -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
      <div class="flex items-center justify-between h-16 sm:h-18">
        
        <!-- Left Group: Brand Logo & Nav Links with Ample Spacing -->
        <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
          
          <!-- Brand Logo (Single Line, Crisp) -->
          <div 
            class="flex items-center space-x-2 cursor-pointer select-none shrink-0 group" 
            @click="$emit('nav', 'home')"
          >
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-sky-600 via-teal-600 to-emerald-600 flex items-center justify-center shadow-md text-white font-black text-lg tracking-tighter group-hover:scale-105 transition-transform">
              BP
            </div>
            <div class="flex items-center gap-1.5">
              <span class="text-xl font-black font-display tracking-tight text-slate-900 group-hover:text-teal-700 transition-colors">
                Batam<span class="text-teal-700">Pulse</span>
              </span>
              <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-sky-100 text-sky-900 border border-sky-300 shrink-0">
                SG ⇄ Batam
              </span>
            </div>
          </div>

          <!-- Navigation Links (Left-Aligned next to Logo, Single Icon, Compact) -->
          <nav class="hidden lg:flex items-center space-x-1 sm:space-x-1.5 whitespace-nowrap">
            
            <!-- Medis -->
            <a 
              @click.prevent="$emit('nav', 'medical')" 
              href="#" 
              class="px-2.5 sm:px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer"
              :class="activeNav === 'medical' 
                ? 'bg-sky-100 text-sky-950 font-black shadow-sm border-2 border-sky-400' 
                : 'text-slate-800 hover:text-slate-950 hover:bg-slate-100 font-bold border-2 border-transparent'"
            >
              <span>🩺</span>
              <span>{{ t?.nav_medical || 'Medis' }}</span>
            </a>

            <!-- Kafe & Wisata -->
            <a 
              @click.prevent="$emit('nav', 'tourism')" 
              href="#" 
              class="px-2.5 sm:px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer"
              :class="activeNav === 'tourism' 
                ? 'bg-amber-100 text-amber-950 font-black shadow-sm border-2 border-amber-400' 
                : 'text-slate-800 hover:text-slate-950 hover:bg-slate-100 font-bold border-2 border-transparent'"
            >
              <span>☕</span>
              <span>{{ t?.nav_tourism || 'Kafe & Wisata' }}</span>
            </a>

            <!-- Resort -->
            <a 
              @click.prevent="$emit('nav', 'resorts')" 
              href="#" 
              class="px-2.5 sm:px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer"
              :class="activeNav === 'resorts' 
                ? 'bg-emerald-100 text-emerald-950 font-black shadow-sm border-2 border-emerald-400' 
                : 'text-slate-800 hover:text-slate-950 hover:bg-slate-100 font-bold border-2 border-transparent'"
            >
              <span>⛳</span>
              <span>{{ t?.nav_resorts || 'Resort' }}</span>
            </a>

            <!-- Price Check -->
            <a 
              @click.prevent="$emit('open-price-check', 'CALCULATOR')" 
              href="#" 
              class="px-2.5 sm:px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer"
              :class="activeNav === 'price-check' 
                ? 'bg-sky-100 text-sky-950 font-black shadow-sm border-2 border-sky-400' 
                : 'text-slate-800 hover:text-slate-950 hover:bg-slate-100 font-bold border-2 border-transparent'"
            >
              <span>💰</span>
              <span>{{ t?.nav_pricecheck || 'Price Check' }}</span>
            </a>

            <!-- Jadwal Feri -->
            <a 
              @click.prevent="$emit('open-ferry')" 
              href="#" 
              class="px-2.5 sm:px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer"
              :class="activeNav === 'ferry' 
                ? 'bg-amber-100 text-amber-950 font-black shadow-sm border-2 border-amber-400' 
                : 'text-slate-800 hover:text-amber-950 hover:bg-amber-50 font-bold border-2 border-transparent'"
            >
              <span>🚢</span>
              <span>{{ t?.nav_ferry || 'Jadwal Feri' }}</span>
            </a>

            <!-- AI Itinerary -->
            <a 
              @click.prevent="$emit('open-ai')" 
              href="#" 
              class="px-2.5 sm:px-3 py-1.5 rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer"
              :class="activeNav === 'ai' 
                ? 'bg-purple-100 text-purple-950 font-black shadow-sm border-2 border-purple-400' 
                : 'text-slate-800 hover:text-purple-950 hover:bg-purple-50 font-bold border-2 border-transparent'"
            >
              <span>✨</span>
              <span>{{ t?.nav_ai || 'AI Itinerary' }}</span>
            </a>

          </nav>
        </div>

        <!-- Right Side: Language Switcher & Compact CTA Button -->
        <div class="flex items-center space-x-2 shrink-0 whitespace-nowrap">
          
          <!-- Language Toggle Pill (ID / EN) -->
          <div class="flex items-center bg-slate-100 p-0.5 rounded-xl border-2 border-slate-200 shadow-xs">
            <button 
              @click="$emit('set-lang', 'id')"
              :class="lang === 'id' 
                ? 'bg-sky-100 text-sky-950 font-black border-2 border-sky-400 shadow-xs' 
                : 'text-slate-700 hover:text-slate-950 font-bold border-2 border-transparent'"
              class="px-2 py-1 rounded-lg text-xs transition-all flex items-center gap-1 cursor-pointer"
              title="Bahasa Indonesia"
            >
              <span>🇮🇩</span>
              <span>ID</span>
            </button>
            <button 
              @click="$emit('set-lang', 'en')"
              :class="lang === 'en' 
                ? 'bg-sky-100 text-sky-950 font-black border-2 border-sky-400 shadow-xs' 
                : 'text-slate-700 hover:text-slate-950 font-bold border-2 border-transparent'"
              class="px-2 py-1 rounded-lg text-xs transition-all flex items-center gap-1 cursor-pointer"
              title="English"
            >
              <span>🇬🇧</span>
              <span>EN</span>
            </button>
          </div>

          <!-- Main CTA Button (Compact, No Overflow) -->
          <button 
            @click="$emit('open-booking')"
            class="inline-flex items-center justify-center gap-1.5 px-3.5 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-black text-white bg-gradient-to-r from-teal-700 via-emerald-700 to-teal-800 hover:from-teal-800 hover:to-emerald-800 transition-all shadow-md active:scale-95 border-2 border-emerald-500 cursor-pointer shrink-0"
          >
            <span>⚡</span>
            <span>{{ t?.nav_cta || 'Janji Layanan' }}</span>
          </button>

        </div>

      </div>
    </div>
  </header>
</template>

<script setup>
defineProps({
  currency: { type: String, default: 'SGD' },
  exchangeRate: { type: Number, default: 11850 },
  activeNav: { type: String, default: 'home' },
  lang: { type: String, default: 'id' },
  t: { type: Object, default: () => ({}) }
})

defineEmits(['nav', 'set-currency', 'set-lang', 'toggle-currency', 'open-ferry', 'open-ai', 'open-booking', 'open-price-check'])

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num)
}
</script>
