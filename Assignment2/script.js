$(document).ready(() => {

    // If cID is empty then form is to add new car, If not empty then it is to edit data
    if ($("#cID").val() === "") {
        $("#add-edit-form-heading").text("Please fill the form to add new car");
    } else {
        $("#add-edit-form-heading").text("Please fill the form to edit car id " + $("#cID").val());
    }

    // While adding the new record to table, do not show the delete-car-data div
    // reset the input fields to have empty values
    $("#add-car").click(() => {
        
        $("#add-edit-form-heading").text("Please fill the form to add new car");
        $("#delete-car-data").addClass("hidden");
        $("#add-edit-car-data").removeClass("hidden");

        $("#cID").val("");
        $("#cName").val("");
        $("#cDesc").val("");
        $("#cPrice").val("");
        $("#cFuel").val("");
        $("#cDrive").val("");
        $("#cQuantity").val("");

    });

    // If cancel is clicked while adding or editing, then clear the form and show add car form
    $("#cancel-add").click((evt) => {
        evt.preventDefault();

        $("#add-edit-form-heading").text("Please fill the form to add new car");

        $("#cID").val("");
        $("#cName").val("");
        $("#cDesc").val("");
        $("#cPrice").val("");
        $("#cFuel").val("");
        $("#cDrive").val("");
        $("#cQuantity").val("");

    });

    // If a button with edit-car class is clicked, then get the car_id from the button clicked
    // and fill the input fields with values from the relevant row as initial values.
    // do not show the delete car div
    $(".edit-car").click((evt) => {
        carid = $(evt.currentTarget).attr('id').split("-")[2];

        $("#add-edit-car-data").removeClass("hidden");
        $("#delete-car-data").addClass("hidden");
        $("#add-edit-form-heading").text("Please fill the form to edit car id " + carid);

        $("#cID").val(carid);
        $("#cName").val($("#cname-"+carid).text());
        $("#cDesc").val($("#cdesc-"+carid).text());
        $("#cPrice").val($("#cprice-"+carid).text());
        $("#cFuel").val($("#cfuel-"+carid).text());
        $("#cDrive").val($("#cdrive-"+carid).text());
        $("#cQuantity").val($("#cquantity-"+carid).text());
    });

    // When a button with delete-car class is clicked. Get the id of the car from the button
    // set the text of the span and hidden input field to car_id
    $(".delete-car").click((evt) => {
        carid = $(evt.currentTarget).attr('id').split("-")[2];
        console.log("clicked " + carid);

        $("#delete-car-data").removeClass("hidden");
        $("#add-edit-car-data").addClass("hidden");

        $("#delete_cid").val(carid);
        $("#delete-car-id-span").text(carid);
    });

    // Id delete is cancelled then show the add/edit car data form.
    $("#cancel-delete").click((evt) => {
        $("#delete-car-data").addClass("hidden");
        $("#add-edit-car-data").removeClass("hidden");
    });

});

