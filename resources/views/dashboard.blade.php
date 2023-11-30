<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}

            <b style="float:right">
                Total Users: <span class="badge text-bg-danger">{{count($users)}}</span>
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{--
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
            --}}

            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <caption>List of Users</caption>

                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>

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

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
