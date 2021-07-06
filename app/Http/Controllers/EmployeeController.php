<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $data = Employee::with('departments')->get();
            return response()->json($data, 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return Response
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $validated = $request->validated();
            $employee = Employee::create($validated);
            $employee->departments()->attach($validated['department_ids']);
            return response('OK', 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $data = Employee::with('departments')->where('id', $id)->firstOrFail();
            return response()->json($data, 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @param $id
     * @return Response
     */
    public function update(EmployeeRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $employee = Employee::findOrFail($id);
            $employee->update($validated);
            $employee->departments()->sync($validated['department_ids']);
            return response('OK', 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy(int $id)
    {
        try {
            Employee::destroy($id);
            return response('OK', 200);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json('server error', 500));
        }
    }
}
