$(document).ready(function () {
    $('.panel a').click(function () {
        var value = $(this).attr('aria-expanded');
        if (value == 'true') {
            $(this).find('h4>i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
        } else {
            $(this).find('h4>i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
        }
    })

    // onchecked changed the value of nationality field
    $('input').on('ifChecked', function (event) {
        $('#nationality').val("Bangladeshi");
    });
    $('input').on('ifUnchecked', function (event) {
        $('#nationality').val("");
    });
});


$(document).ready(function () {

    $('.job-category td #edit').click(function () {
        var cat_id = $(this).closest('tr').find('.category_id').attr('id');

        var cat_text = $(this).closest('tr').find('.cateory_value');
        var cat_note = $(this).closest('tr').find('.cateory_note');
        var cat_text = cat_text[0].innerText;
        var cat_note = cat_note[0].innerText;
        $("input[name='edit_value']").val(cat_text);
        $("textarea[name='edit_note']").val(cat_note);
        $("input[name='cat_id']").val(cat_id);
        $('#myModal').modal('show');
    });

    $('#require-experience').on('ifChecked', function () {
        $('#experience-area').css('display', 'block');
    });
    $('#no-experience').on('ifChecked', function () {
        $('#experience-area').css('display', 'none');
    });
    $('#salary').on('ifChecked', function () {
        $('#min-salary').removeAttr('disabled');
        $('#max-salary').removeAttr('disabled');
    });
    $('#salary').on('ifUnchecked', function () {
        $('#min-salary').attr("disabled", "disabled");
        $('#max-salary').attr("disabled", "disabled");
        console.log("unchecked");
    });

    $('#savebtn').click(function () {
        if( $("#cv-online").iCheck('update')[0].checked || $("#cv-email").iCheck('update')[0].checked || $("#cv-hard").iCheck('update')[0].checked){
            $('#form1').trigger('submit');
            $('#form2').trigger('submit');
            return true;
        }else{
            alert('Select any of the cv receive option');
            
            $('input:first').focus();
        }
        
        return false;
    });
});