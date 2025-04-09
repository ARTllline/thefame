<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SpecialOffer;
use App\Models\TeamMember;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;


class RouteController extends Controller
{

    public function showHome(Request $request)
    {

        $region = $request->session()->get('region', 'ua');

        $specialOffers = SpecialOffer::whereHas('region', function ($query) use ($region) {
            $query->where('code', $region);
        })
            ->ordered()
            ->get();

        return view('home', compact('specialOffers'));

    }

    public function showTeam()
    {
        $team = TeamMember::ordered()->get();
        return view('team', compact('team'));
    }

    public function showAbout()
    {

        return view('about');
    }

    public function showContact()
    {
        return view('contact');
    }

    public function showServices(Request $request)
    {
        $region = $request->session()->get('region', 'ua');

        $services = Service::with(['category', 'variants'])
            ->whereHas('region', function ($query) use ($region) {
                $query->where('code', $region);
            })
            ->ordered()
            ->get();

        return view('services', compact('services', 'region'));
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
