<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FerrySchedule;
use App\Models\FairPriceBenchmark;
use App\Models\Doctor;
use App\Models\ItineraryPackage;
use App\Models\FerryTerminal;
use App\Models\Place;

class EnhancedTourismSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ferry Terminals Map
        $hb = FerryTerminal::where('slug', 'harbour-bay')->first();
        $bc = FerryTerminal::where('slug', 'batam-centre')->first();
        $sk = FerryTerminal::where('slug', 'sekupang')->first();
        $ng = FerryTerminal::where('slug', 'nongsa')->first();
        $hf = FerryTerminal::where('slug', 'harbourfront-sg')->first();
        $tm = FerryTerminal::where('slug', 'tanah-merah-sg')->first();

        // 2. Seed Ferry Schedules (Daily Real Routes SG ⇄ Batam)
        if ($hf && $hb) {
            $schedules = [
                // Horizon & BatamFast: HarbourFront ⇄ Harbour Bay (45 min)
                ['operator_name' => 'Horizon Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $hb->id, 'departure_time' => '08:15:00', 'arrival_time' => '09:00:00', 'duration_minutes' => 45, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'],
                ['operator_name' => 'Horizon Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $hb->id, 'departure_time' => '10:15:00', 'arrival_time' => '11:00:00', 'duration_minutes' => 45, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'],
                ['operator_name' => 'Horizon Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $hb->id, 'departure_time' => '12:15:00', 'arrival_time' => '13:00:00', 'duration_minutes' => 45, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'],
                ['operator_name' => 'Horizon Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $hb->id, 'departure_time' => '14:15:00', 'arrival_time' => '15:00:00', 'duration_minutes' => 45, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'],
                ['operator_name' => 'Horizon Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $hb->id, 'departure_time' => '17:15:00', 'arrival_time' => '18:00:00', 'duration_minutes' => 45, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'],
                ['operator_name' => 'Horizon Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $hb->id, 'departure_time' => '20:15:00', 'arrival_time' => '21:00:00', 'duration_minutes' => 45, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'],
            ];

            if ($bc) {
                // Majestic & BatamFast: HarbourFront ⇄ Batam Centre (60 min)
                $schedules[] = ['operator_name' => 'BatamFast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $bc->id, 'departure_time' => '07:40:00', 'arrival_time' => '08:40:00', 'duration_minutes' => 60, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'];
                $schedules[] = ['operator_name' => 'Majestic Fast Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $bc->id, 'departure_time' => '09:00:00', 'arrival_time' => '10:00:00', 'duration_minutes' => 60, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'];
                $schedules[] = ['operator_name' => 'Sindo Ferry', 'origin_terminal_id' => $hf->id, 'destination_terminal_id' => $bc->id, 'departure_time' => '11:10:00', 'arrival_time' => '12:10:00', 'duration_minutes' => 60, 'price_sgd' => 43.00, 'price_idr' => 595000, 'status' => 'On Time', 'days_active' => 'Daily'];
            }

            if ($tm && $ng) {
                // BatamFast: Tanah Merah ⇄ Nongsa Pura (35 min)
                $schedules[] = ['operator_name' => 'BatamFast Ferry', 'origin_terminal_id' => $tm->id, 'destination_terminal_id' => $ng->id, 'departure_time' => '08:00:00', 'arrival_time' => '08:35:00', 'duration_minutes' => 35, 'price_sgd' => 45.00, 'price_idr' => 625000, 'status' => 'On Time', 'days_active' => 'Daily'];
                $schedules[] = ['operator_name' => 'BatamFast Ferry', 'origin_terminal_id' => $tm->id, 'destination_terminal_id' => $ng->id, 'departure_time' => '14:20:00', 'arrival_time' => '14:55:00', 'duration_minutes' => 35, 'price_sgd' => 45.00, 'price_idr' => 625000, 'status' => 'On Time', 'days_active' => 'Daily'];
            }

            foreach ($schedules as $sched) {
                FerrySchedule::create($sched);
            }
        }

        // 3. Seed Fair Price Benchmarks (Anti-Getok Directory & Receipt OCR Master)
        $benchmarks = [
            // Kuliner & Seafood
            [
                'category' => 'Kuliner Seafood',
                'item_name' => 'Kepiting Saus Lada Hitam (Live Crab)',
                'fair_price_min_idr' => 250000,
                'fair_price_max_idr' => 380000,
                'price_sgd_benchmark' => 85.00,
                'unit' => 'per kg',
                'warning_threshold_idr' => 450000,
                'notes' => 'Di restoran seafood Barelang / Harbour Bay, kisaran wajar Rp 250k - Rp 380k/kg (vs S$85+/kg di SG).'
            ],
            [
                'category' => 'Kuliner Seafood',
                'item_name' => 'Gonggong Rebus Khas Kepri',
                'fair_price_min_idr' => 45000,
                'fair_price_max_idr' => 75000,
                'price_sgd_benchmark' => 25.00,
                'unit' => 'per porsi',
                'warning_threshold_idr' => 100000,
                'notes' => 'Siput laut khas Kepulauan Riau yang segar disajikan dengan saus sambal khas.'
            ],
            [
                'category' => 'Kuliner Seafood',
                'item_name' => 'Ikan Bakar Bumbu Rica / Kecap (Kakap / Kerapu)',
                'fair_price_min_idr' => 120000,
                'fair_price_max_idr' => 180000,
                'price_sgd_benchmark' => 45.00,
                'unit' => 'per kg',
                'warning_threshold_idr' => 240000,
                'notes' => 'Ikan hidup ditimbang segar sebelum dimasak di atas arang kelapa.'
            ],
            // Perawatan Gigi
            [
                'category' => 'Perawatan Gigi',
                'item_name' => 'Pembersihan Karang Gigi (Scaling Ultrasound)',
                'fair_price_min_idr' => 250000,
                'fair_price_max_idr' => 450000,
                'price_sgd_benchmark' => 120.00,
                'unit' => 'per sesi',
                'warning_threshold_idr' => 650000,
                'notes' => 'Termasuk poles gigi dan konsultasi dokter gigi spesialis.'
            ],
            [
                'category' => 'Perawatan Gigi',
                'item_name' => 'Pemutihan Gigi Laser (In-Office Teeth Whitening)',
                'fair_price_min_idr' => 1800000,
                'fair_price_max_idr' => 2800000,
                'price_sgd_benchmark' => 850.00,
                'unit' => 'per paket',
                'warning_threshold_idr' => 3800000,
                'notes' => 'Prosedur 45 menit mencerahkan hingga 6-8 tingkat warna.'
            ],
            // Medis & Checkup
            [
                'category' => 'Pemeriksaan Medis',
                'item_name' => 'Paket Executive Medical Checkup Lengkap + EKG',
                'fair_price_min_idr' => 2800000,
                'fair_price_max_idr' => 4200000,
                'price_sgd_benchmark' => 880.00,
                'unit' => 'per paket',
                'warning_threshold_idr' => 5500000,
                'notes' => 'Meliputi tes darah komprehensif, rontgen thoraks, USG abdomen, EKG jantung & konsultasi spesialis.'
            ],
            // Spa & Wellness
            [
                'category' => 'Spa & Wellness',
                'item_name' => 'Pijat Tradisional Nusantara + Scrub Herbal (120 Menit)',
                'fair_price_min_idr' => 350000,
                'fair_price_max_idr' => 600000,
                'price_sgd_benchmark' => 180.00,
                'unit' => 'per 120 menit',
                'warning_threshold_idr' => 800000,
                'notes' => 'Layanan spa profesional di Nagoya & Harbour Bay dengan minyak aromaterapi alami.'
            ],
            // Transportasi
            [
                'category' => 'Transportasi & Taksi',
                'item_name' => 'Taksi Pelabuhan Harbour Bay ke Kawasan Nagoya / Penuin',
                'fair_price_min_idr' => 35000,
                'fair_price_max_idr' => 60000,
                'price_sgd_benchmark' => 18.00,
                'unit' => 'per perjalanan',
                'warning_threshold_idr' => 100000,
                'notes' => 'Gunakan taksi resmi pelabuhan atau transportasi online (Grab / Maxim / Gojek).'
            ],
            [
                'category' => 'Transportasi & Taksi',
                'item_name' => 'Sewa Mobil Privat Full Day + Driver (Batam City Tour)',
                'fair_price_min_idr' => 600000,
                'fair_price_max_idr' => 850000,
                'price_sgd_benchmark' => 280.00,
                'unit' => 'per 10 jam',
                'warning_threshold_idr' => 1200000,
                'notes' => 'Termasuk mobil ber-AC (Innova/Avanza), bensin, dan driver ramah berbahasa Inggris/Melayu.'
            ]
        ];

        foreach ($benchmarks as $bm) {
            FairPriceBenchmark::create($bm);
        }

        // 4. Seed Specialist Doctors (RS & Klinik Batam)
        $awalBros = Place::where('name', 'like', '%Awal Bros%')->first();
        $budiKemuliaan = Place::where('name', 'like', '%Budi Kemuliaan%')->first();
        $harapanBunda = Place::where('name', 'like', '%Harapan Bunda%')->first();
        $nagoyaDental = Place::where('name', 'like', '%Nagoya Dental%')->first();
        $aestheticSkin = Place::where('name', 'like', '%Aesthetic Skin%')->first();

        $doctors = [
            [
                'place_id' => $awalBros ? $awalBros->id : 1,
                'name' => 'dr. Michael Tan, Sp.JP (K) FIHA',
                'specialization' => 'Spesialis Jantung & Pembuluh Darah (Intervensi)',
                'degree' => 'Fellowship Invasive Cardiology (Singapore / NCIS)',
                'languages_spoken' => 'English, Mandarin, Bahasa Indonesia, Melayu',
                'consultation_fee_sgd' => 45.00,
                'consultation_fee_idr' => 625000.00,
                'schedule_days' => 'Senin - Kamis (09:00 - 15:00)',
                'rating' => 4.9,
                'avatar_url' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=200&q=80'
            ],
            [
                'place_id' => $budiKemuliaan ? $budiKemuliaan->id : 3,
                'name' => 'dr. Siti Sarah Siregar, Sp.M',
                'specialization' => 'Spesialis Mata, Katarak & Bedah LASIK Presisi',
                'degree' => 'Subspesialis Kornea & Refraksi Bedah (FKUI / SNEC SG)',
                'languages_spoken' => 'English, Bahasa Indonesia',
                'consultation_fee_sgd' => 40.00,
                'consultation_fee_idr' => 550000.00,
                'schedule_days' => 'Senin - Jumat (10:00 - 16:00)',
                'rating' => 4.9,
                'avatar_url' => 'https://images.unsplash.com/photo-1594824813629-8736a445e998?auto=format&fit=crop&w=200&q=80'
            ],
            [
                'place_id' => $harapanBunda ? $harapanBunda->id : 6,
                'name' => 'dr. Hendrik Wijaya, Sp.OT (K)',
                'specialization' => 'Spesialis Bedah Ortopedi & Penggantian Sendi Lutut',
                'degree' => 'Fellowship Joint Replacement Surgery (Germany & SG)',
                'languages_spoken' => 'English, Hokkien, Bahasa Indonesia',
                'consultation_fee_sgd' => 50.00,
                'consultation_fee_idr' => 695000.00,
                'schedule_days' => 'Selasa, Kamis, Sabtu (09:00 - 14:00)',
                'rating' => 4.8,
                'avatar_url' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=200&q=80'
            ],
            [
                'place_id' => $nagoyaDental ? $nagoyaDental->id : 11,
                'name' => 'drg. Jessica Lim, Sp.Ort',
                'specialization' => 'Spesialis Ortodonti, Veneer Estetik & Implan Gigi',
                'degree' => 'Certified Invisalign Provider (US & Australia)',
                'languages_spoken' => 'English, Mandarin, Bahasa Indonesia',
                'consultation_fee_sgd' => 35.00,
                'consultation_fee_idr' => 485000.00,
                'schedule_days' => 'Senin - Sabtu (11:00 - 19:00)',
                'rating' => 5.0,
                'avatar_url' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=200&q=80'
            ],
            [
                'place_id' => $aestheticSkin ? $aestheticSkin->id : 13,
                'name' => 'dr. Alvin Hartono, Dip.Derm (UK)',
                'specialization' => 'Dokter Estetika, Anti-Aging & Laser Dermatologi',
                'degree' => 'Diploma in Clinical Dermatology (Cardiff University, UK)',
                'languages_spoken' => 'English, Bahasa Indonesia',
                'consultation_fee_sgd' => 38.00,
                'consultation_fee_idr' => 520000.00,
                'schedule_days' => 'Selasa - Minggu (10:00 - 18:00)',
                'rating' => 4.9,
                'avatar_url' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=200&q=80'
            ]
        ];

        foreach ($doctors as $doc) {
            Doctor::create($doc);
        }

        // 5. Seed Itinerary Packages (AI Travel Planner)
        $packages = [
            [
                'title' => '2D1N Executive Medical Checkup & Sunset Cafe Escape',
                'theme' => 'Medical & Relaxation',
                'duration_days' => 2,
                'estimated_cost_sgd' => 340.00,
                'estimated_savings_sgd' => 650.00,
                'highlights' => 'Feri Cepat 45m • Paket Medical Checkup RS Awal Bros • Brunch Mula Cafe • Sunset Dinner Harbour Bay Seafood',
                'steps_json' => [
                    ['day' => 1, 'time' => '08:15', 'activity' => 'Naik Feri Horizon dari HarbourFront SG menuju Harbour Bay Batam'],
                    ['day' => 1, 'time' => '09:15', 'activity' => 'Penjemputan VIP langsung menuju RS Awal Bros untuk Executive Health Screening'],
                    ['day' => 1, 'time' => '13:00', 'activity' => 'Brunch & Specialty Coffee di Mula Cafe & Eatery Batam Centre'],
                    ['day' => 1, 'time' => '16:00', 'activity' => 'Check-in hotel & relaksasi pijat tradisional 90 menit di Royal Heritage Spa'],
                    ['day' => 1, 'time' => '19:00', 'activity' => 'Santap malam live seafood kepiting lada hitam di Harbour Bay Waterfront'],
                    ['day' => 2, 'time' => '09:00', 'activity' => 'Konsultasi hasil lab medis bersama dokter spesialis & pengambilan resep'],
                    ['day' => 2, 'time' => '11:30', 'activity' => 'Belanja oleh-oleh & shopping di One Batam Mall'],
                    ['day' => 2, 'time' => '16:00', 'activity' => 'Kembali ke Singapura naik kapal feri sore dari Harbour Bay']
                ],
                'image_url' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => '3D2N Golf Championship & Oceanfront Beach Spa',
                'theme' => 'Golf & Luxury Wellness',
                'duration_days' => 3,
                'estimated_cost_sgd' => 420.00,
                'estimated_savings_sgd' => 880.00,
                'highlights' => 'Feri Tanah Merah 35m • 18-Hole Palm Springs Golf • Ocean Spa Nongsa • Kelong Seafood Feast',
                'steps_json' => [
                    ['day' => 1, 'time' => '08:00', 'activity' => 'Feri BatamFast dari Tanah Merah SG ke Nongsa Pura Terminal (35 min)'],
                    ['day' => 1, 'time' => '09:00', 'activity' => 'Tee-off 18 holes di Palm Springs Golf & Beach Resort Nongsa'],
                    ['day' => 1, 'time' => '15:00', 'activity' => 'Terapi oceanfront spa di Batam View Resort menghadap Selat Singapura'],
                    ['day' => 2, 'time' => '09:30', 'activity' => 'Eksplorasi Pantai Pasir Putih Elyora & Viovio Jembatan Barelang'],
                    ['day' => 2, 'time' => '13:00', 'activity' => 'Makan siang seafood lobster & gonggong di Kelong Barelang 168'],
                    ['day' => 2, 'time' => '18:00', 'activity' => 'Cocktail & sunset acoustic di Level Up Floating Lounge Harbour Bay'],
                    ['day' => 3, 'time' => '10:00', 'activity' => 'Dental scaling & polishing express di Nagoya Dental Wellness'],
                    ['day' => 3, 'time' => '15:30', 'activity' => 'Feri kembali ke Tanah Merah Singapura dengan badan segar bugar']
                ],
                'image_url' => 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => '2D1N Dental Makeover & Viral Aesthetic Cafes Tour',
                'theme' => 'Dental & Cafe Hopping',
                'duration_days' => 2,
                'estimated_cost_sgd' => 260.00,
                'estimated_savings_sgd' => 720.00,
                'highlights' => 'Laser Teeth Whitening • Malaya Kopitiam Toast • De’Sands Santorini Cafe • Sunset Drinks',
                'steps_json' => [
                    ['day' => 1, 'time' => '08:15', 'activity' => 'Keberangkatan feri pagi HarbourFront menuju Harbour Bay Nagoya'],
                    ['day' => 1, 'time' => '09:30', 'activity' => 'Sarapan Roti Bakar Kaya Butter & Kopi O di Malaya Cafe Kopitiam'],
                    ['day' => 1, 'time' => '11:00', 'activity' => 'Sesi Laser Teeth Whitening 45 menit di Nagoya Dental Centre'],
                    ['day' => 1, 'time' => '14:30', 'activity' => 'Foto estetik & artisan dessert di De’Sands Santorini Cafe Bengkong'],
                    ['day' => 1, 'time' => '18:30', 'activity' => 'Dinner live acoustic & sunset dining di The Promenade Harbour Bay'],
                    ['day' => 2, 'time' => '10:00', 'activity' => 'Specialty coffee roastery experience di Anchor Cafe Batam Centre'],
                    ['day' => 2, 'time' => '14:00', 'activity' => 'Feri kembali ke HarbourFront Singapura dengan senyum cerah putih']
                ],
                'image_url' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        foreach ($packages as $pkg) {
            ItineraryPackage::create($pkg);
        }
    }
}
