$(document).ready(function () {
    //check admin password is correct or not
    $("#current_pwd").keyup(function () {
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-current-password',
            data: { current_pwd: current_pwd },
            success: function (resp) {
                // console.log("here");
                // console.log(resp);
                if (resp == "false") {
                    $("#verifyCurrentPwd").html("Current Password is Incorrect!");
                } else if (resp == "true") {
                    $("#verifyCurrentPwd").html("Current Password is Correct!");
                }
            }, error: function () {
                alert("Error");
            }
        })
    });


    //update CMS Page Status for toggele on off button
    $(document).on("click", ".updateCmsPageStatus", function () {
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");
        // alert(page_id);
        // alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-cms-page-status',
            data: { status: status, page_id: page_id },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#page-" + page_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i> ");
                } else {
                    $("#page-" + page_id).html("<i class='fas fa-toggle-on'  status='Active'></i> ");
                }

            }, error: function () {
                alert("Error");
            }
        })
    });


    //simple
    //confirm the deletion alert of cms page
    // $(document).on("click",".confirmDelete",function(){
    //     var name = $(this).attr('name');
    //     if(confirm('Are you sure to delete this '+name+'?')){
    //         return true;
    //     }
    //     return false;
    // });

    //sweetAlert2
    // Confirm deletion with sweetalert
    $(document).on("click", ".confirmDelete", function () {
        var record = $(this).attr('record');
        var record_id = $(this).attr('record_id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
                window.location.href = "/admin/delete-" + record + "/" + record_id;
            }
        });

    });



    //update Subadmin Status for toggele on off button
    $(document).on("click", ".updateSubadminStatus", function () {
        var status = $(this).children("i").attr("status");
        var subadmin_id = $(this).attr("subadmin_id");
        // alert(subadmin_id);
        // alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-subadmin-status',
            data: { status: status, subadmin_id: subadmin_id },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#subadmin-" + subadmin_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i> ");
                } else {
                    $("#subadmin-" + subadmin_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3'  status='Active'></i> ");
                }

            }, error: function () {
                alert("Error");
            }
        })
    });


        //update Category Status for toggele on off button
        $(document).on("click", ".updateCategoryStatus", function () {
            var status = $(this).children("i").attr("status");
            var category_id = $(this).attr("category_id");
            // alert(category_id);
            // alert(status);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/update-category-status',
                data: { status: status, category_id: category_id },
                success: function (resp) {
                    if (resp['status'] == 0) {
                        $("#category-" + category_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i> ");
                    } else {
                        $("#category-" + category_id).html("<i class='fas fa-toggle-on'  status='Active'></i> ");
                    }

                }, error: function () {
                    alert("Error");
                }
            })
        });


         //update Product Status for toggele on off button
        $(document).on("click", ".updateProductStatus", function () {
            var status = $(this).children("i").attr("status");
            var product_id = $(this).attr("product_id");
            // alert(product_id);
            // alert(status);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/update-product-status',
                data: { status: status, product_id: product_id },
                success: function (resp) {
                    if (resp['status'] == 0) {
                        $("#product-" + product_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i> ");
                    } else {
                        $("#product-" + product_id).html("<i class='fas fa-toggle-on'  status='Active'></i> ");
                    }

                }, error: function () {
                    alert("Error");
                }
            })
        });

        //Add Product Attribute Dynamic Form
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div class="field_wrapper mt-2"><div class="form-row"><div class="col-md-3"><input type="text" name="size[]" id="size" class="form-control" placeholder="Size" /></div><div class="col-md-3"><input type="text" name="sku[]" id="sku" class="form-control" placeholder="SKU" /></div><div class="col-md-3"><input type="text" name="price[]" id="price" class="form-control" placeholder="Price" /></div><div class="col-md-2"><input type="text" name="stock[]" id="stock" class="form-control" placeholder="Stock" /></div><a href="javascript:void(0);" class="remove_button" style="text-decoration: none;"><i class="fas fa-times fa-lg"></i></a></div></div></div>';


        var x = 1; //Initial field counter is 1


        // Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increase field counter
                $(wrapper).append(fieldHTML); //Add field html
            }else{
                alert('A maximum of '+maxField+' fields are allowed to be added. ');
            }
        });

        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrease field counter
        });


        //update Attribute Status for toggele on off button
        $(document).on("click", ".updateAttributeStatus", function () {
            var status = $(this).children("i").attr("status");
            var attribute_id = $(this).attr("attribute_id");
            // alert(attribute_id);
            // alert(status);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/update-attribute-status',
                data: { status: status, attribute_id: attribute_id },
                success: function (resp) {
                    if (resp['status'] == 0) {
                        $("#attribute-" + attribute_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i> ");
                    } else {
                        $("#attribute-" + attribute_id).html("<i class='fas fa-toggle-on'  status='Active'></i> ");
                    }

                }, error: function () {
                    alert("Error");
                }
            })
        });


        //update Brand Status for toggele on off button
        $(document).on("click", ".updateBrandStatus", function () {
            var status = $(this).children("i").attr("status");
            var brand_id = $(this).attr("brand_id");
            // alert(brand_id);
            // alert(status);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/admin/update-brand-status',
                data: { status: status, brand_id: brand_id },
                success: function (resp) {
                    if (resp['status'] == 0) {
                        $("#brand-" + brand_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i> ");
                    } else {
                        $("#brand-" + brand_id).html("<i class='fas fa-toggle-on'  status='Active'></i> ");
                    }

                }, error: function () {
                    alert("Error");
                }
            })
        });


});
