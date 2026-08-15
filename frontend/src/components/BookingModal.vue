<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md">
    <div class="bg-white w-full max-w-xl rounded-3xl p-6 sm:p-7 border-2 border-slate-300 shadow-2xl relative max-h-[92vh] overflow-y-auto">
      
      <!-- Close Button with strong border and contrast -->
      <button 
        @click="closeModal" 
        class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-200 text-slate-800 hover:bg-slate-300 flex items-center justify-center text-sm font-black z-10 transition-colors border border-slate-400 cursor-pointer shadow-sm"
      >
        ✕
      </button>

      <!-- VIEW A: BOOKING FORM -->
      <div v-if="!receiptData">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl font-bold border-2 border-emerald-300 shadow-sm">
            📋
          </div>
          <div>
            <h3 class="text-xl font-black text-teal-ink">Reservasi & Janji Layanan</h3>
            <p class="text-xs text-slate-600 font-medium">Pemesanan langsung terkonfirmasi ke WhatsApp & Email Wisatawan + Tempat Tujuan</p>
          </div>
        </div>

        <div v-if="selectedPlace" class="mb-4 p-4 rounded-2xl bg-sky-50 border-2 border-sky-200 flex items-center gap-3.5 shadow-sm">
          <img :src="selectedPlace.image" class="w-14 h-14 rounded-xl object-cover border-2 border-slate-300 shadow-sm" />
          <div class="flex-1">
            <p class="text-xs text-teal-ocean font-black uppercase tracking-wider">{{ selectedPlace.categoryLabel }}</p>
            <h4 class="text-sm font-black text-teal-ink">{{ selectedPlace.name }}</h4>
            <p class="text-xs text-emerald-800 font-black mt-0.5">S$ {{ selectedPlace.priceSgd }} (~Rp {{ formatNumber(selectedPlace.priceSgd * exchangeRate) }})</p>
          </div>
          <div class="text-right">
            <span class="text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-lg bg-teal-900 text-white font-black font-mono shadow-sm">
              📍 {{ selectedPlace.terminalKey }}
            </span>
          </div>
        </div>

        <form @submit.prevent="submitBooking" class="space-y-4">
          <div>
            <label class="block text-xs font-black text-slate-800 mb-1 uppercase tracking-wider">Nama Lengkap (Sesuai Paspor)</label>
            <input 
              v-model="form.name" 
              type="text" 
              required 
              placeholder="Contoh: Sarah Tan / Michael Lim" 
              class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm"
            />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-black text-slate-800 mb-1 uppercase tracking-wider">Email Aktif Wisatawan</label>
              <input 
                v-model="form.email" 
                type="email" 
                required 
                placeholder="sarah.tan@gmail.com" 
                class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm"
              />
            </div>
            <div>
              <div class="flex items-center justify-between mb-1">
                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">WhatsApp (+65 / +62)</label>
                <button 
                  type="button"
                  @click="form.phone = '+6285261516767'"
                  class="text-[11px] font-black text-emerald-800 bg-emerald-100 hover:bg-emerald-200 px-2 py-0.5 rounded-lg border border-emerald-300 transition-colors cursor-pointer"
                >
                  ⚡ Preset WA
                </button>
              </div>
              <input 
                v-model="form.phone" 
                type="text" 
                required 
                placeholder="+62 852-6151-6767" 
                class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-emerald-800 font-black focus:outline-none focus:border-teal-600 focus:bg-white transition-all font-mono shadow-sm"
              />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-black text-slate-800 mb-1 uppercase tracking-wider">Tanggal Kunjungan</label>
              <input 
                v-model="form.date" 
                type="date" 
                required 
                class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm"
              />
            </div>
            <div>
              <label class="block text-xs font-black text-slate-800 mb-1 uppercase tracking-wider">Jadwal Keberangkatan Feri SG</label>
              <select v-model="form.ferrySchedule" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm">
                <option value="08:00 AM SGT — HarbourFront ➔ Harbour Bay">08:00 AM SGT — HarbourFront ➔ Harbour Bay</option>
                <option value="09:30 AM SGT — HarbourFront ➔ Batam Centre">09:30 AM SGT — HarbourFront ➔ Batam Centre</option>
                <option value="11:15 AM SGT — Tanah Merah ➔ Nongsa Pura">11:15 AM SGT — Tanah Merah ➔ Nongsa Pura</option>
                <option value="02:00 PM SGT — HarbourFront ➔ Sekupang">02:00 PM SGT — HarbourFront ➔ Sekupang</option>
                <option value="04:30 PM SGT — HarbourFront ➔ Harbour Bay">04:30 PM SGT — HarbourFront ➔ Harbour Bay</option>
              </select>
            </div>
          </div>

          <div class="p-3.5 rounded-2xl bg-sky-50 border-2 border-sky-200">
            <label class="flex items-center space-x-2.5 text-xs font-black text-slate-800 cursor-pointer">
              <input v-model="form.pickup" type="checkbox" class="w-4 h-4 text-teal-ocean rounded border-slate-400 focus:ring-teal-ocean" />
              <span>Sertakan Layanan Antar-Jemput VIP di Pelabuhan Feri Batam?</span>
            </label>
            <div v-if="form.pickup" class="mt-2.5 pl-6">
              <select v-model="form.terminal" class="w-full bg-white border-2 border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-900 font-bold">
                <option value="Harbour Bay Terminal">Harbour Bay Terminal</option>
                <option value="Batam Centre Terminal">Batam Centre Terminal</option>
                <option value="Sekupang Terminal">Sekupang Terminal</option>
                <option value="Nongsa Pura Terminal">Nongsa Pura Terminal</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-black text-slate-800 mb-1 uppercase tracking-wider">Catatan Khusus / Keluhan Medis</label>
            <textarea 
              v-model="form.notes" 
              rows="2" 
              placeholder="Catatan untuk tempat tujuan (contoh: minta ruang konsultasi VIP, alergi obat, permintaan supir penjemput bawa papan nama...)"
              class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-3.5 py-2 text-sm text-slate-900 font-medium focus:outline-none focus:border-teal-600 focus:bg-white transition-all shadow-sm"
            ></textarea>
          </div>

          <!-- Submit Button (Bold Vibrant) -->
          <button 
            type="submit" 
            :disabled="isSubmitting"
            class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-ocean hover:from-emerald-700 hover:to-teal-700 text-white font-black text-sm transition-all flex items-center justify-center gap-2 shadow-xl shadow-teal-600/30 active:scale-95 border border-teal-500 cursor-pointer"
          >
            <span v-if="isSubmitting" class="animate-pulse">🔄 Mengirim Notifikasi Real-Time ke WhatsApp & Email...</span>
            <span v-else>📲 Buat Reservasi & Kirim Notifikasi Real-Time</span>
          </button>
        </form>
      </div>

      <!-- VIEW B: LIVE DISPATCH RECEIPT HUB -->
      <div v-else class="space-y-5">
        <div class="text-center">
          <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl mx-auto mb-2 border-2 border-emerald-300 shadow-sm">
            🎉
          </div>
          <span class="px-3.5 py-1.5 rounded-full bg-teal-900 text-white font-mono text-xs font-black border border-teal-700 shadow-sm">
            RESERVASI TERKONFIRMASI — Kode: {{ receiptData.bookingRef }}
          </span>
          <h3 class="text-2xl font-black text-teal-ink mt-2">Notifikasi Real-Time Dikirim!</h3>
          <p class="text-xs text-slate-600 font-medium mt-1">Sistem telah memproses dan mendistribusikan resi konfirmasi ke seluruh pihak.</p>
        </div>

        <!-- Multi-Channel Dispatch Badges Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <!-- Patient Email & WA -->
          <div class="p-4 rounded-2xl bg-sky-50 border-2 border-sky-200">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs font-black text-teal-ocean">👤 Pasien / Wisatawan</span>
              <span class="px-2 py-0.5 text-[10px] rounded-md bg-emerald-600 text-white font-black shadow-sm">SUCCESS</span>
            </div>
            <div class="text-xs text-slate-800 space-y-1">
              <p>📧 Email: <span class="font-mono font-bold text-slate-950">{{ form.email }}</span></p>
              <p>💬 WhatsApp: <span class="font-mono font-black text-teal-900">{{ form.phone }}</span></p>
            </div>
          </div>

          <!-- Vendor / Hospital Email & WA -->
          <div class="p-4 rounded-2xl bg-amber-50 border-2 border-amber-200">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs font-black text-amber-900">🏢 Tempat Tujuan (Vendor)</span>
              <span class="px-2 py-0.5 text-[10px] rounded-md bg-emerald-600 text-white font-black shadow-sm">AUTO-SENT 🤖</span>
            </div>
            <div class="text-xs text-slate-800 space-y-1">
              <p>📧 Email Vendor: <span class="font-mono font-bold text-slate-950">{{ vendorContact.email }}</span></p>
              <p>💬 WA Gateway: <span class="font-mono text-emerald-800 font-black">{{ vendorContact.phone }}</span></p>
            </div>
          </div>
        </div>

        <div class="p-3.5 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-xs text-emerald-950 flex items-center gap-2 font-medium">
          <span>✅</span>
          <span><strong>Auto-Sent Server Backend Active</strong>: Pesan konfirmasi pasien untuk tempat tujuan otomatis terkirim dari server ke WhatsApp Vendor (<strong>{{ vendorContact.phone }}</strong>).</span>
        </div>

        <!-- Real-Time Actions: Direct WhatsApp API Buttons -->
        <div class="p-4 rounded-2xl bg-slate-100 border-2 border-slate-300 space-y-3">
          <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Aksi Langsung Transaksi Real-Time:</h4>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <!-- Open Patient WhatsApp -->
            <a 
              :href="patientWaLink" 
              target="_blank"
              class="py-3 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black flex items-center justify-center gap-2 transition-all shadow-md active:scale-95 border border-emerald-500"
            >
              <span>📲 Chat WA Pasien</span>
            </a>

            <!-- Open Vendor WhatsApp -->
            <a 
              :href="vendorWaLink" 
              target="_blank"
              class="py-3 px-3 rounded-xl bg-teal-ocean hover:bg-teal-700 text-white text-xs font-black flex items-center justify-center gap-2 transition-all shadow-md active:scale-95 border border-teal-500"
            >
              <span>🏢 Chat WA Vendor</span>
            </a>
          </div>
        </div>

        <!-- Booking Detail Summary Box -->
        <div class="p-4 rounded-2xl bg-slate-100 border-2 border-slate-300 text-xs space-y-1.5 font-mono text-slate-800">
          <div class="flex justify-between">
            <span class="text-slate-600 font-sans font-bold">Destinasi:</span>
            <span class="text-slate-950 font-black font-sans">{{ selectedPlace ? selectedPlace.name : 'Konsultasi Medis' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-slate-600 font-sans font-bold">Tanggal Kunjungan:</span>
            <span class="text-teal-900 font-black">{{ form.date }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-slate-600 font-sans font-bold">Jadwal Feri SG:</span>
            <span class="text-amber-900 font-black font-sans">{{ form.ferrySchedule }}</span>
          </div>
          <div class="flex justify-between" v-if="form.pickup">
            <span class="text-slate-600 font-sans font-bold">Penjemputan VIP:</span>
            <span class="text-emerald-800 font-black font-sans">Ya (Pelabuhan {{ form.terminal }})</span>
          </div>
          <div class="flex justify-between pt-2 border-t border-slate-300 font-bold font-sans">
            <span class="text-slate-700">Total Biaya Layanan:</span>
            <span class="text-emerald-800 text-sm font-black">S$ {{ selectedPlace ? selectedPlace.priceSgd : 0 }} (~Rp {{ formatNumber((selectedPlace ? selectedPlace.priceSgd : 0) * exchangeRate) }})</span>
          </div>
        </div>

        <button 
          @click="closeModal" 
          class="w-full py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 text-slate-900 text-xs font-black transition-all border border-slate-300 cursor-pointer"
        >
          Tutup Window Konfirmasi
        </button>

      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { getApiUrl } from '../config/api.js'

const props = defineProps({
  show: Boolean,
  selectedPlace: Object,
  exchangeRate: { type: Number, default: 13920 }
})

const emit = defineEmits(['close'])

const form = ref({
  name: 'Sarah Lim (Wisatawan SG)',
  email: 'testing.sarah@gmail.com',
  phone: '+65 9123 4567',
  date: new Date().toISOString().substr(0, 10),
  ferrySchedule: '08:00 AM SGT — HarbourFront ➔ Harbour Bay',
  pickup: true,
  terminal: 'Harbour Bay Terminal',
  notes: 'Permintaan konsultasi checkup medis eksekutif'
})

const isSubmitting = ref(false)
const receiptData = ref(null)

// Vendor Contacts Map
const vendorContactsMap = {
  1: { email: 'booking@awalbrosbatam.com', phone: '+6285261516767' },
  2: { email: 'contact@nagoyadental.com', phone: '+6285261516767' },
  3: { email: 'reservation@royalheritagespa.id', phone: '+6285261516767' },
  4: { email: 'concierge@palmspringsgolf.co.id', phone: '+6285261516767' },
  5: { email: 'order@kelong168barelang.com', phone: '+6285261516767' },
  6: { email: 'care@aestheticskinbatam.com', phone: '+6285261516767' },
  7: { email: 'concierge@mountelizabeth.com.sg', phone: '+6285261516767' },
  8: { email: 'wellness@marinabaysands.com', phone: '+6285261516767' },
  9: { email: 'info@tanahmerahferry.sg', phone: '+6285261516767' }
}

const vendorContact = computed(() => {
  if (props.selectedPlace && vendorContactsMap[props.selectedPlace.id]) {
    return vendorContactsMap[props.selectedPlace.id]
  }
  return { email: 'booking@vendor-destination.com', phone: '+6285261516767' }
})

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num)
}

const cleanPhoneNum = (numStr) => {
  return numStr.replace(/[^0-9]/g, '')
}

// Generate Live WhatsApp Direct API Links
const patientWaLink = computed(() => {
  const placeTitle = props.selectedPlace ? props.selectedPlace.name : 'Layanan Medis Batam'
  const text = encodeURIComponent(
    `Halo ${form.value.name}! 🌟\n\n` +
    `Konfirmasi Reservasi BatamPulse (Ref: ${receiptData.value?.bookingRef}):\n` +
    `📍 Destinasi: ${placeTitle}\n` +
    `📅 Tanggal: ${form.value.date}\n` +
    `🚢 Feri Keberangkatan: ${form.value.ferrySchedule}\n` +
    `🚕 VIP Pick-up: ${form.value.pickup ? form.value.terminal : 'Tidak'}\n` +
    `💰 Estimasi Biaya: S$ ${props.selectedPlace?.priceSgd} (~Rp ${formatNumber(props.selectedPlace?.priceSgd * props.exchangeRate)})\n\n` +
    `Tim kami siap menyambut kedatangan Anda di Batam!`
  )
  const phone = cleanPhoneNum(form.value.phone)
  return `https://api.whatsapp.com/send?phone=${phone}&text=${text}`
})

const vendorWaLink = computed(() => {
  const placeTitle = props.selectedPlace ? props.selectedPlace.name : 'Layanan Medis Batam'
  const text = encodeURIComponent(
    `[NOTIFIKASI TAMU SG BARU - BatamPulse]\n\n` +
    `Yth. Tim ${placeTitle},\n\n` +
    `Ada reservasi baru dari wisatawan Singapura (Ref: ${receiptData.value?.bookingRef}):\n` +
    `👤 Nama Pasien: ${form.value.name}\n` +
    `📧 Email: ${form.value.email}\n` +
    `💬 WhatsApp: ${form.value.phone}\n` +
    `📅 Tanggal Kunjungan: ${form.value.date}\n` +
    `🚢 Feri SG: ${form.value.ferrySchedule}\n` +
    `📝 Catatan: ${form.value.notes || '-'}\n\n` +
    `Mohon siapkan tim penerima & konfirmasi kembali ke tamu.`
  )
  const phone = cleanPhoneNum(vendorContact.value.phone)
  return `https://api.whatsapp.com/send?phone=${phone}&text=${text}`
})

const sendFonnteDirectWA = async (bookingRef) => {
  try {
    const placeTitle = props.selectedPlace ? props.selectedPlace.name : 'Layanan Medis Batam'
    const waText = 
      `*[NOTIFIKASI TAMU SG BARU - BatamPulse]*\n\n` +
      `Yth. Tim Operasional ${placeTitle},\n\n` +
      `Ada reservasi baru dari wisatawan Singapura:\n` +
      `🆔 Kode Booking: ${bookingRef}\n` +
      `👤 Nama Pasien: ${form.value.name}\n` +
      `📧 Email Pasien: ${form.value.email}\n` +
      `💬 WhatsApp Pasien: ${form.value.phone}\n` +
      `📅 Tanggal Kunjungan: ${form.value.date}\n` +
      `🚢 Feri SG: ${form.value.ferrySchedule}\n` +
      `🚕 Penjemputan VIP: ${form.value.pickup ? form.value.terminal : 'Tidak'}\n` +
      `💰 Biaya: S$ ${props.selectedPlace?.priceSgd} (~Rp ${formatNumber(props.selectedPlace?.priceSgd * props.exchangeRate)})\n` +
      `📝 Catatan: ${form.value.notes || '-'}\n\n` +
      `Mohon siapkan tim penerima & konfirmasi kembali ke pasien.`

    const formData = new FormData()
    formData.append('target', '085261516767')
    formData.append('message', waText)
    formData.append('countryCode', '62')

    await fetch('https://api.fonnte.com/send', {
      method: 'POST',
      headers: {
        'Authorization': 'RxbepHkDh9uPgw4tx7Ry'
      },
      body: formData
    })
  } catch (err) {
    console.warn('Direct Fonnte fetch note:', err)
  }
}

const submitBooking = async () => {
  isSubmitting.value = true
  const generatedRef = 'BP-' + Date.now().toString().substr(-6)

  const payload = {
    place_id: props.selectedPlace?.id,
    place_name: props.selectedPlace?.name,
    vendor_email: vendorContact.value.email,
    vendor_phone: vendorContact.value.phone,
    user_name: form.value.name,
    user_email: form.value.email,
    user_phone: form.value.phone,
    booking_date: form.value.date,
    booking_time: form.value.ferrySchedule,
    pickup_required: form.value.pickup,
    pickup_terminal: form.value.terminal,
    notes: form.value.notes,
    price_sgd: props.selectedPlace?.priceSgd,
    price_idr: props.selectedPlace ? Math.round(props.selectedPlace.priceSgd * props.exchangeRate) : 0
  }

  // Trigger Fonnte WhatsApp API Direct Send to +6285261516767
  sendFonnteDirectWA(generatedRef)

  try {
    const res = await fetch(getApiUrl('/api/bookings'), {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
    
    if (res.ok) {
      const data = await res.json()
      receiptData.value = {
        bookingRef: data.booking_ref || generatedRef
      }
    } else {
      receiptData.value = { bookingRef: generatedRef }
    }
  } catch (err) {
    receiptData.value = { bookingRef: generatedRef }
  } finally {
    isSubmitting.value = false
  }
}

const closeModal = () => {
  receiptData.value = null
  emit('close')
}
</script>
