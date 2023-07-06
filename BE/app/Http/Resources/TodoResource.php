<?php

namespace App\Http\Resources;

use App\Abstracts\AbstractResource;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Schema(
 *     title="TodoResource",
 *     description="Todo resource",
 *     @OA\Xml(
 *         name="TodoResource"
 *     )
 * )
 */

class TodoResource extends AbstractResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Project[]
     */
    private $data;

        /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    {
        return parent::toArray($request);
    }
}
