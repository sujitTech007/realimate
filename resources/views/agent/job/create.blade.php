@extends('agent.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Add Job') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Job Management') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Add Job') }}
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">{{ __('Add Job') }}</div>
                </div>

                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-lg-10 offset-lg-1">
                            <div class="alert alert-danger pb-1 dis-none" id="jobErrors">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <ul></ul>
                            </div>
                            

                            <form id="jobForm"
                                action=" {{ $agent->id != 0 ? route('agent.job_management.store_job') : route('agent.admin.job_management.store_job') }} "
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    {{-- Property --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="property_id">{{ __('Property*') }}</label>
                                            <select name="property_id" id="property_id" class="form-control" required>
                                                <option value="">{{ __('Select Property') }}</option>
                                                    @foreach($properties as $property)
                                                    <option value="{{ $property->id }}">
                                                        @php
                                                            $property_content = $property->getContent($language->id);
                                                            if (is_null($property_content)) {
                                                                $property_content = $property
                                                                    ->propertyContents()
                                                                    ->first();
                                                            }
                                                        @endphp
                                                        {{ strlen(@$property_content->title) > 100 ? mb_substr(@$property_content->title, 0, 100, 'utf-8') . '...' : @$property_content->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Title --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="title">{{ __('Job Title*') }}</label>
                                            <input type="text" name="title" id="title" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>

                                    {{-- Location --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="location">{{ __('Location') }}</label>
                                            <input type="text" name="location" id="location" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Amount --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="salary">{{ __('Amount') }}</label>
                                            <input type="number" step="0.01" name="salary" id="salary" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status">{{ __('Status*') }}</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="open">{{ __('Open') }}</option>
                                                <option value="closed">{{ __('Closed') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Start Date --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="start_date">{{ __('Start Date') }}</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control">
                                        </div>
                                    </div>

                                    {{-- End Date --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="end_date">{{ __('End Date') }}</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <input type="hidden" name="agent_id" value="{{ Auth::guard('agent')->user()->id }}">

                                    {{-- Submit --}}
                                    {{--<div class="col-lg-12">
                                        <div class="form-group text-right mt-3">
                                            <button type="submit" class="btn btn-primary">{{ __('Save Job') }}</button>
                                        </div>
                                    </div>--}}
                                </div>

                                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-left">
                            <button type="submit" id="JobSubmit" class="btn btn-success">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </div>
                            </form>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
@endsection

@php
    $languages = App\Models\Language::get();
    $labels = '';
    $values = '';
    foreach ($languages as $language) {
        $label_name = $language->code . '_label[]';
        $value_name = $language->code . '_value[]';
        if ($language->direction == 1) {
            $direction = 'form-group rtl text-right';
        } else {
            $direction = 'form-group';
        }

        $labels .=
            "<div class='$direction'><input type='text' name='" .
            $label_name .
            "' class='form-control' placeholder='Label ($language->name)'></div>";
        $values .= "<div class='$direction'><input type='text' name='$value_name' class='form-control' placeholder='Value ($language->name)'></div>";
    }
@endphp
