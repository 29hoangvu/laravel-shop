import * as bootstrap from 'bootstrap';

// Cart Functions
function updateCartQuantity(productId, action) {
    $.ajax({
        url: '/cart/update',
        type: 'POST',
        data: {
            product_id: productId,
            action: action,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        }
    });
}

// Add to Cart Animation
function addToCartAnimation(button) {
    button.disabled = true;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';

    setTimeout(function() {
        button.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
        setTimeout(function() {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    }, 700);
}

// Toggle Favorite Animation
function toggleFavoriteAnimation(element, isFavorite) {
    if (isFavorite) {
        element.innerHTML = '<i class="fas fa-heart text-danger"></i>';
    } else {
        element.innerHTML = '<i class="far fa-heart"></i>';
    }
}

// Initialize Tooltips and event handlers
$(function () {
    // Khởi tạo tooltip Bootstrap 5 (không dùng jQuery)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle Add to Cart button click (event delegation)
    $(document).on('click', '.add-to-cart-btn', function () {
        const productId = $(this).data('product-id');
        const button = this;

        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: 1
            },
            success: function(response) {
                if (response.success) {
                    addToCartAnimation(button);
                    $('.cart-count').text(response.cartCount);
                } else {
                    alert(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function() {
                alert('Lỗi mạng hoặc máy chủ.');
            }
        });
    });

    // Handle Favorite toggle click
    $(document).on('click', '.toggle-favorite', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const element = this;

        $.ajax({
            url: '/favorites/toggle',
            type: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    toggleFavoriteAnimation(element, response.isFavorite);
                }
            }
        });
    });
});
