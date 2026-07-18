// ─── Add to Cart ──────────────────────────────────────────────────────────────
function addToCart(productId, quantity, size) {
    quantity = quantity || 1;
    size = size || null;

    $.post('/cart/add', { product_id: productId, quantity: quantity, size: size })
        .done(function (res) {
            toastr.success(
                'Item added! Cart now has <b>' + res.cart_count + '</b> item(s).',
                '🛒 Added to Cart'
            );
            $('#cart-count').text(res.cart_count).addClass('bounce-badge');
            setTimeout(function () { $('#cart-count').removeClass('bounce-badge'); }, 700);
        })
        .fail(function (xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message)
                ? xhr.responseJSON.message : 'Something went wrong.';
            if (xhr.status === 401) {
                toastr.warning('Please login to add items to cart.', '⚠️ Login Required');
            } else {
                toastr.error(msg, '❌ Error');
            }
        });
}

// ─── Toggle Wishlist ──────────────────────────────────────────────────────────
function toggleWishlist(productId, el) {
    $.post('/wishlist/' + productId + '/toggle')
        .done(function (res) {
            if (res.status === 'added') {
                $(el).find('i')
                    .removeClass('bi-heart')
                    .addClass('bi-heart-fill text-danger');
                toastr.success('Product saved to your wishlist!', '❤️ Wishlist Updated');
            } else {
                $(el).find('i')
                    .removeClass('bi-heart-fill text-danger')
                    .addClass('bi-heart');
                toastr.info('Product removed from your wishlist.', '🤍 Wishlist Updated');
            }
        })
        .fail(function (xhr) {
            if (xhr.status === 401) {
                toastr.warning('Please login to use the wishlist.', '⚠️ Login Required');
            } else {
                toastr.error('Could not update wishlist.', '❌ Error');
            }
        });
}

// ─── Update Cart Quantity ─────────────────────────────────────────────────────
function updateCartQty(itemId, qty) {
    $.ajax({ url: '/cart/' + itemId, method: 'PATCH', data: { quantity: qty } })
        .done(function (res) {
            $('#subtotal-' + itemId).text('$' + res.subtotal);
            $('#cart-total').text(res.total);
            toastr.info('Cart quantity updated.', '🔄 Updated');
        })
        .fail(function () {
            toastr.error('Could not update quantity.', '❌ Error');
        });
}

// ─── Remove Cart Item ─────────────────────────────────────────────────────────
function removeCartItem(itemId) {
    Swal.fire({
        title: 'Remove this item?',
        text:  'It will be removed from your cart.',
        icon:  'warning',
        showCancelButton:    true,
        confirmButtonColor:  '#ff6b35',
        cancelButtonColor:   '#6c757d',
        confirmButtonText:   'Yes, remove it!',
        cancelButtonText:    'Keep it',
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({ url: '/cart/' + itemId, method: 'DELETE' })
                .done(function () {
                    $('#cart-row-' + itemId).fadeOut(400, function () {
                        $(this).remove();
                        if ($('tbody tr:visible').length === 0) {
                            location.reload();
                        }
                    });
                    toastr.success('Item removed from cart.', '🗑️ Removed');
                })
                .fail(function () {
                    toastr.error('Could not remove item.', '❌ Error');
                });
        }
    });
}

// ─── Live AJAX Product Filter ─────────────────────────────────────────────────
$(document).ready(function () {
    var timer;
    $('#filter-form').on('input change', function () {
        clearTimeout(timer);
        $('#product-grid').css('opacity', '0.5');
        timer = setTimeout(function () {
            var params = $('#filter-form').serialize();
            $.get('/products?' + params, { ajax: 1 }, function (html) {
                $('#product-grid').html(html).css('opacity', '1');
            });
        }, 350);
    });
});
