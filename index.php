<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no" />
		<title>Автообъявления</title>  
        <link rel="stylesheet" href="css/bootstrap.min.css" />      
        <link rel="stylesheet" href="css/my.css" />       
        <script src="js/jquery-3.4.1.min.js"></script>  
        <script src="js/bootstrap.bundle.min.js"></script>     
        <script src="js/my.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" id="navsc">
                    <span class="navbar-brand text-monospace">
                        AutoAd
                    </span> 
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nvc">
                        <span class="navbar-toggler-icon"></span>
                    </button>                   
                    <div class="collapse navbar-collapse" id="nvc">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link">Просмотр объявлений</a>
                            </li>
                            <li class="nav-item" data-toggle="tooltip" 
                            title="Необходима авторизация" tabindex="0" id="needaut">
                                <a class="nav-link disabled" data-toggle="modal" 
                                href="#postmod">Дать объявление</a>
                            </li>
                        </ul>
<!--Блок авторизации/регистрации-->
                        <div id="formdiv" class="text-light"></div>
                        <div id="formbut">
                        <button class="btn btn-light mx-3" data-toggle="modal" 
                        data-target="#modreg" type="button">Регистрация</button>                        
                        <div class="btn-group dropdown">
                            <button type="button" data-display="static" 
                                    class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown">
                                      Вход    
                            </button>
                            <form class="dropdown-menu dropdown-menu-lg-right p-3 reg">
                              <div class="form-group" style="position: relative">
                                <label for="email">
                                     Email:
                                </label>
                                <input class="form-control" id="email" data-trigger="hover"
                                type="email" name="em" size="30" maxlength="30" data-toggle="tooltip"
                                title="Введите email, указанный при регистрации" required autofocus="true"/>
                                <div class="invalid-tooltip">Такой адрес не зарегистрирован</div>
                              </div>
                              <div class="form-group" style="position: relative">
                                <label for="passw" >
                                    Пароль:
                                </label>
                                <input class="form-control" id="passw" type="password" 
                                name="pass" size="20" data-toggle="tooltip" data-trigger="hover"
                                maxlength="20" title="Введите пароль" required />
                                <div class="invalid-tooltip">Неверный пароль</div>
                              </div>
                              <input class="btn btn-lg btn-primary" 
                              id="subm" type="submit" name="sub" title="Вход" />
                            </form>
                        </div>  
                        </div>
                    </div>
        </nav>               
<!--Конец блока авторизации/регистрации-->
<!--Блок фильтрации объявления-->
    <div class="container-fluid"> 
      <div class="row justify-content-center" >
        <div class="col-6 col-lg-4 order-lg-2 my-2 my-lg-0 bg-info justify-content-center position-relative" >
            <div id="formatdiv">
                <form enctype="multipart/form-data" action="format.php" method="get">
                    <fieldset>
                        <legend class="text-center">
                            Фильтрация объявлений:
                        </legend>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="oblformat">
                                 По области:
                            </label>
                          </div>
                            <input 
                                id="oblformat" 
                                class="form-control"
                                type="text" 
                                name="oblast" 
                                size="30" 
                                maxlength="30" 
                                title="Введите область"  
                            />
                        </div>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">  
                            <label class="input-group-text" for="gorformat">
                                 По городу:
                            </label>
                          </div>
                            <input 
                                id="gorformat"
                                class="form-control" 
                                type="text" 
                                name="gorod" 
                                size="30" 
                                maxlength="30" 
                                title="Введите название города" 
                            />
                        </div>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="markformat">
                                 По марке:
                            </label>
                          </div>
                            <input 
                                id="markformat" 
                                class="form-control"
                                type="text" 
                                name="marka" 
                                size="15" 
                                maxlength="15" 
                                title="Введите марку автомобиля" 
                            />
                        </div>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="modformat">
                                 По модели:
                            </label>
                          </div>
                            <input 
                                id="modformat" 
                                class="form-control"
                                type="text" 
                                name="model" 
                                size="15" 
                                maxlength="15" 
                                title="Введите модель автомобиля"  
                            />
                        </div>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="obdvformat">
                                 Нижний объем двигателя(см<sup>3</sup>):
                            </label>
                          </div>
                            <input 
                                id="obdvformat"
                                class="form-control" 
                                type="text" 
                                name="obdv" 
                                pattern="^[0-9]*$"
                                size="7" 
                                maxlength="7" 
                                title="Введите минимальный объем двигателя автомобиля цифрами" 
                            />
                        </div>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="probformat">
                                 Максимальный пробег(км):
                            </label>
                          </div>
                            <input 
                                id="probformat" 
                                class="form-control"
                                type="text" 
                                name="probeg" 
                                pattern="^[0-9]*$"
                                size="7" 
                                maxlength="7" 
                                title="Введите максимальный пробег автомобиля в километрах" 
                            />
                        </div>
                        <div class="input-group form-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="kolhformat">
                                 Допустимое количество хозяев:
                            </label>
                          </div>
                            <input 
                                id="kolhformat" 
                                class="form-control"
                                type="text" 
                                name="kolhoz"
                                pattern="^[0-9]*$"
                                size="2" 
                                maxlength="2" 
                                title="Введите максимальное количество хозяев автомобиля цифрами" 
                            />
                        </div>
                        <input 
                            id="submformat" 
                            class="btn btn-success btn-lg my-3 float-right"
                            type="submit" 
                            name="subf" 
                            value="Фильтровать" 
                            title="Фильтровать объявления" 
                        />
                        <br />
                    </fieldset>
                </form>
            </div>
        </div>  
