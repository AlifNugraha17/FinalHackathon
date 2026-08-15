<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\FerryTerminal;
use App\Models\Place;

class TourismSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate / clean before seeding if needed
        Schema::disableForeignKeyConstraints();
        Place::truncate();
        FerryTerminal::truncate();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Categories
        $categories = [
            'medical' => Category::create(['slug' => 'medical', 'name' => 'Medical & Diagnostic', 'icon' => 'hospital']),
            'dental' => Category::create(['slug' => 'dental', 'name' => 'Dental Care', 'icon' => 'tooth']),
            'spa' => Category::create(['slug' => 'spa', 'name' => 'Wellness & Spa', 'icon' => 'sparkles']),
            'golf' => Category::create(['slug' => 'golf', 'name' => 'Golf & Resort', 'icon' => 'flag']),
            'culinary' => Category::create(['slug' => 'culinary', 'name' => 'Seafood & Culinary', 'icon' => 'utensils']),
            'tourism' => Category::create(['slug' => 'tourism', 'name' => 'Tourism, Beaches & Cafes', 'icon' => 'compass']),
            'terminal' => Category::create(['slug' => 'terminal', 'name' => 'Ferry Terminal Hub', 'icon' => 'anchor']),
        ];

        // 2. Seed Ferry Terminals (Batam & Singapore)
        $terminals = [
            'harbour-bay' => FerryTerminal::create([
                'slug' => 'harbour-bay',
                'name' => 'Harbour Bay Ferry Terminal (Batam)',
                'latitude' => 1.1558,
                'longitude' => 104.0041,
                'description' => 'Terminal feri utama terdekat dengan kawasan pusat perbelanjaan & kuliner Nagoya.'
            ]),
            'batam-centre' => FerryTerminal::create([
                'slug' => 'batam-centre',
                'name' => 'Batam Centre Ferry Terminal',
                'latitude' => 1.1311,
                'longitude' => 104.0531,
                'description' => 'Terminal feri di pusat pemerintahan, Mega Mall & rumah sakit rujukan utama.'
            ]),
            'sekupang' => FerryTerminal::create([
                'slug' => 'sekupang',
                'name' => 'Sekupang Ferry Terminal',
                'latitude' => 1.1189,
                'longitude' => 103.9238,
                'description' => 'Terminal feri kawasan barat Batam, RSBP Batam & golf perbukitan.'
            ]),
            'nongsa' => FerryTerminal::create([
                'slug' => 'nongsa',
                'name' => 'Nongsa Pura Ferry Terminal',
                'latitude' => 1.1895,
                'longitude' => 104.1012,
                'description' => 'Terminal feri eksklusif kawasan pantai pasir putih & luxury golf resort.'
            ]),
            'harbourfront-sg' => FerryTerminal::create([
                'slug' => 'harbourfront-sg',
                'name' => 'HarbourFront International Terminal (Singapore)',
                'latitude' => 1.2644,
                'longitude' => 103.8210,
                'description' => 'Pintu gerbang utama feri Singapura ke Batam (Harbour Bay, Batam Centre, Sekupang).'
            ]),
            'tanah-merah-sg' => FerryTerminal::create([
                'slug' => 'tanah-merah-sg',
                'name' => 'Tanah Merah Ferry Terminal (Singapore)',
                'latitude' => 1.3142,
                'longitude' => 103.9882,
                'description' => 'Pintu gerbang feri timur Singapura (dekat Changi) menuju Nongsa Pura & Batam Centre.'
            ]),
        ];

        // 3. 49 Cross-Border Destination Places (Batam & Singapore)
        $placesData = [
            // ==========================================
            // 🏥 RUMAH SAKIT & PUSAT MEDIS BATAM (INDONESIA)
            // ==========================================
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'batam-centre',
                'name' => 'RS Awal Bros Batam — Executive Health Centre',
                'description' => 'Pusat layanan kesehatan medis terkemuka di Batam dengan dokter spesialis lulusan luar negeri, paket EKG, MRI 1.5 Tesla, CT-Scan 128 Slice, dan konsultasi cepat.',
                'address' => 'Jl. Gajah Mada No.1, Batam Kota',
                'latitude' => 1.1278,
                'longitude' => 104.0412,
                'price_sgd' => 280.00,
                'savings_percent' => 68,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'sekupang',
                'name' => 'RS BP Batam (RS Otorita Batam) — Cardiovascular & Hyperbaric',
                'description' => 'Rumah sakit pemerintah BP Batam berstandar internasional di Sekupang, pusat unggulan kateterisasi jantung (Cath Lab), ruang terapi hiperbarik oksigen, dan trauma centre 24 jam.',
                'address' => 'Jl. Dr. Ciptomangunkusumo No.1, Sekupang',
                'latitude' => 1.1215,
                'longitude' => 103.9310,
                'price_sgd' => 220.00,
                'savings_percent' => 72,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'batam-centre',
                'name' => 'RS Budi Kemuliaan Batam — International Eye & Vision Centre',
                'description' => 'Pusat perawatan mata modern di Batam untuk operasi katarak Phacoemulsifikasi, LASIK presisi, bedah retina, serta poliklinik spesialis penyakit dalam dan hemodialisa.',
                'address' => 'Jl. Budi Kemuliaan No.1, Kampung Seraya',
                'latitude' => 1.1350,
                'longitude' => 104.0180,
                'price_sgd' => 240.00,
                'savings_percent' => 65,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'batam-centre',
                'name' => 'RS Santa Elisabeth Batam Kota — Executive Diagnostic Hub',
                'description' => 'Rumah sakit swasta modern di kawasan Batam Centre dengan layanan Medical Checkup eksekutif, rawat inap VIP berstandar hotel, pusat kebidanan, dan laboratorium patologi terpadu.',
                'address' => 'Jl. Raja Alikelana, Batam Kota',
                'latitude' => 1.1240,
                'longitude' => 104.0510,
                'price_sgd' => 260.00,
                'savings_percent' => 66,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbour-bay',
                'name' => 'RS Santa Elisabeth Blok II Nagoya',
                'description' => 'Rumah sakit terpercaya di pusat kawasan bisnis Nagoya Lubuk Baja. Akses sangat cepat dari Pelabuhan Feri Harbour Bay untuk pemeriksaan medis darurat dan rawat jalan.',
                'address' => 'Jl. Anggrek Blok II, Lubuk Baja, Nagoya',
                'latitude' => 1.1420,
                'longitude' => 104.0125,
                'price_sgd' => 210.00,
                'savings_percent' => 70,
                'rating' => 4.7,
                'image_url' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbour-bay',
                'name' => 'RS Harapan Bunda Batam (RSHB) — Orthopaedic & Surgery',
                'description' => 'Rumah sakit rujukan ternama di kawasan Seraya dengan keunggulan bedah ortopedi tulang & sendi, poliklinik saraf, bedah digestif, dan instalasi gawat darurat 24 jam.',
                'address' => 'Jl. Seraya No.1, Batu Ampar',
                'latitude' => 1.1390,
                'longitude' => 104.0195,
                'price_sgd' => 230.00,
                'savings_percent' => 68,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'sekupang',
                'name' => 'RSUD Embung Fatimah Batam — Regional Tertiary Referral',
                'description' => 'Rumah sakit umum daerah tipe B terbesar milik Pemko Batam di Batu Aji dengan 350+ bed, layanan spesialis lengkap, pusat hemodialisa, dan ruang isolasi bertekanan negatif.',
                'address' => 'Jl. R. Soeprapto Blok D No. 1-9, Batu Aji',
                'latitude' => 1.0550,
                'longitude' => 103.9850,
                'price_sgd' => 150.00,
                'savings_percent' => 78,
                'rating' => 4.6,
                'image_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'sekupang',
                'name' => 'RS Graha Hermine Batam — Endoscopy & General Surgery',
                'description' => 'Rumah sakit swasta modern melayani Medical Checkup, endoskopi saluran cerna, bedah laparoskopi minimal invasif, poliklinik anak, dan farmasi 24 jam.',
                'address' => 'Komplek Ruko Graha Hermine, Batu Aji',
                'latitude' => 1.0520,
                'longitude' => 103.9920,
                'price_sgd' => 180.00,
                'savings_percent' => 72,
                'rating' => 4.7,
                'image_url' => 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'nongsa',
                'name' => 'RS Soedarsono Darmosoewito (RS Kabil Nongsa)',
                'description' => 'Rumah sakit rujukan terdekat kawasan timur Batam & Nongsa dengan layanan trauma kecelakaan kerja, instalasi radiologi, poliklinik dokter spesialis, dan kamar VIP.',
                'address' => 'Jl. Hang Kesturi No. 1, Kabil, Nongsa',
                'latitude' => 1.1180,
                'longitude' => 104.1350,
                'price_sgd' => 170.00,
                'savings_percent' => 72,
                'rating' => 4.7,
                'image_url' => 'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'nongsa',
                'name' => 'RS Bhayangkara Batam — Polda Kepri Medical Center',
                'description' => 'Rumah sakit kepolisian modern di Batu Besar Nongsa, melayani masyarakat umum dan wisatawan dengan fasilitas IGD 24 jam, ICU terpadu, dan dokter spesialis bedah.',
                'address' => 'Jl. Dang Merdu No.2, Batu Besar, Nongsa',
                'latitude' => 1.1550,
                'longitude' => 104.0950,
                'price_sgd' => 160.00,
                'savings_percent' => 74,
                'rating' => 4.7,
                'image_url' => 'https://images.unsplash.com/photo-1587745416684-47953f16f02f?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'dental',
                'terminal_slug' => 'harbour-bay',
                'name' => 'Nagoya Dental Wellness Centre',
                'description' => 'Spesialis pembersihan karang gigi, veneer estetik porcelain, mahkota gigi (crown), dan pemutihan gigi laser dengan standar kebersihan tertinggi.',
                'address' => 'Komplek Nagoya Hill Blok A No. 12',
                'latitude' => 1.1445,
                'longitude' => 104.0112,
                'price_sgd' => 180.00,
                'savings_percent' => 72,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'dental',
                'terminal_slug' => 'batam-centre',
                'name' => 'Batam International Dental & Orthodontic Clinic',
                'description' => 'Klinik ortodonti dan gigi estetik terpadu di Batam Centre: perawatan Invisalign, bleaching gigi US standard, implan titanium, dan dental digital X-Ray panoramik.',
                'address' => 'Ruko Mahkota Raya Blok B No. 8, Batam Centre',
                'latitude' => 1.1310,
                'longitude' => 104.0450,
                'price_sgd' => 160.00,
                'savings_percent' => 75,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbour-bay',
                'name' => 'Aesthetic Skin & Laser Clinic Nagoya',
                'description' => 'Perawatan wajah Botox, Filler, Laser Pico, HIFU Facelift, dan Anti-Aging oleh dokter dermatologi bersertifikasi internasional.',
                'address' => 'Komplek Penuin Centre Blok C No. 5, Nagoya',
                'latitude' => 1.1410,
                'longitude' => 104.0150,
                'price_sgd' => 120.00,
                'savings_percent' => 65,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=800&q=80'
            ],

            // ==========================================
            // 🇸🇬 RUMAH SAKIT UTAMA SINGAPURA (SINGAPORE)
            // ==========================================
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Mount Elizabeth Hospital Orchard (Singapore)',
                'description' => 'Rumah sakit swasta paling terkemuka di Asia Tenggara untuk kardiologi lanjutan, transplantasi organ, onkologi, bedah saraf, dan kedokteran presisi.',
                'address' => '3 Mount Elizabeth, Singapore 228510',
                'latitude' => 1.3048,
                'longitude' => 103.8354,
                'price_sgd' => 880.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1504813184591-01572f98c85f?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Mount Elizabeth Novena Hospital (Singapore)',
                'description' => 'Rumah sakit swasta ultra-modern di Novena dengan fasilitas kamar single privat mewah, bedah robotik Da Vinci Xi, dan 250+ dokter spesialis internasional.',
                'address' => '38 Irrawaddy Rd, Singapore 329563',
                'latitude' => 1.3210,
                'longitude' => 103.8440,
                'price_sgd' => 920.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Gleneagles Hospital (Napier / Tanglin, Singapore)',
                'description' => 'Rumah sakit swasta prestisius dekat Botanic Gardens Singapura, pusat rujukan transplantasi hati, bedah digestif, ginekologi, dan pediatri.',
                'address' => '6A Napier Rd, Singapore 258500',
                'latitude' => 1.3075,
                'longitude' => 103.8190,
                'price_sgd' => 850.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1533042789716-e9a9c97cf4ee?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Singapore General Hospital (SGH) & Outram Campus',
                'description' => 'Rumah sakit tersier akademik terbesar dan tertua di Singapura (dinobatkan Newsweek sebagai salah satu RS terbaik di dunia), mencakup National Heart Centre dan Cancer Centre.',
                'address' => 'Outram Rd, Singapore 169608',
                'latitude' => 1.2790,
                'longitude' => 103.8340,
                'price_sgd' => 680.00,
                'savings_percent' => 0,
                'rating' => 5.0,
                'image_url' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'National University Hospital (NUH, Singapore)',
                'description' => 'Pusat medis universitas terkemuka Singapura dengan National University Cancer Institute (NCIS), National University Heart Centre (NUCS), dan pusat transplantasi ginjal & hati.',
                'address' => '5 Lower Kent Ridge Rd, Singapore 119074',
                'latitude' => 1.2938,
                'longitude' => 103.7830,
                'price_sgd' => 650.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Raffles Hospital (Bugis Downtown, Singapore)',
                'description' => 'Rumah sakit swasta terpadu berstandar internasional di pusat kota Bugis Singapura, melayani pasien mancanegara dengan 35+ pusat spesialisasi kedokteran.',
                'address' => '585 North Bridge Rd, Singapore 188770',
                'latitude' => 1.3008,
                'longitude' => 103.8582,
                'price_sgd' => 790.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Tan Tock Seng Hospital (TTSH) & NCID (Singapore)',
                'description' => 'Salah satu rumah sakit rujukan tersier publik terbesar Singapura dengan pusat trauma regional, spesialis geriatri, rehabilitasi stroke, dan National Centre for Infectious Diseases.',
                'address' => '11 Jln Tan Tock Seng, Singapore 308433',
                'latitude' => 1.3214,
                'longitude' => 103.8458,
                'price_sgd' => 620.00,
                'savings_percent' => 0,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'tanah-merah-sg',
                'name' => 'Parkway East Hospital (Joo Chiat / East Coast SG)',
                'description' => 'Rumah sakit swasta komprehensif di kawasan timur Singapura (dekat Changi) dengan keunggulan bedah THT, ortopedi, kebidanan, pediatri, dan poliklinik 24 jam.',
                'address' => '321 Joo Chiat Pl, Singapore 427990',
                'latitude' => 1.3145,
                'longitude' => 103.9060,
                'price_sgd' => 720.00,
                'savings_percent' => 0,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'KK Women’s and Children’s Hospital (KKH, Singapore)',
                'description' => 'Rumah sakit rujukan tersier khusus wanita, kebidanan, fertilitas IVF, dan kesehatan anak terbesar di Singapura dengan tim dokter sub-spesialis terkemuka.',
                'address' => '100 Bukit Timah Rd, Singapore 229899',
                'latitude' => 1.3105,
                'longitude' => 103.8470,
                'price_sgd' => 580.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'medical',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Farrer Park Hospital & Medical Centre (Singapore)',
                'description' => 'Konsep inovatif rumah sakit modern terintegrasi dengan hotel One Farrer, pusat onkologi canggih, bedah kardiologi, dan suites pemulihan berstandar hotel mewah.',
                'address' => '1 Farrer Park Station Rd, Singapore 217562',
                'latitude' => 1.3120,
                'longitude' => 103.8540,
                'price_sgd' => 820.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80'
            ],

            // ==========================================
            // 🏖️ WISATA, PANTAI, KAFE HITS & SEAFOOD
            // ==========================================
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'batam-centre',
                'name' => 'Mula Cafe & Eatery Batam Centre',
                'description' => 'Kafe hits viral bernuansa modern minimalis estetik di Batam Centre. Menyajikan specialty coffee, artisan pasta, croffle lumer, dan signature mocktail.',
                'address' => 'Komplek Ruko Palm Spring, Batam Centre',
                'latitude' => 1.1325,
                'longitude' => 104.0430,
                'price_sgd' => 14.00,
                'savings_percent' => 65,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'batam-centre',
                'name' => 'Pantai Elyora Barelang (Jembatan 6 Batam)',
                'description' => 'Pantai pasir putih terindah dan terjernih di Batam (Jembatan 6 Barelang) dengan gradasi air laut toska, pohon mangrove estetik, dan spot foto instagramable.',
                'address' => 'Galang Baru, Jembatan 6 Barelang',
                'latitude' => 0.8120,
                'longitude' => 104.1890,
                'price_sgd' => 15.00,
                'savings_percent' => 80,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbour-bay',
                'name' => 'Malaya Cafe & Kopitiam Toast Nagoya',
                'description' => 'Kopitiam legendaris favorit warga lokal dan turis SG di Nagoya. Terkenal dengan Roti Bakar Kaya Butter lumer, Kopi O mantap, dan Laksa Seafood Batam.',
                'address' => 'Komplek Nagoya City Centre Blok B No. 3',
                'latitude' => 1.1430,
                'longitude' => 104.0145,
                'price_sgd' => 8.00,
                'savings_percent' => 70,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'culinary',
                'terminal_slug' => 'batam-centre',
                'name' => 'Restoran Seafood Kelong Barelang 168',
                'description' => 'Wisata santapan laut segar di atas kelong tradisional Jembatan Barelang: kepiting saus lada hitam, gonggong khas Kepri, dan lobster hidup.',
                'address' => 'Tembesi, Jembatan 1 Barelang',
                'latitude' => 1.0020,
                'longitude' => 104.0410,
                'price_sgd' => 35.00,
                'savings_percent' => 65,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1559742811-822873691df8?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'culinary',
                'terminal_slug' => 'harbour-bay',
                'name' => 'Harbour Bay Seafood Waterfront Restaurant',
                'description' => 'Restoran live seafood tepi laut tepat di samping terminal feri Harbour Bay. Pemandangan kapal feri dan gemerlap lampu malam Singapura.',
                'address' => 'The Promenade Harbour Bay Downtown',
                'latitude' => 1.1565,
                'longitude' => 104.0055,
                'price_sgd' => 40.00,
                'savings_percent' => 60,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'batam-centre',
                'name' => 'Pantai Viovio & Sunset Beach Club Barelang',
                'description' => 'Destinasi pantai pasir putih hits di Jembatan 5 Barelang dengan ayunan laut estetik, gazebo tebing sunset, dan pertunjukan acoustic live.',
                'address' => 'Pulau Rempang, Jembatan 5 Barelang',
                'latitude' => 0.9320,
                'longitude' => 104.1480,
                'price_sgd' => 18.00,
                'savings_percent' => 75,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'nongsa',
                'name' => 'Nongsa Beach & Palm Bay Watersports',
                'description' => 'Pantai eksklusif dengan pasir putih landai, wahana Jet Ski, Banana Boat, Wakeboarding, dan pemandangan gedung pencakar langit Singapura.',
                'address' => 'Kawasan Wisata Pantai Nongsa, Batam',
                'latitude' => 1.1890,
                'longitude' => 104.1050,
                'price_sgd' => 30.00,
                'savings_percent' => 70,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'batam-centre',
                'name' => 'Anchor Cafe & Roastery Batam Centre',
                'description' => 'Kafe roastery kopi artisan terpopuler di Batam dengan biji kopi pilihan Indonesia, American Southern breakfast, freshly baked pies, dan suasana estetik.',
                'address' => 'Komplek Dermaga Sukajadi Blok RF No. 1',
                'latitude' => 1.1290,
                'longitude' => 104.0380,
                'price_sgd' => 12.00,
                'savings_percent' => 65,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbour-bay',
                'name' => 'Level Up Floating Bar & Sunset Lounge Harbour Bay',
                'description' => 'Spot nongkrong terapung tepi laut paling hits di Harbour Bay Downtown dengan mocktail/cocktail spesial, live DJ sunset, dan suasana romantis.',
                'address' => 'Harbour Bay Waterfront Promenade Blok A No. 1',
                'latitude' => 1.1570,
                'longitude' => 104.0048,
                'price_sgd' => 22.00,
                'savings_percent' => 68,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'batam-centre',
                'name' => 'One Batam Mall & Sky Garden Promenade',
                'description' => 'Pusat perbelanjaan dan rekreasi modern terbesar di Batam dengan area outdoor Sky Garden, aneka kafe hits, bioskop IMAX, dan spot belanja internasional.',
                'address' => 'Jl. Raja M. Tahir No.1, Teluk Tering, Batam Kota',
                'latitude' => 1.1298,
                'longitude' => 104.0485,
                'price_sgd' => 20.00,
                'savings_percent' => 60,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1519567241046-7f570eee3ce6?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'batam-centre',
                'name' => 'De’Sands Cafe & Bar Santorini Style Batam',
                'description' => 'Kafe bergaya arsitektur kubah biru putih Santorini Yunani yang super instagramable dengan rooftop sunset view dan aneka dessert fusion.',
                'address' => 'Kawasan Golden City Bengkong, Batam',
                'latitude' => 1.1380,
                'longitude' => 104.0320,
                'price_sgd' => 15.00,
                'savings_percent' => 70,
                'rating' => 4.7,
                'image_url' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Coach Play Singapore Shophouse & Cafe (Keong Saik SG)',
                'description' => 'Konsep shophouse 3 lantai pertama di dunia dari Coach dengan kafe bernuansa retro New York, signature American desserts, milkshake, dan spot foto viral.',
                'address' => '5 Keong Saik Rd., Singapore 089113',
                'latitude' => 1.2805,
                'longitude' => 103.8415,
                'price_sgd' => 24.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1521017432531-fbd92d768814?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'PS.Cafe at Harding Road (Dempsey Hill Singapore)',
                'description' => 'Kafe paling legendaris di Dempsey Hill tersembunyi di tengah hutan tropis rindang dengan dinding kaca raksasa, Truffle Shoestring Fries ikonik, dan kue sticky date pudding.',
                'address' => '28B Harding Rd, Singapore 249549',
                'latitude' => 1.3032,
                'longitude' => 103.8080,
                'price_sgd' => 36.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Chye Seng Huat Hardware Cafe (Jalan Besar SG)',
                'description' => 'Kafe spesialis artisan coffee berkonsep bekas gedung bengkel perkakas hardware dengan 360° circular coffee bar dan outdoor courtyard yang artistik.',
                'address' => '150 Tyrwhitt Rd, Singapore 207563',
                'latitude' => 1.3118,
                'longitude' => 103.8601,
                'price_sgd' => 18.00,
                'savings_percent' => 0,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Merlion Park & Marina Bay Waterfront (Singapore)',
                'description' => 'Landmark nomor 1 Singapura dengan patung Merlion ikonik menghadap Marina Bay, gemerlap lampu malam Spectra Light & Water Show, dan waterfront cafe promenade.',
                'address' => '1 Fullerton Rd, Singapore 049213',
                'latitude' => 1.2868,
                'longitude' => 103.8545,
                'price_sgd' => 15.00,
                'savings_percent' => 0,
                'rating' => 5.0,
                'image_url' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Sentosa Skyline Luge & Cable Car Experience (Singapore)',
                'description' => 'Wahana meluncur seru 4 lintasan sirkuit gravitasi menuruni bukit tropis Sentosa serta pemandangan spektakuler Selat Singapura dari Singapore Cable Car.',
                'address' => '45 Siloso Beach Walk, Sentosa, Singapore 099003',
                'latitude' => 1.2540,
                'longitude' => 103.8180,
                'price_sgd' => 35.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Marina Bay Sands SkyPark & Observation Lounge (Singapore)',
                'description' => 'Destinasi wisata ikonik dunia di lantai 57 Marina Bay Sands dengan panorama cakrawala Singapura 360 derajat dan spot sunset spektakuler.',
                'address' => '10 Bayfront Ave, Singapore 018956',
                'latitude' => 1.2834,
                'longitude' => 103.8607,
                'price_sgd' => 38.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Tanjong Beach Club & Siloso Beach Sentosa (Singapore)',
                'description' => 'Klub pantai tropis terpopuler di Pulau Sentosa Singapura dengan kolam renang infinity tepi pantai, daybed mewah, burger artisan, dan sunset cocktail.',
                'address' => '120 Tanjong Beach Walk, Singapore 098942',
                'latitude' => 1.2460,
                'longitude' => 103.8260,
                'price_sgd' => 65.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Haji Lane & Arab Street Artisan Coffee Spots (Singapore)',
                'description' => 'Gang seni paling trendi di Singapura penuh mural warna-warni, kafe spesialis cold brew, boutique unik, dan live music malam hari.',
                'address' => 'Haji Lane, Kampong Glam, Singapore',
                'latitude' => 1.3005,
                'longitude' => 103.8590,
                'price_sgd' => 16.00,
                'savings_percent' => 0,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1534430480872-3498386e7856?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'tanah-merah-sg',
                'name' => 'Jewel Changi Rain Vortex & Canopy Park (Singapore)',
                'description' => 'Air terjun indoor tertinggi di dunia (HSBC Rain Vortex setinggi 40m) dikelilingi hutan kanopi tropis Shiseido Forest Valley.',
                'address' => '78 Airport Blvd., Singapore 819666',
                'latitude' => 1.3602,
                'longitude' => 103.9898,
                'price_sgd' => 25.00,
                'savings_percent' => 0,
                'rating' => 5.0,
                'image_url' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'tourism',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Atlas Bar & Grand Lounge Bugis (Singapore)',
                'description' => 'Lounge bergaya Art Deco Eropa di gedung Parkview Square (Gotham Building) dengan koleksi gin tower termegah di Asia dan paket afternoon tea mewah.',
                'address' => '600 North Bridge Rd, Parkview Square, Singapore 188778',
                'latitude' => 1.3001,
                'longitude' => 103.8576,
                'price_sgd' => 48.00,
                'savings_percent' => 0,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1572116469696-31de0f17cc34?auto=format&fit=crop&w=800&q=80'
            ],

            // ==========================================
            // 💆‍♀️ WELLNESS, SPA & ⛳ GOLF RESORTS
            // ==========================================
            [
                'category_slug' => 'spa',
                'terminal_slug' => 'harbour-bay',
                'name' => 'Royal Heritage Spa & Wellness Resort',
                'description' => 'Pijat tradisional Nusantara, scrub rempah herbal, dan terapi pijat batu hangat selama 120 menit untuk relaksasi tubuh pasca-rutinitas kerja.',
                'address' => 'Kawasan Harbour Bay Waterfront Blok B No. 8',
                'latitude' => 1.1512,
                'longitude' => 104.0090,
                'price_sgd' => 45.00,
                'savings_percent' => 70,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'spa',
                'terminal_slug' => 'nongsa',
                'name' => 'Batam View Oceanfront Beach Spa Nongsa',
                'description' => 'Terapi spa relaksasi tepi laut dengan pemandangan Selat Singapura, scrub kelapa murni, mandi rempah, dan privat infinity pool.',
                'address' => 'Jl. Hang Lekiu, Sambau, Nongsa',
                'latitude' => 1.1880,
                'longitude' => 104.1150,
                'price_sgd' => 55.00,
                'savings_percent' => 68,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'golf',
                'terminal_slug' => 'nongsa',
                'name' => 'Palm Springs Golf & Beach Resort Nongsa',
                'description' => 'Lapangan golf bertaraf internasional dengan pemandangan Selat Singapura, lengkap dengan caddie profesional dan fasilitas clubhouse mewah.',
                'address' => 'Jl. Hang Lekiu - Nongsa, Batam',
                'latitude' => 1.1920,
                'longitude' => 104.1080,
                'price_sgd' => 130.00,
                'savings_percent' => 60,
                'rating' => 4.9,
                'image_url' => 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'golf',
                'terminal_slug' => 'sekupang',
                'name' => 'Southlinks Country Club & Resort Batam',
                'description' => 'Lapangan golf perbukitan hijau dengan pemandangan danau alami, night golfing, driving range, dan vila resort keluarga.',
                'address' => 'Jl. Gajah Mada KM 9, Tiban Indah, Sekupang',
                'latitude' => 1.1080,
                'longitude' => 103.9850,
                'price_sgd' => 110.00,
                'savings_percent' => 62,
                'rating' => 4.8,
                'image_url' => 'https://images.unsplash.com/photo-1592919505780-303950717480?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'category_slug' => 'golf',
                'terminal_slug' => 'harbourfront-sg',
                'name' => 'Sentosa Golf Club & Serapong Championship Course (Singapore)',
                'description' => 'Salah satu lapangan golf terbaik di dunia tuan rumah SMBC Singapore Open dengan pemandangan megah waterfront & skyline Singapura.',
                'address' => '27 Bukit Manis Rd, Sentosa, Singapore 099892',
                'latitude' => 1.2480,
                'longitude' => 103.8290,
                'price_sgd' => 420.00,
                'savings_percent' => 0,
                'rating' => 5.0,
                'image_url' => 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        foreach ($placesData as $data) {
            $cat = $categories[$data['category_slug']] ?? $categories['medical'];
            $terminal = $terminals[$data['terminal_slug']] ?? null;

            $place = Place::create([
                'category_id' => $cat->id,
                'ferry_terminal_id' => $terminal ? $terminal->id : null,
                'name' => $data['name'],
                'description' => $data['description'],
                'address' => $data['address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'price_sgd' => $data['price_sgd'],
                'savings_percent' => $data['savings_percent'],
                'rating' => $data['rating'],
                'image_url' => $data['image_url']
            ]);

            // Update PostGIS Spatial location Point if column exists
            if (DB::getDriverName() === 'pgsql') {
                try {
                    if (Schema::hasColumn('places', 'location')) {
                        DB::statement("UPDATE places SET location = ST_SetSRID(ST_MakePoint(?, ?), 4326) WHERE id = ?", [
                            $data['longitude'],
                            $data['latitude'],
                            $place->id
                        ]);
                    }
                } catch (\Throwable $e) {
                    // ignore if PostGIS functions are not active
                }
            }
        }
    }
}
