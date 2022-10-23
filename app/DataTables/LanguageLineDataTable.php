<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Spatie\TranslationLoader\LanguageLine;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class LanguageLineDataTable extends DataTable
{
    protected $edit,$delete;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->of($query)
            ->addColumn('action', function ($users) {
                $edit = $this->edit ? '<a href="'.route('language-line.edit', ['language_line' => $users->id]).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;' : '';
                $delete = $this->delete ? '<a data-href="'.route('language-line.delete', ['language_line' => $users->id]).'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#confirm-delete"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;':'';

                return $edit.$delete;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Spatie\TranslationLoader\LanguageLine $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LanguageLine $model)
    {
        $language_lines = DB::Table('language_lines')->select(
            'language_lines.id as id',
            'language_lines.group',
            'language_lines.key',
            'language_lines.text'
        );
        return $language_lines;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('languageline-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'language_lines.id', 'title' => 'ID'],
            ['data' => 'group', 'name' => 'language_lines.group', 'title' => 'Group'],
            ['data' => 'key', 'name' => 'language_lines.key', 'title' => 'Key'],
            ['data' => 'text', 'name' => 'language_lines.text', 'title' => 'text']
            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'LanguageLine_' . date('YmdHis');
    }
}
