<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $pageTitle }}</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <meta charset="UTF-8">
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        @include('templates.navigation')
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="panel-title">Трансформация на координати</h1>
                </div>
                <div class="panel-body">
                    <div class="col-md-9">
                        @if (isset($message))
                        <div class="alert alert-warning">{{ $message }}</div>
                        @endif
                        <form method="post" action="/affine" enctype="multipart/form-data" class="form-horizontal">
                            <fieldset>
                                <legend>{{ $transformationType }}</legend>
                                <div class="form-group">
                                    <label for="select" class="col-md-4 control-label">Зареждане на XML файл</label>
                                    <div class="col-md-8">
                                        <input type="file" name="file" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-md-4 control-label">Дименсия на грешките</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="units">
                                            <option value="1">метри</option>
                                            <option value="2">дециметри</option>
                                            <option value="3">сантиметри</option>
                                            <option selected="selected" value="4">милиметри</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-md-4 control-label">Captcha</label>
                                    <div class="col-md-8">
                                        <div class="g-recaptcha inline" data-sitekey="6LdblQMTAAAAAHiXO80wz4aFr8yMDUXPQQfnrwPW"></div>
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <input type="submit" name="submit" value="Трансформация" class="btn btn-primary" />
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('templates.footer')
    </body>
</html>