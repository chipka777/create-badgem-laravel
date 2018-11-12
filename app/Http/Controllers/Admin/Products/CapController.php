<?php

namespace App\Http\Controllers\Admin\Products;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CapController extends Controller
{
    const TMP_DIR = 'upload/caps/tmp/';
    const PUBLIC_DIR = 'upload/caps/';
    const PUBLIC_WCLOUD_DIR = 'upload/caps/wcloud/';
    const GLOBAL_PUBLIC_DIR = '/upload/caps/';    
    const GLOBAL_PUBLIC_WCLOUD_DIR  = '/upload/caps/wcloud/';
    
    public function index()
    {
        $page = 'products';

        return view('admin.products.cap.index', compact('page'));
    }

    public function getByCount($count, $offset)
    {
        $products = Product::offset($offset)
            ->limit($count)
            ->orderBy('created_at', 'desc')
            ->get();

        return json_encode([
            'products' => $products,
            'count' => Product::where('type', 'cap')->count(),
            'status' => 'Success',
        ]);
    }

    public function create(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:jpeg,jpg,png,gif',
            'extra_images.*' => 'mimes:jpeg,jpg,png,gif',
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'sizes' => 'required|string|max:255',
            'story' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $tmpName = $this->saveImage($request);
        $name = $this::GLOBAL_PUBLIC_DIR . $tmpName;
        $wcloudName = $this::GLOBAL_PUBLIC_WCLOUD_DIR . $tmpName;
        $extraImages = $this->saveExtraImages($request);

        $product = new Product;

        $product->name = $request->name;
        $product->price = $request->price;
        $product->photo = $name;
        $product->extra_images = $extraImages;
        $product->photo_wcloud = $wcloudName;        
        $product->sizes = $request->sizes;
        $product->story = $request->story;
        $product->type = $request->type;

        $product->save();

        return response()->json([
            'status' => true
        ]);
    } 

    public function edit(Request $request)
    {
        $newImage = false;
        $extraImages = false;

        if(is_string($request->photo)){
            $rules = 'required|string|max:255';
        } else {
            $newImage = true;
            
            $rules = 'required|mimes:jpeg,jpg,png,gif';
        }

        if(is_string($request->extra_images[0])){
            $extraRules = '';
        } else {
            $extraImages = true;
            
            $extraRules = 'required|mimes:jpeg,jpg,png,gif';
        }

        $validator = Validator::make($request->all(), [
            'photo' => $rules,
            'extra_images.*' => $extraRules,
            'extra_exist_images' => '',
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'sizes' => 'required|string|max:255',
            'story' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $product = Product::find($request->id);

        if ($newImage) {
            $tmpName = $this->saveImage($request);
            $name = $this::GLOBAL_PUBLIC_DIR . $tmpName;
            $wcloudName = $this::GLOBAL_PUBLIC_WCLOUD_DIR . $tmpName;
        } else {
            $name = $product->photo;
            $wcloudName = $product->photo_wcloud;            
        }

        if ($extraImages) {
            $tmpExtraImages = $this->saveExtraImages($request);
        }

        if ($request->extra_exist_images == "" || $request->extra_exist_images == null) {
            $extraImages = $tmpExtraImages;
        } else {
            $extraImages = $request->extra_exist_images . '|' . $tmpExtraImages;        
        }
        

        $product->name = $request->name;
        $product->price = $request->price;
        $product->photo = $name;
        $product->extra_images = $extraImages;        
        $product->photo_wcloud = $wcloudName;
        $product->sizes = $request->sizes;
        $product->story = $request->story;
        $product->type = $request->type;

        $product->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function deleteExtra(Request $request)
    {
        $product = Product::find($request->id);

        $product->extra_images = str_replace('|' . $request->image, '', $product->extra_images);
        $product->extra_images = str_replace($request->image . '|', '', $product->extra_images);

        $product->save();

        return response()->json([
            'extra' => $product->extra_images,
            'status' => true
        ]);
    }

    public function delete($id) 
    {
        if (Product::find($id)->delete()) {
            return json_encode([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ], 404);
    }

    private function saveExtraImages($request)
    {
        $response = '';
        $images = $request->files->get('extra_images');

        if (!empty($images)) {
            foreach ($images as $image) {
                $path = public_path($this::PUBLIC_DIR);
                $name = md5(time() . $image->getClientOriginalName()) . '.png'; 
                $image->move($path, $name);
                
                $response .= $this::GLOBAL_PUBLIC_DIR . $name . '|';
            }
        }
        

        return rtrim($response, '|');
    }

    private function saveImage($request)
    {
        $path = public_path($this::PUBLIC_DIR);
        $extension = $request->files->get('photo')->guessExtension();
        $name = md5(time()) . '.png';            
        
        $request->files->get('photo')->move($path, $name);
        
        $img = new \Imagick(realpath($this::PUBLIC_DIR . $name));

        $wd = $img->getImageWidth();

        if ($wd > 400) {
            exec("convert " . $this::PUBLIC_DIR . "$name -resize x400 " . $this::PUBLIC_DIR . "/$name");
        } 

        if ($wd > 150) {
            exec("convert " . $this::PUBLIC_DIR . "$name -resize x300 " . $this::TMP_DIR . "/$name");
        }else {
            exec("convert " . $this::PUBLIC_DIR . "$name  " . $this::TMP_DIR . "/$name");
        }
        

        exec("convert clouds/cloud.png " . $this::TMP_DIR . "$name -gravity center -geometry +0+10 -composite clouds/cloud.png -compose copyopacity -composite " . $this::PUBLIC_WCLOUD_DIR . "$name");
        exec("convert clouds/cloud-frame.png " . $this::PUBLIC_WCLOUD_DIR . "$name -geometry +30+10 -composite " . $this::PUBLIC_WCLOUD_DIR . "$name");

        exec("rm " . $this::TMP_DIR . "/$name");
        return $name;
    }
}
