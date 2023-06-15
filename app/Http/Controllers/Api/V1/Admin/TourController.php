<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

/**
 * @group Admin endpoints
 */
class TourController extends Controller
{
    /**
     * POST Tour
     *
     * Creates a new Tour record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"996a381e-64ca-46ba-8b51-f8279d5529ad","name":"Tour 1","starting_date":"2023-06-15","ending_date":"2023-06-20","price":"99.99"}}
     * @response 422 {"message":"The name has already been taken.","errors":{"name":["The name has already been taken."]}}
     */
    public function store(Travel $travel, TourRequest $request)
    {
        $tour = $travel->tours()->create($request->validated());

        return new TourResource($tour);
    }
}
