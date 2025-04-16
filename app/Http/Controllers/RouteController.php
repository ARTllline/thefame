<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SpecialOffer;
use App\Models\TeamMember;
use App\Models\Device;
use App\Models\About;
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
        $region = $request->session()->get('region', 'ua');

        $services = Service::with(['category', 'variants'])
            ->where(function ($query) use ($region) {
                $query->whereHas('region', function ($query) use ($region) {
                    $query->where('code', $region);
                })->orWhereDoesntHave('region');
            })
            ->ordered()
            ->get();

        return view('services', compact('services', 'region'));
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
