<?php


namespace App\Http\Controllers;


use App\Repositories\Car\CarRepository;
use Illuminate\Http\Request;


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
        $model = $request->post('model');
        $year = $request->post('year');

        $newCar = $this->carRepository->create([
            'model' => $model,
            'year' => $year
        ]);

        return \response()->json($newCar, 201);

    }

    public function getAllCar(Request $request)
    {
        $cars = $this->carRepository->all();

        return \response()->json($cars, 200);
    }

    public function getCar(Request $request)
    {

        $id = $request->get('id');
        $car = $this->carRepository->find($id);
        if (!$car) {
            return \response()->json(null, 404);
        }
        return \response()->json($car, 200);
    }


    public function deleteCar(Request $request)
    {
        $id = $request->get('id');
        $car = $this->carRepository->find($id);
        if ($car) {
            $car->delete();

            return response()->json([
                'message' => 'Deleted'
            ]);
        }
        return response()->json([
            'message' => 'Not found'
        ]);
    }

    public function updateCar(Request $request)
    {
        $id = $request->get('id');
        $model = $request->get('model');
        $year = $request->get('year');

        $car = $this->carRepository->update([
            'model' => $model,
            'year' => $year
        ], $id);
        if (!$car) {
            return \response()->json(null, 404);
        }

        return \response()->json($car, 200);

    }


}
