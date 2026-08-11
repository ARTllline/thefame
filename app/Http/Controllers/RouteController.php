<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Models\SpecialOffer;
use App\Models\TeamMember;
use App\Models\Device;
use App\Models\About;
use App\Models\Gallery;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function showHome()
    {
        // 1. Специальные предложения (без фильтрации по региону)
        $specialOffers = SpecialOffer::ordered()->get();

        // 2. Блоки "О нас"
        $aboutMain = About::where('code', 'main')->first();

        // 3. Категории и услуги (без фильтрации по региону)
        $categories = Category::with(['services' => function ($serviceQuery) {
            $serviceQuery->with('variants')->ordered();
        }])
            ->whereHas('services', function ($query) {
                $query->where('region_id', 1);
            })
            ->ordered()
            ->get();

        // 4. Команда
        $team = TeamMember::ordered()->get();

        // 5. Галерея
        $gallery = Gallery::first();

        // 6. Оборудование (если планируете выводить на лендинге)
        $devices = Device::where('region_id', 1)->ordered()->get();

        // Передаем всё на единую страницу
        return view('home', compact(
            'specialOffers',
            'aboutMain',
            'categories',
            'team',
            'gallery',
            'devices'
        ));
    }

    // Оставляем методы для детальных страниц, если они открываются отдельно (например, по клику из лендинга)
    public function showService(string $service)
    {
        $service = Service::where('code', $service)->first();

        $service->load([
            'variants' => function ($query) {
                $query->ordered();
            },
            'variants.prices' => function ($query) {
                $query->ordered();
            }
        ]);

        return view('service-card', compact('service'));
    }

    public function showSpecialOffer(SpecialOffer $offer)
    {
        // Убрали проверку региона
        return view('special-offer', compact('offer'));
    }
}
