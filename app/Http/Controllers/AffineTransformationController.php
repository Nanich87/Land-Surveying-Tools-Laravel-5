<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Patterns\Factory\CartesianTransformationFactory;

class AffineTransformationController extends Controller {

    const UPLOAD_FOLDER = 'uploads';

    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        $data['pageTitle'] = 'Трансформация на декартови координати';
        $data['transformationType'] = 'Афинна трансформация';
        $data['message'] = Session::get('message');

        return view('transformations.index', $data);
    }

    public function result() {
        if (Request::hasFile('file')) {
            $data['pageTitle'] = 'Трансформация на декартови координати';
            $data['transformationType'] = 'Афинна трансформация';

            $file = Request::file('file');
            $uniqueFilename = sprintf('%s_%s.xml', time(), md5(time() . $file->getClientOriginalName() . rand()));
            $file->move(self::UPLOAD_FOLDER, $uniqueFilename);

            $document = self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $uniqueFilename;
            try {
                $affineTransformation = CartesianTransformationFactory::create('Affine', $document);
                $data['points'] = $affineTransformation->transformPoints();
                $data['rootMeanSquareErrors'] = $affineTransformation->getRootMeanSquareErrors();
            } catch (\Exception $ex) {
                return Redirect::to('affine')->with('message', $ex->getMessage());
            } finally {
                File::delete($document);
            }

            return view('transformations.result', $data);
        } else {
            return Redirect::to('affine')->with('message', 'Upload Failed!');
        }
    }

}