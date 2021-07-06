<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $data = Department::withCount('employees')->withMax('employees', 'salary')->get();
            return response()->json($data, 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentRequest $request
     * @return Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();
            Department::create($validated);
            return response('OK', 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $data = Department::findOrFail($id);
            return response()->json($data, 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentRequest $request
     * @param $id
     * @return Response
     */
    public function update(DepartmentRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $department = Department::findOrFail($id);
            $department->update($validated);
            return response('OK', 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        try {
            Department::destroy($id);
            return response('OK', 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }
}
