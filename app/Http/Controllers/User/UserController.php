<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    // home page
    public function home() {

        $products = Product::select( 'products.id', 'products.name', 'products.price', 'products.description',
        'products.image', 'products.created_at', 'products.category_id', 'categories.name as category_name', )
                            ->leftJoin('categories', 'products.category_id', 'categories.id')

                            ->when( request('categoryId'), function($query) {
                                $query->where('products.category_id', request('categoryId'));
                            })

                            ->when( request('searchKey'), function($query) {
                                $query->where('products.name', 'like', '%'.request('searchKey').'%');
                            })

                            // minPrice = true & maxPrice = true
                            ->when( request('minPrice') != null && request('maxPrice') != null, function($query) {
                                $query->whereBetween('products.price', [ request('minPrice'), request('maxPrice') ]);
                            })

                            // minPrice = true & maxPrice = false
                            ->when( request('minPrice') != null && request('maxPrice') == null, function($query) {
                                $query->where('products.price', '>=', request('minPrice'));
                            })

                            // minPrice = false & maxPrice = true
                            ->when( request('minPrice') == null && request('maxPrice') != null, function($query) {
                                $query->where('products.price', '<=', request('maxPrice'));
                            })

                            ->when( request('sortingType'), function($query) {
                                $sortingRules = explode(",", request('sortingType'));
                                $query->orderBy( $sortingRules[0], $sortingRules[1] ); // ( field name , asc|desc )
                            })
                            ->get();

        $categories = Category::select('id', 'name')->get();

        return view('user.home', compact('products', 'categories'));
    }


    // direct product details page
    public function productDetails($id) {
        $product = Product::select( 'products.id', 'products.name', 'products.price', 'products.description', 'products.stock',
        'products.image', 'products.created_at', 'products.category_id', 'categories.name as category_name', )
                            ->leftJoin('categories', 'products.category_id', 'categories.id')
                            ->where('products.id', $id)
                            ->first();  // first mhr so zero khann ma pr, get nae so pr tl (more complex)

        $comments = Comment::select('comments.id as comment_id', 'comments.message', 'comments.created_at',
        'users.id as user_id', 'users.profile', 'users.name')
                            ->where('comments.product_id', $id)
                            ->leftJoin('users', 'users.id', 'comments.user_id')
                            ->orderBy('comments.created_at', 'desc')
                            ->get();

        $stars = number_format( Rating::where('product_id', $id)->avg('count') );

        // $rating = Rating::where('product_id', $id)->avg('count');
        // $rating = number_format($rating); // remove .000

        // show users how much stars they have given
        $userRating = number_format( Rating::where('product_id', $id)->where('user_id', Auth::user()->id)->value('count') );


        $productList = Product::select( 'products.id', 'products.name', 'products.price', 'products.description', 'products.stock',
        'products.image', 'products.created_at', 'products.category_id', 'categories.name as category_name', )
                            ->leftJoin('categories', 'products.category_id', 'categories.id')
                            ->get();

        return view('user.details', compact('product','comments', 'stars', 'userRating', 'productList'));
    }


    // create comment
    public function comment(Request $request) {
        Comment::create([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'message' => $request->comment,
            // 'created_at' => Carbon::now(),
        ]);
        return back();
    }

    // delete comment
    public function commentDelete($id) {
        Comment::where('id', $id)->delete();
        return back();
    }

    // rating
    public function rating(Request $request) {

        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
        ],
        [
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
            'count' => $request->productRating,
        ]);
        return back();
    }

    // direct cart page
    public function cart() {
        $cart = Cart::select('carts.id as cart_id', 'carts.qty', 'products.id as product_id',
        'products.name', 'products.price', 'products.image')
                    ->leftJoin('products', 'carts.product_id', 'products.id')
                    ->where('carts.user_id', Auth::user()->id)
                    ->get();

        $totalPrice = 0;
        foreach($cart as $item)
            $totalPrice += $item->price * $item->qty;

        // dd($cart);
        return view('user.cart', compact('cart', 'totalPrice'));

    }

    // add to cart
    public function addToCart(Request $request) {
        Cart::create(
        [
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty,
        ]);
        Alert::success('Add to Cart Success', 'Add to Cart Created Successfully');
        return back();
        // dd($request->all());
    }

    // cart delete process
    public function cartDelete(Request $request) {
        $cartId = $request['cartId'];

        Cart::where('id', $cartId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart delete successfully'
        ], 200);    // 200 means OK (can learn at http status)

    }

    // temp storage
    public function tempStorage(Request $request) {
        $orderTemp = [];
        foreach($request->all() as $item) {
            array_push($orderTemp, [
                'user_id' => $item['user_id'],   // database ka name => user si ka key
                'product_id' => $item['product_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
                'finalAmt' => $item['totalAmt']
            ]);
        }
        Session::put('tempCart', $orderTemp);

        return response()->json([
            'status' => 'success',
            'message' => 'temp storage success'
        ], 200);
    }

    // direct to payment page
    public function paymentPage() {
        $paymentAcc = Payment::select('id', 'account_name', 'account_number', 'type')
                                ->orderBy("type", "asc")
                                ->get();
        // dd($paymentAcc);
        $orderTemp = Session::get('tempCart');

        // dd($orderTemp);

        return view('user.payment', compact('paymentAcc', 'orderTemp'));
    }

    // order product
    public function order(Request $request){
        // dd($request->all());

        $request->validate([
            'name' => 'required|min:1|max:50',
            'phone' => 'required|numeric|min:10',
            'address' => 'required|max:2000',
            'paymentType' => 'required',
            'payslipImage' => 'required|file|mimes:png,jpg,jpeg,webp,svg,gif'

        ]);

        $orderTemp = Session::get('tempCart');

        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount,
        ];

        if($request->hasFile('payslipImage')) {
            $fileName = uniqid(). $request->file("payslipImage")->getClientOriginalName();
            $request->file("payslipImage")->move( public_path(). "/payslip_image/", $fileName );
            $data['payslip_image'] = $fileName;
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);

        foreach($orderTemp as $item){
            Order::create([
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
            ]);
            Cart::where('user_id', $item['user_id'])->where('product_id', $item['product_id'])->delete();
        }

        Alert::success('Thanks for you order!', 'Order Created Successfully');
        return to_route('user#orderList');
    }

    // direct order list page
    public function orderList() {
        $orderLists = Order::where('user_id', Auth::user()->id)
                            // ->groupBy('order_code')
                            ->orderBy('created_at', 'desc')
                            ->get();
        $orderList = $orderLists->groupBy('order_code');

        // dd($orderList->toArray());

        return view('user.orderList', compact('orderList'));
    }

    // Direct to Contact Page
    public function contactPage() {
        return view('user.contact'); // references resources/views/user/contact.blade.php
    }

    // Handle Contact Feedback submission
        public function contactSend(Request $request)
        {
            // Validate the incoming form inputs
            $request->validate([
                'contactTitle'   => 'required|string|max:255',
                'contactMessage' => 'required|string',
            ]);

            // Insert into the database. Laravel automatically populates created_at and updated_at!
            Contact::create([
                'user_id' => Auth::id(),
                'title'   => $request->contactTitle,
                'message' => $request->contactMessage,
            ]);

        Alert::success('Message Delivered!', 'Your message has been successfully recorded.');

        return back();
    }

    // Direct to User Edit Profile Page
    public function userEditProfile() {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // Handle User Profile Update
    public function userUpdateProfile(Request $request) {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048', // 2MB Max
        ]);

        $user = \App\Models\User::find(Auth::id());

        // Update text values
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle profile image upload (using the input name 'image' to match your form)
        if ($request->hasFile('image')) {
            // Optional: Delete old profile image if it exists to save storage space
            if ($user->profile && file_exists(public_path('profile/' . $user->profile))) {
                @unlink(public_path('profile/' . $user->profile));
            }

            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('profile'), $fileName);
            $user->profile = $fileName;
        }

        $user->save();
        Alert::success('Profile Updated', 'Your profile details have been saved.');
        return back();
    }

    // Direct to User Change Password Page
    public function userChangePasswordPage() {
        return view('user.profile.changePassword');
    }

    // Handle User Password Change Update
    public function userUpdatePassword(Request $request) {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|confirmed', // Needs 'newPassword_confirmation' field in view
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (Hash::check($request->oldPassword, $user->password)) {
            $user->password = Hash::make($request->newPassword);
            $user->save();
            Alert::success('Password Changed', 'Your password was successfully updated.');
            return back();
        }

        return back()->withErrors(['oldPassword' => 'The old password does not match our records.']);
    }

    // Subscribe
    public function subscribe(Request $request)
    {
        // 1. Validate the input and check if it already exists in the subscribers table
        $request->validate([
            'subscriber_email' => 'required|email'
        ]);

        // 2. Check if the email is already subscribed
        $exists = Subscriber::where('email', $request->subscriber_email)->exists();

        if ($exists) {
            Alert::info('Already Subscribed!', 'This email is already registered to our newsletter.');
            return back();
        }

        // 3. Save the email to the database (Laravel automatically logs created_at/updated_at timestamps)
        Subscriber::create([
            'email' => $request->subscriber_email
        ]);

        Alert::success('Subscribed!', 'Thank you for joining our newsletter.');

        return back();
    }

}
