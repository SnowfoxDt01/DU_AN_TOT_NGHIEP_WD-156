function checkNewOrders() {
    $.ajax({
        url: '/admin/orders/check-new-orders',
        method: 'GET',
            success: function(response) {
                var newOrders = response.newOrders; // Số lượng đơn hàng mới
                var dropdownMenu = $('#newOrdersList'); // Danh sách dropdown
                var notificationBadge = $('#orderNotificationCount'); // Badge hiển thị số lượng

                if (newOrders > 0) {
                        // Cập nhật badge số lượng
                     notificationBadge.text(newOrders).show();

                        // Xóa danh sách cũ và thêm danh sách mới
                    dropdownMenu.empty();
                    response.orders.forEach(function(order) {
                         var orderItem = `
                            <a class="dropdown-item" href="/admin/orders/detail/${order.id}">
                                <strong>Đơn hàng #${order.id}</strong><br>
                                Từ: ${order.customer.name}
                            </a>`;
                            dropdownMenu.append(orderItem);
                        });
                    } else {
                        // Ẩn badge và hiển thị thông báo không có đơn hàng mới
                        notificationBadge.hide();
                        dropdownMenu.html('<p class="dropdown-item text-muted">Không có đơn hàng mới</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi kiểm tra đơn hàng mới:', xhr.responseText);
                }
            });
        }
        // Kiểm tra đơn hàng mới mỗi 5 giây
        setInterval(checkNewOrders, 3000);