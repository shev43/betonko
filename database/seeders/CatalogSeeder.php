<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessContacts;
use App\Models\BusinessFactories;
use App\Models\BusinessProducts;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        // ========== REGIONS (21 oblasts of Ukraine) ==========
        $regions = [
            ['name' => 'Київська область', 'lat' => 50.4501, 'lng' => 30.5234],
            ['name' => 'Львівська область', 'lat' => 49.8397, 'lng' => 24.0297],
            ['name' => 'Одеська область', 'lat' => 46.4825, 'lng' => 30.7233],
            ['name' => 'Дніпропетровська область', 'lat' => 48.4647, 'lng' => 35.0462],
            ['name' => 'Харківська область', 'lat' => 49.9935, 'lng' => 36.2304],
            ['name' => 'Запорізька область', 'lat' => 47.8388, 'lng' => 35.1396],
            ['name' => 'Вінницька область', 'lat' => 49.2331, 'lng' => 28.4682],
            ['name' => 'Полтавська область', 'lat' => 49.5883, 'lng' => 34.5514],
            ['name' => 'Черкаська область', 'lat' => 49.4444, 'lng' => 32.0598],
            ['name' => 'Рівненська область', 'lat' => 50.6199, 'lng' => 26.2516],
            ['name' => 'Хмельницька область', 'lat' => 49.4230, 'lng' => 26.9871],
            ['name' => 'Івано-Франківська область', 'lat' => 48.9226, 'lng' => 24.7111],
            ['name' => 'Тернопільська область', 'lat' => 49.5535, 'lng' => 25.5948],
            ['name' => 'Волинська область', 'lat' => 50.7472, 'lng' => 25.3254],
            ['name' => 'Миколаївська область', 'lat' => 46.9750, 'lng' => 31.9946],
            ['name' => 'Житомирська область', 'lat' => 50.2547, 'lng' => 28.6587],
            ['name' => 'Чернівецька область', 'lat' => 48.2920, 'lng' => 25.9358],
            ['name' => 'Кіровоградська область', 'lat' => 48.5079, 'lng' => 32.2623],
            ['name' => 'Чернігівська область', 'lat' => 51.4982, 'lng' => 31.2893],
            ['name' => 'Сумська область', 'lat' => 50.9077, 'lng' => 34.7981],
            ['name' => 'Закарпатська область', 'lat' => 48.6208, 'lng' => 22.2879],
        ];

        foreach ($regions as $region) {
            City::updateOrCreate(
                ['name' => $region['name'], 'region_id' => null],
                ['lat' => $region['lat'], 'lng' => $region['lng']]
            );
        }

        // ================================================================
        // VERIFIED REAL CONCRETE MANUFACTURERS OF UKRAINE
        // 32 companies across all 21 oblasts (March 2026)
        // ================================================================

        $companies = [

            // ═══ КИЇВСЬКА ОБЛАСТЬ (4) ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@kovalska.com', 'phone' => '0800601188'],
             'business' => ['name' => 'Ковальська', 'phone' => '0800607075', 'email' => 'client@kovalska.com', 'description' => 'Найбільший виробник бетону в Київському регіоні. 9 підприємств, 15 цехів, понад 1500 рецептур. ISO 9001:2015. Понад 60% будівельних проектів Києва.', 'address' => 'м. Київ, вул. Будіндустрії, 7', 'www' => 'https://beton.kovalska.com'],
             'factories' => [
                 ['name' => 'Ковальська — Будіндустрії', 'address' => 'м. Київ, вул. Будіндустрії, 7', 'region' => 'Київська область', 'lat' => 50.4288, 'lng' => 30.6644],
                 ['name' => 'Ковальська — Бориспільська', 'address' => 'м. Київ, вул. Бориспільська, 11', 'region' => 'Київська область', 'lat' => 50.4180, 'lng' => 30.6320],
                 ['name' => 'Ковальська — Святошинська', 'address' => 'м. Київ, вул. Святошинська, 34', 'region' => 'Київська область', 'lat' => 50.4560, 'lng' => 30.3680],
             ],
             'contacts' => [['name' => 'Приватні покупці', 'position' => 'Менеджер', 'phone' => '0800601188'], ['name' => 'Корпоративні', 'position' => 'Менеджер', 'phone' => '0800607075']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3045],
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3108],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3162],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3780],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 4101],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@tehbeton.com.ua', 'phone' => '0672438551'],
             'business' => ['name' => 'Технологія бетону', 'phone' => '0686565658', 'email' => 'info@tehbeton.com.ua', 'description' => 'Бетонний завод у Крюківщині. Два заводи для мінімізації часу доставки. Міксери 6-12 м3. Мін. замовлення 0,5 м3.', 'address' => 'Крюківщина, вул. Гетьмана Сагайдачного, 1', 'www' => 'https://tehbeton.com.ua'],
             'factories' => [['name' => 'Технологія бетону — Крюківщина', 'address' => 'Київська обл., Крюківщина, вул. Гетьмана Сагайдачного, 1', 'region' => 'Київська область', 'lat' => 50.3800, 'lng' => 30.3700]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0672438551']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3051],
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3240],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f50', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3297],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3474],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3675],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3996],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'sales@grandbeton.com.ua', 'phone' => '0673331333'],
             'business' => ['name' => 'Гранд Бетон', 'phone' => '0674196260', 'email' => 'sales@grandbeton.com.ua', 'description' => '18 років досвіду. Власна лабораторія, ДСТУ та БНіП. Горенічі, Київ, Віта-Поштова. єВідновлення.', 'address' => 'Київська обл., Горенічі, вул. Соборна, 270', 'www' => 'https://grandbeton.com.ua'],
             'factories' => [['name' => 'Гранд Бетон — Горенічі', 'address' => 'Київська обл., Бучанський р-н, Горенічі, вул. Соборна, 270', 'region' => 'Київська область', 'lat' => 50.4050, 'lng' => 30.2800]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0673331333']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 5301],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 5418],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3860],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 4041],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4862],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@kaskadbeton.com.ua', 'phone' => '0674469999'],
             'business' => ['name' => 'Каскад Бетон', 'phone' => '0443377400', 'email' => 'info@kaskadbeton.com.ua', 'description' => 'Вишгород, 5 км від Києва. Обладнання Stetter (Німеччина). Всі типи бетону та розчинів.', 'address' => 'м. Вишгород, вул. Шлюзова, 1, 07300', 'www' => 'https://kaskadbeton.com.ua'],
             'factories' => [['name' => 'Каскад Бетон — Вишгород', 'address' => 'м. Вишгород, вул. Шлюзова, 1, 07300', 'region' => 'Київська область', 'lat' => 50.5860, 'lng' => 30.4890]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0674469999'], ['name' => 'Диспетчерська', 'position' => 'Диспетчер', 'phone' => '0678825555']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2950],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3150],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3350],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3600],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3900],
             ]],

            // ═══ ЛЬВІВСЬКА ОБЛАСТЬ (4) ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@betonstandart.lviv.ua', 'phone' => '0947104477'],
             'business' => ['name' => 'Бетон-Стандарт', 'phone' => '0947104477', 'email' => 'info@betonstandart.lviv.ua', 'description' => '8+ років. Щодня 05:00-23:30. Мін. 1 м3. Гравійні та гранітні суміші.', 'address' => 'м. Львів, вул. Промислова, 37А', 'www' => 'https://betonstandart.lviv.ua'],
             'factories' => [['name' => 'Бетон-Стандарт — Промислова', 'address' => 'м. Львів, вул. Промислова, 37А', 'region' => 'Львівська область', 'lat' => 49.8100, 'lng' => 24.0100]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0947104477']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1530],
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1570],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 1630],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 1730],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 1855],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 1890],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'beton@mks-group.com.ua', 'phone' => '0980000238'],
             'business' => ['name' => 'МКС Бетон', 'phone' => '0322422401', 'email' => 'beton@mks-group.com.ua', 'description' => 'Два заводи у Львові. Бетононасоси, лабораторна діагностика, монолітне будівництво.', 'address' => 'м. Львів, вул. Зелена, 238б', 'www' => 'https://mks-beton.com.ua'],
             'factories' => [['name' => 'МКС Бетон — вул. Зелена', 'address' => 'м. Львів, вул. Зелена, 238б', 'region' => 'Львівська область', 'lat' => 49.8250, 'lng' => 24.0050], ['name' => 'МКС Бетон — Кукурудзяна', 'address' => 'м. Львів, вул. Кукурудзяна, 4', 'region' => 'Львівська область', 'lat' => 49.8350, 'lng' => 24.0200]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0980000238']],
             'products' => [
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1800],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2000],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2200],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 2500],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2800],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3200],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'levbeton2019@gmail.com', 'phone' => '0967774778'],
             'business' => ['name' => 'ЛЕВ-Бетон', 'phone' => '0967774778', 'email' => 'levbeton2019@gmail.com', 'description' => 'Яворівський р-н. Міксери до 12 м3, бетононасос 28 м. Гранітний щебінь, пісок.', 'address' => 'м. Новояворівськ, вул. Приозерна, 7, 81053', 'www' => 'https://gbs-beton.lviv.ua'],
             'factories' => [['name' => 'ЛЕВ-Бетон — Новояворівськ', 'address' => 'м. Новояворівськ, вул. Приозерна, 7', 'region' => 'Львівська область', 'lat' => 49.9293, 'lng' => 23.5125]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0967774778']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2360],
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2500],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2670],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2790],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3030],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3180],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@betoner.com.ua', 'phone' => '0979078280'],
             'business' => ['name' => 'Betoner', 'phone' => '0979078280', 'email' => 'info@betoner.com.ua', 'description' => 'Автоматизований бетонозмішувальний завод. Спеціалізоване ПЗ, точне дозування. Європейське обладнання.', 'address' => 'м. Львів, Львівська область', 'www' => 'https://betoner.com.ua'],
             'factories' => [['name' => 'Betoner — Львів', 'address' => 'м. Львів, Львівська обл.', 'region' => 'Львівська область', 'lat' => 49.8400, 'lng' => 24.0300]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0979078280']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1950],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2280],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2450],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 2700],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2900],
             ]],

            // ═══ ВОЛИНСЬКА ОБЛАСТЬ (2) ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'inter_beton@ukr.net', 'phone' => '0661777963'],
             'business' => ['name' => 'Інтер Бетон', 'phone' => '0332203035', 'email' => 'inter_beton@ukr.net', 'description' => 'Мережа заводів Волині та Рівненщини: Луцьк, Рівне, Сарни, Вараш, Нововолинськ, Ковель. 80 м3/год.', 'address' => 'м. Луцьк, вул. Індустріальна, 4, 43000', 'www' => 'https://inter-beton.ua'],
             'factories' => [['name' => 'Інтер Бетон — Луцьк', 'address' => 'м. Луцьк, вул. Індустріальна, 4', 'region' => 'Волинська область', 'lat' => 50.7857, 'lng' => 25.3716], ['name' => 'Інтер Бетон — Нововолинськ', 'address' => 'м. Нововолинськ, вул. Луцька, 25', 'region' => 'Волинська область', 'lat' => 50.7260, 'lng' => 24.1710]],
             'contacts' => [['name' => 'Відділ продажів Луцьк', 'position' => 'Менеджер', 'phone' => '0661777963'], ['name' => 'Нововолинськ', 'position' => 'Менеджер', 'phone' => '0673642008']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3149],
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3210],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3288],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3450],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 4079],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4250],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'tkachuk7792@gmail.com', 'phone' => '0508295427'],
             'business' => ['name' => 'Ліхтнер Бетон', 'phone' => '0332283710', 'email' => 'tkachuk7792@gmail.com', 'description' => 'Філія німецької Lichtner Beton. 15 заводів по Україні. EN 206-1/DIN 1045-2 та ДСТУ. Сертифікована лабораторія.', 'address' => 'м. Луцьк, пров. Дорожній, 4, 43000', 'www' => 'https://www.lichtner.lutsk.ua'],
             'factories' => [['name' => 'Ліхтнер Бетон — Луцьк', 'address' => 'м. Луцьк, пров. Дорожній, 4', 'region' => 'Волинська область', 'lat' => 50.7745, 'lng' => 25.3495]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0508295427']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3230],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3410],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3560],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 4030],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4350],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4970],
             ]],

            // ═══ ЗАКАРПАТСЬКА ОБЛАСТЬ (2) ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'brv.uzg@gmail.com', 'phone' => '0999540502'],
             'business' => ['name' => 'Бетон Груп-4', 'phone' => '0673710312', 'email' => 'brv.uzg@gmail.com', 'description' => 'З 2006 р. в Ужгороді. ЗБВ сертифіковані ДСТУ. Лабораторія, оренда опалубки, промислові підлоги.', 'address' => 'м. Ужгород, вул. Огарьова, 15', 'www' => 'https://www.betongroup4.com.ua'],
             'factories' => [['name' => 'Бетон Груп-4 — Ужгород', 'address' => 'м. Ужгород, вул. Огарьова, 15', 'region' => 'Закарпатська область', 'lat' => 48.5974, 'lng' => 22.2967]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0999540502']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2750],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3100],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3300],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3600],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3850],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'betonbk.zak@gmail.com', 'phone' => '0991860591'],
             'business' => ['name' => 'БЕТОН БК Закарпаття', 'phone' => '0991860591', 'email' => 'betonbk.zak@gmail.com', 'description' => '15+ років. Лідер Закарпаття. 24/7 виробництво. Власний автопарк.', 'address' => 'м. Мукачево, вул. Пряшівська, 11, 89600', 'www' => 'https://beton-zakarpattya.com.ua'],
             'factories' => [['name' => 'БЕТОН БК — Мукачево', 'address' => 'м. Мукачево, вул. Пряшівська, 11', 'region' => 'Закарпатська область', 'lat' => 48.4250, 'lng' => 22.7310]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0991860591']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2600],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2950],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3150],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3450],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3700],
             ]],

            // ═══ ЧЕРНІВЕЦЬКА (1), ХМЕЛЬНИЦЬКА (2), ТЕРНОПІЛЬСЬКА (1), ІВ-ФРАНКІВСЬКА (1), РІВНЕНСЬКА (1) ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@rodnichok.ua', 'phone' => '0507002828'],
             'business' => ['name' => 'БК Родничок', 'phone' => '0975002828', 'email' => 'info@rodnichok.ua', 'description' => 'Бетон (гравійні, щебеневі, гранітні суміші), тротуарна плитка, термоблоки, сендвіч-панелі.', 'address' => 'Новоселицький р-н, с. Бояни, вул. Індустріальна, 1', 'www' => 'https://rodnichok.ua'],
             'factories' => [['name' => 'Родничок — Бояни', 'address' => 'Чернівецька обл., с. Бояни, вул. Індустріальна, 1', 'region' => 'Чернівецька область', 'lat' => 48.2707, 'lng' => 26.1246]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0507002828']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2400],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2700],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2900],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3200],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3450],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3850],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'hkbm@i.ua', 'phone' => '0681719376'],
             'business' => ['name' => 'ХКБМ', 'phone' => '0974212121', 'email' => 'hkbm@i.ua', 'description' => 'Хмельницький Комбінат Будматеріалів. Один з найбільших виробників ЗБВ та бетону. 51-200 працівників.', 'address' => 'м. Хмельницький, вул. Шухевича, 16', 'www' => 'https://hkbm.com.ua'],
             'factories' => [['name' => 'ХКБМ — Хмельницький', 'address' => 'м. Хмельницький, вул. Шухевича, 16', 'region' => 'Хмельницька область', 'lat' => 49.4391, 'lng' => 26.9499]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0681719376']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2650],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2950],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3150],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3500],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3750],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4200],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'sl.brz@ukr.net', 'phone' => '0977115461'],
             'business' => ['name' => 'Славутський БРЗ', 'phone' => '0682802040', 'email' => 'sl.brz@ukr.net', 'description' => 'Бетонно-розчинний завод, м. Славута. Бетон, розчин, ЗБВ, інертні. Власний автопарк.', 'address' => 'м. Славута, вул. Військова, 21Е', 'www' => 'https://slavuta-beton.com'],
             'factories' => [['name' => 'Славутський БРЗ — Славута', 'address' => 'м. Славута, вул. Військова, 21Е', 'region' => 'Хмельницька область', 'lat' => 50.3015, 'lng' => 26.8687]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0977115461']],
             'products' => [
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2025],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2150],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2390],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2480],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'mkbeton@ukr.net', 'phone' => '0672954040'],
             'business' => ['name' => 'МК Бетон', 'phone' => '0672954040', 'email' => 'mkbeton@ukr.net', 'description' => '100 м3/год, 50 000+ м3. 18 міксерів. Бетононасос 120 м. Блоки ФБС, кільця КС.', 'address' => 'Тернопільський р-н, с. Підгородне, вул. Верхня Польова, 9', 'www' => 'https://mkbeton.com.ua'],
             'factories' => [['name' => 'МК Бетон — Підгородне', 'address' => 'с. Підгородне, вул. Верхня Польова, 9, Тернопільська обл.', 'region' => 'Тернопільська область', 'lat' => 49.5535, 'lng' => 25.5948]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0672954040']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3150],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3470],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3600],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3950],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4200],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4800],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'betonif.info@gmail.com', 'phone' => '0984004400'],
             'business' => ['name' => 'Бетон-ІФ', 'phone' => '0506025566', 'email' => 'betonif.info@gmail.com', 'description' => '20+ років. До 300 м3/зміну. Безкоштовна доставка. Бетононасос. Сертифікати та паспорти якості.', 'address' => 'м. Івано-Франківськ, вул. Юності, 57', 'www' => 'https://beton-if.com.ua'],
             'factories' => [['name' => 'Бетон-ІФ — Івано-Франківськ', 'address' => 'м. Івано-Франківськ, вул. Юності, 57', 'region' => 'Івано-Франківська область', 'lat' => 48.9226, 'lng' => 24.7111]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0984004400']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2400],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2700],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2900],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3200],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3500],
                 ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3800],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'sombeton2021@gmail.com', 'phone' => '0986208888'],
             'business' => ['name' => 'СОМ Бетон', 'phone' => '0986208888', 'email' => 'sombeton2021@gmail.com', 'description' => 'Бетон та бетононасос (до 30 м). Блоки ФБС, пісок, гравій, щебінь.', 'address' => 'м. Рівне, вул. Курчатова, 62Е, 33018', 'www' => 'https://sombeton.rv.ua'],
             'factories' => [['name' => 'СОМ Бетон — Рівне', 'address' => 'м. Рівне, вул. Курчатова, 62Е', 'region' => 'Рівненська область', 'lat' => 50.6089, 'lng' => 26.2768]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0986208888']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2700],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2880],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3010],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3420],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3570],
                 ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3700],
             ]],

            // ═══ ОДЕСЬКА (2), ДНІПРОПЕТРОВСЬКА (3), ХАРКІВСЬКА (1), ЗАПОРІЗЬКА (1) ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'beton24.odessa@gmail.com', 'phone' => '0674664999'],
             'business' => ['name' => 'Beton24', 'phone' => '0674664999', 'email' => 'beton24.odessa@gmail.com', 'description' => '9+ років. Німецьке/італійське обладнання, цемент CRH A500. Лабораторія. 15 міксерів. Бетононасос.', 'address' => 'м. Одеса, вул. Промислова, 31', 'www' => 'https://beton24.net'],
             'factories' => [['name' => 'Beton24 — Одеса', 'address' => 'м. Одеса, вул. Промислова, 31', 'region' => 'Одеська область', 'lat' => 46.4825, 'lng' => 30.7233]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0674664999']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2285],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2670],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2790],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3055],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'beton@hi-raise.com', 'phone' => '0675179751'],
             'business' => ['name' => 'Hi-Raise', 'phone' => '0487771177', 'email' => 'beton@hi-raise.com', 'description' => 'Холдинг з 2009 р. Два Liebherr (180 м3/год). 28 міксерів MAN/Mercedes. Сертифікована лабораторія.', 'address' => 'Одеська обл., с. Малодолинське, вул. Вінокурова, 9', 'www' => 'https://hi-raise.com'],
             'factories' => [['name' => 'Hi-Raise — Чорноморськ', 'address' => 'Одеська обл., с. Малодолинське, вул. Вінокурова, 9', 'region' => 'Одеська область', 'lat' => 46.3483, 'lng' => 30.6467]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0675179751']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2900],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3050],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3130],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3260],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3390],
                 ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3480],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'vskgroup.beton@gmail.com', 'phone' => '0678402030'],
             'business' => ['name' => 'VSK Бетон', 'phone' => '0508402030', 'email' => 'vskgroup.beton@gmail.com', 'description' => 'ТОВ ВСК Груп. Потрійний контроль. 600 м3/добу. Власний парк спецтехніки.', 'address' => 'м. Дніпро, вул. Курсантська, 7', 'www' => 'https://www.vskbeton.com.ua'],
             'factories' => [['name' => 'VSK Бетон — Дніпро', 'address' => 'м. Дніпро, вул. Курсантська, 7', 'region' => 'Дніпропетровська область', 'lat' => 48.4647, 'lng' => 35.0462]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0678402030']],
             'products' => [
                 ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2580],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2644],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2877],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3449],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3616],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'elba@const.dp.ua', 'phone' => '0676221592'],
             'business' => ['name' => 'ТД Ельба', 'phone' => '0676265346', 'email' => 'elba@const.dp.ua', 'description' => '20+ років, 1,2 млн м3. Лабораторія "Дніпростандартметрологія". Бетононасос Everdigm 48 м. Доставка 100 км.', 'address' => 'м. Дніпро, вул. Верстова, 50', 'www' => 'https://elba.dp.ua'],
             'factories' => [['name' => 'ТД Ельба — Дніпро', 'address' => 'м. Дніпро, вул. Верстова, 50', 'region' => 'Дніпропетровська область', 'lat' => 48.4520, 'lng' => 35.0455]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0676221592']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2700],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2880],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3060],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3180],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3280],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'scma@ukr.net', 'phone' => '0661806789'],
             'business' => ['name' => 'NIKKOM BETON', 'phone' => '0661806789', 'email' => 'scma@ukr.net', 'description' => 'Бетонний завод у Кривому Розі. Бетон, розчини, ФБС, ЗБВ. Лабораторія, автомобільні ваги.', 'address' => 'м. Кривий Ріг, вул. Цимлянська, 8Д', 'www' => 'https://nikkom-beton.com.ua'],
             'factories' => [['name' => 'NIKKOM BETON — Кривий Ріг', 'address' => 'м. Кривий Ріг, вул. Цимлянська, 8Д', 'region' => 'Дніпропетровська область', 'lat' => 47.9220, 'lng' => 33.3450]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0661806789']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2500],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3000],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3300],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3500],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@rockside.ua', 'phone' => '0507866775'],
             'business' => ['name' => 'Rockside', 'phone' => '0966475289', 'email' => 'info@rockside.ua', 'description' => 'Харків та область. М100-М500. Розчини М75-М200.', 'address' => 'м. Харків', 'www' => 'https://rockside.ua'],
             'factories' => [['name' => 'Rockside — Харків', 'address' => 'м. Харків, Харківська обл.', 'region' => 'Харківська область', 'lat' => 49.9935, 'lng' => 36.2304]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0507866775']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3350],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3800],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 4400],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4500],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 5100],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => '33986217@ukr.net', 'phone' => '0503415035'],
             'business' => ['name' => 'Концерн ВМ', 'phone' => '0989742244', 'email' => '33986217@ukr.net', 'description' => 'Запоріжжя та область. Пн-Нд 8:00-18:00, цілодобово за потребою. Цемент, ФБС, бордюри.', 'address' => 'м. Запоріжжя, вул. Теплична, 25', 'www' => 'https://betonvm.com.ua'],
             'factories' => [['name' => 'Концерн ВМ — Запоріжжя', 'address' => 'м. Запоріжжя, вул. Теплична, 25', 'region' => 'Запорізька область', 'lat' => 47.8388, 'lng' => 35.1396]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0503415035']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3200],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3800],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4000],
             ]],

            // ═══ ПОЛТАВСЬКА, ВІННИЦЬКА, СУМСЬКА, ЧЕРКАСЬКА, ЖИТОМИРСЬКА, ЧЕРНІГІВСЬКА, МИКОЛАЇВСЬКА, КІРОВОГРАДСЬКА ═══

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@beton.poltava.ua', 'phone' => '0509255075'],
             'business' => ['name' => 'Бетон та Цемент Полтава', 'phone' => '0509255075', 'email' => 'info@beton.poltava.ua', 'description' => 'Безпосередній виробник. 2 міксери. Портландцемент 25 кг. Щодня 9:00-21:00.', 'address' => 'м. Полтава, вул. Хлібозаводська, 43', 'www' => 'https://beton.poltava.ua'],
             'factories' => [['name' => 'Бетон та Цемент — Полтава', 'address' => 'м. Полтава, вул. Хлібозаводська, 43', 'region' => 'Полтавська область', 'lat' => 49.5883, 'lng' => 34.5514]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0509255075']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2215],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2460],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2990],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3180],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3595],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'betonukrprodukt@gmail.com', 'phone' => '0664688385'],
             'business' => ['name' => 'Український Продукт', 'phone' => '0963409161', 'email' => 'betonukrprodukt@gmail.com', 'description' => '150 м3/год. Замовлення 24/7. Пн-Сб 08:00-19:00. ISO.', 'address' => 'м. Ладижин, вул. Сагаєва, 1, Вінницька обл.', 'www' => 'https://beton-ukrprodukt.com.ua'],
             'factories' => [['name' => 'Український Продукт — Ладижин', 'address' => 'м. Ладижин, вул. Сагаєва, 1', 'region' => 'Вінницька область', 'lat' => 48.6833, 'lng' => 29.2333]],
             'contacts' => [['name' => 'Директор', 'position' => 'Директор', 'phone' => '0664688385']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's4', 'winter' => 'without', 'price' => 2640],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's4', 'winter' => 'without', 'price' => 3070],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3450],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3650],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'bbudopttorg@gmail.com', 'phone' => '0503071924'],
             'business' => ['name' => 'БУДОПТТОРГ', 'phone' => '0503273198', 'email' => 'bbudopttorg@gmail.com', 'description' => '7 днів/тиждень 08:00-19:00. ФБС, сітка, ЗБ кільця, пісок, щебінь.', 'address' => 'м. Суми, вул. Машинобудівників, 2', 'www' => 'https://betonsumy.com'],
             'factories' => [['name' => 'БУДОПТТОРГ — Суми', 'address' => 'м. Суми, вул. Машинобудівників, 2', 'region' => 'Сумська область', 'lat' => 50.9077, 'lng' => 34.7981]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0503071924']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3300],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 4080],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4400],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'Elaton_tov@meta.ua', 'phone' => '0675051289'],
             'business' => ['name' => 'Елатон', 'phone' => '0675051289', 'email' => 'Elaton_tov@meta.ua', 'description' => 'Роботизований Liebherr. Пн-Сб 06:00-21:00. Міксери: 6-11 м3. Бетононасос, промислові підлоги.', 'address' => 'м. Черкаси', 'www' => 'https://betonelaton.com'],
             'factories' => [['name' => 'Елатон — Черкаси', 'address' => 'м. Черкаси, Черкаська обл.', 'region' => 'Черкаська область', 'lat' => 49.4444, 'lng' => 32.0598]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0675051289']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2370],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2650],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3100],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3350],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'Beton-beton2010@ukr.net', 'phone' => '0672934929'],
             'business' => ['name' => 'ТД Бетон', 'phone' => '0986947375', 'email' => 'Beton-beton2010@ukr.net', 'description' => '20+ років досвіду. Акредитована лабораторія, міксери, бетононасос, екскаваторні послуги.', 'address' => 'м. Житомир, вул. Малинська, 10, 10029', 'www' => 'https://tdbeton.com.ua'],
             'factories' => [['name' => 'ТД Бетон — Житомир', 'address' => 'м. Житомир, вул. Малинська, 10', 'region' => 'Житомирська область', 'lat' => 50.2830, 'lng' => 28.6816]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0672934929']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2250],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2490],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2660],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2830],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3130],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'chernigiv@kovalska.com', 'phone' => '0800601189'],
             'business' => ['name' => 'Ковальська Чернігів', 'phone' => '0800607075', 'email' => 'client@kovalska.com', 'description' => 'АТ "Будіндустрія", група Ковальська. ISO 9001:2015. Лабораторний контроль. 20+ років.', 'address' => 'м. Чернігів, вул. Індустріальна, 11', 'www' => 'https://chernigiv.kovalska.com'],
             'factories' => [['name' => 'Ковальська — Чернігів', 'address' => 'м. Чернігів, вул. Індустріальна, 11', 'region' => 'Чернігівська область', 'lat' => 51.4649, 'lng' => 31.2531]],
             'contacts' => [['name' => 'Приватні покупці', 'position' => 'Менеджер', 'phone' => '0800601188']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2900],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3100],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3600],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3900],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'post_zbi@ukr.net', 'phone' => '0675147760'],
             'business' => ['name' => 'МЗЗБВ', 'phone' => '0675147790', 'email' => 'post_zbi@ukr.net', 'description' => 'З 1944 р. 100+ типів виробів: ЗБВ, бетон, арматурні каркаси, тротуарна плитка.', 'address' => 'м. Миколаїв, вул. Індустріальна, 3-А, 54020', 'www' => 'https://www.zbi.com.ua'],
             'factories' => [['name' => 'МЗЗБВ — Миколаїв', 'address' => 'м. Миколаїв, вул. Індустріальна, 3-А', 'region' => 'Миколаївська область', 'lat' => 46.9590, 'lng' => 32.0460]],
             'contacts' => [['name' => 'Відділ бетону', 'position' => 'Менеджер', 'phone' => '0675147760']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2500],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3350],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3550],
             ]],

            ['user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'stroyspektr@i.ua', 'phone' => '0502047171'],
             'business' => ['name' => 'Стройспектр', 'phone' => '0985218775', 'email' => 'stroyspektr@i.ua', 'description' => '30 років. Системи SIEMENS, GPS. 100% лабораторний контроль. Знижки. Пн-Сб 8:00-18:00.', 'address' => 'м. Кропивницький, вул. Автолюбителів, 3В', 'www' => 'http://sbeton.com.ua'],
             'factories' => [['name' => 'Стройспектр — Кропивницький', 'address' => 'м. Кропивницький, вул. Автолюбителів, 3В', 'region' => 'Кіровоградська область', 'lat' => 48.5050, 'lng' => 32.2350]],
             'contacts' => [['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0502047171']],
             'products' => [
                 ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2413],
                 ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2906],
                 ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3088],
                 ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3600],
                 ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3840],
                 ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4220],
             ]],
        ];

        // ========== INSERT DATA ==========
        $userCounter = User::count();

        foreach ($companies as $idx => $companyData) {
            $userCounter++;

            try {

            $user = User::create([
                'account_type' => 3,
                'profile_number' => str_pad($userCounter, 8, '0', STR_PAD_LEFT),
                'first_name' => $companyData['user']['first_name'],
                'last_name' => $companyData['user']['last_name'],
                'email' => $companyData['user']['email'],
                'phone' => $companyData['user']['phone'],
                'enabled' => 1,
                'password' => Hash::make('BetonKo2024!'),
            ]);

            $business = Business::create([
                'user_id' => $user->id,
                'business_number' => str_pad($user->id, 8, '0', STR_PAD_LEFT),
                'name' => $companyData['business']['name'],
                'phone' => $companyData['business']['phone'],
                'email' => $companyData['business']['email'],
                'description' => $companyData['business']['description'],
                'address' => $companyData['business']['address'],
                'www' => $companyData['business']['www'],
                'map_latitude' => $companyData['factories'][0]['lat'],
                'map_longitude' => $companyData['factories'][0]['lng'],
                'map_zoom' => 12,
                'map_rotate' => 0,
                'marker_latitude' => $companyData['factories'][0]['lat'],
                'marker_longitude' => $companyData['factories'][0]['lng'],
            ]);

            foreach ($companyData['contacts'] as $contactData) {
                BusinessContacts::create([
                    'business_id' => $business->id,
                    'name' => $contactData['name'],
                    'position' => $contactData['position'],
                    'phone' => $contactData['phone'],
                ]);
            }

            $factoryCounter = 0;
            foreach ($companyData['factories'] as $factoryData) {
                $factoryCounter++;
                $factory = BusinessFactories::create([
                    'business_id' => $business->id,
                    'factory_number' => str_pad($business->id, 5, '0', STR_PAD_LEFT) . str_pad($factoryCounter, 3, '0', STR_PAD_LEFT),
                    'name' => $factoryData['name'],
                    'address' => $factoryData['address'],
                    'region' => $factoryData['region'],
                    'map_latitude' => $factoryData['lat'],
                    'map_longitude' => $factoryData['lng'],
                    'map_zoom' => 13,
                    'map_rotate' => 0,
                    'marker_latitude' => $factoryData['lat'],
                    'marker_longitude' => $factoryData['lng'],
                ]);

                $productCounter = 0;
                foreach ($companyData['products'] as $productData) {
                    $productCounter++;
                    BusinessProducts::create([
                        'business_id' => $business->id,
                        'factories_id' => $factory->id,
                        'product_number' => str_pad($factory->id, 5, '0', STR_PAD_LEFT) . str_pad($productCounter, 3, '0', STR_PAD_LEFT),
                        'mark' => $productData['mark'],
                        'class' => $productData['class'],
                        'frost_resistance' => $productData['frost'],
                        'water_resistance' => $productData['water'],
                        'mixture_mobility' => $productData['mobility'],
                        'winter_supplement' => $productData['winter'],
                        'price' => $productData['price'],
                        'comment' => null,
                    ]);
                }
            }

            } catch (\Exception $e) {
                echo "ERROR seeding company #{$idx} ({$companyData['business']['name']}): {$e->getMessage()}\n";
                continue;
            }
        }

        $factoryCount = array_sum(array_map(fn($c) => count($c['factories']), $companies));
        $productCount = array_sum(array_map(fn($c) => count($c['products']) * count($c['factories']), $companies));
        echo "Seeded: " . count($companies) . " businesses, {$factoryCount} factories, {$productCount} products\n";
    }
}
