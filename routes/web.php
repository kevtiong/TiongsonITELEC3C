<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;

// Added
use App\Models\User;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all();   // Added
        return view('dashboard', compact('users'));

    })->name('dashboard');
});

/*
Route::get('/category', function () {
    return view('admin.category.category');
})-> name('AllCat');
*/

Route::get('/category', [CategoryController::class, 'index'])->name('AllCat');
Route::post('/category/add', [CategoryController::class, 'AddCategory'])->name('AddCat');

Route::get('/category/edit/{id}', [CategoryController::class, 'EditCategory']);
Route::post('/category/update/{id}', [CategoryController::class, 'UpdateCategory']);
Route::post('/category/delete/{id}', [CategoryController::class, 'DeleteCategory'])->name('DeleteCat');

Route::post('/category/restore/{id}', [CategoryController::class, 'RestoreCategory'])->name('RestoreCat');
Route::post('/category/permanent-delete/{id}', [CategoryController::class, 'PermaDeleteCategory'])->name('PermaDeleteCat');


/*

    composer create-project laravel/laravel example-app

    composer require laravel/jetstream

    php artisan jetstream:install livewire

    npm install
    npm run build
    php artisan migrate

    php artisan serve

    php artisan route:list
        - lists all registered route information

    php artisan make:middleware EnsureTokenIsValid
        - located in app > Http > Middleware


    Middleware Configuration

        To register middleware,
            php artisan make:middleware [MiddlewareName]

        It will be located in app > Http > Middleware.

        To configure middleware for access, go to app > Http > Kernel.php
            'checktoken' => \App\Http\Middleware\CheckToken::class,

        To apply middleware in routes/web.php
                Route::get('/admin', function () {
                    return view('admin');
                }) -> middleware('checktoken');

        http://127.0.0.1:8000/admin?token=my-secret-token


    Controller Configuration
        To register middleware,
            php artisan make:controller [ControllerName]

        It will be located in app > Http > Controllers.

        To apply in routes/web.php,
            Route::get('/contact', [ContactController::class, 'index']);
                where 'index' is the function name from ContactController

            Make sure to include use App\Http\Controllers\ContactController; in routes/web.php
                where you must include the particular controller


    Database Configuration
        To configure database credentials, go to:
            config > database.php
            .env
                DB_CONNECTION=mysql
                DB_HOST=127.0.0.1
                DB_PORT=3306
                DB_DATABASE=webapp
                DB_USERNAME=root
                DB_PASSWORD=
        You can view your credentials (username & password) in C:\xampp\phpMyAdmin\config.inc

        To migrate tables from database > migrations,
            public function up(): void is CREATE
            public function down(): void is DROP

            php artisan migrate

        After migrating, it will migrate all the tables from the database > migrations + another table for the 'migrations' containing all the migration logs.


    Authentication Configuration
        Laravel Breeze, Laravel Jetstream, and Laravel Fortify.
        Make sure to have Node.js installed.

        To install Laravel Jetstream,
            composer require laravel/jetstream
            php artisan jetstream:install livewire

        Afterwards, there are added tables and files.
            views, routes, migrations, app

            php artisan migrate

        To access the profile pictures, change from .env file
            APP_URL=http://localhost --> APP_URL=http://localhost:8000





    MVC - Model View Controller
        Model:          Handle data logic and interactions with database. It interacts with the database.
        View:           What should be shown to the user (HTML / CSS / Blade). User Interface. It contains everything which a user can see on the screen.
        Controller:     Handle requests. It helps to connect Model and View and contains all the business logic. It is also known as the “Heart of the application in MVC”.

    Laravel Tutorial:
        https://www.youtube.com/@yelocode

    Laravel 8, Jetstream, and Livewire
        https://www.youtube.com/playlist?list=PL1JpS8jP1wgC8Uud_DKhL3jAtcPzeQ9pn


    Component Configuration
        To register a component,
            php artisan make:component [ComponentName]










    To use Bootstrap as styling sheet,
        - Go to views/layouts/app.blade.php
            Add the <link> in the <head>
            Add the <script> CDN at the end of the <body>

    Pass data from Model to View
        - $users = User::all();
        - compact('users')

    Change "navbar" in navigation-menu.blade.php
        Change dashboard.blade.php
                Since the Users data have been passed, you can now access it. (READ QUERY)
                    {{-- PHP CODE --}}
                        @php
                            $i = 1;
                        @endphp

                    {{-- BALDE CODE --}}
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$user -> name}}</td>
                                <td>{{$user -> email}}</td>
                                <td>{{$user -> created_at}}</td>
                            </tr>
                        @endforeach

    Add a page for the list of Categories, category.blade.php
        Move it in the created folder, admin/category
                Create a Model named Category
                    php artisan make:model Category -m
                        - autoomatically create migrations (where fiednames need to be edited)

                    Under database/migrations, there will be a new file named "2023_11_08_050014_create_categories_table" which by default is
                        public function up(): void
                        {
                            Schema::create('categories', function (Blueprint $table) {
                                $table->id();
                                $table->timestamps();
                            });
                        }

                    Modify it to contain all the necessary fieldnames for the Category table.
                        public function up(): void
                        {
                            Schema::create('categories', function (Blueprint $table) {
                                $table->id();
                                $table->string('category_name');
                                $table->integer('user_id'); // FK from Users table
                                $table->timestamps();
                                $table->softDeletes(); // Timestamp of when deleted/updated
                            });
                        }

                    In the Category.php Model,
                        // Added (Since we have SoftDeletes initialized in the table)
                        use SoftDeletes;

                        // To indicate what fieldname/s is/are fillable
                        protected $fillable = [
                            "category_name",
                            "user_id"
                        ];

                Create a CategoryController and implement it in routes/web.php
                    Named routing
                        Route::get('/category', [CategoryController::class, 'index'])->name('AllCat');
                    Implement named routing
                        href="{{route('AllCat')}}"

                In the CategoryController, you pass the Category details and open the newly created page, category.blade.php (READ QUERY)
                    public function index() {
                        $categories = Category::all();
                        return view('admin.category.category', compact('categories'));
                    }

    Now that we can read the Users and Categories, we can now moved in the INSERT/CREATE queries.
        <form action="submit" method="POST">
            // The @csrf directive will insert the CSRF token into your form, which is required for Laravel to validate the request.
            @csrf
            <div class="mb-3 container">
                <label for="inputCategory" class="col-form-label">Category Name</label>
                <div class="mb-3">
                <input type="text" class="form-control" name="inputCategory" required>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </div>
        </form>

            - The POST request will be sent to the URL, /submit (action attribute)
            - In the Category.php Model, add the following
                    // Table Name
                    protected $table = 'categories';
            - Referring to Eloquent ORM (Object-Relational Mapping), https://laravel.com/docs/10.x/eloquent#inserts,
                    Create a route for the "/submit" to be processed which will be using
                        public function store(Request $request): RedirectResponse
                        {
                            // Validate the request...

                            $flight = new Flight;

                            $flight->name = $request->name;

                            $flight->save();

                            return redirect('/flights');
                        }

            - In the CategoryController, modify according to the context which will be:
                    public function store(Request $request): RedirectResponse
                    {
                        $category = new Category; // The model created

                        $category->category_name = $request->input('inputCategory');
                            // $category->category_name is accessing the fieldname, category_name
                            // $request->input('inputCategory') is accessing the input value of the input with a name attribute of 'inputCategory'

                        if (Auth::check()) {
                            // $userId contains the user_id of the currently authenticated user
                            $userId = Auth::user()->id;
                            $category->user_id = $userId;
                        }

                        else {
                            // The user is not authenticated
                        }

                        $category->save();  // Posts the new record

                        return redirect('/category');
                            // Redirect to the original category.blade.php using the defined route, Route::get('/category', [CategoryController::class, 'index'])->name('AllCat');
                    }










    To show the total number of Users registered,
        Go to dashboard.blade.php,
            <b style="float:right">
                Total Users: <span class="badge text-bg-danger">{{count($users)}}</span>
            </b>
                    where:
                        - $users is the passed value using the following code in routing:
                            $users = User::all();   // Added
                            return view('dashboard', compact('users'));

    To access username or any field registered under User table
            Welcome to {{ __('Category') }}, {{Auth::user()->name}}

    To have pagination,
        In CategoryController, replace "::all()" with "latest()->paginate('5')"
            $categories = Category::latest()->paginate('5');
                    where:
                        '5' is the number of entry per page
                        latest() is a filter function that put the latest record to the top

        Below the end tag of </table> of category.blade.php, insert
            {{$categories->links()}}

    To display the timestamp of created_at, updated_at, and deleted_at in readily available for humans.
            {{$category->created_at->diffForHumans()}}
                    where:
                        - diffForHumans() is the built-in method to convert timestamp to "[50] [minutes] ago"


    Given the code:
        <form action="{{ route('AddCat') }}" method="POST">
            @csrf
            <div class="mb-3 container">
                <label for="inputCategory" class="col-form-label">Category Name</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="category_name" required>
                    @error('category_name')
                        <span class="text-danger">{{message}}</span>
                    @enderror
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </div>
        </form>

        New approach to Create/Insert Statement
            Form Action  --->  Route::post('/category/add', [CategoryController::class, 'AddCategory'])->name('AddCat');

            AddCategory  --->  CategoryController
                public function AddCategory(Request $request)
                {
                    $validated = $request->validate([
                        'category_name' => 'required|unique:categories|max:10',
                        ]);

                        Category::insert([
                            'category_name' => $request->category_name,
                            'user_id' => Auth::user()->id,
                            'created_at' => Carbon::now()
                        ]);

                    return Redirect()->back()->with('success','Add Category Successful');
                }

                where:
                    = $validated is the validation of the user inputs
                    = validation is separated by vertical slash |
                    = 'required'          for required
                    = 'unique:tableName'  for unique to the table name
                    = 'max:10'            for maximum number of characters
                    = 'Category::insert' or 'Category::create'
                    = 'Carbon::now()' is to return the current time [now()] with a Carbon instance [Carbon::]
                    = Redirect()->back() simply moves to the previous page
                    = ->with('success','Add Category Successful') accesses the Session for alert messages.
                            = Format: with(sessionVariable, message)

    Create a new view for the Edit/Update Form.
        Add a routing on the Update <a> of every record.
                <a href="{{ url('/category/edit/'.$category->id) }}" class="btn btn-primary btn-md mx-2">Update</a>

        Create a new route for the new view.
                Route::get('/category/edit/{id}', [CategoryController::class, 'EditCategory']);

        Create the necessary method in CategoryController
                public function EditCategory($id) {
                    $categories = Category::find($id);
                    return view('admin.category.edit', compact('categories'));
                }

        Given the code:
            <form action="{{ url('/category/update/'.$categories->id) }}" method="POST">
                @csrf
                <div class="mb-3 container">
                    <label for="inputCategory" class="col-form-label">Category Name</label>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="category_name" value="{{ $categories->category_name }}" required>
                        @error('category_name')
                            <span class="text-danger">{{message}}</span>
                        @enderror
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </div>
            </form>

        Create a new route for the saving of updated data.
                Route::post('/category/update/{id}', [CategoryController::class, 'UpdateCategory']);

        Create the necessary method in CategoryController
                public function UpdateCategory(Request $request, $id)
                {
                    $update = Category::find($id)->update([
                        'category_name' => $request->category_name,
                    ]);

                    return Redirect()->route('AllCat')->with('success','Category Updated Successful');
                        where:
                            - route('AllCat') refers to the 'named' route to display all categories.
                }

        In Category model,
                public function user() {
                    return $this->hasOne(User::class, 'id', 'user_id');
                }

    For the Delete Query
        Create a new route for the delete query.
                Route::post('/category/delete/{id}', [CategoryController::class, 'DeleteCategory'])->name('DeleteCat');

        Create the necessary method in CategoryController
                public function DeleteCategory(Request $request, $id)
                {
                    $deleted = Category::destroy($id);
                    return Redirect()->back()->with('success','Category Deleted Successful');
                }

        Use Modal (for Confirmation Box)
                <a class="btn btn-danger btn-md mx-2" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">Delete</a>
                        where:
                            - data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" opens the Modal with the id="deleteConfirmationModal"

                Put the Modal inside the foreach loop.
                    <!-- Modal -->
                    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    Are you sure you want to delete this category?
                                    <input type="text" class="form-control" id="recordId" name="deleteId" hidden>
                                </div>

                                <div class="modal-footer">
                                    <form action="{{ route('DeleteCat', $category->id) }}" method="POST">
                                    @csrf
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>


    For JavaScript functions, insert the following at the end of the blade.php file.
        @section('script')
            <script>
                ...
            </script>
        @endsection

    To delete all the records from the database at once,
            php artisan migrate:refresh











    insert

*/
