define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    var productId = $('body').data('product-id'); // Lấy ID sản phẩm từ data-attribute trong thẻ body
    console.log('Product ID:', productId); // Kiểm tra xem đã lấy được ID chưa

    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Contact Us',
        modalClass: 'custom-modal',
        buttons: []
    };

    var popup = modal(options, $('#popup-modal-<?=$productId?>'));

    // Mở modal khi bấm vào nút Contact Us
    $('.contact-us-button').on('click', function (e) {
        e.preventDefault();
        $('#popup-modal-<?=$productId?>').modal('openModal');
    });

    // Gửi form và lấy thông tin ID sản phẩm
    $('#contactUsForm<?=$productId?>').on('submit', function (e) {
        e.preventDefault();
        var fullName = $('#contactUsForm<?=$productId?>' + ' [name="full_name"]').val();
        var email = $('#contactUsForm<?=$productId?>' + ' [name="email"]').val();
        var phone = $('#contactUsForm<?=$productId?>' + ' [name="phone"]').val();
        var message = $('#contactUsForm<?=$productId?>' + ' [name="message"]').val();

        // Kiểm tra thông tin gửi lên
        console.log('Full Name:', fullName);
        console.log('Email:', email);
        console.log('Phone:', phone);
        console.log('Message:', message);
        console.log('Product ID:', productId);

        // Gửi dữ liệu tới server hoặc xử lý theo cách của bạn
        $.ajax({
            url: '/hideprice/ajax/submitform', // URL trỏ đến controller
            type: 'POST',
            data: {
                product_id: productId,
                full_name: fullName,
                email: email,
                phone: phone,
                message: message
            },
            success: function(response) {
                console.log('Form submitted successfully:', response);
                if (response.success) {

                } else {
                    alert(response.message); // Hiển thị lỗi nếu có
                }
            },
            error: function(error) {
                console.log('Error submitting form:', error);
            }
        });
    });
});
