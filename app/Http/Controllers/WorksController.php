<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class WorksController extends Controller
{

    /**
     * Full path to static site files
     *
     * @var String
     */
    protected $workBasePath;

    /**
     * Filesystem Instance
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Current Work Pages
     *
     * @var Array
     */
    protected $currentWork;

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

        $this->updateCurrentWork();
    }

    /**
     * Updates currentWork array with current work pages in
     * static site source
     *
     * @return void
     */
    protected function updateCurrentWork()
    {
        $worksFolder = $this->files->files($this->workBasePath);
        $works = [];

        foreach ($worksFolder as $file) {
            $fileExtension = '.blade.md';
            $fileName = str_replace($this->workBasePath, '', $file->getFileName());

            // FUTURE TODO: Figure out a "caching" strategy for file contents
            $fileContents = $this->files->get($file);
            $fileContents = substr($fileContents, stripos($fileContents, '---', 0), strrpos($fileContents, '---', 0));
            $fileContents = trim($fileContents, '---');
            $fileSettings = explode("\n", $fileContents);

            $workItem = [];
            foreach ($fileSettings as $setting) {
                if (strlen($setting) === 0) {
                    continue;
                }

                $keyValuePair = explode(':', $setting);

                if (count($keyValuePair) != 2) {
                    continue;
                }

                $workItem[$keyValuePair[0]] = trim($keyValuePair[1]);
            }

            $workItem['slug'] = (isset($workItem['title'])) ? '/works/' . str_slug($workItem['title'], '-') : '/';
            $works[] = $workItem;
        }

        // By default, sort works by date DESC
        usort($works, function ($a, $b) {
            $aDate = date_create($a['date']);
            $bDate = date_create($b['date']);
            return $bDate <=> $aDate;
        });

        $this->currentWork = $works;
    }

    /**
     * Determines if works directory has grown
     *
     * @return boolean true if file count has changed
     */
    protected function hasWorksUpdated()
    {
        $worksFolder = $this->files->files($this->workBasePath);
        return count($worksFolder) !== count($this->currentWork);
    }

    /**
     * Retrieves total works for a given page
     *
     * @param integer $page Current page to retrieve
     * @param integer $pageSize Total works to display
     * @return Array subset of work items
     */
    protected function pagedWork($page = 1, $pageSize = 10)
    {
        $offset = ($page - 1) * $pageSize;

        // TODO: json_encode when ajax request has been set
        if (count($this->currentWork) <= $pageSize) {
            return $this->currentWork;
        }

        return array_splice($this->currentWork, $offset, $pageSize);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $works = $this->currentWork;

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
