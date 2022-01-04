<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{
    private $viewDir;
    private $viewFiles;

    public function __construct()
    {
        $this->viewDir = 'pages.setting';
        $this->viewFiles = [
            'index' => $this->viewDir . '.index',
            'add' => $this->viewDir . '.add',
            'edit' => $this->viewDir . '.edit',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::select('id', 'config_key', 'config_value')->latest()->paginate(5);
        return View::component($this->viewFiles['index'], compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::component($this->viewFiles['add']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSettingRequest $request)
    {
        Setting::create([
            'config_key' => $request->config_key,
            'config_value' => $request->config_value
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return View::component($this->viewFiles['edit'], compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update([
            'config_key' => $request->config_key,
            'config_value' => $request->config_value
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
    }
}
