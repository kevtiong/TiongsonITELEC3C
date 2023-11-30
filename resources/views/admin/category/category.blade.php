<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            Welcome to Categories

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{--
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
            --}}

            <div class="container ">

                <div class="row my-5">
                <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('AddCat') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 container">
                                        <label for="inputCategory" class="col-form-label">Category Name</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="category_name" required>
                                            @error('category_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <label for="inputCategory" class="col-form-label">Category Icon</label>
                                        <div class="mb-3">
                                            <input type="file" class="form-control" name="category_icon" id="category_icon">
                                            @error('category_icon')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary" id="addBtn">Add Category</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                
                    <div class="col">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissable fade show" role="alert">
                                {{session('success')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card">
    <div class="card-header">
        All Categories
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped">
        
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Category Icon</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- BLADE CODE --}}
                @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{$category->category_name}}</td>
                    <td>
                        <img src="{{ asset('storage/category_images/' . $category->category_icon) }}" class="img-fluid" alt="{{$category->category_name}}" style="width: 50px; height: auto;">
                    </td>
                    <td>{{$category->user_id}}</td>
                    <td>{{$category->created_at->diffForHumans()}}</td>
                    <td>
                        <div class = "d-flex align-items-center"> 
                            <a href="{{ url('/category/edit/'.$category->id) }}" class="btn btn-primary btn-sm">Update</a>
                                <form action="{{ route('DeleteCat', $category->id) }}" method="POST">
                                @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Archive</button>
                                </form>                    
                            </td>
                        </div>
                       
                </tr>
                <!-- Modal here -->
                @endforeach
            </tbody>
        </table>
        {{$categories->links()}}
    </div>
</div>


                        <div class="card my-3">
                            <div class="card-body table-responsive">
                                <table class="table table-hover">
                                    <thead class="align-middle">
                                        <tr>
                                            <th class="pb-3" colspan="6">Archive</th>
                                        </tr>

                                      <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Category Icon</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>

                                    <tbody class="table-group-divider align-middle">

                                        {{-- BLADE CODE --}}
                                        @foreach ($trashCat as $trash)

                                        <tr>
                                            <th scope="row">{{$trash->id}}</th>
                                            <td>{{$trash->category_name}}</td>
                                            <td>
                                                <img src="{{ asset('storage/category_images/' . $trash->category_icon) }}" class="d-block w-10" alt="{{$trash->category_name}}">
                                            </td>
                                            <td>{{$trash->user_id}}</td>
                                            <td>{{$trash->created_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="{{ route('RestoreCat', $trash->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{$trash->id}}">Delete</button>
                                                </div>
                                            </td>
                                        </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteConfirmationModal{{$trash->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$trash->id}}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$trash->id}}">Confirm Delete?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            Are you sure you want to delete this category?
                                                        </div>

                                                        <div class="modal-footer">
                                                            <form action="{{ route('PermaDeleteCat', $trash->id) }}" method="POST">
                                                            @csrf
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </tbody>

                                    <tfoot>

                                    </tfoot>

                                </table>
                                {{$categories->links()}}

                            </div>
                        </div>
                    </div>

                    

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

