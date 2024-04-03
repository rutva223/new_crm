
$(function () {
    $('.multi-select').select2();
    loadConfirm();

});
$(document).ready(function() {
    // Function to check if all required fields are filled
    function checkRequiredFields() {
        var allFieldsFilled = true;
        $('.form-control[required]').each(function() {
            if ($(this).val() === '') {
                allFieldsFilled = false;
                return false; // Exit the loop early if a required field is empty
            }
        });
        return allFieldsFilled;
    }

    // Function to enable or disable the Create button based on required field completion
    function toggleCreateButton() {
        var allFieldsFilled = checkRequiredFields();
        $('#createButton').prop('disabled', !allFieldsFilled);
    }

    // Call the toggleCreateButton function when any form field changes
    $('.form-control').on('input', function() {
        toggleCreateButton();
    });
});
    
function loadConfirm() {
    $(document).on("click", ".js-sweetalert", function () {
        var form = $(this).closest("form");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        Swal.fire({
            title: "Are you sure?",
            text: "This action can not be undone. Do you want to continue?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            console.log(form);
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
}
$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var title = $(this).data('title');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');
    $("#commonModal .modal-title").html(title);
    $("#commonModal .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        beforeSend: function () {
            $(".loader-wrapper").removeClass('d-none');
        },
        success: function (data) {
            $(".loader-wrapper").addClass('d-none');
            $('#commonModal .body').html(data);
            $("#commonModal").modal('show');
        },
        error: function (data) {
            $(".loader-wrapper").addClass('d-none');
            data = data.responseJSON;
            toastrs('Error', data.error, 'error')
        }
    });
});
