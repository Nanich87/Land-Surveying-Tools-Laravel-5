<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Models\Survey\Format\InputFormat\Base_Format;
use App\Patterns\Factory\InputFormatFactory;
use App\Libraries\CurlHelper;

class ConversionController extends Controller {

    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        $data['pageTitle'] = 'Конвертиране на геодезически файлове';
        $data['inputFormat'] = Base_Format::getSupportedInputFormats();
        $data['outputFormat'] = Base_Format::getSupportedOutputFormats();
        $data['message'] = Session::get('message');

        return view('conversion.index', $data);
    }

    public function result() {
        if (!Input::has('input-format')) {
            return Redirect::to('conversion')->with('message', 'Не е избран входен формат на данните!');
        }

        if (!Input::has('output-format')) {
            return Redirect::to('conversion')->with('message', 'Не е избран изходен формат на данните!');
        }

        if (!Input::has('file-content')) {
            return Redirect::to('conversion')->with('message', 'Не е въведено съдържание на файла!');
        }

        if (!Input::has('g-recaptcha-response')) {
            return Redirect::to('conversion')->with('message', 'Не е въведен код за сигурност!');
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $postFields = sprintf('secret=6LdblQMTAAAAAOrQuqC-CdIEmZ8RGsRKRcjLdykX&response=%s', Input::get('g-recaptcha-response'));
        $post = 2;

        $response = CurlHelper::executePostRequest($url, $post, $postFields);

        if ($response['success'] === false) {
            return Redirect::to('conversion')->with('message', 'Invalid Captcha Code');
        }

        try {
            $inputFormat = Input::get('input-format');
            $outputFormat = Input::get('output-format');
            $inputContent = Input::get('file-content');

            $newFile = InputFormatFactory::create($inputContent, $inputFormat, $outputFormat);
            $newFile->convert();

            $data['fileContent'] = htmlentities($newFile->toString(), ENT_QUOTES, 'UTF-8', false);
        } catch (\Exception $e) {
            return Redirect::to('conversion')->with('message', $e->getMessage());
        }

        $data['pageTitle'] = 'Конвертиране на геодезически файлове';
        $data['inputFormat'] = Base_Format::getSupportedInputFormats();
        $data['outputFormat'] = Base_Format::getSupportedOutputFormats();
        $data['message'] = Session::get('message');

        $outputView = Input::get('output-view');
        switch ($outputView) {
            case 'screen':
                return view('conversion.result', $data);
            case 'file':
                return Response::make($newFile->toString(), '200', array(
                            'Content-Type' => 'text/plain',
                            'Content-Disposition' => 'attachment; filename=file.txt'
                ));
            default:
                return view('conversion.result', $data);
        }
    }

}
