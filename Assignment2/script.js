$(document).ready(() => {
    console.log("ready");

    console.log($("#cID").val());

    if ($("#cID").val() === "") {
        $("#add-edit-form-heading").text("Please fill the form to add new car");
    } else {
        $("#add-edit-form-heading").text("Please fill the form to edit car id " + $("#cID").val());
    }

    $("#add-car").click(() => {
        
        $("#add-edit-form-heading").text("Please fill the form to add new car");

        $("#cID").val("");
        $("#cName").val("");
        $("#cDesc").val("");
        $("#cPrice").val("");
        $("#cFuel").val("");
        $("#cDrive").val("");
        $("#cQuantity").val("");

    });

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

        // location.href='index.php';
    });

    $(".edit-car").click((evt) => {
        carid = $(evt.currentTarget).attr('id').split("-")[2];
        console.log("clicked " + carid);

        $("#add-edit-car-data").removeClass("hidden");
        $("#add-edit-form-heading").text("Please fill the form to edit car id " + carid);

        $("#cID").val(carid);
        console.log($("#cID").val() + " hello ");
        $("#cName").val($("#cname-"+carid).text());
        $("#cDesc").val($("#cdesc-"+carid).text());
        $("#cPrice").val($("#cprice-"+carid).text());
        $("#cFuel").val($("#cfuel-"+carid).text());
        $("#cDrive").val($("#cdrive-"+carid).text());
        $("#cQuantity").val($("#cquantity-"+carid).text());
    });

});

