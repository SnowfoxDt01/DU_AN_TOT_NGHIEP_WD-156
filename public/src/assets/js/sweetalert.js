// SweetAlert Confirm Delete
document.addEventListener("DOMContentLoaded", function () {
    // Bắt sự kiện submit trên tất cả các form có class 'delete-form'
    const deleteForms = document.querySelectorAll(".delete-form");
    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Ngăn hành động submit mặc định
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                iconColor: '#ff0000',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#343a40',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form khi người dùng xác nhận
                }
            });
        });
    });
});
