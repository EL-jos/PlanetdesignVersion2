<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ArticleExport implements FromCollection, WithStrictNullComparison, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Article::all([
            'reference', 'name', 'description'
        ]);
    }

    /*public function array(): array
    {
        // TODO: Implement array() method.
        return Article::all([
            'reference', 'name', 'description'
        ])->toArray();
    }*/

    public function headings(): array {

        return [
            'Reference',
            'Nom',
            'Description'
        ];

    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->reference,
            $row->name,
            htmlspecialchars_decode(strip_tags($row->description)),
        ];
    }
}
