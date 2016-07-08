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
                        <h2>{{ $transformationType }}</h2>
                        <h3>РЕЗУЛТАТ ОТ ТРАНСФОРМАЦИЯТА</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td rowspan="2">Номер точка</td>
                                    <td colspan="2">Координатна система 1</td>
                                    <td colspan="2">Координатна система 2</td>
                                    <td colspan="2">Поправки</td>
                                </tr>
                                <tr> 
                                    <td>X [m]</td>
                                    <td>Y [m]</td>
                                    <td>X [m]</td>
                                    <td>Y [m]</td>
                                    <td>X [m]</td>
                                    <td>Y [m]</td>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="7">ОЦЕНКА НА ТОЧНОСТТА</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span style="font-weight: bold;">mx</span> = {{ number_format($rootMeanSquareErrors['x'], 3, '.', '') }} [m]</td> 
                                    <td colspan="2"><span style="font-weight: bold;">my</span> = {{ number_format($rootMeanSquareErrors['y'], 3, '.', '') }} [m]</td>  
                                    <td colspan="3"><span style="font-weight: bold;">ms</span> = {{ number_format($rootMeanSquareErrors['total'], 3, '.', '')}} [m]</td>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($points as $pointIndex => $pointData)
                                <tr>
                                    <td align="center">{{ $pointIndex }}</td>
                                    <td align="right">{{ number_format($pointData['sourceCoordinateSystem']['x'], 3, '.', '') }}</td> 
                                    <td align="right">{{ number_format($pointData['sourceCoordinateSystem']['y'], 3, '.', '') }}</td>
                                    <td align="right">{{ number_format($pointData['targetCoordinateSystem']['x'], 3, '.', '') }}</td> 
                                    <td align="right">{{ number_format($pointData['sourceCoordinateSystem']['y'], 3, '.', '') }}</td>
                                    <td align="right">{{ isset($pointData['residuals']) ? number_format($pointData['residuals']['x'], 3, '.', '') : '' }}</td> 
                                    <td align="right">{{ isset($pointData['residuals']) ? number_format($pointData['residuals']['y'], 3, '.', '') : '' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('templates.footer')
    </body>
</html>