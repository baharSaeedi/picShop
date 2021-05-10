$(".myTab").click(function (){
    $(".tab-pane").addClass("d-none");
    $(".tab-pane"+$(this).children().attr("href")).removeClass("d-none");
})


//---------------------functions-----------------------
function deleteOne( inputList , num) {

    for (i=0;i<=inputList.length;i++)
    {
        $("form input[data-key]").eq(i).val($(inputList).eq(i).val());
    }
    $("form input[name='form-type']").val(num);
    $.each(inputList,function (tdIndex,tdElement) {


        Swal.fire({
            title: 'مطمئنید که میخواهید این مورد را حذف کنید؟',
            text: "",
            icon: 'alert',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'حذف',
            cancelButtonText:'کنسل'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'مورد کاربری حذف شد!',
                    '',
                    'success',
                ).then((result) => {

                    if ($("form input[name='form-type']").val()==num)
                    {
                        $("#adminForm").delay(30000).submit();
                    }
                })
            }
        })


    });
}


function deleteMAny(num) {
    if ($("form input[name='form-type']").val()==num)
    {
        Swal.fire({
            title: 'مطمئنید که میخواهید کاربران را حذف کنید؟',
            text: "",
            icon: 'alert',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'حذف',
            cancelButtonText:'کنسل'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'موارد کاربری حذف شد!',
                    '',
                    'success',
                ).then((result) => {
                    $("form input[name='form-sub']").val(0);
                    $("#adminForm").delay(30000).submit();
                })
            }
        })
    }
    else
    {
        Swal.fire({
            title: 'خطا',
            text: ".کاربری انتخاب نشده است",
            icon: 'warning',
            timer:3000
        })
    }
}

function checkAll($checkVal  , $num) {
        for (k=0;k<checkVal.length;k++)
        {
            if (!$(checkVal).eq(k).parent().parent().parent().parent().hasClass("d-none"))
            {
                $(checkVal).eq(k).prop('checked', $(this).prop('checked'));
            }
        }
        $("form input[name='form-type']").val($num);
        for (i=0;i<checkVal.length;i++)
        {
            if (!$(checkVal).eq(i).parent().parent().parent().hasClass("d-none"))
            {
                checked=$(checkVal).eq(i).parent().parent().children("input");
                for (j=0;j<checked.length;j++)
                {
                    if ($("form input[data-key]").eq(j).val()=="")
                    {
                        $("form input[data-key]").eq(j).val($(checked).eq(j).val());
                    }
                    else
                    {
                        $("form input[data-key]").eq(j).val($("form input[data-key]").eq(j).val()+","+$(checked).eq(j).val());
                    }
                }
            }
        }

}
function checkOne(num) {

        $("form input[name='form-type']").val(num);
        inputList = $(this).parent().parent().children("input");
        for (i = 0; i <= inputList.length; i++) {
            if ($("form input[data-key]").eq(i).val() == "") {
                $("form input[data-key]").eq(i).val($(inputList).eq(i).val());
            } else {
                $("form input[data-key]").eq(i).val($("form input[data-key]").eq(i).val() + "," + $(inputList).eq(i).val());
            }
        }
}

// -------------------------------delete for users-----------------------
$("[data-deleteUser]").click(function (e) {
    e.preventDefault();
    inputList = $(this).parent().parent().children("input");
    deleteOne( inputList , 2);

});
$(".btnUser").click(function (event){
    event.preventDefault();
    deleteMAny(3);
})

$("input[name='check-allUser']").click(function (){
    checkVal=$(".checkboxUser");
    if ($(this).prop("checked"))
    {
        checkAll(checkVal , 3);
    }
    else
    {
        $("form input[name='form-type']").val(0);
        for (k=0;k<checkVal.length;k++)
        {
            if (!$(checkVal).eq(k).parent().parent().parent().hasClass("d-none"))
            {
                $(checkVal).eq(k).prop('checked', $(this).prop('checked'));
            }
        }
        for (j=0;j<10;j++)
        {
            $("form input[data-key]").eq(j).val("");
        }
    }
})


$(".checkboxUser").click(function () {
    if ($(this).prop("checked"))
    {
    checkOne(3);
    }
    else
    {
        $("form input[name='form-type']").val(0);
    }


})

//--------------------delete for pics---------------------
$("[data-deletePics]").click(function (e) {
    e.preventDefault();
    inputList = $(this).parent().parent().children("input");
    deleteOne( inputList , 4);

});
$(".btnPics").click(function (event){
    event.preventDefault();
    deleteMAny(5);
})

$("input[name='check-allPics']").click(function (){
    checkVal=$(".checkboxPics");
    if ($(this).prop("checked"))
    {
        checkAll(checkVal , 5);
    }
    else
    {
        $("form input[name='form-type']").val(0);
        for (k=0;k<checkVal.length;k++)
        {
            if (!$(checkVal).eq(k).parent().parent().parent().hasClass("d-none"))
            {
                $(checkVal).eq(k).prop('checked', $(this).prop('checked'));
            }
        }
        for (j=0;j<10;j++)
        {
            $("form input[data-key]").eq(j).val("");
        }
    }
})


$(".checkboxPics").click(function () {
    if ($(this).prop("checked"))
    {
        checkOne(5);
    }
    else
    {
        $("form input[name='form-type']").val(0);
    }

})

// -------------------------------delete for users-----------------------
$("[data-deleteCats]").click(function (e) {
    e.preventDefault();
    inputList = $(this).parent().parent().children("input");
    deleteOne( inputList , 6);

});
$(".btnCat").click(function (event){
    event.preventDefault();
    deleteMAny(7);
})

$("input[name='check-allCats']").click(function (){
    checkVal=$(".checkboxCat");
    if ($(this).prop("checked"))
    {
        checkAll(checkVal , 7);
    }
    else
    {
        $("form input[name='form-type']").val(0);
        for (k=0;k<checkVal.length;k++)
        {
            if (!$(checkVal).eq(k).parent().parent().parent().hasClass("d-none"))
            {
                $(checkVal).eq(k).prop('checked', $(this).prop('checked'));
            }
        }
        for (j=0;j<10;j++)
        {
            $("form input[data-key]").eq(j).val("");
        }
    }
})


$(".checkboxCat").click(function () {
    if ($(this).prop("checked"))
    {
        checkOne(7);
    }
    else
    {
        $("form input[name='form-type']").val(0);
    }


})







