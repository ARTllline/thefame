<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Models\SpecialOffer;
use App\Models\TeamMember;
use App\Models\Device;
use App\Models\About;
use App\Models\Gallery;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;


class RouteController extends Controller
{

    public function showHome(Request $request)
    {

        $region = $request->session()->get('region', 'ua');

        $specialOffers = SpecialOffer::where(function ($query) use ($region) {
            $query->whereHas('region', function ($query) use ($region) {
                $query->where('code', $region);
            })->orWhereDoesntHave('region');
        })->ordered()
            ->get();

        $about = About::where('code', 'main')->first();

        return view('home', compact('specialOffers', 'about'));

    }

    public function showTeam(Request $request)
    {
        $region = $request->session()->get('region', 'ua');
        $team = TeamMember::where(function ($query) use ($region) {
            $query->whereHas('region', function ($query) use ($region) {
                $query->where('code', $region);
            })->orWhereDoesntHave('region');
        })->ordered()->get();
        return view('team', compact('team'));
    }

    public function showAbout()
    {
        $about = About::where('code', 'full')->first();

        return view('about', compact('about'));
    }

    public function showContact()
    {
        return view('contact');
    }

    public function showServices(Request $request)
    {
        // Определяем текущий регион из сессии
        $regionCode = $request->session()->get('region', 'ua');

        // Загружаем категории, у которых есть хотя бы один сервис для данного региона,
        // и жадно загружаем эти сервисы вместе с вариантами
        $categories = Category::with(['services' => function ($serviceQuery) use ($regionCode) {
            $serviceQuery
                ->with('variants')
                // фильтрация сервисов по региону
                ->where(function ($q) use ($regionCode) {
                    $q->whereHas('region', function ($r) use ($regionCode) {
                        $r->where('code', $regionCode);
                    })
                        ->orWhereDoesntHave('region');
                })
                ->ordered();
        }])
            // гарантируем, что категория имеет хотя бы один сервис для этого региона
            ->whereHas('services', function ($serviceQuery) use ($regionCode) {
                $serviceQuery->where(function ($q) use ($regionCode) {
                    $q->whereHas('region', function ($r) use ($regionCode) {
                        $r->where('code', $regionCode);
                    })
                        ->orWhereDoesntHave('region');
                });
            })
            ->ordered()
            ->get();

        return view('services', compact('categories'));
    }

    public function showGallery(Request $request)
    {
        $region = $request->session()->get('region', 'ua');

        $gallery = Gallery::where(function ($query) use ($region) {
            $query->whereHas('region', function ($query) use ($region) {
                $query->where('code', $region);
            })->orWhereDoesntHave('region');
        })->first();

        return view('gallery', compact('gallery'));
    }

    public function showDevices(Request $request)
    {

        $region = $request->session()->get('region', 'ua');

        $devices = Device::where(function ($query) use ($region) {
            $query->whereHas('region', function ($query) use ($region) {
                $query->where('code', $region);
            })->orWhereDoesntHave('region');
        })
            ->ordered()
            ->get();

        return view('devices', compact('devices'));

    }

    public function showService(Service $service, Request $request)
    {
        $region = $request->session()->get('region', 'ua');

        // Подгружаем связанную модель региона
        $service->load('region');

        if ($service->region->code !== $region) {
            redirect('home');
        }

        $service->load([
            'variants' => function ($query) {
                $query->ordered();
            },
            'variants.prices' => function ($query) {
                $query->ordered();
            }
        ]);

        return view('service-card', compact('service', 'region'));
    }

    public function showSpecialOffer(SpecialOffer $offer, Request $request)
    {
        $region = $request->session()->get('region', 'ua');

        // Подгружаем связанную модель региона
        $offer->load('region');

        if ($offer->region->code !== $region) {
            redirect('home');
        }


        return view('special-offer', compact('offer'));
    }

}
