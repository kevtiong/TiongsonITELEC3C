<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome to Edit Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="container">
                <div class="row">

                    <div class="col">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissable fade show" role="alert">
                                {{session('success')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body table-responsive">

                                <form action="{{ url('/category/update/'.$categories->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 container">
                                        <label for="inputCategory" class="col-form-label">Category Name</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="category_name" value="{{ $categories->category_name }}" required onchange="enableUpdate()">
                                            @error('category_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <label for="inputCategory" class="col-form-label">Category Icon</label>
                                        <img src="{{ asset('storage/category_images/' . $categories->category_icon) }}" class="d-block w-20 mb-3" alt="{{$categories->category_name}}">

                                        <div class="d-flex align-items-center mb-3">
                                            <input type="file" class="form-control" name="category_icon" id="category_icon" onchange="enableUpdateFront(this)"style="width: 108px;">

                                            <input type="text" class="form-control text-center fst-italic" name="category_icon_display" id="category_icon_display" aria-label="Username" aria-describedby="addon-wrapping" value="{{ $categories->category_icon }}" readonly style="width: 50%;"/>

                                            {{-- <img src="{{ asset('storage/product_images/' . $categories->category_icon) }}"> --}}

                                            @error('category_icon')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary" id="updateBtn" disabled>Update Category</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
