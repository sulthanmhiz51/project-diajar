// var keyword = document.getElementById("keyword");
// var tombolCari = document.getElementById("tombolCari");
// var searchDisplay = document.getElementById("search-display");

// keyword.addEventListener("keyup", function () {
//   // buat objek ajax
//   var xhr = new XMLHttpRequest();

//   // cek kesiapan ajax
//   xhr.onreadystatechange = function () {
//     if (xhr.readyState == 4 && xhr.status == 200) {
//       searchDisplay.innerHTML = xhr.responseText;
//     }
//   };
//   //eksekusi ajax
//   xhr.open(
//     "get",
//     "http://localhost/belajar-web/phpmvc/public/mahasiswa/cari?keyword=" +
//       keyword.value,
//     true
//   );
//   xhr.send();
// });

document.addEventListener("click", async function (event) {
  if (event.target.closest(".hapus")) {
    event.preventDefault();
    const target = event.target.closest(".hapus");

    const result = await Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    });

    if (result.isConfirmed) {
      Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success",
      });
      window.location.href = target.href;
    }
  }
});

$(function () {
  $("#keyword").on("keyup", function () {
    // Get the value and encode it so whitespace and special characters are handled
    const keyword = encodeURIComponent($("#keyword").val());
    $("#search-display").load(
      window.APP_CONFIG.BASEURL + "/mahasiswa/cari?keyword=" + keyword
    );
  });
});

$(function () {
  $(".tombolTambah").on("click", function () {
    $("#modalLabel").html("Tambah Data Mahasiswa");
    $(".modal-footer button[type=submit]").html("Tambah Data");
    $(".modal-body form").attr(
      "action",
      window.APP_CONFIG.BASEURL + "/mahasiswa/tambah"
    );
    $("#nama").val("");
    $("#npm").val("");
    $("#email").val("");
    $("#jurusan").val("");
    $("#id").val("");
  });
  $(".tampilModalUbah").on("click", function () {
    $("#modalLabel").html("Ubah Data Mahasiswa");
    $(".modal-footer button[type=submit]").html("Ubah Data");
    $(".modal-body form").attr(
      "action",
      window.APP_CONFIG.BASEURL + "/mahasiswa/ubah"
    );

    const id = $(this).data("id");

    $.ajax({
      url: window.APP_CONFIG.BASEURL + "/mahasiswa/getubah",
      data: { id: id },
      method: "post",
      dataType: "json",
      success: function (data) {
        $("#nama").val(data.nama);
        $("#npm").val(data.npm);
        $("#email").val(data.email);
        $("#jurusan").val(data.jurusan);
        $("#id").val(data.id);
      },
    });
  });
});
