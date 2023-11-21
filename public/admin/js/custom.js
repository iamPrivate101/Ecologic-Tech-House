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


});
