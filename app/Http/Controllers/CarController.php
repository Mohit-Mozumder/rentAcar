<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::paginate(8);
        return view('admin.cars', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.createCar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'brand' => 'required',
        'model' => 'required',
        'engine' => 'required',
        'quantity' => 'required|integer',
        'price_per_day' => 'required|numeric',
        'status' => 'required',
        'reduce' => 'required|integer',
        'stars' => 'required|integer',
        'driver_name' => 'nullable|string',
        'driver_phone' => 'nullable|string',
        'driver_nid' => 'nullable|string',
        'driver_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
    ]);

    $car = new Car;
    $car->brand = $request->brand;
    $car->model = $request->model;
    $car->engine = $request->engine;
    $car->quantity = $request->quantity;
    $car->price_per_day = $request->price_per_day;
    $car->status = $request->status;
    $car->reduce = $request->reduce;
    $car->stars = $request->stars;
    $car->driver_name = $request->driver_name;
    $car->driver_phone = $request->driver_phone;
    $car->driver_nid = $request->driver_nid;

    if ($request->hasFile('image')) {
        $imageName = $request->brand . '-' . $request->model . '-' . $request->engine . '-' . Str::random(10) . '.' . $request->file('image')->extension();
        $image = $request->file('image');
        $path = $image->storeAs('images/cars', $imageName);
        $car->image = '/' . $path;
    }

    if ($request->hasFile('driver_photo')) {
        $driverPhotoName = $request->driver_name . '-' . Str::random(10) . '.' . $request->file('driver_photo')->extension();
        $driverPhoto = $request->file('driver_photo');
        $driverPhotoPath = $driverPhoto->storeAs('images/drivers', $driverPhotoName);
        $car->driver_photo = '/' . $driverPhotoPath;
    }

    $car->save();

    return redirect()->route('cars.index');
}

public function update(Request $request, Car $car)
{
    $request->validate([
        'brand' => 'required',
        'model' => 'required',
        'engine' => 'required',
        'quantity' => 'required|integer',
        'price_per_day' => 'required|numeric',
        'status' => 'required',
        'reduce' => 'required|integer',
        'stars' => 'required|integer',
        'driver_name' => 'nullable|string',
        'driver_phone' => 'nullable|string',
        'driver_nid' => 'nullable|string',
        'driver_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
    ]);

    $car->brand = $request->brand;
    $car->model = $request->model;
    $car->engine = $request->engine;
    $car->quantity = $request->quantity;
    $car->price_per_day = $request->price_per_day;
    $car->status = $request->status;
    $car->reduce = $request->reduce;
    $car->stars = $request->stars;
    $car->driver_name = $request->driver_name;
    $car->driver_phone = $request->driver_phone;
    $car->driver_nid = $request->driver_nid;

    if ($request->hasFile('image')) {
        $filename = basename($car->image);
        Storage::disk('local')->delete('images/cars/' . $filename);
        $imageName = $request->brand . '-' . $request->model . '-' . $request->engine . '-' . Str::random(10) . '.' . $request->file('image')->extension();
        $image = $request->file('image');
        $path = $image->storeAs('images/cars', $imageName);
        $car->image = '/' . $path;
    }

    if ($request->hasFile('driver_photo')) {
        $driverPhotoName = $request->driver_name . '-' . Str::random(10) . '.' . $request->file('driver_photo')->extension();
        $driverPhoto = $request->file('driver_photo');
        $driverPhotoPath = $driverPhoto->storeAs('images/drivers', $driverPhotoName);
        $car->driver_photo = '/' . $driverPhotoPath;
    }

    $car->save();

    return redirect()->route('cars.index');
}
}