/**
 * Created by tomekdrazewski on 11/06/15.
 */
$(document).ready(function () {
    $('#wybortagu').change(function(){
        $(this).closest('form').trigger('submit');
    })


    $('#usun').click(function(){
        $(this).preventDefault;

        if(confirm("Czy na pewno chcesz usunąć wskaźnik z bazy?"))
        {

            var form_data = { 'delete_ids[]' : []};
            $(".list-group :checked").each(function() {
                form_data['delete_ids[]'].push($(this).val());
            });
            console.log(form_data);
            $.ajax({
                url: "../wskazniki/panel_wskazniki/delete",
                method: "post",
                data: form_data,
                success: function (res) {
                    if (res == false) {
                        alert("Wystąpił błąd");
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
                }
            });
        }
        else
        {
            var checkBoxes = $("input[id=delete]");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        }
    })

    $('#przywroc').click(function(){
        $(this).preventDefault;

        if(confirm("Czy na pewno chcesz przywrócić wskaźniki do bazy?"))
        {

            var form_data = { 'delete_ids[]' : []};
            $(".list-group :checked").each(function() {
                form_data['delete_ids[]'].push($(this).val());
            });
            console.log(form_data);
            $.ajax({
                url: "../wskazniki/panel_wskazniki/undelete",
                method: "post",
                data: form_data,
                success: function (res) {
                    if (res == false) {
                        alert("Wystąpił błąd");
                    } else {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
                }
            });
        }
        else
        {
            var checkBoxes = $("input[id=delete]");
            checkBoxes.prop("checked", !checkBoxes.prop("checked"));
        }
    })

});
