<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class WorksController extends Controller
{

    protected $workBasePath;

    /**
     * Filesystem Instance
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->workBasePath = env('WORK_DIR');
        $this->files = new Filesystem();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $worksFolder = $this->files->files($this->workBasePath);
        $works = [];

        foreach ($worksFolder as $file) {
            $fileExtension = '.blade.md';
            $fileName = str_replace($this->workBasePath, '', $file->getFileName());

            // TODO: Figure out a "caching" strategy for file contents
            // $fileContents = $this->files->get($file);
            // $fileContents = substr($fileContents, stripos($fileContents, '---', 0), strrpos($fileContents, '---', 0));
            // $fileContents = trim($fileContents, '---');
            // $fileSettings = explode("\n", $fileContents);
            // $works[] = $fileSettings;

            if (strpos($fileName, $fileExtension) !== false) {
                // TODO: Read file for date
                $works[] = ['name' => rtrim($fileName, '.blade.md'), 'date' => ''];
            }
        }

        return view('dashboard')->with('works', $works);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
