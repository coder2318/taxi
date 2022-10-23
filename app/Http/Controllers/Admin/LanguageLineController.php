<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LanguageLineDataTable;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\LanguageLineService;
use Illuminate\Http\Request;

class LanguageLineController extends Controller
{
    protected $service;
    public function __construct(LanguageLineService $service)
    {
        $this->service = $service;
    }
    /**
     * Load Datatable for Rider
     *
     * @param array $dataTable  Instance of RiderDataTable
     * @return datatable
     */
    public function index(LanguageLineDataTable $dataTable)
    {
        return $dataTable->render('admin.translation.view');
    }

    /**
     * Add a New Rider
     *
     * @param array $request  Input values
     * @return redirect     to Rider view
     */
    public function create(Request $request)
    {
        $languages = Language::get();
        return view('admin.translation.add', ['languages' => $languages]);
    }

    /**
     * Update Rider Details
     *
     * @param array $request    Input values
     * @return redirect     to Rider View
     */
    public function update(Request $request)
    {
        return redirect('admin/rider');
    }

    /**
     * Delete Rider
     *
     * @param array $request    Input values
     * @return redirect     to Rider View
     */
    public function delete(Request $request)
    {
    
        flashMessage('success', 'Deleted Successfully');
        return redirect('admin/rider');
    }

}
