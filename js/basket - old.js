$(document).ready(function () {

    function smallBasketRefresh(){
        $.ajax({
            url: 'modules/small_basket_refresh.php',
            dataType: 'json',
            success: function(data){
                $.each(data, function(k, v){
                    $('#basket_left .' +k+ ' span').text(v);
                });
            },
            error: function(data){
                alert('Error Occurred');
            }
        });
    }

    function bigBasketRefresh(){
        $.ajax({
            url: 'modules/basket_view.php',
            dataType: 'html',
            success: function(data){
                $('#big_basket').html(data);
                initBinds();
            },
            error: function (data) {
                alert('An Error has Occurred.');
            }
        });
    }

    if ($('.add_to_basket').length > 0){

        $('.add_to_basket').click(function () {

            var trigger = $(this);
            var param = trigger.attr('rel');
            var item = param.split('_');
            
            $.ajax({
                type: 'POST',
                url: 'modules/basket.php',
                dataType: 'json',
                data: {id: item[0], job: item[1]},
                success: function(data){
                    var jobFlag = item[0] +'_'+ data.job;
                    if (data.job != item[1]) {
                        if (data.job == 0) {
                            trigger.attr('rel', jobFlag);
                            trigger.text('Remove from Cart');
                            trigger.addClass('btn btn-sm btn-danger');
                            // trigger.addClass('red');
                        } else {
                            trigger.attr('rel', jobFlag);
                            trigger.text('Add to Cart');
                            trigger.removeClass('btn-danger');
                            trigger.addClass('btn-primary');
                            // trigger.removeClass('red');
                        };
                        smallBasketRefresh();
                    };
                },
                error: function(data){
                    alert('Error Occured');
                }
            });
            return false;
        });
    }

    function initBinds() {

        if  ($('.remove_basket').length > 0){
            $('.remove_basket').on('click', removeFromBasket);
        }

        if ($('.update_basket').length > 0){
            $('.update_basket').on('click', updateBasket);
        }

        if ($('.fld_qty').length > 0){
            $('.fld_qty').on('keypress', function(e){
                if (e.which == 13){
                    updateBasket();
                };
            });
        }
    }

    function updateBasket(){

        $('#frm_basket :input').each(function () {
            var itemId = $(this).attr('id').split('-');
            var quantity = $(this).val();
            
            $.ajax({
                type: 'POST',
                url: 'modules/basket_quantity.php',
                data: {id: itemId[1], quantity: quantity},
                success: function(){
                    smallBasketRefresh();
                    bigBasketRefresh();
                },
                error: function (data) {
                    alert('An Error has Occurred.');
                }
            });
        });
    }

    function removeFromBasket() {
        var itemID = $(this).attr('rel');

        $.ajax({
            type: 'POST',
            url: 'modules/remove_from_basket.php',
            data: {id: itemID},
            success: function(data){
                smallBasketRefresh();
                bigBasketRefresh();
            },
            error: function () {
                alert('An Error has Occurred.');
            }
        });
    }

    initBinds();

    if ($('.paypal').length > 0){
        $('.paypal').click(function () {
            var token = $(this).attr('id');

            $('#big_basket').fadeOut(200, function () {
               $('.dn').fadeIn(200, function () {
                   $(this).append('<p>Please wait while we are redirecting you to PayPal...</p>');
                   sendToPayPal(token);
               });
            });
        });
    }

    function sendToPayPal(token){

        $.ajax({
            type: 'POST',
            url: 'modules/paypal.php',
            data: {token: token},
            dataType: 'html',
            success: function (data) {
                $('#frm_pp').html(data);
                $('#frm_paypal').submit();
            },
            error: function (data) {
                alert('An Error has Occurred.');
            }
        });
    }
});