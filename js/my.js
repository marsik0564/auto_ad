            $(function(){
                var user = [];
                var files;
                $('[data-toggle="tooltip"]').tooltip();
                $('body').on('click','img',function(){
                    $('#imgmoda').attr('src',$(this).attr('src'));
                    $('#modaimg').modal('show');                 
                });
                $('#email').focus(function(){
                    $(this).removeClass('is-invalid');    
                });
                $('#passw').focus(function(){
                    $(this).removeClass('is-invalid');    
                });
                $('#fotopost').change(function(e){
                    var l=e.target.files.length;
                    if (l>1){
                        $('#lfotopost').text('Загружено файлов: '+e.target.files.length);    
                    } else {
                        $('#lfotopost').text(e.target.files[0].name);
                    }
                });
                $('form.reg').submit(function(ev){
                    ev.preventDefault();
                    $.ajax({
                        url : 'reg.php',
                        method : 'post',
                        data : $(this).serialize()
                    }).done(function(data) {
                        user = JSON.parse(data);
                        if (user.error!=''){
                            if (user.error=='Такой email не зарегистрирован в базе данных'){
                                $('#email').addClass('is-invalid');    
                            } else if (user.error=='Не правильный пароль'){
                                $('#passw').addClass('is-invalid');
                            } else {
                                alert(user.error);
                            }
                        } else {
                            $('#formbut').hide();
                            $('#modreg').modal('hide');
                            $('#formdiv').append('Добро пожаловать, '+user.email);
                            if (user.kolpost<3){
                                $('#formdiv').append(', Вам доступно объявлений для написания:'+ 
                                '<div class="badge badge-light">'+(3-user.kolpost)+'</div>');
                                $('#postbutton').show();
                                $('a.disabled').removeClass('disabled').addClass('text-info')
                                $('#needaut').tooltip('disable');
                                $('#hid').val(user.uid);
                            } else {
                                $('#formdiv').append(', Вам больше не доступно написание объявлений');
                            }
                        }
                    });
                });
                $('#content').load('format.php');
                $('#content').on('click','a.ajax',function(){
                    $('#content').load($(this).attr('href'));
                    return false;
                });
                $('#formatdiv form').submit(function(ev){
                    ev.preventDefault();
                    $.ajax({
                        url : 'format.php',
                        method : 'get',
                        data : $(this).serialize()
                    }).done(function(data) {
                        $('#content').html(data);
                    });
                });
            });