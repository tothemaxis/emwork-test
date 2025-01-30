const pickerOptions = {
    altInput: true,
    altFormat: "Y-m-d H:i",
    dateFormat: "Y-m-d H:i:s",
    enableTime: true,
};
$(".datePicker").flatpickr(pickerOptions);

$("#search").flatpickr({
    altInput: true,
    altFormat: "Y-m-d",
    dateFormat: "Y-m-d",
});

$(".search-input").change(function () {
    window.LaravelDataTables["dailyoperation-table"].ajax.reload();
});

$('input[name="filterType"]').change(function () {
    let selectedValue = $(this).val();

    if (selectedValue === "date") {
        $("#search-month, #search-status").val("");
        $("#by-date").removeClass("d-none");
        $("#by-month").addClass("d-none");
    } else if (selectedValue === "month") {
        flatpickr("#search", {
            altInput: true,
            altFormat: "Y-m-d",
            dateFormat: "Y-m-d",
        }).setDate("");
        $("#by-date").addClass("d-none");
        $("#by-month").removeClass("d-none");
    }
});

$("#form").submit(function (e) {
    e.preventDefault();
    if ($("#start-time").val() == "") {
        alert("กรุณาเลือกเวลาเริ่มดำเนินการ");
    } else {
        $(this)[0].submit();
    }
});

$("#new-btn").click(function () {
    resetForm();
    $("#form-modal").modal("show");
});

$(document).on("click", ".edit-btn", function () {
    const url = $("#findone_url").val().replace("id", $(this).data("id"));
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response) {
                fillForm(response);
            }
        },
    });
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$(document).on("click", ".del-btn", function () {
    if (confirm("ยืนยันการลบ?")) {
        const url = $("#destroy_url").val().replace("id", $(this).data("id"));
        $.ajax({
            url: url,
            type: "DELETE",
            success: function (response) {
                window.LaravelDataTables["dailyoperation-table"].ajax.reload();
            },
        });
    }
});

function fillForm(data) {
    resetForm();
    $("#id").val(data.id);
    $("#name").val(data.name);
    flatpickr("#start-time", pickerOptions).setDate(data.start_time);
    flatpickr("#end-time", pickerOptions).setDate(data.end_time);
    $("#work-type").val(data.work_type).change();
    $("#status").val(data.status).change();
    $("#form-modal").modal("show");
}

function resetForm() {
    $("#form")[0].reset();
    $("#id").val("");
}
