<?php

namespace App\Http\Controllers\API;

use App\Actions\Statistics as ActionsStatistics;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\StatisticsSity;
use App\Http\Requests\Statistics\StatisticsStates;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class Statistics extends Controller
{
    public function popularStates(StatisticsStates $request, ActionsStatistics $actionOrderProducts)
    {
        $states = $actionOrderProducts->getProductsStatistics($request['period'], 'state');
        $posts = collect($states['coefficients']);

        $perPage = $request['quantity'];
        $currentPage = request("page") ?? 1;

        $states = new LengthAwarePaginator(
            $posts->slice($currentPage - 1, $perPage),
            $posts->count(),
            $perPage,
            $currentPage,
        );
        return compact('states');
    }
    public function popularStatesUser(StatisticsStates $request, ActionsStatistics $actionOrderProducts)
    {
        $states = $actionOrderProducts->getProductsUserStatistics($request['period'], 'state');
        $posts = collect($states['coefficients']);

        $perPage = $request['quantity'];
        $currentPage = request("page") ?? 1;

        $states = new LengthAwarePaginator(
            $posts->slice($currentPage - 1, $perPage),
            $posts->count(),
            $perPage,
            $currentPage,
        );
        $top = $actionOrderProducts->getProducts('state')[0];
        return compact('states', 'top');
    }
    public function popularSity(StatisticsSity $request, ActionsStatistics $actionOrderProducts)
    {
        $sities = $actionOrderProducts->getProductsStatistics($request['period'], 'sity');
        $posts = collect($sities['coefficients']);

        $perPage = $request['quantity'];
        $currentPage = request("page") ?? 0;

        return new LengthAwarePaginator(
            $posts->slice($currentPage - 1, $perPage),
            $posts->count(),
            $perPage,
            $currentPage,
        );
        return compact('sity', 'numberSalesToday');
    }
    public function popularSityUser(StatisticsSity $request, ActionsStatistics $actionOrderProducts)
    {
        $sities = $actionOrderProducts->getProductsUserStatistics($request['period'], 'sity');
        $posts = collect($sities['coefficients']);

        $perPage = $request['quantity'];
        $currentPage = request("page") ?? 0;

        return new LengthAwarePaginator(
            $posts->slice($currentPage - 1, $perPage),
            $posts->count(),
            $perPage,
            $currentPage,
        );
    }
    public function graph(StatisticsSity $request, ActionsStatistics $actionOrderProducts)
    {
        return $sities = $actionOrderProducts->graph($request['period']);
        $posts = collect($sities['coefficients']);

        $perPage = $request['quantity'];
        $currentPage = request("page") ?? 0;

        return new LengthAwarePaginator(
            $posts->slice($currentPage - 1, $perPage),
            $posts->count(),
            $perPage,
            $currentPage,
        );
    }
}
