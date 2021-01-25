<?php


namespace App\Repositories\Car;
use  App\Models\Car;

use Prettus\Repository\Eloquent\BaseRepository;

class CarRepository extends BaseRepository implements CarRepositoryInterface
{

    public function model()
    {
        // TODO: Implement model() method.
        return Car::class;
    }
}
