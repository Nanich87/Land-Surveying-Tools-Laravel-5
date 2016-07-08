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
                    <h1 class="panel-title">Конвертиране на файлове</h1>
                </div>
                <div class="panel-body">
                    <div class="col-md-9">
                        @if (isset($message))
                            <div class="alert alert-warning">{{ $message }}</div>
                        @endif
                        <form method="post" class="form-horizontal">
                            <fieldset>
                                <legend>Конвертиране на файлове</legend>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label">Входен формат</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="input-format" name="input-format">
                                            @foreach ($inputFormat as $format)
                                            <option value="{{ $format['id'] }}">{{ $format['type'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="select" class="col-lg-2 control-label">Изходен формат</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="output-format" name="output-format">
                                            @foreach ($outputFormat as $key => $value)
                                            <option value="{{ $key }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Изход</label>
                                    <div class="col-lg-10">
                                        <div class="radio">
                                            <label>
                                                <input name="output-view" checked="checked" type="radio">
                                                показване на екрана
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="output-view" value="option2" type="radio">
                                                файл
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-lg-2 control-label">Файл</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" rows="3" id="file-content" name="file-content"></textarea>
                                        <span class="help-block">Поставете съдържанието на файла тук.</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-lg-2 control-label">Captcha</label>
                                    <div class="col-lg-10">
                                        <div class="g-recaptcha inline" data-sitekey="6LdblQMTAAAAAHiXO80wz4aFr8yMDUXPQQfnrwPW"></div>
                                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input type="submit" name="submit" value="Конвертиране" class="btn btn-primary" />
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