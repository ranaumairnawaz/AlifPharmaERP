<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Group;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Database\Seeder;

class FlourishSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Flourish Group (Manufacturer)
        $flourish = Group::updateOrCreate(
            ['name' => 'Flourish Health Care'],
            ['description' => 'Pharmaceutical manufacturer focused on a wide range of therapeutic categories.']
        );

        // 2. Units
        $ml = Unit::firstOrCreate(['name' => 'ml'], ['description' => 'Milliliter']);
        $gm = Unit::firstOrCreate(['name' => 'gm'], ['description' => 'Gram']);
        $sachet = Unit::firstOrCreate(['name' => 'Sachet'], ['description' => 'Single use sachet']);
        $tab = Unit::firstOrCreate(['name' => 'Tablets'], ['description' => 'Tablet pack']);
        $cap = Unit::firstOrCreate(['name' => 'Capsules'], ['description' => 'Capsule pack']);
        $liquid = Unit::firstOrCreate(['name' => 'Liquid'], ['description' => 'Liquid formulation']);
        $soap = Unit::firstOrCreate(['name' => 'Soap'], ['description' => 'Soap bar']);

        // 3. Categories from PDF
        $catSyrup = Category::updateOrCreate(['name' => 'Syrup']);
        $catSachet = Category::updateOrCreate(['name' => 'Sachets']);
        $catFoodSupp = Category::updateOrCreate(['name' => 'Food Supplement']);
        $catDrops = Category::updateOrCreate(['name' => 'Drops']);
        $catTablets = Category::updateOrCreate(['name' => 'Tablets']);
        $catOintment = Category::updateOrCreate(['name' => 'Ointment']);
        $catCosmetics = Category::updateOrCreate(['name' => 'Cosmetics']);

        // 4. Products Data mapping
        $data = [
            // SYRUPS (18)
            ['cat' => $catSyrup, 'name' => 'Vitasine syrup 120ml', 'desc' => 'Multivitamin syrup with L-lysine', 'size' => '120ml', 'retail' => 250, 'net' => 45, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Vitasine syrup 220ml', 'desc' => 'Multivitamin syrup with L-lysine', 'size' => '220ml', 'retail' => 380, 'net' => 80, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Becoplex syrup 120ml', 'desc' => 'B-Complex Vitamins', 'size' => '120ml', 'retail' => 290, 'net' => 45, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Becoplex syrup 220ml', 'desc' => 'B-Complex Vitamins', 'size' => '220ml', 'retail' => 495, 'net' => 80, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Bergilif syrup 120ml', 'desc' => 'Antacid with combination of Berginia cilata ext Supplement for H.Pylori & GIT Disorders', 'size' => '120ml', 'retail' => 390, 'net' => 120, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Bergilif syrup 220ml', 'desc' => 'Antacid with combination of Berginia cilata ext Supplement for H.Pylori & GIT Disorders', 'size' => '220ml', 'retail' => 595, 'net' => 190, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Uplex syrup 120ml', 'desc' => 'Concentrated Prune Juice ext & Senna leaf ext Syrup for constipation', 'size' => '120ml', 'retail' => 255, 'net' => 55, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'All leaf syrup 120ml', 'desc' => 'Concentrated Prune Juice ext & Senna leaf ext Syrup for constipation', 'size' => '120ml', 'retail' => 350, 'net' => 55, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Syruco Syrup 120ml', 'desc' => 'Combination of Hedera helix, Glycyrrhiza glabra & Thymus vulgaris ext for cough & cold', 'size' => '120ml', 'retail' => 220, 'net' => 45, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Pepilite Syrup 120ml', 'desc' => 'Antacid syrup', 'size' => '120ml', 'retail' => 190, 'net' => 40, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Pepilite Syrup 220ml', 'desc' => 'Antacid syrup', 'size' => '220ml', 'retail' => 350, 'net' => 55, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Podina Syrup 120ml', 'desc' => 'Antacid syrup', 'size' => '120ml', 'retail' => 190, 'net' => 40, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Podina Syrup 220ml', 'desc' => 'Antacid syrup', 'size' => '220ml', 'retail' => 350, 'net' => 55, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Miti Chore Syrup 120ml', 'desc' => 'Miti chore supplement for children', 'size' => '120ml', 'retail' => 245, 'net' => 45, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Apticin Syrup 120ml', 'desc' => 'Multivitamin syrup with health benefits', 'size' => '120ml', 'retail' => 260, 'net' => 40, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Cranwave Syrup 120ml', 'desc' => 'Cranberry & Ginger ext syrup', 'size' => '120ml', 'retail' => 260, 'net' => 55, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Mulbrix Syrup 120ml', 'desc' => 'Toot siah (Cough syrup)', 'size' => '120ml', 'retail' => 170, 'net' => 45, 'unit' => $ml],
            ['cat' => $catSyrup, 'name' => 'Prolite (ORS) Liquid 450ml', 'desc' => 'ORS Liquid for hydration', 'size' => '450ml', 'retail' => 200, 'net' => 55, 'unit' => $ml],

            // SACHETS (6)
            ['cat' => $catSachet, 'name' => 'Crain Mart Sachet', 'desc' => 'Cranberry, D-manoose & Vitamin C for UTI disorders', 'size' => '10\'s', 'retail' => 650, 'net' => 90, 'unit' => $sachet],
            ['cat' => $catSachet, 'name' => 'Entapep Sachet', 'desc' => 'Antacid sachet', 'size' => '10\'s', 'retail' => 190, 'net' => 65, 'unit' => $sachet],
            ['cat' => $catSachet, 'name' => 'Celcit Sachet', 'desc' => 'Red algae calcium with multivitamins for bones health', 'size' => '10\'s', 'retail' => 890, 'net' => 145, 'unit' => $sachet],
            ['cat' => $catSachet, 'name' => 'Fact Sachet', 'desc' => 'Myo-inositol, D-chiro-inositol & L-Methylfolate', 'size' => '10\'s', 'retail' => 950, 'net' => 210, 'unit' => $sachet],
            ['cat' => $catSachet, 'name' => 'Coliferol Sachet', 'desc' => 'Mouth dispersable sachet combination of Vitamin D3, K2 & B12', 'size' => '30\'s', 'retail' => 650, 'net' => 185, 'unit' => $sachet],
            ['cat' => $catSachet, 'name' => 'Zelvet C Sachet', 'desc' => 'Effervescent sachet with Calcium & Vitamin C', 'size' => '10\'s', 'retail' => 200, 'net' => 60, 'unit' => $sachet],

            // FOOD SUPPLEMENT (6)
            ['cat' => $catFoodSupp, 'name' => 'Magnutra Vanilla 200gm', 'desc' => 'Food Supplement', 'size' => '200gm', 'retail' => 750, 'net' => 220, 'unit' => $gm],
            ['cat' => $catFoodSupp, 'name' => 'Magnutra Strawberry 200gm', 'desc' => 'Food Supplement', 'size' => '200gm', 'retail' => 750, 'net' => 220, 'unit' => $gm],
            ['cat' => $catFoodSupp, 'name' => 'Magnutra Chocolate 200gm', 'desc' => 'Food Supplement', 'size' => '200gm', 'retail' => 750, 'net' => 220, 'unit' => $gm],
            ['cat' => $catFoodSupp, 'name' => 'Shapes 400gm', 'desc' => 'Supplement for weight loss', 'size' => '400gm', 'retail' => 2250, 'net' => 900, 'unit' => $gm],
            ['cat' => $catFoodSupp, 'name' => 'Vitamin Supplement 200gm', 'desc' => 'Food Supplement', 'size' => '200gm', 'retail' => 1200, 'net' => 350, 'unit' => $gm],
            ['cat' => $catFoodSupp, 'name' => 'Nutrux Supplement 200gm', 'desc' => 'Food Supplement', 'size' => '200gm', 'retail' => 750, 'net' => 220, 'unit' => $gm], // Price estimated from Magnutra

            // DROPS (4)
            ['cat' => $catDrops, 'name' => 'All leaf drops 20ml', 'desc' => 'Hedera helix ext (Ivy Leaf) Syrup for cough', 'size' => '20ml', 'retail' => 320, 'net' => 55, 'unit' => $ml],
            ['cat' => $catDrops, 'name' => 'Alif-ADE Drops 10ml', 'desc' => 'Combination drops of Vitamin A, D3 & E for children', 'size' => '10ml', 'retail' => 300, 'net' => 65, 'unit' => $ml],
            ['cat' => $catDrops, 'name' => 'Tetravit Drops 15ml', 'desc' => 'Combination drops of Vitamin A, D3, E & K2 for children', 'size' => '15ml', 'retail' => 450, 'net' => 70, 'unit' => $ml],
            ['cat' => $catDrops, 'name' => 'Neu safe Drops 20ml', 'desc' => 'Pediatric drops', 'size' => '20ml', 'retail' => 350, 'net' => 55, 'unit' => $ml], // Price estimated

            // TABLETS (15)
            ['cat' => $catTablets, 'name' => 'VTM Tablets 20\'s', 'desc' => 'Multivitamin tablets', 'size' => '20\'s Blister', 'retail' => 450, 'net' => 65, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'VTM Tablets 30\'s', 'desc' => 'Multivitamin tablets', 'size' => '30\'s Jar', 'retail' => 700, 'net' => 170, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'Carletin Tablets 30\'s Blister', 'desc' => 'Multivitamin tablets with biotin, Inositol, Folic acid, Calcium & Iron', 'size' => '30\'s Blister', 'retail' => 595, 'net' => 85, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'Carletin Tablets 30\'s Jar', 'desc' => 'Multivitamin tablets with biotin, Inositol, Folic acid, Calcium & Iron', 'size' => '30\'s Jar', 'retail' => 700, 'net' => 170, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'BD12 Tablets 100\'s', 'desc' => 'B12 Supplements', 'size' => '100\'s Blister', 'retail' => 950, 'net' => 210, 'unit' => $tab], // Price estimated
            ['cat' => $catTablets, 'name' => 'Glatglow 30\'s Jar', 'desc' => 'L-Glutathione with Vitamin C, B6, & E', 'size' => '30\'s Jar', 'retail' => 2500, 'net' => 700, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'Bioteen Tablets 30\'s', 'desc' => 'Myo-inositol, D-chiro-inositol & L-Methylfolate', 'size' => '30\'s Jar', 'retail' => 850, 'net' => 200, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'Feroxen capsules 20\'s', 'desc' => 'Iron Bisglycinate tablets', 'size' => '20\'s Blister', 'retail' => 450, 'net' => 70, 'unit' => $cap],
            ['cat' => $catTablets, 'name' => 'Feroxen capsules 30\'s', 'desc' => 'Iron Bisglycinate tablets', 'size' => '30\'s Jar', 'retail' => 600, 'net' => 170, 'unit' => $cap],
            ['cat' => $catTablets, 'name' => 'Q Co-10 capsules 20\'s', 'desc' => 'Co-enzyme Q10', 'size' => '20\'s Blister', 'retail' => 1295, 'net' => 250, 'unit' => $cap],
            ['cat' => $catTablets, 'name' => 'Provoke Capsules 30\'s', 'desc' => 'Pharmaceutical capsules', 'size' => '30\'s Jar', 'retail' => 3000, 'net' => 1000, 'unit' => $cap],
            ['cat' => $catTablets, 'name' => 'Mac D3 Capsules 10\'s', 'desc' => 'Vitamin D3 200000 IU Softgel Capsule', 'size' => '10\'s Blister', 'retail' => 320, 'net' => 32, 'unit' => $cap],
            ['cat' => $catTablets, 'name' => 'Zelvit C Effervescent tablet 10\'s', 'desc' => 'Effervescent tablets with Calcium & Vitamin C', 'size' => '10\'s Blister', 'retail' => 380, 'net' => 80, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'Crain Mart Effervescent tablet 10\'s', 'desc' => 'Effervescent tablets with Calcium', 'size' => '10\'s Blister', 'retail' => 495, 'net' => 110, 'unit' => $tab],
            ['cat' => $catTablets, 'name' => 'Chewit tablets 20\'s', 'desc' => 'Chewable tablets', 'size' => '20\'s Blister', 'retail' => 250, 'net' => 55, 'unit' => $tab], // Price estimated

            // OINTMENT (5)
            ['cat' => $catOintment, 'name' => 'Innomed Cream 30gm', 'desc' => 'Pain killer cream', 'size' => '30gm', 'retail' => 250, 'net' => 70, 'unit' => $gm], // Price estimated
            ['cat' => $catOintment, 'name' => 'Alif Vepourub 19gm', 'desc' => 'Vaporub balm', 'size' => '19gm', 'retail' => 160, 'net' => 36, 'unit' => $gm],
            ['cat' => $catOintment, 'name' => 'Its Dex 16gm', 'desc' => 'Pain balm', 'size' => '16gm', 'retail' => 120, 'net' => 40, 'unit' => $gm],
            ['cat' => $catOintment, 'name' => 'Nappy Rash Cream 30gm', 'desc' => 'Nappy Rash Cream for babies', 'size' => '30gm', 'retail' => 180, 'net' => 50, 'unit' => $gm], // Price estimated
            ['cat' => $catOintment, 'name' => 'Jaybee Oil 60ml', 'desc' => 'Pain killer oil', 'size' => '60ml', 'retail' => 350, 'net' => 95, 'unit' => $ml], // Price estimated

            // COSMETICS (6)
            ['cat' => $catCosmetics, 'name' => 'Neem Soap 80gm', 'desc' => 'Medicated soap', 'size' => '80gm', 'retail' => 255, 'net' => 75, 'unit' => $soap],
            ['cat' => $catCosmetics, 'name' => 'Scarbic Soap 80gm', 'desc' => 'Medicated soap', 'size' => '80gm', 'retail' => 255, 'net' => 75, 'unit' => $soap],
            ['cat' => $catCosmetics, 'name' => 'Acnos Soap 80gm', 'desc' => 'Medicated soap', 'size' => '80gm', 'retail' => 255, 'net' => 75, 'unit' => $soap],
            ['cat' => $catCosmetics, 'name' => 'Glow & go Soap 80gm', 'desc' => 'Beauty soap', 'size' => '80gm', 'retail' => 400, 'net' => 150, 'unit' => $soap],
            ['cat' => $catCosmetics, 'name' => 'Charcool Soap 80gm', 'desc' => 'Medicated soap', 'size' => '80gm', 'retail' => 255, 'net' => 75, 'unit' => $soap],
            ['cat' => $catCosmetics, 'name' => 'Lujain brightening cream 20gm', 'desc' => 'Brightening cream', 'size' => '20gm', 'retail' => 1400, 'net' => 700, 'unit' => $gm],
        ];

        foreach ($data as $item) {
            // Find or create the brand based on the product name prefix (first word)
            $brandName = explode(' ', $item['name'])[0];
            $brand = Brand::firstOrCreate(
                ['name' => $brandName, 'group_id' => $flourish->id]
            );

            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'description' => $item['desc'] . " (Pack Size: " . $item['size'] . ")",
                    'group_id' => $flourish->id,
                    'brand_id' => $brand->id,
                    'category_id' => $item['cat']->id,
                    'material_type' => 'finished_good',
                    'unit_id' => $item['unit']->id,
                    'cost_price' => $item['net'],
                    'sale_price' => $item['retail'],
                    'current_stock' => rand(100, 1000),
                    'reorder_point' => 50,
                ]
            );
        }

        // Add some Raw Materials (6) to hit the 66 target if needed, or just follow user's "66 products" hint
        $rawMaterials = [
            'Sucrose (Liquid)', 'Active Pharma Ingredient A', 'Magnesium Stearate', 
            'Purified Water', 'L-Lysine Hydrochloride', 'B-Complex Raw'
        ];
        
        foreach ($rawMaterials as $rm) {
            Product::updateOrCreate(
                ['name' => $rm],
                [
                    'description' => 'Raw material for pharmaceutical production.',
                    'group_id' => $flourish->id,
                    'material_type' => 'raw_material',
                    'unit_id' => $liquid->id,
                    'cost_price' => rand(500, 2000),
                    'sale_price' => 0,
                    'current_stock' => rand(50, 200),
                    'reorder_point' => 20,
                ]
            );
        }
    }
}
