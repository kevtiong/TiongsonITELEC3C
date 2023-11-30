<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="column">
                <div class="row">
                    <div class="col-md-8">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session(success)}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="card">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">User Id</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp

                                    @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">{{$categories->firstItem()+$loop->index}}</th>
                                        <td>{{$category->category_name}}</td>
                                        <td>{{$category->user_id}}</td>
                                        <td>{{$category->created_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{url('category/edit/'.$category->id)}}" class="btn btn-info">Edit</a>
                                            <a href="" class="btn bn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$categories->links()}}
                        </div>
                    </div>

                    <div class=" col-md-4">
                        <div class="card">
                            <form action="{{route('add.category')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name">

                                    <!-- <label for="category_name" class="form-label">User ID</label>
                                    <input type="text" class="form-control" name="user_id"> -->

                                    

                                    @error('category_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>