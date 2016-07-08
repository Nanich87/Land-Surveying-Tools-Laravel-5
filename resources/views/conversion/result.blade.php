<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $pageTitle }}</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <meta charset="UTF-8">
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
                        @else
                            <h2>Изходен файл</h2>
                            <div class="row">
                                <textarea class="form-control" rows="6">{{ $fileContent }}</textarea>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('templates.footer')
    </body>
</html>