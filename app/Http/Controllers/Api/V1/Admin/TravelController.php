<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

/**
 * @group Admin endpoints
 */
class TravelController extends Controller
{
    /**
     * POST Travel
     *
     * Creates a new Travel record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"996a36ca-2693-4901-9c55-7136e68d81d5","name":"My new travel 234","slug":"my-new-travel-234","description":"The second best journey ever!","number_of_days":"4","number_of_nights":3}}
     * @response 422 {"message":"The name has already been taken.","errors":{"name":["The name has already been taken."]}}
     */
    public function store(TravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

    /**
     * PUT Travel
     *
     * Updates new Travel record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"996a36ca-2693-4901-9c55-7136e68d81d5","name":"My new travel 234","slug":"my-new-travel-234","description":"The second best journey ever!","number_of_days":"4","number_of_nights":3}}
     * @response 422 {"message":"The name has already been taken.","errors":{"name":["The name has already been taken."]}}
     */
    public function update(Travel $travel, TravelRequest $request)
    {
        $travel->update($request->validated());

        return new TravelResource($travel);
    }
}
