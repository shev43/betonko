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
        // ========== REGIONS (21 oblast of Ukraine) ==========
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
        // All data sourced from official company websites (March 2026)
        // ================================================================

        $companies = [

            // ─── KYIV #1: Технологія бетону (TehBeton) ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@tehbeton.com.ua', 'phone' => '0672438551'],
                'business' => [
                    'name' => 'Технологія бетону',
                    'phone' => '0686565658',
                    'email' => 'info@tehbeton.com.ua',
                    'description' => 'Бетонний завод у Крюківщині, Київська область. Два заводи в різних частинах міста для мінімізації часу та вартості доставки. Доставка міксерами 6-12 м3. Оренда бетононасоса. Мінімальне замовлення 0,5 м3.',
                    'address' => 'вул. Гетьмана Сагайдачного, 1, Крюківщина, Київська обл.',
                    'www' => 'https://tehbeton.com.ua',
                ],
                'factories' => [
                    ['name' => 'Технологія бетону — Крюківщина', 'address' => 'Київська обл., Крюківщина, вул. Гетьмана Сагайдачного, 1', 'region' => 'Київська область', 'lat' => 50.3800, 'lng' => 30.3700],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0672438551'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3051],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3240],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f50', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3297],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3474],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3675],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3996],
                ],
            ],

            // ─── KYIV #2: Гранд Бетон ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'sales@grandbeton.com.ua', 'phone' => '0673331333'],
                'business' => [
                    'name' => 'Гранд Бетон',
                    'phone' => '0674196260',
                    'email' => 'sales@grandbeton.com.ua',
                    'description' => '18 років досвіду у виробництві бетону. Власна лабораторія контролю якості, відповідність всім стандартам ДСТУ та БНіП. Виробничі потужності в Горенічах (Бучанський р-н), Києві та Віта-Поштовій. Приймаємо сертифікати єВідновлення.',
                    'address' => 'Київська обл., Бучанський р-н, Горенічі, вул. Соборна, 270',
                    'www' => 'https://grandbeton.com.ua',
                ],
                'factories' => [
                    ['name' => 'Гранд Бетон — Горенічі', 'address' => 'Київська обл., Бучанський р-н, Горенічі, вул. Соборна, 270', 'region' => 'Київська область', 'lat' => 50.4050, 'lng' => 30.2800],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0673331333'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 5301],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 5392],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 5418],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3860],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 4041],
                    ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4568],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4862],
                ],
            ],

            // ─── KYIV #3: Каскад Бетон (Вишгород) ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@kaskadbeton.com.ua', 'phone' => '0674469999'],
                'business' => [
                    'name' => 'Каскад Бетон',
                    'phone' => '0443377400',
                    'email' => 'info@kaskadbeton.com.ua',
                    'description' => 'Бетонний завод у Вишгороді, 5 км від Оболонського р-ну Києва. Повністю автоматизоване виробництво на обладнанні німецького виробника Stetter. Всі типи бетону та розчинів з доставкою по Києву та Київській області.',
                    'address' => 'вул. Шлюзова, 1, Вишгород, Київська обл., 07300',
                    'www' => 'https://kaskadbeton.com.ua',
                ],
                'factories' => [
                    ['name' => 'Каскад Бетон — Вишгород', 'address' => 'м. Вишгород, вул. Шлюзова, 1, Київська обл., 07300', 'region' => 'Київська область', 'lat' => 50.5860, 'lng' => 30.4890],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0674469999'],
                    ['name' => 'Диспетчерська', 'position' => 'Диспетчер', 'phone' => '0678825555'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2950],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3150],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3350],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3600],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3900],
                ],
            ],

            // ─── ЛЬВІВ #1: Бетон-Стандарт ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@betonstandart.lviv.ua', 'phone' => '0947104477'],
                'business' => [
                    'name' => 'Бетон-Стандарт',
                    'phone' => '0947104477',
                    'email' => 'info@betonstandart.lviv.ua',
                    'description' => 'Виробництво та доставка товарного бетону у Львові. 8+ років на ринку. Працюємо щодня з 05:00 до 23:30. Мінімальне замовлення 1 м3. Суміші на основі гравію та граніту.',
                    'address' => 'м. Львів, вул. Промислова, 37А',
                    'www' => 'https://betonstandart.lviv.ua',
                ],
                'factories' => [
                    ['name' => 'Бетон-Стандарт — Промислова', 'address' => 'м. Львів, вул. Промислова, 37А', 'region' => 'Львівська область', 'lat' => 49.8100, 'lng' => 24.0100],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0947104477'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1530],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1570],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 1630],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 1730],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 1855],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 1890],
                ],
            ],

            // ─── ЛЬВІВ #2: МКС Бетон ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'sales@mks-group.com.ua', 'phone' => '0980000238'],
                'business' => [
                    'name' => 'МКС Бетон',
                    'phone' => '0322422401',
                    'email' => 'beton@mks-group.com.ua',
                    'description' => 'Виробництво та доставка товарного бетону у Львові. Два заводи: вул. Зелена, 238б та вул. Кукурудзяна, 4. Послуги бетононасосів (стаціонарних та мобільних), лабораторна діагностика, промислові підлоги, монолітне будівництво.',
                    'address' => 'м. Львів, вул. Зелена, 238б',
                    'www' => 'https://mks-beton.com.ua',
                ],
                'factories' => [
                    ['name' => 'МКС Бетон — вул. Зелена', 'address' => 'м. Львів, вул. Зелена, 238б', 'region' => 'Львівська область', 'lat' => 49.8250, 'lng' => 24.0050],
                    ['name' => 'МКС Бетон — вул. Кукурудзяна', 'address' => 'м. Львів, вул. Кукурудзяна, 4', 'region' => 'Львівська область', 'lat' => 49.8350, 'lng' => 24.0200],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0980000238'],
                ],
                'products' => [
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 1800],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2000],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2200],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 2500],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2800],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3200],
                ],
            ],

            // ─── ОДЕСА: Beton24 ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'beton24.odessa@gmail.com', 'phone' => '0674664999'],
                'business' => [
                    'name' => 'Beton24',
                    'phone' => '0674664999',
                    'email' => 'beton24.odessa@gmail.com',
                    'description' => 'Бетонний завод в Одесі, 9+ років на ринку. Виробництво на німецькому та італійському обладнанні з використанням цементу CRH A500. Власна лабораторія контролю якості. Парк з 15 міксерів (6, 7, 9 м3). Послуги бетононасоса та конвеєрної стрічки.',
                    'address' => 'м. Одеса, вул. Промислова (М. Боровського), 31',
                    'www' => 'https://beton24.net',
                ],
                'factories' => [
                    ['name' => 'Beton24 — Одеса', 'address' => 'м. Одеса, вул. Промислова (М. Боровського), 31', 'region' => 'Одеська область', 'lat' => 46.4825, 'lng' => 30.7233],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0674664999'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2285],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2400],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2670],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2790],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3055],
                ],
            ],

            // ─── ДНІПРО: VSK Бетон ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'vskgroup.beton@gmail.com', 'phone' => '0678402030'],
                'business' => [
                    'name' => 'VSK Бетон',
                    'phone' => '0508402030',
                    'email' => 'vskgroup.beton@gmail.com',
                    'description' => 'Виробник бетону у Дніпрі, підрозділ ТОВ ВСК Груп. Потрійний лабораторний контроль якості кожної партії. Виробнича потужність 600 м3 на добу, включаючи зимові роботи. Власний парк спецтехніки.',
                    'address' => 'м. Дніпро, вул. Курсантська, 7',
                    'www' => 'https://www.vskbeton.com.ua',
                ],
                'factories' => [
                    ['name' => 'VSK Бетон — Дніпро', 'address' => 'м. Дніпро, вул. Курсантська, 7', 'region' => 'Дніпропетровська область', 'lat' => 48.4647, 'lng' => 35.0462],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0678402030'],
                ],
                'products' => [
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2580],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2644],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2877],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3449],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3616],
                    ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4264],
                ],
            ],

            // ─── ХАРКІВ: Rockside ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@rockside.ua', 'phone' => '0507866775'],
                'business' => [
                    'name' => 'Rockside',
                    'phone' => '0966475289',
                    'email' => 'info@rockside.ua',
                    'description' => 'Бетонний завод з доставкою по Харкову та області (Ізюм, Лозова, Чугуїв, Балаклія, Красноград, Дергачі, Зміїв, Мерефа, Пісочин). Повний спектр марок від М100 до М500. Цементні розчини М75-М200.',
                    'address' => 'м. Харків',
                    'www' => 'https://rockside.ua',
                ],
                'factories' => [
                    ['name' => 'Rockside — Харків', 'address' => 'м. Харків, Харківська обл.', 'region' => 'Харківська область', 'lat' => 49.9935, 'lng' => 36.2304],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів Харків', 'position' => 'Менеджер', 'phone' => '0507866775'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3350],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3600],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3800],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 4000],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 4400],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4500],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 5100],
                ],
            ],

            // ─── ЗАПОРІЖЖЯ: Концерн ВМ ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => '33986217@ukr.net', 'phone' => '0503415035'],
                'business' => [
                    'name' => 'Концерн ВМ',
                    'phone' => '0989742244',
                    'email' => '33986217@ukr.net',
                    'description' => 'Виробництво та доставка бетону всіх марок міксером по Запоріжжю та області. Працюємо без вихідних Пн-Нд 8:00-18:00, за потребою цілодобово. Також продаємо цемент, блоки ФБС, бордюри.',
                    'address' => 'м. Запоріжжя, вул. Теплична, 25',
                    'www' => 'https://betonvm.com.ua',
                ],
                'factories' => [
                    ['name' => 'Концерн ВМ — Запоріжжя', 'address' => 'м. Запоріжжя, вул. Теплична, 25', 'region' => 'Запорізька область', 'lat' => 47.8388, 'lng' => 35.1396],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0503415035'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3000],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3200],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3400],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3800],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4000],
                ],
            ],

            // ─── РІВНЕ: СОМ Бетон ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'sombeton2021@gmail.com', 'phone' => '0986208888'],
                'business' => [
                    'name' => 'СОМ Бетон',
                    'phone' => '0986208888',
                    'email' => 'sombeton2021@gmail.com',
                    'description' => 'Виробництво та доставка бетону в Рівному та області. Послуги бетононасоса (до 30 м досяжності). Також продаємо блоки ФБС, інертні матеріали (пісок, гравій, щебінь).',
                    'address' => 'м. Рівне, вул. Курчатова, 62Е, 33018',
                    'www' => 'https://sombeton.rv.ua',
                ],
                'factories' => [
                    ['name' => 'СОМ Бетон — Рівне', 'address' => 'м. Рівне, вул. Курчатова, 62Е, 33018', 'region' => 'Рівненська область', 'lat' => 50.6089, 'lng' => 26.2768],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0986208888'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2700],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2880],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3010],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3420],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3570],
                    ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3700],
                ],
            ],

            // ─── ТЕРНОПІЛЬ: МК Бетон ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'mkbeton@ukr.net', 'phone' => '0672954040'],
                'business' => [
                    'name' => 'МК Бетон',
                    'phone' => '0672954040',
                    'email' => 'mkbeton@ukr.net',
                    'description' => 'Виробництво та доставка бетону в Тернополі та області. Потужність заводу 100 м3/год, вироблено 50 000+ м3 бетону. Парк з 18 міксерів. Послуги бетононасоса (досяжність до 120 м). Блоки ФБС, кільця КС.',
                    'address' => 'Тернопільський р-н, с. Підгородне, вул. Верхня Польова, 9, 47751',
                    'www' => 'https://mkbeton.com.ua',
                ],
                'factories' => [
                    ['name' => 'МК Бетон — Підгородне', 'address' => 'Тернопільський р-н, с. Підгородне, вул. Верхня Польова, 9', 'region' => 'Тернопільська область', 'lat' => 49.5535, 'lng' => 25.5948],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0672954040'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3150],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3270],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3470],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3600],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3950],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4200],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 4800],
                ],
            ],

            // ─── ІВАНО-ФРАНКІВСЬК: Бетон-ІФ ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'betonif.info@gmail.com', 'phone' => '0984004400'],
                'business' => [
                    'name' => 'Бетон-ІФ',
                    'phone' => '0506025566',
                    'email' => 'betonif.info@gmail.com',
                    'description' => 'Виробництво бетону в Івано-Франківську з 20+ річним досвідом. Потужність до 300 м3 за зміну. Безкоштовна доставка (за умов). Послуги бетононасоса. Сертифікати та паспорти якості на всю продукцію.',
                    'address' => 'м. Івано-Франківськ, вул. Юності, 57',
                    'www' => 'https://beton-if.com.ua',
                ],
                'factories' => [
                    ['name' => 'Бетон-ІФ — Івано-Франківськ', 'address' => 'м. Івано-Франківськ, вул. Юності, 57', 'region' => 'Івано-Франківська область', 'lat' => 48.9226, 'lng' => 24.7111],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0984004400'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2400],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2550],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2700],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2900],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3200],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3500],
                    ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3800],
                ],
            ],

            // ─── ПОЛТАВА: Бетон та Цемент ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'info@beton.poltava.ua', 'phone' => '0509255075'],
                'business' => [
                    'name' => 'Бетон та Цемент Полтава',
                    'phone' => '0509255075',
                    'email' => 'info@beton.poltava.ua',
                    'description' => 'Безпосередній виробник бетону та цементу з доставкою по Полтаві та області. 2 міксери завжди в наявності. Також продаємо портландцемент з Івано-Франківського та Криворізького заводів в мішках по 25 кг. Працюємо щодня 9:00-21:00.',
                    'address' => 'м. Полтава, вул. Хлібозаводська, 43',
                    'www' => 'https://beton.poltava.ua',
                ],
                'factories' => [
                    ['name' => 'Бетон та Цемент — Полтава', 'address' => 'м. Полтава, вул. Хлібозаводська, 43', 'region' => 'Полтавська область', 'lat' => 49.5883, 'lng' => 34.5514],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0509255075'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2215],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2365],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2460],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2605],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2990],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3180],
                    ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3475],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3595],
                ],
            ],

            // ─── ВІННИЦЯ: Український Продукт ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'betonukrprodukt@gmail.com', 'phone' => '0664688385'],
                'business' => [
                    'name' => 'Український Продукт',
                    'phone' => '0963409161',
                    'email' => 'betonukrprodukt@gmail.com',
                    'description' => 'Виробництво та доставка бетону у Вінницькій області. Потужність 150 м3/год. Прийом замовлень на бетон 24/7. Графік роботи: Пн-Сб 08:00-19:00. Виробництво відповідає стандартам ISO.',
                    'address' => 'м. Ладижин, вул. Сагаєва, 1, Вінницька обл.',
                    'www' => 'https://beton-ukrprodukt.com.ua',
                ],
                'factories' => [
                    ['name' => 'Український Продукт — Ладижин', 'address' => 'м. Ладижин, вул. Сагаєва, 1, Вінницька обл.', 'region' => 'Вінницька область', 'lat' => 48.6833, 'lng' => 29.2333],
                ],
                'contacts' => [
                    ['name' => 'Директор', 'position' => 'Директор', 'phone' => '0664688385'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's4', 'winter' => 'without', 'price' => 2640],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's4', 'winter' => 'without', 'price' => 2850],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's4', 'winter' => 'without', 'price' => 3070],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3350],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 3450],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3650],
                    ['mark' => '450', 'class' => 'b35', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3770],
                ],
            ],

            // ─── СУМИ: БУДОПТТОРГ ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'BBUDOPTTORG@GMAIL.COM', 'phone' => '0503071924'],
                'business' => [
                    'name' => 'БУДОПТТОРГ',
                    'phone' => '0503273198',
                    'email' => 'bbudopttorg@gmail.com',
                    'description' => 'Виробництво та продаж бетону в Сумах та Сумській області. Працюємо 7 днів на тиждень 08:00-19:00. Також продаємо блоки ФБС, зварну сітку, залізобетонні кільця та кришки, пісок, щебінь.',
                    'address' => 'м. Суми, вул. Машинобудівників, 2',
                    'www' => 'https://betonsumy.com',
                ],
                'factories' => [
                    ['name' => 'БУДОПТТОРГ — Суми', 'address' => 'м. Суми, вул. Машинобудівників, 2', 'region' => 'Сумська область', 'lat' => 50.9077, 'lng' => 34.7981],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0503071924'],
                    ['name' => 'Додатковий контакт', 'position' => 'Менеджер', 'phone' => '0503015541'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2800],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 3170],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 3300],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3560],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 4080],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 4400],
                ],
            ],

            // ─── ЧЕРКАСИ: Елатон ───
            [
                'user' => ['first_name' => 'Відділ', 'last_name' => 'Продажів', 'email' => 'Elaton_tov@meta.ua', 'phone' => '0675051289'],
                'business' => [
                    'name' => 'Елатон',
                    'phone' => '0675051289',
                    'email' => 'Elaton_tov@meta.ua',
                    'description' => 'Виробництво бетону в Черкасах на роботизованому бетонозмішувальному заводі Liebherr. Працюємо Пн-Сб 06:00-21:00. Доставка міксерами: 6, 7, 9 та 11 м3. Також послуги бетононасоса, промислові бетонні підлоги, доставка щебню/піску.',
                    'address' => 'м. Черкаси',
                    'www' => 'https://betonelaton.com',
                ],
                'factories' => [
                    ['name' => 'Елатон — Черкаси', 'address' => 'м. Черкаси, Черкаська обл.', 'region' => 'Черкаська область', 'lat' => 49.4444, 'lng' => 32.0598],
                ],
                'contacts' => [
                    ['name' => 'Відділ продажів', 'position' => 'Менеджер', 'phone' => '0675051289'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2370],
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's3', 'winter' => 'without', 'price' => 2450],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2650],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2850],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 3100],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3350],
                ],
            ],
        ];

        // ========== INSERT DATA ==========
        $userCounter = User::count();

        foreach ($companies as $companyData) {
            $userCounter++;

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
        }

        $factoryCount = array_sum(array_map(fn($c) => count($c['factories']), $companies));
        $productCount = array_sum(array_map(fn($c) => count($c['products']) * count($c['factories']), $companies));
        echo "Seeded: " . count($companies) . " businesses, {$factoryCount} factories, {$productCount} products\n";
    }
}
