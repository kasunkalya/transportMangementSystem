
function generateTable(selector,url, orderableFalseTargets, textCenter,textRight){

    orderableFalseTargets = typeof orderableFalseTargets !== 'undefined' ? orderableFalseTargets : [];
    textCenter = typeof textCenter !== 'undefined' ? textCenter : [];
    textRight = typeof textRight !== 'undefined' ? textRight : [];

    var table = $(selector).DataTable({
                    "columnDefs": [
                        { "orderable": false, "targets": orderableFalseTargets },
                        {"className":"text-center vertical-align-middle", "targets":textCenter},
                        {"className":"text-right vertical-align-middle", "targets":textRight}
                    ],
                    'ajax': url,
                    "pageLength": 25,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
                });
    return table;
}

function sweetAlert(title,message,type){
    var message_types = ['success','info','error','warning'];
    swal(title, message, message_types[type]);
}

function sweetAlertConfirm(title,message,type,func){
    var message_types = ['success','info','error','warning'];

    swal({
        title: title,
        text: message,
        type: message_types[type],
        showConfirmButton : true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: true,
        closeOnCancel: true,
        showCancelButton: true,
        showSpinner: true
    }, func);
}

function ajaxRequest(url,data,method,successFunc){

    data = typeof data !== 'undefined' ? data : {};
    method = typeof method !== 'undefined' ? method : 'post';
    successFunc = typeof successFunc !== 'undefined' ? successFunc : function(data){};

    $.ajax({
        url: url,
        data : data,
        method : method,
        success : successFunc
    });
}
