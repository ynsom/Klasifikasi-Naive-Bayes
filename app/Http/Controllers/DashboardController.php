<?php

namespace App\Http\Controllers;

use App\Models\Aplication;
use App\Models\Reviews;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "dashboard";
        $app = Aplication::count();
        $negative = Reviews::where('sentiment', "negative")->count();
        $positive = Reviews::where('sentiment', "positive")->count();
        $data = Aplication::withCount([
            'review as negative_reviews' => function ($query) {
                $query->where('sentiment', 'negative');
            },
            'review as neutral_reviews' => function ($query) {
                $query->where('sentiment', 'neutral');
            },
            'review as positive_reviews' => function ($query) {
                $query->where('sentiment', 'positive');
            },
            'review as total_reviews'
        ])->get();

        $applications = $data->map(function ($app) {
            $totalReviews = $app->total_reviews;
            $positivePercentage = $totalReviews > 0 ? ($app->positive_reviews / $totalReviews) * 100 : 0;

            return [
                'name' => $app->name,
                'negative' => $app->negative_reviews,
                'neutral' => $app->neutral_reviews,
                'positive' => $app->positive_reviews,
                'positive_percentage' => $positivePercentage
            ];
        });

        $chartData = $applications->map(function ($app) {
            return [
                'name' => $app['name'],
                'positive_percentage' => $app['positive_percentage']
            ];
        });

        return view('dashboard')->with(compact('title', 'negative', 'positive', 'applications', 'chartData', 'app'));
    }
}
