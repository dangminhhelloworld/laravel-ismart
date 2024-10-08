<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ImageProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller

{


    public function index(Request $request)
    {
        // Lấy danh sách sản phẩm
        $user_id = Auth::user()->id;
        $products = Product::query()
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('user_id','=',$user_id)
            ->select([
                'products.id as id',
                'products.name as name',
                Product::raw('REPLACE(FORMAT(products.price, 0), \',\', \'.\') as price'), // Định dạng giá trong SQL
                'categories.name as cname',
                Product::raw('REPLACE(FORMAT(products.sale_price, 0), \',\', \'.\') as sale_price'),
                Product::raw('REPLACE(FORMAT(products.quantity, 0), \',\', \'.\') as quantity'),

            ]);

        // Xử lý dữ liệu cho DataTables
        $data = DataTables::of($products)
            ->setRowClass(function ($product) {
                return $product->id % 2 == 0 ? 'text-danger' : 'text-primary';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->get('search')['value'] != '') {
                    $search = strtolower($request->get('search')['value']);
                    $query->where(function ($q) use ($search) {
                        $q->whereRaw('LOWER(products.name) LIKE ?', ["%$search%"])
                            ->orWhereRaw('LOWER(categories.name) LIKE ?', ["%$search%"]);
                    });
                }
            })
            ->toJson(); // Trả về dữ liệu JSON cho DataTables

        // Nếu request là Ajax thì trả về dữ liệu JSON
        if ($request->ajax()) {
            return $data;
        }

        // Nếu không phải Ajax thì render view
        return view('admin.product.index');
    }



    public function add()
    {
        $category = Category::get();

        return view('admin.product.form', compact('category'));
    }

    public function save(ProductRequest $request)
    {

        $user_id  = Auth::user()->id ;

            $request->validated();

        if($request->sale_price !=null || $request->sale_price !=0){

            $sale_price = $request->sale_price;
            if($sale_price >  $request->price){
                return redirect()->back()->with('error','Giá gốc phải thấp hơn');
            }
        }else{
            $sale_price =$request->price ;
        }

        $data = [
             'user_id' => $user_id ,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'quantity' => $request->quantity ,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'sale_price' => $sale_price,
            'description' => $request->description,
            'content' => $request->content,
            'status' => 'Active',


        ];



        $newProduct =   Product::create($data);
        $imageData  = [];

        // ! UP load file
        if ($files = $request->file('images')) {
            //xoá ảnh tồn tại


            //Thêm lại
            foreach ($files as $key => $file) {
                $duoifile = $file->getClientOriginalExtension();
                $filename = $key . '-' . time() . '.' . $duoifile;
                $path = "uploads/products/";
                $file->move($path, $filename);
                $tmp = [
                    'product_id' => $newProduct->id,
                    'image_name' => $path . $filename,
                ];
                $imageData[] = $tmp;
            }
            // ADD CSDL
            ImageProduct::insert($imageData);
        }

        return redirect()->route('products')->with('message', "Sản phẩm {$request->name} đã được thêm thành công.");
    }

    public function edit($id)

    {

        $product = Product::find($id);
        $category = Category::get();

        $images = ImageProduct::where('product_id', '=', $id)->get();
        //dd($images);
        return view('admin.product.form', compact('category', 'product', 'images'));
    }
    public function update(Request $request, $id)
    {
        if($request->sale_price !=null || $request->sale_price !=0){
            $sale_price = $request->sale_price;
            if($sale_price >  $request->price){
                return redirect()->back()->with('error','Giá gốc phải thấp hơn');
            }
        }else{
            $sale_price =$request->price ;
        }
        $product = Product::find($id);


        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sale_price' => $sale_price,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'content' => $request->content,
            'quantity' => $request->quantity
        ];




        Product::find($id)->update($data);
        $imageData  = [];

        // ! UP load file
        if ($files = $request->file('images')) {
            //xoá ảnh tồn tại
            $images = ImageProduct::where('product_id', '=', $id)->get();

            foreach ($images as $image) {

                if (File::exists($image->image_name)) {
                    File::delete($image->image_name);
                }


                $image->delete();
                Log::info('Image record deleted from database: ' . $image->id);
            }

            //Thêm lại
            foreach ($files as $key => $file) {
                $duoifile = $file->getClientOriginalExtension();
                $filename = $key . '-' . time() . '.' . $duoifile;
                $path = "uploads/products/";
                $file->move($path, $filename);
                $tmp = [
                    'product_id' => $id,
                    'image_name' => $path . $filename,
                ];
                $imageData[] = $tmp;
            }
            // ADD CSDL
            ImageProduct::insert($imageData);
        }


        return redirect()->route('products')->with('message', "Sản phẩm {$product->name} đã được cập nhật.");
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        //xoá ảnh tồn tại
        $images = ImageProduct::where('product_id', '=', $id)->get();

        foreach ($images as $image) {

            if (File::exists($image->image_name)) {
                File::delete($image->image_name);
            }


            $image->delete();
            Log::info('Image record deleted from database: ' . $image->id);
        }
        return redirect()->route('products')->with('message', "Sản phẩm {$product->name} đã được xóa thành công.");
    }
}