<!--Конец блока фильтрации объявления-->
        <div id="content" class="col-12 col-lg-8" style="background-color:#d6d8db" >
            
        </div>
      </div>
    </div>
<!--Блок написания объявления-->
        <div class="modal fade" id="postmod" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Оформление объявления:</h3>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" action="post.php" 
                        method="post" class="form-row" >
                            <input id="hid" name="uid" type="hidden"/>
                            <div class="form-group col-12">
                                <label for="oblpost">
                                     Область:
                                </label>
                                <input 
                                    id="oblpost" 
                                    class="form-control"
                                    type="text" 
                                    name="obl" 
                                    size="30" 
                                    maxlength="30" 
                                    title="Введите область" 
                                    required 
                                />
                            </div>
                            <div class="form-group col-12">
                                <label for="gorpost">
                                     Город:
                                </label>
                                <input 
                                    id="gorpost" 
                                    class="form-control"
                                    type="text" 
                                    name="gor" 
                                    size="30" 
                                    maxlength="30" 
                                    title="Введите название города" 
                                    required 
                                />
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="markpost">
                                     Марка:
                                </label>
                                <input 
                                    id="markpost" 
                                    class="form-control"
                                    type="text" 
                                    name="mark" 
                                    size="15" 
                                    maxlength="15" 
                                    title="Введите марку автомобиля" 
                                    required 
                                />
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="modpost">
                                     Модель:
                                </label>
                                <input 
                                    id="modpost"
                                    class="form-control" 
                                    type="text" 
                                    name="mod" 
                                    size="15" 
                                    maxlength="15" 
                                    title="Введите модель автомобиля" 
                                    required 
                                />
                            </div>
                            <div class="form-group col-xl-4">
                                <label for="obdvpost">
                                     Объем движка(см<sup>3</sup>):
                                </label>
                                <input 
                                    id="obdvpost" 
                                    class="form-control"
                                    type="text" 
                                    name="obdv" 
                                    pattern="^[0-9]+$"
                                    size="7" 
                                    maxlength="7" 
                                    title="Введите объем двигателя автомобиля цифрами" 
                                    required 
                                />
                            </div>
                            <div class="form-group col-xl-4">
                                <label for="probpost">
                                     Пробег(км):
                                </label>
                                <input 
                                    id="probpost"
                                    class="form-control" 
                                    type="text" 
                                    name="prob" 
                                    pattern="^[0-9]+$"
                                    size="7" 
                                    maxlength="7" 
                                    title="Введите Пробег автомобиля в километрах" 
                                    required 
                                />
                            </div>
                            <div class="form-group col-xl-4">
                                <label for="kolhpost">
                                     Количество хозяев:
                                </label>
                                <input 
                                    id="kolhpost" 
                                    class="form-control"
                                    type="text" 
                                    name="kolhoz"
                                    pattern="^[0-9]+$"
                                    size="2" 
                                    maxlength="2" 
                                    title="Введите количество хозяев автомобиля цифрами" 
                                    required 
                                />
                            </div>
                            <div class="custom-file col-12">
                                <label id="lfotopost" class="custom-file-label" for="fotopost">
                                     Загрузите фотографии:
                                </label>
                                <input 
                                    id="fotopost" 
                                    class="custom-file-input"
                                    type="file" 
                                    accept="image/jpeg, image/png, image/gif"
                                    name="fotos[]" 
                                    title="Выберите фотографии автомобиля" 
                                    required
                                    multiple
                                />
                            </div>
                            <div id="fotocheck" class="col-12">
                                
                            </div>
                            <div class=" btn-group my-4 w-100">
                                <input 
                                    id="submpost" 
                                    class="btn btn-primary ml-auto"
                                    type="submit" 
                                    name="subp" 
                                    value="Опубликовать" 
                                    title="Опубликовать объявление"
                                />   
                                <button class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>                                 
                        </form>                      
                    </div>
                </div>
            </div>
         </div>
<!--Конец блока написания объявления-->
    <div class="modal fade" id="modaimg" tabindex="-1">
        <div class="modal-dialog modal-lg" style="width: auto; height: auto;" >
            <div class="modal-content" >
                <button type="button" class="close" data-dismiss="modal">
                     <span>&times;</span>
                </button>
                <img id="imgmoda" src=""  height="600px" width="800px"
                    alt="Картинка увеличенного размера" />
            </div>
        </div>
    </div>
    <div class="modal fade" id="modreg" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Заполните регистрационную форму:</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form class="reg" enctype="multipart/form-data" 
                        action="Reg.php" method="post" >
                        <div class="form-group" >
                            <label for="emailreg">
                                Email:
                            </label>
                            <input id="emailreg" type="email" name="emr" 
                            size="30" maxlength="30" title="Введите Ваш email" 
                            required class="form-control" />
                        </div>
                        <div class="form-group" >
                            <label for="passreg" >
                                Пароль:
                            </label>
                            <input id="passreg" type="password" name="passr" 
                                size="20" maxlength="20" title="Введите Ваш пароль" 
                                required class="form-control" />
                        </div>
                            <input id="submreg" type="submit" name="subr" 
                                value="Регистрация" title="Зарегистрироваться" 
                                class="btn btn-lg btn-primary mx-auto" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>