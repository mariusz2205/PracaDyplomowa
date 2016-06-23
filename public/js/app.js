$(document).ready(function(){
    var bookId = null;

    $('.addToCard').on('click',function(event){

        event.preventDefault();
        bookId = event.target.parentNode.dataset['id'];
        $.ajax({
                method: 'POST',
                url:url,
                data: { bookId: bookId, _token: token }
            })
            .done(function(msg){
                $('.ShopingCardNumOfItems').text(msg);
            });
    });
});

//########################################################################################
$('.edit').on('click',function(event){
    event.preventDefault();
    user_id = event.target.getAttribute("data-userId");

    urlJsonUserDetail = urlJsonUserDetail+'/'+user_id;

    $.getJSON(urlJsonUserDetail, function (data) {

        var name = data.name;
        var surname = data.surname;
        var phone_number = data.phone_number;
        var email = data.email;
        roles = [];

        $.each(data.roles, function(index, role) {
            roles.push(role.role_name);

        });
        $( "#UserData" ).remove();
        $('#modal-body').append('<div id="UserData"><p><b>Imię: </b>'+name+'</p> <p><b>Nazwisko: </b>'+surname+'</p> <p><b>Nr. telefonu: </b>'+phone_number+'</p> <p><b>Adres email: </b>'+email+'</p> </div>');
        });



    htmlString = '';

    $.getJSON(urlJsonAllRoles, function (data) {

        $.each(data, function(index, role) {
            flag = false;
            $.each(roles, function(index, userRole) {
                if(role.role_name == userRole)
                {
                    htmlString = htmlString +'<div class="checkbox"> <label><input name="roles[]" checked  type="checkbox" value="'+role.role_name+'">'+role.role_name+'</label> </div>';
                    flag = true;
                }
            });
            if(flag == false)
            {
                htmlString = htmlString +'<div class="checkbox"> <label><input name="roles[]"  type="checkbox" value="'+role.role_name+'">'+role.role_name+'</label> </div>';
            }
        });
        $( ".UserRoles" ).remove();

        $( document ).ready(function() {
            $('#modal-body').append('<div class="UserRoles">'+htmlString+'</div>');
        });


    });
    $('#edit-modal').modal();
});

//######################################################################################

$('#modal-save').on('click', function(){

    var roles = [];

    $('input[name="roles[]"]:checked').each(function () {
        roles .push($(this).val());
    });


    $.ajax({
            method: 'POST',
            url: urlEditUserRole,
            data: { roles: roles ,userId: user_id, _token: token}
        })
        .done(function(msg){

            $('#edit-modal').modal('hide');
            location.reload();
        });

});
