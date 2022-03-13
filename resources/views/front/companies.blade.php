@extends('layouts.header')

@section('title', 'Companies Featured')

@section('content')
    <!-- CSS FOR COMPANIES-->
    <link rel="stylesheet" href="{{ asset('resources/css/content-page/front/companies-page.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/custom/stars.css') }}">

    <div class="container company-container">
        <h3 class="company-page-title" style="color: #444444">Featured Companies</h3>
        <h1 class="company-red-line"></h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="company">Filter via Company Name:</label>
                                <select class="form-control" id="company" onchange="location = this.value;">
                                    <option hidden></option>
                                    <option {{ $sortn == 'asc' ? 'selected' : '' }}
                                        value="{{ url('/companies/name/asc') }}">Ascending</option>
                                    <option {{ $sortn == 'desc' ? 'selected' : '' }}
                                        value="{{ url('/companies/name/desc') }}">Descending</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="average">Filter via Average:</label>
                                <select class="form-control" id="average" onchange="location = this.value;">
                                    <option hidden></option>
                                    <option {{ $sortr == 'asc' ? 'selected' : '' }}
                                        value="{{ url('/companies/rating/highest') }}">Highest to Lowest</option>
                                    <option {{ $sortr == 'desc' ? 'selected' : '' }}
                                        value="{{ url('/companies/rating/lowest') }}">Lowest to Highest</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($companies as $company)
                <div class="col-sm-6" data-aos="zoom-in">
                    <div class="card company-contents">
                        <div class="company-header">
                            <label class="company-name">
                                @if (!is_null($company->employer))
                                    {{ $company->employer->company }}
                                @else
                                    {{ $company->firstName }}
                                @endif
                            </label>
                            @if ($company->rolesId == 3)
                                <h1 class="company-classification">
                                    Organization
                                </h1>
                            @endif
                        </div>

                        <div class="card-body company-body">
                            @if (!$company->documents->isEmpty())
                                @php
                                    $x = 0;
                                @endphp

                                @foreach ($company->documents as $file)
                                    @if ($file->filetype === 'profile')
                                        @php
                                            $x = 1;
                                        @endphp

                                        <img src="{{ URL::to('/') }}/{{ $file->path }}{{ $file->filename }}"
                                            class="company-logo img-fluid">
                                    @endif
                                @endforeach

                                @if ($x < 1)
                                    <img src="{{ URL::to('/') }}/images/company.png" class="company-logo img-fluid">
                                @endif
                            @else
                                <img src="{{ URL::to('/') }}/images/company.png" class="company-logo img-fluid">
                            @endif

                            <div class="row company-row">
                                <div class="col-sm-6">
                                    <label>
                                        @if (isset($ratings[$company->id]))
                                            {{ number_format($ratings[$company->id]->average, 2, '.', '') }}
                                        @endif
                                    </label>
                                    <div class='overall-ratings'>
                                        <h1 class="company-label">Overall rating</h1>
                                        <ul style="text-align:center">
                                            <li class='star @if (isset($ratings[$company->id])) @if ($ratings[$company->id]->average <= 5 && $ratings[$company->id]->average !== 0)
							selected @endif @endif'
                                                title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>

                                            <li class='star @if (isset($ratings[$company->id])) @if ($ratings[$company->id]->average <= 5 && $ratings[$company->id]->average >= 2)
							selected @endif @endif'
                                                title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>

                                            <li class='star @if (isset($ratings[$company->id])) @if ($ratings[$company->id]->average <= 5 && $ratings[$company->id]->average >= 3)
							selected @endif @endif'
                                                title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>

                                            <li class='star @if (isset($ratings[$company->id])) @if ($ratings[$company->id]->average <= 5 && $ratings[$company->id]->average >= 4)
							selected @endif @endif'
                                                title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>

                                            <li class='star @if (isset($ratings[$company->id])) @if ($ratings[$company->id]->average <= 5 && $ratings[$company->id]->average >= 5)
							selected @endif @endif'
                                                title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <h1 class="company-label-category">Ratings by category</h1>
                                    <div class="company-forms">
                                        <div class='overall-ratings'>
                                            <ul>
                                                <li class='star selected' title='Poor' data-value='1'>
                                                    @if (isset($ratings[$company->id]))
                                                        {{ number_format($ratings[$company->id]->fees, 0, '.', '') }}
                                                    @endif
                                                    <i class='fa fa-star fa-fw'></i> Salary
                                                </li>
                                            </ul>
                                        </div>

                                        <div class='overall-ratings'>
                                            <ul>
                                                <li class='star selected' title='Poor' data-value='1'>
                                                    @if (isset($ratings[$company->id]))
                                                        {{ number_format($ratings[$company->id]->environment, 0, '.', '') }}
                                                    @endif
                                                    <i class='fa fa-star fa-fw'></i> Work Environment
                                                </li>
                                            </ul>
                                        </div>

                                        <div class='overall-ratings'>
                                            <ul>
                                                <li class='star selected' title='Poor' data-value='1'>
                                                    @if (isset($ratings[$company->id]))
                                                        {{ number_format($ratings[$company->id]->career_growth, 0, '.', '') }}
                                                    @endif
                                                    <i class='fa fa-star fa-fw'></i> Career Growth Development
                                                </li>
                                            </ul>
                                        </div>

                                        <div class='overall-ratings'>
                                            <ul>
                                                <li class='star selected' title='Poor' data-value='1'>
                                                    @if (isset($ratings[$company->id]))
                                                        {{ number_format($ratings[$company->id]->security, 0, '.', '') }}
                                                    @endif
                                                    <i class='fa fa-star fa-fw'></i> Job Security
                                                </li>
                                            </ul>
                                        </div>

                                        <div class='overall-ratings'>
                                            <ul>
                                                <li class='star selected' title='Poor' data-value='1'>
                                                    @if (isset($ratings[$company->id]))
                                                        {{ number_format($ratings[$company->id]->relation, 0, '.', '') }}
                                                    @endif
                                                    <i class='fa fa-star fa-fw'></i> Employee's Relation
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="company-footer">
                                <button class="btn btn-chinese view_button company-button"
                                    href="{{ url('company/' . Crypt::encrypt($company->id)) }}">View Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-2">
            {{ $companies->appends(request()->except('page'))->onEachSide(1)->links() }}
        </div>
    </div>






    <script>
        $(".view_button").click(function() {
            var href = $(this).attr("href");

            window.location.href = href;
        });
    </script>
@endsection
