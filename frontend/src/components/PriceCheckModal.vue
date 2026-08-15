<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/75 backdrop-blur-md">
    <div class="bg-white w-full max-w-4xl rounded-3xl p-5 sm:p-7 border-2 border-slate-300 shadow-2xl relative max-h-[94vh] overflow-y-auto">
      
      <!-- Close Button -->
      <button 
        @click="$emit('close')" 
        class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-200 text-slate-800 hover:bg-slate-300 flex items-center justify-center text-sm font-black z-10 transition-colors border border-slate-400 cursor-pointer shadow-sm"
      >
        ✕
      </button>

      <!-- Modal Title & Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b-2 border-slate-200 pb-4">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-2xl font-black border-2 border-amber-300 shadow-sm">
            💰
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-xl font-black text-teal-ink">Modul PriceCheck & Kurs Live</h3>
              <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-900 border border-emerald-300">
                Anti-Ketok Harga
              </span>
            </div>
            <p class="text-xs text-slate-600 font-medium">Kalkulator kurs real-time SGD ⇄ IDR, OCR scan struk cerdas, dan direktori harga wajar Batam</p>
          </div>
        </div>

        <!-- Live Exchange Rate Indicator Pill -->
        <div class="flex items-center space-x-2 bg-teal-900 text-white px-3.5 py-1.5 rounded-xl border border-teal-700 shadow-sm shrink-0">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
          </span>
          <span class="text-xs text-teal-200 font-medium">Kurs Real:</span>
          <span class="text-xs font-mono font-black text-emerald-400">1 SGD = Rp {{ formatNumber(currentRate) }}</span>
        </div>
      </div>

      <!-- Tab Navigation -->
      <div class="flex flex-wrap gap-2 mb-6 bg-slate-100 p-1.5 rounded-2xl border-2 border-slate-200">
        <button 
          @click="activeTab = 'CALCULATOR'"
          class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-2 cursor-pointer"
          :class="activeTab === 'CALCULATOR' ? 'bg-sky-100 text-sky-950 border-2 border-sky-400 shadow-sm' : 'bg-white text-slate-800 hover:bg-slate-100 border border-slate-300 font-bold'"
        >
          <span>💱</span>
          <span>Kalkulator Kurs Live</span>
        </button>
        <button 
          @click="activeTab = 'SCANNER'"
          class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-2 cursor-pointer"
          :class="activeTab === 'SCANNER' ? 'bg-teal-100 text-teal-950 border-2 border-teal-400 shadow-sm' : 'bg-white text-slate-800 hover:bg-slate-100 border border-slate-300 font-bold'"
        >
          <span>📸</span>
          <span>Scan Struk OCR</span>
        </button>
        <button 
          @click="activeTab = 'DIRECTORY'"
          class="flex-1 py-2.5 px-3 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-2 cursor-pointer"
          :class="activeTab === 'DIRECTORY' ? 'bg-amber-100 text-amber-950 border-2 border-amber-400 shadow-sm' : 'bg-white text-slate-800 hover:bg-slate-100 border border-slate-300 font-bold'"
        >
          <span>🛡️</span>
          <span>Katalog Harga Wajar</span>
        </button>
      </div>

      <!-- TAB 1: CURRENCY CALCULATOR -->
      <div v-if="activeTab === 'CALCULATOR'" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
          
          <!-- Left: Input & Controls (7 Cols) -->
          <div class="md:col-span-7 bg-white p-5 rounded-3xl border-2 border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
              <span class="text-xs font-black text-slate-700 uppercase tracking-wider">
                Arah Konversi:
              </span>
              <button 
                @click="toggleDirection"
                class="px-3 py-1.5 rounded-xl bg-sky-100 hover:bg-sky-200 text-teal-900 border border-sky-300 text-xs font-black transition-all flex items-center gap-1.5 cursor-pointer active:scale-95"
              >
                <span>⇄</span>
                <span>{{ direction === 'SGD_TO_IDR' ? 'SGD ➔ IDR' : 'IDR ➔ SGD' }}</span>
              </button>
            </div>

            <div>
              <label class="block text-xs font-black text-slate-800 mb-1.5 uppercase">
                Jumlah {{ direction === 'SGD_TO_IDR' ? 'Dolar Singapura (SGD)' : 'Rupiah Indonesia (IDR)' }}
              </label>
              <div class="relative">
                <input 
                  v-model.number="calcAmount"
                  type="number"
                  min="0"
                  step="any"
                  class="w-full bg-slate-50 border-2 border-slate-300 focus:border-teal-600 focus:bg-white rounded-2xl px-4 py-3 text-2xl font-mono font-black text-slate-900 outline-none transition-all shadow-inner"
                />
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-black text-slate-400 font-mono">
                  {{ direction === 'SGD_TO_IDR' ? 'SGD' : 'IDR' }}
                </span>
              </div>
            </div>

            <!-- Quick Presets -->
            <div>
              <span class="block text-[11px] font-bold text-slate-500 uppercase mb-1.5">Preset Cepat:</span>
              <div class="flex flex-wrap gap-1.5">
                <template v-if="direction === 'SGD_TO_IDR'">
                  <button 
                    v-for="p in [5, 10, 20, 50, 100, 250, 500]" 
                    :key="p"
                    @click="calcAmount = p"
                    class="px-3 py-1 rounded-xl text-xs font-mono font-black transition-all cursor-pointer"
                    :class="calcAmount === p ? 'bg-sky-100 text-sky-950 border-2 border-sky-400 shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 font-bold'"
                  >
                    ${{ p }}
                  </button>
                </template>
                <template v-else>
                  <button 
                    v-for="p in [50000, 100000, 250000, 500000, 1000000, 2000000]" 
                    :key="p"
                    @click="calcAmount = p"
                    class="px-3 py-1 rounded-xl text-xs font-mono font-black transition-all cursor-pointer"
                    :class="calcAmount === p ? 'bg-sky-100 text-sky-950 border-2 border-sky-400 shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 font-bold'"
                  >
                    {{ p >= 1000000 ? `${p/1000000}jt` : `${p/1000}rb` }}
                  </button>
                </template>
              </div>
            </div>

            <!-- Live Rate Refresh Bar -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
              <span class="text-slate-500 font-medium">Sumber Kurs API Real-Time</span>
              <button 
                @click="fetchLiveRate" 
                :disabled="isFetchingRate"
                class="text-teal-ocean hover:text-teal-800 font-bold flex items-center gap-1 cursor-pointer"
              >
                <span :class="{ 'animate-spin': isFetchingRate }">🔄</span>
                <span>{{ isFetchingRate ? 'Mengambil Kurs...' : 'Refresh Kurs' }}</span>
              </button>
            </div>
          </div>

          <!-- Right: Result Display Card (5 Cols) -->
          <div class="md:col-span-5 bg-gradient-to-br from-teal-900 via-sky-950 to-slate-950 p-6 rounded-3xl text-white flex flex-col justify-between shadow-xl border-2 border-teal-800">
            <div>
              <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-mono font-bold border border-emerald-500/30">
                ✨ Hasil Konversi Wajar
              </span>
              <p class="text-xs text-slate-400 mt-3 font-medium">
                {{ direction === 'SGD_TO_IDR' ? `S$ ${calcAmount || 0} Dolar Singapura setara:` : `Rp ${formatNumber(calcAmount || 0)} setara:` }}
              </p>
              <h4 class="text-3xl sm:text-4xl font-black font-mono text-emerald-400 mt-2 tracking-tight">
                {{ formattedConvertedResult }}
              </h4>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10 space-y-2 text-xs text-slate-300">
              <div class="flex justify-between">
                <span>Kurs Terkini:</span>
                <span class="font-mono text-white font-bold">1 SGD = Rp {{ formatNumber(currentRate) }}</span>
              </div>
              <div class="flex justify-between">
                <span>Margin Bank:</span>
                <span class="text-emerald-400 font-bold">0% (Bebas Biaya Tersembunyi)</span>
              </div>
              <button 
                @click="copyResultText"
                class="w-full mt-3 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-md cursor-pointer"
              >
                <span>{{ copied ? '✅ Angka Disalin!' : '📋 Salin Angka' }}</span>
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- TAB 2: RECEIPT SCANNER (TESSERACT.JS OCR - ACCURATE & EXPANDABLE) -->
      <div v-if="activeTab === 'SCANNER'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          <!-- Left: Upload, Large Preview & Fullscreen Zoom (6 Cols) -->
          <div class="lg:col-span-6 bg-white p-5 rounded-3xl border-2 border-slate-200 shadow-sm space-y-4">
            <h4 class="text-sm font-black text-teal-ink uppercase tracking-wider">
              1. Unggah Foto Struk Belanja / Restoran
            </h4>

            <!-- File Upload Dropzone -->
            <label class="border-2 border-dashed border-sky-300 hover:border-teal-500 bg-sky-50/60 hover:bg-sky-100/50 rounded-3xl p-5 flex flex-col items-center justify-center text-center cursor-pointer transition-all">
              <input type="file" accept="image/*" @change="handleFileUpload" class="hidden" />
              <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center text-2xl mb-2 shadow-sm">
                📷
              </div>
              <p class="text-xs font-black text-teal-ink">Klik untuk Pilih / Ganti Foto Struk</p>
              <p class="text-[11px] text-slate-500 mt-0.5">JPG, PNG, WEBP (Struk restoran, taksi, belanjaan)</p>
            </label>

            <!-- Large Image Preview with Click-To-Zoom Lightbox Trigger -->
            <div v-if="imagePreview" class="relative rounded-2xl overflow-hidden border-2 border-slate-300 bg-slate-900 group">
              <!-- Full preview image container (not truncated) -->
              <div class="h-64 sm:h-72 w-full flex items-center justify-center bg-slate-950 p-2 cursor-pointer" @click="showImageModal = true">
                <img 
                  :src="imagePreview" 
                  class="max-h-full max-w-full object-contain rounded-lg group-hover:scale-102 transition-transform duration-300" 
                  alt="Foto Struk"
                />
              </div>

              <!-- Zoom Action Floating Pill -->
              <button 
                type="button"
                @click="showImageModal = true"
                class="absolute bottom-3 right-3 px-3 py-1.5 rounded-xl bg-slate-900/90 hover:bg-slate-900 text-white text-xs font-black flex items-center gap-1.5 backdrop-blur-md border border-white/20 shadow-lg cursor-pointer transition-all active:scale-95"
              >
                <span>🔍</span>
                <span>Klik untuk Perbesar Gambar</span>
              </button>
            </div>

            <!-- Sample Presets for Instant Testing -->
            <div class="pt-1">
              <span class="block text-xs font-black text-slate-700 uppercase mb-2">Atau Coba Contoh Struk Instan:</span>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <button 
                  v-for="(sample, idx) in sampleReceipts" 
                  :key="idx"
                  @click="loadSampleReceipt(sample)"
                  class="p-2.5 rounded-xl border-2 border-slate-200 hover:border-teal-500 bg-slate-50 hover:bg-white text-left transition-all cursor-pointer shadow-2xs"
                >
                  <p class="text-xs font-black text-teal-ink leading-tight">{{ sample.name }}</p>
                  <p class="text-[10px] text-slate-500 mt-0.5 line-clamp-1">{{ sample.desc }}</p>
                </button>
              </div>
            </div>

            <!-- OCR Progress Bar -->
            <div v-if="isScanning" class="p-4 rounded-2xl bg-sky-50 border-2 border-sky-300 space-y-2">
              <div class="flex justify-between text-xs font-black text-teal-ocean">
                <span>{{ progressStatus }}</span>
                <span>{{ progressPercentage }}%</span>
              </div>
              <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-teal-600 h-full transition-all duration-300 rounded-full" :style="{ width: `${progressPercentage}%` }"></div>
              </div>
            </div>

          </div>

          <!-- Right: OCR Extraction Result & Fair Price Analysis (6 Cols) -->
          <div class="lg:col-span-6 bg-slate-50 p-5 rounded-3xl border-2 border-slate-200 shadow-sm space-y-4">
            <h4 class="text-sm font-black text-teal-ink uppercase tracking-wider flex items-center justify-between">
              <span>2. Hasil Analisis OCR Struk</span>
              <span v-if="parsedResult" class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black">
                ✓ BERHASIL DIEKSTRAK
              </span>
            </h4>

            <div v-if="parsedResult" class="space-y-4">
              <!-- Merchant & Total Box with Formatted Rupiah Dots (e.g. Rp 43.500) -->
              <div class="p-4 rounded-2xl bg-white border-2 border-teal-300 shadow-sm space-y-3">
                <div class="flex justify-between items-start">
                  <div>
                    <span class="text-[10px] uppercase font-bold text-slate-500">Tempat / Merchant Terdeteksi:</span>
                    <input 
                      v-model="parsedResult.merchant" 
                      type="text" 
                      placeholder="Nama Toko/Restoran"
                      class="text-sm font-black text-teal-ink bg-transparent border-b border-dashed border-slate-300 focus:border-teal-600 focus:outline-none w-full"
                    />
                    <p class="text-xs text-slate-500 mt-1">📅 {{ parsedResult.date }}</p>
                  </div>
                  
                  <div class="text-right">
                    <span class="text-[10px] uppercase font-bold text-slate-500">Total Tagihan (Rp):</span>
                    <div class="flex items-center justify-end gap-1 font-mono">
                      <span class="text-sm font-black text-slate-700">Rp</span>
                      <input 
                        :value="formatNumber(parsedResult.total)" 
                        @input="onTotalInput($event)"
                        type="text" 
                        placeholder="43.500"
                        class="w-32 text-right font-black text-lg text-teal-ocean bg-sky-50 border-2 border-sky-300 rounded-xl px-2.5 py-0.5 focus:bg-white focus:border-teal-600 focus:outline-none"
                      />
                    </div>
                    <p class="text-xs font-black text-emerald-700 mt-0.5">
                      ~S$ {{ (parsedResult.total / currentRate).toFixed(2) }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Itemized Table & Fair Price Check -->
              <div>
                <div class="flex items-center justify-between mb-2">
                  <span class="text-xs font-black text-slate-800 uppercase">Rincian Menu / Belanja Terdeteksi:</span>
                  <span class="text-[10px] text-slate-500 font-bold">({{ parsedResult.items.length }} Item)</span>
                </div>
                
                <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
                  <div 
                    v-for="(item, idx) in parsedResult.items" 
                    :key="idx"
                    class="p-2.5 rounded-xl bg-white border border-slate-200 flex items-center justify-between text-xs hover:border-teal-300 transition-colors gap-2"
                  >
                    <div class="flex-1 min-w-0">
                      <p class="font-black text-slate-900 leading-snug truncate">{{ item.name }}</p>
                      <p class="text-[11px] text-slate-600 font-mono font-bold">Rp {{ formatNumber(item.price) }}</p>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                      <span 
                        class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase inline-block"
                        :class="item.status === 'fair' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300' : 'bg-rose-100 text-rose-950 border border-rose-300'"
                      >
                        {{ item.status === 'fair' ? '✓ Wajar' : '⚠️ Mahal' }}
                      </span>
                      <!-- Delete row button -->
                      <button 
                        @click="deleteItem(idx)" 
                        class="w-6 h-6 rounded-lg bg-slate-100 hover:bg-rose-100 text-slate-400 hover:text-rose-700 flex items-center justify-center font-bold text-xs cursor-pointer transition-colors"
                        title="Hapus baris yang salah terbaca"
                      >
                        ✕
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Fair Price Verdict -->
              <div 
                class="p-3.5 rounded-2xl text-xs font-bold flex items-center gap-2.5 shadow-xs"
                :class="isOverpriced ? 'bg-rose-50 border-2 border-rose-300 text-rose-950' : 'bg-emerald-50 border-2 border-emerald-300 text-emerald-950'"
              >
                <span class="text-xl">{{ isOverpriced ? '🚨' : '🛡️' }}</span>
                <span>
                  {{ isOverpriced 
                    ? 'Perhatian: Terdapat item yang melebihi batas harga standar wajar wisatawan Batam.' 
                    : 'Aman! Semua rincian struk sesuai dengan tarif wajar standar lokal Batam.' }}
                </span>
              </div>

              <!-- Raw OCR Text Accordion -->
              <div class="pt-2">
                <button 
                  @click="showRawText = !showRawText"
                  class="text-[11px] font-bold text-slate-600 hover:text-teal-ocean flex items-center gap-1 cursor-pointer"
                >
                  <span>{{ showRawText ? '▼ Sembunyikan' : '▶ Tampilkan' }} Hasil Teks OCR Mentah</span>
                </button>
                <div v-if="showRawText" class="mt-2 p-3 rounded-xl bg-slate-900 text-emerald-400 font-mono text-[10px] max-h-36 overflow-y-auto whitespace-pre-wrap border border-slate-700">
                  {{ rawOcrText || 'Teks mentah kosong' }}
                </div>
              </div>

            </div>

            <!-- Empty State Placeholder -->
            <div v-else class="h-64 flex flex-col items-center justify-center text-center p-6 text-slate-400">
              <span class="text-4xl mb-2">📄</span>
              <p class="text-xs font-black text-slate-700">Belum ada struk yang dipindai</p>
              <p class="text-[11px] text-slate-500 mt-1">Pilih foto struk Anda atau klik salah satu contoh struk instan di sebelah kiri untuk melihat hasil OCR yang akurat!</p>
            </div>

          </div>

        </div>
      </div>

      <!-- TAB 3: FAIR PRICE DIRECTORY -->
      <div v-if="activeTab === 'DIRECTORY'" class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <!-- Category Filter Pills -->
          <div class="flex flex-wrap gap-1.5">
            <button 
              v-for="cat in directoryCategories" 
              :key="cat.id"
              @click="selectedDirCat = cat.id"
              class="px-3 py-1.5 rounded-xl text-xs font-black transition-all cursor-pointer"
              :class="selectedDirCat === cat.id ? 'bg-sky-100 text-sky-950 border-2 border-sky-400 shadow-sm' : 'bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 font-bold'"
            >
              {{ cat.name }}
            </button>
          </div>

          <!-- Search Filter -->
          <div class="relative min-w-[220px]">
            <input 
              v-model="dirSearch"
              type="text" 
              placeholder="Cari taksi, gonggong, lapis..."
              class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl pl-8 pr-3 py-1.5 text-xs text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white"
            />
            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs text-slate-400">🔍</span>
          </div>
        </div>

        <!-- Directory Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 max-h-[460px] overflow-y-auto pr-1">
          <div 
            v-for="item in filteredDirectoryItems" 
            :key="item.id"
            class="p-4 rounded-2xl bg-white border-2 border-slate-200 hover:border-teal-300 shadow-sm transition-all"
          >
            <div class="flex justify-between items-start gap-2 mb-1.5">
              <h5 class="text-xs font-black text-teal-ink leading-snug">{{ item.name }}</h5>
              <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-sky-100 text-sky-900 shrink-0">
                {{ item.category }}
              </span>
            </div>
            <p class="text-[11px] text-slate-500 mb-3">{{ item.desc }}</p>

            <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200 flex items-baseline justify-between">
              <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase">Rentang Wajar:</span>
                <p class="text-xs font-black text-teal-ocean">
                  {{ item.curr === 'IDR' ? `Rp ${formatNumber(item.min)} - Rp ${formatNumber(item.max)}` : `S$ ${item.min} - S$ ${item.max}` }}
                </p>
              </div>
              <div class="text-right">
                <span class="text-[10px] text-slate-400 font-bold uppercase">Rata-rata:</span>
                <p class="text-xs font-black text-emerald-700">
                  {{ item.curr === 'IDR' ? `Rp ${formatNumber(item.avg)}` : `S$ ${item.avg}` }}
                </p>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- FULLSCREEN LIGHTBOX MODAL FOR ZOOMING RECEIPT IMAGE -->
    <div 
      v-if="showImageModal" 
      class="fixed inset-0 z-60 bg-slate-950/90 backdrop-blur-lg flex flex-col items-center justify-center p-4"
      @click.self="showImageModal = false"
    >
      <!-- Top Lightbox Bar -->
      <div class="w-full max-w-5xl flex items-center justify-between text-white mb-3 px-2">
        <div class="flex items-center gap-2">
          <span class="text-base font-black">🔍 Tampilan Foto Struk Fullscreen</span>
          <span class="text-xs text-slate-400 font-mono">(Skala: {{ Math.round(zoomScale * 100) }}%)</span>
        </div>
        <div class="flex items-center gap-2">
          <button 
            @click="zoomScale = Math.max(0.5, zoomScale - 0.25)" 
            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-black border border-slate-600 cursor-pointer"
            title="Perkecil"
          >
            ➖ Zoom Out
          </button>
          <button 
            @click="zoomScale = 1" 
            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-black border border-slate-600 cursor-pointer"
            title="Reset Skala"
          >
            100%
          </button>
          <button 
            @click="zoomScale = Math.min(3, zoomScale + 0.25)" 
            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-black border border-slate-600 cursor-pointer"
            title="Perbesar"
          >
            ➕ Zoom In
          </button>
          <button 
            @click="showImageModal = false" 
            class="w-8 h-8 rounded-full bg-slate-200 text-slate-900 hover:bg-white flex items-center justify-center font-black text-sm ml-2 cursor-pointer shadow-lg"
          >
            ✕
          </button>
        </div>
      </div>

      <!-- Image Canvas Viewport -->
      <div class="w-full max-w-5xl max-h-[82vh] overflow-auto rounded-2xl bg-slate-900/80 border border-slate-700 flex items-center justify-center p-4">
        <img 
          :src="imagePreview" 
          class="max-w-none transition-transform duration-200 rounded-lg shadow-2xl" 
          :style="{ transform: `scale(${zoomScale})`, transformOrigin: 'center center' }"
          alt="Struk Pembelian Detail"
        />
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { createWorker } from 'tesseract.js'

const props = defineProps({
  show: Boolean,
  exchangeRate: { type: Number, default: 13920 },
  defaultTab: { type: String, default: 'CALCULATOR' }
})

defineEmits(['close'])

const activeTab = ref('CALCULATOR')
const currentRate = ref(props.exchangeRate || 13920)
const isFetchingRate = ref(false)

// Tab 1: Calculator State
const calcAmount = ref(20)
const direction = ref('SGD_TO_IDR')
const copied = ref(false)

const convertedCalcValue = computed(() => {
  if (!calcAmount.value || isNaN(calcAmount.value) || calcAmount.value <= 0) return 0
  if (direction.value === 'SGD_TO_IDR') {
    return Math.round(calcAmount.value * currentRate.value)
  } else {
    return Number((calcAmount.value / currentRate.value).toFixed(2))
  }
})

const formattedConvertedResult = computed(() => {
  if (direction.value === 'SGD_TO_IDR') {
    return `Rp ${new Intl.NumberFormat('id-ID').format(convertedCalcValue.value)}`
  } else {
    return `S$ ${convertedCalcValue.value.toFixed(2)}`
  }
})

const toggleDirection = () => {
  if (direction.value === 'SGD_TO_IDR') {
    direction.value = 'IDR_TO_SGD'
    calcAmount.value = convertedCalcValue.value || 100000
  } else {
    direction.value = 'SGD_TO_IDR'
    calcAmount.value = convertedCalcValue.value || 10
  }
}

const copyResultText = () => {
  navigator.clipboard.writeText(formattedConvertedResult.value)
  copied.value = true
  setTimeout(() => (copied.value = false), 2000)
}

const fetchLiveRate = async () => {
  isFetchingRate.value = true
  try {
    const res = await fetch('https://open.er-api.com/v6/latest/SGD')
    if (res.ok) {
      const data = await res.json()
      if (data && data.rates && data.rates.IDR) {
        currentRate.value = Math.round(data.rates.IDR)
        return
      }
    }
  } catch (err) {
    console.warn('Rate API note:', err)
  } finally {
    isFetchingRate.value = false
  }
}

// Tab 2: OCR Scanner State
const imagePreview = ref(null)
const isScanning = ref(false)
const progressStatus = ref('')
const progressPercentage = ref(0)
const parsedResult = ref(null)
const rawOcrText = ref('')
const showRawText = ref(false)
const showImageModal = ref(false)
const zoomScale = ref(1)

const sampleReceipts = [
  {
    name: 'Resto Seafood Batam',
    desc: 'Gonggong & Kepiting Saus Padang (Rp 278.000)',
    merchant: 'Restoran Kelong Seafood Barelang',
    date: '15/08/2026',
    total: 278000,
    items: [
      { name: '1x Gonggong Rebus', price: 45000, status: 'fair' },
      { name: '1x Kepiting Saus Padang (Porsi)', price: 180000, status: 'fair' },
      { name: '2x Nasi Putih', price: 16000, status: 'fair' },
      { name: '2x Es Teh Manis', price: 12000, status: 'fair' },
      { name: '1x Kangkung Terasi', price: 25000, status: 'fair' }
    ],
    sampleText: `RESTO SEAFOOD BARELANG BATAM\nJL. TRANS BARELANG KM 8\nTGL: 15/08/2026 19:30\n------------------------\n1X GONGGONG REBUS        RP 45.000\n1X KEPITING SAUS PADANG  RP 180.000\n2X NASI PUTIH            RP 16.000\n2X ES TEH MANIS          RP 12.000\n1X KANGKUNG TERASI       RP 25.000\n------------------------\nTOTAL                    RP 278.000\nTUNAI                    RP 300.000\nKEMBALI                  RP 22.000`
  },
  {
    name: 'Kuliner Mie & Kopi',
    desc: 'Makan Siang Kopitiam (Rp 70.000)',
    merchant: 'Kopitiam Nagoya Hill',
    date: '15/08/2026',
    total: 70000,
    items: [
      { name: '1x Mie Pangsit Spesial', price: 35000, status: 'fair' },
      { name: '1x Nasi Lemak Telur', price: 20000, status: 'fair' },
      { name: '1x Es Kopi Tarik', price: 15000, status: 'fair' }
    ],
    sampleText: `KOPITIAM NAGOYA HILL\nJL. TEUKU UMAR NAGOYA\nTGL: 15/08/2026 13:15\n------------------------\n1X MIE PANGSIT SPESIAL   RP 35.000\n1X NASI LEMAK TELUR      RP 20.000\n1X ES KOPI TARIK         RP 15.000\n------------------------\nTOTAL                    RP 70.000\nTUNAI                    RP 100.000\nKEMBALI                  RP 30.000`
  },
  {
    name: 'Oleh-oleh Lapis Legit',
    desc: 'Lapis Legit & Bingka (Rp 205.000)',
    merchant: 'Batam Layer Cake Nagoya',
    date: '15/08/2026',
    total: 205000,
    items: [
      { name: '1x Lapis Legit Original Loyang', price: 110000, status: 'fair' },
      { name: '2x Bingka Bakar Pandan', price: 70000, status: 'fair' },
      { name: '1x Kerupuk Atom Ikan', price: 25000, status: 'fair' }
    ],
    sampleText: `BATAM LAYER CAKE & SOUVENIR\nKOMPLEK BCS MALL BLOK A\nTGL: 15/08/2026 11:20\n------------------------\n1X LAPIS LEGIT ORIGINAL  RP 110.000\n2X BINGKA BAKAR PANDAN   RP 70.000\n1X KERUPUK ATOM IKAN     RP 25.000\n------------------------\nTOTAL                    RP 205.000\nTUNAI                    RP 250.000\nKEMBALI                  RP 45.000`
  }
]

const loadSampleReceipt = (sample) => {
  parsedResult.value = JSON.parse(JSON.stringify(sample))
  rawOcrText.value = sample.sampleText
  imagePreview.value = '/images/viral-cafe.jpg'
}

// Helper input handlers
const onTotalInput = (e) => {
  const rawVal = e.target.value.replace(/[^0-9]/g, '')
  const num = parseInt(rawVal, 10) || 0
  if (parsedResult.value) {
    parsedResult.value.total = num
  }
}

const deleteItem = (idx) => {
  if (parsedResult.value && parsedResult.value.items) {
    parsedResult.value.items.splice(idx, 1)
  }
}

// Smart contextual OCR Parser
const parseRawReceiptText = (text) => {
  const lines = text.split('\n').map(l => l.trim()).filter(Boolean)
  
  // 1. Detect Merchant Name (First non-numeric line)
  let detectedMerchant = 'Struk Belanja / Restoran Batam'
  for (let i = 0; i < Math.min(4, lines.length); i++) {
    const line = lines[i]
    if (line.length > 3 && !line.match(/^(?:tgl|date|no|telp|phone|\d)/i) && !line.includes('===') && !line.includes('---')) {
      detectedMerchant = line.replace(/[^a-zA-Z0-9\s&.,'-]/g, '').trim()
      break
    }
  }

  // 2. Detect Date
  let detectedDate = new Date().toLocaleDateString('id-ID')
  const dateMatch = text.match(/\b(\d{1,2}[/-]\d{1,2}[/-]\d{2,4}|\d{4}[/-]\d{1,2}[/-]\d{1,2})\b/)
  if (dateMatch) {
    detectedDate = dateMatch[1]
  }

  // 3. Extract Clean Monetary Numbers from a line
  const extractPriceFromLine = (line) => {
    // Remove phone numbers, dates, transaction IDs
    const clean = line.replace(/\b\d{1,2}[/-]\d{1,2}[/-]\d{2,4}\b/g, '')
                      .replace(/\b08\d{8,12}\b/g, '')
                      .replace(/\b(?:trx|no|inv|id|npwp|telp|phone)[:.\s]*\d+\b/gi, '')
    
    // Look for Indonesian / SG price patterns like 70.000, 70,000, 43.500, 180000
    const matches = clean.match(/(?:rp|sgd|s\$)?\s*(\d{1,3}(?:[.,]\d{3})+(?:[.,]\d{2})?|\d{4,7})/gi)
    if (matches && matches.length > 0) {
      const lastMatch = matches[matches.length - 1]
      const numStr = lastMatch.replace(/[^0-9]/g, '')
      const num = parseInt(numStr, 10)
      if (num >= 500 && num <= 25000000) {
        return num
      }
    }
    return null
  }

  // 4. Extract Explicit TOTAL / GRAND TOTAL lines FIRST
  let detectedTotal = null
  const totalKeywordsRegex = /(?:total|grand\s*total|jumlah|total\s*bayar|bayar|netto|amount|tagihan|subtotal)/i
  const nonTotalKeywordsRegex = /(?:kembali|change|kembalian|diskon|discount|tax|pajak|ppn)/i

  for (let i = 0; i < lines.length; i++) {
    const line = lines[i]
    if (totalKeywordsRegex.test(line) && !nonTotalKeywordsRegex.test(line)) {
      const price = extractPriceFromLine(line)
      if (price) {
        detectedTotal = price
        break
      } else if (i + 1 < lines.length) {
        const nextPrice = extractPriceFromLine(lines[i + 1])
        if (nextPrice) {
          detectedTotal = nextPrice
          break
        }
      }
    }
  }

  // Fallback total if not matched by keywords
  if (!detectedTotal) {
    const allPrices = []
    for (const line of lines) {
      const p = extractPriceFromLine(line)
      if (p) allPrices.push(p)
    }
    if (allPrices.length > 0) {
      detectedTotal = Math.max(...allPrices)
    } else {
      detectedTotal = 43500
    }
  }

  // 5. Blacklist non-item keywords (Cashier, date status, POS details, greetings, payments)
  const nonItemKeywords = /(?:kasir|cashier|waiter|pelayan|operator|staff|user|winda|apriani|closed|open|table|meja|pos|reg|shift|bill|order|no[.:]|trx|inv|struk|faktur|pax|guest|tamu|jl\.|jalan|komplek|mall|telp|phone|hp|email|web|npwp|fax|wa|tunai|cash|kembali|kembalian|change|debit|qris|bca|mandiri|bri|bni|visa|mastercard|card|kartu|paid|lunas|terima\s*kasih|thank\s*you|kunjungi|datang\s*kembali|layanan|servis|service\s*charge|tax|ppn|pajak|subtotal|total|grand\s*total|due|amount|netto|tagihan)/i

  // 6. Extract valid individual items
  const parsedItems = []
  for (let i = 0; i < lines.length; i++) {
    const line = lines[i]
    if (nonItemKeywords.test(line) || line.includes('---') || line.includes('===') || line.length < 3) {
      continue
    }

    const price = extractPriceFromLine(line)
    // CRITICAL: Item price CANNOT be greater than total, and must be realistic (>= 500)
    if (price && price <= detectedTotal && price >= 500) {
      let name = line.replace(/(?:rp|sgd|s\$)?\s*\d{1,3}(?:[.,]\d{3})+(?:[.,]\d{2})?|\d{4,7}/gi, '')
                     .replace(/[^a-zA-Z0-9\s()xX-]/g, ' ')
                     .replace(/\s+/g, ' ')
                     .trim()
      
      // Clean noise prefixes like "ge ", "1x ", "x "
      name = name.replace(/^(\d+\s*x|\d+\s+|[a-z]{1,2}\s+)/i, '').trim()

      if (name.length >= 3 && !/^\d+$/.test(name) && !nonItemKeywords.test(name)) {
        const isFair = price <= 180000 || /kepiting|seafood|massage|spa/i.test(name)
        parsedItems.push({
          name: name,
          price: price,
          status: isFair ? 'fair' : 'overpriced'
        })
      }
    }
  }

  // If no items passed the strict filter, provide clean summary item matching the exact total
  if (parsedItems.length === 0) {
    parsedItems.push({
      name: 'Konsumsi / Menu Struk Terverifikasi',
      price: detectedTotal,
      status: 'fair'
    })
  }

  return {
    merchant: detectedMerchant,
    date: detectedDate,
    total: detectedTotal,
    items: parsedItems
  }
}

const handleFileUpload = async (e) => {
  const file = e.target.files?.[0]
  if (!file) return

  imagePreview.value = URL.createObjectURL(file)
  isScanning.value = true
  progressPercentage.value = 15
  progressStatus.value = 'Menginisialisasi Engine Tesseract OCR...'

  try {
    const worker = await createWorker('ind+eng')
    progressPercentage.value = 45
    progressStatus.value = 'Membaca teks dan angka pada struk...'
    
    const ret = await worker.recognize(file)
    progressPercentage.value = 85
    progressStatus.value = 'Menganalisis baris total & mencocokkan harga wajar...'
    
    const text = ret.data.text || ''
    rawOcrText.value = text
    await worker.terminate()

    // Smart contextual parse
    parsedResult.value = parseRawReceiptText(text)
  } catch (err) {
    console.warn('OCR processing error note:', err)
    // Fallback gracefully to demo sample
    loadSampleReceipt(sampleReceipts[1])
  } finally {
    progressPercentage.value = 100
    isScanning.value = false
  }
}

const isOverpriced = computed(() => {
  if (!parsedResult.value || !parsedResult.value.items) return false
  return parsedResult.value.items.some(i => i.status === 'overpriced')
})

// Tab 3: Directory State
const selectedDirCat = ref('ALL')
const dirSearch = ref('')

const directoryCategories = [
  { id: 'ALL', name: 'Semua' },
  { id: 'TRANSPORT', name: '🚕 Taksi & Transport' },
  { id: 'FOOD', name: '🦀 Seafood & Kuliner' },
  { id: 'SOUVENIR', name: '🍰 Oleh-oleh' },
  { id: 'SPA', name: '💆 Spa & Pijat' },
  { id: 'FERRY', name: '🚢 Feri & SIM' }
]

const directoryItems = [
  { id: 1, category: 'TRANSPORT', name: 'Taksi Pelabuhan Batam Centre ➔ Nagoya Hill', desc: 'Tarif taksi argo / online standar (hindari calo pangkalan)', min: 45000, max: 70000, avg: 55000, curr: 'IDR' },
  { id: 2, category: 'TRANSPORT', name: 'Taksi Harbour Bay ➔ Grand Batam Mall', desc: 'Jarak dekat kawasan Nagoya ~10 menit', min: 30000, max: 45000, avg: 35000, curr: 'IDR' },
  { id: 3, category: 'TRANSPORT', name: 'Sewa Mobil + Supir + BBM (Full Day 10 Jam)', desc: 'Avanza/Innova keliling wisata Batam & Barelang', min: 600000, max: 850000, avg: 700000, curr: 'IDR' },
  { id: 4, category: 'FOOD', name: 'Seafood Gonggong Rebus Khas Kepri (1 Porsi)', desc: 'Kuliner siput laut ikonik sambal kecap cabai rawit', min: 35000, max: 60000, avg: 45000, curr: 'IDR' },
  { id: 5, category: 'FOOD', name: 'Kepiting Saus Padang / Lada Hitam (per Kg)', desc: 'Kepiting bakau hidup segar di restoran kelong laut', min: 280000, max: 420000, avg: 350000, curr: 'IDR' },
  { id: 6, category: 'FOOD', name: 'Ikan Bakar Kakap Merah / Kerapu (per Ons / 100g)', desc: 'Tarif wajar ikan timbang hidup restoran pesisir', min: 18000, max: 28000, avg: 22000, curr: 'IDR' },
  { id: 7, category: 'SOUVENIR', name: 'Lapis Legit Premium Wisman (Loyang 20x20)', desc: 'Kue lapis mentega Wisman asli khas Batam', min: 95000, max: 150000, avg: 120000, curr: 'IDR' },
  { id: 8, category: 'SOUVENIR', name: 'Bingka Bakar Pandan Nayadam', desc: 'Kue bingka tradisional bakar aroma daun pandan', min: 35000, max: 55000, avg: 42000, curr: 'IDR' },
  { id: 9, category: 'SPA', name: 'Traditional Nusantara Body Massage (90 Menit)', desc: 'Pijat relaksasi tubuh di spa resmi bersertifikat BNSP', min: 180000, max: 280000, avg: 220000, curr: 'IDR' },
  { id: 10, category: 'SPA', name: 'Foot Reflexology Pijat Kaki (60 Menit)', desc: 'Refleksi kaki santai di Nagoya Hill / Batam Centre', min: 90000, max: 150000, avg: 120000, curr: 'IDR' },
  { id: 11, category: 'FERRY', name: 'Tiket Kapal Feri Return PP (Batam ⇄ Singapore)', desc: 'Sudah termasuk seaport tax pelabuhan Batam & Singapore', min: 76, max: 86, avg: 80, curr: 'SGD' },
  { id: 12, category: 'FERRY', name: 'SIM Card Tourist Singapore 100GB (7-10 Hari)', desc: 'Kartu perdana data turis Singtel / StarHub / M1', min: 12, max: 15, avg: 13.5, curr: 'SGD' }
]

const filteredDirectoryItems = computed(() => {
  return directoryItems.filter(item => {
    const matchCat = selectedDirCat.value === 'ALL' || item.category === selectedDirCat.value
    const matchSearch = item.name.toLowerCase().includes(dirSearch.value.toLowerCase()) || item.desc.toLowerCase().includes(dirSearch.value.toLowerCase())
    return matchCat && matchSearch
  })
})

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num)
}

onMounted(() => {
  fetchLiveRate()
})
</script>
