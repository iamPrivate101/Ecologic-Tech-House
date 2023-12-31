$(document).ready(function () {

    //Get Product Price based On Size Attribute
    $(".getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        // alert(size);
        // alert(product_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/get-attribute-price',
            data: { size: size, product_id: product_id },
            type: 'post',
            success: function (resp) {
                // console.log('a');
                // console.log(resp['final_price']);
                // alert(resp);
                if (resp['discount'] > 0) {
                    $(".getAttributePrice").html("<span class='pd-detail__price' >Rs" + resp['final_price'] + "</span> <span class='pd-detail__discount'>(" + resp['discount_percent'] + "% OFF)</span><del class='pd-detail__del'>" + resp['product_price'] + "</del>");
                } else {
                    $(".getAttributePrice").html("<span class='pd-detail__price' >Rs" + resp['final_price'] + "</span>");
                }
            }, error: function (xhr, status, error) {
                // console.error("AJAX Error: " + status + " - " + error);
                // console.log(xhr.responseText); // Log the response text for more details
                alert("Error");
            }
        })
    });

    //Add To Cart
    // Add To Cart
    $("#addToCart").submit(function () {
        var formData = $(this).serialize();
        // alert(formData);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/add-to-cart',
            type: 'post',
            data: formData, // Fix the typo here
            success: function (resp) {
                // alert(resp['status']);
                $(".totalCartItems").html(resp['totalCartItems']);
                $("#appendCartItems").html(resp.view);
                $("#appendMiniCartItems").html(resp.minicartview);

                if(resp['status'] == true){
                    $('.print-success-msg').show();
                    $('.print-success-msg').delay(3000).fadeOut('slow');
                    $('.print-success-msg').html(" <div class='success'> <span class='closebtn' onclick='this.parentElement.style.display='none';' >&times;</span>"+ resp['message'] +"</div>");
                }else{
                    $('.print-error-msg').show();
                    $('.print-error-msg').delay(3000).fadeOut('slow');
                    $('.print-error-msg').html(" <div class='alert'> <span class='closebtn' onclick='this.parentElement.style.display='none';' >&times;</span>"+ resp['message'] +"</div>");
                }
            },
            error: function () {
                alert('Error');
            }
        });
    });

    //Update Cart Items Quantity
    $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('fa-plus')){
            //GEt Qty
            var quantity = $(this).data('qty');
            new_qty = parseInt(quantity) + 1;
            // alert(new_qty);
        }

        if($(this).hasClass('fa-minus')){
            //GEt Qty
            var quantity = $(this).data('qty');
            //Check Qty is Atleast 1
            if(quantity <= 1){
                alert("Item Quantity Must Be 1 or Greater Than 1 !!!");
                return false;
            }
            new_qty = parseInt(quantity) - 1;
            // alert(new_qty);
        }

        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {cartid:cartid, qty:new_qty},
            url : '/update-cart-item-qty',
            type : 'post',
            success:function(resp){
                // alert(resp);
                if(resp.status == false){
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
                $("#appendMiniCartItems").html(resp.minicartview);

            },error:function(){
                alert("Error");
            }
        });
    });

    //Delete Cart Item
    $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        //confirmation to delete
        var result = confirm("Are you sure you want to delete this Cart Item ?");
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/delete-cart-item',
                type:'post',
                success:function(resp){
                    // alert(resp);
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                    $("#appendMiniCartItems").html(resp.minicartview);
                },error:function(){
                    alert("Error");
                }

            });
        }
    });

    //Empty All  Cart Item
    $(document).on('click','.emptyCart',function(){
        //confirmation to delete
        var result = confirm("Are you sure you want to Empty Your Cart ? ");
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/empty-cart',
                type:'post',
                success:function(resp){
                    // alert(resp);
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                    $("#appendMiniCartItems").html(resp.minicartview);
                },error:function(){
                    alert("Error");
                }

            });
        }
    });



});
