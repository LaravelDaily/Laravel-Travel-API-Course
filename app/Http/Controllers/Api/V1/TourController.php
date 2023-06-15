<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToursListRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;

/**
 * @group Public endpoints
 */
class TourController extends Controller
{
    /**
     * GET Travel Tours
     *
     * Returns paginated list of tours by travel slug.
     *
     * @urlParam travel_slug string Travel slug. Example: "first-travel"
     *
     * @bodyParam priceFrom number. Example: "123.45"
     * @bodyParam priceTo number. Example: "234.56"
     * @bodyParam dateFrom date. Example: "2023-06-01"
     * @bodyParam dateTo date. Example: "2023-07-01"
     * @bodyParam sortBy string. Example: "price"
     * @bodyParam sortOrder string. Example: "asc" or "desc"
     *
     * @response {"data":[{"id":"9958e389-5edf-48eb-8ecd-e058985cf3ce","name":"Tour on Sunday","starting_date":"2023-06-11","ending_date":"2023-06-16","price":"99.99"},{"id":"9958e389-5edf-48eb-8ecd-e058985cf3c2","name":"Tour on Tuesday","starting_date":"2023-06-14","ending_date":"2023-06-19","price":"119.99"},{"id":"9958e389-5edf-48eb-8ecd-e058985cf3c1","name":"Tour on Monday","starting_date":"2023-06-18","ending_date":"2023-06-23","price":"79.99"}],"links":{"first":"http://travel-api.test/api/v1/travels/first-travel/tours?page=1","last":"http://travel-api.test/api/v1/travels/first-travel/tours?page=1","prev":null,"next":null},"meta":{"current_page":1,"from":1,"last_page":1,"links":[{"url":null,"label":"&laquo; Previous","active":false},{"url":"http://travel-api.test/api/v1/travels/first-travel/tours?page=1","label":"1","active":true},{"url":null,"label":"Next &raquo;","active":false}],"path":"http://travel-api.test/api/v1/travels/first-travel/tours","per_page":15,"to":3,"total":3}}
     *
     */
    public function index(Travel $travel, ToursListRequest $request)
    {
        $tours = $travel->tours()
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('starting_date', '<=', $request->dateTo);
            })
            ->when($request->sortBy, function ($query) use ($request) {
                if (! in_array($request->sortBy, ['price'])
                    || (! in_array($request->sortOrder, ['asc', 'desc']))) {
                    return;
                }

                $query->orderBy($request->sortBy, $request->sortOrder);
            })
            ->orderBy('starting_date')
            ->paginate();

        return TourResource::collection($tours);
    }
}
