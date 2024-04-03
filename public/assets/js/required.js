

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
        $('#updateButton').prop('disabled', !allFieldsFilled);
    }

    // Call the toggleCreateButton function when any form field changes
    $('.form-control').on('input', function() {
        toggleCreateButton();
    });
});


