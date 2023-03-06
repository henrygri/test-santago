<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discipline;
use DB;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get roles file
        $path = storage_path('discipline.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        $macro = [];
        foreach ($worksheet->getRowIterator() AS $index => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }

        foreach($rows as $col) {
            if($col[0] == '') {
                $role = Discipline::create([
                    'nome' => $col[1],
                ]);
            } else {
                $role = Discipline::create([
                    'parent_id' => self::getLast(),
                    'nome' => $col[1]
                ]);
            }
        }
        
    }

    private function getLast() {
        $obj = DB::table('discipline')->orderBy('id','desc')->whereNull('parent_id')->first();
        return $obj->id;
    }
}
