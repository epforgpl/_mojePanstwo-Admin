/**
 * Created by tomekdrazewski on 11/06/15.
 */
$(document).ready(function () {
    $('#wybortagu').change(function(){
        $(this).closest('form').trigger('submit');
    })


    $('#usun').click(function(){
        $(this).preventDefault;

        if(confirm("Czy na pewno chcesz usunąć instytucje z bazy?"))
        {

            var form_data = { 'delete_ids[]' : []};
            $(".list-group :checked").each(function() {
                form_data['delete_ids[]'].push($(this).val());
            });
            console.log(form_data);
            $.ajax({
                url: "../instytucje/instytucje/delete",
                method: "post",
                data: form_data,
                success: function (res) {
                    if (res == false) {
                        alert("Wystąpił błąd");
                    } //else if (res.Podgrupy.id = id) {
                       // page.reload();
                   // }
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
