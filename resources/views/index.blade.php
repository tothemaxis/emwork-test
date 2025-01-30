<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @vite(['resources/css/app.css'])
</head>

<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-5">EMWORK</h4>
        <a href="javascript:;">รายการปฏิบัติงาน</a>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <span class="navbar-brand">{{ $title }}</span>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="mt-5">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group d-flex align-items-center mb-3">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="filterType" id="byDate"
                                value="date" checked>
                            <label class="form-check-label" for="byDate">ผลการปฎิบัติงานประจำวัน</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filterType" id="byMonth"
                                value="month">
                            <label class="form-check-label" for="byMonth">สรุปจำนวนสถานะการทำงาน</label>
                        </div>
                    </div>

                    <div id="by-date">
                        <div class="col-md-4">
                            <label class="form-label">ค้นหา</label>
                            <input type="text" class="form-control search-input" id="search"
                                placeholder="ค้นหาด้วยวันที่ดำเนินการ">
                        </div>
                    </div>


                    <div id="by-month" class="d-none">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">ค้นหา</label>
                                @php
                                    $months = [
                                        '1' => 'มกราคม',
                                        '2' => 'กุมภาพันธ์',
                                        '3' => 'มีนาคม',
                                        '4' => 'เมษายน',
                                        '5' => 'พฤษภาคม',
                                        '6' => 'มิถุนายน',
                                        '7' => 'กรกฎาคม',
                                        '8' => 'สิงหาคม',
                                        '9' => 'กันยายน',
                                        '10' => 'ตุลาคม',
                                        '11' => 'พฤศจิกายน',
                                        '12' => 'ธันวาคม',
                                    ];
                                @endphp
                                <select class="form-control search-input" id="search-month">
                                    <option value="">ทั้งหมด</option>
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">สถานะ</label>
                                <select class="form-control search-input" id="search-status">
                                    <option value="">ทั้งหมด</option>
                                    <option value="ดำเนินการ">ดำเนินการ</option>
                                    <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                                    <option value="ยกเลิก">ยกเลิก</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col text-end">
                        <button class="btn btn-primary" id="new-btn">เพิ่มข้อมูล</button>
                    </div>
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <input type="hidden" id="findone_url" value="{{ route('operations.findOne', 'id') }}">
    <input type="hidden" id="destroy_url" value="{{ route('operations.destroy', 'id') }}">
    <div class="modal fade" id="form-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">จัดการการปฏิบัติงาน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('operations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">ชื่องาน</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="ชื่องาน" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">เวลาเริ่มดำเนินการ</label>
                                <input type="text" class="form-control datePicker" id="start-time"
                                    name="start_time" placeholder="เวลาเริ่มดำเนินการ" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">เวลาที่เสร็จสิ้น</label>
                                <input type="text" class="form-control datePicker" id="end-time" name="end_time"
                                    placeholder="เวลาที่เสร็จสิ้น">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">ประเภทงาน</label>
                                <select class="form-control" id="work-type" name="work_type" required>
                                    <option value="">เลือกประเภทงาน</option>
                                    <option value="Development">Development</option>
                                    <option value="Test">Test</option>
                                    <option value="Document">Document</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">สถานะ</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="ดำเนินการ">ดำเนินการ</option>
                                    <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                                    <option value="ยกเลิก">ยกเลิก</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        @vite(['resources/js/main.js'])

</body>

</html>
