<?php


namespace App\Http\Controllers;


use App\Repositories\Car\CarRepository;
use App\Repositories\Car\CarRepositoryInterface;
use http\Env\Response;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;


class CarController extends BaseController
{
    protected $carRepository;

    /**
     * CarController constructor.
     * @param $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function createCar(Request $request)
    {
        $model = $request->get('model');
        $year = $request->get('year');
        dd($model);
        $newCar = $this->carRepository->create([
            'model' => $model,
            'year' => $year
        ]);

        return $newCar;

    }

    public function getAllCar(Request $request)
    {
        $cars = $this->carRepository->all();
        dd($cars);
        return $cars;
    }

    public function getCar(Request $request)
    {

        $id = $request->get('id');
        $car = $this->carRepository->find($id);
        if (!$car) {
            return null;
        }
        return $car;
    }

    public function updateCar(Request $request)
    {
        $id = $request->get('id');
        $model = $request->get('model');
    }

    public function deleteCar(Request $request)
    {
        $id = $request->get('id');
        $car = $this->carRepository->find($id);
        if($car){
            $car->delete();

            return response()->json([
                'message' => 'Deleted'
            ]);
        }
        return response()->json([
            'message' => 'Not found'
        ]);
    }


}