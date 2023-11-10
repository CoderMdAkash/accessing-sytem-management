$(document).ready(function () {

    var ajax_url = location.hash.replace(/^#/, '');

    if (ajax_url.length < 1) {
        ajax_url = 'dashboard';
        window.location.hash = ajax_url;
    } else {
        $(".anchor").removeClass('active');
        $(".anchor").each(function () {
            if ($(this).attr('href') == ajax_url) {
                $(this).addClass('active');
                $(this).parent('li').parent('ul').css('display', 'block');
            }
        });
    }

    //loader show
    $('#main-content').html('<div id="global-loader"><div class="whirly-loader"> </div></div>');

    LoadPageContent(ajax_url);

    $(document).on('click', '.anchor', function (e) {
        e.preventDefault();

        if ($(this).attr('href')) {
            var url = $(this).attr('href');
            var viewType = $(this).attr('viewType');
            
            if (viewType == 'modal' && url != '#') {

                // var modalTitle = $(this).attr('modalTitle');
                // $("#modal-title").text(modalTitle);
                // $(".post-popup.job_post").addClass("active");
                // $(".wrapper").addClass("overlay");

                // LoadModalPageContent(url);

            } else if (url != '#') {

                window.location.hash = url;
                //loader show
                $(".anchor").removeClass('active');
                $(this).addClass('active'); 
                LoadPageContent(url);

            }
        }
    });

});

function LoadPageContent(url, selector = false) {
    site_url = window.location.origin + '/' + base_url + '/' + url;

    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: site_url,
        type: "GET",
        dataType: "html",
        success: function (data) {

            if (data) {
                $("#main-content").html(data);
            } else {
                location.replace = "/admin/login";
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            $('#main-content').html('');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });

}

$(document).on('click', '.show-modal', function (e) {
    e.preventDefault();
    let modalTitle = $(this).attr('modalTitle');
    hideModal = $(this).attr('hideModal');
    $('.modal-title').text(modalTitle);
    let modalSize = $(this).attr('modalSize');
    let url = base_url + '/' +$(this).attr('url');

    modalShow(url, modalSize);

});

function modalShow(url, modalSize="modal-md"){
    $("#modal-dialog").removeClass('modal-sm');
    $("#modal-dialog").removeClass('modal-lg');
    $("#modal-dialog").removeClass('modal-md');

    if(modalSize){
        $("#modal-dialog").addClass('modal-'+modalSize);
    }else{
        $("#modal-dialog").addClass('modal-md');
    }
    $("#show-modal").modal('show');

    $("#modal-body").html('<div class="text-center p-3"><div class="spinner-grow spinner-grow-sm mr-3" role="status"></div><div class="spinner-grow spinner-grow-sm mr-3" role="status"></div><div class="spinner-grow spinner-grow-sm mr-3" role="status"></div></div>');

    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: url,
        type: "GET",
        dataType: "html",
        success: function (data) {
            $("#modal-body").html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });
}


$(document).on('submit', '.form-load', function (e) {
    e.preventDefault();
    let url = $(this).attr('action');
    let type = $(this).attr('type');
    let hideModal = $(this).attr('hideModal');
    
    let formData = new FormData($(this)[0]);
    let buttonText = $(".modal-button-btn").text();
    $(".modal-button-btn").text('loading..');
    $(".modal-button-btn").attr('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        dataType: 'json',
        success: function (data) {

            if(data.success == true){
                toastr.success(data.mgs);

                if(type == 'create'){
                    $("#modal-body form")[0].reset();
                    $("#modal-body form img").attr('src', '');
                }
                $(".modal-button-btn").text(buttonText);
                $(".modal-button-btn").attr('disabled', false);

                var ajax_url = location.hash.replace(/^#/, '');
                LoadPageContent(ajax_url);

                if(hideModal=='hide'){
                    $("#show-modal").modal('hide');
                }
                
            }else{
                $.each(data[0], function (key, item) {
                    toastr.error(item);
                });
                if(data.mgs){
                    toastr.error(data.mgs);
                }
            }

            $(".modal-button-btn").text(buttonText);
            $(".modal-button-btn").attr('disabled', false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });

});

$(document).on('click', '.delete', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    let url = $(this).attr('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                url: base_url + url,
                type: 'DELETE',
                data: {id : id},
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    var ajax_url = location.hash.replace(/^#/, '');
                    LoadPageContent(ajax_url);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                }
            });
          
        }
      })

})

$(document).on('click', '.page-link', function(e){
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    
    if(page){
        let ajax_url = location.hash.replace(/^#/, '').split('?')[0];
        LoadPageContent(ajax_url+'?page='+page);
        window.location.hash = ajax_url+'?page='+page;
    }
});

$(document).on('change','#perpage',function(e){
    e.preventDefault();
    let perPage = $(this).val();
    let ajax_url = location.hash.replace(/^#/, '').split('?')[0];
    LoadPageContent(ajax_url+"?perpage="+perPage);
    window.location.hash = ajax_url+"?perpage="+perPage;
});

$(document).on('submit','#search',function(e){
    e.preventDefault();
    var search = $("#search-input").val();
    let ajax_url = location.hash.replace(/^#/, '').split('?')[0];
    LoadPageContent(ajax_url+"?search="+search);
    window.location.hash = ajax_url+"?search="+search;
    setTimeout(() => {
        $('#search').focus();
        $('#search').val('');
        $('#search').val(search);
    }, 1000);
});

$(document).on('click', '.data-edit', function(e){
    e.preventDefault();
    let modalTitle = $(this).attr('modalTitle');
    hideModal = $(this).attr('hideModal');
    $('.modal-title').text(modalTitle);
    let modalSize = $(this).attr('modalSize');
    let url = base_url + '/' +$(this).attr('url');
    modalShow(url, modalSize);
});

// $( "form" ).each( function() {
//     $( this ).validate( options );
// });


// function LoadModalPageContent(url, selector = false) {
//     site_url = "{{url('/')}}/mentor-member/" + url;

//     $("#modal-main-content").html('<div id="loader"><div class="process-comm"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div></div>');

//     $.ajax({
//         mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
//         url: site_url,
//         type: "GET",
//         dataType: "html",
//         success: function (data) {

//             if (data) {
//                 $("#modal-main-content").html(data);
//                 $('#modal-loader').hide();
//             } else {
//                 location.replace = "/login";
//             }
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             toastr.error(errorThrown);
//         }
//     });

// }
