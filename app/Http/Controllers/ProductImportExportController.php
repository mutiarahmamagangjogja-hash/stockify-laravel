<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductImportExportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view(
            'products.import-export'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT
    |--------------------------------------------------------------------------
    */

    public function export(): StreamedResponse
    {
        $products = Product::with([
            'category',
            'attributeValues.attribute',
        ])
            ->latest()
            ->get();


        $filename =
            'produk-stockify-' .
            date('Y-m-d-H-i-s') .
            '.csv';


        $headers = [

            'Content-Type' =>
                'text/csv; charset=UTF-8',

            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',

        ];


        return response()->stream(
            function () use ($products) {

                $handle = fopen(
                    'php://output',
                    'w'
                );


                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM
                |--------------------------------------------------------------------------
                */

                fprintf(
                    $handle,
                    chr(0xEF) .
                    chr(0xBB) .
                    chr(0xBF)
                );


                /*
                |--------------------------------------------------------------------------
                | HEADER
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [

                    'Nama Produk',

                    'SKU',

                    'Kategori',

                    'Deskripsi',

                    'Harga',

                    'Stok',

                    'Stok Minimum',

                    'Satuan',

                    'Status',

                    'Atribut',

                ]);


                /*
                |--------------------------------------------------------------------------
                | PRODUCTS
                |--------------------------------------------------------------------------
                */

                foreach ($products as $product) {


                    /*
                    |--------------------------------------------------------------------------
                    | FORMAT ATRIBUT
                    |--------------------------------------------------------------------------
                    */

                    $attributes = $product
                        ->attributeValues
                        ->groupBy(
                            'product_attribute_id'
                        )
                        ->map(
                            function ($values) {

                                $attribute =
                                    $values
                                        ->first()
                                        ->attribute;

                                if (!$attribute) {
                                    return null;
                                }


                                $attributeValues =
                                    $values
                                        ->pluck('value')
                                        ->implode(' | ');


                                return
                                    $attribute->name .
                                    ': ' .
                                    $attributeValues;
                            }
                        )
                        ->filter()
                        ->implode('; ');


                    /*
                    |--------------------------------------------------------------------------
                    | CSV ROW
                    |--------------------------------------------------------------------------
                    */

                    fputcsv($handle, [

                        $product->name,

                        $product->sku,

                        $product->category
                            ? $product->category->name
                            : '',

                        $product->description,

                        $product->price,

                        $product->stock,

                        $product->minimum_stock,

                        $product->unit,

                        $product->status,

                        $attributes,

                    ]);
                }


                fclose($handle);

            },
            200,
            $headers
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function template(): StreamedResponse
    {
        $filename =
            'template-import-produk-stockify.csv';


        $headers = [

            'Content-Type' =>
                'text/csv; charset=UTF-8',

            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',

        ];


        return response()->stream(
            function () {

                $handle = fopen(
                    'php://output',
                    'w'
                );


                fprintf(
                    $handle,
                    chr(0xEF) .
                    chr(0xBB) .
                    chr(0xBF)
                );


                /*
                |--------------------------------------------------------------------------
                | HEADER
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [

                    'Nama Produk',

                    'SKU',

                    'Kategori',

                    'Deskripsi',

                    'Harga',

                    'Stok',

                    'Stok Minimum',

                    'Satuan',

                    'Status',

                    'Atribut',

                ]);


                /*
                |--------------------------------------------------------------------------
                | CONTOH
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [

                    'Laptop ASUS',

                    'LPT-ASUS-001',

                    'Elektronik',

                    'Laptop ASUS untuk kebutuhan kerja',

                    '8000000',

                    '10',

                    '2',

                    'pcs',

                    'active',

                    'Warna: Hitam | Silver; RAM: 8GB | 16GB',

                ]);


                fclose($handle);

            },
            200,
            $headers
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([

            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:5120',
            ],

        ], [

            'file.required' =>
                'Silakan pilih file CSV terlebih dahulu.',

            'file.file' =>
                'File yang dipilih tidak valid.',

            'file.mimes' =>
                'File harus berformat CSV.',

            'file.max' =>
                'Ukuran file maksimal 5 MB.',

        ]);


        $file =
            $request->file('file');


        $handle =
            fopen(
                $file->getRealPath(),
                'r'
            );


        if (!$handle) {

            return redirect()
                ->route(
                    'produk.import-export'
                )
                ->with(
                    'error',
                    'File tidak dapat dibaca.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        $header =
            fgetcsv($handle);


        if (!$header) {

            fclose($handle);

            return redirect()
                ->route(
                    'produk.import-export'
                )
                ->with(
                    'error',
                    'File CSV kosong.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE BOM
        |--------------------------------------------------------------------------
        */

        $header[0] =
            preg_replace(
                '/^\xEF\xBB\xBF/',
                '',
                $header[0]
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALIZE HEADER
        |--------------------------------------------------------------------------
        */

        $header =
            array_map(
                function ($value) {

                    return strtolower(
                        trim($value)
                    );

                },
                $header
            );


        /*
        |--------------------------------------------------------------------------
        | REQUIRED HEADER
        |--------------------------------------------------------------------------
        */

        $requiredHeaders = [

            'nama produk',

            'sku',

            'kategori',

            'deskripsi',

            'harga',

            'stok',

            'stok minimum',

            'satuan',

            'status',

            'atribut',

        ];


        foreach ($requiredHeaders as $required) {

            if (!in_array(
                $required,
                $header
            )) {

                fclose($handle);

                return redirect()
                    ->route(
                        'produk.import-export'
                    )
                    ->with(
                        'error',
                        'Format CSV tidak sesuai. Silakan gunakan template CSV Stockify.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | COUNTER
        |--------------------------------------------------------------------------
        */

        $successCount = 0;

        $updateCount = 0;

        $errorCount = 0;


        /*
        |--------------------------------------------------------------------------
        | READ ROW
        |--------------------------------------------------------------------------
        */

        while (
            ($row = fgetcsv($handle))
            !== false
        ) {


            /*
            |--------------------------------------------------------------------------
            | SKIP EMPTY ROW
            |--------------------------------------------------------------------------
            */

            if (
                count($row) === 1 &&
                trim($row[0]) === ''
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | NORMALIZE COLUMN
            |--------------------------------------------------------------------------
            */

            $row = array_pad(
                $row,
                count($header),
                ''
            );


            $data =
                array_combine(
                    $header,
                    $row
                );


            if (!$data) {

                $errorCount++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI
            |--------------------------------------------------------------------------
            */

            $name =
                trim(
                    $data['nama produk'] ?? ''
                );


            $sku =
                trim(
                    $data['sku'] ?? ''
                );


            if (
                $name === '' ||
                $sku === ''
            ) {

                $errorCount++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | CATEGORY
            |--------------------------------------------------------------------------
            */

            $category = null;


            $categoryName =
                trim(
                    $data['kategori'] ?? ''
                );


            if ($categoryName !== '') {

                $category =
                    Category::firstOrCreate(

                        [
                            'name' =>
                                $categoryName,
                        ],

                        [
                            'description' =>
                                null,
                        ]

                    );
            }


            /*
            |--------------------------------------------------------------------------
            | PRODUCT DATA
            |--------------------------------------------------------------------------
            */

            $productData = [

                'name' =>
                    $name,

                'category_id' =>
                    $category?->id,

                'description' =>
                    trim(
                        $data['deskripsi'] ?? ''
                    ),

                'price' =>
                    is_numeric(
                        $data['harga'] ?? null
                    )
                        ? $data['harga']
                        : 0,

                'stock' =>
                    is_numeric(
                        $data['stok'] ?? null
                    )
                        ? (int) $data['stok']
                        : 0,

                'minimum_stock' =>
                    is_numeric(
                        $data['stok minimum'] ?? null
                    )
                        ? (int) $data['stok minimum']
                        : 0,

                'unit' =>
                    trim(
                        $data['satuan'] ?? 'pcs'
                    ) ?: 'pcs',

                'status' =>
                    in_array(

                        strtolower(
                            trim(
                                $data['status'] ?? 'active'
                            )
                        ),

                        [
                            'active',
                            'inactive'
                        ]

                    )
                        ? strtolower(
                            trim(
                                $data['status']
                            )
                        )
                        : 'active',

            ];


            /*
            |--------------------------------------------------------------------------
            | FIND PRODUCT BY SKU
            |--------------------------------------------------------------------------
            */

            $product =
                Product::where(
                    'sku',
                    $sku
                )->first();


            if ($product) {

                $product->update(
                    $productData
                );

                $updateCount++;

            } else {

                $productData['sku'] =
                    $sku;

                $product =
                    Product::create(
                        $productData
                    );

                $successCount++;
            }


            /*
            |--------------------------------------------------------------------------
            | IMPORT ATTRIBUTE
            |--------------------------------------------------------------------------
            */

            $attributeText =
                trim(
                    $data['atribut'] ?? ''
                );


            /*
            |--------------------------------------------------------------------------
            | HANYA SYNC JIKA ADA ATRIBUT
            |--------------------------------------------------------------------------
            */

            if ($attributeText !== '') {

                $attributeValueIds = [];


                /*
                |--------------------------------------------------------------------------
                | CONTOH:
                |
                | Warna: Hitam | Silver;
                | RAM: 8GB | 16GB
                |--------------------------------------------------------------------------
                */

                $attributeGroups =
                    preg_split(
                        '/\s*;\s*/',
                        $attributeText
                    );


                foreach (
                    $attributeGroups
                    as $attributeGroup
                ) {

                    $attributeGroup =
                        trim(
                            $attributeGroup
                        );


                    if (
                        $attributeGroup === ''
                    ) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SPLIT NAMA ATRIBUT DAN NILAI
                    |--------------------------------------------------------------------------
                    */

                    $parts =
                        explode(
                            ':',
                            $attributeGroup,
                            2
                        );


                    if (
                        count($parts) !== 2
                    ) {
                        continue;
                    }


                    $attributeName =
                        trim(
                            $parts[0]
                        );


                    $valuesText =
                        trim(
                            $parts[1]
                        );


                    if (
                        $attributeName === '' ||
                        $valuesText === ''
                    ) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CARI / BUAT ATRIBUT
                    |--------------------------------------------------------------------------
                    */

                    $attribute =
                        ProductAttribute::firstOrCreate(

                            [
                                'name' =>
                                    $attributeName,
                            ],

                            [
                                'description' =>
                                    null,
                            ]

                        );


                    /*
                    |--------------------------------------------------------------------------
                    | SPLIT NILAI
                    |--------------------------------------------------------------------------
                    */

                    $values =
                        preg_split(
                            '/\s*\|\s*/',
                            $valuesText
                        );


                    foreach (
                        $values
                        as $valueText
                    ) {

                        $valueText =
                            trim(
                                $valueText
                            );


                        if (
                            $valueText === ''
                        ) {
                            continue;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | CARI / BUAT NILAI
                        |--------------------------------------------------------------------------
                        */

                        $attributeValue =
                            ProductAttributeValue::firstOrCreate(

                                [
                                    'product_attribute_id' =>
                                        $attribute->id,

                                    'value' =>
                                        $valueText,
                                ]

                            );


                        $attributeValueIds[] =
                            $attributeValue->id;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | HUBUNGKAN ATRIBUT KE PRODUK
                |--------------------------------------------------------------------------
                */

                $product
                    ->attributeValues()
                    ->sync(
                        array_unique(
                            $attributeValueIds
                        )
                    );
            }
        }


        fclose($handle);


        /*
        |--------------------------------------------------------------------------
        | RESULT
        |--------------------------------------------------------------------------
        */

        $message =
            'Import selesai. ' .
            $successCount .
            ' produk baru ditambahkan, ' .
            $updateCount .
            ' produk diperbarui.';


        if ($errorCount > 0) {

            $message .=
                ' ' .
                $errorCount .
                ' baris dilewati karena data tidak valid.';
        }


        return redirect()
            ->route(
                'produk.import-export'
            )
            ->with(
                'success',
                $message
            );
    }
}