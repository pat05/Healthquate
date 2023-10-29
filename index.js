$(document).ready(function () {
  $(".edit-btn").click(function () {
    var id = $(this).data("id");
    $.ajax({
      url: "get_contract.php", // Create this PHP script to fetch product data
      type: "GET",
      data: { id: id },
      success: function (response) {
        $("#editModal .modal-content").html(response);
        $("#editModal").modal("show");
      },
    });
  });
});
