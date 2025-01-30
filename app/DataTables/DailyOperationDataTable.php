<?php

namespace App\DataTables;

use App\Models\DailyOperations;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DailyOperationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('actions', function ($row) {
                return '<button class="edit-btn" data-id="' . $row->id . '">edit</button>
                        <button class="del-btn" data-id="' . $row->id . '">delete</button>';
            })
            ->rawColumns(['actions']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DailyOperations $model): QueryBuilder
    {
        $data = $model->newQuery();
        $searchDate = $this->request->date;
        $searchMonth = $this->request->month;
        $status = $this->request->status;
        if ($searchDate != '') {
            $data = $data->whereDate('start_time', $searchDate);
        }
        if ($searchMonth != '') {
            $data = $data->whereMonth('start_time', $searchMonth);
        }
        if ($status != '') {
            $data->where('status', $status);
        }
        return $data;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('dailyoperation-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('operations.index'),
                'type' => 'GET',
                'dataType' => 'json',
                'data' => 'function (d) {
                                d.date = $("#search").val();
                                d.month = $("#search-month").val();
                                d.status = $("#search-status").val();
                            }',
            ])
            ->orderBy(3);
        // ->buttons([
        //     Button::make('excel'),
        //     Button::make('csv'),
        //     Button::make('pdf'),
        //     Button::make('print'),
        //     Button::make('reset'),
        //     Button::make('reload')
        // ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('ลำดับ')->addClass('text-center')->searchable(false)->orderable(false)->width('5%'),
            Column::make('name')->title('ชื่องาน'),
            Column::make('work_type')->title('ประเภทงาน'),
            Column::make('start_time')->title('เวลาเริ่ม'),
            Column::make('end_time')->title('เวลาสิ้นสุด'),
            Column::make('status')->title('สถานะ'),
            Column::make('created_at')->title('วันที่สร้าง'),
            Column::make('updated_at')->title('วันที่แก้ไข'),
            Column::make('actions')->title('เครื่องมือ'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DailyOperation_' . date('YmdHis');
    }
}
