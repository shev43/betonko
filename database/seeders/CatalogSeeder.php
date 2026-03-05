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
        // ========== REGIONS ==========
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

        // Insert regions
        foreach ($regions as $region) {
            City::updateOrCreate(
                ['name' => $region['name'], 'region_id' => null],
                ['lat' => $region['lat'], 'lng' => $region['lng']]
            );
        }

        // ========== BUSINESSES (concrete companies) ==========
        $companies = [
            [
                'user' => ['first_name' => 'Олександр', 'last_name' => 'Коваленко', 'email' => 'info@kyivbeton.ua', 'phone' => '0671234567'],
                'business' => ['name' => 'КиївБетон', 'phone' => '0441234567', 'email' => 'sales@kyivbeton.ua', 'description' => 'Один з найбільших виробників бетону в Київській області. Працюємо з 2005 року, маємо власний автопарк бетонозмішувачів. Забезпечуємо будівництво житлових комплексів, інфраструктурних об\'єктів та приватне будівництво.', 'address' => 'м. Київ, вул. Промислова, 12', 'www' => 'https://kyivbeton.ua'],
                'factories' => [
                    ['name' => 'Завод КиївБетон — Бортничі', 'address' => 'Київська обл., с. Бортничі, вул. Заводська, 5', 'region' => 'Київська область', 'lat' => 50.3583, 'lng' => 30.6539],
                    ['name' => 'Завод КиївБетон — Вишневе', 'address' => 'Київська обл., м. Вишневе, вул. Київська, 22', 'region' => 'Київська область', 'lat' => 50.3877, 'lng' => 30.3675],
                ],
                'contacts' => [
                    ['name' => 'Олександр Коваленко', 'position' => 'Директор', 'phone' => '0671234567'],
                    ['name' => 'Ірина Мельник', 'position' => 'Менеджер з продажу', 'phone' => '0671234568'],
                ],
                'products' => [
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2150],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2350],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 2650],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'hot_water', 'price' => 2950],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3400],
                ],
            ],
            [
                'user' => ['first_name' => 'Андрій', 'last_name' => 'Шевченко', 'email' => 'info@lvivzalizbeton.ua', 'phone' => '0987654321'],
                'business' => ['name' => 'ЛьвівЗалізобетон', 'phone' => '0322345678', 'email' => 'office@lvivzalizbeton.ua', 'description' => 'Виробництво товарного бетону та залізобетонних виробів у Львові. Сучасне обладнання, лабораторний контроль якості, доставка по всій Львівській області.', 'address' => 'м. Львів, вул. Городоцька, 174', 'www' => 'https://lvivzalizbeton.ua'],
                'factories' => [
                    ['name' => 'Завод ЛьвівЗалізобетон', 'address' => 'м. Львів, вул. Городоцька, 174', 'region' => 'Львівська область', 'lat' => 49.8283, 'lng' => 23.9763],
                ],
                'contacts' => [
                    ['name' => 'Андрій Шевченко', 'position' => 'Комерційний директор', 'phone' => '0987654321'],
                ],
                'products' => [
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's2', 'winter' => 'without', 'price' => 1900],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2200],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2450],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2700],
                ],
            ],
            [
                'user' => ['first_name' => 'Максим', 'last_name' => 'Бондаренко', 'email' => 'info@odesbeton.com.ua', 'phone' => '0501112233'],
                'business' => ['name' => 'ОдесБетон Плюс', 'phone' => '0481234567', 'email' => 'sales@odesbeton.com.ua', 'description' => 'Виробництво та доставка бетону в Одесі та Одеській області. Повний спектр марок бетону для будівництва. Гнучка система знижок для постійних клієнтів.', 'address' => 'м. Одеса, Суворовський р-н, вул. Промислова, 8', 'www' => ''],
                'factories' => [
                    ['name' => 'БРЗ ОдесБетон — Суворовський', 'address' => 'м. Одеса, вул. Промислова, 8', 'region' => 'Одеська область', 'lat' => 46.4993, 'lng' => 30.7384],
                    ['name' => 'БРЗ ОдесБетон — Таїрова', 'address' => 'м. Одеса, вул. Космонавтів, 42', 'region' => 'Одеська область', 'lat' => 46.4320, 'lng' => 30.6899],
                ],
                'contacts' => [
                    ['name' => 'Максим Бондаренко', 'position' => 'Директор', 'phone' => '0501112233'],
                    ['name' => 'Сергій Ткаченко', 'position' => 'Логістик', 'phone' => '0501112234'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's1', 'winter' => 'without', 'price' => 1750],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2100],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2300],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'hot_water', 'price' => 2600],
                ],
            ],
            [
                'user' => ['first_name' => 'Дмитро', 'last_name' => 'Кравчук', 'email' => 'info@dniprobud.ua', 'phone' => '0662223344'],
                'business' => ['name' => 'ДніпроБуд Бетон', 'phone' => '0562345678', 'email' => 'beton@dniprobud.ua', 'description' => 'Виробник товарного бетону та розчинів у Дніпрі. Власна лабораторія, сертифіковане виробництво. Обслуговуємо великі будівельні проекти в регіоні.', 'address' => 'м. Дніпро, вул. Набережна Перемоги, 88', 'www' => 'https://dniprobud.ua'],
                'factories' => [
                    ['name' => 'Завод ДніпроБуд — Лівий берег', 'address' => 'м. Дніпро, Амур-Нижньодніпровський р-н, вул. Каруни, 12', 'region' => 'Дніпропетровська область', 'lat' => 48.4384, 'lng' => 35.0832],
                    ['name' => 'Завод ДніпроБуд — Кривий Ріг', 'address' => 'м. Кривий Ріг, вул. Залізнична, 30', 'region' => 'Дніпропетровська область', 'lat' => 47.9106, 'lng' => 33.3432],
                ],
                'contacts' => [
                    ['name' => 'Дмитро Кравчук', 'position' => 'Генеральний директор', 'phone' => '0662223344'],
                    ['name' => 'Олена Петренко', 'position' => 'Менеджер з продажу', 'phone' => '0662223345'],
                ],
                'products' => [
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2050],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2280],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 2580],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2850],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3300],
                ],
            ],
            [
                'user' => ['first_name' => 'Віталій', 'last_name' => 'Марченко', 'email' => 'info@kharkivbeton.ua', 'phone' => '0931234567'],
                'business' => ['name' => 'ХарківБетон', 'phone' => '0571234567', 'email' => 'order@kharkivbeton.ua', 'description' => 'Надійний виробник бетону для Харкова та області. Оперативна доставка, конкурентні ціни. Працюємо цілодобово для забезпечення безперебійного постачання.', 'address' => 'м. Харків, вул. Плиткова, 16', 'www' => ''],
                'factories' => [
                    ['name' => 'Завод ХарківБетон', 'address' => 'м. Харків, Індустріальний р-н, вул. Плиткова, 16', 'region' => 'Харківська область', 'lat' => 49.9690, 'lng' => 36.3119],
                ],
                'contacts' => [
                    ['name' => 'Віталій Марченко', 'position' => 'Директор', 'phone' => '0931234567'],
                ],
                'products' => [
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's2', 'winter' => 'without', 'price' => 1850],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2100],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2350],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2600],
                ],
            ],
            [
                'user' => ['first_name' => 'Юрій', 'last_name' => 'Савченко', 'email' => 'info@vinbeton.com.ua', 'phone' => '0674445566'],
                'business' => ['name' => 'ВінБетон Груп', 'phone' => '0432123456', 'email' => 'sales@vinbeton.com.ua', 'description' => 'Вінницький виробник бетону з 15-річним досвідом. Повний асортимент марок, зимові добавки, доставка по Вінницькій та сусіднім областям.', 'address' => 'м. Вінниця, вул. 600-річчя, 50', 'www' => ''],
                'factories' => [
                    ['name' => 'Завод ВінБетон', 'address' => 'м. Вінниця, вул. 600-річчя, 50', 'region' => 'Вінницька область', 'lat' => 49.2116, 'lng' => 28.4454],
                ],
                'contacts' => [
                    ['name' => 'Юрій Савченко', 'position' => 'Власник', 'phone' => '0674445566'],
                ],
                'products' => [
                    ['mark' => '100', 'class' => 'b7', 'frost' => 'f50', 'water' => 'w2', 'mobility' => 's2', 'winter' => 'without', 'price' => 1700],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2050],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'hot_water', 'price' => 2350],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's3', 'winter' => 'm5', 'price' => 2550],
                ],
            ],
            [
                'user' => ['first_name' => 'Роман', 'last_name' => 'Литвиненко', 'email' => 'info@zapbeton.ua', 'phone' => '0955556677'],
                'business' => ['name' => 'ЗапБетон Сервіс', 'phone' => '0612345678', 'email' => 'order@zapbeton.ua', 'description' => 'Запорізький виробник бетону. Повний цикл: від виробництва до доставки. Сучасний бетонозмішувальний вузол потужністю до 120 м3/год.', 'address' => 'м. Запоріжжя, вул. Південне шосе, 7', 'www' => 'https://zapbeton.ua'],
                'factories' => [
                    ['name' => 'БЗВ ЗапБетон', 'address' => 'м. Запоріжжя, вул. Південне шосе, 7', 'region' => 'Запорізька область', 'lat' => 47.8060, 'lng' => 35.1601],
                ],
                'contacts' => [
                    ['name' => 'Роман Литвиненко', 'position' => 'Директор', 'phone' => '0955556677'],
                    ['name' => 'Наталія Гриценко', 'position' => 'Диспетчер', 'phone' => '0955556678'],
                ],
                'products' => [
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2000],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2250],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's4', 'winter' => 'without', 'price' => 2500],
                ],
            ],
            [
                'user' => ['first_name' => 'Ігор', 'last_name' => 'Ткачук', 'email' => 'info@rivnebeton.com.ua', 'phone' => '0681234567'],
                'business' => ['name' => 'РівнеБетон', 'phone' => '0362123456', 'email' => 'beton@rivnebeton.com.ua', 'description' => 'Виробництво бетону та будівельних розчинів у Рівному. Працюємо з замовленнями від 2 м3. Доставка по місту та області власним транспортом.', 'address' => 'м. Рівне, вул. Курчатова, 18', 'www' => ''],
                'factories' => [
                    ['name' => 'Завод РівнеБетон', 'address' => 'м. Рівне, вул. Курчатова, 18', 'region' => 'Рівненська область', 'lat' => 50.6089, 'lng' => 26.2768],
                ],
                'contacts' => [
                    ['name' => 'Ігор Ткачук', 'position' => 'Директор', 'phone' => '0681234567'],
                ],
                'products' => [
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's2', 'winter' => 'without', 'price' => 1950],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2150],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'hot_water', 'price' => 2400],
                ],
            ],
            [
                'user' => ['first_name' => 'Петро', 'last_name' => 'Іваненко', 'email' => 'info@poltavabeton.ua', 'phone' => '0509998877'],
                'business' => ['name' => 'ПолтаваБетон', 'phone' => '0532456789', 'email' => 'sales@poltavabeton.ua', 'description' => 'Полтавський бетонний завод. Виробляємо високоякісний товарний бетон для будівельних потреб. Маємо сертифікати відповідності на всю продукцію.', 'address' => 'м. Полтава, вул. Зіньківська, 110', 'www' => ''],
                'factories' => [
                    ['name' => 'Завод ПолтаваБетон', 'address' => 'м. Полтава, вул. Зіньківська, 110', 'region' => 'Полтавська область', 'lat' => 49.6020, 'lng' => 34.5272],
                ],
                'contacts' => [
                    ['name' => 'Петро Іваненко', 'position' => 'Директор', 'phone' => '0509998877'],
                ],
                'products' => [
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 1980],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2200],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2500],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm10', 'price' => 2800],
                ],
            ],
            [
                'user' => ['first_name' => 'Василь', 'last_name' => 'Олійник', 'email' => 'info@frankivskbeton.ua', 'phone' => '0637778899'],
                'business' => ['name' => 'Франківськ Бетон', 'phone' => '0342567890', 'email' => 'order@frankivskbeton.ua', 'description' => 'Виробник бетону в Івано-Франківську. Спеціалізуємося на будівництві в гірських умовах. Підвищена морозостійкість та водонепроникність нашої продукції.', 'address' => 'м. Івано-Франківськ, вул. Промислова, 25', 'www' => ''],
                'factories' => [
                    ['name' => 'Завод Франківськ Бетон', 'address' => 'м. Івано-Франківськ, вул. Промислова, 25', 'region' => 'Івано-Франківська область', 'lat' => 48.9058, 'lng' => 24.7319],
                ],
                'contacts' => [
                    ['name' => 'Василь Олійник', 'position' => 'Директор', 'phone' => '0637778899'],
                ],
                'products' => [
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'hot_water', 'price' => 2250],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f200', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'hot_water', 'price' => 2500],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f300', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 2800],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's4', 'winter' => 'm10', 'price' => 3100],
                ],
            ],
            [
                'user' => ['first_name' => 'Тарас', 'last_name' => 'Мороз', 'email' => 'info@budmix.com.ua', 'phone' => '0961122334'],
                'business' => ['name' => 'БудМікс Київ', 'phone' => '0441112233', 'email' => 'beton@budmix.com.ua', 'description' => 'Сучасний бетонозмішувальний завод у Києві. Автоматизоване виробництво, контроль якості кожної партії. Доставка по Києву протягом 2 годин.', 'address' => 'м. Київ, вул. Червоноткацька, 44', 'www' => 'https://budmix.com.ua'],
                'factories' => [
                    ['name' => 'БудМікс — Дарницький', 'address' => 'м. Київ, Дарницький р-н, вул. Червоноткацька, 44', 'region' => 'Київська область', 'lat' => 50.4199, 'lng' => 30.6442],
                ],
                'contacts' => [
                    ['name' => 'Тарас Мороз', 'position' => 'Комерційний директор', 'phone' => '0961122334'],
                    ['name' => 'Катерина Савчук', 'position' => 'Менеджер замовлень', 'phone' => '0961122335'],
                ],
                'products' => [
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2200],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'without', 'price' => 2400],
                    ['mark' => '350', 'class' => 'b25', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'without', 'price' => 2700],
                    ['mark' => '400', 'class' => 'b30', 'frost' => 'f200', 'water' => 'w8', 'mobility' => 's4', 'winter' => 'm5', 'price' => 3000],
                    ['mark' => '500', 'class' => 'b40', 'frost' => 'f300', 'water' => 'w10', 'mobility' => 's5', 'winter' => 'm10', 'price' => 3500],
                ],
            ],
            [
                'user' => ['first_name' => 'Степан', 'last_name' => 'Козак', 'email' => 'info@ternobeton.ua', 'phone' => '0973344556'],
                'business' => ['name' => 'ТерноБетон', 'phone' => '0352234567', 'email' => 'sales@ternobeton.ua', 'description' => 'Тернопільський виробник товарного бетону та будівельних сумішей. Обслуговуємо Тернопільську, Хмельницьку та Волинську області.', 'address' => 'м. Тернопіль, вул. Промислова, 3', 'www' => ''],
                'factories' => [
                    ['name' => 'Завод ТерноБетон', 'address' => 'м. Тернопіль, вул. Промислова, 3', 'region' => 'Тернопільська область', 'lat' => 49.5413, 'lng' => 25.5772],
                ],
                'contacts' => [
                    ['name' => 'Степан Козак', 'position' => 'Директор', 'phone' => '0973344556'],
                ],
                'products' => [
                    ['mark' => '150', 'class' => 'b12', 'frost' => 'f100', 'water' => 'w4', 'mobility' => 's2', 'winter' => 'without', 'price' => 1900],
                    ['mark' => '200', 'class' => 'b15', 'frost' => 'f150', 'water' => 'w4', 'mobility' => 's3', 'winter' => 'without', 'price' => 2100],
                    ['mark' => '250', 'class' => 'b20', 'frost' => 'f150', 'water' => 'w6', 'mobility' => 's3', 'winter' => 'hot_water', 'price' => 2350],
                ],
            ],
        ];

        $userCounter = User::count();

        foreach ($companies as $companyData) {
            $userCounter++;

            // Create seller user
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

            // Create business
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

            // Create contacts
            foreach ($companyData['contacts'] as $contactData) {
                BusinessContacts::create([
                    'business_id' => $business->id,
                    'name' => $contactData['name'],
                    'position' => $contactData['position'],
                    'phone' => $contactData['phone'],
                ]);
            }

            // Create factories
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

                // Create products for each factory
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

        echo "Seeded: " . count($companies) . " businesses, " .
            array_sum(array_map(fn($c) => count($c['factories']), $companies)) . " factories, " .
            array_sum(array_map(fn($c) => count($c['products']) * count($c['factories']), $companies)) . " products\n";
    }
}
