<?php

namespace App\Http\Controllers;

use App\DataTables\DailyOperationDataTable;
use App\Models\DailyOperations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MainController extends Controller
{
    public function index(DailyOperationDataTable $dataTable)
    {
        $title = 'รายการการปฎิบัติงานประจำวัน';
        return $dataTable->render('index', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'work_type' => 'required',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'status' => 'required',
        ]);
        try {
            if ($request->id != '') {
                // Update Process
                $operation = DailyOperations::findOrFail($request->id);
                $operation->update([
                    'name' => $request->name,
                    'work_type' => $request->work_type,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'status' => $request->status,
                    'updated_at' => now(), // This is actually not needed because Laravel automatically updates timestamps
                ]);
            } else {
                DailyOperations::create($request->all());
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return redirect()->route('operations.index');
    }

    public function findOne(DailyOperations $operation)
    {
        return $operation;
    }
    public function destroy(DailyOperations $operation)
    {
        $operation->delete();
    }
}
