<?php


namespace App\Http\Controllers;



use App\Http\Requests\Car\CreateCarRequest;
use App\Http\Requests\Car\DeleteCarRequest;
use App\Http\Requests\Car\DetailCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Http\Resources\Car\CarDetailResource;
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


    public function createCar(CreateCarRequest $request)

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


        return \response()->json(CarDetailResource::collection($cars), 200); //param cars is a Collection - so we use CarDetailResource:collection
    }

    public function getCar(DetailCarRequest $request)
    {

        $id = $request->get('id');
        $car = $this->carRepository->find($id);
        if (!$car) {
            return \response()->json(null, 404);
        }

        return \response()->json(new CarDetailResource($car), 200);
    }


    public function deleteCar(DeleteCarRequest $request)
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


    public function updateCar(UpdateCarRequest $request)

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
