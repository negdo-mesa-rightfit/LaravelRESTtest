<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Request\CreateMakerRequest;
use App\Http\Requests\CreateVehicleRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Maker;
use App\Vehicle;

class MakerVehiclesController extends Controller {
	public function __construct() {
		$this->middleware('auth.basic', ['except' => ['index', 'show']]);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$maker = Maker::find($id);
		if (!$maker) {
			return response()->json(['message' => 'This maker does not exist', 'code' => '404'], 404);
		}
		return response()->json(['data' => $maker->vehicles]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateVehicleRequest $request, $makerId)
	{
		if(!$maker = Maker::find($makerId)) {
			return response()->json(['message' => 'This maker does not exist', 'code' => '404'], 404);
		}

		$values = $request->all();

		$maker->vehicles()->create($values);

		return response()->json(['message' => 'Vehicle correctly added'], 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $vehicleId)
	{
		$maker = Maker::find($id);
		if (!$maker) {
			return response()->json(['message' => 'This maker does not exist', 'code' => '404'], 404);
		}

		$vehicle = $maker->vehicles->find($vehicleId);

		if (!$vehicle) {
			return response()->json(['message' => 'This vehicle does not exist for this maker', 'code' => '404'], 404);	
		}
		return response()->json(['data' => $vehicle]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateVehicleRequest $request, $makerId, $vehicleId)
	{
		if(!$maker = Maker::find($makerId)) {
			return response()->json(['message' => 'This maker does not exist', 'code' => '404'], 404);
		}

		if(!$vehicle = $maker->vehicles()->find($vehicleId)) {
			return response()->json(['message' => 'This vehicle does not exist', 'code' => '404'], 404);
		}

		$vehicle->color = $request->get('color');
		$vehicle->power = $request->get('power');
		$vehicle->capacity = $request->get('capacity');
		$vehicle->speed = $request->get('speed');

		$vehicle->save();
		

		return response()->json(['message' => 'Vehicle correctly updated'], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, $vehicleId)
	{
		$maker = Maker::find($id);
		if (!$maker) {
			return response()->json(['message' => 'This maker does not exist', 'code' => '404'], 404);
		}

		$vehicle = $maker->vehicles->find($vehicleId);
		if (!$vehicle) {
			return response()->json(['message' => 'This vehicle does not exist for this maker', 'code' => '404'], 404);	
		}


		$vehicle->delete();
		return response()->json(['message' => 'Vehicle deleted', 'code' => '200'], 200);
	}

}
