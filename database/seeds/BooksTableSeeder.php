<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use VIPSoft\Unzip\Unzip;
use Ddeboer\DataImport\Reader\CsvReader;

class BooksTableSeeder extends Seeder
{

    protected $resources = [
        [
            'file' => 'BX-Books.csv',
            'model' => App\Book::class,
            'columns' => [
                'isbn'             => 'ISBN',
                'title'            => 'Book-Title',
                'publisher'        => 'Publisher',
                'pub_year'         => 'Year-Of-Publication',
                'image_url_small'  => 'Image-URL-S',
                'image_url_medium' => 'Image-URL-M',
                'image_url_large'  => 'Image-URL-L',
            ],
            'uniq' => ['isbn'],
            'relationships' => [
//                'Publisher' => 'Publisher',
                'Book-Author' => [
                    'model' => App\Author::class,
                    'column' => 'name',
                    'method' => 'authors',
                    'has' => 'authors.name',
                    'split' => ','
                ],
            ],
//            'onDublicate' => 'isbn=VALUES(isbn)'
        ],
/*        [
            'file' => 'BX-Users.csv',
            'model' => App\BookUser::class,
'uniq' => ['id'],
            'columns' => [
                'id' => 'User-ID',
                'location' => 'Location',
                'age' => 'Age',
            ],
            'onDublicate' => 'id=VALUES(id)'
        ],*/
/*        [
            'file' => 'BX-Book-Ratings.csv',
            'model' => App\BookRating::class,
'uniq' => ['user_id', 'isbn'],
            'columns' => [
                'user_id' => 'User-ID',
                'isbn' => 'ISBN',
                'rating' => 'Book-Rating',
            ],
            'onDublicate' => 'user_id=VALUES(user_id),isbn=VALUES(isbn)'
        ],*/
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(App\Author::class, 50)->create()->each(function($model) {
            $model->save();
        });
        factory(App\Book::class, 50)->create()->each(function($model) {
            $model->save();
        });*/

        $this->unzipData();
        $this->applyData();
    }

    protected function unzipData()
    {
        $zipFile = 'BX-CSV-Dump.zip';
        $csvFile = 'BX-Books.csv';
        $dataPath =  storage_path('app/public/');
        $fs = new Filesystem();

        if ($fs->exists($dataPath.$csvFile)) {
            return;
        }

        if ($fs->exists($dataPath.$zipFile)) {
            $unzip = new Unzip();
            $unzip->extract($dataPath.$zipFile, $dataPath);
        } else {
            throw new FileNotFoundException($dataPath.$zipFile);
        }
    }

    protected function applyData()
    {
        $dataPath =  storage_path('app/public/');
        $fs = new Filesystem();

        foreach ($this->resources as $resource) {

            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model = factory($resource['model'])->make();
            $tableName = $model->getTable();
            $filePath = $dataPath.$resource['file'];

            if ($fs->exists($filePath) == false) {
                continue;
            }
            $file = new \SplFileObject($filePath);
            $reader = new CsvReader($file, ";");
            $reader->setHeaderRowNumber(0);

            DB::table($tableName)->truncate();

            foreach ($reader as $item => $row) {
                try {
                    $values = $this->getRemapValues($row, $resource['columns']);
                    $uniq = array_intersect_key($values, array_flip(Arr::get($resource, 'uniq', [])));
                    $model = resolve($resource['model'])->firstOrCreate($uniq, $values);
                    $this->generateRelations($model, $row, $resource['relationships']);
                    if (($item % 10000) === 0) {
                        echo $item . PHP_EOL;
                    }
                } catch (QueryException $e) {
                    echo 'E:' .$e->getMessage() . PHP_EOL;
                }
            }
            echo 'Total: ' . $item . PHP_EOL;
        }
    }

    protected function getRemapValues(array $item, array $columns)
    {
        $values = [];
        foreach ($columns as $columnDbName => $columnFileName) {
            $values[$columnDbName] = Arr::get($item, $columnFileName, null);
            switch ($columnDbName) {
                case 'title':
                case 'name':
                case 'subtitle':
                    $before = $values[$columnDbName];
                    $encode = mb_detect_encoding($before);
                    $values[$columnDbName] = iconv('UTF-8', $encode.'//IGNORE', $before);
                    break;
            }
        }

        return $values;
    }

    protected function generateInsertValues(array $item, array $columns)
    {
        $result = [];
        foreach ($columns as $columnDbName => $columnFileName) {
            $value = array_key_exists($columnFileName, $item) ? $item[$columnFileName] : null;
            $result[] = is_null($value) ? 'NULL' : $value;
        }
        return sprintf('(%s)', implode(', ', $result));
    }

    protected function generateRelations(Model $parent, array $item, array $relations)
    {
        foreach ($relations as $columnFileName => $relation) {
            $value = Arr::get($item, $columnFileName, null);
            $encode = mb_detect_encoding($value);
            $value = iconv('UTF-8', $encode.'//IGNORE', $value);
            $model = resolve($relation['model'])->firstOrCreate([$relation['column'] => $value]);
            $method = $relation['method'];
            $parent->$method()->sync([$model->id]);
        }
    }
}
