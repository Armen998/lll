
@extends('Admin.layout')

@section('content')

<section style="background-color: rgb(243, 245, 230);">
    <ul class="nav nav-tabs nav-fill mb-3 position " id="ex1" role="tablist">
        <!--  position-fixed d-flex  -->
        <li class="nav-item" role="presentation">
            <a class="nav-link active" style="background-color: rgb(243, 245, 240);" id="ex2-tab-1" data-mdb-toggle="tab" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">
                <i class=" fa-solid fa-house-chimney" style="font-size:40px; color:rgb(73 80 87)"></i>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex2-tab-3" data-mdb-toggle="tab" href="{{ route('admin.posts') }} " role="tab" aria-controls="ex2-tabs-3" aria-selected="false">
                <i class="fa-regular fa-newspaper" style="font-size:40px; color:rgb(73 80 87)"></i>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex2-tab-2" data-mdb-toggle="tab" href="{{ route('admin.users') }} " role="tab" aria-controls="ex2-tabs-2" aria-selected="false">
                <i class="fa fa-users" aria-hidden="true" style="font-size:40px; color:rgb(73 80 87)"></i>
            </a>
        </li>
    </ul>
      <div class="container my-10 py-10">
        <div class="row d-flex justify-content-center">
            <div class="card" style="background-color: rgb(243, 245, 235);">
                <div class="card-body">
                    <div>
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Total Users: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> {{ $regularUsers->count() }} </span>
                        </div>
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Total Inactive Categories: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> {{ $inactiveCategories->count() }} </span>
                        </div>
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Total Active Categories: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> {{ $activeCategories->count() }} </span>
                        </div>
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Total Inactive Posts: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> {{ $inactivePosts->count() }} </span>
                        </div>
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Total Active Posts: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> {{ $activePosts->count() }} </span>
                        </div>
                        @if ($posts->count() === 0 || $regularUsers->count() === 0)
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Avarage post per User: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> 0 </span>
                        </div>
                        @else
                        <div class="d-flex">
                            <p class=" text-info font-italic h3" style="width:250px, font-weight: 900;letter-spacing: 2px;"> Avarage post per User: </p> <span class="ml-2 font-italic h4" style="margin-top: 5px;"> {{ $posts->count()/$regularUsers->count() }} </span>
                        </div   -
                        @endif 
                    </div>
                </div>
            </div>
        </div>  
    </div>  
</section>
@endsection





    