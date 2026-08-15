<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Place;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $awalBros = Place::where('name', 'like', '%Awal Bros%')->first();
        $nagoyaDental = Place::where('name', 'like', '%Nagoya Dental%')->first();
        $royalSpa = Place::where('name', 'like', '%Royal Heritage%')->first();
        $palmSprings = Place::where('name', 'like', '%Palm Springs%')->first();

        $reviews = [
            [
                'place_id' => $awalBros ? $awalBros->id : null,
                'category_slug' => 'medical',
                'user_name' => 'Marcus Tan (陈伟杰)',
                'user_location' => 'Tanjong Pagar, Singapore 🇸🇬',
                'user_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
                'treatment_name' => 'Executive Comprehensive Health Screening + Cardiac MRI',
                'rating' => 5.0,
                'cost_saved_sgd' => 640.00,
                'spent_sgd' => 280.00,
                'comment' => 'Did the full executive screening at RS Awal Bros. In Singapore private hospitals, a comparable MRI + blood panel costs upwards of $920 SGD. Here it was top-notch, fluent English doctor, VIP pickup from Batam Centre terminal was right on time. Highly recommended for Singaporeans wanting quick, affordable medical diagnostics!',
                'ferry_route' => 'HarbourFront SG ⇄ Batam Centre (60 min)',
                'is_verified' => true,
                'helpful_count' => 38,
            ],
            [
                'place_id' => $nagoyaDental ? $nagoyaDental->id : null,
                'category_slug' => 'dental',
                'user_name' => 'Rachel Lim & Jason',
                'user_location' => 'Jurong East, Singapore 🇸🇬',
                'user_avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&q=80',
                'treatment_name' => 'Porcelain Veneers & Laser Teeth Whitening (2 Pax)',
                'rating' => 4.9,
                'cost_saved_sgd' => 850.00,
                'spent_sgd' => 360.00,
                'comment' => 'Took the 45-min ferry from HarbourFront to Harbour Bay. The clinic is 5 minutes away by Grab. The dental hygiene and 3D imaging equipment are German-standard. Saved more than $850 SGD for two people compared to clinics in Orchard Road!',
                'ferry_route' => 'HarbourFront SG ⇄ Harbour Bay (45 min)',
                'is_verified' => true,
                'helpful_count' => 54,
            ],
            [
                'place_id' => $royalSpa ? $royalSpa->id : null,
                'category_slug' => 'spa',
                'user_name' => 'Evelyn Ng',
                'user_location' => 'Bishan, Singapore 🇸🇬',
                'user_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80',
                'treatment_name' => '120-min Royal Herbal Scrub & Hot Stone Aromatherapy',
                'rating' => 4.9,
                'cost_saved_sgd' => 135.00,
                'spent_sgd' => 45.00,
                'comment' => 'A 2-hour luxury spa session in Singapore easily runs $180+ SGD before GST. Royal Heritage Spa provided pure authentic Nusantara herbs and soothing massage. Perfect weekend wellness escape from the CBD hustle.',
                'ferry_route' => 'HarbourFront SG ⇄ Harbour Bay (45 min)',
                'is_verified' => true,
                'helpful_count' => 29,
            ],
            [
                'place_id' => $palmSprings ? $palmSprings->id : null,
                'category_slug' => 'golf',
                'user_name' => 'David & Golf Buddies',
                'user_location' => 'Katong / Marine Parade, Singapore 🇸🇬',
                'user_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
                'treatment_name' => '18-Hole Weekend Championship Green Fee + Buggy + Caddie',
                'rating' => 5.0,
                'cost_saved_sgd' => 290.00,
                'spent_sgd' => 130.00,
                'comment' => 'Departed from Tanah Merah directly to Nongsa Pura (only 35 mins!). The golf course condition is pristine with sea breeze overlooking Singapore strait. Playing 18 holes in Singapore on a weekend is impossible without club membership or paying $400+ SGD. Batam is unbeatable value.',
                'ferry_route' => 'Tanah Merah SG ⇄ Nongsa Pura (35 min)',
                'is_verified' => true,
                'helpful_count' => 47,
            ],
            [
                'place_id' => null,
                'category_slug' => 'culinary',
                'user_name' => 'Kenny Koh',
                'user_location' => 'Sengkang, Singapore 🇸🇬',
                'user_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
                'treatment_name' => 'Live Black Pepper Crab & Seafood Kelong Feast',
                'rating' => 4.8,
                'cost_saved_sgd' => 110.00,
                'spent_sgd' => 35.00,
                'comment' => 'Fresh live seafood over the ocean water at Barelang. Black pepper crab and local steamed gonggong are fresh and super cheap compared to East Coast Seafood Centre in Singapore.',
                'ferry_route' => 'HarbourFront SG ⇄ Batam Centre (60 min)',
                'is_verified' => true,
                'helpful_count' => 22,
            ],
            [
                'place_id' => $nagoyaDental ? $nagoyaDental->id : null,
                'category_slug' => 'dental',
                'user_name' => 'Dr. Andrew Teo',
                'user_location' => 'Novena, Singapore 🇸🇬',
                'user_avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=150&q=80',
                'treatment_name' => 'Laser Scaling + Zirconia Crown Replacement',
                'rating' => 5.0,
                'cost_saved_sgd' => 720.00,
                'spent_sgd' => 220.00,
                'comment' => 'As a healthcare worker in SG myself, I was impressed by the sterilization protocol and autoclave standards at Nagoya Dental. Smooth booking through BatamPulse with prompt WhatsApp assistance.',
                'ferry_route' => 'HarbourFront SG ⇄ Harbour Bay (45 min)',
                'is_verified' => true,
                'helpful_count' => 61,
            ]
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }
    }
}
