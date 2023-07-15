<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SSLController extends Controller
{
    public function getDownload(Request $request) {
        // prepare content
        // $logs = log->all();
        $content = "6515B2BA23CA7BE4DD2E28E71653453A15438ABC55F071C206DE73E28A8C847D\ncomodoca.com\n149e5bd2e84b94f";
    
        // file name that will be used in the download
        $fileName = "logs.txt";
    
        // use headers in order to generate the download
        $headers = [
          'Content-type' => 'text/plain', 
          'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
          'Content-Length' => strlen($content)
        ];
    
        // make a response, with the content, a 200 response code and the headers
        return response($content)->header('Content-Type', 'text/plain');;
    }
}
